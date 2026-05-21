<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HairstylistPortalController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('stylist.book');
    }

    public function booking(Request $request): View|RedirectResponse
    {
        $step = max(1, min(4, (int) $request->query('step', 1)));
        $user = $request->user();
        $selectedPricing = session('stylist_booking.pricing_type');
        $selectedPricingOption = null;
        $assignedChair = null;

        // Use first available chair for pricing options (all chairs identical)
        $pricingSourceChair = Chair::where('status', 'available')->first();
        // Store the chair ID in session so later steps (selectPricing) can access it
        if ($pricingSourceChair) {
            session(['stylist_booking.chair_id' => $pricingSourceChair->id]);
        }
        $pricingOptions = $pricingSourceChair ? $this->pricingOptionsForChair($pricingSourceChair) : [];

        // Steps order: 1 Pricing, 2 Time, 3 Confirm, 4 Summary
        $steps = [
            1 => ['label' => 'Pricing', 'title' => 'Select your pricing plan'],
            2 => ['label' => 'Time', 'title' => 'Pick date & time'],
            3 => ['label' => 'Confirm', 'title' => 'Your details & confirm'],
            4 => ['label' => 'Summary', 'title' => 'Booking summary'],
        ];

        // Retrieve assigned chair after payment, if any
        $assignedChairId = session('stylist_booking.assigned_chair_id');
        if ($assignedChairId) {
            $assignedChair = Chair::find($assignedChairId);
        }

        // If a pricing type is already selected, fetch its details
        if ($selectedPricing) {
            $selectedPricingOption = collect($pricingOptions)->firstWhere('key', $selectedPricing);
        }

        $guestDetails = session('stylist_booking.guest', []);

        return view('stylist.booking', compact(
            'step',
            'user',
            'pricingOptions',
            'selectedPricing',
            'selectedPricingOption',
            'steps',
            'guestDetails',
            'assignedChair'
        ));
    }

    public function selectChair(Request $request): RedirectResponse
    {
        $request->validate([
            'chair_id' => 'required|exists:chairs,id',
        ]);

        $chair = Chair::findOrFail($request->input('chair_id'));

        if ($chair->status !== 'available') {
            return redirect()
                ->route('stylist.book', ['step' => 1])
                ->with('booking_error', 'This chair is not available. Please choose another.');
        }

        session([
            'stylist_booking.chair_id' => $request->input('chair_id'),
        ]);
        session()->forget([
            'stylist_booking.pricing_type',
            'stylist_booking.pricing_label',
            'stylist_booking.pricing_amount',
        ]);

        return redirect()->route('stylist.book', ['step' => 2]);
    }

    public function selectPricing(Request $request): RedirectResponse
    {
        $chairId = session('stylist_booking.chair_id');
        if (!$chairId) {
            return redirect()->route('stylist.book', ['step' => 1]);
        }

        $chair = Chair::findOrFail($chairId);
        $options = $this->pricingOptionsForChair($chair);
        $allowed = collect($options)->pluck('key')->all();

        if (empty($allowed)) {
            return redirect()
                ->route('stylist.book', ['step' => 2])
                ->with('booking_error', 'No pricing is set for this chair. Please ask admin to add pricing.');
        }

        $request->validate([
            'pricing_type' => ['required', 'in:' . implode(',', $allowed)],
        ]);

        $option = collect($options)->firstWhere('key', $request->input('pricing_type'));

        session([
            'stylist_booking.pricing_type' => $option['key'],
            'stylist_booking.pricing_label' => $option['label'],
            'stylist_booking.pricing_amount' => $option['price'],
        ]);

        return redirect()->route('stylist.book', ['step' => 2]);
    }

    // Handle time selection (start + end date & time)
    public function selectTime(Request $request): RedirectResponse
    {
        if (!session('stylist_booking.pricing_type')) {
            return redirect()->route('stylist.book', ['step' => 1]);
        }

        $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'end_time'   => ['required'],
        ]);

        // Calculate duration in hours for price reference
        $start = \Carbon\Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'));
        $end   = \Carbon\Carbon::parse($request->input('end_date')   . ' ' . $request->input('end_time'));

        if ($end->lte($start)) {
            return redirect()->route('stylist.book', ['step' => 2])
                ->withInput()
                ->with('booking_error', 'End date/time must be after start date/time.');
        }

        $hours = max(1, (int) ceil($start->diffInHours($end)));

        session([
            'stylist_booking.start_date' => $request->input('start_date'),
            'stylist_booking.start_time' => $request->input('start_time'),
            'stylist_booking.end_date'   => $request->input('end_date'),
            'stylist_booking.end_time'   => $request->input('end_time'),
            'stylist_booking.hours'      => $hours,
            // Keep legacy keys for backward compat with confirm/summary views
            'stylist_booking.date'       => $request->input('start_date'),
            'stylist_booking.time'       => $request->input('start_time'),
        ]);

        return redirect()->route('stylist.book', ['step' => 3]);
    }

    public function confirm(Request $request): RedirectResponse
    {
        // Ensure a pricing option has been selected before confirming
        if (!session('stylist_booking.pricing_type')) {
            return redirect()->route('stylist.book', ['step' => 1]);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        if ($request->user()) {
            $rules['email'][] = 'unique:users,email,' . $request->user()->id;
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        } else {
            $rules['email'][] = 'unique:users,email';
        }

        $validated = $request->validate($rules);

        $hairstylistRole = Role::where('slug', 'hairstylist')->firstOrFail();

        if ($request->user()) {
            $update = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'] ?? null,
            ];
            if (!empty($validated['password'])) {
                $update['password'] = Hash::make($validated['password']);
            }
            $request->user()->update($update);
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'] ?? null,
                'password' => Hash::make($validated['password']),
                'role_id' => $hairstylistRole->id,
                'role' => 'hairstylist',
                'designation' => 'Hairstylist',
                'joining_date' => date('Y-m-d'),
                'status' => 1,
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
            ]);

            Auth::login($user);
        }

        // Assign first available chair after successful payment/confirmation
        $chair = Chair::where('status', 'available')->first();
        if ($chair) {
            $chair->status = 'booked';
            $chair->save();
            session(['stylist_booking.assigned_chair_id' => $chair->id]);
        }

        // Keep existing booking session data for summary (pricing etc.)
        // Redirect to the summary step (step 4)
        return redirect()->route('stylist.book', ['step' => 4])
            ->with('booking_success', 'Booking confirmed! Your hairstylist account is ready.');
    }

    public function clearBooking(): RedirectResponse
    {
        session()->forget('stylist_booking');

        return redirect()->route('stylist.book');
    }

    /**
     * Build selectable pricing plans from admin chair pricing setup.
     */
    private function pricingOptionsForChair(Chair $chair): array
    {
        $options = [];

        if ($chair->price_hourly) {
            $options[] = [
                'key' => 'hourly',
                'label' => 'Hourly',
                'price' => (float) $chair->price_hourly,
                'subtitle' => 'Pay per hour',
            ];
        }
        if ($chair->price_daily) {
            $options[] = [
                'key' => 'daily',
                'label' => 'Daily',
                'price' => (float) $chair->price_daily,
                'subtitle' => 'Full day rate',
            ];
        }
        if ($chair->price_monthly) {
            $options[] = [
                'key' => 'monthly',
                'label' => 'Monthly',
                'price' => (float) $chair->price_monthly,
                'subtitle' => 'Per month',
            ];
        }
        if ($chair->price_yearly) {
            $options[] = [
                'key' => 'yearly',
                'label' => 'Yearly',
                'price' => (float) $chair->price_yearly,
                'subtitle' => 'Per year',
            ];
        }

        return $options;
    }
}
