<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Hair Studio Management - Premium Salon Portal">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">
    <title>Login | Eladé Studio</title>

    <link id="style" href="{{ asset('assets/css/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --elade-gold: #c6a34d;
            --elade-dark: #121212;
            --elade-sand: #f4efe6;
            --elade-border: #eae2d5;
            --elade-muted: #8c7e6c;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            background: var(--elade-sand);
            font-family: 'Montserrat', sans-serif;
        }

        .login-page-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .login-hero-side {
            flex: 1.25;
            min-height: 100vh;
            background: linear-gradient(rgba(18, 18, 18, 0.35), rgba(18, 18, 18, 0.75)),
                url('https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(2rem, 5vw, 5rem);
            color: #fff;
        }

        .login-hero-side::before {
            content: '';
            position: absolute;
            inset: 24px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            pointer-events: none;
        }

        .hero-top-meta {
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--elade-gold);
            font-weight: 600;
            z-index: 1;
        }

        .hero-brand {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4vw, 3.8rem);
            font-weight: 300;
            letter-spacing: 10px;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            z-index: 1;
        }

        .hero-tagline {
            font-size: 1rem;
            max-width: 480px;
            line-height: 1.7;
            font-weight: 300;
            color: #e0d5c1;
            z-index: 1;
        }

        .login-form-side {
            flex: 1;
            min-height: 100vh;
            background: #fff;
            display: flex;
            justify-content: center;
            padding: clamp(1.5rem, 4vw, 3rem);
        }

        .login-shell {
            width: 100%;
            max-width: 460px;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - clamp(3rem, 8vw, 6rem));
            max-height: 100vh;
        }

        .login-shell-header {
            flex-shrink: 0;
            padding-bottom: 1.75rem;
        }

        .login-shell-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 400;
            letter-spacing: 5px;
            color: var(--elade-dark);
            margin: 0 0 0.35rem;
            text-transform: uppercase;
        }

        .login-shell-header p {
            margin: 0;
            font-size: 0.68rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--elade-muted);
            font-weight: 600;
        }

        .auth-tabs {
            flex-shrink: 0;
            display: flex;
            background: #faf8f5;
            border: 1px solid var(--elade-border);
            margin-bottom: 0;
        }

        .auth-tab-btn {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.85rem 0.5rem;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--elade-muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .auth-tab-btn.active {
            background: var(--elade-dark);
            color: #fff;
        }

        .auth-body {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            border: 1px solid var(--elade-border);
            border-top: none;
            background: #fff;
            padding: 1.75rem 1.5rem 1.25rem;
            scrollbar-width: thin;
            scrollbar-color: #dcd3be transparent;
        }

        .auth-body::-webkit-scrollbar { width: 5px; }
        .auth-body::-webkit-scrollbar-thumb { background: #dcd3be; }

        .auth-panel { display: none; }
        .auth-panel.active { display: block; }

        .register-intro {
            font-size: 0.78rem;
            color: var(--elade-muted);
            line-height: 1.55;
            margin: 0 0 1.25rem;
            padding: 0.85rem 1rem;
            background: #faf8f5;
            border-left: 3px solid var(--elade-gold);
        }

        .form-group-custom {
            position: relative;
            margin-bottom: 1.35rem;
            border-bottom: 1px solid #dcd3be;
            transition: border-color 0.2s;
        }

        .form-group-custom:focus-within {
            border-bottom-color: var(--elade-gold);
        }

        .form-group-custom label {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--elade-muted);
            font-weight: 600;
            margin-bottom: 0.2rem;
            display: block;
        }

        .form-group-custom input {
            width: 100%;
            border: none !important;
            background: transparent !important;
            outline: none !important;
            font-size: 0.9rem;
            color: var(--elade-dark);
            padding: 0.4rem 2rem 0.4rem 0;
            font-weight: 500;
            box-shadow: none !important;
        }

        .form-group-custom input::placeholder {
            color: #b8ac95;
            opacity: 0.7;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0;
            bottom: 0.45rem;
            color: var(--elade-muted);
            text-decoration: none;
            font-size: 1rem;
        }

        .password-toggle-btn:hover { color: var(--elade-gold); }

        .register-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 1rem;
        }

        .register-grid .span-full { grid-column: 1 / -1; }

        .form-check-label {
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            color: var(--elade-muted) !important;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-check-input {
            border-radius: 0 !important;
            border-color: #dcd3be !important;
        }

        .form-check-input:checked {
            background-color: var(--elade-gold) !important;
            border-color: var(--elade-gold) !important;
        }

        .login100-form-btn {
            width: 100%;
            background: var(--elade-dark) !important;
            color: #fff !important;
            border: 1px solid var(--elade-dark) !important;
            border-radius: 0 !important;
            font-weight: 600 !important;
            height: 50px !important;
            letter-spacing: 2px !important;
            text-transform: uppercase !important;
            font-size: 0.72rem !important;
            transition: all 0.25s !important;
            box-shadow: none !important;
            cursor: pointer;
            margin-top: 0.5rem;
        }

        .login100-form-btn:hover {
            background: var(--elade-gold) !important;
            border-color: var(--elade-gold) !important;
            transform: translateY(-1px);
        }

        .auth-switch-link {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--elade-gold);
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .auth-switch-link:hover { color: var(--elade-dark); }

        .login-shell-footer {
            flex-shrink: 0;
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid #f4efe6;
            font-size: 0.62rem;
            color: #a0937d;
            letter-spacing: 1.2px;
            line-height: 1.7;
            text-transform: uppercase;
        }

        @media (max-width: 991px) {
            .login-hero-side { display: none; }
            .login-shell {
                min-height: auto;
                max-height: none;
            }
        }

        @media (max-width: 480px) {
            .register-grid { grid-template-columns: 1fr; gap: 0; }
            .auth-body { padding: 1.25rem 1rem; }
        }
    </style>
</head>

<body>

    <div class="login-page-container">

        <div class="login-hero-side">
            <div class="hero-top-meta">LONDON, UK</div>
            <div>
                <div class="hero-brand">Eladé Studio</div>
                <div class="hero-tagline">
                    Control your schedule. Elevate your standard. Book luxury workspace without long-term commitments.
                </div>
            </div>
            <div class="hero-top-meta">&copy; 2026 ELADÉ STUDIO</div>
        </div>

        <div class="login-form-side">
            <div class="login-shell">

                <div class="login-shell-header">
                    <h2>Eladé Studio</h2>
                    <p id="auth-subtitle">Premium Salon Portal</p>
                </div>

                <div class="auth-tabs">
                    <button type="button" class="auth-tab-btn active" data-auth-tab="login">Sign In</button>
                    <button type="button" class="auth-tab-btn" data-auth-tab="register">Register</button>
                </div>

                <div class="auth-body">
                    <!-- Login -->
                    <div id="login-panel" class="auth-panel active">
                        <form method="POST" action="{{ route('login') }}" class="ajaxForm" id="login-form">
                            @csrf

                            <div class="form-group-custom">
                                <label for="email">Email Address</label>
                                <input name="email" type="email" placeholder="e.g. name@eladeuk.com" id="email" required>
                            </div>

                            <div class="form-group-custom">
                                <label for="password">Password</label>
                                <input name="password" type="password" placeholder="Enter password" id="password" required>
                                <a href="javascript:void(0)" class="password-toggle-btn toggle-password" data-target="#password">
                                    <i class="zmdi zmdi-eye-off"></i>
                                </a>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="user-checkbox">
                                <label class="form-check-label" for="user-checkbox">Remember this device</label>
                            </div>

                            <button type="submit" class="login100-form-btn">Secure Sign In</button>

                            <button type="button" class="auth-switch-link" data-auth-tab="register">
                                New hairstylist? Register here
                            </button>
                        </form>
                    </div>

                    <!-- Register -->
                    <div id="register-panel" class="auth-panel">
                        <p class="register-intro">
                            Join as a hairstylist to view available chairs and place workspace orders with Eladé Studio.
                        </p>

                        <form method="POST" action="{{ route('register.hairstylist') }}" class="ajaxForm" id="register-form">
                            @csrf

                            <div class="register-grid">
                                <div class="form-group-custom span-full">
                                    <label for="reg_name">Full Name</label>
                                    <input name="name" type="text" placeholder="Your full name" id="reg_name" required>
                                </div>

                                <div class="form-group-custom span-full">
                                    <label for="reg_email">Email Address</label>
                                    <input name="email" type="email" placeholder="stylist@email.com" id="reg_email" required>
                                </div>

                                <div class="form-group-custom span-full">
                                    <label for="reg_mobile">Mobile Number</label>
                                    <input name="mobile" type="text" placeholder="+44 7700 900000" id="reg_mobile">
                                </div>

                                <div class="form-group-custom">
                                    <label for="reg_password">Password</label>
                                    <input name="password" type="password" placeholder="Min. 6 chars" id="reg_password" required>
                                    <a href="javascript:void(0)" class="password-toggle-btn toggle-password" data-target="#reg_password">
                                        <i class="zmdi zmdi-eye-off"></i>
                                    </a>
                                </div>

                                <div class="form-group-custom">
                                    <label for="reg_password_confirmation">Confirm</label>
                                    <input name="password_confirmation" type="password" placeholder="Re-enter" id="reg_password_confirmation" required>
                                    <a href="javascript:void(0)" class="password-toggle-btn toggle-password" data-target="#reg_password_confirmation">
                                        <i class="zmdi zmdi-eye-off"></i>
                                    </a>
                                </div>
                            </div>

                            <button type="submit" class="login100-form-btn">Register as Hairstylist</button>

                            <button type="button" class="auth-switch-link" data-auth-tab="login">
                                Already have an account? Sign in
                            </button>
                        </form>
                    </div>
                </div>

                <div class="login-shell-footer">
                    &copy; 2026 <strong>Eladé Studio</strong> &mdash; Premium Quality &bull; Stylists First
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('assets/js/myhelper-script.js') }}"></script>

    <script>
        $(document).ready(function() {
            const $authBody = $('.auth-body');

            function switchAuthTab(tab) {
                $('.auth-tab-btn').removeClass('active');
                $('.auth-tab-btn[data-auth-tab="' + tab + '"]').addClass('active');
                $('.auth-panel').removeClass('active');
                $('#' + tab + '-panel').addClass('active');
                $('#auth-subtitle').text(tab === 'register' ? 'Hairstylist Registration' : 'Premium Salon Portal');
                $authBody.scrollTop(0);
            }

            $(document).on('click', '[data-auth-tab]', function() {
                switchAuthTab($(this).data('auth-tab'));
            });

            if (new URLSearchParams(window.location.search).get('tab') === 'register') {
                switchAuthTab('register');
            }

            $('.ajaxForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const btn = form.find('button[type="submit"]');
                const originalText = btn.text();
                const isRegister = form.attr('id') === 'register-form';

                btn.prop('disabled', true).text(isRegister ? 'Registering...' : 'Signing in...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    complete: function() {
                        btn.prop('disabled', false).text(originalText);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        ajaxErrorHandling(jqXHR, errorThrown);
                    },
                    success: function(data) {
                        if (data.show_login) {
                            toast(data.success, 'Success!', 'success', 2500);
                            form[0].reset();
                            switchAuthTab('login');
                            if (data.email) $('#email').val(data.email);
                            return;
                        }
                        if (data.redirect !== undefined) {
                            toast(data.success, 'Success!', 'success', 1200);
                            setTimeout(function() { window.location = data.redirect; }, 600);
                        } else if (data.error !== undefined) {
                            toast(data.error, 'Error!', 'error');
                        } else if (data.errors !== undefined) {
                            multiple_errors_ajax_handling(data.errors);
                        }
                    }
                });
            });

            $(document).on('click', '.toggle-password', function(e) {
                e.preventDefault();
                const input = $($(this).data('target'));
                const icon = $(this).find('i');
                const isPassword = input.attr('type') === 'password';
                input.attr('type', isPassword ? 'text' : 'password');
                icon.toggleClass('zmdi-eye-off zmdi-eye', isPassword);
            });

            const remembered = localStorage.getItem('rememberedEmail');
            if (remembered) {
                $('#email').val(remembered);
                $('#user-checkbox').prop('checked', true);
            }
            $('#user-checkbox').on('change', function() {
                if (this.checked) {
                    localStorage.setItem('rememberedEmail', $('#email').val());
                } else {
                    localStorage.removeItem('rememberedEmail');
                }
            });
        });
    </script>
</body>

</html>
