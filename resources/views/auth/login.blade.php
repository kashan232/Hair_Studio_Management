<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Hair Studio Management - Premium Salon Portal">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">
    <title>Welcome | Eladé Studio</title>

    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #461111;
            --brand-primary-light: rgba(70, 17, 17, 0.85);
            --brand-primary-faint: rgba(70, 17, 17, 0.1);
            --text-dark: #1a1a1a;
            --text-muted: #666666;
            --border-light: rgba(255, 255, 255, 0.3);
            --border-dark: rgba(0, 0, 0, 0.1);
            --glass-bg: rgba(255, 255, 255, 0.85);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            background-color: #111;
        }

        /* Immersive Background */
        .page-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: #461111;
        }

        .page-wrapper::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.5) 0%, transparent 100%);
            z-index: 1;
        }

        /* Glassmorphism Container */
        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 500px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--border-light);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3), inset 0 0 0 1px rgba(255, 255, 255, 0.5);
            overflow: hidden;
            animation: floatIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes floatIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Area */
        .auth-header {
            width: 100%;
            text-align: center;
            padding: 3rem 2rem 1.5rem;
        }

        .auth-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 500;
            letter-spacing: 2px;
            color: var(--brand-primary);
            margin: 0 0 0.5rem;
            text-transform: uppercase;
        }

        .auth-header p {
            font-size: 0.85rem;
            font-weight: 400;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin: 0;
        }

        /* Tab Navigation */
        .auth-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-dark);
            margin: 0 2rem;
        }

        .tab-btn {
            flex: 1;
            background: transparent;
            border: none;
            padding: 1rem 0;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
            transition: color 0.3s ease;
        }

        .tab-btn.active {
            color: var(--brand-primary);
        }

        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--brand-primary);
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .tab-btn.active::after {
            transform: scaleX(1);
        }

        /* Forms */
        .auth-body {
            padding: 2rem;
        }

        .auth-form {
            display: none;
            animation: fadeIn 0.5s ease forwards;
        }

        .auth-form.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group {
            position: relative;
            margin-bottom: 1.8rem;
        }

        .input-group label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: var(--text-muted);
            transition: all 0.3s ease;
            pointer-events: none;
            letter-spacing: 1px;
        }

        .input-group input {
            width: 100%;
            padding: 0.8rem 0;
            border: none;
            border-bottom: 1px solid var(--border-dark);
            background: transparent;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus,
        .input-group input:not(:placeholder-shown) {
            border-bottom-color: var(--brand-primary);
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -10px;
            font-size: 0.7rem;
            color: var(--brand-primary);
            font-weight: 600;
        }

        .input-group .toggle-password {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            background: var(--brand-primary);
            color: #fff;
            border: none;
            padding: 1.2rem;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(70, 17, 17, 0.2);
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #2b0a0a;
            box-shadow: 0 6px 20px rgba(70, 17, 17, 0.3);
            transform: translateY(-2px);
        }
        
        .btn-primary:disabled {
            background: #8a6a6a;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            background: transparent;
            color: var(--brand-primary);
            border: 1px solid var(--brand-primary);
            padding: 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-outline:hover {
            background: var(--brand-primary-faint);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0 1rem;
            color: var(--text-muted);
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-dark);
        }

        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input {
            accent-color: var(--brand-primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 0.8rem;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        /* Mobile specific adjustments */
        @media (max-width: 480px) {
            .auth-container {
                border-radius: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .page-wrapper {
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrapper">
        <div class="auth-container">
            
            <div class="auth-header">
                <img src="{{ asset('images/brand_logo.svg') }}" alt="Studio Logo" style="height: 60px; width: auto; display: block; margin: 0 auto 10px;">
                <p>Premium Workspace</p>
            </div>

            <div class="auth-tabs">
                <button class="tab-btn active" data-target="login">Sign In</button>
                <button class="tab-btn" data-target="register">Register</button>
            </div>

            <div class="auth-body">
                
                <!-- LOGIN FORM -->
                <form id="login-form" class="auth-form active ajaxForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="input-group">
                        <input type="email" name="email" id="login-email" placeholder=" " required>
                        <label for="login-email">Email Address</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="login-password" placeholder=" " required>
                        <label for="login-password">Password</label>
                        <i class="zmdi zmdi-eye-off toggle-password" data-input="#login-password"></i>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div class="checkbox-group" style="margin-bottom: 0;">
                            <input type="checkbox" id="remember-me" name="remember">
                            <label for="remember-me">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 0.8rem; color: var(--brand-primary); text-decoration: none; font-weight: 600;">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary">Secure Sign In</button>

                    <div class="divider">or</div>

                    <a href="{{ route('stylist.book') }}" class="btn-outline">
                        Book Chair as Guest
                    </a>
                </form>

                <!-- REGISTER FORM -->
                <form id="register-form" class="auth-form ajaxForm" method="POST" action="{{ route('register.hairstylist') }}">
                    @csrf

                    <div class="input-group">
                        <input type="text" name="name" id="reg-name" placeholder=" " required>
                        <label for="reg-name">Full Name</label>
                    </div>

                    <div class="input-group">
                        <input type="email" name="email" id="reg-email" placeholder=" " required>
                        <label for="reg-email">Email Address</label>
                    </div>

                    <div class="input-group">
                        <input type="text" name="mobile" id="reg-mobile" placeholder=" ">
                        <label for="reg-mobile">Mobile Number</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="reg-password" placeholder=" " required>
                        <label for="reg-password">Password</label>
                        <i class="zmdi zmdi-eye-off toggle-password" data-input="#reg-password"></i>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="reg-confirm" placeholder=" " required>
                        <label for="reg-confirm">Confirm Password</label>
                        <i class="zmdi zmdi-eye-off toggle-password" data-input="#reg-confirm"></i>
                    </div>

                    <button type="submit" class="btn-primary">Create Account</button>
                </form>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            
            // Tab Switching
            $('.tab-btn').on('click', function() {
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');
                
                const target = $(this).data('target');
                $('.auth-form').removeClass('active');
                $('#' + target + '-form').addClass('active');
            });

            // Password Toggle
            $('.toggle-password').on('click', function() {
                const input = $($(this).data('input'));
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('zmdi-eye-off zmdi-eye');
            });

            // Remember Me LocalStorage
            const remembered = localStorage.getItem('elade_email');
            if (remembered) {
                $('#login-email').val(remembered);
                $('#remember-me').prop('checked', true);
            }
            
            $('#remember-me').on('change', function() {
                if(this.checked) {
                    localStorage.setItem('elade_email', $('#login-email').val());
                } else {
                    localStorage.removeItem('elade_email');
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success || 'Welcome to Eladé Studio',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error,
                                confirmButtonColor: '#461111'
                            });
                            btn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text(originalText);
                        let errMsg = 'Something went wrong. Please try again.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errMsg = Object.values(errors)[0][0]; // Show first validation error
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errMsg,
                            confirmButtonColor: '#461111'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
