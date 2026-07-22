@extends('layouts.stylist-app')

@section('title', 'Select Booking Type')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    :root {
        --app-bg: #F3F2EC;
        --app-surface: #ffffff;
        --app-accent: #461111;
        --app-accent-hover: #5a1818;
        --app-text: #1a260e;
        --app-muted: rgba(26, 38, 14, 0.7);
        --app-line: rgba(26, 38, 14, 0.1);
    }

    body {
        background-color: var(--app-bg);
        font-family: 'Montserrat', sans-serif;
        color: var(--app-text);
        margin: 0;
    }
    
    .booking-page {
        padding: 4rem 1rem;
        max-width: 1000px;
        margin: 0 auto;
        position: relative;
    }

    .booking-top-actions {
        position: absolute;
        top: 1.25rem;
        right: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        z-index: 2;
    }

    .btn-logout {
        flex-shrink: 0;
        height: 40px;
        padding: 0 1rem;
        border: 1px solid var(--app-line);
        background: #fff;
        color: var(--app-text);
        font-family: 'Montserrat', sans-serif;
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
        text-decoration: none;
    }

    .btn-logout:hover {
        border-color: var(--app-accent);
        color: var(--app-accent);
    }

    .btn-signin-link {
        flex-shrink: 0;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--app-accent);
        text-decoration: none;
        padding: 0.65rem 0.85rem;
        border: 1px solid rgba(70, 17, 17, 0.15);
        border-radius: 6px;
        background: #fff;
    }

    .btn-signin-link:hover {
        border-color: var(--app-accent);
    }

    /* HEADER */
    .header-section {
        text-align: center;
        margin-bottom: 3.5rem;
    }
    .header-logo {
        height: 60px;
        margin-bottom: 2.5rem;
    }
    .header-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3.2rem;
        font-weight: 400;
        letter-spacing: 0.04em;
        margin-bottom: 0.75rem;
    }
    .header-subtitle {
        font-size: 1.05rem;
        font-weight: 400;
        color: var(--app-muted);
    }

    /* CARDS GRID */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .booking-card {
        background: #ffffff;
        border: none;
        border-radius: 24px;
        padding: 3rem 2rem 2.5rem;
        text-align: center;
        text-decoration: none;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: var(--app-text);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .booking-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(70, 17, 17, 0.12);
    }

    .card-icon {
        width: 72px;
        height: 72px;
        border-radius: 16px;
        background: var(--app-accent);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        flex-shrink: 0;
    }

    .card-icon svg { width: 34px; height: 34px; }

    .card-title-styled {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(2.75rem, 5vw, 4.25rem);
        font-weight: 400;
        line-height: 0.92;
        letter-spacing: 0.03em;
        margin: 0 0 2.5rem;
        text-transform: uppercase;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        min-height: 7.5rem;
    }

    .card-title-line {
        display: block;
        color: #000;
    }

    .card-title-mixed {
        text-transform: uppercase;
        margin-bottom: 0.14em;
    }

    .card-title-by {
        font-family: 'Instrument Serif', serif;
        font-style: italic;
        font-weight: 400;
        text-transform: lowercase;
        letter-spacing: 0;
    }

    .card-title-accent {
        color: var(--app-accent);
    }

    .card-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.95rem 2.25rem;
        border-radius: 100px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        margin-top: auto;
        background: var(--app-accent);
        color: #fff;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .booking-card:hover .card-btn {
        background: var(--app-accent-hover);
        transform: translateY(-1px);
    }

    .save-tag {
        background: var(--app-accent);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.4rem 1.5rem;
        letter-spacing: 1.5px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        box-shadow: 0 4px 15px rgba(70, 17, 17, 0.2);
        z-index: 1;
        margin-top: -3rem;
        margin-bottom: 1.5rem;
    }

    /* PREMIUM INFO SECTION */
    .info-section {
        margin-top: 5rem;
        padding-top: 5rem;
        border-top: 1px solid var(--app-line);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .about-block {
        text-align: center;
        max-width: 800px;
        margin-bottom: 5rem;
    }
    .about-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.5rem;
        font-weight: 400;
        letter-spacing: 0.04em;
        margin-bottom: 1.5rem;
        color: var(--app-accent);
    }
    .about-text {
        font-size: 1.15rem;
        font-weight: 400;
        line-height: 1.8;
        color: var(--app-text);
        margin-bottom: 1.5rem;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
        width: 100%;
        max-width: 1000px;
    }

    .studio-box {
        background: #fff;
        border: 1px solid var(--app-line);
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        transition: transform 0.3s ease;
    }
    .studio-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.05);
    }
    .studio-box h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
        font-weight: 400;
        letter-spacing: 0.04em;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--app-accent);
    }
    .studio-box p {
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.8;
        color: var(--app-text);
        margin-bottom: 0.75rem;
    }
    .studio-box strong {
        font-weight: 600;
        color: var(--app-text);
    }
    .studio-box a {
        color: var(--app-accent);
        text-decoration: none;
        font-weight: 500;
        transition: opacity 0.3s ease;
    }
    .studio-box a:hover {
        opacity: 0.7;
    }

    /* SIMPLE FOOTER */
    .simple-footer {
        margin-top: 5rem;
        padding-top: 3rem;
        padding-bottom: 2rem;
        border-top: 1px solid var(--app-line);
        text-align: center;
    }
    .footer-logo {
        height: 40px;
        margin-bottom: 1rem;
        opacity: 0.8;
    }
    .footer-copyright {
        font-size: 0.8rem;
        color: var(--app-muted);
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    @media (max-width: 900px) {
        .cards-grid { 
            grid-template-columns: 1fr; 
            max-width: 450px; 
            margin-left: auto; 
            margin-right: auto; 
            gap: 1.25rem; 
        }
        .booking-card {
            padding: 2rem 1.5rem 1.75rem;
            border-radius: 20px;
        }
        .card-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1.5rem;
            border-radius: 14px;
        }
        .card-icon svg { width: 28px; height: 28px; }
        .card-title-styled {
            margin-bottom: 2rem;
        }
        .card-btn {
            padding: 0.85rem 2rem;
            font-size: 0.72rem;
        }
        .save-tag {
            padding: 0.35rem 1.5rem;
            font-size: 0.6rem;
            margin-top: -2rem;
            margin-bottom: 1rem;
        }
        
        .info-section { padding-top: 3rem; margin-top: 3rem; }
        .contact-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .header-title { font-size: 2.4rem; }
        .header-logo { height: 40px; margin-bottom: 1.5rem; }
        .header-section { margin-bottom: 2rem; }
        .about-title { font-size: 2rem; }
        .about-text { font-size: 1rem; }
        .booking-top-actions {
            position: static;
            justify-content: center;
            margin-bottom: 1rem;
            padding: 0 0.25rem;
        }
    }
