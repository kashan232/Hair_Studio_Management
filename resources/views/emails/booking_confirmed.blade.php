<x-mail::message>
# Booking Confirmed

Hello {{ $booking->user ? $booking->user->name : $booking->guest_name }},

Your workspace booking at Eladé Studio has been successfully confirmed.

**Date:** {{ $booking->start_datetime->format('l, jS F Y') }}
**Time:** {{ $booking->start_datetime->format('g:i A') }} - {{ $booking->end_datetime->format('g:i A') }}
**Duration:** {{ $booking->duration_hours }} hours
@if($booking->setup_type && $booking->setup_type !== 'any')
**Required Setup:** {{ $booking->setup_type === 'makeup' ? 'Make-up Chair' : 'Hair Stylist Chair' }}
@endif

@if(!$booking->user_id)
Want to amend or cancel your booking? Create an account with us using this email address:
<x-mail::button :url="$registerUrl">
Create Account
</x-mail::button>
@endif

Thanks,<br>
Eladé Studio
</x-mail::message>
