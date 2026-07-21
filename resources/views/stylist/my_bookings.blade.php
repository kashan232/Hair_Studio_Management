@extends('layouts.stylist-app')

@section('title', 'My Bookings | The Studio')

@section('css')
<style>
    :root {
        --app-bg: #fdf8f6;
        --app-surface: #ffffff;
        --app-accent: rgba(70, 17, 17, 0.9);
        --app-accent-dark: #461111;
        --app-accent-soft: rgba(70, 17, 17, 0.1);
        --app-text: #2a2420;
        --app-muted: #8a7d72;
        --app-line: #efe4dc;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --shadow-sm: 0 4px 15px rgba(0,0,0,0.03);
        --shadow-md: 0 10px 30px rgba(0,0,0,0.05);
    }

    body {
        background-color: var(--app-bg);
        font-family: 'Outfit', 'Montserrat', sans-serif;
        color: var(--app-text);
        margin: 0;
        padding-bottom: 80px;
    }

    /* -------------------------------------
       TOP NAV / PROFILE BAR
       ------------------------------------- */
    .top-nav {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--app-line);
        position: sticky;
        top: 0;
        z-index: 100;
        padding: 0.75rem 1.5rem;
    }
    .top-nav-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }
    .profile-wrap {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }
    .profile-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(212, 160, 136, 0.3);
        border: 2px solid #fff;
    }
    .profile-details h3 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: -0.3px;
    }
    .profile-details p {
        margin: 0;
        font-size: 0.7rem;
        color: var(--app-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
    }
    .nav-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex: 1;
        justify-content: flex-end;
    }
    .btn-outline {
        border: 1px solid var(--app-line);
        background: transparent;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--app-text);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .btn-outline:hover {
        background: #fdf5f1;
        color: var(--app-accent-dark);
        border-color: #d4a088;
    }
    .btn-new-booking {
        background: var(--app-surface);
        border-color: var(--salon-theme-solid, #461111);
        color: var(--salon-theme-solid, #461111);
    }
    .btn-new-booking:hover {
        background: var(--salon-theme-solid, #461111);
        color: #fff;
    }
    .btn-logout {
        color: #d32f2f;
        border-color: #ffcdd2;
    }
    .btn-logout:hover {
        background: #ffebee;
        border-color: #ef5350;
    }

    .header-logo-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        flex: 0;
        display: flex;
        justify-content: center;
        z-index: -1;
    }

    @media (max-width: 950px) {
        .top-nav-inner {
            flex-wrap: wrap;
        }
        .header-logo-center {
            position: static;
            transform: none;
            order: -1;
            width: 100%;
            text-align: center;
            margin-bottom: 1rem;
            z-index: 1;
        }
        .profile-wrap {
            flex: 1 1 auto;
            margin-bottom: 0.5rem;
        }
        .nav-actions {
            flex: 1 1 100%;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .nav-actions .btn-outline {
            flex: 1;
            text-align: center;
        }
        .nav-actions form {
            flex: 1;
        }
    }

    /* -------------------------------------
       MAIN CONTAINER
       ------------------------------------- */
    .container {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 0 1.5rem;
    }
    .page-header {
        margin-bottom: 2.5rem;
    }
    .page-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 0.5rem;
        letter-spacing: -1px;
        color: var(--app-text);
    }
    .page-subtitle {
        font-size: 0.9rem;
        color: var(--app-text-muted);
        margin: 0;
        line-height: 1.5;
    }

    /* -------------------------------------
       BOOKING CARDS
       ------------------------------------- */
    .bookings-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .b-card {
        background: var(--app-surface);
        border-radius: 16px;
        border: 1px solid var(--app-line);
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .b-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
    
    /* Decorative side border based on status */
    .b-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
    }
    .b-card.status-pending_payment::before { background: #42a5f5; }
    .b-card.status-pending_approval::before { background: #ffa726; }
    .b-card.status-confirmed::before { background: #66bb6a; }
    .b-card.status-cancelled::before { background: #ef5350; }
    .b-card.status-cancelled_late_response::before { background: #ef5350; }

    @media(min-width: 768px) {
        .b-card {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .b-info { flex: 1; }
    .b-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .b-id {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--app-text);
        margin: 0;
    }
    
    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .badge-pending_approval { background: #fff3e0; color: #ef6c00; }
    .badge-pending_payment { background: #e3f2fd; color: #1565c0; }
    .badge-confirmed { background: #e8f5e9; color: #2e7d32; }
    .badge-cancelled { background: #ffebee; color: #c62828; }
    .badge-cancelled_late_response { background: #ffebee; color: #c62828; }

    .b-details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        background: #faf7f5;
        border-radius: 10px;
        padding: 1.25rem;
        border: 1px solid var(--app-line);
    }
    @media(min-width: 600px) {
        .b-details-grid { grid-template-columns: repeat(4, 1fr); }
    }
    .b-detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .b-detail-label {
        font-size: 0.65rem;
        color: var(--app-text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    .b-detail-val {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--app-text);
    }

    .b-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        min-width: 160px;
    }
    .btn-pay {
        background: linear-gradient(135deg, var(--app-accent) 0%, var(--app-accent-dark) 100%);
        color: #fff;
        border: none;
        height: 44px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(212,160,136,0.3);
    }
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212,160,136,0.4);
    }
    .btn-disabled {
        background: #f0ebe8;
        color: #a89f99;
        cursor: not-allowed;
        box-shadow: none;
        border: 1px solid var(--app-line);
    }
    .btn-cancel-booking {
        width: 100%;
        border-color: #ffcdd2 !important;
        color: #d32f2f !important;
        font-size: 0.7rem !important;
        background: #fff;
    }
    .btn-cancel-booking:hover {
        background: #ffebee !important;
        border-color: #ef5350 !important;
    }
    .btn-amend-booking {
        width: 100%;
        border-color: #d4a088 !important;
        color: var(--app-accent-dark) !important;
        font-size: 0.7rem !important;
        background: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 40px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-amend-booking:hover {
        background: #fdf5f1 !important;
    }
    .flash-banner {
        max-width: 1200px;
        margin: 0 auto 1.25rem;
        padding: 0.9rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .flash-success {
        background: #e8f5e9;
        border: 1px solid #c8e6c9;
        color: #2e7d32;
    }
    .flash-error {
        background: #ffebee;
        border: 1px solid #ffcdd2;
        color: #c62828;
    }
    .policy-note {
        font-size: 0.65rem;
        color: var(--app-muted);
        text-align: center;
        line-height: 1.4;
        margin-top: 0.25rem;
    }

    /* -------------------------------------
       EMPTY STATE
       ------------------------------------- */
    .empty-state {
        background: var(--app-surface);
        border: 1px dashed #d6ccc6;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
    }
    .empty-icon {
        width: 80px;
        height: 80px;
        background: #fdf8f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .empty-icon svg {
        width: 40px;
        height: 40px;
        color: var(--app-accent);
    }
    .empty-state h3 {
        font-size: 1.5rem;
        margin: 0 0 0.5rem;
    }
    .empty-state p {
        color: var(--app-text-muted);
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }
    .btn-primary {
        background: var(--app-text);
        color: #fff;
        text-decoration: none;
        padding: 0.85rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.3s;
        display: inline-block;
    }
    .btn-primary:hover {
        background: #000;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<nav class="top-nav">
    <div class="top-nav-inner">
        <div class="profile-wrap">
            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f5e6df&color=c4896e' }}" alt="User" class="profile-avatar">
            <div class="profile-details">
                <h3>{{ $user->name }}</h3>
                <p>Stylist Portal</p>
            </div>
        </div>

        <div class="header-logo-center">
            <img src="{{ asset('images/brand_logo.svg') }}" alt="Studio Logo" style="height: 45px; width: auto; object-fit: contain;">
        </div>

        <div class="nav-actions">
            @php
                $activePackage = App\Models\UserPackage::where('user_id', auth()->id())->where('status', 'active')->where('hours_remaining', '>', 0)->first();
            @endphp
            @if($activePackage)
                <div style="background: var(--app-accent-dark); color: var(--app-surface); display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-weight: 700; padding: 0.4rem 1rem; border-radius: 8px; font-size: 0.75rem; letter-spacing: 0.5px;">
                    <span style="width: 8px; height: 8px; background: #4caf50; border-radius: 50%; display: inline-block; box-shadow: 0 0 8px #4caf50;"></span>
                    {{ intval($activePackage->hours_remaining) == $activePackage->hours_remaining ? intval($activePackage->hours_remaining) : $activePackage->hours_remaining }} HRS
                </div>
            @endif
            <a href="{{ route('stylist.packages.index') }}" class="btn-outline" style="border-color: #d4a088; color: var(--app-accent-dark);">My Packages</a>
            <a href="{{ route('stylist.book') }}" class="btn-outline btn-new-booking">New Booking</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0; display:flex;">
                @csrf
                <button type="submit" class="btn-outline btn-logout">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">My Bookings</h1>
        <p class="page-subtitle">Manage your studio workspace reservations and upcoming appointments.</p>
    </div>

    @if(session('success'))
        <div class="flash-banner flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-banner flash-error">{{ session('error') }}</div>
    @endif

    @if($bookings->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3>No reservations found</h3>
            <p>You haven't booked any workspaces yet. Ready to get started?</p>
            <a href="{{ route('stylist.book') }}" class="btn-primary">Book a Workspace</a>
        </div>
    @else
        <div class="bookings-grid">
            @foreach($bookings as $b)
                @php
                    $startAt = \Carbon\Carbon::parse($b->start_datetime);
                    $hoursUntilStart = ($startAt->getTimestamp() - now()->getTimestamp()) / 3600;
                    $canManage = in_array($b->status, ['pending_payment', 'pending_approval'], true)
                        || ($b->status === 'confirmed' && $startAt->gt(now()->addHours(24)));
                    $canAmend = $canManage && $startAt->isFuture();
                @endphp
                <div class="b-card status-{{ $b->status }}">
                    <div class="b-info">
                        <div class="b-header">
                            <h4 class="b-id">Booking #{{ $b->id }}</h4>
                            <span class="status-badge badge-{{ $b->status }}">
                                {{ str_replace('_', ' ', $b->status) }}
                            </span>
                        </div>
                        
                        <div class="b-details-grid">
                            <div class="b-detail-item">
                                <span class="b-detail-label">Date</span>
                                <span class="b-detail-val">{{ $startAt->format('d M Y') }}</span>
                            </div>
                            <div class="b-detail-item">
                                <span class="b-detail-label">Time (UK)</span>
                                <span class="b-detail-val">{{ $startAt->format('h:i A') }}</span>
                            </div>
                            <div class="b-detail-item">
                                <span class="b-detail-label">Duration</span>
                                <span class="b-detail-val">{{ $b->duration_hours }} Hours</span>
                            </div>
                            @if($b->status === 'confirmed' && $startAt->isFuture())
                            <div class="b-detail-item">
                                <span class="b-detail-label">Starts in (UK)</span>
                                <span class="b-detail-val">
                                    @if($hoursUntilStart >= 24)
                                        {{ floor($hoursUntilStart) }} hrs
                                    @elseif($hoursUntilStart > 0)
                                        {{ max(1, (int) round($hoursUntilStart)) }} hrs
                                    @else
                                        Soon
                                    @endif
                                </span>
                            </div>
                            @endif
                            <div class="b-detail-item">
                                <span class="b-detail-label">Chairs</span>
                                <span class="b-detail-val">
                                    @if($b->chairs->isEmpty())
                                        Pending
                                    @else
                                        {{ $b->chairs->pluck('name')->join(', ') }}
                                    @endif
                                </span>
                            </div>
                            @if($b->setup_type && $b->setup_type !== 'any')
                            <div class="b-detail-item">
                                <span class="b-detail-label">Setup</span>
                                <span class="b-detail-val">{{ $b->setup_type === 'makeup' ? 'Make-up Chair' : 'Hair Stylist Chair' }}</span>
                            </div>
                            @endif
                            @if($b->coupon_code)
                            <div class="b-detail-item" style="grid-column: span 2;">
                                <span class="b-detail-label">Discount Applied</span>
                                <span class="b-detail-val text-success" style="color: #2e7d32; font-weight: 700;">
                                    {{ $b->coupon_code }} (-£{{ number_format($b->discount_amount, 2) }})
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="b-actions">
                        @if($b->status === 'pending_payment')
                            @if($b->expires_at)
                                <div style="font-size: 0.85rem; color: #d32f2f; margin-bottom: 0.5rem; text-align: center;">
                                    Expires in <span class="stylist-timer" style="font-weight:bold;" data-expires="{{ \Carbon\Carbon::parse($b->expires_at)->toIso8601String() }}">--:--</span>
                                </div>
                            @endif
                            <a href="{{ route('stylist.bookings.pay', $b->id) }}" class="btn-pay">
                                Pay £{{ number_format($b->total_amount, 2) }}
                            </a>
                        @endif
                        @if($b->status === 'confirmed' && !$canManage)
                            <button class="btn-outline btn-disabled" disabled>Paid & Confirmed</button>
                            <p class="policy-note">
                                @if($startAt->isFuture())
                                    Starts in ~{{ max(1, (int) round($hoursUntilStart)) }} hrs — cancel/refund only when more than 24 hrs before start.
                                @else
                                    This booking has already started — cancellation is not available.
                                @endif
                                <a href="https://eladeuk.com/bookings-and-cancellation-policy" target="_blank" rel="noopener" style="color:inherit; text-decoration:underline;">Policy</a>
                            </p>
                        @elseif($b->status === 'confirmed')
                            <button class="btn-outline btn-disabled" disabled>Paid & Confirmed</button>
                        @endif
                        @if($b->status === 'pending_approval' && !$canManage)
                            <button class="btn-outline btn-disabled" disabled>Awaiting Admin</button>
                        @endif
                        @if($b->status === 'cancelled' || $b->status === 'cancelled_late_response')
                            <button class="btn-outline btn-disabled" disabled>Cancelled</button>
                            @if($b->refunded_at && (float) $b->refunded_amount > 0)
                                <p class="policy-note" style="color:#2e7d32;">
                                    Refund £{{ number_format((float) $b->refunded_amount, 2) }} issued
                                    @if($b->refund_status)
                                        ({{ $b->refund_status }})
                                    @endif
                                </p>
                            @elseif($b->refund_status === 'failed' || $b->refund_status === 'missing_payment')
                                <p class="policy-note" style="color:#c62828;">Refund pending — contact studio with #{{ $b->id }}</p>
                            @endif
                        @endif

                        @if($canAmend)
                            <a href="{{ route('stylist.amend_booking', $b->id) }}" class="btn-amend-booking">Amend Booking</a>
                        @endif

                        @if($canManage)
                            <form action="{{ route('stylist.cancel_booking', $b->id) }}" method="POST" style="margin:0;"
                                  class="cancel-booking-form"
                                  data-refund-eligible="{{ ($b->status === 'confirmed' && (float) $b->total_amount > 0) ? '1' : '0' }}"
                                  data-refund-amount="{{ number_format((float) $b->total_amount, 2, '.', '') }}">
                                @csrf
                                <button type="submit" class="btn-outline btn-cancel-booking">Cancel Booking</button>
                            </form>
                            @if($b->status === 'confirmed')
                                <p class="policy-note">
                                    Cancel 24h+ before start for a full refund.
                                    <a href="https://eladeuk.com/bookings-and-cancellation-policy" target="_blank" rel="noopener" style="color:inherit; text-decoration:underline;">Booking &amp; Cancellation Policy</a>
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.cancel-booking-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const refundEligible = form.getAttribute('data-refund-eligible') === '1';
                const refundAmount = form.getAttribute('data-refund-amount') || '0.00';
                const text = refundEligible
                    ? 'Cancel with 24h+ notice: a full refund of £' + refundAmount + ' will be returned to your original payment method (bank timing may vary). Package hours will also be restored if used.'
                    : 'This cannot be undone. Package hours (if used) will be restored.';
                const doSubmit = function() { form.submit(); };
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Cancel this booking?',
                        text: text,
                        type: 'warning',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#461111',
                        cancelButtonColor: '#eae2d5',
                        confirmButtonText: refundEligible ? 'Cancel & refund' : 'Yes, cancel it',
                        cancelButtonText: 'Keep booking'
                    }).then(function(result) {
                        if (result.value || result.isConfirmed) doSubmit();
                    });
                } else if (confirm(text)) {
                    doSubmit();
                }
            });
        });

        const timers = document.querySelectorAll('.stylist-timer');
        if (timers.length > 0) {
            setInterval(() => {
                const now = new Date().getTime();
                timers.forEach(timer => {
                    const expiresAt = new Date(timer.getAttribute('data-expires')).getTime();
                    const distance = expiresAt - now;
                    
                    if (distance <= 0) {
                        timer.innerHTML = "Expired";
                        timer.parentElement.style.color = "#8a7d72";
                    } else {
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        timer.innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                    }
                });
            }, 1000);
        }
    });
</script>
@endsection
