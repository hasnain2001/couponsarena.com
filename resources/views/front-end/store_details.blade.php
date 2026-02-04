@extends('layouts.main')
@section('title')
@if ($store->title)
{{ $store->title }}
@else
{{ $store->name }} - Coupons & Promo Codes
@endif
@endsection
@section('description')
@if ($store->meta_description)
{{ $store->meta_description }}
@else
Save big at {{ $store->name }} with verified coupons, promo codes & exclusive discounts from {{config('app.name')}}.
@endif
@endsection
@section('keywords')
{!! $store->meta_keyword !!}
@endsection
@section('main-content')
<!-- Store Information and Coupons Section -->
<div class="container-fluid">
    <!-- Breadcrumb Navigation - Attractive Style -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm" style="--bc-color: #2e2bb1;">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none fw-bold" style="color: var(--bc-color);">
                    <i class="fas fa-home me-1"></i>Home
                </a>
            </li>
            <li class="breadcrumb-item">
                @if ($store->categories)
                    <a href="{{ route('category.details', ['slug' => Str::slug($store->categories->slug)]) }}" class="text-decoration-none fw-bold" style="color: var(--bc-color);">
                        <i class="fas fa-tags me-1"></i>{{ $store->categories->title }}
                    </a>
                @else
                    <span class="text-muted"><i class="fas fa-ban me-1"></i>Uncategorized</span>
                @endif
            </li>
            <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: var(--bc-color);">
                <i class="fas fa-store me-1"></i>{{ $store->name }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content - Coupons Section -->
        <div class="col-lg-8">
            <!-- Store Header Card - Mobile Optimized -->
            <div class="card store-header-card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        @if ($store->store_image)
                        <picture>
                            <img src="{{ asset('uploads/stores/' . $store->store_image) }}"
                            class="store-logo me-3" alt="{{ $store->name }}"
                             loading="lazy"
                            decoding="async"
                            />
                        </picture>

                        @else
                            <div class="no-image-placeholder bg-light text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image-fill" viewBox="0 0 16 16">
                                    <path d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l- 3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                                </svg>
                                <span>{{ $store->name }}</span>
                            </div>

                        @endif
                        <div class="flex-grow-1">
                            <h1 class="store-title mb-1">{{ $store->name }}</h1>
                            <p class="store-description mb-0 text-muted small">{!! Str::limit(strip_tags($store->description), 100) !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coupons Grid -->
            <div class="row" id="coupons-container">
                @foreach ($coupons as $coupon)
                    <div class="col-6 col-md-4 mb-3 coupon-item">
                        <div class="coupon-card card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <!-- Store Logo -->
                                <div class="text-center mb-2">
                                    @if ($store->store_image)
                                        <img src="{{ asset('uploads/stores/' . $store->store_image) }}" class="coupon-store-img" alt="{{ $store->name }}" loading="lazy" decoding="async" / >
                                    @endif
                                </div>

                                <!-- Coupon Details -->
                                <h6 class="coupon-title text-center">{{ $coupon->name }}</h6>
                                <p class="coupon-description text-muted small text-center mb-2">{{ Str::limit($coupon->description, 60) }}</p>

                                <!-- Coupon Action -->
                                <div class="coupon-action mt-auto">
                                    @if ($coupon->code)
                                        <button class="btn btn-primary btn-sm w-100 reveal-btn"
                                                onclick="handleRevealCode('{{ $coupon->id }}', '{{ $coupon->stores->affiliate_url ?? $coupon->destination_url }}')"
                                                id="getCode{{ $coupon->id }}">
                                            <i class="fas fa-eye me-1"></i>Reveal Code
                                        </button>

                                        <!-- Hidden Code Section -->
                                        <div class="code-section mt-2 d-none" id="codeContainer{{ $coupon->id }}">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control coupon-code text-center"
                                                       value="{{ $coupon->code }}" readonly
                                                       id="codeIndex{{ $coupon->id }}">
                                                <button class="btn btn-outline-primary copy-btn"
                                                        onclick="copyCouponCode('{{ $coupon->id }}')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                            <div class="copy-success text-success small mt-1 d-none text-center" id="copyConfirmation{{ $coupon->id }}">
                                                <i class="fas fa-check-circle me-1"></i>Copied!
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ $coupon->stores->affiliate_url ?? $coupon->destination_url }}"
                                           onclick="updateClickCount('{{ $coupon->id }}')"
                                           class="btn btn-success btn-sm w-100 "
                                           rel="nofollow"
                                           target="_blank">
                                            <i class="fas fa-shopping-bag me-1"></i>Get Deal
                                        </a>
                                    @endif
                                </div>

                                <!-- Coupon Footer -->
                                <div class="coupon-footer mt-2 pt-2 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-users me-1"></i>{{ $coupon->clicks }}
                                        </small>
                                        <small class="expiry-date {{ \Carbon\Carbon::parse($coupon->ending_date)->isPast() ? 'text-danger' : 'text-muted' }}">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($coupon->ending_date)->format('M d') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Store Content Section -->
            @if ($store->content)
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title">About {{ $store->name }}</h5>
                        <div class="store-content">{!! $store->content !!}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
        <!-- About Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3">
                <h6 class="card-title text-dark fw-bold mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Store Information
                </h6>
                <span class="badge bg-primary rounded-pill">About</span>
            </div>
            <div class="card-body">
                <div class="store-info">
                    <h6 class="text-primary mb-3">{{ $store->name }}</h6>
                    <p class="text-muted lh-lg mb-0">{{ $store->about }}</p>
                </div>
            </div>
        </div>


               <!-- Filter Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">Filter Offers</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ url()->current() }}" class="btn btn-outline-dark btn-sm {{ !request()->has('sort') ? 'active' : '' }}">
                            All Offers
                        </a>
                        <a href="{{ url()->current() }}?sort=codes" class="btn btn-outline-dark btn-sm {{ request('sort') == 'codes' ? 'active' : '' }}">
                            Coupon Codes
                        </a>
                        <a href="{{ url()->current() }}?sort=deals" class="btn btn-outline-dark btn-sm {{ request('sort') == 'deals' ? 'active' : '' }}">
                            Online Deals
                        </a>
                    </div>
                </div>
            </div>

            <!-- Share Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h6 class="card-title mb-3 text-dark">Share These Deals</h6>
                    <div class="social-share d-flex justify-content-center gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           class="btn btn-primary btn-sm rounded-circle" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/share?url={{ urlencode(url()->current()) }}"
                           class="btn btn-info btn-sm rounded-circle text-white" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=Check out {{ $store->name }} deals: {{ urlencode(url()->current()) }}"
                           class="btn btn-success btn-sm rounded-circle" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Stores -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3 text-dark">Related Stores</h6>
                    <div class="row g-2">
                        @foreach ($relatedStores as $relatedStore)

                            <div class="col-6">
                                <a href="{{route('store_details', ['slug' => Str::slug($relatedStore->slug)]) }}" class="related-store-link text-decoration-none">
                                    <div class="related-store-card text-center p-2 border rounded">
                                        <small class="store-name">{{ $relatedStore->name }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hidden Form for Click Tracking -->
<form method="post" action="{{ route('update.clicks') }}" id="clickForm" class="d-none">
    @csrf
    <input type="hidden" name="coupon_id" id="coupon_id">
</form>
@endsection
@push('styles')
<style>
    .store-about-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .store-about-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border-left-color: #4e73df;
    }
