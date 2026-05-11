<a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}" class="store-card-link text-decoration-none">
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
                    Offers: {{ $store->coupons_count }}
                </small>
            </div>
        </div>
    </div>
</a>