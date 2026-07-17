@extends('layouts.stylist-app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #fdf8f6;
    }
    :root {
        --salon-theme: #461111e6;
        --salon-theme-solid: #461111;
        --app-muted: #8a7d72;
        --app-line: #efe4dc;
        --app-surface: #ffffff;
        --app-accent: rgba(70, 17, 17, 0.9);
        --app-accent-dark: #461111;
        --app-text: #2a2420;
    }
    
    body {
        font-family: 'Outfit', 'Montserrat', sans-serif;
        background-color: #fdfaf9;
    }

    .checkout-container { max-width: 650px; margin: 3rem auto; }
    
    .checkout-header { text-align: center; margin-bottom: 2.5rem; }
    .checkout-header h2 { font-weight: 800; color: var(--salon-theme-solid); letter-spacing: -0.5px; margin-bottom: 0.5rem; }
    .checkout-header p { color: var(--app-muted); font-size: 1.05rem; }

    .summary-card {
        background: linear-gradient(135deg, var(--app-accent) 0%, var(--app-accent-dark) 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(70, 17, 17, 0.2);
    }
    .summary-details h5 { margin: 0; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; }
    .summary-details h3 { margin: 0; font-size: 1.6rem; font-weight: 800; margin-top: 0.2rem; }
    .summary-price { font-size: 2.2rem; font-weight: 800; }

    .stripe-card-wrap { background: var(--app-surface); border: 1px solid var(--app-line); border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .stripe-card-wrap h4 { font-weight: 700; color: var(--salon-theme-solid); margin-bottom: 1.5rem; font-size: 1.2rem; }
    
    .stripe-card-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--app-muted); margin-bottom: 0.5rem; display: block; }
    .stripe-input { padding: 14px 1rem; border: 1.5px solid var(--app-line); border-radius: 10px; background: #fff; transition: all 0.2s; min-height: 50px; }
    .stripe-input.StripeElement--focus { border-color: var(--salon-theme-solid); box-shadow: 0 0 0 3px rgba(70, 17, 17, 0.1); }
    .stripe-input.StripeElement--invalid { border-color: #e53935; }
    .stripe-row { display: flex; gap: 1rem; margin-top: 1.2rem; }
    .stripe-field { flex: 1; margin-bottom: 1.2rem; }
    
    #stripe-error-msg { color: #c62828; font-size: 0.85rem; margin-top: 0.5rem; min-height: 1.5rem; font-weight: 600; }
    
    .btn-pay { width: 100%; height: 56px; background: var(--salon-theme-solid); color: #fff; border: none; border-radius: 12px; font-size: 1.05rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(70, 17, 17, 0.2); }
    .btn-pay:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(70, 17, 17, 0.3); }
    .btn-pay:disabled { opacity: 0.7; cursor: not-allowed; transform: none; box-shadow: none; }
    
    .pay-spinner { display: none; width: 20px; height: 20px; border: 2.5px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .secure-badge {
        display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 1.5rem; color: var(--app-muted); font-size: 0.8rem; font-weight: 600;
    }
    .secure-badge svg { width: 16px; height: 16px; color: #2e7d32; }

</style>
@endsection

@section('content')
<div class="checkout-container px-3">
    <div class="checkout-header">
        <h2>Secure Checkout</h2>
        <p>Complete your package purchase below</p>
    </div>

    <div class="stripe-card-wrap" style="padding: 1.5rem; margin-bottom: 1.5rem;">
        <span class="stripe-card-label">Have a Coupon?</span>
        <div style="display: flex; gap: 0.5rem;">
            <input type="text" id="coupon_code" class="stripe-input" style="flex: 1; text-transform: uppercase;" placeholder="Enter code">
            <button type="button" id="apply-coupon-btn" class="btn-pay" style="width: auto; padding: 0 1.5rem;">Apply</button>
        </div>
        <div id="coupon-msg" style="font-size: 0.85rem; margin-top: 0.5rem; min-height: 1.5rem; font-weight: 600;"></div>
    </div>

    <div class="summary-card">
        <div class="summary-details">
            <h5>Prepaid Package</h5>
            <h3>{{ $package->name }}</h3>
            <div style="font-size: 0.85rem; opacity: 0.8; margin-top: 0.3rem;">Includes {{ $package->hours }} booking hours</div>
        </div>
        <div class="summary-price" style="display: flex; flex-direction: column; align-items: flex-end;">
            <div id="summary-price-display">£{{ number_format($package->price, 2) }}</div>
            <div id="discount-row" style="display: none; font-size: 1.2rem; color: #ffeb3b; font-weight: 700;">
                <span id="discount-display"></span>
            </div>
        </div>
    </div>

    <div class="stripe-card-wrap">
        <h4>Payment Method</h4>

        <div class="stripe-field" style="margin-bottom: 0;">
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
        
        <button id="pay-btn" class="btn-pay mt-2" type="button">
            <span class="pay-spinner" id="pay-spinner"></span>
            <span id="pay-btn-text">Pay £{{ number_format($package->price, 2) }}</span>
        </button>

        <div class="secure-badge">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Payments are secured & encrypted by Stripe
        </div>
    </div>
</div>

<form id="payment-form" action="{{ route('stylist.packages.success', $package) }}" method="GET" style="display: none;">
    <input type="hidden" name="payment_intent" id="payment_intent_input">
    <input type="hidden" name="is_free" id="is_free_input" value="0">
</form>
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

    const cardNumber = elements.create('cardNumber', { style: cardStyle }); 
    cardNumber.mount('#stripe-card-number');
    
    const cardExpiry = elements.create('cardExpiry', { style: cardStyle }); 
    cardExpiry.mount('#stripe-card-expiry');
    
    const cardCvc = elements.create('cardCvc', { style: cardStyle }); 
    cardCvc.mount('#stripe-card-cvc');

    const displayError = document.getElementById('stripe-error-msg');
    const handleChange = (e) => { displayError.textContent = e.error ? e.error.message : ''; };

    cardNumber.on('change', handleChange);
    cardExpiry.on('change', handleChange);
    cardCvc.on('change', handleChange);

    const payBtn = document.getElementById('pay-btn');
    const payBtnText = document.getElementById('pay-btn-text');
    const paySpinner = document.getElementById('pay-spinner');
    
    // Coupon Logic
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const couponInput = document.getElementById('coupon_code');
    const couponMsg = document.getElementById('coupon-msg');
    const summaryPrice = document.getElementById('summary-price-display');
    const discountRow = document.getElementById('discount-row');
    const discountDisplay = document.getElementById('discount-display');
    
    let currentTotal = {{ $package->price }};
    let appliedCoupon = null;

    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', async () => {
            const code = couponInput.value.trim();
            if (!code) return;
            
            applyCouponBtn.disabled = true;
            couponMsg.textContent = 'Applying...';
            couponMsg.style.color = '#8a7d72';
            
            try {
                const res = await fetch('{{ route("stylist.coupon.apply") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: code, total_amount: {{ $package->price }} })
                });
                
                const data = await res.json();
                
                if (data.error) {
                    couponMsg.textContent = data.error;
                    couponMsg.style.color = '#c62828';
                    appliedCoupon = null;
                    currentTotal = {{ $package->price }};
                    summaryPrice.innerHTML = '£' + currentTotal.toFixed(2);
                    discountRow.style.display = 'none';
                    payBtnText.textContent = 'Pay £' + currentTotal.toFixed(2);
                } else if (data.success) {
                    couponMsg.textContent = 'Coupon applied successfully!';
                    couponMsg.style.color = '#2e7d32';
                    appliedCoupon = data.coupon_code;
                    currentTotal = data.new_total;
                    
                    summaryPrice.innerHTML = '£' + currentTotal.toFixed(2);
                    discountDisplay.textContent = '-£' + data.discount_amount.toFixed(2);
                    discountRow.style.display = 'flex';
                    
                    if (currentTotal <= 0) {
                        payBtnText.textContent = 'Complete Free Purchase';
                    } else {
                        payBtnText.textContent = 'Pay £' + currentTotal.toFixed(2);
                    }
                }
            } catch (err) {
                couponMsg.textContent = 'Error applying coupon.';
                couponMsg.style.color = '#c62828';
            }
            applyCouponBtn.disabled = false;
        });
    }

    payBtn.addEventListener('click', async () => {
        payBtn.disabled = true;
        payBtnText.style.display = 'none';
        paySpinner.style.display = 'inline-block';
        displayError.textContent = '';

        try {
            // Get client secret
            const response = await fetch("{{ route('stylist.packages.intent', $package) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coupon_code: appliedCoupon })
            });
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }

            if (data.is_free) {
                document.getElementById('is_free_input').value = '1';
                document.getElementById('payment-form').submit();
                return;
            }

            // Confirm payment
            const { paymentIntent, error } = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: {
                    card: cardNumber
                }
            });

            if (error) {
                throw new Error(error.message);
            }

            if (paymentIntent.status === 'succeeded') {
                document.getElementById('payment_intent_input').value = paymentIntent.id;
                document.getElementById('payment-form').submit();
            } else {
                throw new Error('Payment failed. Please try again.');
            }

        } catch (err) {
            displayError.textContent = err.message;
            payBtn.disabled = false;
            payBtnText.style.display = 'inline-block';
            paySpinner.style.display = 'none';
        }
    });
})();
</script>

@endsection