</style>
<link rel="stylesheet" href="{{ asset('cssfile/storedetail.css') }}">
@endpush
@push('scripts')
<script>
    // Handle reveal code functionality
    function handleRevealCode(couponId, destinationUrl, affiliateUrl) {
        const getCodeBtn = document.getElementById(`getCode${couponId}`);
        const codeContainer = document.getElementById(`codeContainer${couponId}`);

        // Hide reveal button and show code
        getCodeBtn.classList.add('d-none');
        codeContainer.classList.remove('d-none');

        // Open store URL in new tab
        if (destinationUrl) {
            window.open(destinationUrl, '_blank');
        }
        if (affiliateUrl) {
            window.open(affiliateUrl, '_blank');
        }

        // Update click count
        updateClickCount(couponId);
    }

    // Copy coupon code to clipboard
    function copyCouponCode(couponId) {
        const codeElement = document.getElementById(`codeIndex${couponId}`);
        const code = codeElement.value;
        const confirmation = document.getElementById(`copyConfirmation${couponId}`);

        navigator.clipboard.writeText(code)
            .then(() => {
                confirmation.classList.remove('d-none');
                setTimeout(() => {
                    confirmation.classList.add('d-none');
                }, 2000);
            })
            .catch(err => {
                console.error('Failed to copy:', err);
                // Fallback for older browsers
                codeElement.select();
                document.execCommand('copy');
                confirmation.classList.remove('d-none');
                setTimeout(() => {
                    confirmation.classList.add('d-none');
                }, 2000);
            });
    }

    // Update click count via AJAX
    function updateClickCount(couponId) {
        fetch('{{ route("update.clicks") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: `coupon_id=${couponId}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Click count updated');
        })
        .catch(error => {
            console.error('Error updating click count:', error);
        });
    }

    // Mobile-specific optimizations
    document.addEventListener('DOMContentLoaded', function() {
        // Add touch effects for mobile
        if ('ontouchstart' in window) {
            document.querySelectorAll('.coupon-card').forEach(card => {
                card.style.cursor = 'pointer';
            });
        }
    });
</script>
@endpush