</style>
@endsection

@section('content')
<div class="booking-page">

    <div class="booking-top-actions">
        @auth
            @php
                $pendingCount = \App\Models\Booking::where('user_id', auth()->id())
                    ->where('status', 'pending_approval')
                    ->count();
            @endphp
            <a href="{{ route('stylist.my_bookings') }}" class="btn-logout" style="position: relative;">
                My Bookings
                @if($pendingCount > 0)
                    <span style="position: absolute; top: -6px; right: -6px; background: #e74c3c; color: #fff; font-size: 0.6rem; font-weight: bold; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">{{ $pendingCount }}</span>
                @endif
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-signin-link">Sign in</a>
        @endauth
    </div>
    
    <div class="header-section">
        <img src="{{ asset('images/brand_logo.svg') }}" alt="Eladé Studio" class="header-logo">
        <h1 class="header-title">Book Your Session</h1>
        <p class="header-subtitle">Choose how you'd like to reserve your space at Eladé Studios</p>
    </div>

    <div class="cards-grid">
        <!-- Hourly Booking -->
        <a href="{{ route('stylist.book', ['type' => 'hourly']) }}" class="booking-card">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="card-title-styled">
                <span class="card-title-line">BOOK</span>
                <span class="card-title-line card-title-mixed"><span class="card-title-by">by</span> THE</span>
                <span class="card-title-line card-title-accent">HOUR</span>
            </h3>
            <div class="card-btn">
                Select Time &rarr;
            </div>
        </a>

        <!-- Daily Booking -->
        <a href="{{ route('stylist.book', ['type' => 'daily']) }}" class="booking-card">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="card-title-styled">
                <span class="card-title-line">BOOK</span>
                <span class="card-title-line card-title-mixed"><span class="card-title-by">by</span> THE</span>
                <span class="card-title-line card-title-accent">DAY</span>
            </h3>
            <div class="card-btn">
                Select Date &rarr;
            </div>
        </a>

        <!-- Monthly Packages -->
        <a href="{{ route('stylist.packages.index') }}" class="booking-card"
           @guest
           onclick="event.preventDefault(); Swal.fire({title: 'Account Required', text: 'You must create an account before accessing studio bundles.', icon: 'info', confirmButtonText: 'Log In', confirmButtonColor: '#461111'}).then(() => window.location.href = '{{ route('login') }}');"
           @endguest
        >
            <span class="save-tag">SAVE MORE</span>
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </div>
            <h3 class="card-title-styled">
                <span class="card-title-line">MONTHLY</span>
                <span class="card-title-line card-title-accent">BUNDLES</span>
            </h3>
            <div class="card-btn">
                View Bundles &rarr;
            </div>
        </a>
    </div>

    <div style="text-align: center; font-size: 0.9rem; color: var(--app-muted); margin-bottom: 4rem; font-weight: 300;">
        Hourly From £15.65  •  Daily From £99  •  Monthly From £295
    </div>

    <div class="info-section">
        
        <!-- About Section (Centered) -->
        <div class="about-block">
            <h2 class="about-title">About Eladé</h2>
            <p class="about-text">
                Eladé is a flexible workspace for beauty professionals, designed for stylists who want the freedom to book by the hour, day, week, or month. 
            </p>
            <p class="about-text">
                Located near Kings Cross, London, our studio provides a professional environment for appointments, content creation, education, consultations, and client experiences without the commitment of a traditional salon rental model.
            </p>
        </div>

        <!-- Contact & Location Grid (2 Columns) -->
        <div class="contact-grid">
            
            <div class="studio-box">
                <h3>
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Location
                </h3>
                <p>
                    <strong>Eladé</strong><br>
                    G13 (Ground Floor)<br>
                    4–10 North Road<br>
                    London<br>
                    N7 9EY<br>
                    United Kingdom
                </p>
            </div>

            <div class="studio-box">
                <h3>
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Contact & Hours
                </h3>
                <p style="margin-bottom: 1.5rem;">
                    <strong>Timings:</strong><br>
                    Monday - Sunday (Open 24 Hours)
                </p>
                <p>
                    <strong>Email:</strong><br>
                    <a href="mailto:management@eladeuk.com">management@eladeuk.com</a>
                </p>
                <p>
                    <strong>Phone:</strong><br>
                    <a href="tel:02039786384">02039786384</a>
                </p>
            </div>

        </div>

    </div>

    <!-- Simple Footer -->
    <div class="simple-footer">
        <img src="{{ asset('images/brand_logo.svg') }}" alt="Eladé Studio" class="footer-logo">
        <div class="footer-copyright">
            &copy; {{ date('Y') }} Eladé Studios. All rights reserved.
        </div>
    </div>

</div>
@endsection
