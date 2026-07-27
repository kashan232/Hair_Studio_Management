<x-mail::message>
# Booking Confirmed

Hello {{ $booking->user ? $booking->user->name : $booking->guest_name }},

Your workspace booking at Eladé Studio has been successfully confirmed.

**Booking Ref:** #{{ $booking->id }}
**Date:** {{ $booking->start_datetime->timezone('Europe/London')->format('l, jS F Y') }}
**Time (UK):** {{ $booking->start_datetime->timezone('Europe/London')->format('g:i A') }} – {{ $booking->end_datetime->timezone('Europe/London')->format('g:i A') }}
**Duration:** {{ $booking->duration_hours }} hours
@if($booking->chairs->isNotEmpty())
**Chair(s):** {{ $booking->chairs->pluck('name')->join(', ') }}
@endif
@if($booking->setup_type && $booking->setup_type !== 'any')
**Required Setup:** {{ $booking->setup_type === 'makeup' ? 'Make-up Chair' : 'Hair Stylist Chair' }}
@endif
@if((float) $booking->total_amount > 0)
**Amount:** £{{ number_format((float) $booking->total_amount, 2) }}
@endif

@if($booking->agreement_signature)
---
**Member Agreement Accepted**
<br>
<img src="{{ $booking->agreement_signature }}" alt="Signature" style="max-height: 100px; max-width: 100%; border: 1px solid #efe4dc; padding: 10px; background: #fff;">
@endif

@if($booking->user_id)
You can amend or cancel this booking from **My Bookings** in your account.
@else
Want to amend or cancel your booking? Create an account with us using this email address:
<x-mail::button :url="$registerUrl">
Create Account
</x-mail::button>
@endif

Thanks,<br>
Eladé Studio
</x-mail::message>
