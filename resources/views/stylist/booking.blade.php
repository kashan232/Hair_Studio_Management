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
        min-width: 420px;
        max-width: 720px;
        margin: 0 auto;
        position: relative;
        padding: 0 0.25rem;
    }

    .stepper::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: var(--app-line);
        z-index: 0;
    }

    .stepper-progress {
        position: absolute;
        top: 14px;
        left: 10%;
        height: 2px;
        background: var(--app-accent);
        z-index: 1;
        transition: width 0.3s ease;
    }

    .step-item {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 2;
        text-decoration: none;
        color: inherit;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--app-surface);
        border: 2px solid var(--app-line);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--app-muted);
        margin: 0 auto 0.4rem;
    }

    .step-item.done .step-circle,
    .step-item.active .step-circle {
        border-color: var(--app-accent);
        background: var(--app-accent);
        color: #fff;
    }

    .step-item.done .step-circle {
        background: var(--app-surface);
        color: var(--app-accent-dark);
    }

    .step-label {
        font-size: 0.62rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--app-muted);
    }

    .step-item.active .step-label { color: var(--app-text); }

    .step-edit {
        display: block;
        font-size: 0.58rem;
        color: var(--app-accent-dark);
        margin-top: 2px;
        text-decoration: underline;
    }

    .app-main {
        max-width: 720px;
        margin: 0 auto;
        padding: 1.25rem 1.25rem 2rem;
    }

    .step-heading {
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-align: center;
        margin: 0 0 1.25rem;
    }

    .chair-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .chair-option { position: relative; cursor: pointer; }
    .chair-option input { position: absolute; opacity: 0; pointer-events: none; }

    .chair-tile {
        aspect-ratio: 1;
        background: var(--app-accent-soft);
        border: 2px solid transparent;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        text-align: center;
        transition: all 0.2s;
    }

    .chair-option input:checked + .chair-tile {
        background: var(--app-accent);
        border-color: var(--app-accent-dark);
        color: #fff;
    }

    .chair-tile .chair-num { font-size: 1.5rem; font-weight: 700; }
    .chair-tile .chair-name {
        font-size: 0.58rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 0.35rem;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .chair-type-tag { font-size: 0.55rem; margin-top: 0.2rem; opacity: 0.8; }

    .chair-status-tag {
        font-size: 0.5rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 0.25rem;
        padding: 0.1rem 0.35rem;
        border-radius: 3px;
    }

    .chair-status-tag.available { background: #e8f5e9; color: #2e7d32; }
    .chair-status-tag.booked { background: #ffebee; color: #c62828; }

    .chair-option.is-unavailable { cursor: not-allowed; opacity: 0.55; }
    .chair-option.is-unavailable .chair-tile { background: #f0f0f0; }

    .chair-price-hint-tile {
        font-size: 0.5rem;
        margin-top: 0.2rem;
        opacity: 0.75;
        line-height: 1.2;
    }

    .empty-chairs, .coming-card, .summary-card {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        color: var(--app-muted);
    }

    .summary-card { text-align: left; margin-bottom: 1rem; }
    .summary-card h4 {
        margin: 0 0 0.75rem;
        font-size: 0.72rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--app-muted);
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        padding: 0.45rem 0;
        font-size: 0.85rem;
        border-bottom: 1px solid var(--app-line);
    }

    .summary-line:last-child { border-bottom: none; }

    .details-form .form-field {
        margin-bottom: 1.1rem;
    }

    .details-form label {
        display: block;
        font-size: 0.68rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-muted);
        margin-bottom: 0.35rem;
    }

    .details-form input {
        width: 100%;
        height: 46px;
        border: 1px solid var(--app-line);
        border-radius: 6px;
        padding: 0 0.85rem;
        font-size: 0.88rem;
        background: #fff;
        color: var(--app-text);
    }

    .details-form input:focus {
        outline: none;
        border-color: var(--app-accent);
    }

    .details-form .hint {
        font-size: 0.72rem;
        color: var(--app-muted);
        margin: -0.5rem 0 1rem;
    }

    .details-form .row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .app-footer-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--app-surface);
        border-top: 1px solid var(--app-line);
        padding: 0.85rem 1.25rem;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        z-index: 100;
    }

    .btn-app {
        min-width: 110px;
        height: 48px;
        border: none;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-app-back { background: var(--app-accent-soft); color: var(--app-accent-dark); }
    .btn-app-next { background: var(--app-accent); color: #fff; }
    .btn-app:disabled { opacity: 0.45; cursor: not-allowed; }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .pricing-option { position: relative; cursor: pointer; }
    .pricing-option input { position: absolute; opacity: 0; pointer-events: none; }

    .pricing-tile {
        background: var(--app-surface);
        border: 2px solid var(--app-line);
        border-radius: 10px;
        padding: 1.1rem 0.85rem;
        text-align: center;
        transition: all 0.2s;
        min-height: 110px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pricing-option input:checked + .pricing-tile {
        border-color: var(--app-accent-dark);
        background: var(--app-accent);
        color: #fff;
    }

    .pricing-tile .pricing-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .pricing-tile .pricing-amount {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0.35rem 0 0.2rem;
    }

    .pricing-tile .pricing-sub {
        font-size: 0.65rem;
        opacity: 0.85;
    }

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

    /* ===== CALENDAR STEP 2 ===== */
    .datetime-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    .cal-card, .slots-card {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 14px;
        padding: 1.25rem;
    }

    .cal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .cal-nav-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: var(--app-accent-soft);
        color: var(--app-accent-dark);
        border-radius: 50%;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .cal-nav-btn:hover { background: var(--app-accent); color: #fff; }

    .cal-month-label {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-text);
    }

    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
    }

    .cal-day-name {
        text-align: center;
        font-size: 0.55rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--app-muted);
        padding: 0.3rem 0;
    }

    .cal-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        border: none;
        background: transparent;
        color: var(--app-text);
    }

    .cal-day:hover:not(.cal-day-disabled):not(.cal-day-empty) {
        background: var(--app-accent-soft);
        color: var(--app-accent-dark);
    }

    .cal-day.cal-day-selected {
        background: var(--app-accent);
        color: #fff;
    }

    .cal-day.cal-day-today {
        border: 2px solid var(--app-accent);
        color: var(--app-accent-dark);
    }

    .cal-day.cal-day-today.cal-day-selected {
        background: var(--app-accent);
        color: #fff;
    }

    .cal-day.cal-day-disabled {
        color: #ddd;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .cal-day.cal-day-empty { cursor: default; }

    /* Time slots */
    .slots-heading {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-muted);
        margin-bottom: 0.75rem;
    }

    .slots-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.45rem;
        max-height: 260px;
        overflow-y: auto;
    }

    .slot-btn {
        padding: 0.4rem 0;
        font-size: 0.68rem;
        font-weight: 600;
        border: 1px solid var(--app-line);
        border-radius: 6px;
        background: #fff;
        color: var(--app-text);
        cursor: pointer;
        transition: all 0.15s;
        text-align: center;
    }

    .slot-btn:hover:not(.slot-unavail) {
        border-color: var(--app-accent);
        color: var(--app-accent-dark);
        background: var(--app-accent-soft);
    }

    .slot-btn.slot-selected {
        background: var(--app-accent);
        border-color: var(--app-accent-dark);
        color: #fff;
    }

    .slot-btn.slot-unavail {
        background: #f5f5f5;
        color: #bbb;
        cursor: not-allowed;
        text-decoration: line-through;
        font-size: 0.6rem;
    }

    /* Price summary strip */
    .price-strip {
        margin-top: 1.25rem;
        padding: 1rem 1.25rem;
        background: var(--app-surface);
        border: 2px solid var(--app-accent-soft);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .price-strip-meta {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .price-strip-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-muted);
    }

    .price-strip-duration {
        font-size: 0.75rem;
        color: var(--app-text);
        font-weight: 500;
    }

    .price-strip-amount {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--app-accent-dark);
        white-space: nowrap;
    }

    /* datetime two-panel layout */
    .dt-panels {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .dt-panel {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 14px;
        padding: 1rem;
    }

    .dt-panel-title {
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--app-accent-dark);
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .dt-panel-title::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--app-accent);
    }

    .date-confirm-label {
        font-size: 0.7rem;
        text-align: center;
        margin-top: 0.5rem;
        color: var(--app-accent-dark);
        font-weight: 600;
        min-height: 1.1rem;
    }

    @media (max-width: 620px) {
        .dt-panels { grid-template-columns: 1fr; }
        .slots-grid { grid-template-columns: repeat(3, 1fr); max-height: 160px; }
    }

    @media (max-width: 480px) {
        .pricing-grid { grid-template-columns: 1fr; }
        .chair-grid { grid-template-columns: repeat(2, 1fr); }
        .details-form .row-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    $progressPercent = $step <= 1 ? 0 : (($step - 1) / 3) * 80;
    $displayName = $user?->name ?? ($guestDetails['name'] ?? 'Guest');
    $displayEmail = $user?->email ?? ($guestDetails['email'] ?? 'Details at confirmation');
    $avatarUrl = $user?->avatar
        ? (str_starts_with($user->avatar, 'http') ? $user->avatar : asset($user->avatar))
        : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150';
@endphp

{{-- Profile bar (always on top) --}}
<div class="top-profile-bar">
    <div class="top-profile-inner">
        <div class="profile-info">
            <img src="{{ $avatarUrl }}" alt="" class="profile-avatar-sm">
            <div class="profile-text">
                <h3>{{ $displayName }}</h3>
                <p>{{ $displayEmail }}</p>
                @if($user)
                    <span class="profile-badge-sm">Hairstylist</span>
                @else
                    <span class="profile-badge-sm">Guest booking</span>
                @endif
            </div>
        </div>
        @auth
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fe fe-log-out"></i> Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-signin-link">Sign in</a>
        @endauth
    </div>
</div>

<div class="app-brand-strip">Eladé Studio</div>

@if(session('booking_success'))
    <div class="alert-success-app mx-3">{{ session('booking_success') }}</div>
@endif
@if(session('booking_error'))
    <div class="alert-error-app mx-3">{{ session('booking_error') }}</div>
@endif

<div class="stepper-wrap">
    <div class="stepper">
        <div class="stepper-progress" style="width: {{ $progressPercent }}%;"></div>
        @foreach($steps as $num => $info)
            @php
                $isActive = $num === $step;
                $isDone = $num < $step;
                $canJump = $num <= $step || ($num === 1);
            @endphp
            <a href="{{ ($canJump && ($num < $step || $num === 1)) ? route('stylist.book', ['step' => $num]) : 'javascript:void(0)' }}"
               class="step-item {{ $isActive ? 'active' : '' }} {{ $isDone ? 'done' : '' }}">
                <div class="step-circle">
                    @if($isDone)<i class="fe fe-check" style="font-size:0.85rem;"></i>@else{{ $num }}@endif
                </div>
                <div class="step-label">{{ $info['label'] }}</div>
            </a>
        @endforeach
    </div>
</div>

<main class="app-main">
    <h1 class="step-heading">{{ $steps[$step]['title'] }}</h1>

    @if($step === 1)
        @if(empty($pricingOptions))
            <div class="empty-chairs">
                <i class="fe fe-dollar-sign d-block mb-2" style="font-size:2rem;color:var(--app-accent);"></i>
                <p class="mb-0">No pricing configured. Please set prices in admin.</p>
            </div>
        @else
            <p class="text-center mb-3" style="font-size:0.8rem;color:var(--app-muted);">Select a pricing plan</p>
            <form id="pricing-form" method="POST" action="{{ route('stylist.book.pricing') }}">
                @csrf
                <div class="pricing-grid">
                    @foreach($pricingOptions as $option)
                        <label class="pricing-option">
                            <input type="radio" name="pricing_type" value="{{ $option['key'] }}"
                                {{ old('pricing_type', $selectedPricing) === $option['key'] ? 'checked' : '' }} required>
                            <div class="pricing-tile">
                                <span class="pricing-label">{{ $option['label'] }}</span>
                                <span class="pricing-amount">£{{ number_format($option['price'], 2) }}</span>
                                <span class="pricing-sub">{{ $option['subtitle'] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </form>
        @endif
    @endif

    @if($step === 2)
        @php
            $isHourly  = $selectedPricingOption && $selectedPricingOption['key'] === 'hourly';
            $isDaily   = $selectedPricingOption && $selectedPricingOption['key'] === 'daily';
            $isWeekly  = $selectedPricingOption && $selectedPricingOption['key'] === 'weekly';
            $isMonthly = $selectedPricingOption && $selectedPricingOption['key'] === 'monthly';
            $unitPrice = $selectedPricingOption['price'] ?? 0;
            $savedStartDate = old('start_date', session('stylist_booking.start_date') ?? '');
            $savedStartTime = old('start_time', session('stylist_booking.start_time') ?? '');
            $savedEndDate   = old('end_date',   session('stylist_booking.end_date')   ?? '');
            $savedEndTime   = old('end_time',   session('stylist_booking.end_time')   ?? '');
        @endphp

        <form method="POST" action="{{ route('stylist.book.time') }}" id="time-form">
            @csrf
            <input type="hidden" name="start_date" id="hidden-start-date" value="{{ $savedStartDate }}">
            <input type="hidden" name="start_time" id="hidden-start-time" value="{{ $savedStartTime }}">
            <input type="hidden" name="end_date"   id="hidden-end-date"   value="{{ $savedEndDate }}">
            <input type="hidden" name="end_time"   id="hidden-end-time"   value="{{ $savedEndTime }}">
        </form>

        <div class="dt-panels">

            {{-- START block --}}
            <div class="dt-panel">
                <div class="dt-panel-title">Start</div>

                {{-- Start calendar --}}
                <div class="cal-header">
                    <button type="button" class="cal-nav-btn" id="s-cal-prev">&#8249;</button>
                    <span class="cal-month-label" id="s-cal-label">...</span>
                    <button type="button" class="cal-nav-btn" id="s-cal-next">&#8250;</button>
                </div>
                <div class="cal-grid" id="s-cal-grid"></div>
                <div class="date-confirm-label" id="s-date-label">
                    {{ $savedStartDate ? \Carbon\Carbon::parse($savedStartDate)->format('D, d M Y') : 'Select start date' }}
                </div>

                {{-- Start time slots --}}
                <div class="slots-heading" style="margin-top:1rem;">Start time</div>
                <div class="slots-grid" id="s-slots-grid"></div>
            </div>

            {{-- END block --}}
            <div class="dt-panel">
                <div class="dt-panel-title">End</div>

                {{-- End calendar --}}
                <div class="cal-header">
                    <button type="button" class="cal-nav-btn" id="e-cal-prev">&#8249;</button>
                    <span class="cal-month-label" id="e-cal-label">...</span>
                    <button type="button" class="cal-nav-btn" id="e-cal-next">&#8250;</button>
                </div>
                <div class="cal-grid" id="e-cal-grid"></div>
                <div class="date-confirm-label" id="e-date-label">
                    {{ $savedEndDate ? \Carbon\Carbon::parse($savedEndDate)->format('D, d M Y') : 'Select end date' }}
                </div>

                {{-- End time slots --}}
                <div class="slots-heading" style="margin-top:1rem;">End time</div>
                <div class="slots-grid" id="e-slots-grid"></div>
            </div>

        </div>

        {{-- Price strip --}}
        <div class="price-strip">
            <div class="price-strip-meta">
                <span class="price-strip-label">Total amount</span>
                <span class="price-strip-duration" id="duration-label">—</span>
            </div>
            <span class="price-strip-amount" id="price-display">£{{ number_format($unitPrice, 2) }}</span>
        </div>
    @endif

    @if($step === 3)
        @if($selectedPricingOption)
        <div class="summary-card mb-3">
            <h4>Booking summary</h4>
            @if($selectedPricingOption)
                <div class="summary-line"><span>Plan</span><span>{{ $selectedPricingOption['label'] }}</span></div>
                <div class="summary-line"><span>Rate</span><span>£{{ number_format($selectedPricingOption['price'], 2) }}</span></div>
            @endif
            @if(session('stylist_booking.start_date'))
                <div class="summary-line"><span>Start</span><span>{{ \Carbon\Carbon::parse(session('stylist_booking.start_date'))->format('D d M Y') }} @ {{ session('stylist_booking.start_time') }}</span></div>
                <div class="summary-line"><span>End</span><span>{{ \Carbon\Carbon::parse(session('stylist_booking.end_date'))->format('D d M Y') }} @ {{ session('stylist_booking.end_time') }}</span></div>
            @endif
        </div>
        @endif
        <form method="POST" action="{{ route('stylist.book.confirm') }}" class="details-form" id="confirm-form">
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
        <div class="summary-card mb-3">
            <h4>Booking confirmed!</h4>
            @if($assignedChair)
                <div class="summary-line"><span>Chair</span><span>{{ $assignedChair->name }}</span></div>
            @endif
            @if($selectedPricingOption)
                <div class="summary-line"><span>Plan</span><span>{{ $selectedPricingOption['label'] }}</span></div>
                <div class="summary-line"><span>Rate</span><span>£{{ number_format($selectedPricingOption['price'], 2) }}</span></div>
            @endif
            @if(session('stylist_booking.start_date'))
                <div class="summary-line"><span>Start</span><span>{{ \Carbon\Carbon::parse(session('stylist_booking.start_date'))->format('D d M Y') }} @ {{ session('stylist_booking.start_time') }}</span></div>
                <div class="summary-line"><span>End</span><span>{{ \Carbon\Carbon::parse(session('stylist_booking.end_date'))->format('D d M Y') }} @ {{ session('stylist_booking.end_time') }}</span></div>
            @endif
        </div>
    @endif
</main>

<nav class="app-footer-nav">
    @if($step > 1)
        <a href="{{ route('stylist.book', ['step' => $step - 1]) }}" class="btn-app btn-app-back">Back</a>
    @endif

    @if($step === 1)
        <button type="submit" form="pricing-form" class="btn-app btn-app-next" {{ empty($pricingOptions) ? 'disabled' : '' }}>Next</button>
    @elseif($step === 2)
        <button type="submit" form="time-form" class="btn-app btn-app-next">Next</button>
    @elseif($step === 3)
        <button type="submit" form="confirm-form" class="btn-app btn-app-next">Confirm</button>
    @endif
</nav>
@endsection

@section('scripts')
<script>
(function () {
    if (!document.getElementById('time-form')) return;

    /* ============================================================
       CONFIG
    ============================================================ */
    const PRICING_TYPE = '{{ $selectedPricingOption["key"] ?? "" }}';
    const UNIT_PRICE   = {{ $unitPrice ?? 0 }};

    /* ============================================================
       STATE
    ============================================================ */
    const today = new Date(); today.setHours(0,0,0,0);

    // Start
    let sDate = '{{ $savedStartDate ?? "" }}' || null;
    let sTime = '{{ $savedStartTime ?? "" }}' || null;
    let sYear, sMonth;
    if (sDate) { const d=new Date(sDate); sYear=d.getFullYear(); sMonth=d.getMonth(); }
    else { sYear=today.getFullYear(); sMonth=today.getMonth(); }

    // End
    let eDate = '{{ $savedEndDate ?? "" }}' || null;
    let eTime = '{{ $savedEndTime ?? "" }}' || null;
    let eYear, eMonth;
    if (eDate) { const d=new Date(eDate); eYear=d.getFullYear(); eMonth=d.getMonth(); }
    else { eYear=today.getFullYear(); eMonth=today.getMonth(); }

    /* ============================================================
       SLOTS (9 AM – 8:30 PM every 30 min)
    ============================================================ */
    const ALL_SLOTS = [];
    for (let h = 9; h < 21; h++) {
        for (const m of ['00','30']) {
            const suffix   = h < 12 ? 'AM' : 'PM';
            const hDisplay = h > 12 ? h - 12 : h;
            ALL_SLOTS.push({
                label: `${String(hDisplay).padStart(2,'0')}:${m} ${suffix}`,
                value: `${String(h).padStart(2,'0')}:${m}`
            });
        }
    }

    /* ============================================================
       CALENDAR RENDERER
       id     = element id prefix  (s- or e-)
       selDate = currently selected date string
       onPick = callback(dateStr)
    ============================================================ */
    const MONTH_NAMES = ['January','February','March','April','May','June',
                         'July','August','September','October','November','December'];
    const DAY_NAMES   = ['Su','Mo','Tu','We','Th','Fr','Sa'];

    function renderCal(gridEl, labelEl, year, month, selDate, minDate, onPick) {
        gridEl.innerHTML = '';
        labelEl.textContent = `${MONTH_NAMES[month]} ${year}`;

        DAY_NAMES.forEach(d => {
            const el = document.createElement('div');
            el.className = 'cal-day-name';
            el.textContent = d;
            gridEl.appendChild(el);
        });

        const firstDay    = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            const e = document.createElement('div');
            e.className = 'cal-day cal-day-empty';
            gridEl.appendChild(e);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const cur = new Date(year, month, d); cur.setHours(0,0,0,0);
            const min = minDate ? new Date(minDate) : today; min.setHours(0,0,0,0);
            const isPast     = cur < min;
            const isToday    = cur.getTime() === today.getTime();
            const ds         = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const isSel      = selDate === ds;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cal-day'
                + (isPast  ? ' cal-day-disabled' : '')
                + (isToday ? ' cal-day-today'    : '')
                + (isSel   ? ' cal-day-selected' : '');
            btn.textContent = d;
            if (!isPast) btn.addEventListener('click', () => onPick(ds, cur));
            gridEl.appendChild(btn);
        }
    }

    /* ============================================================
       SLOT RENDERER
    ============================================================ */
    function renderSlots(gridEl, selTime, enabled, onPick) {
        gridEl.innerHTML = '';
        if (!enabled) {
            const p = document.createElement('p');
            p.style.cssText = 'color:var(--app-muted);font-size:0.72rem;grid-column:1/-1;text-align:center;margin:0.75rem 0;';
            p.textContent = 'Pick a date first';
            gridEl.appendChild(p);
            return;
        }
        ALL_SLOTS.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'slot-btn' + (selTime === slot.value ? ' slot-selected' : '');
            btn.textContent = slot.label;
            btn.addEventListener('click', () => onPick(slot.value));
            gridEl.appendChild(btn);
        });
    }

    /* ============================================================
       PRICE CALCULATION
    ============================================================ */
    function calcTotal() {
        if (!sDate || !sTime || !eDate || !eTime) return null;

        const start = new Date(`${sDate}T${sTime}:00`);
        const end   = new Date(`${eDate}T${eTime}:00`);
        if (end <= start) return null;

        const diffMs   = end - start;
        const diffHrs  = diffMs / 3_600_000;
        const diffDays = diffMs / 86_400_000;

        let total = 0;
        let durationText = '';

        if (PRICING_TYPE === 'hourly') {
            total = UNIT_PRICE * diffHrs;
            durationText = `${diffHrs.toFixed(1)} hour${diffHrs !== 1 ? 's' : ''} × £${UNIT_PRICE.toFixed(2)}/hr`;
        } else if (PRICING_TYPE === 'daily') {
            const days = Math.ceil(diffDays);
            total = UNIT_PRICE * days;
            durationText = `${days} day${days !== 1 ? 's' : ''} × £${UNIT_PRICE.toFixed(2)}/day`;
        } else if (PRICING_TYPE === 'weekly') {
            const weeks = Math.ceil(diffDays / 7);
            total = UNIT_PRICE * weeks;
            durationText = `${weeks} week${weeks !== 1 ? 's' : ''} × £${UNIT_PRICE.toFixed(2)}/wk`;
        } else if (PRICING_TYPE === 'monthly') {
            const months = Math.ceil(diffDays / 30);
            total = UNIT_PRICE * months;
            durationText = `${months} month${months !== 1 ? 's' : ''} × £${UNIT_PRICE.toFixed(2)}/mo`;
        } else {
            total = UNIT_PRICE;
            durationText = '';
        }

        return { total, durationText };
    }

    function updatePrice() {
        const priceEl    = document.getElementById('price-display');
        const durationEl = document.getElementById('duration-label');
        const result = calcTotal();
        if (result) {
            priceEl.textContent    = '£' + result.total.toFixed(2);
            durationEl.textContent = result.durationText;
        } else {
            priceEl.textContent    = '£' + UNIT_PRICE.toFixed(2);
            durationEl.textContent = sDate && sTime && eDate && eTime ? '⚠ End must be after start' : '—';
        }
    }

    /* ============================================================
       RENDER ALL
    ============================================================ */
    function renderAll() {
        // Start calendar
        renderCal(
            document.getElementById('s-cal-grid'),
            document.getElementById('s-cal-label'),
            sYear, sMonth, sDate, null,
            (ds, dateObj) => {
                sDate = ds;
                sTime = null;
                document.getElementById('hidden-start-date').value = ds;
                document.getElementById('hidden-start-time').value = '';
                document.getElementById('s-date-label').textContent =
                    dateObj.toLocaleDateString('en-GB', {weekday:'short',day:'numeric',month:'short',year:'numeric'});
                // End date must not be before start date
                if (eDate && eDate < sDate) { eDate = null; eTime = null;
                    document.getElementById('hidden-end-date').value = '';
                    document.getElementById('hidden-end-time').value = '';
                    document.getElementById('e-date-label').textContent = 'Select end date';
                }
                renderAll(); updatePrice();
            }
        );

        // End calendar (min = start date)
        renderCal(
            document.getElementById('e-cal-grid'),
            document.getElementById('e-cal-label'),
            eYear, eMonth, eDate, sDate || null,
            (ds, dateObj) => {
                eDate = ds;
                eTime = null;
                document.getElementById('hidden-end-date').value = ds;
                document.getElementById('hidden-end-time').value = '';
                document.getElementById('e-date-label').textContent =
                    dateObj.toLocaleDateString('en-GB', {weekday:'short',day:'numeric',month:'short',year:'numeric'});
                renderAll(); updatePrice();
            }
        );

        // Start slots
        renderSlots(
            document.getElementById('s-slots-grid'),
            sTime, !!sDate,
            (val) => {
                sTime = val;
                document.getElementById('hidden-start-time').value = val;
                renderAll(); updatePrice();
            }
        );

        // End slots
        renderSlots(
            document.getElementById('e-slots-grid'),
            eTime, !!eDate,
            (val) => {
                eTime = val;
                document.getElementById('hidden-end-time').value = val;
                renderAll(); updatePrice();
            }
        );
    }

    /* ============================================================
       NAVIGATION BUTTONS
    ============================================================ */
    function navHandler(prevId, nextId, getYM, setYM) {
        document.getElementById(prevId).addEventListener('click', () => {
            let [y, m] = getYM();
            m--; if (m < 0) { m = 11; y--; }
            const minM = today.getFullYear() * 12 + today.getMonth();
            if (y * 12 + m < minM) return;
            setYM(y, m); renderAll();
        });
        document.getElementById(nextId).addEventListener('click', () => {
            let [y, m] = getYM();
            m++; if (m > 11) { m = 0; y++; }
            setYM(y, m); renderAll();
        });
    }

    navHandler('s-cal-prev','s-cal-next', () => [sYear,sMonth], (y,m) => { sYear=y; sMonth=m; });
    navHandler('e-cal-prev','e-cal-next', () => [eYear,eMonth], (y,m) => { eYear=y; eMonth=m; });

    /* ============================================================
       FORM SUBMIT VALIDATION
    ============================================================ */
    document.getElementById('time-form').addEventListener('submit', function(ev) {
        if (!sDate || !sTime) { ev.preventDefault(); alert('Please select a start date and time.'); return; }
        if (!eDate || !eTime) { ev.preventDefault(); alert('Please select an end date and time.');   return; }
        const s = new Date(`${sDate}T${sTime}:00`);
        const e = new Date(`${eDate}T${eTime}:00`);
        if (e <= s) { ev.preventDefault(); alert('End must be after start.'); }
    });

    /* ============================================================
       INIT
    ============================================================ */
    renderAll();
    updatePrice();

    // Restore labels if values were saved
    if (sDate) {
        const [y,m,d] = sDate.split('-');
        document.getElementById('s-date-label').textContent =
            new Date(y, m-1, d).toLocaleDateString('en-GB', {weekday:'short',day:'numeric',month:'short',year:'numeric'});
    }
    if (eDate) {
        const [y,m,d] = eDate.split('-');
        document.getElementById('e-date-label').textContent =
            new Date(y, m-1, d).toLocaleDateString('en-GB', {weekday:'short',day:'numeric',month:'short',year:'numeric'});
    }
})();
</script>
@endsection
