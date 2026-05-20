<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Hair Studio Management - Premium Salon Portal">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">

    <!-- TITLE -->
    <title>Login | Eladé Studio</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('assets/css/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --elade-gold: #c6a34d;
            --elade-dark: #121212;
            --elade-charcoal: #1e1c19;
            --elade-sand: #f4efe6;
            --elade-cream: #faf7f2;
        }

        html, body {
            overflow: hidden !important;
            height: 100vh !important;
            margin: 0;
            padding: 0;
            background-color: var(--elade-sand) !important;
        }

        body {
            font-family: 'Montserrat', sans-serif !important;
        }

        .login-page-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* Split Screen Left - Hero image */
        .login-hero-side {
            flex: 1.3;
            background: linear-gradient(rgba(18, 18, 18, 0.35), rgba(18, 18, 18, 0.75)), 
                        url('https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=1200&q=80') no-repeat center center;
            background-size: cover;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 5rem;
            color: #fff;
        }

        .login-hero-side::before {
            content: '';
            position: absolute;
            top: 30px; left: 30px; right: 30px; bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            pointer-events: none;
        }

        .hero-top-meta {
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--elade-gold);
            font-weight: 600;
            z-index: 2;
        }

        .hero-brand-wrap {
            z-index: 2;
        }

        .hero-brand {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            font-weight: 300;
            letter-spacing: 12px;
            color: #fff;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .hero-tagline {
            font-size: 1.05rem;
            max-width: 500px;
            line-height: 1.7;
            font-weight: 300;
            color: #e0d5c1;
            letter-spacing: 0.5px;
        }

        /* Split Screen Right - Form side */
        .login-form-side {
            flex: 1;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem 5rem;
            position: relative;
            overflow-y: auto;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            background: transparent;
            border: none;
        }

        .form-brand-header {
            text-align: left;
            margin-bottom: 3.5rem;
        }

        .form-brand-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 400;
            letter-spacing: 6px;
            color: var(--elade-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .form-brand-header p {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #8c7e6c;
            font-weight: 600;
            margin: 0;
        }

        /* Unique Boutique Input Styling (Only bottom border) */
        .form-group-custom {
            position: relative;
            margin-bottom: 2rem;
            border-bottom: 1px solid #dcd3be;
            transition: border-color 0.3s;
        }

        .form-group-custom:focus-within {
            border-bottom-color: var(--elade-gold);
        }

        .form-group-custom label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #8c7e6c;
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: block;
        }

        .form-group-custom input {
            width: 100%;
            border: none !important;
            background: transparent !important;
            outline: none !important;
            font-size: 0.95rem;
            color: var(--elade-dark);
            padding: 0.5rem 0;
            font-weight: 500;
            box-shadow: none !important;
        }

        .form-group-custom input::placeholder {
            color: #b8ac95 !important;
            opacity: 0.6;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0;
            bottom: 0.5rem;
            color: #8c7e6c;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: var(--elade-gold);
        }

        .login100-form-btn {
            background: var(--elade-dark) !important;
            color: #fff !important;
            border: 1px solid var(--elade-dark) !important;
            border-radius: 0px !important;
            font-weight: 600 !important;
            height: 56px !important;
            letter-spacing: 3px !important;
            text-transform: uppercase !important;
            font-size: 0.8rem !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            cursor: pointer;
            margin-top: 1rem;
        }

        .login100-form-btn:hover {
            background: var(--elade-gold) !important;
            border-color: var(--elade-gold) !important;
            color: #fff !important;
            transform: translateY(-2px);
        }

        .form-check-label {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #8c7e6c !important;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-check-input {
            border-radius: 0px !important;
            border-color: #dcd3be !important;
        }

        .form-check-input:checked {
            background-color: var(--elade-gold) !important;
            border-color: var(--elade-gold) !important;
        }

        .footer-note {
            text-align: left;
            margin-top: 3.5rem;
            font-size: 0.65rem;
            color: #a0937d;
            letter-spacing: 1.5px;
            line-height: 1.8;
            text-transform: uppercase;
            border-top: 1px solid #faf7f2;
            padding-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .login-hero-side {
                display: none;
            }
            .login-form-side {
                flex: 1;
                padding: 3rem 1.5rem;
            }
            html, body {
                overflow-y: auto !important;
                height: auto !important;
            }
        }
    </style>
