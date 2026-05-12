
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
</head>

<body class="app sidebar-mini ltr light-mode">

    <!--{ Pre-loder start }-->
    <div id="global-loader">
        <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!--{ Pre-loder end }-->
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
    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
           
             <!--{ app header start }-->
            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar"
                            href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-grid status_toggle middle sidebar-toggle">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </a>
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal " href="index.html">
                            <img src="../assets/images/brand/logo-white.png" class="header-brand-img desktop-logo"
                                alt="logo">
                            <img src="../assets/images/brand/logo-dark.png" class="header-brand-img light-logo1"
                                alt="logo">
                        </a>
                        <!-- LOGO -->
                        <div class="main-header-center ms-3 d-none d-lg-block">
                            <input type="text" class="form-control" id="typehead" placeholder="Search for results...">
                            <button class="btn px-0 pt-2"><i class="fe fe-search" aria-hidden="true"></i></button>
                        </div>
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <!-- SEARCH -->
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        <div class="dropdown d-lg-none d-flex">
                                            <a href="javascript:void(0)" class="nav-link icon"
                                                data-bs-toggle="dropdown">
                                                <i class="fe fe-search"></i>
                                            </a>
                                            <div class="dropdown-menu header-search dropdown-menu-start">
                                                <div class="input-group w-100 p-2">
                                                    <input type="text" class="form-control" placeholder="Search....">
                                                    <div class="input-group-text btn btn-primary">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex country">
                                            <span class="nav-link icon text-center">
                                                <select id="template-with-flag-icons">
                                                    <option selected value="IN" data-flag="in">India</option>
                                                    <option value="Alaska" data-flag="ad">Alaska</option>
                                                    <option value="Hawaii" data-flag="ae">Hawaii</option>
                                                    <option value="California" data-flag="af">California</option>
                                                    <option value="Nevada" data-flag="ag">Nevada</option>
                                                    <option value="Oregon" data-flag="ao">Oregon</option>
                                                    <option value="Washington" data-flag="at">Washington</option>
                                                    <option value="Indonesia" data-flag="id">Indonesia</option>
                                                </select>
                                            </span>
                                        </div>
                                        <!-- COUNTRY -->
                                        <div class="d-flex">
                                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                                <span class="dark-layout"><i class="ti ti-moon-stars"></i></span>
                                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                                            </a>
                                        </div>
                                        <!-- Theme-Layout -->
                                        <div class="dropdown  d-flex shopping-cart">
                                            <a class="nav-link icon text-center" data-bs-toggle="dropdown">
                                                <i class="fe fe-shopping-cart"></i><span
                                                    class="badge bg-secondary header-badge">4</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading border-bottom">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">My Cart</h6>
                                                        <a class="btn btn-primary w-sm btn-sm py-2"
                                                            href="ecommerce-cart.html"><i
                                                                class="fe fe-shopping-cart"></i> View Cart</a>
                                                    </div>
                                                </div>
                                                <div class="header-dropdown-list message-menu">
                                                    <div class="dropdown-item d-flex p-4">
                                                        <a href="ecommerce-cart.html" class="open-file"></a>
                                                        <span
                                                            class="avatar avatar-xl br-5 me-3 align-self-center cover-image">
                                                            <img src="../assets/images/products/3.jpg" alt="demo" >
                                                        </span>
                                                        <div class="wd-50p">
                                                            <h5 class="mb-1">Yellow polka dot</h5>
                                                            <span>Status: <span class="text-success">In
                                                                    Stock</span></span>
                                                        </div>
                                                        <div class="ms-auto text-end d-flex fs-16">
                                                            <span class="fs-16 text-dark d-none d-sm-block px-4">
                                                                $600
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex p-4">
                                                        <a href="ecommerce-cart.html" class="open-file"></a>
                                                        <span
                                                            class="avatar avatar-xl br-5 me-3 align-self-center cover-image">
                                                            <img src="../assets/images/products/42.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-50p">
                                                            <h5 class="mb-1">Black dress, chic</h5>
                                                            <span>Status: <span class="text-success">In
                                                                    Stock</span></span>
                                                        </div>
                                                        <div class="ms-auto text-end d-flex">
                                                            <span class="fs-16 text-dark d-none d-sm-block px-4">
                                                                $654
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex p-4">
                                                        <a href="ecommerce-cart.html" class="open-file"></a>
                                                        <span
                                                            class="avatar avatar-xl br-5 me-3 align-self-center cover-image">
                                                            <img src="../assets/images/products/43.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-50p">
                                                            <h5 class="mb-1">Sunglasses, stylish, hat</h5>
                                                            <span>Status: <span class="text-success">In
                                                                    Stock</span></span>
                                                        </div>
                                                        <div class="ms-auto text-end d-flex">
                                                            <span class="fs-16 text-dark d-none d-sm-block px-4">
                                                                $320
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex p-4">
                                                        <a href="ecommerce-cart.html" class="open-file"></a>
                                                        <span
                                                            class="avatar avatar-xl br-5 me-3 align-self-center cover-image">
                                                            <img src="../assets/images/products/44.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-50p">
                                                            <h5 class="mb-1">Smiling, dress, pink.</h5>
                                                            <span>Status: <span class="text-success">In
                                                                    Stock</span></span>
                                                        </div>
                                                        <div class="ms-auto text-end d-flex">
                                                            <span class="fs-16 text-dark d-none d-sm-block px-4">
                                                                $1000
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex p-4">
                                                        <a href="ecommerce-cart.html" class="open-file"></a>
                                                        <span
                                                            class="avatar avatar-xl br-5 me-3 align-self-center cover-image">
                                                            <img src="../assets/images/products/45.jpg" alt="demo" class="">
                                                        </span>
                                                        <div class="wd-50p">
                                                            <h5 class="mb-1">Gorgeous, floral, chic.</h5>
                                                            <span>Status: <span class="text-success">In
                                                                    Stock</span></span>
                                                        </div>
                                                        <div class="ms-auto text-end d-flex">
                                                            <span class="fs-16 text-dark d-none d-sm-block px-4">
                                                                $800
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <div class="dropdown-footer text-end">
                                                    <span class="p-2 fs-17 fw-semibold">Total: $9000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CART -->

                                        <div class="dropdown  d-flex notifications">
                                            <a class="nav-link icon" data-bs-toggle="dropdown"><i
                                                    class="fe fe-bell"></i><span class=" pulse"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading border-bottom">
                                                    <div class="d-flex">
                                                        <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">Notifications
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="notifications-menu">
                                                    <div class="d-flex align-items-start dropdown-item">
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-1">
                                                                <a href="#" class="p-0">
                                                                    <h5 class="mb-0">Desktop notification turned on</h5>
                                                                </a>
                                                                <a href="#" class="text-danger p-0"><i
                                                                        class="fe fe-x"></i></a>
                                                            </div>
                                                            <a href=""
                                                                class="p-0 d-flex align-items-end justify-content-between p-12">
                                                                <p class="mb-0 text-muted">
                                                                    Now you will receive desktop notifications
                                                                </p>
                                                                <span class="text-sm ms-2 text-nowrap">1 min ago</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-start dropdown-item">
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-1">
                                                                <a href="#" class="p-0">
                                                                    <h5 class="mb-0">Admin settings</h5>
                                                                </a>
                                                                <a href="#" class="text-danger p-0"><i
                                                                        class="fe fe-x"></i></a>
                                                            </div>
                                                            <a href=""
                                                                class="p-0 d-flex align-items-end justify-content-between p-12">
                                                                <p class="mb-0 text-muted">
                                                                    Setup complete
                                                                </p>
                                                                <span class="text-sm ms-2 text-nowrap">8 min ago</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-start dropdown-item">
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-1">
                                                                <a href="#" class="p-0">
                                                                    <h5 class="mb-0">Mailbox</h5>
                                                                </a>
                                                                <a href="#" class="text-danger p-0"><i
                                                                        class="fe fe-x"></i></a>
                                                            </div>
                                                            <a href=""
                                                                class="p-0 d-flex align-items-end justify-content-between p-12">
                                                                <p class="mb-0 text-muted">
                                                                    you have 15 unread mails.
                                                                </p>
                                                                <span class="text-sm ms-2 text-nowrap">9 min ago</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-start dropdown-item">
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-1">
                                                                <a href="#" class="p-0">
                                                                    <h5 class="mb-0">Order received</h5>
                                                                </a>
                                                                <a href="#" class="text-danger p-0"><i
                                                                        class="fe fe-x"></i></a>
                                                            </div>
                                                            <a href=""
                                                                class="p-0 d-flex align-items-end justify-content-between p-12">
                                                                <p class="mb-0 text-muted">
                                                                    New order received.
                                                                </p>
                                                                <span class="text-sm ms-2 text-nowrap">10 min ago</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-start dropdown-item">
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-1">
                                                                <a href="#" class="p-0">
                                                                    <h5 class="mb-0">Desktop notification turned on</h5>
                                                                </a>
                                                                <a href="#" class="text-danger p-0"><i
                                                                        class="fe fe-x"></i></a>
                                                            </div>
                                                            <a href=""
                                                                class="p-0 d-flex align-items-end justify-content-between p-12">
                                                                <p class="mb-0 text-muted">
                                                                    Now you will receive desktop notifications
                                                                </p>
                                                                <span class="text-sm ms-2 text-nowrap">16 min ago</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a href="basic-alert.html"
                                                    class="dropdown-item text-center p-3 text-muted">View all
                                                    Notification</a>
                                            </div>
                                        </div>
                                        <!-- NOTIFICATIONS -->
                                        <div class="dropdown  d-flex message">
                                            <a class="nav-link icon text-center" data-bs-toggle="dropdown">
                                                <i class="fe fe-message-square"></i><span class="pulse-danger"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading border-bottom">
                                                    <div class="d-flex">
                                                        <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">You have 4
                                                            Messages</h6>
                                                    </div>
                                                </div>
                                                <div class="message-menu message-menu-scroll">
                                                    <a class="dropdown-item d-flex" href="private-chat.html">
                                                        <span
                                                            class="avatar avatar-md  me-3 align-self-center cover-image">
                                                            <img src="../assets/images/profiles/1.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-90p">
                                                            <div class="d-flex">
                                                                <h5 class="mb-1">John Smith</h5>
                                                                <small class="text-muted ms-auto text-end">
                                                                    3:00 am
                                                                </small>
                                                            </div>
                                                            <span>Added new feature to the dashboard...</span>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item d-flex" href="private-chat.html">
                                                        <span
                                                            class="avatar avatar-md  me-3 align-self-center cover-image">
                                                            <img src="../assets/images/profiles/15.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-90p">
                                                            <div class="d-flex">
                                                                <h5 class="mb-1">Emily Johnson</h5>
                                                                <small class="text-muted ms-auto text-end">
                                                                    4:20 am
                                                                </small>
                                                            </div>
                                                            <span>Uploaded photos from the event...</span>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item d-flex" href="private-chat.html">
                                                        <span
                                                            class="avatar avatar-md  me-3 align-self-center cover-image">
                                                            <img src="../assets/images/profiles/12.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-90p">
                                                            <div class="d-flex">
                                                                <h5 class="mb-1">Michael Brown</h5>
                                                                <small class="text-muted ms-auto text-end">
                                                                    6:30 pm
                                                                </small>
                                                            </div>
                                                            <span>Completed the final review...</span>
                                                        </div>
                                                    </a>

                                                    <a class="dropdown-item d-flex" href="private-chat.html">
                                                        <span
                                                            class="avatar avatar-md  me-3 align-self-center cover-image">
                                                            <img src="../assets/images/profiles/3.jpg" alt="demo">
                                                        </span>
                                                        <div class="wd-90p">
                                                            <div class="d-flex">
                                                                <h5 class="mb-1">Sarah Davis</h5>
                                                                <small class="text-muted ms-auto text-end">
                                                                    7:00 pm
                                                                </small>
                                                            </div>
                                                            <span>Received approval for project proposal...</span>
                                                        </div>
                                                    </a>

                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a href="private-chat.html"
                                                    class="dropdown-item text-center p-3 text-muted">See all
                                                    Messages</a>
                                            </div>
                                        </div>

                                        <div class="demo-icon nav-link icon">
                                            <i class="fe fe-settings text_primary"></i>
                                        </div>
                                        <!-- SIDE-MENU -->
                                        <div class="dropdown d-flex">
                                            <a class="nav-link icon full-screen-link nav-link-bg">
                                                <i class="fe fe-minimize fullscreen-button"></i>
                                            </a>
                                        </div>
                                        <!-- FULL-SCREEN -->
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link user-dropdown">
                                                <img src="../assets/images/profiles/5.jpg" alt="profile-user" class="profile-user avatar  cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold">Aashvi Monroe</h5>
                                                        <small class="text-muted">Super Admin</small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" href="user-account-view.html">
                                                    <i class="dropdown-icon fe fe-user"></i> Profile
                                                </a>
                                                <a class="dropdown-item" href="lockscreen.html">
                                                    <i class="dropdown-icon fe fe-lock"></i> Lockscreen
                                                </a>
                                                <a class="dropdown-item" href="authentication-signin.html">
                                                    <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--{ app header end }-->
            <!--{ app sidebar start }-->
            <div class="sticky">
                <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                <div class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="index.html">
                            <img src="../assets/images/brand/logo-white.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="../assets/images/brand/icon-white.png" class="header-brand-img toggle-logo" alt="logo">
                            <img src="../assets/images/brand/icon-dark.png" class="header-brand-img light-logo" alt="logo">
                            <img src="../assets/images/brand/logo-dark.png" class="header-brand-img light-logo1" alt="logo">
                        </a>
                        <!-- LOGO -->
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                            </svg></div>
                        <ul class="side-menu">
                            <li class="sub-category">
                                <h3>Main</h3>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon  fe fe-home"></i>
                                    <span class="side-menu__label">Dashboard</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Dashboards</a>
                                                        </li>
                                                        <li><a href="index.html" class="slide-item">CRM</a></li>
                                                        <li><a href="dashboard-analytics.html" class="slide-item">Analytics</a></li>
                                                        <li><a href="dashboard-ecommerce.html" class="slide-item">eCommerce</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="sub-category">
                                <h3>Apps & Pages</h3>
                            </li>

                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-slack"></i>
                                    <span class="side-menu__label">Application</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Application</a>
                                                        </li>
                                                        <li><a href="app-kanban.html" class="slide-item">Kanban</a></li>
                                                        <li><a href="calendar.html" class="slide-item">Calendar</a></li>
                                                        <li><a href="app-calendar.html" class="slide-item">Event Calendar</a></li>
                                                        <li><a href="app-list-calendar.html" class="slide-item">List Calendar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" href="private-chat.html"><i
                                        class="side-menu__icon  ti ti-brand-hipchat"></i><span class="side-menu__label">Chat</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Users</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Users</a></li>
                                                        <li><a href="user-list.html" class="slide-item">List</a></li>
                                                        <li><a href="user-reports.html" class="slide-item">Reports</a>
                                                        </li>
                                                        <li class="sub-slide">
                                                            <a class="sub-sidenav-menu-item" data-bs-toggle="sub-slide"
                                                                href="javascript:void(0)"><span
                                                                    class="sub-side-menu__label">View</span><i
                                                                    class="sub-angle fe fe-chevron-right"></i></a>
                                                            <ul class="sub-slide-menu">
                                                                <li><a class="sub-slide-item"
                                                                        href="user-account-view.html">Account</a></li>
                                                                <li><a class="sub-slide-item"
                                                                        href="user-security-view.html">Security</a></li>
                                                                <li><a class="sub-slide-item" href="user-billing-view.html">Billing
                                                                        &
                                                                        Plans</a></li>
                                                                <li><a class="sub-slide-item"
                                                                        href="user-notifications-view.html">Notifications</a>
                                                                </li>
                                                                <li><a class="sub-slide-item"
                                                                        href="user-connections-view.html">Connections</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-shopping-cart"></i><span
                                        class="side-menu__label">Ecommerce</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Ecommerce</a></li>
                                                        <li><a href="ecommerce-product-add.html" class="slide-item">Add
                                                                Product</a></li>
                                                        <li><a href="ecommerce-product.html" class="slide-item">Products</a></li>
                                                        <li><a href="ecommerce-product-details.html" class="slide-item">Products
                                                                Detail</a></li>
                                                        <li><a href="ecommerce-product-list.html" class="slide-item">Product
                                                                List</a></li>
                                                        <li><a href="ecommerce-cart.html" class="slide-item">Cart</a>
                                                        </li>
                                                        <li><a href="ecommerce-wishlist.html" class="slide-item">Wishlist</a></li>
                                                        <li><a href="ecommerce-order-list.html" class="slide-item">Order
                                                                Lists</a></li>
                                                        <li><a href="ecommerce-product-referral.html"
                                                                class="slide-item">Referrals</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-lock"></i><span
                                        class="side-menu__label">Authentication</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Authentication</a>
                                                        </li>
                                                        <li><a class="slide-item" href="authentication-signin.html">Sign
                                                                up</a></li>
                                                        <li><a class="slide-item" href="register.html">Sign in</a></li>
                                                        <li><a class="slide-item" href="forgot-password.html"> Forgot
                                                                Password </a></li>
                                                        <li><a class="slide-item" href="lockscreen.html">Lock Screen</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-alert-triangle"></i><span class="side-menu__label">Error
                                        Pages</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Authentication</a>
                                                        </li>
                                                        <li><a class="slide-item" href="400.html">400</a></li>
                                                        <li><a class="slide-item" href="401.html">401</a></li>
                                                        <li><a class="slide-item" href="403.html">403 </a></li>
                                                        <li><a class="slide-item" href="404.html">404</a></li>
                                                        <li><a class="slide-item" href="500.html">500</a></li>
                                                        <li><a class="slide-item" href="503.html">503</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-category">
                                <h3>Elements</h3>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-layers"></i><span class="side-menu__label">Basic</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Basic</a>
                                                        </li>
                                                        <li><a class="slide-item" href="basic-alert.html">Alert</a></li>
                                                        <li><a class="slide-item" href="basic-buttons.html">Button</a>
                                                        </li>
                                                        <li><a class="slide-item" href="basic-badges.html">Badges</a>
                                                        </li>
                                                        <li><a class="slide-item" href="basic-breadcrumb.html">Breadcrumb</a></li>
                                                        <li><a class="slide-item" href="basic-cards.html">Cards</a></li>
                                                        <li><a class="slide-item" href="basic-accordion.html">Accordion</a></li>
                                                        <li><a class="slide-item" href="basic-carousel.html">Carousel</a></li>
                                                        <li><a class="slide-item" href="basic-dropdowns.html">Dropdowns</a></li>
                                                        <li><a class="slide-item" href="basic-offcanvas.html">Offcanvas</a></li>
                                                        <li> <a class="slide-item" href="basic-pagination.html">Pagination</a></li>
                                                        <li> <a class="slide-item" href="basic-progress.html">Progress</a></li>
                                                        <li><a class="slide-item" href="basic-list-group.html">List
                                                                group</a></li>
                                                        <li><a class="slide-item" href="basic-modal.html">Modal</a></li>
                                                        <li><a class="slide-item" href="basic-spinner.html">Spinner</a>
                                                        </li>
                                                        <li> <a class="slide-item" href="basic-tabs.html">Tabs</a></li>
                                                        <li><a class="slide-item" href="basic-typography.html">Typography</a></li>
                                                        <li><a class="slide-item" href="basic-tooltip-popover.html">Tooltip &
                                                                popovers</a>
                                                        </li>
                                                        <li><a class="slide-item" href="basic-toasts.html">Toasts</a>
                                                        </li>
                                                        <li class="sub-slide">
                                                            <a class="sub-sidenav-menu-item" data-bs-toggle="sub-slide"
                                                                href="javascript:void(0)"><span
                                                                    class="sub-side-menu__label">Utilities</span><i
                                                                    class="sub-angle fe fe-chevron-right"></i></a>
                                                            <ul class="sub-slide-menu">
                                                                <li><a class="sub-slide-item" href="avatars.html">Avatars</a></li>
                                                                <li><a class="sub-slide-item" href="position.html">Position</a></li>
                                                                <li><a class="sub-slide-item" href="columns.html">Columns</a></li>
                                                                <li><a class="sub-slide-item" href="flex.html">Flex</a>
                                                                </li>
                                                                <li><a class="sub-slide-item" href="gutters.html">Gutters</a></li>
                                                                <li><a class="sub-slide-item" href="more.html">More</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">Advance</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Advance</a></li>
                                                        <li><a class="slide-item" href="sweet-alert.html">Sweet
                                                                alert</a></li>

                                                        <li><a class="slide-item" href="notification.html">Notification</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti ti-gift"></i><span class="side-menu__label">icons</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">icons</a></li>
                                                        <li><a class="slide-item" href="bootstrap-icons.html">Bootstrap
                                                                Icons</a></li>
                                                        <li><a class="slide-item" href="tabler-icons.html">Tabler</a>
                                                        </li>
                                                        <li><a class="slide-item" href="fontawesome-icons.html">Font
                                                                Awesome</a></li>
                                                        <li><a class="slide-item" href="material-designicons-icons.html">Material
                                                                Design
                                                                Icons</a></li>
                                                        <li><a class="slide-item" href="simple-line-icons.html">Simple
                                                                Line Icons</a></li>
                                                        <li><a class="slide-item" href="ionic-icons.html">Ionic
                                                                Icons</a></li>
                                                        <li><a class="slide-item" href="feather-icons.html">Feather
                                                                Icons</a></li>
                                                        <li><a class="slide-item" href="flags-icons.html">Flags
                                                                Icons</a></li>
                                                        <li><a class="slide-item" href="payments-icons.html">Payments
                                                                Icons</a></li>
                                                        <li><a class="slide-item" href="typicons.html">Typicons</a></li>
                                                        <li><a class="slide-item" href="weather-icons.html">Weather
                                                                Icons</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-category">
                                <h3>Maps & Charts</h3>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-map-pin"></i><span class="side-menu__label">Maps</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Maps</a></li>
                                                        <li><a href="leaflet-maps.html" class="slide-item">Leaflet
                                                                Maps</a></li>
                                                        <li><a href="mapel-maps.html" class="slide-item">Mapel Maps</a>
                                                        </li>
                                                        <li><a href="vector-maps.html" class="slide-item">Vector
                                                                Maps</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-bar-chart-2"></i><span class="side-menu__label">Chart</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Chart</a></li>
                                                        <li><a href="chartjs.html" class="slide-item">ChartJs</a></li>
                                                        <li><a href="flot-charts.html" class="slide-item">Flot
                                                                Charts</a></li>
                                                        <li><a href="echarts.html" class="slide-item">ECharts</a></li>
                                                        <li><a href="morris-charts.html" class="slide-item">Morris
                                                                Charts</a></li>
                                                        <li><a href="nvd3-charts.html" class="slide-item">Nvd3
                                                                Charts</a></li>
                                                        <li class="sub-slide">
                                                            <a class="sub-sidenav-menu-item" data-bs-toggle="sub-slide"
                                                                href="javascript:void(0)"><span class="sub-side-menu__label">C3
                                                                    Charts</span><i class="sub-angle fe fe-chevron-right"></i></a>
                                                            <ul class="sub-slide-menu">
                                                                <li><a class="sub-slide-item" href="c-charts.html">Bar
                                                                        Charts</a></li>
                                                                <li><a class="sub-slide-item" href="line-chart.html">Line Charts</a>
                                                                </li>
                                                                <li><a class="sub-slide-item" href="dount-charts.html">Dount
                                                                        Charts</a></li>
                                                                <li><a class="sub-slide-item" href="pie-chart.html">Pie
                                                                        Charts</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-category">
                                <h3>Forms</h3>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" href="form-validation.html">
                                    <i class="side-menu__icon  ti ti-clipboard-check"></i>
                                    <span class="side-menu__label">Form Validation</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti ti-forms"></i><span class="side-menu__label">Forms
                                        Elements</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Forms
                                                                Elements</a></li>
                                                        <li><a class="slide-item" href="form-elements.html">Form
                                                                Basic</a></li>
                                                        <li><a class="slide-item" href="form-floating.html">Form
                                                                Floating</a></li>
                                                        <li><a class="slide-item" href="form-options.html">Form
                                                                Options</a></li>
                                                        <li><a class="slide-item" href="input-group.html">Input
                                                                Groups</a></li>
                                                        <li><a class="slide-item" href="form-input-spinners.html"> Form
                                                                Input Spinners</a></li>
                                                        <li><a class="slide-item" href="gerenal-elements.html">Gerenal
                                                                Elements</a></li>
                                                        <li><a class="slide-item" href="form-wizard.html">Form
                                                                Wizard</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti ti-plug"></i><span class="side-menu__label">Forms
                                        Plugins</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Forms
                                                                Plugins</a></li>
                                                        <li><a class="slide-item" href="form-datepicker.html">Date
                                                                Pickers</a></li>
                                                        <li><a class="slide-item" href="form-select.html">Select2</a>
                                                        </li>
                                                        <li><a class="slide-item" href="form-inputmask.html">Input
                                                                Masks</a></li>
                                                        <li><a class="slide-item" href="file-upload.html">File
                                                                Upload</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti ti-edit"></i><span class="side-menu__label">Text
                                        Editors</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Text
                                                                Editors</a></li>
                                                        <li class="sub-slide">
                                                            <a class="sub-sidenav-menu-item" data-bs-toggle="sub-slide"
                                                                href="javascript:void(0)"><span class="sub-side-menu__label">CK
                                                                    editor</span><i class="sub-angle fe fe-chevron-right"></i></a>
                                                            <ul class="sub-slide-menu">
                                                                <li><a class="sub-slide-item" href="classic-editor.html">classic</a>
                                                                </li>
                                                                <li><a class="sub-slide-item"
                                                                        href="document-editor.html">Document</a></li>
                                                                <li><a class="sub-slide-item" href="inline-editor.html">Inline</a>
                                                                </li>
                                                                <li><a class="sub-slide-item" href="balloon-editor.html">Balloon</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li><a href="quill-editor.html" class="slide-item">Quill
                                                                Editor</a></li>
                                                        <li><a href="tinymce-editor.html" class="slide-item">Tinymce
                                                                Editor</a></li>
                                                        <li><a href="markdown-editor.html" class="slide-item">Markdown
                                                                Editor</a></li>
                                                        <li><a href="summernote-editor.html" class="slide-item">Summernote
                                                                Editor</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-category">
                                <h3>Tables</h3>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti ti-table"></i><span class="side-menu__label">Bootstrap
                                        table</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Bootstrap
                                                                table</a></li>
                                                        <li><a href="tbl-bootstrap.html" class="slide-item">Basic
                                                                table</a></li>
                                                        <li><a href="tbl-sizing.html" class="slide-item">Sizing
                                                                table</a></li>
                                                        <li><a href="tbl-styling.html" class="slide-item">Styling
                                                                table</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon bx bxs-shield-plus"></i><span class="side-menu__label">Advance
                                        Table</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Advance Table</a>
                                                        </li>
                                                        <li><a href="datatable.html" class="slide-item">datatable</a>
                                                        </li>
                                                        <li><a href="edit-table.html" class="slide-item">Edit Tables</a>
                                                        </li>
                                                        <li><a href="tables-extension.html" class="slide-item">Tables
                                                                Extension</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-sliders"></i>
                                    <span class="side-menu__label">Level items</span><i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li class="side-menu-label1"><a href="javascript:void(0)">Level
                                                                items</a></li>
                                                        <li><a href="javascript:void(0)" class="slide-item">Level-1</a>
                                                        </li>
                                                        <li class="sub-slide">
                                                            <a class="sub-sidenav-menu-item" data-bs-toggle="sub-slide"
                                                                href="javascript:void(0)"><span
                                                                    class="sub-side-menu__label">Level-2</span><i
                                                                    class="sub-angle fe fe-chevron-right"></i></a>
                                                            <ul class="sub-slide-menu">
                                                                <li><a class="sub-slide-item"
                                                                        href="javascript:void(0)">Level-2.1</a></li>
                                                                <li><a class="sub-slide-item"
                                                                        href="javascript:void(0)">Level-2.2</a></li>
                                                                <li class="sub-slide2">
                                                                    <a class="sub-sidenav-menu-item" href="javascript:void(0)"
                                                                        data-bs-toggle="sub-slide2"><span
                                                                            class="sub-side-menu__label">Level-2.3</span><i
                                                                            class="sub-angle2 fe fe-chevron-right"></i></a>
                                                                    <ul class="sub-slide-menu2">
                                                                        <li><a href="javascript:void(0)"
                                                                                class="sub-slide-item2">Level-2.3.1</a>
                                                                        </li>
                                                                        <li><a href="javascript:void(0)"
                                                                                class="sub-slide-item2">Level-2.3.2</a>
                                                                        </li>
                                                                        <li><a href="javascript:void(0)"
                                                                                class="sub-slide-item2">Level-2.3.3</a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li><a class="sub-slide-item"
                                                                        href="javascript:void(0)">Level-2.4</a></li>
                                                                <li><a class="sub-slide-item"
                                                                        href="javascript:void(0)">Level-2.5</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg></div>
                    </div>
                </div>
            </div>
            <!--{ app sidebar end }-->

            <!--{ app content start }-->
            <div class="main-content app-content mt-0">
                <div class="side-app">
                    <!--{ container start }-->
                    <div class="main-container container-fluid">
                        <!--{ PAGE HEADER START }-->
                        <div class="page-header">
                            <h1 class="page-title">Dashboard</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        <!--{ PAGE HEADER END }-->

                       <!-- start row -->
                        <div class="row">
                            <div class="col-md-12 col-xl-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title  mb-0">Sales Overview</h5>
                                        <div class="ms-auto"> 
                                            <button class="btn btn-sm bg-light  dropdown-toggle fw-medium " type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This Month</button>
                                            <div class="dropdown-menu dropdown-menu-end" style="">
                                                <a class="dropdown-item" href="#">This Month</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="sales-overview" class=""></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-5">
                                <div class="row g-3">
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="widget-first">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="p-2 border border-primary border-opacity-10 bg-primary-transparent rounded-pill me-2">
                                                            <div class="bg-primary rounded-circle widget-size text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#ffffff" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"></path></svg>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-dark fs-15">Total Customers</p>
                                                    </div>
       
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0 fs-22  me-3">3,456</h3>
                                                        <div class="text-center">
                                                            <span class="text-primary fs-14"><i class="mdi mdi-trending-up fs-14"></i> 12.5%</span>
                                                            <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="widget-first">
        
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="p-2 border border-secondary border-opacity-10 bg-secondary-transparent rounded-pill me-2">
                                                            <div class="bg-secondary rounded-circle widget-size text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 640 512"><path fill="#ffffff" d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"></path></svg>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-dark fs-15">Active Customers</p>
                                                    </div>
        
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0 fs-22  me-3">2,839</h3>
                                                        <div class="text-center">
                                                            <span class="text-danger fs-14 me-2"><i class="mdi mdi-trending-down fs-14"></i> 1.5%</span>
                                                            <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="widget-first">
        
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="p-2 border border-danger border-opacity-10 bg-danger-transparent rounded-pill me-2">
                                                            <div class="bg-danger rounded-circle widget-size text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#ffffff" d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15"></path></svg>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-dark fs-15">Profit Total</p>   
                                                    </div>
        
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0 fs-22  me-3">$7,254</h3>
                                                        <div class="text-center">
                                                            <span class="text-primary fs-14 me-2"><i class="mdi mdi-trending-up fs-14"></i> 12.8%</span>
                                                            <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="widget-first">
        
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="p-2 border border-warning border-opacity-10 bg-warning-transparent rounded-pill me-2">
                                                            <div class="bg-warning rounded-circle widget-size text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#ffffff" d="M5.574 4.691c-.833.692-1.052 1.862-1.491 4.203l-.75 4c-.617 3.292-.926 4.938-.026 6.022C4.207 20 5.88 20 9.23 20h5.54c3.35 0 5.025 0 5.924-1.084c.9-1.084.591-2.73-.026-6.022l-.75-4c-.439-2.34-.658-3.511-1.491-4.203C17.593 4 16.403 4 14.02 4H9.98c-2.382 0-3.572 0-4.406.691" opacity="0.5"></path><path fill="#988D4D" d="M12 9.25a2.251 2.251 0 0 1-2.122-1.5a.75.75 0 1 0-1.414.5a3.751 3.751 0 0 0 7.073 0a.75.75 0 1 0-1.414-.5A2.251 2.251 0 0 1 12 9.25"></path></svg>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-dark fs-15">Expense Total</p>
                                                    </div>
                                                    
        
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0 fs-22  me-3">$4,578</h3>
        
                                                        <div class="text-muted">
                                                            <span class="text-danger fs-14 me-2"><i class="mdi mdi-trending-down fs-14"></i> 18%</span>
                                                            <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="widget-first">
        
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="p-2 border border-success border-opacity-10 bg-success-transparent rounded-pill me-2">
                                                            <div class="bg-success rounded-circle widget-size text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M5 19L19 5"></path><circle cx="7" cy="7" r="3"></circle><circle cx="17" cy="17" r="3"></circle></g></svg>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-dark fs-15">Conversion Rate</p>
                                                    </div>
                                                    
        
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0 fs-22  me-3">14.57%</h3>
        
                                                        <div class="text-muted">
                                                            <span class="text-primary fs-14 me-2"><i class="mdi mdi-trending-up fs-14"></i> 5.8%</span>
                                                            <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="widget-first">
        
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="p-2 border border-dark border-opacity-10 bg-dark-transparent rounded-pill me-2">
                                                            <div class="bg-dark rounded-circle widget-size text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9H6.659c-1.006 0-1.51 0-1.634-.309c-.125-.308.23-.672.941-1.398L8.211 5M5 15h12.341c1.006 0 1.51 0 1.634.309c.125.308-.23.672-.941 1.398L15.789 19" color="#ffffff"></path></svg>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-dark fs-15">Total Deals</p>
                                                    </div>
                                                    
        
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h3 class="mb-0 fs-22  me-3">8,754</h3>
        
                                                        <div class="text-muted">
                                                            <span class="text-primary fs-14 me-2"><i class="mdi mdi-trending-up fs-14"></i> 4.5%</span>
                                                            <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- end row -->
                                 <!-- Start Monthly Sales -->
                                 <div class="row">
                                    <div class="col-md-12 col-xl-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title  mb-0">Latest transactions</h5>
                                            </div>
                                            <div class="card-body p-0">
                                                <ul class="list-group list-group-flush list-group-no-gutters">

                                                    <!-- List Item -->
                                                    <li class="list-group-item">
                                                        <div class="d-flex">
        
                                                            <div class="flex-shrink-0 align-self-center">
                                                                <!-- Avatar -->
                                                                <div class="align-content-center text-center border border-dashed rounded-circle p-1">
                                                                    <img src="../assets/images/profiles/5.jpg" class="avatar avatar-md rounded-circle" alt="image-1">
                                                                </div>
                                                                <!-- End Avatar -->
                                                            </div>
                                    
                                                            <div class="flex-grow-1 ms-3 align-content-center">
                                                                <div class="row">
                                                                    <div class="col-7 col-md-5 order-md-1">
                                                                        <h6 class="mb-1  fs-15">Bob Dean</h6>
                                                                        <span class="fs-14 text-muted">Transfer to bank account</span>
                                                                    </div>
                                            
                                                                    <div class="col-5 col-md-4 order-md-3 text-end mt-2 mt-md-0">
                                                                        <h6 class="mb-1  fs-14">$158.00 USD</h6>
                                                                        <span class="fs-13 text-muted">24 Jan, 2024</span>
                                                                    </div>
                                            
                                                                    <div class="col-auto col-md-3 order-md-2 align-self-center">
                                                                        <span class="badge bg-warning-transparent text-warning fw-semibold rounded-pill">Pending</span>
                                                                    </div>
                                                                </div>
                                                                <!-- End Row -->
                                                            </div>
        
                                                        </div>
                                                    </li>
                                                    <!-- End List Item -->
        
                                                    <!-- List Item -->
                                                    <li class="list-group-item">
                                                        <div class="d-flex">
        
                                                            <div class="flex-shrink-0 align-self-center">
                                                                <!-- Avatar -->
                                                                <div class="avatar border border-dashed rounded-circle align-content-center text-center p-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                                                        <path fill="#2786f1" d="M15.194 7.57c.487-.163 1.047-.307 1.534-.451c-1.408-.596-3.176-1.227-4.764-1.625c-.253.073-1.01.271-1.534.434c.541.162 2.328.577 4.764 1.642m-8.896 6.785c.577.343 1.19.812 1.786 1.209c3.952-3.068 7.85-5.432 12.127-6.767c-.596-.307-1.119-.578-1.787-.902c-2.562.65-6.947 2.4-12.126 6.46m-.758-6.46c-2.112.974-4.331 2.31-5.54 3.085c.433.199.866.361 1.461.65c2.671-1.805 4.764-2.905 5.594-3.266c-.595-.217-1.154-.361-1.515-.47zm8.066.234c-.686-.379-3.068-1.263-4.71-1.642c-.487.18-1.173.451-1.642.65c.595.162 2.815.758 4.71 1.714c.487-.235 1.173-.523 1.642-.722m-3.374 1.552c-.56-.27-1.173-.523-1.643-.74c-1.425.704-3.284 1.769-5.63 3.447c.505.27 1.047.595 1.624.92c1.805-1.335 3.627-2.598 5.649-3.627m1.732 8.825c3.79-3.249 9.113-6.407 12.036-7.544a48 48 0 0 0-1.949-1.155c-3.771 1.246-8.174 4.007-12.108 7.129c.667.505 1.371 1.028 2.02 1.57zm2.851-.235h-.108l-.18-.27h-.109v.27h-.072v-.596h.27c.055 0 .109 0 .145.036c.054.019.072.073.072.127c0 .108-.09.162-.198.162zm-.289-.343c.09 0 .199.018.199-.09c0-.072-.072-.09-.144-.09h-.163v.18zm-.523.036c0-.289.235-.523.541-.523s.542.234.542.523a.543.543 0 0 1-.542.542a.53.53 0 0 1-.54-.542m.107 0c0 .235.199.433.451.433a.424.424 0 1 0 0-.848c-.27 0-.45.199-.45.415"></path>
                                                                    </svg>
                                                                </div>
                                                                <!-- End Avatar -->
                                                            </div>
                                    
                                                            <div class="flex-grow-1 ms-3 align-content-center">
                                                                <div class="row">
                                                                    <div class="col-7 col-md-5 order-md-1">
                                                                        <h6 class="mb-1  fs-15">Bank of America</h6>
                                                                        <span class="fs-14 text-muted">Withdrawal to account</span>
                                                                    </div>
                                            
                                                                    <div class="col-5 col-md-4 order-md-3 text-end mt-2 mt-md-0">
                                                                        <h6 class="mb-1 text-success fs-14">$258.00 USD</h6>
                                                                        <span class="fs-13 text-muted">26 June, 2024</span>
                                                                    </div>
                                            
                                                                    <div class="col-auto col-md-3 order-md-2 align-self-center">
                                                                        <span class="badge bg-success-transparent text-success fw-semibold rounded-pill">Completed</span>
                                                                    </div>
                                                                </div>
                                                                <!-- End Row -->
                                                            </div>
        
                                                        </div>
                                                    </li>
                                                    <!-- End List Item -->
        
                                                    <!-- List Item -->
                                                    <li class="list-group-item">
                                                        <div class="d-flex">
        
                                                            <div class="flex-shrink-0 align-self-center">
                                                                <!-- Avatar -->
                                                                <div class="avatar border border-dashed rounded-circle align-content-center text-center p-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256">
                                                                        <path fill="#e01e5a" d="M53.841 161.32c0 14.832-11.987 26.82-26.819 26.82S.203 176.152.203 161.32c0-14.831 11.987-26.818 26.82-26.818H53.84zm13.41 0c0-14.831 11.987-26.818 26.819-26.818s26.819 11.987 26.819 26.819v67.047c0 14.832-11.987 26.82-26.82 26.82c-14.83 0-26.818-11.988-26.818-26.82z"></path><path fill="#36c5f0" d="M94.07 53.638c-14.832 0-26.82-11.987-26.82-26.819S79.239 0 94.07 0s26.819 11.987 26.819 26.819v26.82zm0 13.613c14.832 0 26.819 11.987 26.819 26.819s-11.987 26.819-26.82 26.819H26.82C11.987 120.889 0 108.902 0 94.069c0-14.83 11.987-26.818 26.819-26.818z"></path><path fill="#2eb67d" d="M201.55 94.07c0-14.832 11.987-26.82 26.818-26.82s26.82 11.988 26.82 26.82s-11.988 26.819-26.82 26.819H201.55zm-13.41 0c0 14.832-11.988 26.819-26.82 26.819c-14.831 0-26.818-11.987-26.818-26.82V26.82C134.502 11.987 146.489 0 161.32 0s26.819 11.987 26.819 26.819z"></path><path fill="#ecb22e" d="M161.32 201.55c14.832 0 26.82 11.987 26.82 26.818s-11.988 26.82-26.82 26.82c-14.831 0-26.818-11.988-26.818-26.82V201.55zm0-13.41c-14.831 0-26.818-11.988-26.818-26.82c0-14.831 11.987-26.818 26.819-26.818h67.25c14.832 0 26.82 11.987 26.82 26.819s-11.988 26.819-26.82 26.819z"></path>
                                                                    </svg>
                                                                </div>
                                                                <!-- End Avatar -->
                                                            </div>
                                    
                                                            <div class="flex-grow-1 ms-3 align-content-center">
                                                                <div class="row">
                                                                    <div class="col-7 col-md-5 order-md-1">
                                                                        <h6 class="mb-1  fs-15">Slack</h6>
                                                                        <span class="fs-14 text-muted">Subscription to plan</span>
                                                                    </div>
                                            
                                                                    <div class="col-5 col-md-4 order-md-3 text-end mt-2 mt-md-0">
                                                                        <h6 class="mb-1  fs-14">-$154.00 USD</h6>
                                                                        <span class="fs-13 text-muted">12 May, 2024</span>
                                                                    </div>
                                            
                                                                    <div class="col-auto col-md-3 order-md-2 align-self-center">
                                                                        <span class="badge bg-danger-transparent text-danger fw-semibold rounded-pill">Failed</span>
                                                                    </div>
                                                                </div>
                                                                <!-- End Row -->
                                                            </div>
        
                                                        </div>
                                                    </li>
                                                    <!-- End List Item -->
        
                                                    <!-- List Item -->
                                                    <li class="list-group-item">
                                                        <div class="d-flex">
        
                                                            <div class="flex-shrink-0 align-self-center">
                                                                <!-- Avatar -->
                                                                <div class="avatar border border-dashed rounded-circle align-content-center text-center p-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="#f06a6a" d="M18.78 12.653a5.22 5.22 0 1 0 0 10.44a5.22 5.22 0 0 0 0-10.44m-13.56 0a5.22 5.22 0 1 0 .001 10.439a5.22 5.22 0 0 0-.001-10.439m12-6.525a5.22 5.22 0 1 1-10.44 0a5.22 5.22 0 0 1 10.44 0"></path></svg>
                                                                </div>
                                                                <!-- End Avatar -->
                                                            </div>
                                    
                                                            <div class="flex-grow-1 ms-3 align-content-center">
                                                                <div class="row">
                                                                    <div class="col-7 col-md-5 order-md-1">
                                                                        <h6 class="mb-1  fs-15">Asana</h6>
                                                                        <span class="fs-14 text-muted">Subscription payment</span>
                                                                    </div>
                                            
                                                                    <div class="col-5 col-md-4 order-md-3 text-end mt-2 mt-md-0">
                                                                        <h6 class="mb-1 text-success fs-14">$258.00 USD</h6>
                                                                        <span class="fs-13 text-muted">15 Fab, 2024</span>
                                                                    </div>
                                            
                                                                    <div class="col-auto col-md-3 order-md-2 align-self-center">
                                                                        <span class="badge bg-success-transparent text-success fw-semibold rounded-pill">Completed</span>
                                                                    </div>
                                                                </div>
                                                                <!-- End Row -->
                                                            </div>
        
                                                        </div>
                                                    </li>
                                                    <!-- End List Item -->
        
                                                    <!-- List Item -->
                                                    <li class="list-group-item">
                                                        <div class="d-flex">
        
                                                            <div class="flex-shrink-0 align-self-center">
                                                                <!-- Avatar -->
                                                                <div class="avatar border border-dashed rounded-circle align-content-center text-center p-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 256 208">
                                                                        <path d="M205.28 31.36c14.096 14.88 20.016 35.2 22.512 63.68c6.626 0 12.805 1.47 16.976 7.152l7.792 10.56A17.55 17.55 0 0 1 256 123.2v28.688c-.008 3.704-1.843 7.315-4.832 9.504C215.885 187.222 172.35 208 128 208c-49.066 0-98.19-28.273-123.168-46.608c-2.989-2.189-4.825-5.8-4.832-9.504V123.2c0-3.776 1.2-7.424 3.424-10.464l7.792-10.544c4.173-5.657 10.38-7.152 16.992-7.152c2.496-28.48 8.4-48.8 22.512-63.68C77.331 3.165 112.567.06 127.552 0H128c14.72 0 50.4 2.88 77.28 31.36m-77.264 47.376c-3.04 0-6.544.176-10.272.544c-1.312 4.896-3.248 9.312-6.08 12.128c-11.2 11.2-24.704 12.928-31.936 12.928c-6.802 0-13.927-1.42-19.744-5.088c-5.502 1.808-10.786 4.415-11.136 10.912c-.586 12.28-.637 24.55-.688 36.824c-.026 6.16-.05 12.322-.144 18.488c.024 3.579 2.182 6.903 5.44 8.384C79.936 185.92 104.976 192 128.016 192c23.008 0 48.048-6.08 74.512-18.144c3.258-1.48 5.415-4.805 5.44-8.384c.317-18.418.062-36.912-.816-55.312h.016c-.342-6.534-5.648-9.098-11.168-10.912c-5.82 3.652-12.927 5.088-19.728 5.088c-7.232 0-20.72-1.728-31.936-12.928c-2.832-2.816-4.768-7.232-6.08-12.128a106 106 0 0 0-10.24-.544m-26.941 43.93c5.748 0 10.408 4.66 10.408 10.409v19.183c0 5.749-4.66 10.409-10.408 10.409s-10.408-4.66-10.408-10.409v-19.183c0-5.748 4.66-10.408 10.408-10.408m53.333 0c5.749 0 10.409 4.66 10.409 10.409v19.183c0 5.749-4.66 10.409-10.409 10.409c-5.748 0-10.408-4.66-10.408-10.409v-19.183c0-5.748 4.66-10.408 10.408-10.408M81.44 28.32c-11.2 1.12-20.64 4.8-25.44 9.92c-10.4 11.36-8.16 40.16-2.24 46.24c4.32 4.32 12.48 7.2 21.28 7.2c6.72 0 19.52-1.44 30.08-12.16c4.64-4.48 7.52-15.68 7.2-27.04c-.32-9.12-2.88-16.64-6.72-19.84c-4.16-3.68-13.6-5.28-24.16-4.32m68.96 4.32c-3.84 3.2-6.4 10.72-6.72 19.84c-.32 11.36 2.56 22.56 7.2 27.04c10.56 10.72 23.36 12.16 30.08 12.16c8.8 0 16.96-2.88 21.28-7.2c5.92-6.08 8.16-34.88-2.24-46.24c-4.8-5.12-14.24-8.8-25.44-9.92c-10.56-.96-20 .64-24.16 4.32M128 56c-2.56 0-5.6.16-8.96.48c.32 1.76.48 3.68.64 5.76c0 1.44 0 2.88-.16 4.48c3.2-.32 5.92-.32 8.48-.32s5.28 0 8.48.32c-.16-1.6-.16-3.04-.16-4.48c.16-2.08.32-4 .64-5.76c-3.36-.32-6.4-.48-8.96-.48"></path>
                                                                    </svg>
                                                                </div>
                                                                <!-- End Avatar -->
                                                            </div>
                                    
                                                            <div class="flex-grow-1 ms-3 align-content-center">
                                                                <div class="row">
                                                                    <div class="col-7 col-md-5 order-md-1">
                                                                        <h6 class="mb-1  fs-15">Github Copilot</h6>
                                                                        <span class="fs-14 text-muted">Renew A Plan</span>
                                                                    </div>
                                            
                                                                    <div class="col-5 col-md-4 order-md-3 text-end mt-2 mt-md-0">
                                                                        <h6 class="mb-1  fs-14">$89.00 USD</h6>
                                                                        <span class="fs-13 text-muted">25 April, 2024</span>
                                                                    </div>
                                            
                                                                    <div class="col-auto col-md-3 order-md-2 align-self-center">
                                                                        <span class="badge bg-primary-transparent text-primary fw-semibold rounded-pill">Completed</span>
                                                                    </div>
                                                                </div>
                                                                <!-- End Row -->
                                                            </div>
        
                                                        </div>
                                                    </li>
                                                    <!-- End List Item -->
        
                                                  </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title  mb-0">Deals Statistics</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="deals-statistics"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title  mb-0">Your Recent Perfomance</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="browservisiting"></div>
                                                <div class="text-center fw-medium my-3">78% increase in company growth.</div>
                                                <div class="d-flex gap-3 justify-content-between">
                                                    <div class="d-flex">
                                                        <div class="bg-primary-transparent rounded-2 p-1 me-2 border border-dashed border-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                                <path fill="#287F71" d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <small><script>document.write(new Date().getFullYear() - 1)</script>2024</small>
                                                            <h6 class="mb-0 fs-15">$32.5k</h6>
                                                        </div>
                                                    </div>
        
                                                    <div class="d-flex">
                                                        <div class="bg-success-transparent rounded-2 p-1 me-2 border border-dashed border-success">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                                <path fill="#2786f1" d="M12 12V2c5.523 0 10 4.477 10 10z" opacity="0.25"></path><path fill="#2786f1" d="m12 12l5 8.66A10.01 10.01 0 0 0 22 12z" opacity="0.5"></path><path fill="#2786f1" d="M17 20.66L12 12V2c-5.523.002-9.999 4.48-9.997 10.003c.002 5.523 4.48 9.999 10.004 9.997A10 10 0 0 0 17 20.662l.003-.005l-.004.003z"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <small><script>document.write(new Date().getFullYear() - 2)</script>2023</small>
                                                            <h6 class="mb-0 fs-15">$41.2k</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Monthly Sales -->
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title  mb-0">Product Activity</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xxl-6">
                                                        <div id="productactivity"></div>
                                                    </div>
                                                    <div class="col-xxl-6 align-self-center">
                                                        <h3 class="fs-18 fw-semibold  mb-3">Data Statistic</h3>
                                                        <ul class="list-unstyled mb-0">
                                                            
                                                            <li class="list-item mb-2 align-self-center">
                                                                <div class="d-flex align-items-center justify-content-between fs-15">
                                                                    <div class="">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" class="me-0"><path fill="#2786f1" d="M4 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m4-2.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5"></path></svg>
                                                                        <span class=" fw-normal">To Be Packed </span> 
                                                                    </div>
                                                                    <p class="mb-0 text-muted">157.880</p>
                                                                </div>
                                                            </li>
        
                                                            <li class="list-item mb-2 align-self-center">
                                                                <div class="d-flex align-items-center justify-content-between fs-15">
                                                                    <div class="">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="#f59440" d="M4 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m4-2.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5"></path></svg>
                                                                        <span class=" fw-normal">Process Delivery </span>
                                                                    </div>
                                                                    <p class="mb-0 text-muted">198.254</p>
                                                                </div>
                                                            </li>
        
                                                            <li class="list-item  align-self-center fs-15">
                                                                <div class="d-flex align-items-center justify-content-between fs-15">
                                                                    <div class="">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="#522c8f" d="M4 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m4-2.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5"></path></svg>
                                                                        <span class=" fw-normal">Delivery Done</span>
                                                                    </div>
                                                                    <p class="mb-0 text-muted">142.278</p>
                                                                </div>
                                                            </li>
        
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card overflow-hidden">
                                            <div class="card-header">
                                                <h5 class="card-title  mb-0">Sales by Countries</h5>
                                                    <div class="ms-auto"> 
                                                        <button class="btn btn-sm bg-light  dropdown-toggle fw-medium " type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View All</button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Today</a>
                                                            <a class="dropdown-item" href="#">This Week</a>
                                                            <a class="dropdown-item" href="#">Last Week</a>
                                                        </div>
                                                    </div>
                                            </div>
        
                                            <div class="card-body">
                                                <ul class="p-0 m-0">
                                                    <li class="d-flex mb-4">
                                                        <div class="d-flex w-50 align-items-center me-4">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 64 64">
                                                                    <path fill="#ed4c5c" d="M48 6.6C43.3 3.7 37.9 2 32 2v4.6z"></path><path fill="#fff" d="M32 11.2h21.6C51.9 9.5 50 7.9 48 6.6H32z"></path><path fill="#ed4c5c" d="M32 15.8h25.3c-1.1-1.7-2.3-3.2-3.6-4.6H32z"></path><path fill="#fff" d="M32 20.4h27.7c-.7-1.6-1.5-3.2-2.4-4.6H32z"></path><path fill="#ed4c5c" d="M32 25h29.2c-.4-1.6-.9-3.1-1.5-4.6H32z"></path><path fill="#fff" d="M32 29.7h29.9c-.1-1.6-.4-3.1-.7-4.6H32z"></path><path fill="#ed4c5c" d="M61.9 29.7H32V32H2c0 .8 0 1.5.1 2.3h59.8c.1-.8.1-1.5.1-2.3c0-.8 0-1.6-.1-2.3"></path><path fill="#fff" d="M2.8 38.9h58.4c.4-1.5.6-3 .7-4.6H2.1c.1 1.5.3 3.1.7 4.6"></path><path fill="#ed4c5c" d="M4.3 43.5h55.4c.6-1.5 1.1-3 1.5-4.6H2.8c.4 1.6.9 3.1 1.5 4.6"></path><path fill="#fff" d="M6.7 48.1h50.6c.9-1.5 1.7-3 2.4-4.6H4.3c.7 1.6 1.5 3.1 2.4 4.6"></path><path fill="#ed4c5c" d="M10.3 52.7h43.4c1.3-1.4 2.6-3 3.6-4.6H6.7c1 1.7 2.3 3.2 3.6 4.6"></path><path fill="#fff" d="M15.9 57.3h32.2c2.1-1.3 3.9-2.9 5.6-4.6H10.3c1.7 1.8 3.6 3.3 5.6 4.6"></path><path fill="#ed4c5c" d="M32 62c5.9 0 11.4-1.7 16.1-4.7H15.9c4.7 3 10.2 4.7 16.1 4.7"></path><path fill="#428bc1" d="M16 6.6c-2.1 1.3-4 2.9-5.7 4.6c-1.4 1.4-2.6 3-3.6 4.6c-.9 1.5-1.8 3-2.4 4.6c-.6 1.5-1.1 3-1.5 4.6c-.4 1.5-.6 3-.7 4.6c-.1.8-.1 1.6-.1 2.4h30V2c-5.9 0-11.3 1.7-16 4.6"></path><path fill="#fff" d="m25 3l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm4 6l.5 1.5H31l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H23l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm4 6l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H19l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H11l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm20 6l.5 1.5H31l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H23l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H15l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm12 6l.5 1.5H27l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H19l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm-8 0l.5 1.5H11l-1.2 1l.4 1.5l-1.2-.9l-1.2.9l.4-1.5l-1.2-1h1.5zm2.8-14l1.2-.9l1.2.9l-.5-1.5l1.2-1h-1.5L13 9l-.5 1.5h-1.4l1.2.9zm-8 12l1.2-.9l1.2.9l-.5-1.5l1.2-1H5.5L5 21l-.5 1.5h-1c0 .1-.1.2-.1.3l.8.6z"></path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 me-1 fs-15 fw-semibold ">USA</h6>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="d-flex flex-grow-1 align-items-center">
                                                            <div class="progress progress-md w-100 me-4 mt-2" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"> 
                                                                <div class="progress-bar bg-primary" style="width: 65%"></div> 
                                                            </div> 
                                                            <span class="">65%</span>
                                                        </div>
                                                    </li>
        
                                                    <li class="d-flex mb-4">
                                                        <div class="d-flex w-50 align-items-center me-4">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 64 64">
                                                                    <path fill="#2a5f9e" d="M32 2v10H12v20H2c0 16.6 13.4 30 30 30s30-13.4 30-30S48.6 2 32 2"></path><path fill="#fff" d="M32 2c-4.7 0-9.1 1.1-13.1 3v6H11v7.9H5c-1.9 4-3 8.4-3 13.1h12V17l12 15h6v-7.5L23.6 14H32z"></path><g fill="#ed4c5c"><path d="M15.4 14L30 32h2v-4.9L21.4 14z"></path><path d="M32 5H18.9c-6 2.9-11 7.9-13.9 13.9V32h6V11h21z"></path></g><path fill="#fff" d="m8 35.7l2.2-2.7l-.7 3.5l3.5.1l-3.1 1.6L12 41l-3.1-1.4L8 43l-.9-3.4L4 41l2.1-2.8L3 36.6l3.5-.1l-.7-3.5zm44-15.5l1.8-2.2l-.6 2.8l2.8.1l-2.5 1.3l1.7 2.2l-2.5-1.2L52 26l-.7-2.8l-2.5 1.2l1.7-2.2l-2.5-1.3l2.8-.1l-.6-2.8zm0 20l1.8-2.2l-.6 2.8l2.8.1l-2.5 1.3l1.7 2.2l-2.5-1.2L52 46l-.7-2.8l-2.5 1.2l1.7-2.2l-2.5-1.3l2.8-.1l-.6-2.8zm-10-14l1.8-2.2l-.6 2.8l2.8.1l-2.5 1.3l1.7 2.2l-2.5-1.2L42 32l-.7-2.8l-2.5 1.2l1.7-2.2l-2.5-1.3l2.8-.1l-.6-2.8z"></path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 me-1 fs-15 fw-semibold ">Australia</h6>
                                                            </div>
                                                        </div>
        
                                                        <div class="d-flex flex-grow-1 align-items-center">
                                                            <div class="progress progress-md w-100 me-4 mt-2" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"> 
                                                                <div class="progress-bar bg-secondary" style="width: 89%"></div> 
                                                            </div> 
                                                            <span class="">89%</span>
                                                        </div>
                                                    </li>
        
                                                    <li class="d-flex align-items-center mb-4">
        
                                                        <div class="d-flex w-50 align-items-center me-4">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 64 64">
                                                                    <path fill="#f2b200" d="M31.8 2c-13 0-24.1 8.4-28.2 20h56.6C56 10.4 44.9 2 31.8 2"></path><path fill="#83bf4f" d="M31.8 62c13.1 0 24.2-8.3 28.3-20H3.6c4.1 11.7 15.2 20 28.2 20"></path><path fill="#fff" d="M3.6 22c-1.1 3.1-1.7 6.5-1.7 10s.6 6.9 1.7 10h56.6c1.1-3.1 1.7-6.5 1.7-10s-.6-6.9-1.7-10z"></path><circle cx="31.8" cy="32" r="8" fill="#428bc1"></circle><circle cx="31.8" cy="32" r="7" fill="#fff"></circle><g fill="#428bc1"><circle cx="29.2" cy="25.5" r=".5"></circle><circle cx="27.6" cy="26.4" r=".5"></circle><circle cx="26.3" cy="27.7" r=".5"></circle><circle cx="25.4" cy="29.3" r=".5"></circle><circle cx="24.9" cy="31.1" r=".5"></circle><circle cx="24.9" cy="32.9" r=".5"></circle><circle cx="25.4" cy="34.7" r=".5"></circle><circle cx="26.3" cy="36.3" r=".5"></circle><circle cx="27.6" cy="37.6" r=".5"></circle><circle cx="29.2" cy="38.5" r=".5"></circle><circle cx="30.9" cy="38.9" r=".5"></circle><path d="M32.3 39c0-.3.2-.5.4-.6c.3 0 .5.2.6.4c0 .3-.2.5-.4.6c-.4.1-.6-.1-.6-.4"></path><circle cx="34.5" cy="38.5" r=".5"></circle><circle cx="36.1" cy="37.6" r=".5"></circle><circle cx="37.4" cy="36.3" r=".5"></circle><circle cx="38.3" cy="34.7" r=".5"></circle><circle cx="38.8" cy="32.9" r=".5"></circle><path d="M38.8 31.6c-.3 0-.5-.2-.6-.4c0-.3.2-.5.4-.6c.3 0 .5.2.6.4c.1.3-.1.5-.4.6"></path><circle cx="38.3" cy="29.3" r=".5"></circle><circle cx="37.4" cy="27.7" r=".5"></circle><circle cx="36.1" cy="26.4" r=".5"></circle><path d="M35 25.7c-.1.3-.4.4-.7.3c-.3-.1-.4-.4-.3-.7c.1-.3.4-.4.7-.3c.3.2.4.5.3.7m-1.8-.6c0 .3-.3.5-.6.4c-.3 0-.5-.3-.4-.6c0-.3.3-.5.6-.4c.3.1.5.4.4.6m-1.8-.1c0 .3-.2.5-.4.6c-.3 0-.5-.2-.6-.4c0-.3.2-.5.4-.6c.3-.1.6.1.6.4"></path><circle cx="31.8" cy="32" r="1.5"></circle><path d="m31.8 25l-.2 4.3l.2 2.7l.3-2.7zm-1.8.2l.9 4.3l.9 2.5l-.4-2.7z"></path><path d="m28.3 25.9l2 3.9l1.5 2.2l-1.1-2.5zM26.9 27l2.9 3.3l2 1.7l-1.7-2.1z"></path><path d="m25.8 28.5l3.6 2.4l2.4 1.1l-2.2-1.6z"></path><path d="m25.1 30.2l4.1 1.3l2.6.5l-2.5-.9zm-.3 1.8l4.4.2l2.6-.2l-2.6-.2z"></path><path d="m25.1 33.8l4.2-.9l2.5-.9l-2.6.5zm.7 1.7l3.8-1.9l2.2-1.6l-2.4 1.1z"></path><path d="m26.9 36.9l3.2-2.8l1.7-2.1l-2 1.7zm1.4 1.2l2.4-3.7l1.1-2.4l-1.5 2.2z"></path><path d="m30 38.8l1.4-4.1l.4-2.7l-.9 2.5zm1.8.2l.3-4.3l-.3-2.7l-.2 2.7zm1.8-.2l-.8-4.3l-1-2.5l.5 2.7z"></path><path d="m35.3 38.1l-1.9-3.9l-1.6-2.2l1.2 2.5zm1.5-1.2l-2.9-3.2l-2.1-1.7l1.8 2.1z"></path><path d="m37.9 35.5l-3.6-2.4l-2.5-1.1l2.2 1.6zm.7-1.7l-4.1-1.3l-2.7-.5l2.6.9zm.2-1.8l-4.3-.3l-2.7.3l2.7.2zm-.2-1.8l-4.2.9l-2.6.9l2.7-.5z"></path><path d="M37.9 28.5L34 30.4L31.8 32l2.5-1.1zm-1.1-1.4l-3.2 2.8l-1.8 2.1l2.1-1.7z"></path><path d="M35.3 25.9L33 29.6L31.8 32l1.6-2.2z"></path><path d="m33.7 25.2l-1.4 4.1l-.5 2.7l1-2.5z"></path></g>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 me-1 fs-15 fw-semibold ">India</h6>
                                                            </div>
                                                        </div>
        
                                                        <div class="d-flex flex-grow-1 align-items-center">
                                                            <div class="progress progress-md w-100 me-4 mt-2" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"> 
                                                                <div class="progress-bar bg-success" style="width: 78%"></div> 
                                                            </div>
                                                            <span class="">78%</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="card overflow-hidden">
        
                                            <div class="card-header">
                                                <div class="d-flex align-items-center">
                                                    <h5 class="card-title  mb-0">Leads Report</h5>
                                                </div>
                                            </div>
        
                                            <div class="card-body mt-0">
                                                <div class="table-responsive table-card mt-0">
                                                    <table class="table table-borderless  card-table table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted">
                                                            <tr>
                                                                <th scope="col" class="cursor-pointer">Lead</th>
                                                                <th scope="col" class="cursor-pointer">Email</th>
                                                                <th scope="col" class="cursor-pointer">Phone No</th>
                                                                <th scope="col" class="cursor-pointer">Campany</th>
                                                                <th scope="col" class="cursor-pointer">Status</th>
                                                                <th scope="col" class="cursor-pointer">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/1.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-2">
                                                                    John Hamilton
                                                                </td>
                                                                <td>johnehamilton@gmail.com</td>
                                                                <td>+48, 65610085</td>
                                                                <td>Mufti</td>
                                                                <td>
                                                                    <span class="badge bg-primary-transparent text-primary fw-semibold">New Lead</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/2.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-3">
                                                                    Janice Reese
                                                                </td>
                                                                <td>janicecreese@gmail.com</td>
                                                                <td>+45, 32678972</td>
                                                                <td>Gucci</td>
                                                                <td>
                                                                    <span class="badge bg-secondary-transparent text-secondary fw-semibold">In Progress</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/3.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-4">
                                                                    Andrew Kim
                                                                </td>
                                                                <td>andrewekim@gmail.com</td>
                                                                <td>+30, 84787124</td>
                                                                <td>Vans</td>
                                                                <td>
                                                                    <span class="badge bg-danger-transparent text-danger fw-semibold">Loss</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/4.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-5">
                                                                    Kathryn Sanchez
                                                                </td>
                                                                <td>kathryntsanchez@gmail.com</td>
                                                                <td>+30, 23794209</td>
                                                                <td>Myntra</td>
                                                                <td>
                                                                    <span class="badge bg-success-transparent text-success fw-semibold">Won</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/5.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-6">
                                                                    Diane Richards
                                                                </td>
                                                                <td>dianetrichards@gmail.com</td>
                                                                <td>+78, 37569176</td>
                                                                <td>HCLTech</td>
                                                                <td>
                                                                    <span class="badge bg-warning-transparent text-warning fw-semibold">Converted</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/6.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-7">
                                                                    Chung Ohearn
                                                                </td>
                                                                <td>chunglohearn@gmail.com</td>
                                                                <td>+39, 59937702</td>
                                                                <td>Skechers</td>
                                                                <td>
                                                                    <span class="badge bg-primary-transparent text-primary fw-semibold">New Lead</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img src="../assets/images/profiles/7.jpg" class="avatar avatar-md rounded-circle me-3" alt="image-8">
                                                                    John Shan
                                                                </td>
                                                                <td>nikeshop@gmail.com</td>
                                                                <td>+47, 45789564</td>
                                                                <td>Nike</td>
                                                                <td>
                                                                    <span class="badge bg-warning-subtle text-warning fw-semibold">Converted</span>
                                                                </td>
                                                                <td>
                                                                    <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                        <i class="mdi mdi-pencil fs-16 text-muted"></i>
                                                                    </a>
                                                                    <a aria-label="anchor" class="" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody><!-- end tbody -->
                                                    </table><!-- end table -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!--{ container end }-->
                </div>
            </div>
            <!--{ app content end }-->
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

</body>

</html>