<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password | Eladé Studio</title>

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

    </style>
</head>

<body>

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
</body>
</html>
