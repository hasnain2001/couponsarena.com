@extends('layouts.main')
@section('title', "Search Results for '{$query}'")
@section('description', "Find blogs and categories matching '{$query}'. Discover amazing content.")
@section('keywords', "search, {$query}, blogs, categories, content")

@section('main-content')

<div class="search-results-page">
    <!-- Hero Section -->
    <section class="search-hero py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="hero-title display-5 fw-bold mb-3">Search Results</h1>
                    <p class="hero-subtitle lead mb-4">
                        Showing results for "<span class="text-warning fw-bold">{{ $query }}</span>"
                    </p>
                    
                    <!-- Search Stats -->
                    <div class="search-stats mb-4">
                        <span class="badge bg-primary fs-6 mb-2">
                            <i class="fas fa-search me-2"></i>
                            {{ $totalCount }} results found
                        </span>
                        
                        <!-- Search Type Filters -->
                        <div class="search-type-filters mt-3">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Search type">
                                <a href="{{ route('search_results', ['query' => $query, 'type' => 'all']) }}" 
                                   class="btn {{ $type === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="fas fa-layer-group me-1"></i> All
                                </a>
                                <a href="{{ route('search_results', ['query' => $query, 'type' => 'blogs']) }}" 
                                   class="btn {{ $type === 'blogs' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="fas fa-blog me-1"></i> Blogs
                                </a>
                                <a href="{{ route('search_results', ['query' => $query, 'type' => 'categories']) }}" 
                                   class="btn {{ $type === 'categories' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="fas fa-tags me-1"></i> Categories
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Search Form -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <form action="{{ route('storesearch') }}" method="GET" class="search-form">
                                <div class="input-group input-group-lg shadow">
                                    <input type="text" 
                                           name="query" 
                                           class="form-control py-3 border-0" 
                                           placeholder="Search for blogs, categories..."
                                           value="{{ $query }}"
                                           aria-label="Search">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                </div>
                            </form>
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
                    <i class="fas fa-search me-2"></i>Search: "{{ $query }}"
                </li>
            </ol>
        </nav>

        <!-- Results Container -->
        <div class="search-results-container">
            @if ($totalCount === 0)
            <!-- No Results Found -->
            <div class="empty-search-state text-center py-8">
                <div class="empty-icon mb-4">
                    <i class="fas fa-search fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">No Results Found</h3>
                <p class="text-muted mb-4">We couldn't find anything matching "{{ $query }}"</p>
                <div class="empty-actions">
                    <a href="/" class="btn btn-primary me-3">
                        <i class="fas fa-home me-2"></i>Go to Homepage
                    </a>
                    <a href="{{ route('blog',['lang' => app()->getLocale()]) }}" class="btn btn-outline-primary">
                        <i class="fas fa-blog me-2"></i>Browse Blogs
                    </a>
                </div>
            </div>
            @else
            <!-- Blogs Results -->
            @if(isset($results['blogs']) && $results['blogs']->total() > 0)
            <section class="search-section mb-5">
                <div class="section-header mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="section-title mb-0">
                            <i class="fas fa-blog me-2 text-success"></i>
                            Blog Articles ({{ $results['blogs']->total() }})
                        </h2>
                        @if($type !== 'blogs' && $results['blogs']->total() > 3)
                        <a href="{{ route('search_results', ['query' => $query, 'type' => 'blogs']) }}" 
                           class="btn btn-sm btn-outline-success">
                            View All Blogs <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($results['blogs']->take($type === 'blogs' ? 20 : 4) as $blog)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="blog-search-card card border-0 shadow-sm h-100">
                            <a href="{{ route('blog-details', ['slug' => $blog->slug]) }}" class="blog-search-link text-decoration-none">
                                <div class="blog-image-container">
                                    <img src="{{ $blog->category_image ? asset($blog->category_image) : asset('front/assets/images/no-image-found.jpg') }}"
                                         class="blog-search-image"
                                         alt="{{ $blog->title }}"
                                         loading="lazy">
                                    <div class="blog-overlay">
                                        <span class="view-blog-btn">
                                            Read Article <i class="fas fa-arrow-right ms-1"></i>
                                        </span>
                                    </div>
                                    <div class="blog-badge">
                                        <i class="far fa-clock me-1"></i>
                                        {{ rand(3, 10) }} min read
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-2">
                                        <span class="badge bg-success">{{ $blog->category->title ?? 'General' }}</span>
                                    </div>
                                    <h5 class="blog-search-title mb-2">{{ Str::limit($blog->title, 60) }}</h5>
                                    <p class="blog-search-excerpt text-muted small mb-3">
                                        {{ Str::limit(strip_tags($blog->content), 100) }}
                                    </p>
                                    <div class="blog-search-meta d-flex justify-content-between">
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            {{ $blog->created_at->format('M d, Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="far fa-eye me-1"></i> {{ $blog->views ?? 0 }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($type === 'blogs' && $results['blogs']->hasPages())
                <div class="mt-4">
                    {{ $results['blogs']->links('vendor.pagination.custom') }}
                </div>
                @endif
            </section>
            @endif

            <!-- Categories Results -->
            @if(isset($results['categories']) && $results['categories']->total() > 0)
            <section class="search-section mb-5">
                <div class="section-header mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="section-title mb-0">
                            <i class="fas fa-tags me-2 text-info"></i>
                            Categories ({{ $results['categories']->total() }})
                        </h2>
                        @if($type !== 'categories' && $results['categories']->total() > 3)
                        <a href="{{ route('search_results', ['query' => $query, 'type' => 'categories']) }}" 
                           class="btn btn-sm btn-outline-info">
                            View All Categories <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($results['categories']->take($type === 'categories' ? 20 : 4) as $category)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="category-search-card card border-0 shadow-sm h-100">
                            <a href="{{ route('category.details', ['slug' => $category->slug]) }}" class="category-search-link text-decoration-none">
                                <div class="category-content p-4 text-center">
                                    <div class="category-icon mb-3">
                                        <div class="bg-info rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-tag text-white fs-4"></i>
                                        </div>
                                    </div>
                                    <h5 class="category-name mb-2">{{ $category->title }}</h5>
                                    <p class="category-description text-muted small mb-3">
                                        {{ Str::limit($category->description, 80) }}
                                    </p>
                                    <div class="category-stats">
                                        <small class="text-muted">
                                            <i class="fas fa-newspaper me-1"></i>
                                            {{ $category->blogs_count ?? 0 }} articles
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($type === 'categories' && $results['categories']->hasPages())
                <div class="mt-4">
                    {{ $results['categories']->links('vendor.pagination.custom') }}
                </div>
                @endif
            </section>
            @endif
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    :root {
        --primary-color: #2e2bb1;
        --secondary-color: #791291;
        --text-dark: #2d3748;
        --text-light: #718096;
        --bg-light: #f7fafc;
        --border-radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Hero Section */
    .search-hero {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        position: relative;
        overflow: hidden;
    }

    .search-hero::before {
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

    .search-type-filters .btn-group {
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .search-type-filters .btn {
        border: none;
        padding: 8px 16px;
        font-weight: 500;
    }

    .search-form .input-group {
        border-radius: 15px;
        overflow: hidden;
    }

    /* Search Sections */
    .section-header {
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    /* Blog Cards */
    .blog-search-card {
        transition: all 0.3s ease;
        border-radius: var(--border-radius);
        overflow: hidden;
        background: white;
    }

    .blog-search-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .blog-image-container {
        position: relative;
        overflow: hidden;
        height: 180px;
    }

    .blog-search-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog-search-card:hover .blog-search-image {
        transform: scale(1.05);
    }

    .blog-overlay {
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

    .blog-search-card:hover .blog-overlay {
        opacity: 1;
    }

    .view-blog-btn {
        color: white;
        font-weight: 600;
    }

    .blog-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .blog-search-title {
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.4;
        margin-bottom: 0.5rem;
        min-height: 48px;
    }

    /* Category Cards */
    .category-search-card {
        transition: all 0.3s ease;
        border-radius: var(--border-radius);
        background: white;
    }

    .category-search-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--info);
    }

    .category-content {
        transition: all 0.3s ease;
    }

    .category-search-card:hover .category-content {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .category-name {
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-type-filters .btn-group {
            flex-wrap: wrap;
            border-radius: 10px;
        }
        
        .search-type-filters .btn {
            flex: 1 0 45%;
            margin: 2px;
        }
        
        .blog-image-container {
            height: 160px;
        }
    }

    @media (max-width: 576px) {
        .search-type-filters .btn {
            flex: 1 0 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Live search suggestions (optional)
        const searchInput = document.querySelector('.search-form input[name="query"]');
        const searchForm = document.querySelector('.search-form');
        
        if (searchInput) {
            let timeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (this.value.length > 2) {
                        fetchSuggestions(this.value);
                    }
                }, 300);
            });
        }
        
        function fetchSuggestions(query) {
            fetch(`/search-suggestions?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    // Handle suggestions here
                    console.log('Suggestions:', data);
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>
@endpush