@extends('layouts.main')
@section('title',)
@if ($blog->meta_title)
{{ $blog->meta_title }}
@else
{{ $blog->title }}
@endif
@endsection
@section('description')
{{ $blog->meta_description}}
@endsection
@section('keywords')
{{ $blog->meta_keyword }}
@endsection

@section('main-content')
<div class="container-fluid px-0">
    <!-- Hero Banner Section -->
    <div class="blog-hero-banner position-relative">
        <!-- Background Image -->
        <div class="banner-background" style="background-image: url('{{ asset($blog->category_image) }}');"></div>

        <!-- Overlay Gradient -->
        <div class="banner-overlay"></div>

        <!-- Breadcrumb (on banner) -->
        <div class="banner-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-decoration-none text-white">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('category.details', ['slug' => Str::slug($blog->category->slug)]) }}" class="text-decoration-none text-white">
                            {{ $blog->category->title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url(app()->getLocale() . '/blog') }}" class="text-decoration-none text-white">Blog</a>
                    </li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">{{ Str::limit($blog->title, 30) }}</li>
                </ol>
            </nav>
        </div>

        <!-- Title Section -->
        <div class="container">
            <div class="banner-title-wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <h1 class="blog-title text-white mb-4">{{ $blog->title }}</h1>
                        <div class="blog-meta d-flex align-items-center justify-content-center text-white">
                            <span class="me-3"><i class="far fa-calendar me-1"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                            <span><i class="far fa-clock me-1"></i> {{ $blog->read_time ?? '5 min read' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="row">
            <!-- Blog Content Column -->
            <div class="col-lg-8">
                <div class="blog-content-wrapper shadow-sm rounded-lg p-4 mb-5">
                    <!-- Featured Image (for mobile) -->
                    <div class="d-lg-none mb-4">
                        <img src="{{ asset($blog->category_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded">
                    </div>

                    <!-- Content -->
                    <div class="content-body">
                        {!! $blog->content !!}
                    </div>

                    <!-- Tags -->
                    @if($blog->meta_keyword)
                    <div class="blog-tags mt-5 pt-4 border-top">
                        <h6 class="mb-3"><i class="fas fa-tags me-2"></i>Tags</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $blog->meta_keyword) as $tag)
                            <span class="badge bg-light text-dark border px-3 py-2">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="share-section mt-5 pt-4 border-top">
                        <h6 class="mb-3"><i class="fas fa-share-alt me-2"></i>Share this article</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="share-btn instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="share-btn tiktok"><i class="fab fa-tiktok"></i></a>
                            

                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Latest Stores Section -->
                <aside class="sidebar sticky-top" style="top: 20px;">
                    {{-- <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                        <div class="card-header bg-dark text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-store me-2"></i>Latest Stores</h5>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                @foreach ($chunks as $store)
                                <div class="col-12">
                                    <div class="store-card d-flex align-items-center p-2 rounded hover-shadow">
                                        <div class="store-image-wrapper me-3">
                                            <div class="store-circle">
                                                <img src="{{ asset('uploads/stores/' . $store->store_image) }}"
                                                     alt="{{ $store->name }}"
                                                     class="store-img">
                                            </div>
                                        </div>
                                        <div class="store-info flex-grow-1">
                                            <h6 class="store-name mb-1">{{ Str::limit($store->name, 20) }}</h6>
                                            <a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}"
                                               class="btn btn-dark btn-sm px-3">
                                                Visit <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- View All Link -->
                            <div class="text-center mt-4">
                                <a href="{{ route('store', ['lang' => app()->getLocale()]) }}" class="btn btn-outline-dark w-100">
                                    View All Stores <i class="fas fa-external-link-alt ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Additional Sidebar Widget -->
                    <div class="card border-0 shadow-sm rounded-lg mt-4 overflow-hidden">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Recent Posts</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach($recentPosts ?? [] as $recent)
                                <a href="{{ route('blog-details', ['slug' => Str::slug($recent->slug)]) }}"
                                   class="list-group-item list-group-item-action border-0 py-3">
                                    <h6 class="mb-1">{{ Str::limit($recent->title, 50) }}</h6>
                                    <small class="text-muted">{{ $recent->created_at->format('M d') }}</small>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Hero Banner Styles */
.blog-hero-banner {
    height: 70vh;
    min-height: 500px;
    position: relative;
    overflow: hidden;
}

.banner-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: brightness(0.7);
    transition: transform 10s ease;
}

