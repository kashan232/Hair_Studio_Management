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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">

    <!-- TITLE -->
    <title>Eladé Studio - Premium Salon Dashboard</title>
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

    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
</head>

<body class="app sidebar-mini ltr light-mode">

    <!--{ Pre-loder start }-->
    <div id="global-loader">
        <img src="{{ asset('assets/images/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!--{ Pre-loder end }-->
 
    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
          
        
        
        
        



      @include('layouts.navbar')
   
       @include('layouts.sidebar')
      


          @yield('content')
         
 </div>
    </div>


    

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-md-12 col-sm-12 text-center">
                    <div>Copyright © <span id="year"></span> <a href="javascript:void(0)">ELADÉ STUDIO</a>. All rights reserved.</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER END -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>   

    <!--{ JQUERY JS }-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!--{ BOOTSTRAP JS }-->
    <script src="{{ asset('assets/js/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--{ SPARKLINE JS }-->
    <script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
    <!--{ Sticky js }-->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>
    <!--{ CHART-CIRCLE JS }-->
    <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>
    <!--{ PIETY CHART JS }-->
    <script src="{{ asset('assets/js/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/peitychart/peitychart.init.js') }}"></script>
    <!--{ SIDEBAR JS }-->
    <script src="{{ asset('assets/js/plugins/sidebar/sidebar.js') }}"></script>
    <!-- Perfect SCROLLBAR JS-->
    <script src="{{ asset('assets/js/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/p-scroll/pscroll.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/p-scroll/pscroll-1.js') }}"></script>
    <!--{ INTERNAL CHARTJS CHART JS }-->
    <script src="{{ asset('assets/js/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart/utils.js') }}"></script>
    <!--{ Select2 js }-->
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/select2.init.js') }}"></script>
    <!--{  INTERNAL Data tables js }-->
    <script src="{{ asset('assets/js/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <!--{ INTERNAL APEXCHART JS }-->
    @if (Route::currentRouteName() !== 'dashboard')
    <script src="{{ asset('assets/js/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexchart/irregular-data-series.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/dashboard.sampledata.js') }}"></script>
    <!--{ INTERNAL Vector js }-->
    <script src="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!--{ SIDE-MENU JS }-->
    <script src="{{ asset('assets/js/plugins/sidemenu/sidemenu.js') }}"></script>
    <!--{ Color Theme js }-->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>
    <!--{ CUSTOM JS }-->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!--{ Custom-switcher }-->
    <script src="{{ asset('assets/js/custom-swicher.js') }}"></script>
    <!--{ Switcher js }-->
    <script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>


    <script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/myhelper-script.js')}}"></script>
    <script>
        $('.ajaxForm').submit(function(e) {
            e.preventDefault();
            $('.ajaxForm button[type="submit"]').prop('disabled', true);
            var url = $(this).attr('action');
            var formData = new FormData(this);
            my_ajax(url, formData, 'post', function(res) {}, true);
            $('.ajaxForm button[type="submit"]').prop('disabled', true);
        });
    </script>
    @yield('JScript')
    
    <!-- Global Cookie Consent -->
    @include('partials.cookie-consent')
</body>

</html>

