@extends('layouts.stylist-app')

@section('title', 'Pay for Booking')

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
    }
    body { background: var(--app-bg); font-family: 'Montserrat', sans-serif; color: var(--app-text); padding-bottom: 50px; }
    .pay-container { max-width: 600px; margin: 3rem auto; padding: 2rem; background: var(--app-surface); border-radius: 12px; border: 1px solid var(--app-line); box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
    h2 { text-align: center; margin-top: 0; }
    
    .timer-container { text-align: center; font-size: 1.1rem; font-weight: 700; color: #d32f2f; margin-bottom: 1.5rem; background: #fff3f3; padding: 0.8rem; border-radius: 8px; border: 1px solid #ffcdd2; }
    .timer-container.urgent { color: #b71c1c; background: #ffebee; border-color: #ef9a9a; animation: pulse 1s infinite; }
    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.8; } 100% { opacity: 1; } }
    
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

    /* Coupon UI */
    .coupon-wrap { margin-bottom: 1.5rem; display: flex; gap: 0.5rem; }
    .coupon-input { flex: 1; padding: 0.7rem 0.85rem; border: 1.5px solid var(--app-line); border-radius: 8px; background: #fff; font-size: 0.9rem; }
    .btn-apply-coupon { background: var(--app-muted); color: #fff; border: none; border-radius: 8px; padding: 0 1.5rem; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; transition: background 0.2s; cursor: pointer; }
    .btn-apply-coupon:hover { background: var(--app-text); }
    .coupon-msg { font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; display: none; }
    .coupon-msg.success { color: #2e7d32; display: block; }
    .coupon-msg.error { color: #c62828; display: block; }
    .discount-line { color: #2e7d32; display: none; }
</style>
@endsection

@section('content')
<div class="pay-container">
    <h2>Secure Payment</h2>
    
    @if($booking->expires_at)
    <div class="timer-container" id="bookingTimer">
        Time remaining to complete payment: <span id="countdownText">--:--</span>
    </div>
    @endif
    
    <p style="text-align:center;color:var(--app-muted);font-size:0.9rem;margin-bottom:2rem;">Your overnight booking has been approved! Please complete your payment to lock in your reservation.</p>

    <div class="summary-card">
        <div class="summary-line"><span>Booking ID</span><span>#{{ $booking->id }}</span></div>
        <div class="summary-line"><span>Stylist / Client</span><span>{{ $booking->user->name }}</span></div>
        <div class="summary-line"><span>Email</span><span>{{ $booking->user->email }}</span></div>
        <div class="summary-line"><span>Start</span><span>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('D d M Y, h:i A') }}</span></div>
        <div class="summary-line"><span>Duration</span><span>{{ $booking->duration_hours }} hours</span></div>
        <div class="summary-line discount-line" id="discount-line"><span>Discount</span><span id="discount-amount-text">-£0.00</span></div>
    </div>

    <div class="coupon-wrap">
        <input type="text" id="coupon_code" class="coupon-input" placeholder="Enter promo code">
        <button type="button" id="apply-coupon-btn" class="btn-apply-coupon">Apply</button>
    </div>
    <div id="coupon-message" class="coupon-msg"></div>

    <div class="total-highlight">
        <span class="total-highlight-label">Amount due</span>
        <span class="total-highlight-amount" id="final-amount-display">£{{ number_format($booking->total_amount, 2) }}</span>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const couponInput = document.getElementById('coupon_code');
    const couponMessage = document.getElementById('coupon-message');
    const discountLine = document.getElementById('discount-line');
    const discountAmountText = document.getElementById('discount-amount-text');
    const finalAmountDisplay = document.getElementById('final-amount-display');

    let appliedCoupon = '';
    let currentTotal = {{ $booking->total_amount }};

    applyCouponBtn.addEventListener('click', async function() {
        const code = couponInput.value.trim();
        if (!code) return;
        
        applyCouponBtn.disabled = true;
        applyCouponBtn.textContent = '...';
        couponMessage.className = 'coupon-msg';
        
        try {
            const res = await fetch('{{ route("stylist.coupon.apply") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ 
                    code: code, 
                    total_amount: {{ $booking->total_amount }},
                    booking_id: {{ $booking->id }}
                })
            });
            const data = await res.json();
            
            if (res.ok && data.success) {
                appliedCoupon = data.coupon_code;
                currentTotal = data.new_total;
                
                discountLine.style.display = 'flex';
                discountAmountText.textContent = '-£' + parseFloat(data.discount_amount).toFixed(2);
                finalAmountDisplay.textContent = '£' + parseFloat(data.new_total).toFixed(2);
                payText.textContent = 'Pay £' + parseFloat(data.new_total).toFixed(2);
                
                couponMessage.textContent = 'Coupon applied successfully!';
                couponMessage.className = 'coupon-msg success';
                couponInput.disabled = true;
                applyCouponBtn.style.display = 'none';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error || 'Invalid coupon',
                    confirmButtonColor: '#461111'
                });
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = 'Apply';
            }
        } catch(err) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error applying coupon',
                confirmButtonColor: '#461111'
            });
            applyCouponBtn.disabled = false;
            applyCouponBtn.textContent = 'Apply';
        }
    });

    payBtn.addEventListener('click', async function() {
        payBtn.disabled = true; paySpinner.style.display = 'block'; payText.textContent = 'Processing…';
        try {
            const intentRes = await fetch('{{ route("stylist.bookings.pay.intent", $booking->id) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ coupon_code: appliedCoupon }),
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
            payText.textContent = 'Pay £' + parseFloat(currentTotal).toFixed(2);
        }
    });
})();

@if($booking->expires_at)
(function() {
    const expiresAt = new Date("{{ \Carbon\Carbon::parse($booking->expires_at)->toIso8601String() }}").getTime();
    const countdownEl = document.getElementById('countdownText');
    const containerEl = document.getElementById('bookingTimer');
    
    function updateTimer() {
        const now = new Date().getTime();
        const distance = expiresAt - now;
        
        if (distance <= 0) {
            countdownEl.innerHTML = "00:00";
            alert("Your booking reservation has expired. Please try booking again.");
            window.location.reload();
            return;
        }
        
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        countdownEl.innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        
        if (minutes < 5) {
            containerEl.classList.add('urgent');
        }
    }
    
    updateTimer();
    setInterval(updateTimer, 1000);
})();
@endif
</script>
@endsection
