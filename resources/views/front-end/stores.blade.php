{{-- resources/views/stores/index.blade.php --}}
@extends('layouts.main')

@section('title', 'Top Stores - Best Deals, Discounts, and Coupons')
@section('description', 'Find the best deals, discounts, and coupons on CouponsArena. Save money on your favorite products from top brands.')
@section('keywords', 'stores, deals, discounts, coupons, offers, promo codes, vouchers, savings, shopping, brands, products, online, in-store, best deals, discounts, coupons, offers, promo codes, vouchers, savings, shopping, brands, products, online, in-store, deals, discounts, coupons, savings, affiliate marketing, shopping, brands, products, online, in-store')

@push('styles')
    <style>
        :root {
            --primary-color: #2e2bb1;
            --primary-dark: #23209e;
            --secondary-color: #791291;
            --accent-color: #ff6b6b;
            --text-dark: #2d3748;
            --text-light: #718096;
            --bg-light: #f8f9fa;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --border-radius: 16px;
            --transition: all 0.2s ease;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 2rem 2rem;
            color: white;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            background: white;
            padding: 1rem 2rem;
            border-radius: 60px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .stat-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Search Section */
        .store-search-section {
            margin-bottom: 2rem;
        }

        .store-search-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
        }

        .store-search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .store-search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.1rem;
        }

        .store-search-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 60px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .store-search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 43, 177, 0.1);
        }

        /* Alphabet Navigation */
        .alphabet-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            justify-content: center;
        }

        .alphabet-letter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--bg-light);
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .alphabet-letter:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .alphabet-letter.active {
            background: var(--primary-color);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .alphabet-all {
            width: auto;
            padding: 0 1rem;
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-light);
            padding: 0.5rem 1rem;
            border-radius: 40px;
            font-size: 0.875rem;
            color: var(--text-dark);
        }

        .filter-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-light);
            transition: var(--transition);
        }

        .filter-remove:hover {
            color: var(--accent-color);
        }

        /* Letter Section */
        .letter-section {
            margin-bottom: 2.5rem;
        }

        .letter-header {
            margin-bottom: 1.25rem;
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
        }

        .letter-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .letter-title i {
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .letter-count {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-light);
            background: var(--bg-light);
            padding: 0.125rem 0.5rem;
            border-radius: 20px;
        }

        /* Store Grid */
        .stores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1.25rem;
        }

        @media (min-width: 768px) {
            .stores-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }

        @media (min-width: 992px) {
            .stores-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        /* Store Card */
        .store-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            text-align: center;
            position: relative;
            animation: fadeInUp 0.4s ease-out backwards;
        }

        .store-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .store-image-container {
            position: relative;
            padding-top: 75%;
            background: var(--bg-light);
        }

        .store-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .store-card:hover .store-image {
            transform: scale(1.05);
        }

        .store-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .store-content {
            padding: 1rem;
        }

        .store-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .store-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .store-meta i {
            color: var(--primary-color);
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--bg-light);
            border-radius: var(--border-radius);
        }

        .no-results-icon {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-custom a {
            color: var(--primary-color);
        }

        /* Animations */
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

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .floating-text {
            animation: pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 2rem 0;
            }
            
            .page-title {
                font-size: 1.75rem;
            }
            
            .stats-bar {
                gap: 1rem;
                padding: 0.75rem 1rem;
            }
            
            .stat-item {
                font-size: 0.875rem;
            }
            
            .alphabet-letter {
                width: 35px;
                height: 35px;
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

@section('main-content')
    <main>
        <!-- Page Header -->
        <header class="page-header">
            <div class="container">
                <h1 class="page-title floating-text">@lang('message.stores')</h1>
                <p class="page-subtitle">
                    Discover amazing stores with exclusive offers and discounts. Find the best deals from trusted brands.
                </p>
            </div>
        </header>

        <div class="container py-4">
            <!-- Breadcrumb Navigation -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ url(app()->getLocale() . '/') }}" class="text-decoration-none">
                            <i class="fas fa-home me-1"></i>@lang('message.home')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-store me-2 text-primary"></i>
                        @lang('message.stores')
                    </li>
                </ol>
            </nav>

            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stat-item">
                    <i class="fas fa-store"></i>
                    <span>{{ $stores->total() ?? $totalStoresCount ?? 0 }} Stores</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-tags"></i>
                    <span>Latest {{ date('Y') }} Deals</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-star"></i>
                    <span>Verified Offers</span>
                </div>
            </div>

            <!-- Search Section -->
            <section class="store-search-section">
                <div class="store-search-container">
                    <!-- Search Box -->
                    <div class="store-search-box">
                        <i class="fas fa-search store-search-icon"></i>
                        <input 
                            type="text" 
                            class="store-search-input" 
                            id="storeSearch"
                            placeholder="Search for stores, brands, or categories..."
                            autocomplete="off"
                        >
                    </div>

                    <!-- Alphabet Navigation -->
                    <div class="alphabet-nav" id="alphabetNav">
                        <a href="?letter=all" class="alphabet-letter alphabet-all {{ request('letter', 'all') == 'all' ? 'active' : '' }}" data-letter="all">
                            All
                        </a>
                        @foreach(range('A', 'Z') as $char)
                            <a href="?letter={{ $char }}" class="alphabet-letter {{ request('letter') == $char ? 'active' : '' }}" data-letter="{{ $char }}">
                                {{ $char }}
                            </a>
                        @endforeach
                        <a href="?letter=#" class="alphabet-letter {{ request('letter') == '#' ? 'active' : '' }}" data-letter="#">
                            #
                        </a>
                    </div>

                    <!-- Active Filters -->
                    <div class="active-filters" id="activeFilters"></div>

                    <!-- Search Results Info -->
                    <div class="search-results-info" id="searchResultsInfo">
                        <div class="stats-bar" style="margin-bottom: 0; background: var(--bg-light);">
                            <div class="stat-item">
                                <i class="fas fa-store"></i>
                                <span id="totalStores">{{ $stores->total() ?? $totalStoresCount ?? 0 }}</span> Stores Found
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-tags"></i>
                                <span>Active Offers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stores Content -->
            <div id="storesContent">
                @if(isset($storesByLetter) && !empty($storesByLetter))
                    <!-- Display stores grouped by letters -->
                    @foreach($storesByLetter as $letterKey => $storesGroup)
                        @if(count($storesGroup) > 0)
                            <section class="letter-section" data-letter="{{ $letterKey }}">
                                <div class="letter-header">
                                    <h2 class="letter-title">
                                        <i class="fas fa-bookmark"></i>
                                        {{ $letterKey }}
                                        <span class="letter-count">{{ count($storesGroup) }}</span>
                                    </h2>
                                </div>
                                <div class="stores-grid">
                                    @foreach($storesGroup as $store)
                                        <a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}" class="text-decoration-none">
                                            <div class="store-card">
                                                <div class="store-image-container">
                                                    <img
                                                        src="{{ $store->store_image ? asset('uploads/stores/' . $store->store_image) : asset('front/assets/images/no-image-found.jpg') }}"
                                                        onerror="this.src='{{ asset('assets/img/no-image-found.png') }}'"
                                                        class="store-image"
                                                        alt="{{ $store->name }}"
                                                        loading="lazy"
                                                    />
                                                    @if($store->top_store)
                                                        <div class="store-badge">
                                                            <i class="fas fa-crown me-1"></i>Top Store
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="store-content">
                                                    <h5 class="store-name">{{ $store->name ?: 'Store Name' }}</h5>
                                                    <div class="store-meta">
                                                        <i class="fas fa-tag"></i>
                                                        <span>{{ $store->coupons_count ?? '0' }} Offers</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                @else
                    <!-- Display stores in grid with pagination -->
                    <div class="stores-grid" id="storesGrid">
                        @forelse ($stores as $store)
                            <a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}" class="text-decoration-none">
                                <div class="store-card">
                                    <div class="store-image-container">
                                        <img
                                            src="{{ $store->store_image ? asset('uploads/stores/' . $store->store_image) : asset('front/assets/images/no-image-found.jpg') }}"
                                            onerror="this.src='{{ asset('assets/img/no-image-found.png') }}'"
                                            class="store-image"
                                            alt="{{ $store->name }}"
                                            loading="lazy"
                                        />
                                        @if($store->top_store)
                                            <div class="store-badge">
                                                <i class="fas fa-crown me-1"></i>Top Store
                                            </div>
                                        @endif
                                    </div>
                                    <div class="store-content">
                                        <h5 class="store-name">{{ $store->name ?: 'Store Name' }}</h5>
                                        <div class="store-meta">
                                            <i class="fas fa-tag"></i>
                                            <span>{{ $store->coupons_count ?? '0' }} Offers</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="no-results">
                                <div class="no-results-icon">
                                    <i class="fas fa-store-slash"></i>
                                </div>
                                <h4 class="text-dark mb-3">No Stores Found</h4>
                                <p class="text-muted mb-0">
                                    We couldn't find any stores matching your criteria. Try adjusting your search or filter to find what you're looking for.
                                </p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if(isset($stores) && $stores->hasPages() && (!isset($storesByLetter) || empty($storesByLetter)))
                <div class="d-flex justify-content-center mt-5">
                    {{ $stores->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('storeSearch');
            const alphabetNav = document.getElementById('alphabetNav');
            const storesContent = document.getElementById('storesContent');
            const activeFilters = document.getElementById('activeFilters');
            const totalStoresSpan = document.getElementById('totalStores');
            
            // Store data for client-side filtering
            let allStoresData = [];
            
            // Extract store data from the page
            function extractStoreData() {
                const storeCards = storesContent.querySelectorAll('.store-card');
                const stores = [];
                
                storeCards.forEach(card => {
                    const link = card.closest('a');
                    if (!link) return;
                    
                    const name = card.querySelector('.store-name')?.textContent.trim() || '';
                    const image = card.querySelector('.store-image')?.src || '';
                    const offersSpan = card.querySelector('.store-meta span');
                    const offers = offersSpan ? offersSpan.textContent : '0';
                    const isTopStore = card.querySelector('.store-badge') !== null;
                    const url = link.href;
                    
                    // Extract slug from URL
                    const slugMatch = url.match(/store\/([^\/]+)/);
                    const slug = slugMatch ? slugMatch[1] : '';
                    
                    stores.push({
                        name: name,
                        image: image,
                        coupons_count: parseInt(offers) || 0,
                        top_store: isTopStore,
                        detail_url: url,
                        slug: slug
                    });
                });
                
                return stores;
            }
            
            // Get active letter from URL or navigation
            function getActiveLetter() {
                const urlParams = new URLSearchParams(window.location.search);
                const letter = urlParams.get('letter');
                const activeNav = alphabetNav.querySelector('.alphabet-letter.active');
                if (activeNav && activeNav.dataset.letter) {
                    return activeNav.dataset.letter;
                }
                return letter || 'all';
            }
            
            // Create filter badge
            function createFilterBadge(type, value, filterType) {
                const badge = document.createElement('div');
                badge.className = 'filter-badge';
                badge.innerHTML = `
                    <span>${type}: ${value}</span>
                    <button class="filter-remove" data-filter="${filterType}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                return badge;
            }
            
            // Update active filters display
            function updateActiveFilters(searchTerm, activeLetter) {
                activeFilters.innerHTML = '';
                
                if (searchTerm) {
                    const searchBadge = createFilterBadge('Search', searchTerm, 'search');
                    activeFilters.appendChild(searchBadge);
                }
                
                if (activeLetter && activeLetter !== 'all') {
                    const letterBadge = createFilterBadge('Letter', activeLetter, 'letter');
                    activeFilters.appendChild(letterBadge);
                }
            }
            
            // Display filtered stores
            function displayFilteredStores(stores) {
                if (stores.length === 0) {
                    storesContent.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h4 class="text-dark mb-3">No Stores Found</h4>
                            <p class="text-muted mb-0">
                                Try adjusting your search or filter to find what you're looking for.
                            </p>
                        </div>
                    `;
                    return;
                }
                
                // Group stores by first letter
                const groupedStores = {};
                stores.forEach(store => {
                    const firstChar = store.name.charAt(0).toUpperCase();
                    const letter = /[A-Z]/.test(firstChar) ? firstChar : '#';
                    
                    if (!groupedStores[letter]) {
                        groupedStores[letter] = [];
                    }
                    groupedStores[letter].push(store);
                });
                
                // Sort letters
                const sortedLetters = Object.keys(groupedStores).sort((a, b) => {
                    if (a === '#') return 1;
                    if (b === '#') return -1;
                    return a.localeCompare(b);
                });
                
                // Generate HTML
                let html = '';
                sortedLetters.forEach(letter => {
                    html += `
                        <section class="letter-section" data-letter="${letter}">
                            <div class="letter-header">
                                <h2 class="letter-title">
                                    <i class="fas fa-bookmark"></i>
                                    ${letter}
                                    <span class="letter-count">${groupedStores[letter].length}</span>
                                </h2>
                            </div>
                            <div class="stores-grid">
                    `;
                    
                    groupedStores[letter].forEach(store => {
                        html += `
                            <a href="${store.detail_url}" class="text-decoration-none">
                                <div class="store-card">
                                    <div class="store-image-container">
                                        <img
                                            src="${store.image}"
                                            onerror="this.src='{{ asset('assets/img/no-image-found.png') }}'"
                                            class="store-image"
                                            alt="${escapeHtml(store.name)}"
                                            loading="lazy"
                                        />
                                        ${store.top_store ? `
                                            <div class="store-badge">
                                                <i class="fas fa-crown me-1"></i>Top Store
                                            </div>
                                        ` : ''}
                                    </div>
                                    <div class="store-content">
                                        <h5 class="store-name">${escapeHtml(store.name)}</h5>
                                        <div class="store-meta">
                                            <i class="fas fa-tag"></i>
                                            <span>${store.coupons_count} Offers</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        `;
                    });
                    
                    html += `
                            </div>
                        </section>
                    `;
                });
                
                storesContent.innerHTML = html;
                animateStoreCards();
            }
            
            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Filter stores based on search and letter
            function filterStores() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const activeLetter = getActiveLetter();
                
                let filteredStores = [...allStoresData];
                
                // Filter by search term
                if (searchTerm) {
                    filteredStores = filteredStores.filter(store => 
                        store.name.toLowerCase().includes(searchTerm)
                    );
                }
                
                // Filter by letter
                if (activeLetter && activeLetter !== 'all') {
                    if (activeLetter === '#') {
                        filteredStores = filteredStores.filter(store => {
                            const firstChar = store.name.charAt(0).toLowerCase();
                            return !/[a-z]/i.test(firstChar);
                        });
                    } else {
                        filteredStores = filteredStores.filter(store => 
                            store.name.toLowerCase().startsWith(activeLetter.toLowerCase())
                        );
                    }
                }
                
                updateActiveFilters(searchTerm, activeLetter);
                displayFilteredStores(filteredStores);
                if (totalStoresSpan) {
                    totalStoresSpan.textContent = filteredStores.length;
                }
            }
            
            // Animate store cards
            function animateStoreCards() {
                const cards = storesContent.querySelectorAll('.store-card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.03}s`;
                });
            }
            
            // Initialize data and event listeners
            function initialize() {
                allStoresData = extractStoreData();
                filterStores();
                animateStoreCards();
                
                // Search input with debounce
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(filterStores, 300);
                });
                
                // Remove filter
                activeFilters.addEventListener('click', function(e) {
                    const removeBtn = e.target.closest('.filter-remove');
                    if (removeBtn) {
                        const filterType = removeBtn.dataset.filter;
                        if (filterType === 'search') {
                            searchInput.value = '';
                            filterStores();
                        } else if (filterType === 'letter') {
                            const url = new URL(window.location);
                            url.searchParams.set('letter', 'all');
                            window.location.href = url.toString();
                        }
                    }
                });
            }
            
            initialize();
        });
    </script>
@endpush