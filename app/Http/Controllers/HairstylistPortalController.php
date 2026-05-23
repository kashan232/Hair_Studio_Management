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
        $user = $request->user();

        // Ensure we don't skip required steps
        if ($step > 1 && !session('stylist_booking.start_date')) {
            return redirect()->route('stylist.book', ['step' => 1]);
        }

        $steps = [
            1 => ['label' => 'Schedule', 'title' => 'Select Date & Duration'],
            2 => ['label' => 'Options',  'title' => 'Review Availability'],
            3 => ['label' => 'Details',  'title' => 'Your Details'],
            4 => ['label' => 'Payment',  'title' => 'Secure Payment'],
            5 => ['label' => 'Done',     'title' => 'Booking Confirmed!'],
        ];

        // Fetch availability state
        $availabilityState = session('stylist_booking.availability_state');
        $guestDetails = session('stylist_booking.guest', []);
        $computedTotal = $this->calculateTotal();
        $isOvernight = $this->isOvernightBooking();

        return view('stylist.booking', compact(
            'step', 'user', 'steps', 'guestDetails', 'computedTotal', 'isOvernight', 'availabilityState'
        ));
    }

    public function selectTime(Request $request): RedirectResponse
    {
        $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required'],
            'duration'   => ['required', 'integer', 'min:2'], // Minimum 2 hours
        ]);

        $start = Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'));
        $durationHours = (int) $request->input('duration');
        $end = $start->copy()->addHours($durationHours);

        session([
            'stylist_booking.start_date' => $start->format('Y-m-d'),
            'stylist_booking.start_time' => $start->format('H:i'),
            'stylist_booking.end_date'   => $end->format('Y-m-d'),
            'stylist_booking.end_time'   => $end->format('H:i'),
            'stylist_booking.duration'   => $durationHours,
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
        $rules = [
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        if ($request->user()) {
            $rules['email'][]    = 'unique:users,email,' . $request->user()->id;
            $rules['password']   = ['nullable', 'string', 'min:6', 'confirmed'];
        } else {
            $rules['email'][] = 'unique:users,email';
        }

        $validated = $request->validate($rules);

        session([
            'stylist_booking.guest' => [
                'name'   => $validated['name'],
                'email'  => $validated['email'],
                'mobile' => $validated['mobile'] ?? null,
                'password' => $validated['password'] ?? null,
            ],
        ]);

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

        $total = $this->calculateTotal();
        if (!$total || $total <= 0) {
            return response()->json(['error' => 'Invalid amount.'], 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount'   => (int) round($total * 100),
            'currency' => 'gbp',
            'metadata' => [
                'start_date' => session('stylist_booking.start_date'),
                'end_date'   => session('stylist_booking.end_date'),
            ],
        ]);

        session(['stylist_booking.payment_intent_id' => $intent->id]);

        return response()->json(['clientSecret' => $intent->client_secret]);
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
                ->where('bookings.status', 'confirmed')
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

    private function createBookingRecord($user, $status)
    {
        $start = Carbon::parse(session('stylist_booking.start_date') . ' ' . session('stylist_booking.start_time'));
        $end = Carbon::parse(session('stylist_booking.end_date') . ' ' . session('stylist_booking.end_time'));

        $booking = Booking::create([
            'user_id' => $user->id,
            'start_datetime' => $start,
            'end_datetime' => $end,
            'duration_hours' => session('stylist_booking.duration'),
            'total_amount' => $this->calculateTotal(),
            'status' => $status,
        ]);

        $assignedChairs = session('stylist_booking.assigned_chair_ids', []);
        
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

        session(['stylist_booking.final_booking_id' => $booking->id]);
    }

    private function getOrCreateUser(Request $request)
    {
        $guestDetails = session('stylist_booking.guest', []);
        
        if ($request->user()) {
            $update = [
                'name'   => $guestDetails['name']   ?? $request->user()->name,
                'email'  => $guestDetails['email']  ?? $request->user()->email,
                'mobile' => $guestDetails['mobile'] ?? null,
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
        $user = $request->user();
        $bookings = Booking::where('user_id', $user->id)
            ->with('chairs')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stylist.my_bookings', compact('bookings', 'user'));
    }

    /* ─────────────────────────────────────────────
     |  HELPERS
     ───────────────────────────────────────────── */

    private function checkAvailability(Carbon $start, Carbon $end, int $durationHours): array
    {
        $allChairs = Chair::where('status', '!=', 'maintenance')->get();
        if ($allChairs->isEmpty()) return ['status' => 'unavailable'];

        // Find bookings that overlap with requested time
        $overlappingBookings = DB::table('booking_chairs')
            ->join('bookings', 'booking_chairs.booking_id', '=', 'bookings.id')
            ->where('bookings.status', 'confirmed')
            ->where('booking_chairs.start_time', '<', $end)
            ->where('booking_chairs.end_time', '>', $start)
            ->get(['booking_chairs.*']);

        $busyChairIds = $overlappingBookings->pluck('chair_id')->unique()->toArray();

        $freeChairs = $allChairs->whereNotIn('id', $busyChairIds);

        // 1. Single Chair Available
        if ($freeChairs->isNotEmpty()) {
            return [
                'status' => 'single_chair',
                'chair_id' => $freeChairs->first()->id,
                'available_chair_ids' => $freeChairs->pluck('id')->toArray()
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
                ->where('bookings.status', 'confirmed')
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
        $startStr = session('stylist_booking.start_time');
        $endStr = session('stylist_booking.end_time');
        if (!$startStr || !$endStr) return false;

        $start = Carbon::parse($startStr);
        $end = Carbon::parse($endStr);
        
        // 9 PM is 21:00. 8 AM is 08:00
        // Any time between 21:00 and 08:00
        $ninePM = Carbon::createFromTime(21, 0, 0);
        $eightAM = Carbon::createFromTime(8, 0, 0);

        if ($start->gte($ninePM) || $start->lt($eightAM) || $end->gt($ninePM) || $end->lte($eightAM)) {
            return true;
        }

        return false;
    }

    public function calculateTotal(): float
    {
        $duration = session('stylist_booking.duration');
        if (!$duration) return 0.0;

        // Base it on the first chair's hourly price or a default
        $chair = Chair::first();
        $unitPrice = $chair ? (float) $chair->price_hourly : 25.00;

        return round($unitPrice * $duration, 2);
    }
}
