<x-mail::message>
# Booking Approved - Payment Required

Hello {{ $booking->user ? $booking->user->name : $booking->guest_name }},

Good news! Your overnight workspace booking at Eladé Studio has been approved by our admin team.

**Date:** {{ \Carbon\Carbon::parse($booking->start_datetime)->timezone('Europe/London')->format('l, jS F Y') }}
**Time (UK):** {{ \Carbon\Carbon::parse($booking->start_datetime)->timezone('Europe/London')->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_datetime)->timezone('Europe/London')->format('g:i A') }}
**Booking Ref:** #{{ $booking->id }}
@if($booking->chairs->isNotEmpty())
**Chair(s):** {{ $booking->chairs->pluck('name')->join(', ') }}
@endif

To secure your reservation, please complete your payment within the next 15 minutes. 
If payment is not received, the reservation will automatically expire.

<x-mail::button :url="$payUrl" color="success">
Pay £{{ number_format($booking->total_amount, 2) }} Now
</x-mail::button>

Thanks,<br>
Eladé Studio
</x-mail::message>
