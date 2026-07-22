<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingCancellationService;
use Carbon\Carbon;
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

    /**
     * Full booking + payment/card details for admin refund.
     */
    public function show($id, BookingCancellationService $cancellation)
    {
        $user = request()->user();
        if (!$user || !$user->canManageChairBookings()) {
            abort(403, 'You do not have permission to view booking refunds.');
        }

        $booking = Booking::with(['user', 'chairs'])->findOrFail($id);
        $payment = $cancellation->paymentDetails($booking);

        $canRefund = (float) $booking->total_amount > 0
            && !empty($booking->stripe_payment_intent)
            && !($booking->refunded_at || $booking->refund_status === 'succeeded')
            && in_array($booking->status, ['confirmed', 'cancelled', 'pending_payment'], true);

        return view('admin.bookings.show', compact('booking', 'payment', 'canRefund'));
    }

    /**
     * Refund the charged amount back to the customer's original card, then cancel if still active.
     */
    public function adminRefund(Request $request, $id, BookingCancellationService $cancellation)
    {
        $user = $request->user();
        if (!$user || !$user->canManageChairBookings()) {
            abort(403, 'You do not have permission to refund bookings.');
        }

        $booking = Booking::with(['user', 'chairs'])->findOrFail($id);

        if ($booking->refunded_at || $booking->refund_status === 'succeeded') {
            return redirect()
                ->route('bookings.show', $booking->id)
                ->with('error', 'This booking has already been refunded.');
        }

        if ((float) $booking->total_amount <= 0 || empty($booking->stripe_payment_intent)) {
            return redirect()
                ->route('bookings.show', $booking->id)
                ->with('error', 'No paid Stripe charge found to refund for this booking.');
        }

        $refund = $cancellation->refundPayment($booking);

        if (!($refund['refunded'] ?? false)) {
            return redirect()
                ->route('bookings.show', $booking->id)
                ->with('error', 'Refund failed. ' . ($refund['message'] ?? 'Please try again or check Stripe.'));
        }

        // Free the chair if booking is still active
        if (!in_array($booking->status, ['cancelled', 'cancelled_late_response'], true)) {
            $cancellation->cancel($booking->fresh(), false);
        }

        return redirect()
            ->route('bookings.show', $booking->id)
            ->with(
                'success',
                'Refund of £' . number_format((float) $refund['amount'], 2)
                . ' sent back to the customer’s original card. Booking #' . $booking->id . ' is cancelled.'
            );
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

    /**
     * Admin / receptionist cancel (manage-chairs or manage-bookings).
     * Always allowed for active bookings; refund when paid + 24h+ before start.
     */
    public function adminCancel(Request $request, $id, BookingCancellationService $cancellation)
    {
        $user = $request->user();
        if (!$user || !$user->canManageChairBookings()) {
            abort(403, 'You do not have permission to cancel bookings.');
        }

        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['cancelled', 'cancelled_late_response'], true)) {
            return back()->with('error', 'Booking #' . $booking->id . ' is already cancelled.');
        }

        $wasConfirmed = $booking->status === 'confirmed';
        $paidAmount = (float) $booking->total_amount;
        $eligibleForRefund = $wasConfirmed
            && $paidAmount > 0
            && Carbon::parse($booking->start_datetime)->gt(now()->addHours(24));

        $refund = $cancellation->cancel($booking, $eligibleForRefund);

        if ($eligibleForRefund && ($refund['refunded'] ?? false)) {
            return back()->with(
                'success',
                'Booking #' . $booking->id . ' cancelled. Refund of £' . number_format((float) $refund['amount'], 2) . ' started.'
            );
        }

        if ($eligibleForRefund && !($refund['refunded'] ?? false)) {
            return back()->with(
                'error',
                'Booking #' . $booking->id . ' cancelled, but refund failed. ' . ($refund['message'] ?? '')
            );
        }

        $note = $wasConfirmed && $paidAmount > 0
            ? ' Cancelled within 24h of start — no automatic refund (policy).'
            : '';

        return back()->with('success', 'Booking #' . $booking->id . ' cancelled.' . $note);
    }

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
            $email = $booking->guest_email ?: $booking->user?->email;
            if ($coupon && $coupon->isValidNow() && !$coupon->hasBeenUsedBy($booking->user, $email)) {
                $discountAmount = $coupon->calculateDiscount((float) $finalAmount);
                session(['pay_balance_coupon' => $coupon->code, 'pay_balance_discount' => $discountAmount]);
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
                $coupon->recordUsage(
                    $booking->user,
                    $booking->guest_email ?: $booking->user?->email
                );
            }
            session()->forget('pay_balance_coupon');
            session()->forget('pay_balance_discount');
        }

        $booking->save();

        try {
            $emailToSend = $booking->guest_email ?: $booking->user?->email;
            if ($emailToSend) {
                \Illuminate\Support\Facades\Mail::to($emailToSend)
                    ->send(new \App\Mail\BookingConfirmed($booking->fresh(['user', 'chairs'])));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send booking confirmation after balance payment: ' . $e->getMessage());
        }

        return view('stylist.pay_balance_success', compact('booking'));
    }
}
