@extends('layouts.stylist-app')

@section('title', 'Select Booking Type')

@section('css')
<style>
    :root {
        --app-bg: #fffcf2;
        --app-surface: #ffffff;
        --app-accent: #461111;
        --app-accent-hover: #5a1818;
        --app-text: #1a260e;
        --app-muted: rgba(26, 38, 14, 0.7);
        --app-line: rgba(26, 38, 14, 0.1);
    }

    body {
        background-color: var(--app-bg);
        font-family: 'Outfit', sans-serif;
        color: var(--app-text);
        margin: 0;
    }
    
    .booking-page {
        padding: 4rem 1rem;
        max-width: 1000px;
        margin: 0 auto;
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
        font-family: 'Playfair Display', serif;
        font-size: 3.2rem;
        font-weight: 300;
        margin-bottom: 0.75rem;
    }
    .header-subtitle {
        font-size: 1.05rem;
        font-weight: 300;
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
        background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
        border: 1px solid rgba(70, 17, 17, 0.05);
        border-radius: 24px;
        padding: 3.5rem 2rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        color: var(--app-text);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }
    
    /* Decorative top accent line */
    .booking-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--app-accent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .booking-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(70, 17, 17, 0.08);
        border-color: rgba(70, 17, 17, 0.15);
        background: #ffffff;
    }
    .booking-card:hover::before {
        opacity: 1;
    }

    .card-icon {
        width: 75px;
        height: 75px;
        border-radius: 20px;
        background: var(--app-accent); /* Permanently maroon */
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(70, 17, 17, 0.15);
        transition: transform 0.3s ease;
    }
    
    .booking-card:hover .card-icon {
        transform: translateY(-3px); /* Simple hover effect */
    }
    .card-icon svg { width: 34px; height: 34px; }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem;
        font-weight: 500;
        margin-bottom: 1rem;
        color: #1a1a1a;
        transition: color 0.3s ease;
    }
    .booking-card:hover .card-title {
        color: var(--app-accent);
    }
    
    .card-desc {
        font-size: 1rem;
        font-weight: 300;
        color: var(--app-muted);
        margin-bottom: 2.5rem;
        line-height: 1.6;
        padding: 0 0.5rem;
    }

    .card-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 2rem;
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-top: auto;
        background: var(--app-accent); /* Permanently maroon */
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(70, 17, 17, 0.15);
    }
    .booking-card:hover .card-btn {
        background: #5a1818; /* Slightly lighter maroon on hover */
        transform: translateY(-2px);
    }

    .save-tag {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        background: var(--app-accent); /* Restored to brand color */
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.4rem 1.5rem;
        letter-spacing: 1.5px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        box-shadow: 0 4px 15px rgba(70, 17, 17, 0.2);
        z-index: 1;
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
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 300;
        margin-bottom: 1.5rem;
        color: var(--app-accent);
    }
    .about-text {
        font-size: 1.15rem;
        font-weight: 300;
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
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 400;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--app-accent);
    }
    .studio-box p {
        font-size: 1rem;
        font-weight: 300;
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
        font-weight: 300;
        letter-spacing: 0.5px;
    }

    @media (max-width: 900px) {
        .cards-grid { 
            grid-template-columns: 1fr; 
            max-width: 450px; 
            margin-left: auto; 
            margin-right: auto; 
            gap: 1rem; 
        }
        .booking-card {
            padding: 1.5rem 1.25rem;
            border-radius: 16px;
        }
        .card-icon {
            width: 55px;
            height: 55px;
            margin-bottom: 1rem;
            border-radius: 14px;
        }
        .card-icon svg { width: 26px; height: 26px; }
        .card-title {
            font-size: 1.4rem;
            margin-bottom: 0.4rem;
        }
        .card-desc {
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
        .card-btn {
            padding: 0.7rem 1.5rem;
            font-size: 0.75rem;
        }
        .save-tag {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.35rem 1.5rem;
            font-size: 0.6rem;
        }
        
        .info-section { padding-top: 3rem; margin-top: 3rem; }
        .contact-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .header-title { font-size: 2.2rem; }
        .header-logo { height: 40px; margin-bottom: 1.5rem; }
        .header-section { margin-bottom: 2rem; }
        .about-title { font-size: 2rem; }
        .about-text { font-size: 1rem; }
    }
</style>
@endsection

@section('content')
<div class="booking-page">
    
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
            <h3 class="card-title">Book by the Hour</h3>
            <p class="card-desc">Flexible hourly studio reservations tailored to your schedule.</p>
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
            <h3 class="card-title">Daily Booking</h3>
            <p class="card-desc">Reserve a chair for the entire day and focus solely on your clients.</p>
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
            <h3 class="card-title">Studio Bundles</h3>
            <p class="card-desc">Pre-purchase hours in bulk and save significantly on studio hire.</p>
            <div class="card-btn">
                View Bundles &rarr;
            </div>
        </a>
    </div>

    <div style="text-align: center; font-size: 0.9rem; color: var(--app-muted); margin-bottom: 4rem; font-weight: 300;">
        Hourly from £15 &nbsp;&bull;&nbsp; Daily from £100 &nbsp;&bull;&nbsp; Packages from £250
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
