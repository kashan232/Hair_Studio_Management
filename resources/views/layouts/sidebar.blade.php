<!-- app sidebar start -->
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <h3 class="mb-0 fw-bold" style="letter-spacing: 2px; color: #c6a34d !important;">HAIR STUDIO</h3>
            </a>
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
                    <a class="sidenav-menu-item {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <li class="sub-category">
                    <h3>Salon Management</h3>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-calendar"></i>
                        <span class="side-menu__label">Appointments</span>
                        <span class="badge bg-gold text-white ms-auto">New</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-scissors"></i>
                        <span class="side-menu__label">Services</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-users"></i>
                        <span class="side-menu__label">Stylists & Staff</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-user"></i>
                        <span class="side-menu__label">Customers</span>
                    </a>
                </li>

                <li class="sub-category">
                    <h3>Settings</h3>
                </li>
                
                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="side-menu__icon fe fe-user-check"></i>
                        <span class="side-menu__label">My Profile</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="side-menu__icon fe fe-log-out"></i>
                        <span class="side-menu__label">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>

            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
</div>
<!-- app sidebar end -->