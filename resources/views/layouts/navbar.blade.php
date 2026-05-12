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