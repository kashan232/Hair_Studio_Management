<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        // All chairs for "create pricing" dropdown
        $allChairs = Chair::orderBy('name')->get();

        // Chairs that already have at least one pricing set — for listing
        $pricedChairs = Chair::where(function($q) {
            $q->whereNotNull('price_hourly')
              ->orWhereNotNull('price_daily')
              ->orWhereNotNull('price_monthly')
              ->orWhereNotNull('price_yearly');
        })->orderBy('id', 'desc')->get();

        return view('pricing.index', compact('allChairs', 'pricedChairs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chair_id'     => 'required|exists:chairs,id',
            'price_hourly'  => 'nullable|numeric|min:0',
            'price_daily'   => 'nullable|numeric|min:0',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_yearly'  => 'nullable|numeric|min:0',
        ]);

        $chair = Chair::findOrFail($request->input('chair_id'));
        $chair->update([
            'price_hourly'  => $request->input('price_hourly'),
            'price_daily'   => $request->input('price_daily'),
            'price_monthly' => $request->input('price_monthly'),
            'price_yearly'  => $request->input('price_yearly'),
        ]);

        return response()->json([
            'success'  => 'Pricing set successfully.',
            'redirect' => route('pricing.index'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $chair = Chair::findOrFail($id);

        $request->validate([
            'price_hourly'  => 'nullable|numeric|min:0',
            'price_daily'   => 'nullable|numeric|min:0',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_yearly'  => 'nullable|numeric|min:0',
        ]);

        $chair->update([
            'price_hourly'  => $request->input('price_hourly'),
            'price_daily'   => $request->input('price_daily'),
            'price_monthly' => $request->input('price_monthly'),
            'price_yearly'  => $request->input('price_yearly'),
        ]);

        return response()->json([
            'success'  => 'Pricing updated successfully.',
            'redirect' => route('pricing.index'),
        ]);
    }

    public function destroy($id)
    {
        $chair = Chair::findOrFail($id);
        $chair->update([
            'price_hourly'  => null,
            'price_daily'   => null,
            'price_monthly' => null,
            'price_yearly'  => null,
        ]);

        return response()->json([
            'success'  => 'Pricing cleared successfully.',
            'redirect' => route('pricing.index'),
        ]);
    }
}
