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
            <a href="{{ ($canJump && ($num < $step || ($num === 1) || $selectedChair)) ? route('stylist.book', ['step' => $num]) : 'javascript:void(0)' }}"
               class="step-item {{ $isActive ? 'active' : '' }} {{ $isDone ? 'done' : '' }}">
                <div class="step-circle">
                    @if($isDone)<i class="fe fe-check" style="font-size:0.85rem;"></i>@else{{ $num }}@endif
                </div>
                <div class="step-label">{{ $info['label'] }}</div>
                @if($isDone && $num === 1 && $selectedChair)<span class="step-edit">Edit</span>@endif
                @if($isDone && $num === 2 && $selectedPricing)<span class="step-edit">Edit</span>@endif
            </a>
        @endforeach
    </div>
</div>

<main class="app-main">
    <h1 class="step-heading">{{ $steps[$step]['title'] }}</h1>

    {{-- Step 1: Chairs (default) --}}
    @if($step === 1)
        @if($chairs->isEmpty())
            <div class="empty-chairs">
                <i class="fe fe-grid d-block mb-2" style="font-size:2rem;color:var(--app-accent);"></i>
                <p class="mb-0">No chairs registered yet. Add chairs in admin.</p>
            </div>
        @else
            <form id="chair-form" method="POST" action="{{ route('stylist.book.chair') }}">
                @csrf
                <div class="chair-grid">
                    @foreach($chairs as $index => $chair)
                        @php
                            $isAvailable = $chair->status === 'available';
                            $hasPricing = $chair->price_hourly || $chair->price_daily || $chair->price_monthly || $chair->price_yearly;
                        @endphp
                        <label class="chair-option {{ $isAvailable ? '' : 'is-unavailable' }}">
                            <input type="radio" name="chair_id" value="{{ $chair->id }}"
                                {{ !$isAvailable ? 'disabled' : '' }}
                                {{ $isAvailable && (int) old('chair_id', $selectedChair?->id) === (int) $chair->id ? 'checked' : '' }}>
                            <div class="chair-tile">
                                <span class="chair-num">{{ $index + 1 }}</span>
                                <span class="chair-name">{{ $chair->name }}</span>
                                <span class="chair-type-tag">{{ $chair->type ?? 'Chair' }}</span>
                                <span class="chair-status-tag {{ $isAvailable ? 'available' : 'booked' }}">{{ $isAvailable ? 'Available' : 'Booked' }}</span>
                                @if($hasPricing)
                                    <span class="chair-price-hint-tile">Pricing set</span>
                                @else
                                    <span class="chair-price-hint-tile">No pricing yet</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
                @if(!$chairs->contains(fn ($c) => $c->status === 'available'))
                    <p class="text-center mt-3 mb-0" style="font-size:0.78rem;color:var(--app-muted);">All chairs are currently booked.</p>
                @endif
            </form>
        @endif
    @endif

    @if($step >= 2 && $selectedChair)
        <div class="summary-card">
            <h4>Selected chair</h4>
            <div class="summary-line"><span>Chair</span><span>{{ $selectedChair->name }}</span></div>
            <div class="summary-line"><span>Type</span><span>{{ $selectedChair->type ?? 'N/A' }}</span></div>
            @if($selectedPricingOption)
                <div class="summary-line"><span>Pricing</span><span>{{ $selectedPricingOption['label'] }} — £{{ number_format($selectedPricingOption['price'], 2) }}</span></div>
            @endif
        </div>
    @endif

    @if($step === 2)
        @if(empty($pricingOptions))
            <div class="empty-chairs">
                <i class="fe fe-dollar-sign d-block mb-2" style="font-size:2rem;color:var(--app-accent);"></i>
                <p class="mb-0">No pricing configured for <strong>{{ $selectedChair->name }}</strong>.<br>Please set prices in admin Pricing page.</p>
            </div>
        @else
            <p class="text-center mb-3" style="font-size:0.8rem;color:var(--app-muted);">Rates from studio pricing setup for this chair</p>
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

    @if($step === 3)
        <div class="coming-card">
            <i class="fe fe-clock d-block mb-2" style="font-size:1.75rem;color:var(--app-accent);"></i>
            <p class="mb-0 fw-semibold">Date & time — coming soon</p>
            <p class="mb-0 small mt-2" style="color:var(--app-muted);">Your chair and {{ $selectedPricingOption['label'] ?? 'pricing' }} plan (£{{ number_format(session('stylist_booking.pricing_amount', 0), 2) }}) are saved.</p>
        </div>
    @endif

    {{-- Step 4: Details at confirmation --}}
    @if($step === 4)
        @if($selectedChair && $selectedPricingOption)
        <div class="summary-card mb-3">
            <h4>Booking summary</h4>
            <div class="summary-line"><span>Chair</span><span>{{ $selectedChair->name }}</span></div>
            <div class="summary-line"><span>Plan</span><span>{{ $selectedPricingOption['label'] }}</span></div>
            <div class="summary-line"><span>Total rate</span><span>£{{ number_format($selectedPricingOption['price'], 2) }}</span></div>
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
</main>

<nav class="app-footer-nav">
    @if($step > 1)
        <a href="{{ route('stylist.book', ['step' => $step - 1]) }}" class="btn-app btn-app-back">Back</a>
    @endif

    @if($step === 1)
        <button type="submit" form="chair-form" class="btn-app btn-app-next" id="chair-next-btn" {{ $chairs->isEmpty() || !$chairs->contains(fn ($c) => $c->status === 'available') ? 'disabled' : '' }}>Next</button>
    @elseif($step === 2)
        <button type="submit" form="pricing-form" class="btn-app btn-app-next" {{ empty($pricingOptions) ? 'disabled' : '' }}>Next</button>
    @elseif($step < 4)
        <a href="{{ route('stylist.book', ['step' => $step + 1]) }}" class="btn-app btn-app-next">Next</a>
    @else
        <button type="submit" form="confirm-form" class="btn-app btn-app-next">Confirm</button>
    @endif
</nav>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.chair-option input:not(:disabled)').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const btn = document.getElementById('chair-next-btn');
            if (btn) btn.removeAttribute('disabled');
        });
    });
</script>
@endsection