</head>

<body>

    <div class="login-page-container">
        
        <!-- Left Side: Hero Brand -->
        <div class="login-hero-side">
            <div class="hero-top-meta">LONDON, UK</div>
            <div class="hero-brand-wrap">
                <div class="hero-brand">Eladé Studio</div>
                <div class="hero-tagline">
                    Control your schedule. Elevate your standard. Book luxury workspace without long-term commitments.
                </div>
            </div>
            <div class="hero-top-meta">&copy; 2026 ELADÉ STUDIO</div>
        </div>

        <!-- Right Side: Luxury Form -->
        <div class="login-form-side">
            <div class="login-card">
                
                <div class="form-brand-header">
                    <h2>Eladé Studio</h2>
                    <p>PREMIUM SALON PORTAL</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="ajaxForm">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group-custom">
                        <label for="email">Email Address</label>
                        <input name="email" type="email" placeholder="e.g. name@eladeuk.com" id="email" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group-custom">
                        <label for="password">Password</label>
                        <input name="password" type="password" placeholder="Enter security password" id="password" required>
                        <a href="javascript:void(0)" class="password-toggle-btn toggle-password">
                            <i class="zmdi zmdi-eye-off" aria-hidden="true"></i>
                        </a>
                    </div>

                    <!-- Remember Me -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="user-checkbox">
                            <label class="form-check-label text-muted" for="user-checkbox">
                                REMEMBER THIS DEVICE
                            </label>
                        </div>
                    </div>

                    <!-- Sign In Button -->
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn w-100">
                            SECURE SIGN IN
                        </button>
                    </div>

                    <!-- Footer Note -->
                    <div class="footer-note">
                        &copy; 2026 <strong>Eladé Studio</strong><br>
                        Powered by Luxury Salon Portal Inc.<br>
                        <small class="fw-bold mt-1 d-block" style="letter-spacing: 2px;">Premium Quality &bull; Stylists First</small>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- JQUERY JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('assets/js/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    
    <script src="{{ asset('assets/js/myhelper-script.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.ajaxForm').submit(function(e) {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.html();
                btn.prop('disabled', true).html('AUTHENTICATING... <span class="spinner-border spinner-border-sm ms-2"></span>');
                
                var url = $(this).attr('action');
                var formData = new FormData(this);
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    complete: function () {
                        btn.prop('disabled', false).html(originalText);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        ajaxErrorHandling(jqXHR, errorThrown);
                    },
                    success: function (data) {
                        if (data['redirect'] !== undefined) {
                            toast(data['success'], "Success!", 'success', 1200);
                            setTimeout(function () {
                                window.location = data['redirect'];
                            }, 600);
                        } else if (data['error'] !== undefined) {
                            toast(data['error'], "Error!", 'error');
                        } else if (data['errors'] !== undefined) {
                            multiple_errors_ajax_handling(data['errors']);
                        }
                    }
                });
            });

            // Password toggle logic
            $(document).on('click', '.toggle-password', function(e) {
                e.preventDefault();
                const input = $('#password');
                const icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('zmdi-eye-off').addClass('zmdi-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('zmdi-eye').addClass('zmdi-eye-off');
                }
            });

            // Remember Me
            var email = localStorage.getItem('rememberedEmail');
            if (email) {
                $('#email').val(email);
                $('#user-checkbox').prop('checked', true);
            }
            $('#user-checkbox').change(function() {
                if ($(this).is(':checked')) {
                    localStorage.setItem('rememberedEmail', $('#email').val());
                } else {
                    localStorage.removeItem('rememberedEmail');
                }
            });
        });
    </script>
</body>

</html>
