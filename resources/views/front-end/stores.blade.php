@extends('layouts.main')
@section('title', 'Top Stores - Best Deals, Discounts, and Coupons')
@section('description', 'Find the best deals, discounts, and coupons on CouponsArena. Save money on your favorite products from top brands.')
@section('keywords', 'stores, deals, discounts, coupons, offers, promo codes, vouchers, savings, shopping, brands, products, online, in-store, best deals, discounts, coupons, offers, promo codes, vouchers, savings, shopping, brands, products, online, in-store, deals, discounts, coupons, savings, affiliate marketing, shopping, brands, products, online, in-store')

@section('main-content')
<div class="container-fluid ">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="stores-hero text-center py-5 rounded-4 mb-4">
                <h1 class="display-5 fw-bold text-white mb-3">Discover Amazing Stores</h1>
                <p class="lead text-white mb-4">Find the best deals, discounts, and coupons from top brands</p>

                <div class="hero-stats d-flex justify-content-center gap-4 flex-wrap">

                    <!-- Total Stores -->
                    <div class="stat-item text-white">
                        <div class="stat-number fw-bold">{{ $stores->total() }}+</div>
                        <div class="stat-label">Stores</div>
                    </div>

                    <!-- Total Coupons -->
                    <div class="stat-item text-white">
                        <div class="stat-number fw-bold">{{ $coupons }}+</div>
                        <div class="stat-label">Active Deals</div>
                    </div>

                    <!-- Recently Updated Stores -->
                    <div class="stat-item text-white">
                        <div class="stat-number fw-bold">{{ $updatedStores }}</div>
                        <div class="stat-label">Updated</div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Stores Section -->
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url(app()->getLocale() . '/') }}" class="text-decoration-none">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-store me-2"></i>Stores
                </li>
            </ol>
        </nav>

        <!-- Header with Count -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">All Stores</h2>
                <p class="text-muted mb-0">Total stores: <span class="fw-bold text-primary">{{ $stores->total() }}</span></p>
            </div>
            <div class="store-sort">
                <select class="form-select form-select-sm" style="max-width: 200px;">
                    <option>Sort by: Popularity</option>
                    <option>Sort by: Name A-Z</option>
                    <option>Sort by: Newest First</option>
                </select>
            </div>
        </div>

        <!-- Stores Grid -->
        <div class="row g-4">
            @forelse ($stores as $store)
               <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <a href="{{  route('store_details', ['slug' => Str::slug($store->slug)])  }}" class="store-card-link text-decoration-none">
                        <div class="store-card card border-0 shadow-sm h-100">
                            <div class="store-image-wrapper">
                                @if ($store->store_image)
                                    <img class="store-img"
                                         src="{{ asset('uploads/stores/' . $store->store_image) }}"
                                         loading="lazy"
                                         decoding="async"
                                         alt="{{ $store->name }}"
                                         onerror="this.src='{{ asset('front/assets/images/no-image-found.jpg') }}'">
                                @else
                                    <div class="store-placeholder">
                                        <i class="fas fa-store fa-2x"></i>
                                    </div>
                                @endif
                                <div class="store-overlay">
                                    <span class="btn btn-primary btn-sm rounded-pill">
                                        View Deals <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="store-title mb-2">{{ $store->name ?: "Store Name" }}</h6>
                                <div class="store-meta">
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>
                                         offers: {{  $store->coupons()->count() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-store fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">No Stores Found</h4>
                        <p class="text-muted mb-4">We're constantly adding new stores. Check back soon!</p>
                        <a href="/" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($stores->hasPages())
            <div class="mt-5">
                <nav aria-label="Stores pagination">
                    {{ $stores->links('vendor.pagination.custom') }}
                </nav>
            </div>
        @endif
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
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Hero Section */
.stores-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    position: relative;
    overflow: hidden;
}

.stores-hero::before {
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

/* Store Cards */
.store-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
}

.store-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(46, 43, 177, 0.15) !important;
}

.store-image-wrapper {
    position: relative;
    overflow: hidden;
    background: var(--bg-light);
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.store-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 20px;
    transition: all 0.3s ease;
}

.store-card:hover .store-img {
    transform: scale(1.05);
}

.store-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #e2e8f0;
    color: var(--text-light);
}

.store-overlay {
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

.store-card:hover .store-overlay {
    opacity: 1;
}

.store-title {
    font-weight: 600;
    color: var(--text-dark);
    line-height: 1.3;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.store-meta {
    font-size: 0.8rem;
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

/* Empty State */
.empty-state {
    background: var(--bg-light);
    border-radius: 12px;
    border: 2px dashed #e2e8f0;
}

.empty-icon {
    color: #cbd5e0;
}

/* Store Sort */
.store-sort .form-select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    font-size: 0.875rem;
}

.store-sort .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(46, 43, 177, 0.25);
}

/* Pagination */
.my-pagination {
    flex-wrap: wrap;
    justify-content: center;
}

.my-pagination .page-item {
    margin: 2px;
}

.my-pagination .page-link {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 16px;
    color: var(--primary-color);
    font-weight: 500;
    transition: all 0.3s ease;
}

.my-pagination .page-link:hover {
    background-color: var(--primary-color);
    color: #ffffff;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.my-pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: #ffffff;
}

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

    .stores-hero {
        padding: 3rem 1rem !important;
    }

    .display-5 {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .store-image-wrapper {
        height: 120px;
    }

    .store-title {
        font-size: 0.9rem;
    }

    .hero-stats {
        gap: 2rem;
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

    .store-image-wrapper {
        height: 100px;
    }

    .store-img {
        padding: 15px;
    }

    .card-body {
        padding: 1rem 0.5rem !important;
    }

    .store-title {
        font-size: 0.85rem;
    }

    .store-meta {
        font-size: 0.75rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    .store-sort .form-select {
        max-width: 100% !important;
    }
}

@media (max-width: 400px) {
    .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

/* Loading animation for cards */
.store-card {
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

/* Ensure good contrast and accessibility */
.store-card-link:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
    border-radius: 12px;
}

.store-card-link:focus .store-card {
    box-shadow: 0 0 0 3px rgba(46, 43, 177, 0.3);
}
</style>
@endpush
