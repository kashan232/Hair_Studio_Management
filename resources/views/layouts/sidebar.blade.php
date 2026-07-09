<!-- app sidebar start -->
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/brand_logo.svg') }}" alt="Studio Logo" style="height: 40px; width: auto; object-fit: contain;">
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

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="side-menu__icon fe fe-users"></i>
                        <span class="side-menu__label">Users</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('bookings*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">
                        <i class="side-menu__icon fe fe-calendar"></i>
                        <span class="side-menu__label">Bookings</span>
                        @php
                            $pendingCount = \App\Models\Booking::where('status', 'pending_approval')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('reports*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="side-menu__icon fe fe-pie-chart"></i>
                        <span class="side-menu__label">Advanced Reports</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('coupons*') ? 'active' : '' }}" href="{{ route('coupons.index') }}">
                        <i class="side-menu__icon fe fe-tag"></i>
                        <span class="side-menu__label">Coupons</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('admin.packages*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                        <i class="side-menu__icon fe fe-box"></i>
                        <span class="side-menu__label">Packages</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('chairs*') ? 'active' : '' }}" href="{{ route('chairs.index') }}">
                        <i class="side-menu__icon fe fe-grid"></i>
                        <span class="side-menu__label">Chairs</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('pricing*') ? 'active' : '' }}" href="{{ route('pricing.index') }}">
                        <i class="side-menu__icon fe fe-credit-card"></i>
                        <span class="side-menu__label">Pricing and slots setup</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="side-menu__icon fe fe-shield"></i>
                        <span class="side-menu__label">Roles</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="sidenav-menu-item {{ Route::is('permissions*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                        <i class="side-menu__icon fe fe-lock"></i>
                        <span class="side-menu__label">Permissions</span>
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