<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        // Get all bookings with latest first
        $bookings = Booking::with('user', 'chairs')->orderBy('created_at', 'desc')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,confirmed,cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        // If approved (pending_payment), we ideally send an email to user to pay.
        // For now, we just redirect back with success message.
        $message = 'Booking status updated successfully.';
        if ($request->status === 'pending_payment') {
            $message = 'Booking approved. Stylist can now pay.';
        } elseif ($request->status === 'cancelled') {
            $message = 'Booking rejected and cancelled.';
        }

        return redirect()->route('bookings.index')->with('success', $message);
    }

    // Public payment page for stylists to pay for an approved booking
    public function payBalance($id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if ($booking->status !== 'pending_payment') {
            return redirect()->route('stylist.book')->with('booking_error', 'This booking cannot be paid right now.');
        }

        return view('stylist.pay_balance', compact('booking'));
    }

    // Process the payment intent for the balance
    public function processBalancePayment(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending_payment') {
            return response()->json(['error' => 'Invalid booking status'], 400);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $intent = \Stripe\PaymentIntent::create([
            'amount'   => (int) round($booking->total_amount * 100),
            'currency' => 'gbp',
            'metadata' => [
                'booking_id' => $booking->id,
            ],
        ]);

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function balancePaymentSuccess($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return view('stylist.pay_balance_success', compact('booking'));
    }
}
