
<!doctype html>
<html lang="en" dir="ltr">

<head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Dashmaster – Bootstrap 5  Admin & Dashboard Template">
        <meta name="author" content="Techne Infosys">
        <meta name="keywords"
            content="admin template, Dashmaster admin template, dashboard template, flat admin template, responsive admin template, web app">

        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/favicon.ico">

        <!-- TITLE -->
        <title>Dashmaster – Bootstrap 5 Admin & Dashboard Template </title>
    <!-- BOOTSTRAP CSS -->
    <link id="style" href="../assets/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="../assets/css/plugins.css" rel="stylesheet">

    <!--- FONT-ICONS CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet">

    <!-- INTERNAL Switcher css -->
    <link href="../assets/switcher/css/switcher.css" rel="stylesheet">
    <link href="../assets/switcher/demo.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body class="app sidebar-mini ltr light-mode login-img">

     <!--{ Switcher Start }-->
     <div class="switcher-wrapper">
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
                                        <div class="form-check p-0"> 
                                            <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary" id="switcher-primary4"> 
                                        </div>
                                        <div class="form-check p-0"> 
                                            <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary" id="switcher-primary5"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4> <i class="ti ti-directions"></i> LTR and RTL VERSIONS</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex"> <span class="me-auto">LTR Version</span>
                                        <label for="myonoffswitch23" class="switch switch-square">
                                            <input type="radio" name="onoffswitch7" id="myonoffswitch23"
                                                class="switch-input" checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">RTL Version</span>
                                        <label for="myonoffswitch24" class="switch switch-square">
                                            <input type="radio" name="onoffswitch7" id="myonoffswitch24"
                                                class="switch-input">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4> <i class="fe fe-sun"></i> Light Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex"> <span class="me-auto">Light Theme</span>
                                        <label for="myonoffswitch1"  class="switch switch-square">
                                            <input type="radio" name="onoffswitch1" id="myonoffswitch1" class="switch-input" checked=""> 
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span> 
                                        </label> 
                                    </div>
                               
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4> <i class="ti ti-moon-stars"></i> Dark Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2"> <span class="me-auto">Dark Theme</span>
                                        <label for="myonoffswitch2" class="switch switch-square">
                                            <input type="radio" name="onoffswitch1" id="myonoffswitch2" class="switch-input"> 
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span> 
                                        </label> 
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                  
                        <div class="swichermainleft">
                            <h4>Menu Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle lightMenu d-flex"> <span class="me-auto">Light Menu</span>
                                        <label for="myonoffswitch3" class="switch switch-square">
                                            <input type="radio" name="onoffswitch2" id="myonoffswitch3" class="switch-input" checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="switch-toggle darkMenu d-flex mt-2">
                                        <span class="me-auto">Dark Menu</span>
                                        <label for="myonoffswitch5" class="switch switch-square">
                                            <input type="radio" name="onoffswitch2" id="myonoffswitch5"
                                                class="switch-input">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4> <i class="ti ti-brush"></i> Header Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle lightHeader d-flex">
                                        <span class="me-auto">Light Header</span>
                                        <label for="myonoffswitch6" class="switch switch-square">
                                            <input type="radio" name="onoffswitch3" id="myonoffswitch6" class="switch-input" checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="switch-toggle darkHeader d-flex mt-2">
                                        <span class="me-auto">Dark Header</span>
                                        <label for="myonoffswitch8" class="switch switch-square">
                                            <input type="radio" name="onoffswitch3" id="myonoffswitch8" class="switch-input">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--{ Switcher End }-->

    <div class="">
        <!-- PAGE -->
        <div class="page auth-page">
            <div class="">
                <!-- Theme-Layout -->
                <!-- CONTAINER OPEN -->
                <div class="login-container">
                    <div class="card login-wrap-main  p-6">
                        <div class="text-center mb-5 auth-logo">
                            <a href="index.html">
                                <img src="../assets/images/brand/logo-white.png" class="header-brand-img light-logo" alt="demo">
                                <img src="../assets/images/brand/logo-dark.png" class="header-brand-img dark-logo" alt="demo">
                            </a>
                        </div>
                        <form   method="post" action="{{route('login')}}" class="ajaxForm">

                            <span class="login-form-title pb-5">
                                Login
                            </span>
                            <div class="panel panel-primary">
                                <!-- <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        
                                        <ul class="nav panel-tabs justify-content-center">
                                            <li class="mx-0"><a href="#tab5" class="active"
                                                    data-bs-toggle="tab">Email</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input validate-input input-group"
                                                data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)"
                                                    class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0" name="email" type="email"
                                                    placeholder="Email">
                                            </div>
                                            <div class="wrap-input validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)"
                                                    class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye-off text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0" name="password" type="password"
                                                    placeholder="Password">
                                            </div>
                                            <div class="text-end pt-4">
                                                <!-- <p class="mb-0"><a href="forgot-password.html"
                                                        class="text-primary ms-1">Forgot Password?</a></p> -->
                                            </div>
                                            <div class="container-login100-form-btn">
                                                <button type="submit"  class="login100-form-btn btn-primary">
                                                    Login
</button>
                                            </div>
                                         
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>


    <!--{ JQUERY JS }-->
    <script src="../assets/js/jquery.min.js"></script>
    <!--{ BOOTSTRAP JS }-->
    <script src="../assets/js/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/js/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/js/plugins/p-scroll/perfect-scrollbar.js"></script>
    <!--{ Color Theme js }-->
    <script src="../assets/js/themeColors.js"></script>
    <!-- { Show Password js } -->
    <script src="../assets/js/show-password.min.js"></script>
    <!-- { Genrate OTP JS } -->
    <script src="../assets/js/generate-otp.js"></script>
    <!--{ Custom-switcher }-->
    <script src="../assets/js/custom-swicher.js"></script>
    <!--{ Switcher js }-->
    <script src="../assets/switcher/js/switcher.js"></script>

    <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="assets/js/myhelper-script.js"></script>
  <script>
     $('.ajaxForm').submit(function(e) {
         e.preventDefault();
        $('.ajaxForm button[type="submit"]').prop('disabled', true);
        var url = $(this).attr('action');
        var formData = new FormData(this);
        my_ajax(url, formData, 'post', function(res) {
        },true);
        $('.ajaxForm button[type="submit"]').prop('disabled', false);
    });

    $(document).ready(function() {

        $(document).on('click', '.toggle-password', function () {
            const $button = $(this);
            const $input = $button.siblings('input');
            const $icon = $button.find('i');

            if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
            } else {
            $input.attr('type', 'password');
            $icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
            }
        });

        var email = localStorage.getItem('rememberedEmail');
        if (email) {
            $('#email').val(email);
            $('#user-checkbox').prop('checked', true);
        }else{
            $('#user-checkbox').prop('checked', false);
        }
        if ($('#user-checkbox').prop('checked') && localStorage.getItem('rememberedEmail')) {
            $('#email').val(localStorage.getItem('rememberedEmail'));
        }
        // Update rememberedEmail on "Remember Me" checkbox change
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


