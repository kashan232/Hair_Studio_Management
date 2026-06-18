<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Hair Studio Management - Premium Salon Portal">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">
    <title>Reset Password | Eladé Studio</title>

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
            color: var(--brand-primary);
            cursor: pointer;
            position: relative;
        }

        .auth-body {
            padding: 2rem;
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

            <div class="auth-tabs" style="border-bottom:none; margin-bottom: 0;">
                <button class="tab-btn active" style="pointer-events: none; padding-bottom: 0;">Create New Password</button>
            </div>

            <div class="auth-body">
                @if ($errors->any())
                    <div style="margin-bottom: 1.5rem; color: #c62828; font-size: 0.85rem; font-weight: 600; text-align: center; background: #ffebee; padding: 0.8rem; border-radius: 8px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="input-group">
                        <input type="email" name="email" id="email" placeholder=" " value="{{ old('email', $request->email) }}" required autofocus>
                        <label for="email">Email Address</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder=" " required>
                        <label for="password">New Password</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required>
                        <label for="password_confirmation">Confirm Password</label>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:0;">Reset Password</button>

                    <a href="{{ route('login') }}" class="btn-outline">Back to Login</a>
                </form>
            </div>
            
        </div>
    </div>

</body>
</html>
