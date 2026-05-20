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
        --app-gold: #c6a34d;
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

    .app-header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: var(--app-surface);
        border-bottom: 1px solid var(--app-line);
        padding: 0.85rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .app-header .brand {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--app-text);
        text-decoration: none;
    }

    .header-icon-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: var(--app-accent-soft);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--app-accent-dark);
        text-decoration: none;
        cursor: pointer;
        font-size: 1.1rem;
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
        position: relative;
        padding: 0 0.25rem;
    }

    .stepper::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 8%;
        right: 8%;
        height: 2px;
        background: var(--app-line);
        z-index: 0;
    }

    .stepper-progress {
        position: absolute;
        top: 14px;
        left: 8%;
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
        padding: 1.5rem 1.25rem 2rem;
    }

    .location-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: var(--app-muted);
        margin-bottom: 1rem;
    }

    .step-heading {
        font-size: 1.35rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-align: center;
        margin: 0 0 1.5rem;
        line-height: 1.35;
    }

    /* Profile card */
    .profile-card {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--app-accent-soft);
    }

    .profile-meta h3 {
        margin: 0 0 0.25rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .profile-meta p {
        margin: 0.15rem 0;
        font-size: 0.82rem;
        color: var(--app-muted);
    }

    .profile-badge {
        display: inline-block;
        margin-top: 0.5rem;
        padding: 0.25rem 0.6rem;
        background: var(--app-accent-soft);
        color: var(--app-accent-dark);
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-radius: 4px;
    }

    .detail-list {
        margin-top: 1.25rem;
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        overflow: hidden;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.9rem 1rem;
        border-bottom: 1px solid var(--app-line);
        font-size: 0.85rem;
    }

    .detail-row:last-child { border-bottom: none; }
    .detail-row span:first-child { color: var(--app-muted); font-weight: 500; }

    /* Chair grid */
    .chair-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .chair-option {
        position: relative;
        cursor: pointer;
    }

    .chair-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

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

    .chair-tile .chair-num {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .chair-tile .chair-name {
        font-size: 0.58rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 0.35rem;
        opacity: 0.85;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .chair-option input:checked + .chair-tile .chair-name { opacity: 1; }

    .chair-type-tag {
        font-size: 0.55rem;
        margin-top: 0.2rem;
        opacity: 0.75;
    }

    .chair-price-hint {
        text-align: center;
        font-size: 0.72rem;
        color: var(--app-muted);
        margin-top: 1rem;
    }

    .empty-chairs {
        text-align: center;
        padding: 2.5rem 1rem;
        background: var(--app-surface);
        border: 1px dashed var(--app-line);
        border-radius: 12px;
        color: var(--app-muted);
    }

    .coming-card {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .coming-card i {
        font-size: 2rem;
        color: var(--app-accent);
        margin-bottom: 0.75rem;
    }

    .summary-card {
        background: var(--app-surface);
        border: 1px solid var(--app-line);
        border-radius: 12px;
        padding: 1.25rem;
    }

    .summary-card h4 {
        margin: 0 0 1rem;
        font-size: 0.75rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--app-muted);
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.88rem;
        border-bottom: 1px solid var(--app-line);
    }

    .summary-line:last-child { border-bottom: none; font-weight: 600; }

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
        transition: all 0.2s;
    }

    .btn-app-back {
        background: var(--app-accent-soft);
        color: var(--app-accent-dark);
    }

    .btn-app-next {
        background: var(--app-accent);
        color: #fff;
    }

    .btn-app-next:hover { background: var(--app-accent-dark); }
    .btn-app:disabled { opacity: 0.45; cursor: not-allowed; }

    @media (max-width: 400px) {
        .chair-grid { grid-template-columns: repeat(2, 1fr); }
        .stepper { min-width: 100%; }
    }
</style>
@endsection

@section('content')
@php
    $progressPercent = (($step - 1) / 4) * 84;
@endphp

<header class="app-header">
    <span style="width:40px;"></span>
    <a href="{{ route('stylist.book') }}" class="brand">Eladé Studio</a>
    <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="header-icon-btn" title="Logout">
            @if($user->avatar)
                <img src="{{ str_starts_with($user->avatar, 'http') ? $user->avatar : asset($user->avatar) }}" alt="" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
            @else
                <i class="fe fe-user"></i>
            @endif
        </button>
    </form>
</header>

<div class="stepper-wrap">
    <div class="stepper">
        <div class="stepper-progress" style="width: {{ $progressPercent }}%;"></div>
        @foreach($steps as $num => $info)
            @php
                $isActive = $num === $step;
                $isDone = $num < $step;
                $canJump = $num <= $step || ($num === 2 && $step >= 2);
            @endphp
            <a href="{{ $canJump ? route('stylist.book', ['step' => $num]) : 'javascript:void(0)' }}"
               class="step-item {{ $isActive ? 'active' : '' }} {{ $isDone ? 'done' : '' }}">
                <div class="step-circle">
                    @if($isDone)
                        <i class="fe fe-check" style="font-size:0.85rem;"></i>
                    @else
                        {{ $num }}
                    @endif
                </div>
                <div class="step-label">{{ $info['label'] }}</div>
                @if($isDone && $num === 2 && $selectedChair)
                    <span class="step-edit">Edit</span>
                @endif
            </a>
        @endforeach
    </div>
</div>

<main class="app-main">
    <div class="location-pill">
        <i class="fe fe-map-pin"></i>
        <span>Eladé Studio — Workspace Booking</span>
    </div>

    <h1 class="step-heading">{{ $steps[$step]['title'] }}</h1>

    {{-- Step 1: Profile --}}
    @if($step === 1)
        <div class="profile-card">
            <img src="{{ $user->avatar && str_starts_with($user->avatar, 'http') ? $user->avatar : asset($user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150') }}"
                 alt="{{ $user->name }}" class="profile-avatar">
            <div class="profile-meta">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                @if($user->mobile)
                    <p>{{ $user->mobile }}</p>
                @endif
                <span class="profile-badge">Hairstylist</span>
            </div>
        </div>

        <div class="detail-list">
            <div class="detail-row"><span>Designation</span><span>{{ $user->designation ?? 'Hairstylist' }}</span></div>
            <div class="detail-row"><span>Member since</span><span>{{ $user->joining_date ? \Carbon\Carbon::parse($user->joining_date)->format('d M Y') : '—' }}</span></div>
            <div class="detail-row"><span>Account status</span><span>{{ (int) $user->status === 1 ? 'Active' : 'Inactive' }}</span></div>
            @if($user->specialization)
                <div class="detail-row"><span>Specialization</span><span>{{ $user->specialization }}</span></div>
            @endif
        </div>
    @endif

    {{-- Step 2: Chairs --}}
    @if($step === 2)
        @if($chairs->isEmpty())
            <div class="empty-chairs">
                <i class="fe fe-grid d-block mb-2" style="font-size:2rem;color:var(--app-accent);"></i>
                <p class="mb-0">No chairs available right now.<br>Please check back later.</p>
            </div>
        @else
            <form id="chair-form" method="POST" action="{{ route('stylist.book.chair') }}">
                @csrf
                <div class="chair-grid">
                    @foreach($chairs as $index => $chair)
                        <label class="chair-option">
                            <input type="radio" name="chair_id" value="{{ $chair->id }}"
                                {{ (int) old('chair_id', $selectedChair?->id) === (int) $chair->id ? 'checked' : '' }}
                                required>
                            <div class="chair-tile">
                                <span class="chair-num">{{ $index + 1 }}</span>
                                <span class="chair-name">{{ $chair->name }}</span>
                                <span class="chair-type-tag">{{ $chair->type ?? 'Chair' }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <p class="chair-price-hint">Select a chair to continue. Pricing shown on next steps.</p>
            </form>
        @endif
    @endif

    {{-- Step 3–5 placeholders --}}
    @if($step >= 3)
        <div class="summary-card mb-3">
            <h4>Selected chair</h4>
            <div class="summary-line">
                <span>Chair</span>
                <span>{{ $selectedChair->name }} ({{ $selectedChair->type ?? 'N/A' }})</span>
            </div>
            @if($selectedChair->price_hourly)
                <div class="summary-line"><span>Hourly</span><span>€{{ number_format($selectedChair->price_hourly, 2) }}</span></div>
            @endif
            @if($selectedChair->price_daily)
                <div class="summary-line"><span>Daily</span><span>€{{ number_format($selectedChair->price_daily, 2) }}</span></div>
            @endif
            @if($selectedChair->price_monthly)
                <div class="summary-line"><span>Monthly</span><span>€{{ number_format($selectedChair->price_monthly, 2) }}</span></div>
            @endif
        </div>

        <div class="coming-card">
            <i class="fe fe-clock d-block"></i>
            <p class="mb-1 fw-semibold">{{ $steps[$step]['label'] }} — coming soon</p>
            <p class="mb-0 small text-muted">Your chair is saved. Full booking flow will be added next.</p>
        </div>
    @endif
</main>

<nav class="app-footer-nav">
    @if($step > 1)
        <a href="{{ route('stylist.book', ['step' => $step - 1]) }}" class="btn-app btn-app-back">Back</a>
    @endif

    @if($step === 1)
        <a href="{{ route('stylist.book', ['step' => 2]) }}" class="btn-app btn-app-next">Next</a>
    @elseif($step === 2)
        <button type="submit" form="chair-form" class="btn-app btn-app-next" {{ $chairs->isEmpty() ? 'disabled' : '' }}>Next</button>
    @elseif($step < 5)
        <a href="{{ route('stylist.book', ['step' => $step + 1]) }}" class="btn-app btn-app-next">Next</a>
    @else
        <form action="{{ route('stylist.book.reset') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn-app btn-app-next">Finish</button>
        </form>
    @endif
</nav>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.chair-option input').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.chair-tile').forEach(function (t) { t.style.transform = ''; });
            if (this.checked) {
                this.nextElementSibling.style.transform = 'scale(1.02)';
            }
        });
    });
</script>
@endsection
