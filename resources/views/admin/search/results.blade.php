@extends('admin.layouts.master')
@section('title', "Admin Search: '{$query}'")
@section('main-content')

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-dark">
                <i class="fas fa-search me-2 text-primary"></i>Search Results
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Search: "{{ $query }}"</li>
                </ol>
            </nav>
        </div>
        
        <!-- Search Form -->
        <div style="max-width: 400px;">
            <form action="{{ route('admin.search') }}" method="GET" class="w-100">
                <div class="input-group">
                    <input type="text" 
                           name="query" 
                           class="form-control" 
                           placeholder="Search in admin..."
                           value="{{ $query }}"
                           required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="fw-bold text-muted me-2">Filter by:</span>
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'all']) }}" 
                   class="btn btn-sm {{ $type === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-layer-group me-1"></i> All ({{ $totalCount }})
                </a>
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'stores']) }}" 
                   class="btn btn-sm {{ $type === 'stores' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-store me-1"></i> 
                    {{ isset($results['stores']) ? $results['stores']->total() : 0 }} Stores
                </a>
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'blogs']) }}" 
                   class="btn btn-sm {{ $type === 'blogs' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-blog me-1"></i> 
                    {{ isset($results['blogs']) ? $results['blogs']->total() : 0 }} Blogs
                </a>
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'categories']) }}" 
                   class="btn btn-sm {{ $type === 'categories' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-tags me-1"></i> 
                    {{ isset($results['categories']) ? $results['categories']->total() : 0 }} Categories
                </a>
            </div>
        </div>
    </div>

    <!-- Results Container -->
    @if ($totalCount === 0)
    <!-- No Results -->
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No results found for "{{ $query }}"</h4>
                <p class="text-muted mb-4">Try adjusting your search terms or browse through the sections below.</p>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('admin.store.index') }}" class="btn btn-primary">
                    <i class="fas fa-store me-2"></i> Browse Stores
                </a>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-success">
                    <i class="fas fa-blog me-2"></i> Browse Blogs
                </a>
                <a href="{{ route('admin.category.index') }}" class="btn btn-info">
                    <i class="fas fa-tags me-2"></i> Browse Categories
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Stores Results -->
    @if(isset($results['stores']) && $results['stores']->total() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-store me-2 text-warning"></i>
                    Stores ({{ $results['stores']->total() }})
                </h5>
                @if($type !== 'stores')
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'stores']) }}" 
                   class="btn btn-sm btn-outline-warning">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Store</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['stores']->take($type === 'stores' ? 15 : 5) as $store)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($store->store_image)
                                    <img src="{{ asset('uploads/stores/' . $store->store_image) }}" 
                                         alt="{{ $store->name }}" 
                                         class="rounded me-3"
                                         width="40"
                                         height="40"
                                         style="object-fit: cover;">
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $store->name }}</div>
                                        <small class="text-muted">{{ $store->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $store->category->title ?? 'General' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $store->language->code ?? 'EN' }}</span>
                            </td>
                            <td>
                                @if($store->status == 'enable')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.store.store_details', ['slug' => Str::slug($store->slug)]) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.store.edit', $store->id) }}" 
                                       class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($type === 'stores' && $results['stores']->hasPages())
            <div class="mt-3">
                {{ $results['stores']->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Blogs Results -->
    @if(isset($results['blogs']) && $results['blogs']->total() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-blog me-2 text-success"></i>
                    Blog Posts ({{ $results['blogs']->total() }})
                </h5>
                @if($type !== 'blogs')
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'blogs']) }}" 
                   class="btn btn-sm btn-outline-success">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Status</th>
                            <th>image</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['blogs']->take($type === 'blogs' ? 15 : 5) as $blog)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ Str::limit($blog->title, 50) }}</div>
                                <small class="text-muted">{{ $blog->slug }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $blog->category->title ?? 'General' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $blog->language->code ?? 'EN' }}</span>
                            </td>
                            <td>
                                @if($blog->status == 'enable')
                                <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                @if($blog->category_image)
                                <img src="{{ asset($blog->category_image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="rounded"
                                     width="40"
                                     height="40"
                                     style="object-fit: cover;">
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.blog.edit', $blog->id) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}" 
                                       target="_blank"
                                       class="btn btn-outline-success">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($type === 'blogs' && $results['blogs']->hasPages())
            <div class="mt-3">
                {{ $results['blogs']->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Categories Results -->
    @if(isset($results['categories']) && $results['categories']->total() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2 text-info"></i>
                    Categories ({{ $results['categories']->total() }})
                </h5>
                @if($type !== 'categories')
                <a href="{{ route('admin.search_results', ['query' => $query, 'type' => 'categories']) }}" 
                   class="btn btn-sm btn-outline-info">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>image</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['categories']->take($type === 'categories' ? 15 : 5) as $category)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $category->title }}</div>
                            </td>
                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>
                            <td>
                                @if($category->category_image)
                                <img src="{{ asset('uploads/categories/' . $category->category_image) }}" 
                                     alt="{{ $category->title }}" 
                                     class="rounded"
                                     width="40"
                                     height="40"
                                     style="object-fit: cover;">
                                @endif
                            </td>
                            <td>
                                @if($category->status == 'enable')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $category->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.category.edit', $category->id) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
            
            @if($type === 'categories' && $results['categories']->hasPages())
            <div class="mt-3">
                {{ $results['categories']->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
    @endif
    @endif
</div>

@endsection