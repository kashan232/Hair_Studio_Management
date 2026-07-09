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
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => intval(round($package->price * 100)),
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
        
        if (!$paymentIntentId) {
            return redirect()->route('stylist.packages.index')->with('error', 'Invalid payment session.');
        }

        // Prevent duplicate purchases on refresh
        $existingPackage = UserPackage::where('stripe_payment_intent', $paymentIntentId)->first();
        
        if (!$existingPackage) {
            // Create the user package record
            UserPackage::create([
                'user_id' => auth()->id(),
                'package_id' => $package->id,
                'hours_purchased' => $package->hours,
                'hours_remaining' => $package->hours,
                'price_paid' => $package->price,
                'stripe_payment_intent' => $paymentIntentId,
                'status' => 'active',
            ]);
        }

        return redirect()->route('stylist.packages.index')->with('success', 'Package purchased successfully! Your balance has been updated.');
    }
}
