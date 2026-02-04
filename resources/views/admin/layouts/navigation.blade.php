<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom px-3">
    <div class="container-fluid">
        <!-- Brand Logo with Icon -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                <i class="fas fa-ticket-alt text-white fs-5"></i>
            </div>
            <div class="d-flex flex-column">
                <span class="fw-bold text-white fs-5">CouponsArena</span>
                <small class="text-white-50" style="font-size: 0.7rem; margin-top: -3px;">Admin Panel</small>
            </div>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <i class="fas fa-bars text-white"></i>
        </button>

        <!-- Enhanced Search Bar (Desktop) -->
        <div class="d-none d-lg-flex flex-grow-1 justify-content-center mx-4">
            <div class="w-100" style="max-width: 500px;">
                <form action="{{ route('admin.search') }}" method="GET" class="position-relative">
                    <div class="input-group input-group-lg shadow">
                        <span class="input-group-text bg-white border-end-0 ps-3">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="search" 
                               name="query" 
                               class="form-control border-start-0 py-2"
                               placeholder="Search stores, coupons, blogs, users..." 
                               aria-label="Search"
                               value="{{ request('query') ?? '' }}">
                        <button type="submit" class="input-group-text bg-primary text-white border-0 px-4">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="adminNavbar">
            <!-- Enhanced Mobile Search -->
            <div class="d-lg-none mb-4">
                <form action="{{ route('admin.search') }}" method="GET" class="w-100">
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-dark text-white border-secondary">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="search" 
                               name="query"
                               class="form-control bg-dark text-white border-secondary"
                               placeholder="Search everything..."
                               value="{{ request('query') ?? '' }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <!-- Mobile Search Filters -->
                    <div class="d-flex flex-wrap gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="mobile_stores" id="mobileStores" checked>
                            <label class="form-check-label text-white-50" for="mobileStores">
                                <i class="fas fa-store me-1"></i> Stores
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="mobile_coupons" id="mobileCoupons" checked>
                            <label class="form-check-label text-white-50" for="mobileCoupons">
                                <i class="fas fa-ticket-alt me-1"></i> Coupons
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="mobile_blogs" id="mobileBlogs" checked>
                            <label class="form-check-label text-white-50" for="mobileBlogs">
                                <i class="fas fa-blog me-1"></i> Blogs
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Quick Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-3 text-info"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.store.index') }}">
                        <i class="fas fa-store me-3 text-warning"></i>
                        Stores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.blog.index') }}">
                        <i class="fas fa-blog me-3 text-success"></i>
                        Blogs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.coupon.index') }}">
                        <i class="fas fa-ticket-alt me-3 text-danger"></i>
                        Coupons
                    </a>
                </li>
            </ul>

            <!-- Right Side Actions -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- Search Button (Mobile Only) -->
                    <li class="nav-item d-lg-none mb-3">
                        <button class="btn btn-outline-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#quickSearch">
                            <i class="fas fa-search me-2"></i> Quick Search
                        </button>
                        <div class="collapse mt-2" id="quickSearch">
                            <div class="card bg-dark border-secondary">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.store.index') }}?filter=new" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-store me-2"></i> New Stores
                                        </a>
                                        <a href="{{ route('admin.coupon.index') }}?filter=expiring" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-clock me-2"></i> Expiring Coupons
                                        </a>
                                        <a href="{{ route('admin.blog.index') }}?filter=trending" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-chart-line me-2"></i> Trending Blogs
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Quick Stats Badge -->
                    <li class="nav-item d-none d-lg-block">
                        <div class="nav-link d-flex align-items-center text-white-50 me-3">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 30px; height: 30px;">
                                <i class="fas fa-chart-line text-white fs-6"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <small class="fw-bold text-success">Active</small>
                                <small>Dashboard</small>
                            </div>
                        </div>
                    </li>

                    <!-- Notification -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" 
                           aria-expanded="false" data-bs-auto-close="outside">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-bell text-dark fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-dark" 
                                      style="font-size: 0.6rem; padding: 0.2em 0.5em;">
                                    3
                                </span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width: 300px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">Notifications</h6>
                                    <a href="#" class="text-primary small">Mark all read</a>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-user-plus text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">New user registered</div>
                                        <small class="text-muted">2 minutes ago</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-store text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">New store added</div>
                                        <small class="text-muted">1 hour ago</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-ticket-alt text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">Coupon expiring</div>
                                        <small class="text-muted">3 hours ago</small>
                                    </div>
                                </a>
                            </li>
                            <li class="border-top mt-2">
                                <a class="dropdown-item text-center text-primary py-2" href="#">
                                    <i class="fas fa-eye me-1"></i> View all notifications
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- User Profile -->
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="position-relative me-2">
                                <div class="bg-gradient rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 bg-success border border-2 border-dark rounded-circle" 
                                     style="width: 12px; height: 12px;"></div>
                            </div>
                            <div class="d-none d-lg-flex flex-column me-2">
                                <span class="fw-bold text-white">{{ Auth::user()->name }}</span>
                                <small class="text-white-50">{{ Auth::user()->role }}</small>
                            </div>
                            <i class="fas fa-chevron-down text-white-50 d-none d-lg-block"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li class="px-3 py-3 border-bottom bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 45px; height: 45px;">
                                        <i class="fas fa-user text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-cog me-3 text-primary"></i>
                                    <div>My Profile</div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-3 text-info"></i>
                                    <div>Dashboard</div>
                                </a>
                            </li>
                            @if(Auth::user()->is_admin)
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('admin.settings') }}">
                                    <i class="fas fa-cog me-3 text-warning"></i>
                                    <div>Admin Settings</div>
                                </a>
                            </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 text-danger" 
                                   href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-3"></i>
                                    <div>Logout</div>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Login/Register -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light px-4" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                    </li>
                    @if(Route::has('register'))
                    <li class="nav-item ms-2">
                        <a class="nav-link btn btn-primary px-4" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </a>
                    </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>