@extends('layouts.stylist-app')

@section('title', 'Payment Successful')

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

    html, body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
    }

    body {
        background: #0f1012;
        background-image: 
            radial-gradient(at 0% 0%, rgba(212, 160, 136, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(196, 137, 110, 0.15) 0px, transparent 50%);
        font-family: 'Outfit', sans-serif;
        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 2rem 1rem;
        box-sizing: border-box;
    }

    .success-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-grow: 1;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    /* Ambient animated blobs */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.5;
        z-index: 0;
        animation: float 10s infinite ease-in-out alternate;
    }
    .blob-1 {
        width: 300px;
        height: 300px;
        background: rgba(212, 160, 136, 0.4);
        top: 20%;
        left: 20%;
        animation-delay: 0s;
    }
    .blob-2 {
        width: 400px;
        height: 400px;
        background: rgba(144, 102, 82, 0.3);
        bottom: 10%;
        right: 15%;
        animation-delay: -5s;
    }

    @keyframes float {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(30px, -50px) scale(1.1); }
    }

    /* Glassmorphism Card */
    .success-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 3.5rem 3rem;
        max-width: 550px;
        width: 100%;
        text-align: center;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
        animation: slideUpFade 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(40px);
    }

    @keyframes slideUpFade {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Brand Logo */
    .brand-logo {
        height: 50px;
        margin-bottom: 2rem;
        animation: fadeIn 0.8s ease forwards 0.2s;
        opacity: 0;
        filter: brightness(0) invert(1); /* Makes the dark logo white for dark theme */
    }

    /* Animated Success Icon */
    .icon-wrapper {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #d4a088, #906652);
        border-radius: 50%;
        opacity: 0.2;
        animation: pulseRing 2s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes pulseRing {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(1.8); opacity: 0; }
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #d4a088, #906652);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 10px 25px rgba(212, 160, 136, 0.4);
        animation: scaleIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s forwards;
        transform: scale(0);
    }

    @keyframes scaleIn {
        to { transform: scale(1); }
    }

    .icon-circle svg {
        width: 40px;
        height: 40px;
        color: #fff;
        stroke-dasharray: 50;
        stroke-dashoffset: 50;
        animation: drawCheck 0.6s ease-out 0.8s forwards;
    }

    @keyframes drawCheck {
        to { stroke-dashoffset: 0; }
    }

    h2 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 0.8rem;
        background: linear-gradient(to right, #fff, #ebd3c6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        opacity: 0;
        animation: fadeIn 0.6s ease forwards 0.5s;
    }

    p.subtitle {
        color: #a39c98;
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fadeIn 0.6s ease forwards 0.7s;
    }

    /* Booking Details */
    .booking-details {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fadeIn 0.6s ease forwards 0.9s;
        text-align: left;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-label {
        color: #8c8682;
        font-size: 0.95rem;
    }

    .detail-value {
        color: #fff;
        font-weight: 500;
        font-size: 1rem;
    }
    
    .detail-value.highlight {
        color: #d4a088;
        font-weight: 600;
    }

    /* Button */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 52px;
        padding: 0 3rem;
        background: linear-gradient(135deg, #d4a088, #c4896e);
        color: #fff;
        border-radius: 26px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        box-shadow: 0 10px 20px rgba(212, 160, 136, 0.3);
        opacity: 0;
        animation: fadeIn 0.6s ease forwards 1.1s;
        position: relative;
        overflow: hidden;
    }
    
    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(212, 160, 136, 0.4);
        color: #fff;
    }
    
    .action-btn:hover::before {
        left: 100%;
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }
</style>
@endsection

@section('content')
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="success-wrapper">
    <div class="success-card">
        <!-- Brand Logo -->
        <img src="{{ asset('images/brand_logo.svg') }}" alt="Eladé Studio" class="brand-logo">

        <div class="icon-wrapper">
            <div class="icon-circle">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
        
        <h2>Payment Successful</h2>
        <p class="subtitle">Thank you! Your payment has been securely processed and your reservation is fully confirmed.</p>
        
        <div class="booking-details">
            <div class="detail-row">
                <span class="detail-label">Booking Reference</span>
                <span class="detail-value highlight">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date & Time</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('M d, Y') }} &bull; {{ \Carbon\Carbon::parse($booking->start_datetime)->format('h:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value" style="color: #4ade80;">Confirmed</span>
            </div>
        </div>

        <a href="{{ route('stylist.book') }}" class="action-btn">Back to Dashboard</a>
    </div>
</div>
@endsection
