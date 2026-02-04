@extends('layouts.main')

@section('title')
    Latest Coupon Codes & Discounts - Save Big Today!
@endsection

@section('description')
    Find the latest coupon codes and exclusive deals for your favorite stores. Save money on online shopping with verified discount codes updated daily.
@endsection

@section('keywords')
    coupon codes, discount codes, promo codes, deals, offers, vouchers, discounts, savings, online shopping, exclusive coupons
@endsection

@section('main-content')

<main class="container-fluid px-0">
    <!-- Hero Section -->
    <section class="coupons-hero py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title display-4 fw-bold mb-3">Latest Coupon Codes</h1>
                    <p class="hero-subtitle lead mb-4">
                        Discover exclusive discount codes and save big on your favorite brands. All codes verified and updated daily.
                    </p>
                    <div class="hero-stats d-flex justify-content-center gap-4 flex-wrap">
                        <div class="stat-item text-white">
                            <div class="stat-number fw-bold">{{ $coupons->total() }}+</div>
                            <div class="stat-label">Active Codes</div>
                        </div>
                        <div class="stat-item text-white">
                            <div class="stat-number fw-bold">100%</div>
                            <div class="stat-label">Verified</div>
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
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-tag me-2"></i>Coupon Codes
                </li>
            </ol>
        </nav>

        <!-- Header with Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1">All Coupon Codes</h2>
                <p class="text-muted mb-0">Showing {{ $coupons->count() }} of {{ $coupons->total() }} active codes</p>
            </div>
            <div class="coupon-filter">
                <select class="form-select form-select-sm" style="max-width: 200px;">
                    <option>Sort by: Newest</option>
                    <option>Sort by: Most Popular</option>
                    <option>Sort by: Ending Soon</option>
                </select>
            </div>
        </div>

        <!-- Coupons Grid -->
        <div class="coupons-grid">
            @forelse ($coupons as $coupon)

            
            <div class="coupon-card card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <!-- Store Logo & Info -->
                        <div class="col-lg-2 col-md-3 text-center mb-3 mb-md-0">
                            <div class="store-section">
                                @if ($coupon->stores )
                                <a href="{{ route('store_details', ['slug' => Str::slug($coupon->stores->slug)]) }}" class="store-link">
                                    <img src="{{ asset('uploads/stores/' . $coupon->stores->store_image) }}" 
                                         alt="{{ $coupon->stores->name }} Logo" 
                                         class="store-logo">
                                </a>
                                @else
                                <div class="store-placeholder">
                                    <i class="fas fa-store fa-2x"></i>
                                </div>
                                @endif
                                <div class="store-info mt-2">
                                    <small class="text-muted">{{ $coupon->store }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Coupon Details -->
                        <div class="col-lg-6 col-md-5">
                            <div class="coupon-details">
                                <h4 class="coupon-title mb-2">{{ $coupon->name }}</h4>
                                <p class="coupon-description text-muted mb-3">{{ $coupon->description }}</p>
                                
                                <div class="coupon-meta d-flex flex-wrap gap-3">
                                    <div class="meta-item">
                                        <i class="fas fa-users me-1 text-primary"></i>
                                        <small>Used {{ $coupon->clicks }} times</small>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-clock me-1 {{ \Carbon\Carbon::parse($coupon->ending_date)->isPast() ? 'text-danger' : 'text-warning' }}"></i>
                                        <small class="{{ \Carbon\Carbon::parse($coupon->ending_date)->isPast() ? 'text-danger' : 'text-muted' }}">
                                            Ends: {{ \Carbon\Carbon::parse($coupon->ending_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-check-circle me-1 text-success"></i>
                                        <small>Verified</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-4 col-md-4 text-center">
                            <div class="coupon-actions">
                                @if ($coupon->code)
                                <button class="btn btn-primary btn-lg w-100 reveal-btn mb-2" 
                                        onclick="handleRevealCode('{{ $coupon->id }}', '{{ $coupon->code }}', '{{ $coupon->destination_url }}', '{{ $coupon->name }}', '{{ $coupon->stores->slug }}')"
                                        id="getCode{{ $coupon->id }}">
                                    <i class="fas fa-eye me-2"></i>Reveal Code
                                </button>
                                @else
                                <a href="{{ $coupon->destination_url }}" 
                                   target="_blank" 
                                   class="btn btn-success btn-lg w-100 get-deal-btn mb-2"
                                   onclick="updateClickCount('{{ $coupon->id }}')"
                                   rel="nofollow">
                                    <i class="fas fa-bolt me-2"></i>Get Deal
                                </a>
                                @endif

                                <a href="{{ route('store_details', ['slug' => Str::slug($coupon->stores->slug)]) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-store me-1"></i>All Offers
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state text-center py-5">
                <div class="empty-icon mb-4">
                    <i class="fas fa-tag fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">No Coupon Codes Available</h3>
                <p class="text-muted mb-4">We're updating our coupon codes. Please check back soon for amazing deals!</p>
                <a href="/stores" class="btn btn-primary">
                    <i class="fas fa-store me-2"></i>Browse Stores
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($coupons->hasPages())
        <div class="mt-5">
            <nav aria-label="Coupons pagination">
                {{ $coupons->links('vendor.pagination.custom') }}
            </nav>
        </div>
        @endif
    </div>
</main>

<!-- Coupon Code Modal -->
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white border-0">
                <div class="modal-store-info d-flex align-items-center">
                    <img id="modalStoreLogo" src="" alt="Store Logo" class="modal-store-logo me-3">
                    <div>
                        <h5 class="modal-title mb-0" id="modalStoreName"></h5>
                        <small id="modalCouponTitle" class="opacity-75"></small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body text-center py-4">
                <!-- Success Icon -->
                <div class="success-icon mb-3">
                    <i class="fas fa-gift fa-3x text-primary"></i>
                </div>
                
                <h4 class="text-success mb-3">Coupon Code Revealed!</h4>
                
                <!-- Coupon Code Display -->
                <div class="coupon-code-display mb-4">
                    <div class="code-container bg-light rounded-3 p-3 border">
                        <small class="text-muted d-block mb-1">Your Coupon Code</small>
                        <h2 id="couponCode" class="text-dark mb-0 font-monospace"></h2>
                    </div>
                </div>
                
                <!-- Copy Button -->
                <button class="btn btn-primary btn-lg w-100 copy-btn mb-3" onclick="copyToClipboard()">
                    <i class="fas fa-copy me-2"></i>Copy Code
                </button>
                
                <!-- Copy Confirmation -->
                <div id="copyMessage" class="alert alert-success d-none" role="alert">
                    <i class="fas fa-check-circle me-2"></i>Code copied to clipboard!
                </div>
                
                <!-- Instructions -->
                <div class="instructions mt-3">
                    <p class="text-muted small mb-2">
                        Use this code at checkout on <strong id="modalStoreWebsite"></strong>
                    </p>
                    <a href="#" id="storeRedirect" class="btn btn-outline-primary btn-sm" target="_blank" rel="nofollow">
                        <i class="fas fa-external-link-alt me-1"></i>Go to Store
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle the "Reveal Code" button click
    function handleRevealCode(couponId, couponCode, destinationUrl, couponTitle, storeName) {
        // Set modal content
        document.getElementById('couponCode').textContent = couponCode;
        document.getElementById('modalCouponTitle').textContent = couponTitle;
        document.getElementById('modalStoreName').textContent = storeName;
        document.getElementById('modalStoreWebsite').textContent = storeName;
        document.getElementById('storeRedirect').href = destinationUrl;
        
        // Try to get store logo
        const storeLogo = document.querySelector(`[alt="${storeName} Logo"]`);
        if (storeLogo) {
            document.getElementById('modalStoreLogo').src = storeLogo.src;
        }
        
        // Update click count
        updateClickCount(couponId);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('couponModal'));
        modal.show();
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

    // Copy the coupon code to the clipboard
    function copyToClipboard() {
        const code = document.getElementById('couponCode').textContent;
        navigator.clipboard.writeText(code).then(() => {
            const copyMessage = document.getElementById('copyMessage');
            copyMessage.classList.remove('d-none');
            setTimeout(() => {
                copyMessage.classList.add('d-none');
            }, 3000);
        });
    }
</script>
@endsection

@push('styles')
<style>
:root {
    --primary-color: #2e2bb1;
    --secondary-color: #791291;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --text-dark: #2d3748;
    --text-light: #718096;
    --bg-light: #f7fafc;
    --border-radius: 12px;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Hero Section */
.coupons-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    position: relative;
    overflow: hidden;
}

.coupons-hero::before {
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

/* Coupon Cards */
.coupon-card {
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    background: white;
}

.coupon-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.store-section {
    text-align: center;
}

.store-logo {
    width: 80px;
    height: 80px;
    object-fit: contain;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 8px;
    transition: all 0.3s ease;
}

.store-link:hover .store-logo {
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.store-placeholder {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e2e8f0;
    border-radius: 10px;
    color: var(--text-light);
    margin: 0 auto;
}

/* Coupon Details */
.coupon-title {
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1.3;
    font-size: 1.1rem;
}

.coupon-description {
    line-height: 1.5;
    font-size: 0.9rem;
}

.coupon-meta {
    font-size: 0.85rem;
}

.meta-item {
    display: flex;
    align-items: center;
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

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #34ce57);
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838, var(--success-color));
    transform: translateY(-2px);
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-1px);
}

/* Modal Styles */
.modal-store-logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: 8px;
}

.success-icon {
    color: var(--primary-color);
}

.code-container {
    border: 2px dashed var(--primary-color) !important;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    letter-spacing: 1px;
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

/* Filter */
.coupon-filter .form-select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.coupon-filter .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(46, 43, 177, 0.25);
}

/* Responsive Design */
@media (max-width: 768px) {
    .coupons-hero {
        padding: 3rem 1rem !important;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .stat-number {
        font-size: 1.25rem;
    }
    
    .coupon-card .row {
        text-align: center;
    }
    
    .store-logo {
        width: 60px;
        height: 60px;
    }
    
    .coupon-title {
        font-size: 1rem;
    }
    
    .coupon-meta {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .coupon-filter .form-select {
        max-width: 100% !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
}

/* Animations */
.coupon-card {
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
.coupon-card:nth-child(1) { animation-delay: 0.1s; }
.coupon-card:nth-child(2) { animation-delay: 0.2s; }
.coupon-card:nth-child(3) { animation-delay: 0.3s; }
.coupon-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endpush