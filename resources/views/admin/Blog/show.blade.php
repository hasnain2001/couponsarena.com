@extends('admin.layouts.master')
@section('title')
    Blog Details - {{ $blog->title }}
@endsection

@section('main-content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-dark">
                <i class="fas fa-file-alt text-primary me-2"></i>Blog Details
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blogs</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ Str::limit($blog->title, 30) }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Blogs
            </a>
            <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-external-link-alt me-2"></i>View Live
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Blog Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h4 mb-0 text-dark fw-bold">{{ $blog->title }}</h3>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary">
                                <i class="fas fa-tag me-1"></i>{{ $blog->category->title ?? 'Uncategorized' }}
                            </span>
                             <span class="badge bg-primary">
                                <i class="fas fa-store me-1"></i>{{ $blog->store->name ?? 'no store ' }}
                            </span>
                            @if($blog->status == 'enable')
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Published</span>
                            @else
                            <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Draft</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Blog Meta Info -->
                <div class="card-body border-bottom">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Published Date</small>
                                    <strong>{{ $blog->created_at->format('F j, Y') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="fas fa-clock text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Last Updated</small>
                                    <strong>{{ $blog->updated_at->format('F j, Y \a\t h:i A') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="fas fa-eye text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total Views</small>
                                    <strong>{{ $blog->views ?? 0 }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="fas fa-language text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Language</small>
                                    <strong>{{ $blog->language->name ?? 'English' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($blog->category_image)
                <div class="card-body border-bottom">
                    <h6 class="text-muted mb-3"><i class="fas fa-image me-2"></i>Featured Image</h6>
                    <div class="text-center">
                        <img src="{{ asset($blog->category_image) }}" 
                             alt="{{ $blog->title }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 400px; object-fit: cover; width: 100%;">
                    </div>
                </div>
                @endif

                <!-- Blog Content -->
                <div class="card-body">
                    <h6 class="text-muted mb-3"><i class="fas fa-align-left me-2"></i>Content</h6>
                    <div class="blog-content p-3 bg-light rounded">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Blog
                        </a>
                        <a href="{{ route('admin.blog.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Create New Blog
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Blog
                        </button>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-search text-info me-2"></i>SEO Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Meta Title</small>
                        <p class="mb-0">{{ $blog->meta_title ?? 'Not Set' }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Meta Keywords</small>
                        <p class="mb-0">{{ $blog->meta_keyword ?? 'Not Set' }}</p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Meta Description</small>
                        <p class="mb-0 text-truncate">{{ $blog->meta_description ?? 'Not Set' }}</p>
                    </div>
                </div>
            </div>

            <!-- Blog Statistics -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-bar text-success me-2"></i>Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-eye text-primary fs-4"></i>
                            </div>
                            <h4 class="mb-0">{{ $blog->views ?? 0 }}</h4>
                            <small class="text-muted">Views</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-comments text-warning fs-4"></i>
                            </div>
                            <h4 class="mb-0">{{ $blog->comments_count ?? 0 }}</h4>
                            <small class="text-muted">Comments</small>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-share-alt text-info fs-4"></i>
                            </div>
                            <h4 class="mb-0">{{ $blog->shares ?? 0 }}</h4>
                            <small class="text-muted">Shares</small>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-heart text-danger fs-4"></i>
                            </div>
                            <h4 class="mb-0">{{ $blog->likes ?? 0 }}</h4>
                            <small class="text-muted">Likes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this blog?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. All data associated with this blog will be permanently deleted.
                </div>
                <div class="card">
                    <div class="card-body">
                        <strong>Blog Title:</strong> {{ $blog->title }}<br>
                        <strong>Category:</strong> {{ $blog->category->title ?? 'N/A' }}<br>
                        <strong>Published:</strong> {{ $blog->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.blog.delete', $blog->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    .blog-content p {
        line-height: 1.8;
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .blog-content h1, 
    .blog-content h2, 
    .blog-content h3, 
    .blog-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #2d3748;
        font-weight: 600;
    }
    
    .blog-content ul, 
    .blog-content ol {
        margin-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: var(--primary-color, #791291);
        font-weight: 500;
    }
    
    .card {
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }
    
    .card-header {
        background: #fff;
        border-bottom: 1px solid #e9ecef;
    }
    
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Copy URL functionality
        document.getElementById('copyUrlBtn').addEventListener('click', function() {
            var url = window.location.href;
            navigator.clipboard.writeText(url).then(function() {
                var toast = new bootstrap.Toast(document.getElementById('copyToast'));
                toast.show();
            });
        });
    });
</script>
@endpush