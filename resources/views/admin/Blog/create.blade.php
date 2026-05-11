@extends('admin.layouts.master')
@section('title')
    Create Blog
@endsection

@section('main-content')
<div class="content-wrapper">
    <!-- Page header -->
    <section class="content-header mb-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="h3 text-primary"><i class="fas fa-blog me-2"></i>Create New Blog Post</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="float-sm-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog Posts</a></li>
                            <li class="breadcrumb-item active">Create Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Alerts -->
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Validation Error(s):</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.blog.store')}}" enctype="multipart/form-data" id="blogForm">
                @csrf
                
                <div class="row">
                    <!-- Left column - Main content -->
                    <div class="col-lg-8">
                        <!-- Blog Content Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white py-3">
                                <h3 class="h5 mb-0"><i class="fas fa-edit me-2"></i>Blog Content</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-semibold">Blog Title <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-heading text-muted"></i></span>
                                        <input type="text" class="form-control" name="title" id="title" 
                                               value="{{ old('title') }}" placeholder="Enter blog title" required />
                                    </div>
                                    <small class="form-text text-muted mt-1">A clear, descriptive title for your blog post.</small>
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="form-label fw-semibold">Slug / URL <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-link text-muted"></i></span>
                                        <input type="text" class="form-control" name="slug" id="slug" 
                                               value="{{ old('slug') }}" placeholder="blog-post-url" required />
                                    </div>
                                    <small class="form-text text-muted mt-1">URL-friendly version of the title (auto-generated).</small>
                                    <div id="slug-message" class="mt-2"></div>
                                </div>

                                <div class="mb-4">
                                    <label for="content" class="form-label fw-semibold">Main Content <span class="text-danger">*</span></label>
                                    <textarea id="editor" name="content" class="form-control" rows="12">{{ old('content') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-info text-white py-3">
                                <h3 class="h5 mb-0"><i class="fas fa-image me-2"></i>Featured Image</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="blog_image" class="form-label fw-semibold">Upload Blog Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="category_image" id="blog_image" accept="image/*" required>
                                    <small class="form-text text-muted">Recommended size: 1200x630px. Max file size: 2MB.</small>
                                </div>

                                <div class="image-preview-container text-center mt-4">
                                    <div id="imagePreview" class="border rounded p-4 bg-light" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <div class="text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p class="mb-0">Image preview will appear here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right column - Sidebar -->
                    <div class="col-lg-4">
                        <!-- Publish Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-success text-white py-3">
                                <h3 class="h5 mb-0"><i class="fas fa-paper-plane me-2"></i>Publish</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong class="text-muted">Status:</strong>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="status_published" value="enable" checked>
                                            <label class="form-check-label" for="status_published">Published</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Publish Blog Post
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="saveDraftBtn">
                                        <i class="fas fa-save me-2"></i>Save as Draft
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Categories & Language Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-warning text-dark py-3">
                                <h3 class="h5 mb-0"><i class="fas fa-tags me-2"></i>store & Categories & Language</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="store_id" class="form-label fw-semibold">Store <span class="text-danger">*</span></label>
                                    <select name="store_id" id="store_id" class="form-select" required>
                                        <option value="" disabled {{ old('store_id') ? '' : 'selected' }}>-- Select Store --</option>
                                        @foreach ($stores as $store)
                                        <option value="{{ $store->id }}" 
                                                data-language="{{ $store->language_id }}"
                                                data-category="{{ $store->category_id }}"
                                                {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                            {{ $store->slug ?? 'store' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> 
                                
                                <div class="mb-3">
                                    <label for="category_id" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category_id" id="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->slug }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="language_id" class="form-label fw-semibold">Language <span class="text-danger">*</span></label>
                                    <select name="language_id" id="language_id" class="form-select" required>
                                        <option value="" disabled {{ old('language_id') ? '' : 'selected' }}>-- Select Language --</option>
                                        @foreach ($langs as $lang)
                                        <option value="{{ $lang->id }}" {{ old('language_id') == $lang->id ? 'selected' : '' }}>
                                            {{ $lang->code }} - {{ $lang->name ?? 'Language' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings Card -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white py-3">
                                <h3 class="h5 mb-0"><i class="fas fa-search me-2"></i>SEO Settings</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title" 
                                           value="{{ old('meta_title') }}" placeholder="Meta title for SEO">
                                    <small class="form-text text-muted">Recommended: 50-60 characters</small>
                                </div>


                                <div class="mb-3">
                                    <label for="meta_keyword" class="form-label fw-semibold">Meta Keyword</label>
                                    <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" 
                                           value="{{ old('meta_keyword') }}" placeholder="Primary keywords">
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" 
                                              rows="4" placeholder="Brief description for search engines">{{ old('meta_description') }}</textarea>
                                    <small class="form-text text-muted">Recommended: 150-160 characters</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: none;
    }
    
    .form-label {
        color: #2d3748;
        font-size: 0.95rem;
    }
    
    .input-group-text {
        border-right: none;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border-color: #86b7fe;
    }
    
    #imagePreview {
        transition: all 0.3s ease;
    }
    
    #imagePreview:hover {
        background-color: #f8f9fa;
    }
    
    #imagePreview img {
        max-width: 100%;
        max-height: 250px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    
    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: #0d6efd;
    }
    
    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
      // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically select category and language when store is selected
        const storeSelect = document.getElementById('store_id');
        
        if (storeSelect) {
            storeSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const categoryId = selectedOption.getAttribute('data-category');
                const languageId = selectedOption.getAttribute('data-language');

                // Auto-select category if data-category exists
                if (categoryId) {
                    const categorySelect = document.getElementById('category_id');
                    if (categorySelect) {
                        categorySelect.value = categoryId;
                    }
                }

                // Auto-select language if data-language exists
                if (languageId) {
                    const languageSelect = document.getElementById('language_id');
                    if (languageSelect) {
                        languageSelect.value = languageId;
                    }
                }
            });

            // If there's a store selected, trigger the change event to set category and language
            if (storeSelect.value) {
                storeSelect.dispatchEvent(new Event('change'));
            }
        }

        // If you have a toggle code checkbox functionality
        const toggleCodeCheckbox = document.getElementById('toggleCodeCheckbox');
        if (toggleCodeCheckbox) {
            // If there's an old code value, show the code input
            if ("{{ old('code') }}") {
                toggleCodeCheckbox.checked = true;
                const codeInputGroup = document.getElementById('codeInputGroup');
                if (codeInputGroup) {
                    codeInputGroup.style.display = 'block';
                }
            }
        }
    });
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // CKEditor is already initialized in main layout
        
        // Update file input to show selected file name
        const blogImageInput = document.getElementById('blog_image');
        const imagePreview = document.getElementById('imagePreview');
        
        // Initialize image preview functionality
        blogImageInput.addEventListener('change', function() {
            previewImage(this);
        });
        
        // Auto-generate slug from title
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        
        titleInput.addEventListener('input', function() {
            const value = this.value;
            // Convert to slug format
            const slugValue = value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, ' ')
                .trim()
                .replace(/\s/g, ' ');
            
            slugInput.value = slugValue;
            
            // Check slug existence
            if(slugValue) {
                checkSlugExistence(slugValue);
            }
        });
        
        // Check slug existence on manual input
        slugInput.addEventListener('keyup', function() {
            const slug = this.value;
            
            if (slug) {
                checkSlugExistence(slug);
            } else {
                const slugMessage = document.getElementById('slug-message');
                slugMessage.innerHTML = '<span class="text-muted">Please enter a slug</span>';
            }
        });
        
        // Save as draft button
        const saveDraftBtn = document.getElementById('saveDraftBtn');
        if(saveDraftBtn) {
            saveDraftBtn.addEventListener('click', function() {
                // Create a hidden input for draft status
                const draftInput = document.createElement('input');
                draftInput.type = 'hidden';
                draftInput.name = 'status';
                draftInput.value = 'draft';
                
                // Add to form and submit
                const form = document.getElementById('blogForm');
                form.appendChild(draftInput);
                form.submit();
            });
        }
    });
    
    // Function to check slug existence
    function checkSlugExistence(slug) {
        const slugMessage = document.getElementById('slug-message');
        
        // Show loading state
        slugMessage.innerHTML = '<span class="text-info"><i class="fas fa-spinner fa-spin me-1"></i> Checking slug availability...</span>';
        
        fetch('{{ route("admin.blog.check.slug") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ slug: slug })
        })
        .then(response => response.json())
        .then(data => {
            if(data.exists) {
                slugMessage.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i> This slug is already taken</span>';
            } else {
                slugMessage.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i> This slug is available</span>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            slugMessage.innerHTML = '<span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i> Unable to verify slug</span>';
        });
    }
    
    // Function to preview selected image
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = '';
                
                // Create image element
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-fluid rounded';
                img.style.maxHeight = '250px';
                
                // Create remove button container
                const buttonContainer = document.createElement('div');
                buttonContainer.className = 'mt-3';
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-outline-danger';
                removeBtn.innerHTML = '<i class="fas fa-trash me-1"></i> Remove Image';
                removeBtn.onclick = function() {
                    document.getElementById('blog_image').value = '';
                    preview.innerHTML = `
                        <div class="text-muted">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p class="mb-0">Image preview will appear here</p>
                        </div>
                    `;
                };
                
                buttonContainer.appendChild(removeBtn);
                preview.appendChild(img);
                preview.appendChild(buttonContainer);
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Character counter for meta fields (optional enhancement)
    function initMetaFieldCounters() {
        const metaTitle = document.getElementById('meta_title');
        const metaDesc = document.getElementById('meta_description');
        
        if(metaTitle) {
            metaTitle.addEventListener('input', function() {
                updateCharCounter(this, 'metaTitleCounter');
            });
        }
        
        if(metaDesc) {
            metaDesc.addEventListener('input', function() {
                updateCharCounter(this, 'metaDescCounter');
            });
        }
    }
    
    function updateCharCounter(field, counterId) {
        let counter = document.getElementById(counterId);
        if(!counter) {
            counter = document.createElement('div');
            counter.id = counterId;
            counter.className = 'form-text text-end';
            field.parentNode.appendChild(counter);
        }
        
        const length = field.value.length;
        counter.textContent = `${length} characters`;
        
        if(field.id === 'meta_title') {
            if(length > 60) {
                counter.className = 'form-text text-end text-danger';
            } else if(length > 50) {
                counter.className = 'form-text text-end text-warning';
            } else {
                counter.className = 'form-text text-end text-success';
            }
        } else if(field.id === 'meta_description') {
            if(length > 160) {
                counter.className = 'form-text text-end text-danger';
            } else if(length > 150) {
                counter.className = 'form-text text-end text-warning';
            } else {
                counter.className = 'form-text text-end text-success';
            }
        }
    }
    
    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initMetaFieldCounters();
    });
</script>
@endpush