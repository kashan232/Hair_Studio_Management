<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'is_reusable' => 'boolean',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
            'is_reusable' => $request->has('is_reusable'),
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'email' => 'nullable|email',
            'booking_id' => 'nullable|integer',
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
        $email = $request->input('email');

        if ($request->filled('booking_id')) {
            $booking = \App\Models\Booking::find($request->booking_id);
            if ($booking) {
                $user = $user ?: $booking->user;
                $email = $email
                    ?: $booking->guest_email
                    ?: $booking->user?->email;
            }
        }

        if (!$email) {
            $email = session('stylist_booking.guest.email')
                ?: $user?->email;
        }

        if ($coupon->hasBeenUsedBy($user, $email)) {
            return response()->json(['error' => 'This coupon has already been used with this email address.'], 400);
        }

        $originalTotal = (float) $request->total_amount;
        $discountAmount = $coupon->calculateDiscount($originalTotal);
        $newTotal = $originalTotal - $discountAmount;

        return response()->json([
            'success' => true,
            'discount_amount' => round($discountAmount, 2),
            'new_total' => round($newTotal, 2),
            'coupon_code' => $coupon->code,
            'is_reusable' => (bool) $coupon->is_reusable,
        ]);
    }
}
