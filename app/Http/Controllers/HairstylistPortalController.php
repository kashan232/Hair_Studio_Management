<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\Booking;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use App\Services\BookingCancellationService;

class HairstylistPortalController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('stylist.book');
    }

    /* ─────────────────────────────────────────────
     |  NEW BOOKING WIZARD
     |  Step 1: Date, Start Time & Duration
     |  Step 2: Availability Check (Alternative Time / Multi-chair Approval)
     |  Step 3: Details
     |  Step 4: Payment (or Pending Approval)
     |  Step 5: Confirmed
     ───────────────────────────────────────────── */
    public function booking(Request $request): View|RedirectResponse
    {
        $step = max(1, min(5, (int) $request->query('step', 1)));
        $type = $request->query('type');
        $user = $request->user();

        // If they navigate to the base route without a type, assume they want to start a new booking
        if ($step == 1 && !$type) {
            // clear any old stuck booking session
            session()->forget('stylist_booking');

            $minHourly = Chair::whereNotNull('price_hourly')->min('price_hourly');
            $minDaily = Chair::whereNotNull('price_daily')->min('price_daily');

            return view('stylist.booking_filter', compact('minHourly', 'minDaily'));
        }

        // Save type to session if provided, otherwise retrieve it
        if ($type) {
            session(['stylist_booking.type' => $type]);
        } else {
            $type = session('stylist_booking.type', 'hourly');
        }

        // Ensure we don't skip required steps
        if ($step > 1 && !session('stylist_booking.start_date')) {
            return redirect()->route('stylist.book', ['step' => 1, 'type' => $type]);
        }

        if ($step === 4 && $this->isAdminBookingSession() && !session('stylist_booking.completed')) {
            return $this->processAdminBooking($request);
        }

        $steps = [
            1 => ['label' => 'Schedule', 'title' => 'Select Date & Duration'],
            2 => ['label' => 'Options',  'title' => 'Review Availability'],
            3 => ['label' => 'Details',  'title' => 'Your Details'],
            4 => ['label' => 'Payment',  'title' => 'Secure Payment'],
            5 => ['label' => 'Done',     'title' => 'Booking Confirmed!'],
        ];

        $availabilityState = session('stylist_booking.availability_state');
        $guestDetails = session('stylist_booking.guest', []);
        
        $rawTotal = $this->calculateTotal();
        $computedTotal = $rawTotal;
        $packageHoursUsed = 0;
        $duration = session('stylist_booking.duration', 0);
        $amendPricing = $this->resolveAmendPricing($user);

        if ($amendPricing) {
            $rawTotal = $amendPricing['raw_total'];
            $computedTotal = $amendPricing['amount_due'];
            $packageHoursUsed = $amendPricing['package_hours_used'];
        } elseif ($user && $duration > 0 && $type !== 'daily') {
            $packageBalance = $user->package_balance;
            if ($packageBalance > 0) {
                $packageHoursUsed = min($packageBalance, $duration);
                $remainingDuration = $duration - $packageHoursUsed;
                $unitPrice = $computedTotal / $duration;
                $computedTotal = round($unitPrice * $remainingDuration, 2);
            }
        }

        $isOvernight = $this->isOvernightBooking();

        $pricingChair = $this->resolveBookingChair();
        [$pricingRate, $pricingRateLabel] = $this->rateForChair($pricingChair, $type);

        // If assigned/preview chair has no rate, prefer first free chair that does
        if ($pricingRate === null && !empty($availabilityState['available_chair_ids'] ?? [])) {
            foreach ($availabilityState['available_chair_ids'] as $candidateId) {
                $candidate = Chair::find($candidateId);
                [$candidateRate, $candidateLabel] = $this->rateForChair($candidate, $type);
                if ($candidateRate !== null) {
                    $pricingChair = $candidate;
                    $pricingRate = $candidateRate;
                    $pricingRateLabel = $candidateLabel;
                    if ($step === 2 && empty(session('stylist_booking.assigned_chair_ids'))) {
                        session(['stylist_booking.assigned_chair_ids' => [$candidate->id]]);
                        if (is_array($availabilityState)) {
                            $availabilityState['chair_id'] = $candidate->id;
                            session(['stylist_booking.availability_state' => $availabilityState]);
                        }
                    }
                    break;
                }
            }
            // Recompute totals after switching to a priced chair
            $rawTotal = $this->calculateTotal();
            $computedTotal = $rawTotal;
            $packageHoursUsed = 0;
            $amendPricing = $this->resolveAmendPricing($user);
            if ($amendPricing) {
                $rawTotal = $amendPricing['raw_total'];
                $computedTotal = $amendPricing['amount_due'];
                $packageHoursUsed = $amendPricing['package_hours_used'];
            } elseif ($user && $duration > 0 && $type !== 'daily') {
                $packageBalance = $user->package_balance;
                if ($packageBalance > 0) {
                    $packageHoursUsed = min($packageBalance, $duration);
                    $remainingDuration = $duration - $packageHoursUsed;
                    $unitPrice = $duration > 0 ? ($rawTotal / $duration) : 0;
                    $computedTotal = round($unitPrice * $remainingDuration, 2);
                }
            }
        }

        $chairPricingMap = $this->buildChairPricingMap(
            $availabilityState['available_chair_ids']
                ?? session('stylist_booking.assigned_chair_ids', [])
                ?? [],
            $type,
            (float) session('stylist_booking.duration', 0),
            is_array($availabilityState) ? $availabilityState : null
        );

        $availableIds = $availabilityState['available_chair_ids'] ?? [];

        return view('stylist.booking', compact(
            'step', 'user', 'steps', 'guestDetails', 'computedTotal', 'isOvernight',
            'availabilityState', 'packageHoursUsed', 'rawTotal', 'type',
            'pricingChair', 'pricingRate', 'pricingRateLabel', 'chairPricingMap', 'availableIds',
            'amendPricing'
        ));
    }

    public function selectTime(Request $request): RedirectResponse
    {
        $type = session('stylist_booking.type', 'hourly');

        if ($type === 'daily') {
            $request->validate([
                'start_date' => ['required', 'date', 'after_or_equal:today'],
            ]);
            
            $start = Carbon::parse($request->input('start_date'), 'Europe/London')->setTime(8, 0, 0);
            $durationHours = 13; // Daily booking represents 8am to 9pm
            $end = Carbon::parse($request->input('start_date'), 'Europe/London')->setTime(21, 0, 0);
        } else {
            $request->validate([
                'start_date' => ['required', 'date', 'after_or_equal:today'],
                'start_time' => ['required'],
                'duration'   => ['required', 'integer', 'min:2'], // Minimum 2 hours
            ]);

            $start = Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'), 'Europe/London');
            $durationHours = (int) $request->input('duration');
            $end = $start->copy()->addHours($durationHours);
        }

        if ($start->lt(Carbon::now('Europe/London'))) {
            return back()->withErrors(['start_time' => 'You cannot book a time in the past.']);
        }

        session([
            'stylist_booking.start_date' => $start->format('Y-m-d'),
            'stylist_booking.start_time' => $start->format('H:i'),
            'stylist_booking.end_date'   => $end->format('Y-m-d'),
            'stylist_booking.end_time'   => $end->format('H:i'),
            'stylist_booking.duration'   => $durationHours,
            'stylist_booking.setup_type' => $request->input('setup_type', 'hair'),
        ]);

        // RUN AVAILABILITY ENGINE
        $availability = $this->checkAvailability($start, $end, $durationHours);

        session(['stylist_booking.availability_state' => $availability]);

        if ($availability['status'] === 'single_chair') {
            session(['stylist_booking.assigned_chair_ids' => [$availability['chair_id']]]);
        }

        // Always go to step 2 to show SVG map for selection / preview
        return redirect()->route('stylist.book', ['step' => 2]);
    }

    public function confirmAvailability(Request $request): RedirectResponse
    {
        $action = $request->input('action');
        $availability = session('stylist_booking.availability_state');

        if ($action === 'accept_single_chair') {
            $selectedChair = $request->input('selected_chair_id');
            if ($selectedChair) {
                session(['stylist_booking.assigned_chair_ids' => [$selectedChair]]);
            }
            return redirect()->route('stylist.book', ['step' => 3]);
        }

        if ($action === 'accept_alternative') {
            $newStart = Carbon::parse($availability['alternative_start']);
            $duration = session('stylist_booking.duration');
            $newEnd = $newStart->copy()->addHours($duration);

            session([
                'stylist_booking.start_date' => $newStart->format('Y-m-d'),
                'stylist_booking.start_time' => $newStart->format('H:i'),
                'stylist_booking.end_date'   => $newEnd->format('Y-m-d'),
                'stylist_booking.end_time'   => $newEnd->format('H:i'),
            ]);

            // Re-run availability to assign the single chair found at alternative time
            $newAvailability = $this->checkAvailability($newStart, $newEnd, $duration);
            session(['stylist_booking.assigned_chair_ids' => [$newAvailability['chair_id']]]);
            return redirect()->route('stylist.book', ['step' => 3]);

        } elseif ($action === 'accept_multi_chair') {
            // User agreed to switch chairs
            session(['stylist_booking.assigned_chair_ids' => $availability['chair_ids']]);
            return redirect()->route('stylist.book', ['step' => 3]);
        }

        // Cancel
        return redirect()->route('stylist.book', ['step' => 1]);
    }

    public function confirmDetails(Request $request): RedirectResponse
    {
        $isGuest = $request->boolean('is_guest');
        $isAdminBooking = $request->user()?->canBookOnBehalfOfCustomer()
            && $request->boolean('admin_booking_for_customer');

        $rules = [
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'mobile' => ['required', 'digits_between:11,12'],
        ];

        $messages = [
            'mobile.required' => 'invalid number, please re enter',
            'mobile.digits_between' => 'invalid number, please re enter',
        ];

        if (!$isGuest && !$isAdminBooking) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
            if ($request->user()) {
                $rules['email'][]  = 'unique:users,email,' . $request->user()->id;
                $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
            } else {
                $rules['email'][] = 'unique:users,email';
            }
        }

        $validated = $request->validate($rules, $messages);

        session([
            'stylist_booking.guest' => [
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'mobile'   => $validated['mobile'] ?? null,
                'password' => $validated['password'] ?? null,
                'is_guest' => $isGuest,
                'is_admin_booking' => $isAdminBooking,
            ],
            'stylist_booking.consent_photography' => $request->boolean('consent_photography'),
        ]);

        if ($isAdminBooking) {
            $this->syncAdminBookingTotals($validated['email']);

            if ($this->isOvernightBooking()) {
                return $this->processPendingApproval($request);
            }

            return $this->processAdminBooking($request);
        }

        $isOvernight = $this->isOvernightBooking();
        if ($isOvernight) {
            // Need Admin Approval - create booking immediately as pending_approval, skip Stripe
            return $this->processPendingApproval($request);
        }

        return redirect()->route('stylist.book', ['step' => 4]);
    }

    public function createPaymentIntent(Request $request): JsonResponse
    {
        if (!session('stylist_booking.start_date')) {
            return response()->json(['error' => 'Session expired. Please restart.'], 400);
        }

        $rawTotal = $this->calculateTotal();
        $total = $rawTotal;
        $duration = session('stylist_booking.duration', 0);
        $bookingType = session('stylist_booking.type', 'hourly');
        $packageHoursUsed = 0;
        $bookingTotal = null;

        $user = $request->user();
        if (!$user) {
            $guestEmail = session('stylist_booking.guest.email');
            if ($guestEmail) {
                $user = \App\Models\User::where('email', $guestEmail)->first();
            }
        }

        $amendPricing = $this->resolveAmendPricing($user);
        if ($amendPricing) {
            $total = $amendPricing['amount_due'];
            $packageHoursUsed = $amendPricing['package_hours_used'];
            $bookingTotal = $amendPricing['booking_total'];
        } elseif ($user && $duration > 0 && $bookingType !== 'daily') {
            $packageBalance = $user->package_balance;
            if ($packageBalance > 0) {
                $packageHoursUsed = min($packageBalance, $duration);
                $remainingDuration = $duration - $packageHoursUsed;
                $unitPrice = $total / $duration;
                $total = round($unitPrice * $remainingDuration, 2);
            }
        }

        if ($total < 0) $total = 0;

        $discount = 0;
        $couponCode = null;
        $guestEmail = session('stylist_booking.guest.email') ?: $user?->email;

        if ($request->has('coupon_code') && $total > 0) {
            $code = strtoupper(trim($request->coupon_code));
            $coupon = \App\Models\Coupon::where('code', $code)->first();
            if ($coupon && $coupon->isValidNow() && !$coupon->hasBeenUsedBy($user, $guestEmail)) {
                $discount = $coupon->calculateDiscount($total);
                $total = $total - $discount;
                $couponCode = $code;
            }
        }

        $storedBookingTotal = $total;
        if ($amendPricing) {
            $storedBookingTotal = round($amendPricing['old_total'] + $total, 2);
        }

        session([
            'stylist_booking.coupon_code' => $couponCode,
            'stylist_booking.discount' => $discount,
            'stylist_booking.final_total' => $storedBookingTotal,
            'stylist_booking.amount_due' => $total,
            'stylist_booking.package_hours_used' => $packageHoursUsed
        ]);

        if ($total <= 0) {
            return response()->json(['clientSecret' => null, 'finalTotal' => 0, 'is_free' => true]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount'   => (int) round($total * 100),
            'currency' => 'gbp',
            'metadata' => [
                'start_date' => session('stylist_booking.start_date'),
                'end_date'   => session('stylist_booking.end_date'),
                'coupon'     => $couponCode
            ],
        ]);

        session(['stylist_booking.payment_intent_id' => $intent->id]);

        return response()->json(['clientSecret' => $intent->client_secret, 'finalTotal' => $total, 'is_free' => false]);
    }

    private function verifyChairsAreFree(): bool
    {
        $start = Carbon::parse(session('stylist_booking.start_date') . ' ' . session('stylist_booking.start_time'));
        $end = Carbon::parse(session('stylist_booking.end_date') . ' ' . session('stylist_booking.end_time'));
        $assignedChairs = session('stylist_booking.assigned_chair_ids', []);
        
        if (empty($assignedChairs)) return false;

        $durationPerChair = ceil(session('stylist_booking.duration') / count($assignedChairs));
        $currentStart = $start->copy();

        foreach ($assignedChairs as $chairId) {
            $currentEnd = $currentStart->copy()->addHours($durationPerChair);
            if ($currentEnd->gt($end)) $currentEnd = $end->copy();

            $conflict = \Illuminate\Support\Facades\DB::table('booking_chairs')
                ->join('bookings', 'booking_chairs.booking_id', '=', 'bookings.id')
                ->where('booking_chairs.chair_id', $chairId)
                ->whereIn('bookings.status', ['confirmed', 'pending_approval'])
                ->when(session('stylist_booking.amend_booking_id'), function ($q) {
                    $q->where('bookings.id', '!=', session('stylist_booking.amend_booking_id'));
                })
                ->where(function ($query) use ($currentStart, $currentEnd) {
                    $query->where('booking_chairs.start_time', '<', $currentEnd)
                          ->where('booking_chairs.end_time', '>', $currentStart);
                })
                ->exists();

            if ($conflict) return false;
            
            $currentStart = $currentEnd->copy();
        }
        
        return true;
    }

    public function paymentSuccess(Request $request): RedirectResponse
    {
        if ($this->isAdminBookingSession()) {
            return $this->processAdminBooking($request);
        }

        if (session('stylist_booking.completed')) {
            return redirect()->route('stylist.book', ['step' => 5]);
        }

        if (!session('stylist_booking.start_date')) {
            return redirect()->route('stylist.book', ['step' => 1]);
        }

        if (!$this->verifyChairsAreFree()) {
            return redirect()->route('stylist.book', ['step' => 1])
                ->with('error', 'Sorry, the selected chairs are no longer available. They might have just been booked. Your payment was not processed or will be refunded.');
        }

        $user = $this->getOrCreateUser($request);
        
        $this->createBookingRecord($user, 'confirmed');
        session(['stylist_booking.completed' => true]);

        return redirect()->route('stylist.book', ['step' => 5])
            ->with('booking_success', 'Payment successful! Your workspace is confirmed.');
    }

    private function processPendingApproval(Request $request): RedirectResponse
    {
        if (session('stylist_booking.completed')) {
            return redirect()->route('stylist.book', ['step' => 5]);
        }

        if (!$this->verifyChairsAreFree()) {
            return redirect()->route('stylist.book', ['step' => 1])
                ->with('error', 'Sorry, the selected chairs are no longer available. You may have already submitted this booking or it was booked by someone else.');
        }

        $user = $this->getOrCreateUser($request);
        $this->createBookingRecord($user, 'pending_approval');
        session(['stylist_booking.completed' => true]);

        return redirect()->route('stylist.book', ['step' => 5])
            ->with('booking_success', 'Booking submitted. Pending Admin Approval for overnight hours.');
    }

    private function processAdminBooking(Request $request): RedirectResponse
    {
        if (session('stylist_booking.completed')) {
            return redirect()->route('stylist.book', ['step' => 5]);
        }

        if (!session('stylist_booking.start_date')) {
            return redirect()->route('stylist.book', ['step' => 1]);
        }

        if (!$this->verifyChairsAreFree()) {
            return redirect()->route('stylist.book', ['step' => 1])
                ->with('error', 'Sorry, the selected chairs are no longer available. They might have just been booked.');
        }

        $user = $this->getOrCreateUser($request);
        $this->createBookingRecord($user, 'confirmed');
        session(['stylist_booking.completed' => true]);

        return redirect()->route('stylist.book', ['step' => 5])
            ->with('booking_success', 'Booking confirmed for customer.');
    }

    private function isAdminBookingSession(): bool
    {
        return !empty(session('stylist_booking.guest.is_admin_booking'));
    }

    private function syncAdminBookingTotals(string $customerEmail): void
    {
        $rawTotal = $this->calculateTotal();
        $total = $rawTotal;
        $packageHoursUsed = 0;
        $duration = session('stylist_booking.duration', 0);
        $type = session('stylist_booking.type', 'hourly');
        $customer = User::where('email', $customerEmail)->first();

        if ($customer && $duration > 0 && $type !== 'daily') {
            $packageBalance = $customer->package_balance;
            if ($packageBalance > 0) {
                $packageHoursUsed = min($packageBalance, $duration);
                $remainingDuration = $duration - $packageHoursUsed;
                $unitPrice = $total / $duration;
                $total = round($unitPrice * $remainingDuration, 2);
            }
        }

        session([
            'stylist_booking.final_total' => max($total, 0),
            'stylist_booking.package_hours_used' => $packageHoursUsed,
        ]);
    }

    private function createBookingRecord($user, $status)
    {
        $start = Carbon::parse(session('stylist_booking.start_date') . ' ' . session('stylist_booking.start_time'));
        $end = Carbon::parse(session('stylist_booking.end_date') . ' ' . session('stylist_booking.end_time'));
        $guestDetails = session('stylist_booking.guest', []);
        $packageHoursUsed = session('stylist_booking.package_hours_used', 0);
        $amendPricing = $this->resolveAmendPricing($user);

        // Amendment: cancel previous booking without refund so paid value carries over.
        $amendId = session('stylist_booking.amend_booking_id');
        if ($amendId && $user) {
            $oldBooking = Booking::where('id', $amendId)->where('user_id', $user->id)->first();
            if ($oldBooking && !in_array($oldBooking->status, ['cancelled', 'cancelled_late_response'], true)) {
                app(BookingCancellationService::class)->cancel($oldBooking, false);
            }
            session()->forget('stylist_booking.amend_booking_id');
        }

        $totalAmount = session('stylist_booking.final_total', $this->calculateTotal());
        $paymentIntentId = session('stylist_booking.payment_intent_id');
        if ($amendPricing) {
            $totalAmount = $amendPricing['booking_total'];
            if ($amendPricing['amount_due'] <= 0 && !empty($amendPricing['original_payment_intent'])) {
                $paymentIntentId = $amendPricing['original_payment_intent'];
            }
        }

        $booking = Booking::create([
            'user_id' => $user ? $user->id : null,
            'guest_name' => $user ? null : ($guestDetails['name'] ?? null),
            'guest_email' => $user ? null : ($guestDetails['email'] ?? null),
            'guest_phone' => $user ? null : ($guestDetails['mobile'] ?? null),
            'start_datetime' => $start,
            'end_datetime' => $end,
            'duration_hours' => session('stylist_booking.duration'),
            'package_hours_used' => $packageHoursUsed,
            'total_amount' => $totalAmount,
            'stripe_payment_intent' => $paymentIntentId,
            'coupon_code' => session('stylist_booking.coupon_code'),
            'discount_amount' => session('stylist_booking.discount', 0),
            'status' => $status,
            'setup_type' => session('stylist_booking.setup_type', 'hair'),
            'consent_photography' => session('stylist_booking.consent_photography', false),
            'expires_at' => $status === 'pending_payment' ? now()->addMinutes(15) : null,
        ]);

        if ($user && $packageHoursUsed > 0 && in_array($status, ['confirmed', 'pending_approval'])) {
            $hoursToDeduct = $packageHoursUsed;
            $activePackages = $user->userPackages()
                ->where('status', 'active')
                ->where('hours_remaining', '>', 0)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->orderBy('created_at', 'asc')
                ->get();
            foreach ($activePackages as $up) {
                if ($hoursToDeduct <= 0) break;
                
                if ($up->hours_remaining >= $hoursToDeduct) {
                    $up->hours_remaining -= $hoursToDeduct;
                    $hoursToDeduct = 0;
                } else {
                    $hoursToDeduct -= $up->hours_remaining;
                    $up->hours_remaining = 0;
                }
                
                if ($up->hours_remaining == 0) {
                    $up->status = 'exhausted';
                }
                $up->save();
            }
        }

        // Attach coupon if used (standard = 1 per email; reusable = unlimited)
        $couponCode = session('stylist_booking.coupon_code');
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $redeemEmail = strtolower(trim((string) (
                    session('stylist_booking.guest.email')
                    ?: $user?->email
                    ?: $booking->guest_email
                )));
                $coupon->recordUsage($user, $redeemEmail);
            }
        }

        $assignedChairs = session('stylist_booking.assigned_chair_ids', []);
        if (!is_array($assignedChairs)) {
            $assignedChairs = [];
        }

        if (!empty($assignedChairs)) {
            // Split time across assigned chairs
            $durationPerChair = ceil(session('stylist_booking.duration') / count($assignedChairs));
            $currentStart = $start->copy();

            foreach ($assignedChairs as $chairId) {
                $currentEnd = $currentStart->copy()->addHours($durationPerChair);
                if ($currentEnd->gt($end)) $currentEnd = $end->copy();

                $booking->chairs()->attach($chairId, [
                    'start_time' => $currentStart,
                    'end_time' => $currentEnd,
                ]);

                $currentStart = $currentEnd->copy();
            }
        }

        session(['stylist_booking.final_booking_id' => $booking->id]);

        $this->sendBookingConfirmationEmail($booking, $user, session('stylist_booking.guest', []));
    }

    private function sendBookingConfirmationEmail(Booking $booking, $user = null, array $guestDetails = []): void
    {
        try {
            $booking->loadMissing(['user', 'chairs']);

            $emailToSend = strtolower(trim((string) (
                ($guestDetails['email'] ?? null)
                ?: $booking->guest_email
                ?: $user?->email
                ?: $booking->user?->email
            )));

            if ($emailToSend === '') {
                \Illuminate\Support\Facades\Log::warning('Booking confirmation skipped: no recipient email', [
                    'booking_id' => $booking->id,
                ]);
                return;
            }

            Mail::to($emailToSend)
                ->bcc(config('mail.from.address', 'eladebookings@gmail.com'))
                ->send(new BookingConfirmed($booking));
        } catch (\Throwable $e) {
            // Retry without BCC if the provider rejects the combined message
            try {
                Mail::to($emailToSend)->send(new BookingConfirmed($booking));
            } catch (\Throwable $retryError) {
                \Illuminate\Support\Facades\Log::error('Failed to send booking confirmation email: ' . $retryError->getMessage(), [
                    'booking_id' => $booking->id,
                    'first_error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function getOrCreateUser(Request $request)
    {
        $guestDetails = session('stylist_booking.guest', []);
        
        if (!empty($guestDetails['is_guest'])) {
            return null;
        }

        if ($request->user()) {
            if ($request->user()->canBookOnBehalfOfCustomer() && !empty($guestDetails['is_admin_booking'])) {
                $existing = User::where('email', $guestDetails['email'])->first();
                if ($existing) {
                    return $existing;
                }

                $hairstylistRole = Role::where('slug', 'hairstylist')->firstOrFail();
                return User::create([
                    'name'        => $guestDetails['name'],
                    'email'       => $guestDetails['email'],
                    'mobile'      => $guestDetails['mobile'] ?? null,
                    'password'    => Hash::make('password123'),
                    'role_id'     => $hairstylistRole->id,
                    'role'        => 'hairstylist',
                    'designation' => 'Hairstylist',
                    'joining_date'=> date('Y-m-d'),
                    'status'      => 1,
                    'avatar'      => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
                ]);
            }

            $update = [
                'name'   => $guestDetails['name']   ?? $request->user()->name,
                'mobile' => $guestDetails['mobile'] ?? $request->user()->mobile,
            ];
            if (!empty($guestDetails['password'])) {
                $update['password'] = Hash::make($guestDetails['password']);
            }
            $request->user()->update($update);
            return $request->user();
        }

        $existing = User::where('email', $guestDetails['email'])->first();
        if ($existing) {
            Auth::login($existing);
            return $existing;
        }

        $hairstylistRole = Role::where('slug', 'hairstylist')->firstOrFail();
        $user = User::create([
            'name'        => $guestDetails['name'],
            'email'       => $guestDetails['email'],
            'mobile'      => $guestDetails['mobile'] ?? null,
            'password'    => Hash::make($guestDetails['password']),
            'role_id'     => $hairstylistRole->id,
            'role'        => 'hairstylist',
            'designation' => 'Hairstylist',
            'joining_date'=> date('Y-m-d'),
            'status'      => 1,
            'avatar'      => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
        ]);
        Auth::login($user);
        return $user;
    }

    public function clearBooking(): RedirectResponse
    {
        session()->forget('stylist_booking');
        return redirect()->route('stylist.book');
    }

    public function myBookings(Request $request): View
    {
        // Auto-cancel past bookings that were left in pending_approval
        Booking::where('status', 'pending_approval')
            ->whereDate('start_datetime', '<', today())
            ->update(['status' => 'cancelled_late_response']);

        $user = $request->user();
        $bookings = Booking::where('user_id', $user->id)
            ->with('chairs')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stylist.my_bookings', compact('bookings', 'user'));
    }

    public function cancelBooking(Request $request, $id): RedirectResponse
    {
        $user = $request->user();
        $booking = Booking::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        if (!$this->bookingCanBeCancelled($booking)) {
            return back()->with('error', $this->bookingCancelBlockReason($booking));
        }

        $wasConfirmed = $booking->status === 'confirmed';
        $paidAmount = (float) $booking->total_amount;
        $eligibleForRefund = $wasConfirmed
            && $paidAmount > 0
            && Carbon::parse($booking->start_datetime)->gt(now()->addHours(24));

        $refund = app(BookingCancellationService::class)->cancel($booking, $eligibleForRefund);

        if ($eligibleForRefund && ($refund['refunded'] ?? false)) {
            return back()->with(
                'success',
                'Booking #' . $booking->id . ' cancelled. A full refund of £' . number_format((float) $refund['amount'], 2)
                . ' has been started to your original payment method (per our Booking & Cancellation Policy).'
            );
        }

        if ($eligibleForRefund && !($refund['refunded'] ?? false)) {
            $detail = $refund['message'] ?? 'Please contact the studio if you need help with your refund.';
            return back()->with(
                'error',
                'Booking #' . $booking->id . ' was cancelled, but the automatic refund could not be completed. ' . $detail
            );
        }

        return back()->with('success', 'Booking #' . $booking->id . ' cancelled successfully.');
    }

    public function amendBooking(Request $request, $id): RedirectResponse
    {
        $user = $request->user();
        $booking = Booking::where('id', $id)->where('user_id', $user->id)->with('chairs')->firstOrFail();

        if (!$this->bookingCanBeAmended($booking)) {
            return redirect()
                ->route('stylist.my_bookings')
                ->with('error', $this->bookingCancelBlockReason($booking) ?: 'This booking cannot be amended.');
        }

        session()->forget('stylist_booking');

        $duration = (int) $booking->duration_hours;
        $type = ($duration >= 12) ? 'daily' : 'hourly';

        session([
            'stylist_booking.amend_booking_id' => $booking->id,
            'stylist_booking.type' => $type,
            'stylist_booking.setup_type' => $booking->setup_type ?: 'hair',
            'stylist_booking.guest' => [
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
            ],
        ]);

        return redirect()
            ->route('stylist.book', ['step' => 1, 'type' => $type])
            ->with('booking_success', 'Amending Booking #' . $booking->id . '. Choose a new date & time — your old booking will be replaced when you confirm.');
    }

    /**
     * Pending payment / approval: always cancellable.
     * Confirmed: only if start is more than 24 hours away (studio policy).
     */
    private function bookingCanBeCancelled(Booking $booking): bool
    {
        if (in_array($booking->status, ['pending_payment', 'pending_approval'], true)) {
            return true;
        }

        if ($booking->status === 'confirmed') {
            return Carbon::parse($booking->start_datetime)->gt(now()->addHours(24));
        }

        return false;
    }

    private function bookingCanBeAmended(Booking $booking): bool
    {
        // Same window as cancel for upcoming bookings
        return $this->bookingCanBeCancelled($booking)
            && Carbon::parse($booking->start_datetime)->isFuture();
    }

    private function bookingCancelBlockReason(Booking $booking): string
    {
        if (in_array($booking->status, ['cancelled', 'cancelled_late_response'], true)) {
            return 'This booking is already cancelled.';
        }

        if ($booking->status === 'confirmed' && Carbon::parse($booking->start_datetime)->lte(now()->addHours(24))) {
            return 'Confirmed bookings can only be cancelled or amended more than 24 hours before start time.';
        }

        if (Carbon::parse($booking->start_datetime)->isPast()) {
            return 'Past bookings cannot be cancelled or amended.';
        }

        return 'This booking cannot be cancelled.';
    }

    /* ─────────────────────────────────────────────
     |  HELPERS
     ───────────────────────────────────────────── */

    private function checkAvailability(Carbon $start, Carbon $end, int $durationHours): array
    {
        $setupType = session('stylist_booking.setup_type', 'hair');
        $query = Chair::where('status', '!=', 'maintenance');
        if ($setupType === 'makeup') {
            $query->whereNotIn('id', [4, 5]);
        }
        $allChairs = $query->get();
        if ($allChairs->isEmpty()) return ['status' => 'unavailable'];

        $now = now();
        $amendBookingId = session('stylist_booking.amend_booking_id');

        $overlappingBookings = DB::table('booking_chairs')
            ->join('bookings', 'booking_chairs.booking_id', '=', 'bookings.id')
            ->where(function($query) use ($now) {
                $query->where('bookings.status', 'confirmed')
                      ->orWhere('bookings.status', 'pending_approval')
                      ->orWhere(function($q) use ($now) {
                          $q->where('bookings.status', 'pending_payment')
                            ->where('bookings.expires_at', '>', $now);
                      });
            })
            ->when($amendBookingId, function ($q) use ($amendBookingId) {
                $q->where('bookings.id', '!=', $amendBookingId);
            })
            ->where('booking_chairs.start_time', '<', $end)
            ->where('booking_chairs.end_time', '>', $start)
            ->get(['booking_chairs.*']);

        $busyChairIds = $overlappingBookings->pluck('chair_id')->unique()->toArray();

        $freeChairs = $allChairs->whereNotIn('id', $busyChairIds)->values();

        // 1. Single Chair Available — prefer a chair that has pricing for this booking type
        if ($freeChairs->isNotEmpty()) {
            $bookingType = session('stylist_booking.type', 'hourly');
            $pricedFree = $freeChairs->filter(function (Chair $chair) use ($bookingType) {
                [$rate] = $this->rateForChair($chair, $bookingType);
                return $rate !== null;
            })->values();

            $preferred = $pricedFree->isNotEmpty() ? $pricedFree : $freeChairs;

            return [
                'status' => 'single_chair',
                'chair_id' => $preferred->first()->id,
                'available_chair_ids' => $freeChairs->pluck('id')->values()->all(),
            ];
        }

        // 2. Multi-Chair Possible? 
        // Simple heuristic: If we don't have a single chair, let's see if we have ANY free chair for each hour
        $canMultiChair = true;
        $usedChairs = [];
        for ($i = 0; $i < $durationHours; $i++) {
            $hourStart = $start->copy()->addHours($i);
            $hourEnd = $hourStart->copy()->addHour();

            $hourOverlaps = $overlappingBookings->where('start_time', '<', $hourEnd)
                                                ->where('end_time', '>', $hourStart)
                                                ->pluck('chair_id')->toArray();
            
            $availableForHour = $allChairs->whereNotIn('id', $hourOverlaps)->first();
            if (!$availableForHour) {
                $canMultiChair = false;
                break;
            }
            $usedChairs[] = $availableForHour->id;
        }

        if ($canMultiChair) {
            return [
                'status' => 'multi_chair',
                'chair_ids' => array_unique($usedChairs),
                'schedule' => $usedChairs // Store array of chair IDs per hour for visual mapping
            ];
        }

        // 3. Find Nearest Available Slot
        $nextSlot = $start->copy();
        while (true) {
            $nextSlot->addMinutes(30);
            $nextEnd = $nextSlot->copy()->addHours($durationHours);

            $futureOverlaps = DB::table('booking_chairs')
                ->join('bookings', 'booking_chairs.booking_id', '=', 'bookings.id')
                ->whereIn('bookings.status', ['confirmed', 'pending_approval'])
                ->when($amendBookingId, function ($q) use ($amendBookingId) {
                    $q->where('bookings.id', '!=', $amendBookingId);
                })
                ->where('booking_chairs.start_time', '<', $nextEnd)
                ->where('booking_chairs.end_time', '>', $nextSlot)
                ->pluck('booking_chairs.chair_id')->toArray();

            $futureFree = $allChairs->whereNotIn('id', $futureOverlaps);
            if ($futureFree->isNotEmpty()) {
                return [
                    'status' => 'alternative_time',
                    'alternative_start' => $nextSlot->format('Y-m-d H:i'),
                    'chair_id' => $futureFree->first()->id
                ];
            }
            
            // Safety break to prevent infinite loop (search up to 7 days ahead)
            if ($nextSlot->diffInDays($start) > 7) {
                return ['status' => 'unavailable'];
            }
        }
    }

    private function isOvernightBooking(): bool
    {
        return false; // Night approval rule removed
    }

    public function calculateTotal(): float
    {
        $type = session('stylist_booking.type', 'hourly');
        $duration = (float) session('stylist_booking.duration', 0);
        if ($duration <= 0 && $type !== 'daily') {
            return 0.0;
        }

        $chair = $this->resolveBookingChair();
        [$unitPrice] = $this->rateForChair($chair, $type);

        if ($unitPrice === null) {
            // Fallback: first available chair with pricing
            $availability = session('stylist_booking.availability_state', []);
            foreach ($availability['available_chair_ids'] ?? [] as $candidateId) {
                $candidate = Chair::find($candidateId);
                [$candidateRate] = $this->rateForChair($candidate, $type);
                if ($candidateRate !== null) {
                    $unitPrice = $candidateRate;
                    break;
                }
            }
        }

        if ($unitPrice === null) {
            return 0.0;
        }

        if ($type === 'daily') {
            return round($unitPrice, 2);
        }

        return round($unitPrice * max($duration, 1), 2);
    }

    /**
     * Resolve which chair pricing should be used for the current booking.
     */
    private function resolveBookingChair(): ?Chair
    {
        $assignedIds = session('stylist_booking.assigned_chair_ids', []);
        if (!empty($assignedIds)) {
            return Chair::find($assignedIds[0]);
        }

        $availability = session('stylist_booking.availability_state');
        if (!empty($availability['chair_id'])) {
            return Chair::find($availability['chair_id']);
        }
        if (!empty($availability['available_chair_ids'][0])) {
            return Chair::find($availability['available_chair_ids'][0]);
        }
        if (!empty($availability['chair_ids'][0])) {
            return Chair::find($availability['chair_ids'][0]);
        }

        return null;
    }

    /**
     * Unit rate + label from admin /pricing fields on the chair.
     *
     * @return array{0: ?float, 1: ?string}
     */
    private function rateForChair(?Chair $chair, string $type): array
    {
        if (!$chair) {
            return [null, null];
        }

        $rate = null;
        $label = 'hour';

        if ($type === 'daily') {
            $rate = $chair->price_daily;
            $label = 'day';
        } elseif ($type === 'monthly') {
            $rate = $chair->price_monthly;
            $label = 'month';
        } elseif ($type === 'yearly') {
            $rate = $chair->price_yearly;
            $label = 'year';
        } else {
            $rate = $chair->price_hourly;
            $label = 'hour';
        }

        if ($rate === null || $rate === '') {
            return [null, $label];
        }

        return [(float) $rate, $label];
    }

    /**
     * Pricing payload for step-2 chair map (live rate/total updates).
     */
    private function buildChairPricingMap(array $chairIds, string $type, float $duration, ?array $availability = null): array
    {
        $map = [];
        $positions = $this->chairMapPositions();
        $startTime = session('stylist_booking.start_time');
        $endTime = session('stylist_booking.end_time');
        $multiSchedule = ($availability['status'] ?? '') === 'multi_chair'
            ? ($availability['schedule'] ?? [])
            : [];

        foreach (array_unique(array_filter($chairIds)) as $chairId) {
            $chair = Chair::find($chairId);
            if (!$chair) {
                continue;
            }
            [$rate, $label] = $this->rateForChair($chair, $type);
            $total = null;
            if ($rate !== null) {
                $total = $type === 'daily'
                    ? round($rate, 2)
                    : round($rate * max($duration, 1), 2);
            }
            [$startHour, $endHour, $hourLabel] = $this->chairScheduleLabel(
                (int) $chairId,
                $startTime,
                $endTime,
                $multiSchedule
            );
            $pos = $positions[(int) $chairId] ?? ['x' => 0, 'y' => 0];
            $map[(string) $chairId] = [
                'id' => (int) $chair->id,
                'name' => $chair->name,
                'type' => $chair->type,
                'rate' => $rate,
                'label' => $label,
                'total' => $total,
                'startHour' => $startHour,
                'endHour' => $endHour,
                'hourLabel' => $hourLabel,
                'x' => $pos['x'],
                'y' => $pos['y'],
            ];
        }

        return $map;
    }

    private function chairMapPositions(): array
    {
        return [
            1 => ['x' => 365, 'y' => 1019],
            2 => ['x' => 365, 'y' => 1529],
            3 => ['x' => 365, 'y' => 2039],
            4 => ['x' => 1115, 'y' => 1529],
            5 => ['x' => 1115, 'y' => 1988],
            6 => ['x' => 1523, 'y' => 1529],
            7 => ['x' => 1523, 'y' => 1988],
        ];
    }

    private function getAmendOriginalBooking(): ?Booking
    {
        $amendId = session('stylist_booking.amend_booking_id');
        if (!$amendId) {
            return null;
        }

        return Booking::find($amendId);
    }

    private function resolveAmendPricing(?User $user): ?array
    {
        $oldBooking = $this->getAmendOriginalBooking();
        if (!$oldBooking) {
            return null;
        }

        $type = session('stylist_booking.type', 'hourly');
        $newDuration = (float) session('stylist_booking.duration', 0);
        $oldDuration = (float) $oldBooking->duration_hours;
        $oldTotal = (float) $oldBooking->total_amount;
        $oldType = ((int) $oldBooking->duration_hours >= 12) ? 'daily' : 'hourly';
        $rawTotal = $this->calculateTotal();
        $packageBalance = ($user && $type !== 'daily')
            ? (int) $user->package_balance + (int) $oldBooking->package_hours_used
            : 0;

        if (($type === 'daily' || $newDuration >= 12) && $oldType === 'daily') {
            return $this->formatAmendPricing(
                $oldTotal,
                0.0,
                $rawTotal,
                min($packageBalance, (int) $newDuration),
                $oldBooking
            );
        }

        if ($newDuration <= $oldDuration) {
            return $this->formatAmendPricing(
                $oldTotal,
                0.0,
                $rawTotal,
                min($packageBalance, (int) $newDuration),
                $oldBooking
            );
        }

        $extraHours = $newDuration - $oldDuration;
        [$unitPrice] = $this->rateForChair($this->resolveBookingChair(), 'hourly');
        if ($unitPrice === null && $oldDuration > 0) {
            $unitPrice = $oldTotal / $oldDuration;
        }
        $unitPrice = (float) ($unitPrice ?? 0);

        $packageOnExtra = min($packageBalance, (int) $extraHours);
        $billableExtra = max(0, $extraHours - $packageOnExtra);
        $amountDue = round($unitPrice * $billableExtra, 2);
        $bookingTotal = round($oldTotal + $amountDue, 2);

        return $this->formatAmendPricing(
            $bookingTotal,
            $amountDue,
            $rawTotal,
            min($packageBalance, (int) $newDuration),
            $oldBooking
        );
    }

    private function formatAmendPricing(
        float $bookingTotal,
        float $amountDue,
        float $rawTotal,
        int $packageHoursUsed,
        Booking $oldBooking
    ): array {
        return [
            'booking_total' => round($bookingTotal, 2),
            'amount_due' => round(max(0, $amountDue), 2),
            'raw_total' => round($rawTotal, 2),
            'package_hours_used' => max(0, $packageHoursUsed),
            'original_payment_intent' => $oldBooking->stripe_payment_intent,
            'is_amend' => true,
            'old_duration' => (int) $oldBooking->duration_hours,
            'old_total' => round((float) $oldBooking->total_amount, 2),
        ];
    }

    private function chairScheduleLabel(int $chairId, $startTime, $endTime, array $multiSchedule): array
    {
        if (!empty($multiSchedule) && in_array($chairId, $multiSchedule, true)) {
            $hourIndex = array_search($chairId, $multiSchedule);
            $start = \Carbon\Carbon::parse($startTime)->addHours($hourIndex);
            $end = \Carbon\Carbon::parse($startTime)->addHours($hourIndex + 1);
            $hourLabel = $hourIndex === 0
                ? '1st Hour'
                : ($hourIndex === 1 ? '2nd Hour' : 'Hour ' . ($hourIndex + 1));

            return [$start->format('g:i A'), $end->format('g:i A'), $hourLabel];
        }

        return [
            \Carbon\Carbon::parse($startTime)->format('g:i A'),
            \Carbon\Carbon::parse($endTime)->format('g:i A'),
            'Full Duration',
        ];
    }
}
