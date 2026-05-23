@extends('layouts.stylist-app')

@section('title', 'Payment Successful')

@section('css')
<style>
    body { background: #fdf8f6; font-family: 'Montserrat', sans-serif; }
    .success-container { max-width: 600px; margin: 4rem auto; padding: 3rem 2rem; background: #fff; border-radius: 12px; border: 1px solid #efe4dc; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
    .icon { width: 80px; height: 80px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
    .icon svg { width: 40px; height: 40px; color: #2e7d32; }
    h2 { margin: 0 0 1rem; color: #2a2420; }
    p { color: #8a7d72; line-height: 1.6; margin-bottom: 2rem; }
    .btn-home { display: inline-flex; align-items: center; justify-content: center; height: 48px; padding: 0 2rem; background: #d4a088; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; transition: 0.2s; }
    .btn-home:hover { background: #c4896e; transform: translateY(-1px); }
</style>
@endsection

@section('content')
<div class="success-container">
    <div class="icon">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h2>Payment Successful!</h2>
    <p>Thank you. Your overnight booking <strong>#{{ $booking->id }}</strong> is now fully confirmed. You will receive an email confirmation shortly.</p>
    <a href="{{ route('stylist.book') }}" class="btn-home">Back to Homepage</a>
</div>
@endsection
