@extends('layouts.main')
@section('title','Categories - Best Deals and Discounts')
@section('description','Browse all categories to find the best deals, discounts, and coupons on CouponsArena. Save money on your favorite products from top brands.')
@section('keywords','categories, deals, discounts, coupons, savings, affiliate marketing, shopping categories')

@section('main-content')
<div class="categories-page">
    <!-- Hero Section -->
    <div class="categories-hero py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title display-4 fw-bold mb-3">Browse Categories</h1>
                    <p class="hero-subtitle lead mb-4">
                        Discover amazing deals across all categories. Find the perfect discounts for your favorite products and brands.
                    </p>
                    <div class="hero-stats d-flex justify-content-center gap-4">
                        <div class="stat-item">
                            <div class="stat-number fw-bold">{{ $categories->count() }}+</div>
                            <div class="stat-label">Categories</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number fw-bold">1000+</div>
                            <div class="stat-label">Stores</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number fw-bold">24/7</div>
                            <div class="stat-label">Updated</div>
                        </div>
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
                    <i class="fas fa-tags me-2"></i>Categories
                </li>
            </ol>
        </nav>

        <!-- Categories Grid -->
        <div class="categories-grid">
            <div class="row g-4">
                @foreach ($categories as $category)                
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="category-card card border-0 shadow-sm h-100">
                        <a href="{{ route('category.details', ['slug' => Str::slug($category->slug)]) }}" class="category-link text-decoration-none">
                            <div class="category-image-wrapper">
                                @if ($category->category_image)
                                    <img src="{{ asset('uploads/categories/' . $category->category_image) }}" 
                                         class="category-image" 
                                         alt="{{ $category->title }}"
                                         loading="lazy">
                                @else
                                    <div class="category-placeholder">
                                        <i class="fas fa-tag fa-3x"></i>
                                    </div>
                                @endif
                                <div class="category-overlay">
                                    <span class="explore-btn">
                                        Explore <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body text-center p-3">
                                <h5 class="category-title mb-2">{{ $category->title }}</h5>
                                <div class="category-meta">
                                    <small class="text-muted">
                                        <i class="fas fa-store me-1"></i>
                                        {{ $category->stores_count ?? 0 }} stores
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Empty State -->
        @if($categories->isEmpty())
        <div class="empty-state text-center py-8">
            <div class="empty-icon mb-4">
                <i class="fas fa-tags fa-4x text-muted"></i>
            </div>
            <h3 class="text-muted mb-3">No Categories Available</h3>
            <p class="text-muted mb-4">We're working on adding new categories. Please check back soon!</p>
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
        </div>
        @endif
    </div>

    <!-- CTA Section -->
    <section class="cta-section py-5 mt-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="cta-title mb-3">Can't Find What You're Looking For?</h2>
                    <p class="cta-text mb-4">
                        We're constantly adding new categories and stores. Contact us if you have specific requests!
                    </p>
                    <div class="cta-buttons">
                        <a href="/contact" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-envelope me-2"></i>Contact Us
                        </a>
                        <a href="/stores" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-store me-2"></i>Browse All Stores
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    --border-radius: 12px;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Hero Section */
.categories-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    position: relative;
    overflow: hidden;
}

.categories-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.hero-title {
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
    opacity: 0.9;
    font-weight: 300;
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

/* Breadcrumb */
.breadcrumb {
    background: var(--bg-light);
    border-radius: 10px;
    padding: 12px 20px;
    border: 1px solid #e2e8f0;
}

.breadcrumb-item a {
    color: var(--primary-color);
    font-weight: 500;
}

.breadcrumb-item.active {
    color: var(--text-light);
    font-weight: 600;
}

/* Category Cards */
.category-card {
    transition: all 0.3s ease;
    border-radius: var(--border-radius);
    overflow: hidden;
    background: white;
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.category-link {
    color: inherit;
}

.category-link:hover {
    text-decoration: none;
    color: inherit;
}

.category-image-wrapper {
    position: relative;
    overflow: hidden;
    background: var(--bg-light);
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.category-card:hover .category-image {
    transform: scale(1.1);
}

.category-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #e2e8f0;
    color: var(--text-light);
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(46, 43, 177, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.category-card:hover .category-overlay {
    opacity: 1;
}

.explore-btn {
    color: white;
    font-weight: 600;
    font-size: 1rem;
}

.category-title {
    font-weight: 600;
    color: var(--text-dark);
    line-height: 1.3;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.category-meta {
    font-size: 0.85rem;
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
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    background: var(--bg-light);
    border-radius: var(--border-radius);
    border: 2px dashed #e2e8f0;
}

.empty-icon {
    color: #cbd5e0;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-top: 1px solid #e2e8f0;
}

.cta-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
}

.cta-text {
    font-size: 1.1rem;
    color: var(--text-light);
    max-width: 600px;
    margin: 0 auto;
}

/* Animations */
.category-card {
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stagger animation for cards */
.category-card:nth-child(1) { animation-delay: 0.1s; }
.category-card:nth-child(2) { animation-delay: 0.2s; }
.category-card:nth-child(3) { animation-delay: 0.3s; }
.category-card:nth-child(4) { animation-delay: 0.4s; }
.category-card:nth-child(5) { animation-delay: 0.5s; }
.category-card:nth-child(6) { animation-delay: 0.6s; }

/* Responsive Design */
@media (max-width: 1200px) {
    .col-xl-2 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (max-width: 992px) {
    .col-lg-3 {
        flex: 0 0 33.333%;
        max-width: 33.333%;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .categories-hero {
        padding: 3rem 1rem !important;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .category-image-wrapper {
        height: 140px;
    }
    
    .stat-number {
        font-size: 1.25rem;
    }
}

@media (max-width: 576px) {
    .col-sm-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .category-image-wrapper {
        height: 120px;
    }
    
    .category-title {
        font-size: 0.9rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        gap: 1rem;
    }
    
    .cta-buttons .btn {
        width: 100%;
        margin: 0 !important;
    }
}

@media (max-width: 400px) {
    .col-sm-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

/* Ensure good contrast and accessibility */
.category-link:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
    border-radius: var(--border-radius);
}

.category-link:focus .category-card {
    box-shadow: 0 0 0 3px rgba(46, 43, 177, 0.3);
}
</style>
@endpush