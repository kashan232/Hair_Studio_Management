<x-mail::message>
# Booking Request Rejected

Hello {{ $booking->user ? $booking->user->name : $booking->guest_name }},

We regret to inform you that your overnight workspace booking request at Eladé Studio could not be approved at this time.

**Date:** {{ \Carbon\Carbon::parse($booking->start_datetime)->timezone('Europe/London')->format('l, jS F Y') }}
**Time (UK):** {{ \Carbon\Carbon::parse($booking->start_datetime)->timezone('Europe/London')->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_datetime)->timezone('Europe/London')->format('g:i A') }}
**Booking Ref:** #{{ $booking->id }}
@if($booking->chairs->isNotEmpty())
**Chair(s):** {{ $booking->chairs->pluck('name')->join(', ') }}
@endif

If you have any questions or need to discuss alternative booking times, please feel free to reach out to us.

Thanks,<br>
Eladé Studio
</x-mail::message>
