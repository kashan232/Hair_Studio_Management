<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HairstylistPortalController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('stylist.book', ['step' => 1]);
    }

    public function booking(Request $request): View|RedirectResponse
    {
        $step = max(1, min(5, (int) $request->query('step', 1)));
        $user = $request->user();
        $selectedChairId = session('stylist_booking.chair_id');
        $selectedChair = $selectedChairId ? Chair::find($selectedChairId) : null;

        if ($step >= 3 && !$selectedChair) {
            return redirect()->route('stylist.book', ['step' => 2]);
        }

        $chairs = Chair::query()
            ->where('status', 'available')
            ->orderBy('name')
            ->get();

        $steps = [
            1 => ['label' => 'Profile', 'title' => 'Your profile details'],
            2 => ['label' => 'Chair', 'title' => 'Choose an available chair'],
            3 => ['label' => 'Services', 'title' => 'Select your services'],
            4 => ['label' => 'Time', 'title' => 'Pick date & time'],
            5 => ['label' => 'Confirm', 'title' => 'Review & confirm'],
        ];

        return view('stylist.booking', compact('step', 'user', 'chairs', 'selectedChair', 'steps'));
    }

    public function selectChair(Request $request): RedirectResponse
    {
        $request->validate([
            'chair_id' => 'required|exists:chairs,id',
        ]);

        $chair = Chair::where('status', 'available')->findOrFail($request->input('chair_id'));

        session(['stylist_booking.chair_id' => $chair->id]);

        return redirect()->route('stylist.book', ['step' => 3]);
    }

    public function clearBooking(): RedirectResponse
    {
        session()->forget('stylist_booking');

        return redirect()->route('stylist.book', ['step' => 1]);
    }
}
