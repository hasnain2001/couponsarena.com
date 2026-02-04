@extends('layouts.main')
@section('title','Page Not Found - 404 Error')
@section('description','The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.')
@section('main-content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content text-center py-8">
            <!-- Animated 404 Graphic -->
            <div class="error-graphic mb-5">
                <div class="error-number">
                    <span class="number-4">4</span>
                    <div class="floating-planet">
                        <div class="planet"></div>
                    </div>
                    <span class="number-4">4</span>
                </div>
            </div>

            <!-- Error Message -->
            <div class="error-message mb-5">
                <h1 class="error-title">Oops! Page Not Found</h1>
                <p class="error-description lead">
                    The page you are looking for might have been removed, had its name changed, 
                    or is temporarily unavailable.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="error-actions mb-6">
                <div class="row g-3 justify-content-center">
                    <div class="col-auto">
                        <button onclick="history.back()" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="/" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Home Page
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="/contact" class="btn btn-outline-dark btn-lg">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="quick-links mt-6">
                <h5 class="mb-4">You might be looking for:</h5>
                <div class="row g-3 justify-content-center">
                    <div class="col-md-3 col-6">
                        <a href="{{ route('store', ['lang' => app()->getLocale()]) }}" class="quick-link-card">
                            <i class="fas fa-store fa-2x mb-3"></i>
                            <span>Popular Stores</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('blog', ['lang' => app()->getLocale()]) }}" class="quick-link-card">
                            <i class="fas fa-blog fa-2x mb-3"></i>
                            <span>Blog Posts</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('categories') }}" class="quick-link-card">
                            <i class="fas fa-tags fa-2x mb-3"></i>
                            <span>Categories</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('coupons', ['lang' => app()->getLocale()]) }}" class="quick-link-card">
                            <i class="fas fa-percent fa-2x mb-3"></i>
                            <span>Hot Deals</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="error-search mt-6">
                <h6 class="mb-3">Or search for what you need:</h6>
                <div class="search-container mx-auto" style="max-width: 500px;">

                    <form id="searchForm" action="{{ route('storesearch') }}" method="GET" class="d-flex" role="search">
                        <input type="text" name="query" id="searchInput" class="form-control form-control-lg me-2" 
                               placeholder="@lang('message.search')">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('cssfile/404.css') }}">
@endpush