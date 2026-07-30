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

        $booking = Booking::with(['user', 'chairs'])->findOrFail($id);
        
        $status = $request->status;
        // If admin approves but no payment is needed (fully paid via package)
        if ($status === 'pending_payment' && $booking->total_amount <= 0) {
            $status = 'confirmed';
        }

        $booking->status = $status;

        if ($status === 'pending_payment') {
            $booking->expires_at = now()->addMinutes(30);
        } elseif ($status === 'cancelled' || $status === 'confirmed') {
            $booking->expires_at = null;
        }

        $booking->save();

        $message = 'Booking status updated successfully.';
        $flashType = 'success';

        if ($status === 'pending_payment') {
            $message = 'Booking approved. Stylist can now pay.';
            $emailResult = $this->sendApprovalEmail($booking);

            if (!$emailResult['sent']) {
                $flashType = 'error';
                $message = 'Booking approved, but the approval email could not be sent to the customer. '
                    . ($emailResult['error'] ?: 'Please check mail settings (MAIL_USERNAME / MAIL_PASSWORD) and resend.');
            } else {
                $message = 'Booking approved. Approval email sent to ' . $emailResult['email'] . '.';
            }
        } elseif ($status === 'confirmed' && $request->status === 'pending_payment') {
            $message = 'Booking approved and auto-confirmed (fully covered by package).';
            try {
                $emailToSend = $booking->guest_email ?: $booking->user?->email;
                if ($emailToSend) {
                    \Illuminate\Support\Facades\Mail::to($emailToSend)
                        ->bcc(config('mail.from.address', 'eladebookings@gmail.com'))
                        ->send(new \App\Mail\BookingConfirmed($booking));
                }
            } catch (\Throwable $e) {}
        } elseif ($request->status === 'cancelled') {
            $message = 'Booking rejected and cancelled.';
            try {
                $emailToSend = $booking->guest_email ?: $booking->user?->email;
                if ($emailToSend) {
                    \Illuminate\Support\Facades\Mail::to($emailToSend)
                        ->bcc(config('mail.from.address', 'eladebookings@gmail.com'))
                        ->send(new \App\Mail\BookingRejected($booking));
                    $message .= ' Rejection email sent.';
                }
            } catch (\Throwable $e) {}
        }

        return redirect()->route('bookings.index')->with($flashType, $message);
    }

    /**
     * Notify customer that overnight booking was approved and payment is required.
     *
     * @return array{sent: bool, email: ?string, error: ?string}
     */
    private function sendApprovalEmail(Booking $booking): array
    {
        $booking->loadMissing(['user', 'chairs']);

        $emailToSend = strtolower(trim((string) (
            $booking->user?->email
            ?: $booking->guest_email
        )));

        if ($emailToSend === '') {
            \Illuminate\Support\Facades\Log::warning('Booking approval email skipped: no recipient', [
                'booking_id' => $booking->id,
            ]);

            return ['sent' => false, 'email' => null, 'error' => 'No customer email on this booking.'];
        }

        try {
            Mail::to($emailToSend)->send(new BookingApprovedPaymentRequired($booking));

            return ['sent' => true, 'email' => $emailToSend, 'error' => null];
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send booking approval email: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'email' => $emailToSend,
            ]);

            $hint = str_contains($e->getMessage(), '534') || str_contains($e->getMessage(), '535')
                ? 'Gmail rejected the SMTP login — create a new App Password for eladebookings@gmail.com and update MAIL_PASSWORD in .env.'
                : $e->getMessage();

            return ['sent' => false, 'email' => $emailToSend, 'error' => $hint];
        }
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
        $booking = Booking::with(['user', 'chairs'])->findOrFail($id);

        if ($booking->status !== 'pending_payment') {
            return redirect()->route('stylist.book')->with('booking_error', 'This booking cannot be paid right now.');
        }

        $pricingChair = $booking->chairs->first();
        $pricingRate = null;
        $pricingRateLabel = 'hour';
        if ($pricingChair) {
            if ($booking->duration_hours >= 13 && $pricingChair->price_daily > 0) {
                $pricingRate = $pricingChair->price_daily;
                $pricingRateLabel = 'day';
            } else {
                $pricingRate = $pricingChair->price_hourly;
            }
        }
        
        $packageHoursUsed = $booking->package_hours_used ?? 0;
        $rawTotal = $booking->total_amount;
        $packageDiscount = 0;
        if ($pricingRate && $packageHoursUsed > 0) {
            // Approximating the package discount
            if ($pricingRateLabel === 'day' && $packageHoursUsed >= 13) {
                $packageDiscount = $pricingRate;
            } else {
                $packageDiscount = $pricingRate * $packageHoursUsed;
            }
            $rawTotal += $packageDiscount;
        }

        // Auto-confirm if balance is 0 or less (e.g. package covered it all)
        if ($booking->total_amount <= 0) {
            $booking->status = 'confirmed';
            $booking->expires_at = null;
            $booking->save();
            try {
                $emailToSend = $booking->guest_email ?: $booking->user?->email;
                if ($emailToSend) {
                    \Illuminate\Support\Facades\Mail::to($emailToSend)
                        ->bcc(config('mail.from.address', 'eladebookings@gmail.com'))
                        ->send(new \App\Mail\BookingConfirmed($booking));
                }
            } catch (\Throwable $e) {}
            return redirect()->route('stylist.my_bookings')->with('success', 'Your booking is confirmed (fully covered by package).');
        }

        if ($booking->expires_at && $booking->expires_at < now()) {
            $booking->status = 'cancelled';
            $booking->save();
            return redirect()->route('stylist.book')->with('booking_error', 'Your booking reservation has expired due to timeout. Please try booking again.');
        }

        return view('stylist.pay_balance', compact(
            'booking', 'pricingChair', 'pricingRate', 'pricingRateLabel', 'rawTotal', 'packageHoursUsed', 'packageDiscount'
        ));
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
            if ($coupon && !$coupon->isApplicableTo($booking->type)) {
                $serviceName = $booking->type === 'hourly' ? 'hourly bookings' : 'daily bookings';
                return response()->json(['error' => "This discount code is not valid for {$serviceName}."], 400);
            }
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
