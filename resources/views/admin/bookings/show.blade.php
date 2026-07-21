@extends('layouts.main')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .rf-page {
        --rf-ink: #121212;
        --rf-muted: #8c7e6c;
        --rf-line: #eae2d5;
        --rf-sand: #faf8f5;
        --rf-gold: #c6a34d;
        --rf-wine: #461111;
        --rf-ok: #2e7d32;
        font-family: 'DM Sans', sans-serif;
        color: var(--rf-ink);
    }

    .rf-page .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 400;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--rf-ink);
        margin: 0;
        font-size: clamp(1.2rem, 2vw, 1.55rem);
    }

    .rf-kicker {
        margin: 0 0 0.35rem;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1.6px;
        text-transform: uppercase;
        color: var(--rf-muted);
    }

    .rf-hero {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    @media (max-width: 991px) {
        .rf-hero { grid-template-columns: 1fr; }
    }

    .rf-hero-main,
    .rf-hero-pay {
        border: 1px solid var(--rf-line);
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .rf-hero-main {
        padding: 1.5rem 1.6rem;
        background:
            linear-gradient(135deg, rgba(198,163,77,0.08), transparent 42%),
            #fff;
        animation: rf-rise 0.45s ease both;
    }

    .rf-hero-pay {
        padding: 1.5rem 1.6rem;
        background: var(--rf-ink);
        color: #fff;
        animation: rf-rise 0.55s ease both;
    }

    .rf-status {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        padding: 0.35rem 0.65rem;
        border: 1px solid var(--rf-line);
        background: var(--rf-sand);
        color: var(--rf-ink);
    }
    .rf-status.is-confirmed { background: #e8f5e9; border-color: #c8e6c9; color: var(--rf-ok); }
    .rf-status.is-cancelled { background: #ffebee; border-color: #ffcdd2; color: #c62828; }
    .rf-status.is-pending { background: #fff8e1; border-color: #ffe082; color: #f57c00; }
    .rf-status.is-refunded { background: #e3f2fd; border-color: #90caf9; color: #1565c0; }

    .rf-ref {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3vw, 2.4rem);
        margin: 0.75rem 0 0.35rem;
        letter-spacing: 1px;
    }

    .rf-customer {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }
    .rf-meta {
        color: var(--rf-muted);
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .rf-pay-label {
        font-size: 0.68rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        opacity: 0.7;
        font-weight: 700;
    }
    .rf-pay-amount {
        font-size: clamp(2rem, 4vw, 2.6rem);
        font-weight: 700;
        letter-spacing: -0.5px;
        margin: 0.35rem 0 0.75rem;
        font-family: 'Playfair Display', serif;
    }
    .rf-pay-note {
        font-size: 0.8rem;
        opacity: 0.75;
        margin: 0;
        line-height: 1.45;
    }

    .rf-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 1rem;
        align-items: start;
    }
    @media (max-width: 991px) {
        .rf-grid { grid-template-columns: 1fr; }
    }

    .rf-panel {
        border: 1px solid var(--rf-line);
        background: #fff;
        margin-bottom: 1rem;
        animation: rf-rise 0.5s ease both;
    }
    .rf-panel:nth-child(2) { animation-delay: 0.05s; }
    .rf-panel:nth-child(3) { animation-delay: 0.1s; }

    .rf-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        padding: 0.95rem 1.2rem;
        background: var(--rf-sand);
        border-bottom: 1px solid var(--rf-line);
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: var(--rf-muted);
    }

    .rf-panel-body { padding: 0.35rem 1.2rem 1.1rem; }

    .rf-row {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 0.75rem;
        padding: 0.72rem 0;
        border-bottom: 1px solid #f3eee6;
        font-size: 0.9rem;
    }
    .rf-row:last-child { border-bottom: 0; }
    .rf-row .k { color: var(--rf-muted); font-weight: 600; }
    .rf-row .v { color: var(--rf-ink); font-weight: 600; text-align: right; word-break: break-word; }
    @media (max-width: 575px) {
        .rf-row { grid-template-columns: 1fr; }
        .rf-row .v { text-align: left; }
    }

    .rf-chairs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        justify-content: flex-end;
    }
    .rf-chair-pill {
        border: 1px solid var(--rf-line);
        background: var(--rf-sand);
        padding: 0.25rem 0.55rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .rf-timeline {
        display: grid;
        gap: 0.85rem;
        padding: 1.1rem 1.2rem 1.25rem;
    }
    .rf-step {
        display: grid;
        grid-template-columns: 18px 1fr;
        gap: 0.75rem;
        align-items: start;
    }
    .rf-dot {
        width: 12px;
        height: 12px;
        margin-top: 0.3rem;
        border-radius: 50%;
        background: var(--rf-gold);
        box-shadow: 0 0 0 4px rgba(198,163,77,0.18);
    }
    .rf-dot.is-muted { background: #d7d0c4; box-shadow: none; }
    .rf-step strong {
        display: block;
        font-size: 0.88rem;
        margin-bottom: 0.1rem;
    }
    .rf-step span {
        color: var(--rf-muted);
        font-size: 0.8rem;
    }

    .rf-card-visual {
        margin: 1.1rem 1.2rem;
        border-radius: 14px;
        padding: 1.25rem 1.3rem;
        min-height: 150px;
        background:
            linear-gradient(145deg, #1c1c1c 0%, #2b2b2b 45%, #3a3228 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(0,0,0,0.18);
    }
    .rf-card-visual::after {
        content: '';
        position: absolute;
        inset: auto -20% -40% auto;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(198,163,77,0.35), transparent 70%);
        pointer-events: none;
    }
    .rf-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.4rem;
        font-size: 0.72rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        opacity: 0.8;
        font-weight: 700;
    }
    .rf-card-number {
        font-size: 1.2rem;
        letter-spacing: 3px;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .rf-card-bottom {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
    }

    .rf-actions {
        position: sticky;
        top: 1rem;
        border: 1px solid var(--rf-line);
        background: #fff;
        padding: 1.25rem;
        animation: rf-rise 0.6s ease both;
    }
    .rf-actions h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        margin: 0 0 0.5rem;
        letter-spacing: 0.5px;
    }
    .rf-actions p {
        color: var(--rf-muted);
        font-size: 0.84rem;
        line-height: 1.5;
        margin: 0 0 1rem;
    }

    .rf-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        border-radius: 0 !important;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        font-size: 0.74rem;
        padding: 0.85rem 1rem;
        text-decoration: none;
        transition: 0.25s ease;
    }
    .rf-btn-primary {
        background: var(--rf-wine);
        border: 1px solid var(--rf-wine);
        color: #fff !important;
    }
    .rf-btn-primary:hover {
        background: var(--rf-ink);
        border-color: var(--rf-ink);
        transform: translateY(-1px);
        color: #fff !important;
    }
    .rf-btn-ghost {
        background: #fff;
        border: 1px solid var(--rf-line);
        color: var(--rf-ink) !important;
        margin-top: 0.55rem;
    }
    .rf-btn-ghost:hover {
        border-color: var(--rf-ink);
        color: var(--rf-ink) !important;
    }
    .rf-btn[disabled] {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none !important;
    }

    .rf-success-box,
    .rf-warn-box {
        padding: 0.85rem 0.95rem;
        font-size: 0.82rem;
        line-height: 1.45;
        margin-bottom: 0.85rem;
    }
    .rf-success-box {
        background: #e8f5e9;
        border: 1px solid #c8e6c9;
        color: #1b5e20;
    }
    .rf-warn-box {
        background: #fff8e1;
        border: 1px solid #ffe082;
        color: #e65100;
    }

    .rf-flash {
        border-radius: 0;
        border: 1px solid transparent;
        margin-bottom: 1rem;
        animation: rf-rise 0.35s ease both;
    }

    @keyframes rf-rise {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
@php
    $customerName = $booking->user->name ?? ($booking->guest_name ?? 'Guest');
    $customerEmail = $booking->user->email ?? ($booking->guest_email ?? '—');
    $customerPhone = $booking->user->mobile ?? ($booking->guest_phone ?? '—');
    $alreadyRefunded = $booking->refunded_at || $booking->refund_status === 'succeeded';
    $charged = (float) ($payment['amount_charged'] ?? $booking->total_amount);
    $statusKey = $alreadyRefunded ? 'refunded' : $booking->status;
    $statusClass = match (true) {
        $alreadyRefunded => 'is-refunded',
        $booking->status === 'confirmed' => 'is-confirmed',
        in_array($booking->status, ['cancelled', 'cancelled_late_response'], true) => 'is-cancelled',
        default => 'is-pending',
    };
    $setupLabel = match ($booking->setup_type) {
        'makeup' => 'Make-up Chair',
        'hair' => 'Hair Stylist Chair',
        default => ($booking->setup_type ?: '—'),
    };
@endphp

<div class="main-content app-content mt-0 rf-page">
    <div class="side-app">
        <div class="main-container container-fluid py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
                <div>
                    <p class="rf-kicker">Refund &amp; booking review</p>
                    <h1 class="page-title">Booking #{{ $booking->id }}</h1>
                </div>
                <a href="{{ route('bookings.index') }}" class="rf-btn rf-btn-ghost" style="width:auto; min-width:160px;">
                    ← All Bookings
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success rf-flash">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger rf-flash">{{ session('error') }}</div>
            @endif

            <div class="rf-hero">
                <div class="rf-hero-main">
                    <span class="rf-status {{ $statusClass }}">{{ str_replace('_', ' ', $statusKey) }}</span>
                    <h2 class="rf-ref">#{{ $booking->id }}</h2>
                    <p class="rf-customer">{{ $customerName }}</p>
                    <p class="rf-meta">{{ $customerEmail }} · {{ $customerPhone }}</p>
                    <p class="rf-meta mt-2 mb-0">
                        Booked {{ optional($booking->created_at)->timezone(config('app.timezone'))->format('d M Y · h:i A') }} (UK)
                    </p>
                </div>
                <div class="rf-hero-pay">
                    <div class="rf-pay-label">{{ $alreadyRefunded ? 'Amount refunded' : 'Amount charged' }}</div>
                    <div class="rf-pay-amount">
                        £{{ number_format($alreadyRefunded ? (float) ($booking->refunded_amount ?? $charged) : $charged, 2) }}
                    </div>
                    <p class="rf-pay-note">
                        @if($alreadyRefunded)
                            Returned to the original card on {{ optional($booking->refunded_at)->format('d M Y, h:i A') }}.
                        @else
                            Exact Stripe charge for this booking. Refund goes back to the same card.
                        @endif
                    </p>
                </div>
            </div>

            <div class="rf-grid">
                <div>
                    <div class="rf-panel">
                        <div class="rf-panel-head">
                            <span>Schedule &amp; chair</span>
                            <span>{{ $booking->duration_hours }} hrs</span>
                        </div>
                        <div class="rf-panel-body">
                            <div class="rf-row">
                                <span class="k">Start (UK)</span>
                                <span class="v">{{ optional($booking->start_datetime)->format('D, d M Y · h:i A') }}</span>
                            </div>
                            <div class="rf-row">
                                <span class="k">End (UK)</span>
                                <span class="v">{{ optional($booking->end_datetime)->format('D, d M Y · h:i A') }}</span>
                            </div>
                            <div class="rf-row">
                                <span class="k">Duration</span>
                                <span class="v">{{ $booking->duration_hours }} hours</span>
                            </div>
                            <div class="rf-row">
                                <span class="k">Chair(s)</span>
                                <span class="v">
                                    <span class="rf-chairs">
                                        @forelse($booking->chairs as $c)
                                            <span class="rf-chair-pill">{{ $c->name }}</span>
                                        @empty
                                            <span>—</span>
                                        @endforelse
                                    </span>
                                </span>
                            </div>
                            <div class="rf-row">
                                <span class="k">Setup</span>
                                <span class="v">{{ $setupLabel }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="rf-panel">
                        <div class="rf-panel-head"><span>Timeline</span></div>
                        <div class="rf-timeline">
                            <div class="rf-step">
                                <span class="rf-dot"></span>
                                <div>
                                    <strong>Booking created</strong>
                                    <span>{{ optional($booking->created_at)->timezone(config('app.timezone'))->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                            <div class="rf-step">
                                <span class="rf-dot {{ $payment['paid_at'] || $payment['available'] ? '' : 'is-muted' }}"></span>
                                <div>
                                    <strong>Payment</strong>
                                    <span>
                                        @if($payment['paid_at'])
                                            Paid {{ $payment['paid_at'] }} · £{{ number_format($charged, 2) }}
                                        @elseif($payment['available'])
                                            Stripe status: {{ $payment['status'] }} · £{{ number_format($charged, 2) }}
                                        @else
                                            No Stripe payment linked
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="rf-step">
                                <span class="rf-dot"></span>
                                <div>
                                    <strong>Session start</strong>
                                    <span>{{ optional($booking->start_datetime)->format('d M Y, h:i A') }} (UK)</span>
                                </div>
                            </div>
                            @if($alreadyRefunded)
                            <div class="rf-step">
                                <span class="rf-dot"></span>
                                <div>
                                    <strong>Refund completed</strong>
                                    <span>
                                        £{{ number_format((float) ($booking->refunded_amount ?? $charged), 2) }}
                                        on {{ optional($booking->refunded_at)->format('d M Y, h:i A') }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="rf-panel">
                        <div class="rf-panel-head"><span>Payment breakdown</span></div>
                        <div class="rf-panel-body">
                            <div class="rf-row">
                                <span class="k">Booking total</span>
                                <span class="v">£{{ number_format((float) $booking->total_amount, 2) }}</span>
                            </div>
                            @if($booking->coupon_code)
                            <div class="rf-row">
                                <span class="k">Coupon</span>
                                <span class="v">{{ $booking->coupon_code }} (−£{{ number_format((float) $booking->discount_amount, 2) }})</span>
                            </div>
                            @endif
                            @if((float) $booking->package_hours_used > 0)
                            <div class="rf-row">
                                <span class="k">Package used</span>
                                <span class="v">{{ $booking->package_hours_used }} hrs</span>
                            </div>
                            @endif
                            <div class="rf-row">
                                <span class="k">Stripe charge</span>
                                <span class="v">£{{ number_format($charged, 2) }}</span>
                            </div>
                            <div class="rf-row">
                                <span class="k">Payment ID</span>
                                <span class="v" style="font-size:0.72rem;">{{ $booking->stripe_payment_intent ?: 'Not linked' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="rf-panel" style="margin-bottom:1rem;">
                        <div class="rf-panel-head"><span>Card on file</span></div>
                        <div class="rf-card-visual">
                            <div class="rf-card-top">
                                <span>{{ $payment['card_brand'] ?: 'Card' }}</span>
                                <span>Stripe</span>
                            </div>
                            <div class="rf-card-number">
                                @if($payment['card_last4'])
                                    •••• •••• •••• {{ $payment['card_last4'] }}
                                @else
                                    •••• •••• •••• ----
                                @endif
                            </div>
                            <div class="rf-card-bottom">
                                <span>{{ $customerName }}</span>
                                <span>{{ $payment['card_exp'] ? 'Exp '.$payment['card_exp'] : 'Exp --/--' }}</span>
                            </div>
                        </div>
                        <div class="rf-panel-body" style="padding-top:0;">
                            @if($payment['error'])
                                <div class="rf-warn-box mb-0">{{ $payment['error'] }}</div>
                            @elseif($payment['available'] && $payment['card_last4'])
                                <p class="mb-0" style="color:var(--rf-muted);font-size:0.82rem;line-height:1.45;">
                                    Refund returns to this original payment method. Banks can take a few working days to show it.
                                </p>
                            @else
                                <p class="mb-0" style="color:var(--rf-muted);font-size:0.82rem;">
                                    Card details unavailable — refund needs a linked Stripe payment.
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="rf-actions">
                        <h3>{{ $alreadyRefunded ? 'Refund complete' : 'Issue refund' }}</h3>

                        @if($alreadyRefunded)
                            <div class="rf-success-box">
                                £{{ number_format((float) ($booking->refunded_amount ?? $charged), 2) }} already sent back to the customer’s card
                                @if($booking->refund_status)
                                    ({{ $booking->refund_status }})
                                @endif
                                on {{ optional($booking->refunded_at)->format('d M Y, h:i A') }}.
                            </div>
                            <a href="{{ route('bookings.index') }}" class="rf-btn rf-btn-ghost">Back to bookings</a>
                        @elseif($canRefund)
                            <p>
                                Confirm to refund <strong>£{{ number_format($charged, 2) }}</strong> to the original card and cancel this booking so the chair is released.
                            </p>
                            <form method="POST" action="{{ route('bookings.refund', $booking->id) }}" id="admin-refund-form">
                                @csrf
                                <button type="submit" class="rf-btn rf-btn-primary">
                                    <i class="fe fe-refresh-cw"></i>
                                    Refund £{{ number_format($charged, 2) }} to card
                                </button>
                            </form>
                            <a href="{{ route('bookings.index') }}" class="rf-btn rf-btn-ghost">Cancel &amp; go back</a>
                        @else
                            <div class="rf-warn-box">
                                Refund unavailable — this booking has no linked Stripe payment to return funds to.
                            </div>
                            <a href="{{ route('bookings.index') }}" class="rf-btn rf-btn-ghost">Back to bookings</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script>
    document.getElementById('admin-refund-form')?.addEventListener('submit', function (e) {
        e.preventDefault();
        var form = this;
        var amount = '{{ number_format($charged, 2) }}';
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Refund £' + amount + '?',
                html: 'This sends <strong>£' + amount + '</strong> back to the customer’s original card and cancels booking #{{ $booking->id }}.',
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#461111',
                confirmButtonText: 'Yes, refund now',
                cancelButtonText: 'Keep booking'
            }).then(function (result) {
                if (result.value || result.isConfirmed) {
                    var btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = 'Processing refund…';
                    }
                    form.submit();
                }
            });
        } else if (confirm('Refund £' + amount + ' to the original card?')) {
            form.submit();
        }
    });
</script>
@endsection
