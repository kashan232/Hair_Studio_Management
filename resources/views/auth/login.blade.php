

<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="E-ABIANA – Digitization of Abiana Record">
    <meta name="author" content="NCAWB">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">

    <!-- TITLE -->
    <title>Login | E-ABIANA - Nara Canal Area Water Board</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('assets/css/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- STYLE CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- INTERNAL Switcher css -->
    <link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #01411C;
        }
        
        body.login-img {
            background: url('{{ asset("assets/images/backgrounds/nara_canal.png") }}') no-repeat center center fixed !important;
            background-size: cover !important;
            font-family: 'Outfit', sans-serif !important;
        }

        body.login-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(1, 65, 28, 0.4), rgba(30, 64, 175, 0.4));
            z-index: 0;
        }

        .page.auth-page {
            position: relative;
            z-index: 1;
        }

        .login-wrap-main {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 0 !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
        }

        .auth-logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .auth-logo-container img {
            max-height: 80px;
            width: auto;
            object-fit: contain;
            mix-blend-mode: multiply;
            filter: contrast(1.1);
        }

        .project-title {
            text-align: center;
            margin-bottom: 15px;
        }

        .project-title h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-color);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .project-title p {
            font-size: 0.9rem;
            color: #4b5563;
            margin-top: 5px;
            font-weight: 500;
        }

        .login-form-title {
            font-weight: 700 !important;
            color: #1f2937 !important;
            font-size: 1.2rem !important;
            padding-bottom: 15px !important;
        }

        .login100-form-btn {
            background: var(--primary-color) !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            height: 50px !important;
            box-shadow: 0 10px 15px -3px rgba(1, 65, 28, 0.3) !important;
        }

        .login100-form-btn:hover {
            background: #012a12 !important;
            transform: translateY(-2px);
        }

        .wrap-input {
            border-radius: 10px !important;
            overflow: hidden;
            margin-bottom: 20px !important;
        }

        .input-group-text {
            border: none !important;
            background: #f3f4f6 !important;
        }

        .input100 {
            height: 50px !important;
            font-size: 0.95rem !important;
        }

        .footer-note {
            text-align: center;
            margin-top: 15px;
            font-size: 0.75rem;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>

<body class="app sidebar-mini ltr light-mode login-img">

    <!--{ Switcher Start }-->
    <div class="switcher-wrapper">
        <!-- Switcher content remains as per original template to maintain "format" -->
        <div class="demo_changer">
            <div class="p-4 m-0 lh-1 border-start template-customizer-header position-relative py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="template-customizer-t-panel_header mb-2">Template Customizer</h3>
                    <p class="template-customizer-t-panel_sub_header mb-0">Customize and preview in real time</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="javascript:void(0)" id="ThemeReset" class="text-danger"><i class="fe fe-refresh-ccw fs-17 text-danger"></i></a>
                </div>
            </div>
            <div class="form_holder sidebar-right1 ps ps--active-y">
                <div class="row">
                    <div class="predefined_styles">
                        <!-- Color palette, theme styles, etc. -->
                        <div class="swichermainleft">
                            <h4 class="mt-0"><i class="zmdi zmdi-invert-colors"></i> Color palette</h4>
                            <div class="skin-body theme-colors">
                                <div class="switch_section">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <div class="form-check p-0"> 
                                            <input class="form-check-input color-input color-primary-1" type="radio" name="theme-primary" id="switcher-primary1"> 
                                        </div>
                                        <div class="form-check p-0"> 
                                            <input class="form-check-input color-input color-primary-2" type="radio" name="theme-primary" id="switcher-primary2"> 
                                        </div>
                                        <div class="form-check p-0"> 
                                            <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary" id="switcher-primary3"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Other switcher options... -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--{ Switcher End }-->

    <div class="page auth-page">
        <div class="login-container">
            <div class="card login-wrap-main p-4">
                
                <div class="auth-logo-container">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQi5ueEUcsB3jj5hxnLTHXUY4ZpVE87aON_Q&s" alt="Gov of Sindh">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThQvNSJVCfq0OJK34GPAfdPponLvA_lC5Hzw&s" alt="SIDA">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLbY1OsztKQ05-7knkY0ksVtFGJP_0PmGVzg&s" alt="NCAWB">
                </div>

                <div class="project-title">
                    <h1>E-ABIANA</h1>
                    <p>Digitization of Abiana Record<br><strong>Nara Canal Area Water Board</strong></p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="ajaxForm">
                    @csrf
                    
                    <span class="login-form-title text-center d-block">
                        Account Login
                    </span>

                    <div class="panel panel-primary">
                        <div class="panel-body tabs-menu-body p-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab5">
                                    <div class="wrap-input validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 form-control ms-0" name="email" type="email" placeholder="Email Address" id="email" required>
                                    </div>

                                    <div class="wrap-input validate-input input-group" id="Password-toggle">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted toggle-password">
                                            <i class="zmdi zmdi-eye-off text-muted" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 form-control ms-0" name="password" type="password" placeholder="Password" id="password" required>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="user-checkbox">
                                            <label class="form-check-label text-muted" for="user-checkbox" style="font-size: 0.85rem;">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="container-login100-form-btn">
                                        <button type="submit" class="login100-form-btn btn-primary w-100">
                                            Secure Login
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer-note">
                        &copy; 2026 <strong>Nara Canal Area Water Board</strong><br>
                        Sindh Irrigation & Drainage Authority (SIDA)<br>
                        <small class="fw-bold text-uppercase mt-2 d-block" style="letter-spacing: 1px;">Powered by XCL TECHNOLOGIES</small>
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
    <!-- Perfect SCROLLBAR JS-->
    <script src="{{ asset('assets/js/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
    <!-- Color Theme js -->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>
    <!-- Custom-switcher -->
    <script src="{{ asset('assets/js/custom-swicher.js') }}"></script>
    <!-- Switcher js -->
    <script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    
    <script src="{{ asset('assets/js/myhelper-script.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.ajaxForm').submit(function(e) {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.html();
                btn.prop('disabled', true).html('Authenticating... <span class="spinner-border spinner-border-sm ms-2"></span>');
                
                var url = $(this).attr('action');
                var formData = new FormData(this);
                my_ajax(url, formData, 'post', function(res) {
                    if(!res.success) {
                        btn.prop('disabled', false).html(originalText);
                    }
                }, true);
            });

            // Password toggle logic for this template
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




