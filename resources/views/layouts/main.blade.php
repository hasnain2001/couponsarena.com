<?php
header("X-Robots-Tag: index, follow");
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Essential Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="Uzair">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ request()->url() }}">
       <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <!-- Verification Meta Tags -->
    <meta name="verify-admitad" content="f0d873ca8d">
    <meta name="63711d15cd5e7aa" content="31f76a5fad0bded704d8c077fe66a830">
    <meta name="mylead-verification" content="f7ea0dd41c6c08d393d95a3019348565">
    <meta name="linkbuxverifycode" content="32dc01246faccb7f5b3cad5016dd5033">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cssfile/home.css') }}">
    <link rel="stylesheet" href="{{ asset('cssfile/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('cssfile/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('cssfile/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L63MY7QC0K"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-20TPD768B2"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B9GQCLK2K1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-L63MY7QC0K');
        gtag('config', 'G-20TPD768B2');
        gtag('config', 'G-B9GQCLK2K1');
    </script>

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <x-navbar />

    <!-- Main Content -->
    <main>
        @yield('main-content')
    </main>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
      <button onclick="topFunction()" id="myBtn" title="Go to top">
        <i class="fas fa-chevron-up"></i>
    </button>
    <!-- Footer -->
    <x-footer />

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="{{ asset('bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/footer.js') }}"></script>

    @stack('scripts')
</body>
</html>
