@extends('layouts.stylist-app')

@section('title', 'Pay for Booking')

@section('css')
<style>
    :root {
        --app-bg: #fdf8f6;
        --app-surface: #ffffff;
        --app-accent: #d4a088;
        --app-accent-dark: #c4896e;
        --app-text: #2a2420;
        --app-muted: #8a7d72;
        --app-line: #efe4dc;
    }
    body { background: var(--app-bg); font-family: 'Montserrat', sans-serif; color: var(--app-text); padding-bottom: 50px; }
    .pay-container { max-width: 600px; margin: 3rem auto; padding: 2rem; background: var(--app-surface); border-radius: 12px; border: 1px solid var(--app-line); box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
    h2 { text-align: center; margin-top: 0; }
    
    .summary-card { background: #fdfdfd; border: 1px solid var(--app-line); border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem; }
    .summary-line { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--app-line); font-size: 0.9rem; }
    .summary-line:last-child { border: none; padding-bottom: 0; }
    .summary-line span:first-child { color: var(--app-muted); font-weight: 600; }
    .summary-line span:last-child { font-weight: 700; }

    .total-highlight {
        background: linear-gradient(135deg, var(--app-accent) 0%, var(--app-accent-dark) 100%);
        border-radius: 12px; padding: 1.1rem 1.3rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; color: #fff;
    }
    .total-highlight-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.9; }
    .total-highlight-amount { font-size: 2rem; font-weight: 800; letter-spacing: -0.5px; }

    /* Stripe Card UI */
    .stripe-card-wrap { background: var(--app-surface); border: 1px solid var(--app-line); border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem; }
    .stripe-card-label { font-size: 0.68rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--app-muted); margin-bottom: 0.6rem; display: block; }
    .stripe-input { padding: 0.7rem 0.85rem; border: 1.5px solid var(--app-line); border-radius: 8px; background: #fff; transition: border-color 0.2s; }
    .stripe-input.StripeElement--focus { border-color: var(--app-accent); }
    .stripe-input.StripeElement--invalid { border-color: #e53935; }
    .stripe-row { display: flex; gap: 1rem; margin-top: 1rem; }
    .stripe-field { flex: 1; }
    #stripe-error-msg { color: #c62828; font-size: 0.78rem; margin-top: 0.5rem; min-height: 1.2rem; }

    .btn-pay { width: 100%; height: 52px; background: linear-gradient(135deg, var(--app-accent) 0%, var(--app-accent-dark) 100%); color: #fff; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: opacity 0.2s; }
    .btn-pay:hover:not(:disabled) { opacity: 0.9; }
    .btn-pay:disabled { opacity: 0.55; cursor: not-allowed; }
    
    .pay-spinner { display: none; width: 18px; height: 18px; border: 2.5px solid rgba(255,255,255,0.35); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@section('content')
<div class="pay-container">
    <h2>Complete Payment</h2>
    <p style="text-align:center;color:var(--app-muted);font-size:0.9rem;margin-bottom:2rem;">Your overnight booking has been approved! Please complete your payment to lock in your reservation.</p>

    <div class="summary-card">
        <div class="summary-line"><span>Booking ID</span><span>#{{ $booking->id }}</span></div>
        <div class="summary-line"><span>Stylist / Client</span><span>{{ $booking->user->name }}</span></div>
        <div class="summary-line"><span>Email</span><span>{{ $booking->user->email }}</span></div>
        <div class="summary-line"><span>Start</span><span>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('D d M Y, h:i A') }}</span></div>
        <div class="summary-line"><span>Duration</span><span>{{ $booking->duration_hours }} hours</span></div>
    </div>

    <div class="total-highlight">
        <span class="total-highlight-label">Amount due</span>
        <span class="total-highlight-amount">£{{ number_format($booking->total_amount, 2) }}</span>
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
    </div>

    <button id="pay-btn" class="btn-pay" type="button">
        <span class="pay-spinner" id="pay-spinner"></span>
        <span id="pay-btn-text">Pay £{{ number_format($booking->total_amount, 2) }}</span>
    </button>
</div>
@endsection

@section('scripts')
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
            const intentRes = await fetch('{{ route("stylist.bookings.pay.intent", $booking->id) }}', {
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
                window.location.href = '{{ route("stylist.bookings.pay.success", $booking->id) }}';
            }
        } catch(err) {
            displayError.textContent = err.message || 'Payment failed. Please try again.';
            payBtn.disabled = false; paySpinner.style.display = 'none';
            payText.textContent = 'Pay £{{ number_format($booking->total_amount, 2) }}';
        }
    });
})();
</script>
@endsection
