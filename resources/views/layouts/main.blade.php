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

    <link rel="stylesheet" href="{{asset('')}}assets/plugins/sweetalert2/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')


</head>

<body class="app sidebar-mini ltr light-mode">

    <!--{ Pre-loder start }-->
    <div id="global-loader">
        <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
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
                    <div>Copyright © <span id="year"></span> <a href="javascript:void(0)">Dashmaster</a>. Designed with <span class="fa fa-heart text-danger"></span> by <a href="javascript:void(0)"> techneinfosys </a> All rights reserved.</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER END -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>   

    <!--{ JQUERY JS }-->
    <script src="../assets/js/jquery.min.js"></script>
<!--{ BOOTSTRAP JS }-->
    <script src="../assets/js/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/js/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--{ SPARKLINE JS }-->
    <script src="../assets/js/jquery.sparkline.min.js"></script>
    <!--{ Sticky js }-->
    <script src="../assets/js/sticky.js"></script>
    <!--{ CHART-CIRCLE JS }-->
    <script src="../assets/js/circle-progress.min.js"></script>
    <!--{ PIETY CHART JS }-->
    <script src="../assets/js/plugins/peitychart/jquery.peity.min.js"></script>
    <script src="../assets/js/plugins/peitychart/peitychart.init.js"></script>
    <!--{ SIDEBAR JS }-->
    <script src="../assets/js/plugins/sidebar/sidebar.js"></script>
    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/js/plugins/p-scroll/perfect-scrollbar.js"></script>
    <script src="../assets/js/plugins/p-scroll/pscroll.js"></script>
    <script src="../assets/js/plugins/p-scroll/pscroll-1.js"></script>
    <!--{ INTERNAL CHARTJS CHART JS }-->
    <script src="../assets/js/plugins/chart/Chart.bundle.js"></script>
    <script src="../assets/js/plugins/chart/utils.js"></script>
    <!--{ Select2 js }-->
    <script src="../assets/js/plugins/select2/select2.full.min.js"></script>
    <script src="../assets/js/plugins/select2/select2.init.js"></script>
    <!--{  INTERNAL Data tables js }-->
    <script src="../assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="../assets/js/plugins/datatable/dataTables.bootstrap5.min.js"></script>
    <!--{ INTERNAL APEXCHART JS }-->
    <script src="../assets/js/apexcharts.js"></script>
    <script src="../assets/js/plugins/apexchart/irregular-data-series.js"></script>
    <script src="../assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="../assets/js/plugins/flot/jquery.flot.fillbetween.js"></script>
    <script src="../assets/js/plugins/flot/chart.flot.sampledata.js"></script>
    <script src="../assets/js/plugins/flot/dashboard.sampledata.js"></script>
    <!--{ INTERNAL Vector js }-->
    <script src="../assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!--{ SIDE-MENU JS }-->
    <script src="../assets/js/plugins/sidemenu/sidemenu.js"></script>
    <!--{ INTERNAL INDEX JS }-->
    <script src="../assets/js/index1.js"></script>
    <!--{ Color Theme js }-->
    <script src="../assets/js/themeColors.js"></script>
    <!--{ CUSTOM JS }-->
    <script src="../assets/js/custom.js"></script>
    <!--{ Custom-switcher }-->
    <script src="../assets/js/custom-swicher.js"></script>
    <!--{ Switcher js }-->
    <script src="../assets/switcher/js/switcher.js"></script>


    <script src="{{asset('')}}assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{asset('')}}assets/js/myhelper-script.js"></script>
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
</body>

</html>

