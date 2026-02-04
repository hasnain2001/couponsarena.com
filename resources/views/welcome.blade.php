@extends('layouts.main')
@section('title')
CouponsArena | Latest Discount Codes & Shopping Guides
@endsection
@section('description')
Discover verified promo codes, exclusive deals, and expert shopping guides. Save money with our latest coupon codes and trend insights.
@endsection
@section('keywords')
coupon codes, discount codes, promo codes, deals, shopping guides, savings tips, online shopping, verified coupons
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('cssfile/home.css') }}">
@endpush

@section('main-content')
<main class="container-fluid px-0">
    <!-- Hero Banner with Top Blogs -->
    <section class="hero-banner">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold mb-4">Unlock Exclusive Savings</h1>
                <p class="lead mb-5">Smart shopping blogs, expert guides, and trending deals to help you save more every day.</p>
                
                <!-- Search Bar -->
                <form action="{{ route('storesearch') }}" method="GET" >
                <div class="search-container mx-auto mb-5" style="max-width: 600px;">
                    <div class="input-group">       
                    <input type="search" name="query" id="searchInput" class="form-control" placeholder="Search for articles...">
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </div>
                  </form>

                <!-- Top Blogs Grid -->
                @if($topblogs && count($topblogs) > 0)
                <div class="top-blogs-grid">
                    <div class="section-header mb-4">
                        <h2 class="section-title text-white">Top Picks This Week</h2>
                        <p class="text-white-50">Handpicked articles and deals for maximum savings</p>
                    </div>
                    
                    <div class="row g-4">
                        @foreach($topblogs->take(3) as $blog)
                        <div class="col-md-4">
                            <div class="top-blog-card">
                                <div class="top-blog-badge">
                                    <i class="fas fa-star me-1"></i>TOP PICK
                                </div>
                                <h3 class="top-blog-title">
                                    {{ Str::limit($blog->title, 50) }}
                                </h3>
                                <p class="top-blog-excerpt">
                                    {{ Str::limit(strip_tags($blog->content), 100) }}
                                </p>
                                <div class="top-blog-meta">
                                    <small>
                                        <i class="far fa-clock me-1"></i>
                                        {{ rand(3, 8) }} min read
                                    </small>
                                    <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="top-blog-read-more">
                                        Read More <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Featured Articles Section -->
    <section class="featured-articles">
        <div class="container">
            <div class="section-header mb-4">
                <h2 class="section-title">Featured Articles</h2>
                <p class="section-subtitle text-muted">Discover our most popular shopping guides and expert tips</p>
            </div>
            
            <div class="row g-4">
                @foreach($featuredBlogs as $blog)
                <div class="col-md-4">
                    <div class="featured-card h-100">
                        <div class="featured-image position-relative">
                            <img src="{{ asset($blog->category_image) }}" 
                                 alt="{{ $blog->title }}"
                                 class="img-fluid rounded-top">
                            <span class="featured-badge">Featured</span>
                        </div>
                        <div class="featured-content p-4">
                            <div class="category-tag mb-2">
                                <span class="badge bg-primary">{{ $blog->category->slug ?? 'General' }}</span>
                            </div>
                            <h3 class="featured-title h5 mb-3">
                                <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="text-decoration-none">
                                    {{ Str::limit($blog->title, 60) }}
                                </a>
                            </h3>
                            <div class="featured-meta d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $blog->created_at->format('M d, Y') }}
                                </small>
                                <small class="text-muted">
                                    <i class="far fa-eye me-1"></i>
                                    {{ rand(100, 5000) }} reads
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trending & Categories Section -->
    <section class="trending-featured">
        <div class="container">
            <div class="row g-4">
                <!-- Trending Articles -->
                <div class="col-lg-8">
                    <div class="section-header mb-4">
                        <h2 class="section-title">Trending Now</h2>
                        <p class="section-subtitle text-muted">What's hot in the world of savings</p>
                    </div>
                    <div class="row g-4">
                        @foreach($trendingBlogs as $index => $blog)
                        <div class="col-md-6">
                            <div class="trending-card d-flex h-100">
                                <div class="trending-number me-3">
                                    {{-- <span class="fw-bold">0{{ $index + 1 }}</span> --}}
                                    <div class="trending-number-bg" 
                                        style="background-image: url('{{ asset($blog->category_image) }}')">
                                    </div>
                                </div>
                                <div class="trending-content">
                                    <div class="category-tag mb-2">
                                        <span class="badge bg-secondary">{{ $blog->category->slug ?? 'General' }}</span>
                                    </div>
                                    <h4 class="h6 mb-2">
                                        <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($blog->title, 70) }}
                                        </a>
                                    </h4>
                                    <div class="trending-meta">
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            {{ $blog->created_at->format('M d') }} · 
                                            <i class="far fa-clock me-1 ms-2"></i>
                                            {{ rand(3, 10) }} min read
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Categories Sidebar -->
                <div class="col-lg-4">
                    <div class="categories-sidebar">
                        <div class="sidebar-header mb-4">
                            <h3 class="sidebar-title">Explore Categories</h3>
                            <div class="header-accent"></div>
                        </div>
                        
                        <div class="category-list">
                            @foreach(['Fashion', 'Electronics', 'Travel', 'Home and Garden', 'Food', 'Gifts and Flowers'] as $category)
                            <a href="{{ route('category.details', ['slug' => Str::slug($category)]) }}" class="category-item d-flex justify-content-between align-items-center py-3 border-bottom text-decoration-none">
                                <div class="category-name">
                                    <i class="fas fa-chevron-right me-2" style="color: var(--primary-color);"></i>
                                    <span class="text-dark">{{ $category }}</span>
                                </div>
                                {{-- <span class="badge bg-light text-dark">{{ $category->blogs->count() ?? rand(5, 50)  }}</span> --}}
                            </a>
                            @endforeach
                        </div>
                        
                        <!-- Newsletter Signup -->
                        <div class="newsletter-card mt-4 p-4 bg-light rounded">
                            <h5 class="mb-3 fw-bold">Get Weekly Newsletters</h5>
                            <p class="small text-muted mb-3">Subscribe to get expert shopping guides, market insights, and smart buying tips delivered to your inbox.</p>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email" style="border-color: var(--primary-color);">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Sections -->
    <section class="category-sections mb-5">
        <div class="container">
            @foreach(['Fashion' => $fashionBlogs, 'Gift Ideas' => $GiftBlogs] as $categoryName => $blogs)
            <div class="category-section mb-5">
                <div class="section-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="section-title">{{ $categoryName }}</h2>
                        <p class="text-muted mb-0">Latest in {{ strtolower($categoryName) }}</p>
                    </div>
                    <a href="{{ route('category.details', ['slug' => Str::slug($categoryName)]) }}" class="btn btn-outline-primary btn-sm">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                
                <div class="row g-4">
                    @foreach($blogs as $blog)
                    <div class="col-md-4 col-lg-3">
                        <div class="latest-card">
                            <div class="latest-image mb-3">
                                <img src="{{ asset($blog->category_image) }}" 
                                     alt="{{ $blog->title }}"
                                     class="img-fluid rounded">
                            </div>
                            <div class="latest-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge" style="background: var(--primary-color);">{{ $blog->category->slug ?? 'General' }}</span>
                                    <small class="text-muted">{{ $blog->created_at->format('M d') }}</small>
                                </div>
                                <h4 class="h6 mb-3">
                                    <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($blog->title, 50) }}
                                    </a>
                                </h4>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="btn btn-link p-0" style="color: var(--primary-color);">
                                        Read <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                    <small class="text-muted">
                                        <i class="far fa-eye me-1"></i> {{ rand(50, 1000) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>
<!-- CTA Banner for Blogging Website -->
<section class="cta-banner py-5 mb-5">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-4">Stay Updated with Expert Shopping Guides</h2>
                <p class="lead mb-4">Get the latest trends, money-saving tips, and expert advice delivered directly to your inbox.</p>
                
                <!-- Two CTA Buttons Side by Side -->
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mb-5">
                    <a href="{{ route('blog',['lang' => app()->getLocale()]) }}" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="fas fa-book-open me-2"></i>Explore All Articles
                    </a>
                    <a href="#newsletter" class="btn btn-outline-primary btn-lg px-5 py-3">
                        <i class="fas fa-envelope me-2"></i>Subscribe to Newsletter
                    </a>
                </div>

                <!-- Stats Counter -->
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="counter-item">
                            <h3 class="display-4 fw-bold text-primary">1,000+</h3>
                            <p class="text-muted">Expert Articles Published</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="counter-item">
                            <h3 class="display-4 fw-bold text-primary">50K+</h3>
                            <p class="text-muted">Monthly Readers</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="counter-item">
                            <h3 class="display-4 fw-bold text-primary">95%</h3>
                            <p class="text-muted">Reader Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection