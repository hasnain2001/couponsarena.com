@extends('layouts.main')
@section('title')
{!! $category->title !!} - Best Deals & Discounts
@endsection
@section('description')
{!! $category->meta_description ?? "Discover amazing deals and discounts in {$category->title}. Find the best coupon codes and offers from top stores." !!}
@endsection
@section('keywords')
{!! $category->meta_keyword ?? "{$category->title}, deals, discounts, coupons, offers, stores, shopping" !!}
@endsection

@section('main-content')

<div class="category-page">
    <!-- Hero Section -->
    <section class="category-hero py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    @if ($category->category_image)
                    <div class="category-hero-image mb-4">
                        <img src="{{ asset('uploads/categories/' . $category->category_image) }}"
                             alt="{{ $category->title }}"
                             class="hero-category-image">
                    </div>
                    @endif
                    <h1 class="hero-title display-4 fw-bold mb-3">{{ $category->title }}</h1>
                    <p class="hero-subtitle lead mb-4">
                        Discover the best deals and exclusive discounts in {{ $category->title }}
                    </p>
                    <div class="hero-stats d-flex justify-content-center gap-4 flex-wrap">
                        <div class="stat-item text-white">
                            <div class="stat-number fw-bold">{{ $blogs->count() }}+</div>
                            <div class="stat-label">Blogs</div>
                        </div>
                        <div class="stat-item text-white">
                            <div class="stat-number fw-bold">1000+</div>
                            <div class="stat-label">Active Deals</div>
                        </div>
                        <div class="stat-item text-white">
                            <div class="stat-number fw-bold">24/7</div>
                            <div class="stat-label">Updated</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/" class="text-decoration-none">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/categories" class="text-decoration-none">
                        <i class="fas fa-tags me-2"></i>Categories
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $category->title }}
                </li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="category-header mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="category-stores-title mb-2">Blogs in {{ $category->title }}</h2>
                    <p class="category-stores-subtitle text-muted mb-0">
                        Total Blogs: <span class="fw-bold text-primary">{{ $blogs->count() }}</span>
                    </p>
                </div>
                {{-- <div class="category-filter">
                    <select class="form-select form-select-sm" style="max-width: 200px;">
                        <option>Sort by: Popularity</option>
                        <option>Sort by: Name A-Z</option>
                        <option>Sort by: Newest</option>
                    </select>
                </div> --}}
            </div>
        </div>


         <!-- Blog Grid -->
        <div class="stores-grid mt-5">
            @forelse ($blogs as $blog)
            <div class="store-card-wrapper">
                <div class="store-card card border-0 shadow-sm h-100">
                    <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="store-card-link text-decoration-none">
                        <div class="store-image-container">
                            <img src="{{ asset($blog->category_image) }}"
                                 class="store-image"
                                 alt="{{ $blog->title }}"
                                 loading="lazy">
                            <div class="store-overlay">
                                <span class="view-deals-btn">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                        <div class="card-body text-center p-3">
                            <h5 class="store-name mb-2">{{ $blog->title ?: "Blog Title" }}</h5>
                            <div class="store-meta">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $blog->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-category-state text-center py-5">
                <div class="empty-icon mb-4">
                    <i class="fas fa-store fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">No Blogs Available</h3>
                <p class="text-muted mb-4">
                    There are currently no blogs in this category. Check back soon for new additions!
                </p>
                <div class="empty-actions">
                    <a href="{{ route('blog', ['lang' => app()->getLocale()]) }}" class="btn btn-primary me-3">
                        <i class="fas fa-blog me-2"></i>Browse Blogs
                    </a>
                </div>
            </div>
            @endforelse
        </div>
                {{-- <!-- Stores Grid -->
        <div class="stores-grid">
            @forelse ($stores as $store)
            <div class="store-card-wrapper">
                <div class="store-card card border-0 shadow-sm h-100">
                    <a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}" class="store-card-link text-decoration-none">
                        <div class="store-image-container">
                            <img src="{{ $store->store_image ?
                                        asset('uploads/stores/' . $store->store_image) :
                                        asset('front/assets/images/no-image-found.jpg') }}"
                                 class="store-image"
                                 alt="{{ $store->name }}"
                                 loading="lazy">
                            <div class="store-overlay">
                                <span class="view-deals-btn">
                                    View Deals <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                            <div class="store-badge">
                                <i class="fas fa-tag me-1"></i>
                                {{ $store->coupons_count ?? 0 }}
                            </div>
                        </div>
                        <div class="card-body text-center p-3">
                            <h5 class="store-name mb-2">{{ $store->name ?: "Store Name" }}</h5>
                            <div class="store-meta">
                                <small class="text-muted">
                                    <i class="fas fa-store me-1"></i>
                                    {{ $store->coupons_count ?? 0 }} offers
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-category-state text-center py-5">
                <div class="empty-icon mb-4">
                    <i class="fas fa-store fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">No Stores Available</h3>
                <p class="text-muted mb-4">
                    There are currently no stores in this category. Check back soon for new additions!
                </p>
                <div class="empty-actions">
                    <a href="/categories" class="btn btn-primary me-3">
                        <i class="fas fa-tags me-2"></i>Browse Categories
                    </a>
                    <a href="/stores" class="btn btn-outline-primary">
                        <i class="fas fa-store me-2"></i>All Stores
                    </a>
                </div>
            </div>
            @endforelse
        </div> --}}

        <!-- Category Description -->
        @if($category->description)
        <section class="category-description mt-6 pt-5 border-top">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h3 class="mb-4">About {{ $category->title }}</h3>
                    <div class="category-content">
                        {!! $category->description !!}
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Related Categories -->
        <section class="related-categories mt-6 pt-5 border-top">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h3 class="mb-4">Explore More Categories</h3>
                    <p class="text-muted mb-4">Discover amazing deals across all categories</p>
                    <div class="related-categories-grid">
                        @foreach($explorecategories as $explorecategory)
                        <a href="/categories/{{ Str::slug($explorecategory->title) }}" class="related-category-btn">{{ $explorecategory->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('cssfile/related-category.css') }}">
@endpush
