<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Log in or create account | Eladé Studio</title>

    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #000000;
        }

        /* Top Navbar matching the screenshot */
        .top-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
        }

        .top-nav .menu-icon, .top-nav .user-icon {
            font-size: 1.8rem;
            color: #333;
            cursor: pointer;
            position: absolute;
            left: 2rem;
        }

        .top-nav .logo img {
            height: 65px;
            width: auto;
            display: block;
        }

        /* Main Container */
        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        /* Header area */
        .page-title {
            text-align: center;
            font-size: 1.2rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
            margin-top: 2rem;
        }

        .page-subtitle {
            text-align: center;
            font-size: 0.95rem;
            font-weight: 400;
            color: #444;
            margin-bottom: 3rem;
        }

        /* Forms */
        .auth-form-wrap {
            max-width: 600px;
            margin: 0 auto;
        }

        .auth-form {
            display: none;
            animation: fadeIn 0.4s ease forwards;
            text-align: left;
        }

        .auth-form.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 0.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 1rem;
            background: #ffffff;
            border: 1px solid #d1d1d1;
            border-radius: 0; /* Square edges like the screenshot */
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            color: #000;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .input-group input:focus {
            border-color: #000;
        }

        .btn-submit {
            width: 100%;
            background: #461111e6;
            color: #fff;
            border: none;
            padding: 1.1rem;
            font-size: 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background: #461111;
        }

        .btn-submit:disabled {
            background: #f0d5ce;
            cursor: not-allowed;
        }

        .switch-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #000;
            text-decoration: underline;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
        }

        .forgot-link {
            display: inline-block;
            margin-top: 0.5rem;
            color: #666;
            text-decoration: underline;
            font-size: 0.85rem;
        }

        /* ===== LOGIN STEPPER (Matches booking.blade.php) ===== */
        .stepper-wrap {
            padding: 1rem 1rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            overflow-x: auto;
            margin-bottom: 3rem;
            width: 100%;
        }
        
        .stepper {
            display: flex;
            align-items: flex-start;
            min-width: 520px;
            max-width: 720px;
            margin: 0 auto;
            position: relative;
            padding: 0 0.25rem;
        }
        
        .stepper::before {
            content: '';
            position: absolute;
            top: 14px;
            left: 30px;
            right: 30px;
            height: 2px;
            background: #f0f0f0;
            z-index: 1;
        }

        .step-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            text-align: center;
        }
    
        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #999;
            margin-bottom: 0.4rem;
            transition: all 0.3s;
        }
    
        .step-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            transition: color 0.3s;
        }
    
        .step-item.active .step-circle {
            border-color: #461111e6;
            background: #461111e6;
            color: #fff;
        }
    
        .step-item.active .step-label {
            color: #000;
        }
        
        .step-item.done .step-circle {
            border-color: #461111e6;
            color: #461111e6;
        }

        /* Divider & Guest Button */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2.5rem 0 1.5rem 0;
            color: #666;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #eee;
        }

        .divider:not(:empty)::before { margin-right: 1em; }
        .divider:not(:empty)::after { margin-left: 1em; }

        .btn-outline-guest {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            background: #ffffff;
            color: #000;
            border: 1px solid #000;
            padding: 1.1rem;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-outline-guest:hover {
            background: #000;
            color: #fff;
        }

        /* Premium Side Menu Styles */
        .side-menu-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(18, 18, 18, 0.6);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .side-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .side-menu {
            position: fixed;
            top: 0; left: -400px; width: 400px; height: 100%;
            background: #ffffff;
            z-index: 999;
            box-shadow: 5px 0 40px rgba(0,0,0,0.15);
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .side-menu.active {
            left: 0;
        }

        .side-menu-header {
            padding: 1.8rem 2.5rem;
            background: #ffffff;
            border-bottom: 1px solid rgba(70, 17, 17, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .close-menu { 
            cursor: pointer; 
            font-size: 1.6rem; 
            color: #888; 
            transition: all 0.3s ease;
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            background: #f8f8f8;
        }
        .close-menu:hover { color: #fff; background: #461111; transform: rotate(90deg); }

        .side-menu-content { padding: 2.5rem; }
        
        .side-welcome-box {
            background: linear-gradient(145deg, #faf8f5 0%, #fffdf9 100%);
            border-left: 4px solid #461111;
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            border-radius: 0 12px 12px 0;
        }
        
        .side-welcome-box p {
            font-size: 0.95rem; 
            color: #555; 
            line-height: 1.7; 
            margin: 0;
            font-style: italic;
        }

        .side-menu-content h4 { 
            font-size: 0.85rem; 
            color: #461111; 
            margin-top: 0; 
            margin-bottom: 1.5rem; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            font-weight: 800; 
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .side-menu-content h4::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(70, 17, 17, 0.1);
        }
        
        .info-card {
            display: flex; 
            align-items: flex-start; 
            margin-bottom: 1.2rem; 
            gap: 1rem;
            padding: 1.2rem;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(70, 17, 17, 0.08);
            border-color: rgba(70, 17, 17, 0.1);
        }

        .info-icon-wrap { 
            width: 42px; height: 42px; 
            border-radius: 10px; 
            background: rgba(70, 17, 17, 0.05); 
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .info-icon-wrap i { 
            font-size: 1.3rem; 
            color: #461111; 
        }

        .info-details { font-size: 0.9rem; color: #666; line-height: 1.5; }
        .info-details strong { display: block; font-weight: 700; color: #111; margin-bottom: 4px; font-size: 0.95rem;}

        /* Mobile specific adjustments to avoid scrolling */
        @media (max-width: 600px) {
            .main-container {
                padding: 1rem;
            }
            .stepper-wrap {
                margin-bottom: 1.5rem;
            }
            .page-title {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .page-subtitle {
                margin-bottom: 1rem;
            }
            .input-group {
                margin-bottom: 1rem;
            }
            .input-group input {
                padding: 0.75rem;
            }
            .divider {
                margin: 1rem 0;
            }
            .btn-submit {
                padding: 0.85rem;
            }
            .btn-outline-guest {
                padding: 0.85rem;
            }
        }

    </style>
</head>

<body>

    <!-- Side Menu -->
    <div class="side-menu-overlay" id="side-menu-overlay"></div>
    <div class="side-menu" id="side-menu">
        <div class="side-menu-header">
            <img src="{{ asset('images/brand_logo.svg') }}" alt="Eladé Studio" style="height: 40px; width: auto;">
            <div class="close-menu" id="close-menu"><i class="zmdi zmdi-close"></i></div>
        </div>
        
        <div class="side-menu-content">
            <div class="side-welcome-box">
                <p>"Eladé is a flexible workspace for beauty professionals, designed for stylists who want the freedom to book by the hour, day, week, or month. Located near Kings Cross, London, our studio provides a professional environment for appointments, content creation, education, consultations, and client experiences without the commitment of a traditional salon rental model."</p>
            </div>
            
            <h4>Contact Details</h4>
            
            <div class="info-card">
                <div class="info-icon-wrap"><i class="zmdi zmdi-pin"></i></div>
                <div class="info-details">
                    <strong>Location</strong>
                    Eladé<br>G13 (Ground Floor)<br>4–10 North Road<br>London<br>N7 9EY<br>United Kingdom
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon-wrap"><i class="zmdi zmdi-time"></i></div>
                <div class="info-details">
                    <strong>Timings</strong>
                    Monday - Sunday<br>Open 24 Hours
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon-wrap"><i class="zmdi zmdi-email"></i></div>
                <div class="info-details">
                    <strong>Email</strong>
                    <a href="mailto:management@eladeuk.com" style="color: inherit; text-decoration: none;">management@eladeuk.com</a>
                </div>
            </div>
        </div>
    </div>

    <header class="top-nav">
        <i class="zmdi zmdi-menu menu-icon"></i>
        <div class="logo">
            <img src="{{ asset('images/brand_logo.svg') }}" alt="Eladé Studio">
        </div>
    </header>

    <main class="main-container">
        
        <!-- Stepper -->
        <div class="stepper-wrap">
            <div class="stepper">
                <div class="step-item done">
                    <div class="step-circle">✓</div>
                    <div class="step-label">Schedule</div>
                </div>
                <div class="step-item done">
                    <div class="step-circle">✓</div>
                    <div class="step-label">Options</div>
                </div>
                <div class="step-item active">
                    <div class="step-circle">3</div>
                    <div class="step-label">Details</div>
                </div>
                <div class="step-item">
                    <div class="step-circle">4</div>
                    <div class="step-label">Payment</div>
                </div>
                <div class="step-item">
                    <div class="step-circle">5</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
        </div>

        <h1 class="page-title">Log in or create account</h1>
        <p class="page-subtitle">Enter your details to sign in or to create an account.</p>

        <div class="auth-form-wrap">
            <!-- LOGIN FORM -->
            <form id="login-form" class="auth-form active ajaxForm" method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="input-group">
                    <label for="login-email">Email *</label>
                    <input type="email" name="email" id="login-email" required>
                </div>

                <div class="input-group">
                    <label for="login-password">Password *</label>
                    <input type="password" name="password" id="login-password" required>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <div class="input-group" style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="remember-me" name="remember" style="width: auto;">
                    <label for="remember-me" style="margin: 0; font-weight: 500; font-size: 0.9rem;">Remember me</label>
                </div>

                <button type="submit" class="btn-submit">Continue</button>
                
                <a class="switch-link" data-target="register">Create a new account</a>

                <div class="divider">or</div>

                <a href="{{ route('stylist.book') }}" class="btn-outline-guest">Book Chair as Guest</a>
            </form>

            <!-- REGISTER FORM -->
            <form id="register-form" class="auth-form ajaxForm" method="POST" action="{{ route('register.hairstylist') }}">
                @csrf

                <div class="input-group">
                    <label for="reg-name">Full Name *</label>
                    <input type="text" name="name" id="reg-name" required>
                </div>

                <div class="input-group">
                    <label for="reg-email">Email Address *</label>
                    <input type="email" name="email" id="reg-email" required>
                </div>

                <div class="input-group">
                    <label for="reg-mobile">Mobile Number *</label>
                    <input type="text" name="mobile" id="reg-mobile" required
                        pattern="\d{11,12}" maxlength="12"
                        oninvalid="this.setCustomValidity('invalid number, please re enter')"
                        oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <div class="input-group">
                    <label for="reg-password">Password *</label>
                    <input type="password" name="password" id="reg-password" required>
                </div>

                <div class="input-group">
                    <label for="reg-confirm">Confirm Password *</label>
                    <input type="password" name="password_confirmation" id="reg-confirm" required>
                </div>

                <button type="submit" class="btn-submit">Create Account</button>
                
                <a class="switch-link" data-target="login">Already have an account? Sign in</a>

                <div class="divider">or</div>

                <a href="{{ route('stylist.book') }}" class="btn-outline-guest">Book Chair as Guest</a>
            </form>
        </div>

    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            
            // Toggle side menu
            $('.menu-icon').on('click', function() {
                $('#side-menu').addClass('active');
                $('#side-menu-overlay').addClass('active');
            });

            $('#close-menu, #side-menu-overlay').on('click', function() {
                $('#side-menu').removeClass('active');
                $('#side-menu-overlay').removeClass('active');
            });
            
            // Switch forms
            $('.switch-link').on('click', function(e) {
                e.preventDefault();
                const target = $(this).data('target');
                $('.auth-form').removeClass('active');
                $('#' + target + '-form').addClass('active');
                
                if(target === 'register') {
                    $('.page-title').text('Create an account');
                    $('.page-subtitle').text('Join Eladé Studio to book your workspace.');
                } else {
                    $('.page-title').text('Log in or create account');
                    $('.page-subtitle').text('Enter your details to sign in or to create an account.');
                }
            });

            // Form Submit handling
            $('.ajaxForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const btn = form.find('button[type="submit"]');
                const originalText = btn.text();
                
                btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error,
                                confirmButtonColor: '#121212'
                            });
                            btn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text(originalText);
                        let errMsg = 'Something went wrong. Please try again.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errMsg = Object.values(errors)[0][0]; 
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: errMsg,
                            confirmButtonColor: '#121212'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
