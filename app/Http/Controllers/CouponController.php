<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'expires_at' => 'required|date',
            'is_active' => 'boolean',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    // Public / Stylist API to apply coupon
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total_amount' => 'required|numeric|min:0'
        ]);

        $coupon = Coupon::where('code', strtoupper(trim($request->code)))->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.'], 400);
        }

        if (!$coupon->is_active) {
            return response()->json(['error' => 'This coupon is no longer active.'], 400);
        }

        if ($coupon->expires_at->lt(Carbon::today())) {
            return response()->json(['error' => 'This coupon has expired.'], 400);
        }

        $user = $request->user();
        if ($user) {
            $hasUsed = $coupon->users()->where('user_id', $user->id)->exists();
            if ($hasUsed) {
                return response()->json(['error' => 'You have already used this coupon.'], 400);
            }
        } else {
            // For guests, we can't reliably track usage, but we can check if they are trying to use it without login.
            // But they are usually logged in when paying the balance. 
            // In case of pay balance, they might not be authenticated if it's a public link?
            // Actually, the prompt says "only 1 time user pr wo coupon expire ho jaeyga".
            // So if user is not logged in, we should probably require them to log in or just apply it and rely on booking user tracking.
            // Wait, booking has a user_id! The pay balance route knows the booking ID!
        }
        
        // If booking_id is provided (like in pay balance screen)
        if ($request->has('booking_id')) {
            $booking = \App\Models\Booking::find($request->booking_id);
            if ($booking && $booking->user_id) {
                $hasUsed = $coupon->users()->where('user_id', $booking->user_id)->exists();
                if ($hasUsed) {
                    return response()->json(['error' => 'You have already used this coupon.'], 400);
                }
            }
        }

        $originalTotal = (float) $request->total_amount;
        $discountAmount = 0;

        if ($coupon->discount_type === 'fixed') {
            $discountAmount = (float) $coupon->discount_value;
        } else {
            $discountAmount = $originalTotal * ((float) $coupon->discount_value / 100);
        }

        if ($discountAmount > $originalTotal) {
            $discountAmount = $originalTotal;
        }

        $newTotal = $originalTotal - $discountAmount;

        return response()->json([
            'success' => true,
            'discount_amount' => round($discountAmount, 2),
            'new_total' => round($newTotal, 2),
            'coupon_code' => $coupon->code
        ]);
    }
}
