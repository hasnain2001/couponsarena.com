<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modern Navbar</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 120px;
            min-height: 200vh;
            background: #f8f9fa;
        }

        /* Modern Navbar Container */
        .modern-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(135deg, #000000 0%, #2e2bb1 50%, #791291 100%);
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-bottom: 3px solid transparent;
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
        }

        .modern-navbar.scrolled-down {
            transform: translateY(-100%);
            opacity: 0;
        }

        .modern-navbar.scrolled-up {
            transform: translateY(0);
            opacity: 1;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Top Bar */
        .nav-top-bar {
            background: rgba(0, 0, 0, 0.8);
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .top-bar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 20px;
        }

        /* Main Nav Container */
        .nav-main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-main-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            height: 80px;
        }

        /* Logo Section */
        .nav-brand {
            flex: 0 0 auto;
        }

        .nav-brand .logo {
            height: 60px;
            width: auto;
            transition: all 0.5s ease;
            filter: brightness(0) invert(1);
        }

        .nav-brand .logo:hover {
            transform: scale(1.05) rotate(-2deg);
            filter: brightness(0) invert(1) drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
        }

        .nav-brand-mobile {
            display: none;
        }

        /* Desktop Navigation */
        .nav-desktop {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
            list-style: none;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #ff6b6b 0%, #2e2bb1 100%);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        /* Mega Dropdown */
        .mega-dropdown {
            position: relative;
        }

        .mega-dropdown-toggle {
            position: relative;
            padding-right: 25px !important;
            cursor: pointer;
        }

        .mega-dropdown-toggle::after {
            content: '▼';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .mega-dropdown:hover .mega-dropdown-toggle::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 800px;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            display: none;
            opacity: 0;
            transform: translateY(15px);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1001;
        }

        .mega-dropdown:hover .mega-menu {
            display: block;
            opacity: 1;
            transform: translateY(10px);
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(10px);
            }
        }

        .mega-menu-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .mega-menu-column {
            padding: 10px;
        }

        .mega-menu-column h4 {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .mega-menu-link {
            color: white;
            text-decoration: none;
            display: block;
            padding: 6px 0;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border-left: 2px solid transparent;
            padding-left: 10px;
        }

        .mega-menu-link:hover {
            color: #ff6b6b;
            padding-left: 15px;
            border-left-color: #ff6b6b;
        }

        /* Search Container */
        .search-container {
            position: relative;
        }

        .search-form {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 5px 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .search-form:focus-within {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ff6b6b;
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.2);
        }

        .search-input {
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 8px 12px;
            width: 200px;
            font-size: 0.95rem;
            transition: width 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .search-input:focus {
            width: 250px;
        }

        .search-btn {
            border: none;
            background: transparent;
            color: white;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-btn:hover {
            color: #ff6b6b;
            transform: rotate(15deg);
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .social-icons a {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Language Selector */
        .language-selector {
            position: relative;
            margin-left: 15px;
        }

        .language-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .language-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            text-decoration: none;
        }

        .language-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 10px;
            min-width: 120px;
            display: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1002;
        }

        .language-selector:hover .language-dropdown {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .language-option {
            display: block;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .language-option:hover {
            background: rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }

        /* Mobile Toggle */
        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.8rem;
            cursor: pointer;
            padding: 8px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            color: #ff6b6b;
            transform: rotate(90deg);
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.98);
            backdrop-filter: blur(20px);
            padding: 20px;
            transition: right 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1002;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .mobile-menu.active {
            right: 0;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            color: #ff6b6b;
            transform: rotate(90deg);
        }

        .mobile-menu-header {
            display: flex;
            justify-content: center;
            padding: 40px 0 20px;
        }

        .mobile-menu-logo {
            height: 50px;
            filter: brightness(0) invert(1);
        }

        .menu-links {
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .mobile-nav-link {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            font-size: 1.1rem;
        }

        .mobile-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateX(10px);
            text-decoration: none;
        }

        .mobile-social-icons {
            margin-top: auto;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            gap: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Categories Modal */
        .modal-content.bg-dark {
            background: rgba(0, 0, 0, 0.95) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-body a {
            display: block;
            color: white !important;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .modal-body a:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 20px;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .mega-menu {
                width: 700px;
            }
            
            .search-input {
                width: 180px;
            }
            
            .search-input:focus {
                width: 220px;
            }
        }

        @media (max-width: 992px) {
            .nav-desktop {
                display: none;
            }
            
            .navbar-toggler {
                display: block;
            }
            
            .mega-menu {
                width: 600px;
                left: -200px;
            }
            
            .mega-menu-content {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .search-input {
                width: 150px;
            }
            
            .nav-brand-mobile {
                display: block;
            }
            
            .nav-brand-desktop {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .nav-brand .logo {
                height: 50px;
            }
            
            .nav-main-content {
                height: 70px;
            }
            
            .mega-menu {
                width: 100%;
                left: 0;
                right: 0;
                border-radius: 0 0 15px 15px;
            }
            
            .mega-menu-content {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .search-input {
                width: 120px;
            }
            
            .search-input:focus {
                width: 150px;
            }
        }

        @media (max-width: 576px) {
            .nav-brand {
                flex: 1;
            }
            
            .nav-brand .logo {
                height: 45px;
            }
            
            .mega-menu-content {
                grid-template-columns: 1fr;
            }
            
            .search-container {
                display: none;
            }
            
            .mobile-search {
                display: block;
                width: 100%;
            }
            
            .mobile-search .search-form {
                display: flex;
                margin-bottom: 20px;
            }
            
            .language-selector {
                display: none;
            }
        }

        /* Demo Content */
        .demo-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .demo-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .demo-card h2 {
            color: #2e2bb1;
            margin-bottom: 20px;
        }

        .demo-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        /* Scroll to Top Button */
        .scroll-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff6b6b 0%, #2e2bb1 100%);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
        }

        .scroll-top-btn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top-btn:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.6);
        }

        /* Fix for logo display */
        .logo {
            display: block;
            max-width: 100%;
            height: auto;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Modern Navbar -->
    <nav class="modern-navbar" id="modernNavbar">
        <!-- Top Bar (optional for promotions/alerts) -->
        <div class="nav-top-bar d-none d-md-block">
            <div class="top-bar-container">
                <span style="color: rgba(255,255,255,0.7); font-size: 0.85rem;">
                    <i class="fas fa-gift me-1"></i> Special Offers Available!
                </span>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="nav-main-container">
            <div class="nav-main-content">
                <!-- Desktop Logo -->
                <div class="nav-brand nav-brand-desktop">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/old-logo.png') }}" alt="CouponsArena" class="logo">
                    </a>
                </div>

                <!-- Mobile Logo (Hidden on desktop) -->
                <div class="nav-brand nav-brand-mobile">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="CouponsArena" class="logo">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="nav-desktop d-none d-lg-flex">
                    <ul class="nav-links">
                        <li>
                            <a href="{{ url(app()->getLocale() . '/') }}" class="nav-link active">@lang('message.home')</a>
                        </li>
                        
                        <!-- Mega Menu Dropdown -->
                        <li class="mega-dropdown">
                            <a href="#" class="nav-link mega-dropdown-toggle">@lang('message.category')</a>
                            <div class="mega-menu">
                                <div class="mega-menu-content">
                                    @php
                                        // Group categories into 4 columns
                                        $chunkedCategories = isset($categories) ? $categories->chunk(ceil($categories->count() / 4)) : [];
                                    @endphp
                                    
                                    @foreach($chunkedCategories as $categoryGroup)
                                    <div class="mega-menu-column">
                                        @foreach($categoryGroup as $category)
                                        <a href="{{ route('category.details', ['slug' => \Illuminate\Support\Str::slug($category->slug)]) }}" 
                                           class="mega-menu-link">
                                            {{ $category->title }}
                                        </a>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <a href="{{ route('contact',['lang' => app()->getLocale()]) }}" class="nav-link">@lang('message.contact')</a>
                        </li>
                        <li>
                            <a href="{{ route('blog',['lang' => app()->getLocale()]) }}" class="nav-link">@lang('message.news')</a>
                        </li>
                    </ul>
                </div>

                <!-- Search Bar -->
                <div class="search-container d-none d-md-block">
                    <form id="searchForm" action="{{ route('storesearch') }}" method="GET" class="search-form">
                        <input type="search" 
                               name="query" 
                               id="searchInput"
                               class="search-input"
                               placeholder="@lang('message.search')"
                               autocomplete="off">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Social Icons -->
                <div class="social-icons d-none d-lg-flex">
                    <a href="https://www.facebook.com/profile.php?id=61571970471132" 
                       target="_blank" 
                       title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/coupons.arena/" 
                       target="_blank" 
                       title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@couponsarena" 
                       target="_blank" 
                       title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>

                <!-- Language Selector -->
                <div class="language-selector d-none d-lg-block">
                    <a href="#" class="language-btn">
                        <span class="current-lang">{{ strtoupper(app()->getLocale()) }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="language-dropdown">
                        @if(isset($langs))
                            @foreach($langs as $lang)
                            <a href="{{ url('/' . $lang->code) }}" 
                               class="language-option {{ app()->getLocale() == $lang->code ? 'active' : '' }}">
                                {{ strtoupper($lang->code) }}
                            </a>
                            @endforeach
                        @else
                            @foreach(['en', 'de', 'fr', 'es'] as $lang)
                            <a href="{{ url('/' . $lang) }}" 
                               class="language-option {{ app()->getLocale() == $lang ? 'active' : '' }}">
                                {{ strtoupper($lang) }}
                            </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler d-lg-none" onclick="toggleMobileMenu()">
                    &#9776;
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <span class="close-btn" onclick="toggleMobileMenu()">&times;</span>
        
        <div class="mobile-menu-header">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/mb-logo.png') }}" alt="Logo" class="mobile-menu-logo">
            </a>
        </div>

        <!-- Mobile Search -->
        <div class="search-container d-md-none mb-4">
            <form id="mobileSearchForm" action="{{ route('storesearch') }}" method="GET" class="search-form">
                <input type="search" 
                       name="query" 
                       class="search-input"
                       placeholder="@lang('message.search')">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Mobile Navigation Links -->
        <div class="menu-links">
            <a href="{{ url(app()->getLocale() . '/') }}" 
               class="mobile-nav-link" 
               onclick="toggleMobileMenu()">
                <i class="fas fa-home me-2"></i>@lang('message.home')
            </a>
            
            <a href="#" 
               class="mobile-nav-link" 
               data-bs-toggle="modal" 
               data-bs-target="#mobileCategoriesModal"
               onclick="toggleMobileMenu()">
                <i class="fas fa-th-large me-2"></i>@lang('message.category')
            </a>
            
            <a href="{{ route('contact',['lang' => app()->getLocale()]) }}" 
               class="mobile-nav-link" 
               onclick="toggleMobileMenu()">
                <i class="fas fa-envelope me-2"></i>@lang('message.contact')
            </a>
            
            <a href="{{ route('blog',['lang' => app()->getLocale()]) }}" 
               class="mobile-nav-link" 
               onclick="toggleMobileMenu()">
                <i class="fas fa-newspaper me-2"></i>@lang('message.news')
            </a>
        </div>

        <!-- Mobile Social Icons -->
        <div class="mobile-social-icons">
            <a href="https://www.facebook.com/profile.php?id=61571970471132" 
               target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.instagram.com/coupons.arena/" 
               target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.tiktok.com/@couponsarena" 
               target="_blank">
                <i class="fab fa-tiktok"></i>
            </a>
        </div>

        <!-- Mobile Language Selector -->
        <div class="language-selector mt-4">
            <select class="form-select bg-dark text-white border-secondary" onchange="changeLanguage(this)">
                @if(isset($langs))
                    @foreach($langs as $lang)
                    <option value="{{ $lang->code }}" {{ app()->getLocale() == $lang->code ? 'selected' : '' }}>
                        {{ strtoupper($lang->code) }}
                    </option>
                    @endforeach
                @else
                    @foreach(['en', 'de', 'fr', 'es'] as $lang)
                    <option value="{{ $lang }}" {{ app()->getLocale() == $lang ? 'selected' : '' }}>
                        {{ strtoupper($lang) }}
                    </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <!-- Categories Modal for Mobile -->
    <div class="modal fade" id="mobileCategoriesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white">@lang('message.category')</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    @if(isset($categories))
                        @foreach($categories as $category)
                        <a href="{{ route('category.details', ['slug' => \Illuminate\Support\Str::slug($category->slug)]) }}" 
                           class="text-white text-decoration-none d-block p-2 mb-2 bg-secondary bg-opacity-25 rounded">
                            <i class="fas fa-arrow-right me-2"></i>{{ $category->title }}
                        </a>
                        @endforeach
                    @else
                        @foreach(['Electronics', 'Fashion', 'Home & Garden', 'Beauty', 'Sports', 'Travel'] as $cat)
                        <a href="#" class="text-white text-decoration-none d-block p-2 mb-2 bg-secondary bg-opacity-25 rounded">
                            <i class="fas fa-arrow-right me-2"></i>{{ $cat }}
                        </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-top-btn" id="scrollTopBtn" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll behavior
        let lastScrollTop = 0;
        const navbar = document.getElementById('modernNavbar');
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Show/hide scroll to top button
            if (scrollTop > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
            
            // Navbar hide/show on scroll
            if (scrollTop > 100) {
                if (scrollTop > lastScrollTop) {
                    // Scrolling down
                    navbar.classList.add('scrolled-down');
                    navbar.classList.remove('scrolled-up');
                } else {
                    // Scrolling up
                    navbar.classList.remove('scrolled-down');
                    navbar.classList.add('scrolled-up');
                }
            } else {
                navbar.classList.remove('scrolled-down', 'scrolled-up');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const body = document.body;
            
            mobileMenu.classList.toggle('active');
            
            if (mobileMenu.classList.contains('active')) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const navbarToggler = document.querySelector('.navbar-toggler');
            
            if (mobileMenu.classList.contains('active') && 
                !mobileMenu.contains(event.target) && 
                !navbarToggler.contains(event.target)) {
                toggleMobileMenu();
            }
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            // Prevent form submission if empty search
            document.getElementById('searchForm')?.addEventListener('submit', function(e) {
                const query = this.querySelector('input[name="query"]').value.trim();
                if (!query) {
                    e.preventDefault();
                    this.querySelector('input').focus();
                }
            });
            
            document.getElementById('mobileSearchForm')?.addEventListener('submit', function(e) {
                const query = this.querySelector('input[name="query"]').value.trim();
                if (!query) {
                    e.preventDefault();
                    this.querySelector('input').focus();
                }
            });
        }
        
        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Language change function
        function changeLanguage(select) {
            const lang = select.value;
            window.location.href = `/${lang}`;
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to current page link
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
            
            navLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath === currentPath || 
                    (currentPath.endsWith('/') && linkPath === currentPath) ||
                    (currentPath === '/' && linkPath.includes('/' + app()->getLocale() + '/')) ||
                    (currentPath.includes('/contact') && linkPath.includes('/contact'))) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
            
            // Close mobile menu when clicking a link
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (!this.hasAttribute('data-bs-toggle')) {
                        toggleMobileMenu();
                    }
                });
            });
        });
        
        // Global variable for current locale (simulated)
        const currentLocale = "{{ app()->getLocale() }}";
    </script>
</body>
</html>