.blog-hero-banner:hover .banner-background {
    transform: scale(1.05);
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
}

.banner-breadcrumb {
    position: absolute;
    top: 30px;
    left: 0;
    width: 100%;
    z-index: 10;
}

.banner-breadcrumb .breadcrumb {
    background: transparent;
    padding: 0 15px;
}

.banner-title-wrapper {
    position: relative;
    z-index: 5;
    display: flex;
    align-items: center;
    height: 70vh;
    min-height: 500px;
    text-align: center;
}

.blog-title {
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 1.2;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    animation: fadeInUp 0.8s ease;
}

.blog-meta {
    opacity: 0.9;
    animation: fadeInUp 1s ease;
}

.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 1.5rem;
    animation: bounce 2s infinite;
    cursor: pointer;
    z-index: 10;
}

/* Blog Content */
.blog-content-wrapper {
    background: white;
    border-radius: 15px;
    margin-top: -50px;
    position: relative;
    z-index: 2;
}

.content-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.content-body h2,
.content-body h3,
.content-body h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.content-body p {
    margin-bottom: 1.5rem;
}

.content-body img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1.5rem 0;
}

/* Store Cards */
.store-card {
    transition: all 0.3s ease;
    border: 1px solid #eee;
}

.store-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #ddd;
}

.store-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #fff;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.store-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.store-card:hover .store-img {
    transform: scale(1.1);
}

.store-name {
    color: #2c3e50;
    font-weight: 600;
}

/* Share Buttons */
.share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.share-btn.facebook { background: #3b5998; }
.share-btn.instagram { background: #e1306c; }
.share-btn.tiktok { background: #000000; }

.share-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    40% {
        transform: translateX(-50%) translateY(-10px);
    }
    60% {
        transform: translateX(-50%) translateY(-5px);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .blog-hero-banner {
        height: 50vh;
        min-height: 400px;
    }

    .banner-title-wrapper {
        height: 50vh;
        min-height: 400px;
    }

    .blog-title {
        font-size: 2.5rem;
    }

    .blog-content-wrapper {
        margin-top: -30px;
    }
}

@media (max-width: 576px) {
    .blog-title {
        font-size: 2rem;
    }

    .store-card {
        flex-direction: column;
        text-align: center;
    }

    .store-image-wrapper {
        margin-right: 0 !important;
        margin-bottom: 15px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Smooth scroll for scroll indicator
document.querySelector('.scroll-indicator').addEventListener('click', function() {
    window.scrollTo({
        top: document.querySelector('.blog-content-wrapper').offsetTop - 20,
        behavior: 'smooth'
    });
});

// Add parallax effect to banner
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const banner = document.querySelector('.banner-background');
    if (banner) {
        banner.style.transform = `translateY(${scrolled * 0.5}px) scale(1.05)`;
    }
});

// Share buttons functionality
document.querySelectorAll('.share-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const url = window.location.href;
        const title = document.querySelector('.blog-title').textContent;

        if (this.classList.contains('facebook')) {
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
        } else if (this.classList.contains('instagram')) {
            window.open(`https://www.instagram.com/?url=${encodeURIComponent(url)}`, '_blank');
        } else if (this.classList.contains('tiktok')) {
            window.open(`https://www.tiktok.com/share?url=${encodeURIComponent(url)}`, '_blank');
        }
    });
});
</script>
@endpush
