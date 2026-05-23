@extends('layouts.stylist-app')

@section('title', 'Book Workspace')

@section('css')
<style>
    :root {
        --app-bg: #fdf8f6;
        --app-surface: #ffffff;
        --app-accent: #d4a088;
        --app-accent-dark: #c4896e;
        --app-accent-soft: #f5e6df;
        --app-text: #2a2420;
        --app-muted: #8a7d72;
        --app-line: #efe4dc;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: 'Montserrat', sans-serif;
        background: var(--app-bg);
        color: var(--app-text);
        min-height: 100vh;
        padding-bottom: 88px;
    }

    .top-profile-bar {
        background: var(--app-surface);
        border-bottom: 1px solid var(--app-line);
        padding: 0.85rem 1.25rem;
    }

    .top-profile-inner {
        max-width: 720px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .profile-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        min-width: 0;
        flex: 1;
    }

    .profile-avatar-sm {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--app-accent-soft);
        flex-shrink: 0;
    }

    .profile-text h3 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-text p {
        margin: 0.15rem 0 0;
        font-size: 0.72rem;
        color: var(--app-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-badge-sm {
        display: inline-block;
        margin-top: 0.25rem;
        font-size: 0.58rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-accent-dark);
        background: var(--app-accent-soft);
        padding: 0.15rem 0.45rem;
        border-radius: 3px;
    }

    .btn-logout {
        flex-shrink: 0;
        height: 40px;
        padding: 0 1rem;
        border: 1px solid var(--app-line);
        background: #fff;
        color: var(--app-text);
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s;
    }

    .btn-logout:hover {
        border-color: var(--app-accent);
        color: var(--app-accent-dark);
    }

    .btn-signin-link {
        flex-shrink: 0;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-accent-dark);
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--app-accent-soft);
        border-radius: 6px;
        background: var(--app-accent-soft);
    }

    .app-brand-strip {
        text-align: center;
        padding: 0.65rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--app-muted);
        background: var(--app-bg);
        border-bottom: 1px solid var(--app-line);
    }

    .alert-success-app {
        max-width: 720px;
        margin: 1rem auto 0;
        padding: 0.85rem 1.25rem;
        background: #e8f5e9;
        border: 1px solid #c8e6c9;
        color: #2e7d32;
        font-size: 0.82rem;
        border-radius: 8px;
    }

    .stepper-wrap {
        background: var(--app-surface);
        padding: 1rem 1rem 0.5rem;
        border-bottom: 1px solid var(--app-line);
        overflow-x: auto;
    }

    .stepper {
        display: flex;
        align-items: flex-start;
        min-width: 520px;
        max-width: 720px;
        margin: 0 auto;
        position: relative;
        padding: 0 0.25rem;
    }

    .stepper::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 30px;
        right: 30px;
        height: 2px;
        background: var(--app-line);
        z-index: 1;
    }

    .step-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--app-line);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--app-muted);
        margin-bottom: 0.4rem;
        transition: all 0.3s;
    }

    .step-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--app-muted);
        transition: color 0.3s;
    }

    .step-item.active .step-circle {
        border-color: var(--app-accent);
        background: var(--app-accent);
        color: #fff;
    }

    .step-item.active .step-label {
        color: var(--app-text);
    }

    .step-item.done .step-circle {
        border-color: var(--app-accent);
        color: var(--app-accent);
    }

    .app-main {
        max-width: 720px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
    }

    .step-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 1.5rem;
        letter-spacing: -0.5px;
    }

    /* ===== DETAILS FORM ===== */
    .details-form {
        background: var(--app-surface);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--app-line);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .hint {
        font-size: 0.8rem;
        color: var(--app-muted);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .form-field { margin-bottom: 1.2rem; }
    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    .form-field label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.4rem;
        color: var(--app-muted);
    }

    .form-field input {
        width: 100%;
        height: 48px;
        padding: 0 0.85rem;
        border: 1.5px solid var(--app-line);
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.95rem;
        background: #fff;
        color: var(--app-text);
        transition: border-color 0.2s;
    }

    .form-field input:focus {
        outline: none;
        border-color: var(--app-accent);
    }

    /* ===== FOOTER NAV ===== */
    .app-footer-nav {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: var(--app-surface);
        border-top: 1px solid var(--app-line);
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.03);
    }

    .btn-app {
        height: 48px;
        padding: 0 1.5rem;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
    }

    .btn-app-back {
        background: #fff;
        border: 1px solid var(--app-line);
        color: var(--app-muted);
    }

    .btn-app-back:hover {
        background: #fdfdfd;
        color: var(--app-text);
        border-color: #dcd0c8;
    }

    .btn-app-next {
        background: var(--app-accent);
        color: #fff;
        box-shadow: 0 4px 12px rgba(212,160,136,0.3);
    }

    .btn-app-next:hover:not(:disabled) {
        background: var(--app-accent-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(212,160,136,0.4);
    }

    .btn-app-next:disabled {
        background: var(--app-line);
        color: #a09791;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    /* ===== SUMMARY CARD ===== */
    .summary-card {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        padding: 1.25rem;
    }

    .summary-card h4 {
        margin: 0 0 1rem;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        padding: 0.65rem 0;
        border-bottom: 1px solid var(--app-line);
        font-size: 0.85rem;
    }

    .summary-line:last-child { border-bottom: none; padding-bottom: 0; }
    .summary-line span:first-child { color: var(--app-muted); font-weight: 600; }
    .summary-line span:last-child { text-align: right; }

    .mb-3 { margin-bottom: 1.5rem; }

    .alert-error-app {
        max-width: 720px;
        margin: 1rem auto 0;
        padding: 0.85rem 1.25rem;
        background: #ffebee;
        border: 1px solid #ffcdd2;
        color: #c62828;
        font-size: 0.82rem;
        border-radius: 8px;
    }

    /* ===== TOTAL AMOUNT HIGHLIGHT ===== */
    .total-highlight {
        background: linear-gradient(135deg, var(--app-accent) 0%, var(--app-accent-dark) 100%);
        border-radius: 12px;
        padding: 1.1rem 1.3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 16px rgba(212,160,136,0.25);
    }
    .total-highlight-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.85);
    }
    .total-highlight-amount {
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
    }

    /* ===== STRIPE PAYMENT FORM ===== */
    .stripe-card-wrap {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .stripe-card-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-muted);
        margin-bottom: 0.6rem;
        display: block;
    }
    .stripe-input {
        padding: 0.7rem 0.85rem;
        border: 1.5px solid var(--app-line);
        border-radius: 8px;
        background: #fff;
        transition: border-color 0.2s;
    }
    .stripe-input.StripeElement--focus {
        border-color: var(--app-accent);
    }
    .stripe-input.StripeElement--invalid {
        border-color: #e53935;
    }
    .stripe-row {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    .stripe-field {
        flex: 1;
    }
    #stripe-error-msg {
        color: #c62828;
        font-size: 0.78rem;
        margin-top: 0.5rem;
        min-height: 1.2rem;
    }
    .stripe-secure-badge {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.65rem;
        color: var(--app-muted);
        margin-top: 0.6rem;
    }
    .stripe-secure-badge svg {
        width: 14px; height: 14px; flex-shrink: 0;
    }
    .btn-pay {
        width: 100%;
        height: 52px;
        background: linear-gradient(135deg, var(--app-accent) 0%, var(--app-accent-dark) 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 1px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: opacity 0.2s, transform 0.15s;
        margin-top: 1rem;
        text-transform: uppercase;
    }
    .btn-pay:hover:not(:disabled) { opacity: 0.9; transform: translateY(-1px); }
    .btn-pay:disabled { opacity: 0.55; cursor: not-allowed; }
    .pay-spinner {
        display: none;
        width: 18px; height: 18px;
        border: 2.5px solid rgba(255,255,255,0.35);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ===== CONFIRMED CARD ===== */
    .confirmed-icon {
        width: 64px; height: 64px;
        background: #e8f5e9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
    }
    .confirmed-icon svg { width: 32px; height: 32px; color: #2e7d32; }

    /* ===== NEW CALENDAR & DURATION STEP 1 ===== */
    .schedule-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 650px) { .schedule-layout { grid-template-columns: 1fr; } }
    .schedule-panel {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid var(--app-line);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .schedule-panel-title {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-accent-dark);
        margin-bottom: 1rem;
        border-bottom: 1.5px solid var(--app-line);
        padding-bottom: 0.5rem;
    }

    .cal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem; }
    .cal-nav-btn {
        background: none; border: 1px solid var(--app-line);
        width: 32px; height: 32px; border-radius: 6px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: var(--app-muted); transition: all 0.2s;
    }
    .cal-nav-btn:hover { border-color: var(--app-accent); color: var(--app-text); }
    .cal-month-label { font-size: 0.85rem; font-weight: 700; color: var(--app-text); text-transform: uppercase; letter-spacing: 1px; }
    .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
    .cal-day-name { text-align: center; font-size: 0.65rem; font-weight: 700; color: var(--app-muted); padding-bottom: 0.5rem; }
    .cal-day {
        aspect-ratio: 1; border: 1px solid transparent; background: transparent;
        font-size: 0.8rem; font-weight: 600; color: var(--app-text);
        border-radius: 6px; cursor: pointer; transition: all 0.2s;
        font-family: inherit; display:flex; align-items:center; justify-content:center;
    }
    .cal-day:hover:not(.cal-day-disabled) { border-color: var(--app-line); background: #f9f9f9; }
    .cal-day-disabled { color: #dcd0c8; cursor: not-allowed; }
    .cal-day-today { font-weight: 800; color: var(--app-accent-dark); }
    .cal-day-selected { background: var(--app-accent) !important; color: #fff !important; border-color: var(--app-accent) !important; box-shadow: 0 4px 10px rgba(212,160,136,0.3); }

    .slots-heading { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--app-muted); margin-bottom: 0.75rem; }
    .slots-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; max-height: 250px; overflow-y: auto; padding-right: 4px; }
    .slot-btn {
        padding: 0.6rem 0; border: 1px solid var(--app-line); background: #fff;
        border-radius: 6px; font-size: 0.75rem; font-weight: 600; color: var(--app-text);
        cursor: pointer; transition: all 0.2s; font-family: inherit;
    }
    .slot-btn:hover { border-color: var(--app-accent); color: var(--app-accent-dark); }
    .slot-selected { background: var(--app-accent-soft); border-color: var(--app-accent); color: var(--app-accent-dark); font-weight: 700; }

    /* Duration Stepper */
    .duration-control {
        display: flex; align-items: center; justify-content: center; gap: 1rem;
        background: #fdfdfd; border: 1px solid var(--app-line); padding: 1rem; border-radius: 8px; margin-top: 1rem;
    }
    .dur-btn {
        width: 40px; height: 40px; border-radius: 8px;
        background: #fff; border: 1px solid var(--app-line);
        font-size: 1.2rem; font-weight: bold; color: var(--app-text);
        cursor: pointer; transition: all 0.2s;
    }
    .dur-btn:hover { border-color: var(--app-accent); }
    .dur-val { font-size: 1.5rem; font-weight: 800; width: 60px; text-align: center; }

    /* Availability Options UI */
    .av-card {
        background: #fff; border: 2px solid var(--app-accent); border-radius: 12px;
        padding: 1.5rem; text-align: center; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(212,160,136,0.15);
    }
    .av-icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .av-title { font-size: 1.2rem; font-weight: 700; margin: 0 0 0.5rem; color: var(--app-text); }
    .av-desc { font-size: 0.9rem; color: var(--app-muted); line-height: 1.5; margin-bottom: 1.5rem; }

</style>
@endsection

@section('content')

{{-- TOP PROFILE BAR --}}
<div class="top-profile-bar">
    <div class="top-profile-inner">
        <div class="profile-info">
            <img src="https://images.unsplash.com/photo-1580618672591-eb180b1a973f?w=150" alt="Salon" class="profile-avatar-sm">
            <div class="profile-text">
                <h3>The Studio London</h3>
                <p>Premium Workspaces</p>
            </div>
        </div>
        @if($user)
            <div style="display:flex; gap:0.5rem; align-items:center;">
                <a href="{{ route('stylist.my_bookings') }}" class="btn-logout" style="text-decoration:none;">
                    My Bookings
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-signin-link">Sign in</a>
        @endif
    </div>
</div>

{{-- STEPPER --}}
<div class="stepper-wrap">
    <div class="stepper">
        @foreach($steps as $num => $s)
            <div class="step-item {{ $step == $num ? 'active' : '' }} {{ $step > $num ? 'done' : '' }}">
                <div class="step-circle">
                    @if($step > $num) ✓ @else {{ $num }} @endif
                </div>
                <div class="step-label">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>
</div>

<main class="app-main">
    @if(session('booking_error'))
        <div class="alert-error-app">{{ session('booking_error') }}</div>
    @endif
    @if(session('booking_success'))
        <div class="alert-success-app">{{ session('booking_success') }}</div>
    @endif

    <h2 class="step-title">{{ $steps[$step]['title'] }}</h2>

    @if($step === 1)
        <form method="POST" action="{{ route('stylist.book.time') }}" id="schedule-form">
            @csrf
            <input type="hidden" name="start_date" id="hidden-start-date" value="{{ session('stylist_booking.start_date') }}">
            <input type="hidden" name="start_time" id="hidden-start-time" value="{{ session('stylist_booking.start_time') }}">
            <input type="hidden" name="duration"   id="hidden-duration"   value="{{ session('stylist_booking.duration', 2) }}">

            <div class="schedule-layout">
                <div class="schedule-panel">
                    <div class="schedule-panel-title">1. Select Date</div>
                    <div class="cal-header">
                        <button type="button" class="cal-nav-btn" id="s-cal-prev">&#8249;</button>
                        <span class="cal-month-label" id="s-cal-label">...</span>
                        <button type="button" class="cal-nav-btn" id="s-cal-next">&#8250;</button>
                    </div>
                    <div class="cal-grid" id="s-cal-grid"></div>
                </div>

                <div class="schedule-panel">
                    <div class="schedule-panel-title">2. Select Start Time</div>
                    <div class="slots-grid" id="s-slots-grid"></div>

                    <div class="schedule-panel-title" style="margin-top:2rem;">3. Duration (Hours)</div>
                    <div class="duration-control">
                        <button type="button" class="dur-btn" id="dur-minus">&minus;</button>
                        <div class="dur-val" id="dur-display">{{ session('stylist_booking.duration', 2) }}</div>
                        <button type="button" class="dur-btn" id="dur-plus">&plus;</button>
                    </div>
                    <p style="text-align:center;font-size:0.75rem;color:var(--app-muted);margin-top:0.5rem;">Minimum 2 hours</p>
                </div>
            </div>
        </form>
    @endif

    @if($step === 2)
        @if(isset($availabilityState) && $availabilityState['status'] === 'alternative_time')
            <div class="av-card">
                <div class="av-icon">🕒</div>
                <h3 class="av-title">Selected time is fully booked</h3>
                <p class="av-desc">
                    We don't have any chairs available for your selected time. 
                    However, the next available slot is at:
                    <br><br>
                    <strong>{{ \Carbon\Carbon::parse($availabilityState['alternative_start'])->format('l, j M Y @ H:i') }}</strong>
                </p>
                <form method="POST" action="{{ route('stylist.book.availability.confirm') }}">
                    @csrf
                    <input type="hidden" name="action" value="accept_alternative">
                    <button type="submit" class="btn-app btn-app-next" style="width:100%;margin-bottom:1rem;">Accept new time</button>
                    <button type="submit" name="action" value="cancel" class="btn-app btn-app-back" style="width:100%;">Cancel & Pick another date</button>
                </form>
            </div>
        @elseif(isset($availabilityState) && $availabilityState['status'] === 'multi_chair')
            <div class="av-card">
                <div class="av-icon">🪑</div>
                <h3 class="av-title">Multi-Chair Booking</h3>
                <p class="av-desc">
                    A single chair is not available for your entire {{ session('stylist_booking.duration') }}-hour duration. 
                    However, we can accommodate you by having you switch chairs midway through your booking.
                </p>
                <form method="POST" action="{{ route('stylist.book.availability.confirm') }}">
                    @csrf
                    <input type="hidden" name="action" value="accept_multi_chair">
                    <button type="submit" class="btn-app btn-app-next" style="width:100%;margin-bottom:1rem;">I agree to switch chairs</button>
                    <button type="submit" name="action" value="cancel" class="btn-app btn-app-back" style="width:100%;">No, let me pick another time</button>
                </form>
            </div>
        @else
            <div class="av-card">
                <div class="av-icon">❌</div>
                <h3 class="av-title">Unavailable</h3>
                <p class="av-desc">We are fully booked for the foreseeable future from this start date.</p>
                <a href="{{ route('stylist.book', ['step' => 1]) }}" class="btn-app btn-app-back">Go back</a>
            </div>
        @endif
    @endif

    @if($step === 3)
        <div class="summary-card mb-3">
            <h4>Booking recap</h4>
            <div class="summary-line"><span>Start</span><span>{{ \Carbon\Carbon::parse(session('stylist_booking.start_date'))->format('D d M Y') }} &bull; {{ \Carbon\Carbon::parse(session('stylist_booking.start_time'))->format('h:i A') }}</span></div>
            <div class="summary-line"><span>Duration</span><span>{{ session('stylist_booking.duration') }} hours</span></div>
            @if($isOvernight)
                <div class="summary-line" style="border:none;margin-top:0.5rem;color:#d84315;">
                    <span style="font-size:0.8rem;line-height:1.4;">🌙 Your booking falls between 9 PM and 8 AM. This requires admin approval.</span>
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('stylist.book.details') }}" class="details-form" id="confirm-form">
            @csrf
            <p class="hint">Enter your details to complete booking. Your account will be created if you are new.</p>

            <div class="form-field">
                <label for="name">Full name *</label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $user?->name ?? ($guestDetails['name'] ?? '')) }}">
            </div>
            <div class="form-field">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" required
                    value="{{ old('email', $user?->email ?? ($guestDetails['email'] ?? '')) }}">
            </div>
            <div class="form-field">
                <label for="mobile">Mobile</label>
                <input type="text" name="mobile" id="mobile"
                    value="{{ old('mobile', $user?->mobile ?? ($guestDetails['mobile'] ?? '')) }}">
            </div>
            <div class="row-2">
                <div class="form-field">
                    <label for="password">{{ $user ? 'New password (optional)' : 'Password *' }}</label>
                    <input type="password" name="password" id="password" {{ $user ? '' : 'required' }} minlength="6" placeholder="Min. 6 characters">
                </div>
                <div class="form-field">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" {{ $user ? '' : 'required' }} minlength="6">
                </div>
            </div>
        </form>
    @endif

    @if($step === 4)
        <div class="total-highlight">
            <span class="total-highlight-label">Amount due</span>
            <span class="total-highlight-amount">£{{ number_format($computedTotal, 2) }}</span>
        </div>

        <div class="stripe-card-wrap">
            <div class="stripe-field">
                <span class="stripe-card-label">Card Number</span>
                <div id="stripe-card-number" class="stripe-input"></div>
            </div>
            <div class="stripe-row">
                <div class="stripe-field">
                    <span class="stripe-card-label">Expiry Date</span>
                    <div id="stripe-card-expiry" class="stripe-input"></div>
                </div>
                <div class="stripe-field">
                    <span class="stripe-card-label">CVC</span>
                    <div id="stripe-card-cvc" class="stripe-input"></div>
                </div>
            </div>
            <div id="stripe-error-msg"></div>
            <div class="stripe-secure-badge">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Secured by Stripe &mdash; we never store your card details
            </div>
        </div>

        <button id="pay-btn" class="btn-pay" type="button">
            <span class="pay-spinner" id="pay-spinner"></span>
            <span id="pay-btn-text">Pay £{{ number_format($computedTotal, 2) }}</span>
        </button>
    @endif

    @if($step === 5)
        <div class="confirmed-icon">
            @if(session('stylist_booking.availability_state.status') === 'pending_approval' || $isOvernight)
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#f57c00;width:32px;height:32px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#2e7d32;width:32px;height:32px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            @endif
        </div>
        <div class="summary-card mb-3">
            @if($isOvernight)
                <h4 style="text-align:center;color:#f57c00;">Pending Approval</h4>
                <p style="text-align:center;font-size:0.9rem;margin-bottom:1.5rem;">Your requested overnight booking has been submitted for admin approval. You will receive an email once approved.</p>
            @else
                <h4 style="text-align:center;">Booking confirmed!</h4>
            @endif
            
            <div class="summary-line"><span>Start</span><span>{{ \Carbon\Carbon::parse(session('stylist_booking.start_date'))->format('D d M Y') }} &bull; {{ \Carbon\Carbon::parse(session('stylist_booking.start_time'))->format('h:i A') }}</span></div>
            <div class="summary-line"><span>Duration</span><span>{{ session('stylist_booking.duration') }} hours</span></div>
            @if(!$isOvernight)
                <div class="summary-line"><span>Amount paid</span><span><strong>£{{ number_format($computedTotal, 2) }}</strong></span></div>
            @endif
        </div>
        <div style="text-align:center;margin-top:1.5rem;display:flex;justify-content:center;gap:1rem;">
            @auth
                <a href="{{ route('stylist.my_bookings') }}" class="btn-app btn-app-next" style="min-width:180px;text-decoration:none;">View My Bookings</a>
            @endauth
            <form method="POST" action="{{ route('stylist.book.reset') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-app btn-app-back" style="min-width:180px;">Make another booking</button>
            </form>
        </div>
    @endif
