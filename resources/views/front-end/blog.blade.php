@extends('layouts.main')
@section('title', 'The Real Deal by ' . config('app.name') . ': Daily Savings, Buying Guides & Expert Reviews')
@section('description','Get savings tips, smart shopping advice and deals from ' . config('app.name') . 's blog, The Real Deal. Read consumer news, product reviews and gift guides for all occasions.')
@section('keywords','savings tips, smart shopping advice, deals, consumer news, product reviews, gift guides, blog, The Real Deal, Coupons Arena')

@section('main-content')
<div class="container-fluid py-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="blog-hero text-center py-5 rounded-4">
                <h1 class="display-5 fw-bold text-white mb-3">The Real Deal Blog</h1>
                <p class="lead text-white mb-4">Daily Savings, Buying Guides & Expert Reviews</p>
                <div class="hero-stats d-flex justify-content-center gap-4">
                    <div class="stat-item text-white">
                        <div class="stat-number fw-bold">{{ $blogs->total() }}</div>
                        <div class="stat-label">Articles</div>
                    </div>
                    <div class="stat-item text-white">
                        <div class="stat-number fw-bold">50K+</div>
                        <div class="stat-label">Readers</div>
                    </div>
                    <div class="stat-item text-white">
                        <div class="stat-number fw-bold">{{$updatedblog}}</div>
                        <div class="stat-label">Updates</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/" class="text-decoration-none">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-blog me-2"></i>Blog
                </li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-lg-10">
                <div class="row g-4">
                    @foreach ($blogs as $blog)
                    <div class="col-12">
                        <article class="blog-card card border-0 shadow-sm h-100">
                            <div class="row g-0 h-100">
                                <!-- Blog Image -->
                                <div class="col-md-5">
                                    <div class="blog-image-wrapper h-100">
                                        <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}">
                                            <img src="{{ asset($blog->category_image) }}"
                                                 alt="{{ $blog->title }}"
                                                 class="blog-image"
                                                 loading="lazy"
                                                 decoding="async"
                                                 width="100%"
                                                 height="100%"
                                                 >
                                        </a>
                                        <div class="blog-badge">
                                            <i class="fas fa-tag me-1"></i>Blog
                                        </div>
                                    </div>
                                </div>

                                <!-- Blog Content -->
                                <div class="col-md-7">
                                    <div class="card-body d-flex flex-column h-100">
                                        <div class="blog-meta mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $blog->created_at->format('M d, Y') }}
                                            </small>
                                            <small class="text-muted ms-3">
                                                <i class="fas fa-clock me-1"></i>
                                                5 min read
                                            </small>
                                        </div>

                                        <h3 class="blog-title">
                                            <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="text-decoration-none text-dark">
                                                {{ $blog->title }}
                                            </a>
                                        </h3>

                                        <p class="blog-excerpt text-muted flex-grow-1">
                                            {{ Str::limit(strip_tags($blog->description ?? 'Discover amazing insights and tips in this blog post.'), 120) }}
                                        </p>

                                        <div class="blog-actions d-flex justify-content-between align-items-center">
                                            <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="btn btn-primary rounded-pill px-4">
                                                Read More <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                            <div class="blog-stats">
                                                <small class="text-muted">
                                                    <i class="fas fa-eye me-1"></i>1.2K
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $blogs->links('vendor.pagination.custom') }}
                </div>
            </div>

            {{-- <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-sticky">
                    <!-- Latest Stores -->
                    <div class="sidebar-card card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h4 class="card-title mb-0 text-center">
                                <i class="fas fa-store me-2"></i>Latest Stores
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($chunks as $store)
                                <div class="list-group-item border-0 py-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="store-avatar me-3">
                                                <img src="{{ asset('uploads/stores/' . $store->store_image) }}"
                                                     alt="{{ $store->name }}"
                                                     class="store-img"
                                                     loading="lazy"
                                                     decoding="async"
                                                     width="50"
                                                     height="50"
                                                     >
                                            </div>
                                            <div class="store-info">
                                                <h6 class="store-name mb-1">{{ $store->name }}</h6>
                                                <small class="text-muted">
                                                    {{ $store->coupons->count() ?? 0 }} offers
                                                </small>
                                            </div>
                                        </div>
                                        <a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                            Visit <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Subscription -->
                    <div class="sidebar-card card border-0 shadow-sm mb-4">
                        <div class="card-body text-center py-4">
                            <div class="newsletter-icon mb-3">
                                <i class="fas fa-envelope-open-text fa-2x text-primary"></i>
                            </div>
                            <h5 class="card-title">Stay Updated</h5>
                            <p class="card-text text-muted small">
                                Get the latest deals and blog posts delivered to your inbox.
                            </p>
                            <form class="newsletter-form">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" placeholder="Your email" required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Popular Tags -->
                    <div class="sidebar-card card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-tags me-2"></i>Popular Topics
                            </h5>
                            <div class="tags-container">
                            @foreach ($categories as $category)
                                <a href="{{ route('related_category', ['slug' => Str::slug($category->slug)]) }}" class="tag-badge">
                                    {{ $category->title }}
                                </a>
                            @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --primary-color: #2e2bb1;
    --secondary-color: #791291;
    --accent-color: #ff6b6b;
    --text-dark: #2d3748;
    --text-light: #718096;
    --bg-light: #f7fafc;
}

/* Hero Section */
.blog-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    position: relative;
    overflow: hidden;
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.stat-item {
    position: relative;
    z-index: 2;
}

.stat-number {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

/* Blog Cards */
.blog-card {
    transition: all 0.3s ease;
    border-radius: 16px;
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(46, 43, 177, 0.15) !important;
}

.blog-image-wrapper {
    position: relative;
    overflow: hidden;
}

.blog-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-image {
    transform: scale(1.05);
}

.blog-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: var(--accent-color);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.blog-title {
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 0.75rem;
}

.blog-title a:hover {
    color: var(--primary-color) !important;
}

.blog-excerpt {
    line-height: 1.6;
    margin-bottom: 1rem;
}

.blog-meta {
    font-size: 0.875rem;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #4a46d4);
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #25219c, var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 43, 177, 0.3);
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
    font-weight: 500;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    transform: translateY(-1px);
}

/* Sidebar */
.sidebar-sticky {
    position: sticky;
    top: 100px;
}

.sidebar-card {
    border-radius: 12px;
    overflow: hidden;
}

.store-avatar {
    flex-shrink: 0;
}

.store-img {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.store-name {
    color: var(--text-dark);
    font-weight: 600;
    font-size: 0.95rem;
}

.list-group-item {
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #edf2f7 !important;
}

.list-group-item:hover {
    background-color: var(--bg-light);
}

.list-group-item:last-child {
    border-bottom: none !important;
}

/* Tags */
.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-badge {
    background: #e2e8f0;
    color: var(--text-dark);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.tag-badge:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

/* Newsletter */
.newsletter-icon {
    color: var(--primary-color);
}

.newsletter-form .form-control {
    border-radius: 25px 0 0 25px;
    border: 1px solid #e2e8f0;
}

.newsletter-form .btn {
    border-radius: 0 25px 25px 0;
}

/* Breadcrumb */
.breadcrumb {
    background: var(--bg-light);
    border-radius: 10px;
    padding: 12px 20px;
}

.breadcrumb-item a {
    color: var(--primary-color);
    font-weight: 500;
}

.breadcrumb-item.active {
    color: var(--text-light);
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-hero {
        padding: 2rem 1rem !important;
    }

    .display-5 {
        font-size: 2rem;
    }

    .hero-stats {
        gap: 2rem;
    }

    .blog-card .row {
        flex-direction: column;
    }

    .blog-card .col-md-5 {
        height: 200px;
    }

    .sidebar-sticky {
        position: static;
        margin-top: 2rem;
    }
}

@media (max-width: 576px) {
    .stat-number {
        font-size: 1.25rem;
    }

    .blog-title {
        font-size: 1.25rem;
    }

    .store-img {
        width: 40px;
        height: 40px;
    }
}
</style>
@endpush
