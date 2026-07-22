<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class UserPackageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $packages = Package::where('is_active', true)->get();
        
        $myPackages = collect();
        $totalBalance = 0;
        
        if ($user) {
            $myPackages = UserPackage::with('package')->where('user_id', $user->id)->latest()->get();
            $totalBalance = $user->package_balance;
        }

        return view('user.packages.index', compact('packages', 'myPackages', 'totalBalance'));
    }

    public function checkout(Package $package)
    {
        return view('user.packages.checkout', compact('package'));
    }

    public function intent(Request $request, Package $package)
    {
        $finalAmount = (float) $package->price;
        $discount = 0;
        $couponCode = $request->input('coupon_code');

        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', strtoupper(trim($couponCode)))->first();
            if ($coupon && $coupon->isValidNow()) {
                if ($coupon->hasBeenUsedBy(auth()->user(), auth()->user()?->email)) {
                    return response()->json(['error' => 'This coupon has already been used with this email address.'], 400);
                }

                $discount = $coupon->calculateDiscount($finalAmount);
                $finalAmount -= $discount;
                session(['package_checkout_coupon' => $coupon->code, 'package_checkout_discount' => $discount]);
            } else {
                return response()->json(['error' => 'Invalid or expired coupon.'], 400);
            }
        } else {
            session()->forget('package_checkout_coupon');
            session()->forget('package_checkout_discount');
        }

        if ($finalAmount <= 0) {
            return response()->json(['clientSecret' => null, 'is_free' => true, 'finalTotal' => 0]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => intval(round($finalAmount * 100)),
                'currency' => 'gbp',
                'metadata' => [
                    'package_id' => $package->id,
                    'user_id' => auth()->id(),
                ],
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request, Package $package)
    {
        $paymentIntentId = $request->get('payment_intent');
        $isFree = $request->get('is_free') == '1';
        
        if (!$paymentIntentId && !$isFree) {
            return redirect()->route('stylist.packages.index')->with('error', 'Invalid payment session.');
        }

        // Prevent duplicate purchases on refresh
        if (!$isFree && $paymentIntentId) {
            $existingPackage = UserPackage::where('stripe_payment_intent', $paymentIntentId)->first();
            if ($existingPackage) {
                return redirect()->route('stylist.packages.index')->with('success', 'Package already purchased successfully! Your balance has been updated.');
            }
        }

        $pricePaid = $package->price;
        if (session()->has('package_checkout_coupon')) {
            $pricePaid -= session('package_checkout_discount');
        }
        if ($pricePaid < 0) $pricePaid = 0;

        // Create the user package record
        UserPackage::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'hours_purchased' => $package->hours,
            'hours_remaining' => $package->hours,
            'price_paid' => $pricePaid,
            'stripe_payment_intent' => $paymentIntentId,
            'status' => 'active',
            'expires_at' => $package->expiry_days ? now()->addDays($package->expiry_days) : null,
        ]);

        if (session()->has('package_checkout_coupon')) {
            $coupon = \App\Models\Coupon::where('code', session('package_checkout_coupon'))->first();
            if ($coupon) {
                $coupon->recordUsage(auth()->user(), auth()->user()?->email);
            }
            session()->forget('package_checkout_coupon');
            session()->forget('package_checkout_discount');
        }

        return redirect()->route('stylist.packages.index')->with('success', 'Package purchased successfully! Your balance has been updated.');
    }
}
