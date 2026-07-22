<x-mail::message>
# Booking Received — Pending Approval

Hello {{ $booking->user ? $booking->user->name : $booking->guest_name }},

Thank you for your booking request at Eladé Studio.

Your requested time falls within overnight hours (**9 PM – 8 AM**), so it has been submitted for **admin approval**. You will receive another email once it has been reviewed.

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

If approved, you will be asked to complete payment to secure your reservation.

Thanks,<br>
Eladé Studio
</x-mail::message>
