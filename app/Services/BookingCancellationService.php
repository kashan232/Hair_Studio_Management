<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class BookingCancellationService
{
    /**
     * Cancel a booking, optionally issuing a Stripe refund for paid confirmed bookings.
     *
     * @return array{refunded: bool, amount: float, message: ?string}
     */
    public function cancel(Booking $booking, bool $attemptRefund = true): array
    {
        $refundResult = ['refunded' => false, 'amount' => 0.0, 'message' => null];

        if ($attemptRefund && $booking->status === 'confirmed' && (float) $booking->total_amount > 0) {
            $refundResult = $this->refundPayment($booking);
        }

        if ($booking->user_id && (float) $booking->package_hours_used > 0) {
            $hoursToRestore = (float) $booking->package_hours_used;
            $user = User::find($booking->user_id);
            if ($user) {
                $pkg = $user->userPackages()
                    ->whereIn('status', ['active', 'exhausted'])
                    ->orderByDesc('updated_at')
                    ->first();

                if ($pkg) {
                    $pkg->hours_remaining = (float) $pkg->hours_remaining + $hoursToRestore;
                    if ($pkg->hours_remaining > 0 && $pkg->status === 'exhausted') {
                        $pkg->status = 'active';
                    }
                    $pkg->save();
                }
            }
        }

        $booking->status = 'cancelled';
        $booking->expires_at = null;
        $booking->save();

        return $refundResult;
    }

    /**
     * @return array{refunded: bool, amount: float, message: ?string}
     */
    public function refundPayment(Booking $booking): array
    {
        if ($booking->refunded_at || $booking->refund_status === 'succeeded') {
            return [
                'refunded' => true,
                'amount' => (float) ($booking->refunded_amount ?? $booking->total_amount),
                'message' => 'already_refunded',
            ];
        }

        $paymentIntentId = $booking->stripe_payment_intent;
        if (!$paymentIntentId) {
            $booking->refund_status = 'missing_payment';
            $booking->save();

            return [
                'refunded' => false,
                'amount' => 0.0,
                'message' => 'No Stripe payment was found on this booking.',
            ];
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Refund the exact charged amount back to the original card
            $refund = \Stripe\Refund::create([
                'payment_intent' => $paymentIntentId,
                'reason' => 'requested_by_customer',
                'metadata' => [
                    'booking_id' => (string) $booking->id,
                    'policy' => 'admin_refund_to_original_card',
                ],
            ]);

            $amount = isset($refund->amount)
                ? round(((int) $refund->amount) / 100, 2)
                : (float) $booking->total_amount;

            $booking->refund_status = $refund->status ?? 'succeeded';
            $booking->refunded_amount = $amount;
            $booking->refunded_at = now();
            $booking->save();

            return [
                'refunded' => in_array($refund->status, ['succeeded', 'pending'], true),
                'amount' => $amount,
                'message' => null,
            ];
        } catch (\Throwable $e) {
            Log::error('Booking refund failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'payment_intent' => $paymentIntentId,
            ]);

            $booking->refund_status = 'failed';
            $booking->save();

            return [
                'refunded' => false,
                'amount' => 0.0,
                'message' => 'Stripe refund failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Load Stripe payment + card summary for admin refund view.
     *
     * @return array{
     *   available: bool,
     *   error: ?string,
     *   payment_intent_id: ?string,
     *   status: ?string,
     *   amount_charged: ?float,
     *   currency: ?string,
     *   card_brand: ?string,
     *   card_last4: ?string,
     *   card_exp: ?string,
     *   paid_at: ?string
     * }
     */
    public function paymentDetails(Booking $booking): array
    {
        $empty = [
            'available' => false,
            'error' => null,
            'payment_intent_id' => $booking->stripe_payment_intent,
            'status' => null,
            'amount_charged' => null,
            'currency' => 'gbp',
            'card_brand' => null,
            'card_last4' => null,
            'card_exp' => null,
            'paid_at' => null,
        ];

        if (!$booking->stripe_payment_intent) {
            $empty['error'] = 'No Stripe payment is linked to this booking.';
            return $empty;
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $pi = \Stripe\PaymentIntent::retrieve($booking->stripe_payment_intent, [
                'expand' => ['latest_charge', 'payment_method'],
            ]);

            $amountCharged = isset($pi->amount_received) && $pi->amount_received > 0
                ? round($pi->amount_received / 100, 2)
                : (isset($pi->amount) ? round($pi->amount / 100, 2) : (float) $booking->total_amount);

            $cardBrand = null;
            $cardLast4 = null;
            $cardExp = null;
            $paidAt = null;

            $charge = $pi->latest_charge ?? null;
            if (is_string($charge) && $charge !== '') {
                $charge = \Stripe\Charge::retrieve($charge);
            }

            if (is_object($charge)) {
                if (!empty($charge->created)) {
                    $paidAt = \Carbon\Carbon::createFromTimestamp($charge->created)
                        ->timezone(config('app.timezone'))
                        ->format('d M Y, h:i A');
                }
                $card = $charge->payment_method_details->card ?? null;
                if ($card) {
                    $cardBrand = $card->brand ?? null;
                    $cardLast4 = $card->last4 ?? null;
                    if (!empty($card->exp_month) && !empty($card->exp_year)) {
                        $cardExp = str_pad((string) $card->exp_month, 2, '0', STR_PAD_LEFT) . '/' . $card->exp_year;
                    }
                }
            }

            if ((!$cardBrand || !$cardLast4) && isset($pi->payment_method) && is_object($pi->payment_method)) {
                $pmCard = $pi->payment_method->card ?? null;
                if ($pmCard) {
                    $cardBrand = $cardBrand ?: ($pmCard->brand ?? null);
                    $cardLast4 = $cardLast4 ?: ($pmCard->last4 ?? null);
                    if (!$cardExp && !empty($pmCard->exp_month) && !empty($pmCard->exp_year)) {
                        $cardExp = str_pad((string) $pmCard->exp_month, 2, '0', STR_PAD_LEFT) . '/' . $pmCard->exp_year;
                    }
                }
            }

            return [
                'available' => true,
                'error' => null,
                'payment_intent_id' => $pi->id,
                'status' => $pi->status,
                'amount_charged' => $amountCharged,
                'currency' => strtoupper($pi->currency ?? 'gbp'),
                'card_brand' => $cardBrand ? strtoupper($cardBrand) : null,
                'card_last4' => $cardLast4,
                'card_exp' => $cardExp,
                'paid_at' => $paidAt,
            ];
        } catch (\Throwable $e) {
            Log::warning('Unable to load Stripe payment details: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
            ]);
            $empty['error'] = 'Could not load card details from Stripe: ' . $e->getMessage();
            return $empty;
        }
    }
}
