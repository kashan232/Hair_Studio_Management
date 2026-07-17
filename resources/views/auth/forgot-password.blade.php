<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password | Eladé Studio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">

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

        /* Top Navbar */
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
            line-height: 1.5;
        }

        /* Forms */
        .auth-form-wrap {
            max-width: 600px;
            margin: 0 auto;
        }

        .auth-form {
            display: block;
            animation: fadeIn 0.4s ease forwards;
            text-align: left;
        }

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
            border-radius: 0; 
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
        
        .alert-success {
            margin-bottom: 1.5rem;
            color: #155724;
            font-size: 0.95rem;
            font-weight: 500;
            text-align: center;
            background: #d4edda;
            padding: 1rem;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            margin-bottom: 1.5rem;
            color: #721c24;
            font-size: 0.95rem;
            font-weight: 500;
            text-align: center;
            background: #f8d7da;
            padding: 1rem;
            border: 1px solid #f5c6cb;
        }

        /* Premium Side Menu Styles */
        .side-menu-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(18, 18, 18, 0.6); backdrop-filter: blur(4px); z-index: 998; opacity: 0; visibility: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .side-menu-overlay.active { opacity: 1; visibility: visible; }
        .side-menu { position: fixed; top: 0; left: -400px; width: 400px; height: 100%; background: #ffffff; z-index: 999; box-shadow: 5px 0 40px rgba(0,0,0,0.15); transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; overflow-y: auto; max-width: 100vw; }
        .side-menu.active { left: 0; }
        .side-menu-header { padding: 1.8rem 2.5rem; background: #ffffff; border-bottom: 1px solid rgba(70, 17, 17, 0.08); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; }
        .close-menu { cursor: pointer; font-size: 1.6rem; color: #888; transition: all 0.3s ease; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #f8f8f8; }
        .close-menu:hover { color: #fff; background: #461111; transform: rotate(90deg); }
        .side-menu-content { padding: 2.5rem; }
        .side-welcome-box { background: linear-gradient(145deg, #faf8f5 0%, #fffdf9 100%); border-left: 4px solid #461111; padding: 1.5rem; margin-bottom: 2.5rem; border-radius: 0 12px 12px 0; }
        .side-welcome-box p { font-size: 0.95rem; color: #555; line-height: 1.7; margin: 0; font-style: italic; }
        .side-menu-content h4 { font-size: 0.85rem; color: #461111; margin-top: 0; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 800; display: flex; align-items: center; gap: 10px; }
        .side-menu-content h4::after { content: ""; flex: 1; height: 1px; background: rgba(70, 17, 17, 0.1); }
        .info-card { display: flex; align-items: flex-start; margin-bottom: 1.2rem; gap: 1rem; padding: 1.2rem; border-radius: 12px; background: #ffffff; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .info-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(70, 17, 17, 0.08); border-color: rgba(70, 17, 17, 0.1); }
        .info-icon-wrap { width: 42px; height: 42px; border-radius: 10px; background: rgba(70, 17, 17, 0.05); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .info-icon-wrap i { font-size: 1.3rem; color: #461111; }
        .info-details { font-size: 0.9rem; color: #666; line-height: 1.5; }
        .info-details strong { display: block; font-weight: 700; color: #111; margin-bottom: 4px; font-size: 0.95rem; }
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
        
        <h1 class="page-title">Reset Password</h1>
        <p class="page-subtitle">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.</p>

        <div class="auth-form-wrap">
            
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="input-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                </div>

                <button type="submit" class="btn-submit">Email Password Reset Link</button>
                
                <a href="{{ route('login') }}" class="switch-link" style="text-decoration: none;">Back to Login</a>
            </form>
            
        </div>

    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.menu-icon').on('click', function() {
                $('#side-menu').addClass('active');
                $('#side-menu-overlay').addClass('active');
            });

            $('#close-menu, #side-menu-overlay').on('click', function() {
                $('#side-menu').removeClass('active');
                $('#side-menu-overlay').removeClass('active');
            });
        });
    </script>
</body>
</html>