</main>

<nav class="app-footer-nav">
    @if($step > 1 && $step < 4)
        <a href="{{ route('stylist.book', ['step' => $step - 1]) }}" class="btn-app btn-app-back">Back</a>
    @endif

    @if($step === 1)
        <button type="submit" form="schedule-form" class="btn-app btn-app-next">Next &rarr;</button>
    @elseif($step === 3)
        <button type="submit" form="confirm-form" class="btn-app btn-app-next">
            {{ $isOvernight ? 'Submit for Approval' : 'Next &rarr; Payment' }}
        </button>
    @endif
</nav>
@endsection

@section('scripts')
@if($step === 1)
<script>
(function () {
    const today = new Date(); today.setHours(0,0,0,0);
    
    let sDate = document.getElementById('hidden-start-date').value || null;
    let sTime = document.getElementById('hidden-start-time').value || null;
    let duration = parseInt(document.getElementById('hidden-duration').value || 2);
    
    let sYear, sMonth;
    if (sDate) { const d=new Date(sDate); sYear=d.getFullYear(); sMonth=d.getMonth(); }
    else { sYear=today.getFullYear(); sMonth=today.getMonth(); }

    const ALL_SLOTS = [];
    for (let h = 0; h < 24; h++) {
        for (const m of ['00','30']) {
            const suffix   = h < 12 ? 'AM' : 'PM';
            const hDisplay = h === 0 ? 12 : (h > 12 ? h - 12 : h);
            ALL_SLOTS.push({
                label: `${String(hDisplay).padStart(2,'0')}:${m} ${suffix}`,
                value: `${String(h).padStart(2,'0')}:${m}`
            });
        }
    }

    const MONTH_NAMES = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    const DAY_NAMES   = ['Su','Mo','Tu','We','Th','Fr','Sa'];

    function renderCal() {
        const gridEl = document.getElementById('s-cal-grid');
        gridEl.innerHTML = '';
        document.getElementById('s-cal-label').textContent = `${MONTH_NAMES[sMonth]} ${sYear}`;

        DAY_NAMES.forEach(d => {
            const el = document.createElement('div'); el.className = 'cal-day-name'; el.textContent = d;
            gridEl.appendChild(el);
        });

        const firstDay = new Date(sYear, sMonth, 1).getDay();
        const daysInMonth = new Date(sYear, sMonth + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            const e = document.createElement('div'); e.className = 'cal-day cal-day-empty'; gridEl.appendChild(e);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const cur = new Date(sYear, sMonth, d); cur.setHours(0,0,0,0);
            const isPast = cur < today;
            const ds = `${sYear}-${String(sMonth+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const isSel = sDate === ds;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cal-day' + (isPast ? ' cal-day-disabled' : '') + (isSel ? ' cal-day-selected' : '');
            btn.textContent = d;
            if (!isPast) {
                btn.addEventListener('click', () => { sDate = ds; document.getElementById('hidden-start-date').value = ds; renderCal(); renderSlots(); });
            }
            gridEl.appendChild(btn);
        }
    }

    function renderSlots() {
        const gridEl = document.getElementById('s-slots-grid');
        gridEl.innerHTML = '';
        if (!sDate) {
            const p = document.createElement('p'); p.style.cssText = 'color:var(--app-muted);font-size:0.75rem;grid-column:1/-1;text-align:center;margin:1rem 0;';
            p.textContent = 'Pick a date first'; gridEl.appendChild(p);
            return;
        }
        ALL_SLOTS.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'slot-btn' + (sTime === slot.value ? ' slot-selected' : '');
            btn.textContent = slot.label;
            btn.addEventListener('click', () => { sTime = slot.value; document.getElementById('hidden-start-time').value = slot.value; renderSlots(); });
            gridEl.appendChild(btn);
        });
    }

    document.getElementById('s-cal-prev').addEventListener('click', () => {
        sMonth--; if (sMonth < 0) { sMonth = 11; sYear--; }
        const minM = today.getFullYear() * 12 + today.getMonth();
        if (sYear * 12 + sMonth < minM) return;
        renderCal();
    });
    document.getElementById('s-cal-next').addEventListener('click', () => {
        sMonth++; if (sMonth > 11) { sMonth = 0; sYear++; }
        renderCal();
    });

    document.getElementById('dur-minus').addEventListener('click', () => {
        if (duration > 2) { duration--; document.getElementById('dur-display').textContent = duration; document.getElementById('hidden-duration').value = duration; }
    });
    document.getElementById('dur-plus').addEventListener('click', () => {
        duration++; document.getElementById('dur-display').textContent = duration; document.getElementById('hidden-duration').value = duration;
    });

    document.getElementById('schedule-form').addEventListener('submit', function(ev) {
        if (!sDate || !sTime) { ev.preventDefault(); alert('Please select a start date and time.'); }
    });

    renderCal(); renderSlots();
})();
</script>
@endif

{{-- ===== STRIPE PAYMENT (Step 4 only) ===== --}}
@if(isset($step) && $step === 4)
<script src="https://js.stripe.com/v3/"></script>
<script>
(function() {
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();

    const cardStyle = {
        base: { fontFamily: "'Montserrat', sans-serif", fontSize: '15px', color: '#2a2420', '::placeholder': { color: '#b0a49e' } },
        invalid: { color: '#c62828' },
    };

    const cardNumber = elements.create('cardNumber', { style: cardStyle }); cardNumber.mount('#stripe-card-number');
    const cardExpiry = elements.create('cardExpiry', { style: cardStyle }); cardExpiry.mount('#stripe-card-expiry');
    const cardCvc = elements.create('cardCvc', { style: cardStyle }); cardCvc.mount('#stripe-card-cvc');

    const displayError = document.getElementById('stripe-error-msg');
    const handleChange = (e) => { displayError.textContent = e.error ? e.error.message : ''; };

    cardNumber.on('change', handleChange);
    cardExpiry.on('change', handleChange);
    cardCvc.on('change', handleChange);

    const payBtn = document.getElementById('pay-btn');
    const paySpinner = document.getElementById('pay-spinner');
    const payText = document.getElementById('pay-btn-text');

    payBtn.addEventListener('click', async function() {
        payBtn.disabled = true; paySpinner.style.display = 'block'; payText.textContent = 'Processing…';
        try {
            const intentRes = await fetch('{{ route("stylist.book.payment.intent") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({}),
            });
            const intentData = await intentRes.json();
            if (intentData.error) throw new Error(intentData.error);

            const { error, paymentIntent } = await stripe.confirmCardPayment(intentData.clientSecret, {
                payment_method: { card: cardNumber },
            });
            if (error) throw new Error(error.message);

            if (paymentIntent.status === 'succeeded') {
                window.location.href = '{{ route("stylist.book.payment.success") }}';
            }
        } catch(err) {
            displayError.textContent = err.message || 'Payment failed. Please try again.';
            payBtn.disabled = false; paySpinner.style.display = 'none';
            payText.textContent = 'Pay £{{ number_format($computedTotal, 2) }}';
        }
    });
})();
</script>
@endif
@endsection
