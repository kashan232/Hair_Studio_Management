<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingApprovedPaymentRequired;

class BookingController extends Controller
{
    public function index()
    {
        // Auto-cancel past bookings that were left in pending_approval
        Booking::where('status', 'pending_approval')
            ->whereDate('start_datetime', '<', today())
            ->update(['status' => 'cancelled_late_response']);

        // Eager-load relations; limit payload for admin table performance
        $bookings = Booking::query()
            ->with([
                'user:id,name,email',
                'chairs:id,name',
            ])
            ->orderByDesc('id')
            ->limit(500)
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,confirmed,cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        
        if ($request->status === 'pending_payment') {
            $booking->expires_at = now()->addMinutes(15);
        } elseif ($request->status === 'cancelled' || $request->status === 'confirmed') {
            $booking->expires_at = null;
        }

        $booking->save();

        // If approved (pending_payment), we ideally send an email to user to pay.
        $message = 'Booking status updated successfully.';
        if ($request->status === 'pending_payment') {
            $message = 'Booking approved. Stylist can now pay.';
            try {
                $emailToSend = $booking->user ? $booking->user->email : $booking->guest_email;
                if ($emailToSend) {
                    Mail::to($emailToSend)->send(new BookingApprovedPaymentRequired($booking));
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send booking approval email: ' . $e->getMessage());
            }
        } elseif ($request->status === 'cancelled') {
            $message = 'Booking rejected and cancelled.';
        }

        return redirect()->route('bookings.index')->with('success', $message);
    }

    // Public payment page for stylists to pay for an approved booking
    public function payBalance($id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if ($booking->status !== 'pending_payment') {
            return redirect()->route('stylist.book')->with('booking_error', 'This booking cannot be paid right now.');
        }

        if ($booking->expires_at && $booking->expires_at < now()) {
            $booking->status = 'cancelled';
            $booking->save();
            return redirect()->route('stylist.book')->with('booking_error', 'Your booking reservation has expired due to timeout. Please try booking again.');
        }

        return view('stylist.pay_balance', compact('booking'));
    }

    public function processBalancePayment(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending_payment') {
            return response()->json(['error' => 'Invalid booking status'], 400);
        }

        $finalAmount = $booking->total_amount;
        $discountAmount = 0;

        if ($request->has('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->is_active && $coupon->expires_at->gte(\Carbon\Carbon::today())) {
                $hasUsed = $coupon->users()->where('user_id', $booking->user_id)->exists();
                if (!$hasUsed) {
                    if ($coupon->discount_type === 'fixed') {
                        $discountAmount = (float) $coupon->discount_value;
                    } else {
                        $discountAmount = $finalAmount * ((float) $coupon->discount_value / 100);
                    }
                    if ($discountAmount > $finalAmount) $discountAmount = $finalAmount;
                    $finalAmount -= $discountAmount;
                    
                    session(['pay_balance_coupon' => $coupon->code, 'pay_balance_discount' => $discountAmount]);
                }
            }
        } else {
            session()->forget('pay_balance_coupon');
            session()->forget('pay_balance_discount');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $intent = \Stripe\PaymentIntent::create([
            'amount'   => (int) round($finalAmount * 100),
            'currency' => 'gbp',
            'metadata' => [
                'booking_id' => $booking->id,
            ],
        ]);

        $booking->stripe_payment_intent = $intent->id;
        $booking->save();

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function balancePaymentSuccess($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';

        if (session()->has('pay_balance_coupon')) {
            $couponCode = session('pay_balance_coupon');
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $booking->coupon_code = $couponCode;
                $booking->discount_amount = session('pay_balance_discount');
                if ($booking->user_id) {
                    $coupon->users()->attach($booking->user_id, [
                        'used_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                $coupon->is_active = false;
                $coupon->save();
            }
            session()->forget('pay_balance_coupon');
            session()->forget('pay_balance_discount');
        }

        $booking->save();

        return view('stylist.pay_balance_success', compact('booking'));
    }
}
