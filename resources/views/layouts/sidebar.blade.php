
            
            <!-- app sidebar start -->
            <div class="sticky">
                <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                <div class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="{{ route('dashboard') }}">
                            <h3 class="mb-0 fw-bold" style="letter-spacing: 2px; color: #000 !important;">ABIANA</h3>
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
                                <a class="sidenav-menu-item" href="{{ route('dashboard') }}">
                                    <i class="side-menu__icon fe fe-home"></i>
                                    <span class="side-menu__label">Dashboard</span>
                                </a>
                            </li>

                            <li class="sub-category">
                                <h3>Management</h3>
                            </li>

                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-map"></i>
                                    <span class="side-menu__label">Location hierarchy</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li><a href="{{ route('districts.index') }}" class="slide-item">Districts</a></li>
                                                        <li><a href="{{ route('talukas.index') }}" class="slide-item">Talukas</a></li>
                                                        <li><a href="{{ route('tehsils.index') }}" class="slide-item">Tehsils</a></li>
                                                        <li><a href="{{ route('dehs.index') }}" class="slide-item">DEHs</a></li>
                                                        <li><a href="{{ route('locations.import') }}" class="slide-item">Excel bulk import</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            

                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-droplet"></i>
                                    <span class="side-menu__label">Administration Irrigation</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li><a href="{{ route('circles.index') }}" class="slide-item">Circles</a></li>
                                                        <li><a href="{{ route('divisions.index') }}" class="slide-item">Divisions</a></li>
                                                        <li><a href="{{ route('sub-divisions.index') }}" class="slide-item">Sub Divisions</a></li>
                                                        <li><a href="{{ route('irrigation.import') }}" class="slide-item">Excel bulk import</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-git-branch"></i>
                                    <span class="side-menu__label">Channels hierarchy</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li><a href="{{ route('barrages.index') }}" class="slide-item">Barrages</a></li>
                                                        <li><a href="{{ route('main-canals.index') }}" class="slide-item">Main canals</a></li>
                                                        <li><a href="{{ route('sub-canals.index') }}" class="slide-item">Sub canals</a></li>
                                                        <li><a href="{{ route('branch-canals.index') }}" class="slide-item">Branch canals</a></li>
                                                        <li><a href="{{ route('distributaries.index') }}" class="slide-item">Distributaries</a></li>
                                                        <li><a href="{{ route('minors.index') }}" class="slide-item">Minors</a></li>
                                                        <li><a href="{{ route('channels.import') }}" class="slide-item">Excel bulk import</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-user"></i>
                                    <span class="side-menu__label">Customer management</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li><a href="{{ route('customers.index') }}" class="slide-item">Customers</a></li>
                                                        <li><a href="{{ route('customers.create') }}" class="slide-item">Add customer</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-layers"></i>
                                    <span class="side-menu__label">Watercourse management</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li><a href="{{ route('watercourses.index') }}" class="slide-item">Watercourses (WC)</a></li>
                                                        <li><a href="{{ route('watercourses.create') }}" class="slide-item">Add watercourse</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="sub-category">
                                <h3>User Access</h3>
                            </li>
                            <li class="slide">
                                <a class="sidenav-menu-item" data-bs-toggle="slide" href="javascript:void(0)">
                                    <i class="side-menu__icon fe fe-users"></i>
                                    <span class="side-menu__label">User Controls</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active">
                                                    <ul class="sidemenu-list">
                                                        <li><a href="{{ route('users') }}" class="slide-item">Users</a></li>
                                                        <li><a href="{{ route('roles') }}" class="slide-item">Roles</a></li>
                                                        <li><a href="{{ route('permissions') }}" class="slide-item">Permissions</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide">
                                <a class="sidenav-menu-item" href="{{ route('dashboard') }}">
                                    <i class="side-menu__icon fe fe-home"></i>
                                    <span class="side-menu__label">Logout</span>
                                </a>
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