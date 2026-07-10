<style>
    .cookie-consent-wrapper {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        width: calc(100% - 40px);
        max-width: 450px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        padding: 20px;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: 'Montserrat', sans-serif;
    }

    .cookie-consent-wrapper.show {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    .cookie-content {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cookie-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cookie-text {
        font-size: 0.85rem;
        color: #555;
        line-height: 1.5;
        margin: 0;
    }

    .cookie-text a {
        color: #17b081;
        text-decoration: underline;
        font-weight: 500;
    }

    .cookie-buttons {
        display: flex;
        gap: 10px;
        width: 100%;
    }

    .btn-cookie {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        outline: none;
    }

    .btn-cookie-accept {
        background: #17b081;
        color: #fff;
        box-shadow: 0 4px 15px rgba(23, 176, 129, 0.2);
    }

    .btn-cookie-accept:hover {
        background: #149c72;
        transform: translateY(-2px);
    }

    .btn-cookie-decline {
        background: #f0f3f8;
        color: #444;
    }

    .btn-cookie-decline:hover {
        background: #e2e8f0;
        color: #222;
    }
</style>

<div class="cookie-consent-wrapper" id="cookieConsent">
    <div class="cookie-content">
        <h4 class="cookie-title">🍪 We value your privacy</h4>
        <p class="cookie-text">
            We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.
        </p>
    </div>
    <div class="cookie-buttons">
        <button class="btn-cookie btn-cookie-decline" id="btnCookieDecline">Decline</button>
        <button class="btn-cookie btn-cookie-accept" id="btnCookieAccept">Accept All</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cookiePopup = document.getElementById('cookieConsent');
        const acceptBtn = document.getElementById('btnCookieAccept');
        const declineBtn = document.getElementById('btnCookieDecline');

        // Check if user already made a choice
        if (!localStorage.getItem('cookieConsent')) {
            // Delay popup slightly for better UX
            setTimeout(() => {
                cookiePopup.classList.add('show');
            }, 1000);
        }

        acceptBtn.addEventListener('click', function() {
            localStorage.setItem('cookieConsent', 'accepted');
            cookiePopup.classList.remove('show');
        });

        declineBtn.addEventListener('click', function() {
            localStorage.setItem('cookieConsent', 'declined');
            cookiePopup.classList.remove('show');
        });
    });
</script>
