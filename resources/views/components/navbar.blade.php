
    <!-- Navbar -->
    <header class="header-container  text-capitalize">
        <div class="navbar-brand d-sm-block d-none">
            <a href="/">
                <img src="{{ asset('images/logodesktop.png') }}" alt="Logo" class="logo">
            </a>
        </div>
   <nav class="navbar">
         <!-- Logo -->
         <div class="navbar-brand d-block d-sm-none ">
            <a href="/">
                <img src="{{ asset('images/mb-logo.png') }}" alt="Logo" class="logo">
            </a>
        </div>

        <!-- Desktop Menu -->
        <div class="navbar-menu">
            <a href="{{ url(app()->getLocale() . '/') }}">@lang('message.home')</a>
            <li class="mega-dropdown d-none d-sm-block">
                <a href="#" class="dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">@lang('message.category')</a>
                <div class="dropdown-menu mega-menu" aria-labelledby="navbarDropdown">
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-md-3">
                                <a href="{{ route('category.details', ['slug' => Str::slug($category->slug)]) }}">{{ $category->title }}</a>
                            </div>
                            @if ($loop->iteration % 4 == 0)
                                </div><div class="row">
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
            <a href="{{ route('contact', ['lang' => app()->getLocale()]) }}">@lang('message.contact')</a>
            <a href="{{ route('blog', ['lang' => app()->getLocale()]) }}">@lang('message.news')</a>
            <div class="search-container">
                <form id="searchForm" action="{{ route('storesearch') }}" method="GET" class="d-flex" role="search">
                    <input type="search" name="query" id="searchInput" placeholder="@lang('message.search')">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!-- Social Icons -->
        <div class="social-icons">
            <a href="https://www.facebook.com/profile.php?id=61571970471132" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/coupons.arena/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href=" https://www.tiktok.com/@couponsarena" target="_blank"><i class="fab fa-tiktok"></i></a>
        </div>

        <!-- Language Selector -->
        <div class="language-selector">
            <a href="#">{{ strtoupper(app()->getLocale()) }}</a>
            <ul>
                @foreach ($langs as $lang)
                <li><a href="{{ url('/' . $lang->code) }}">  {{ strtoupper($lang->code) }}</a></li>
@endforeach
            </ul>
        </div>

        <!-- Toggler for Mobile -->
        <button class="navbar-toggler" onclick="toggleMobileMenu()">
            &#9776;
        </button>
   </nav>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <span class="close-btn" onclick="toggleMobileMenu()">&times;</span>
        <div class="social-icons">
           <a href="https://www.facebook.com/profile.php?id=61571970471132" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/coupons.arena/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href=" https://www.tiktok.com/@couponsarena" target="_blank"><i class="fab fa-tiktok"></i></a>
        </div>
        <div class="menu-links">
            <a href="{{ url(app()->getLocale() . '/') }}">@lang('message.home')</a>

            <div class="mobile-categories">
                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                    @lang('message.category')
                </a>

                <!-- Modal -->
                <div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark ">
                            <div class="modal-header">
                                <h5 class="modal-title text-white" id="categoriesModalLabel"> @lang('message.category')</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-dark" style="max-height: 400px; overflow-y: auto;">
                                @foreach ($categories as $category)
                                    <a href="{{ route('category.details', ['slug' => Str::slug($category->slug)]) }}" class="text-dark-">{{ $category->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('contact', ['lang' => app()->getLocale()]) }}">@lang('message.contact')</a>
            <a href="{{ route('blog', ['lang' => app()->getLocale()]) }}">@lang('message.news')</a>
            <div class="search-container">
                <form id="searchForm" action="{{ route('storesearch') }}" method="GET" class="d-flex" role="search">
                    <input type="search" name="query" id="searchInput" placeholder="@lang('message.search')">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>




