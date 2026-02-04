@extends('admin.layouts.master')
@section('title')
    Update Category
@endsection

@section('main-content')
<div class="content-wrapper">
    <!-- Header with breadcrumb -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-primary"><i class="fas fa-edit mr-2"></i>Update Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Notification alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="icon fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="icon fas fa-exclamation-triangle mr-2"></i>
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Form -->
            <form name="UpdateCategory" id="UpdateCategory" method="POST" enctype="multipart/form-data" action="{{ route('admin.category.update', $category->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Category Information</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Category Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" id="title" placeholder="Enter category title"
                                           value="{{ old('title', $category->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">Category URL/Slug <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                               name="slug" id="slug" placeholder="category-slug"
                                               value="{{ old('slug', $category->slug) }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        </div>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Only lowercase letters, numbers and hyphens allowed</small>
                                </div>

                                <div class="form-group">
                                    <label for="category_image">Category Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('category_image') is-invalid @enderror"
                                               name="category_image" id="category_image" accept="image/*">
                                        <label class="custom-file-label" for="category_image">Choose new image (leave blank to keep current)</label>
                                        @error('category_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Recommended size: 800x600px, Max: 2MB</small>
                                    <div class="mt-3">
                                        <h6 class="text-muted mb-2">Current Image</h6>
                                        <img src="{{ asset('uploads/categories/' . $category->category_image) }}"
                                             alt="Current Category Image"
                                             class="img-thumbnail"
                                             style="max-height: 200px;">
                                    </div>
                                    <div class="mt-3 text-center" id="imagePreviewContainer" style="display: none;">
                                        <h6 class="text-muted mb-2">New Image Preview</h6>
                                        <img id="categoryImagePreview" src="#" alt="New Category Image Preview" class="img-thumbnail" style="max-height: 200px;">
                                        <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImageBtn">
                                            <i class="fas fa-trash mr-1"></i> Remove New Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Card -->
                        <div class="card card-info card-outline mt-3">
                            <div class="card-header">
                                <h3 class="card-title">SEO Settings</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="meta_tag">Meta Tags <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('meta_tag') is-invalid @enderror"
                                           name="meta_tag" id="meta_tag" placeholder="tag1, tag2, tag3"
                                           value="{{ old('meta_tag', $category->meta_tag) }}" required>
                                    @error('meta_tag')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="text-muted">Separate tags with commas</small>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keyword">Meta Keywords <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('meta_keyword') is-invalid @enderror"
                                           name="meta_keyword" id="meta_keyword" placeholder="keyword1, keyword2"
                                           value="{{ old('meta_keyword', $category->meta_keyword) }}" required>
                                    @error('meta_keyword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control"
                                              rows="3" placeholder="Brief description for search engines">{{ old('meta_description', $category->meta_description) }}</textarea>
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                    <div class="d-flex justify-content-end">
                                        <span id="meta_desc_counter">{{ strlen(old('meta_description', $category->meta_description)) }}</span>/160
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <!-- Status Card -->
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Publish</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="enable" name="status" value="enable" {{ old('status', $category->status) == 'enable' ? 'checked' : '' }}>
                                        <label for="enable" class="custom-control-label font-weight-normal text-success">Enable</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="disable" name="status" value="disable" {{ old('status', $category->status) == 'disable' ? 'checked' : '' }}>
                                        <label for="disable" class="custom-control-label font-weight-normal text-danger">Disable</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Authentication</label>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="authentication" name="authentication" value="top_stores" {{ old('authentication', $category->authentication) == 'top_stores' ? 'checked' : '' }}>
                                        <label for="authentication" class="custom-control-label font-weight-normal">Top Store</label>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Update Category
                                    </button>
                                    <a href="{{ route('admin.category.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Current Image Card -->
                        <div class="card card-secondary card-outline mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Current Image</h3>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset('uploads/categories/' . $category->category_image) }}"
                                     alt="Current Category Image"
                                     class="img-fluid rounded"
                                     style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-generate slug from title
        $('#title').on('input', function() {
            const title = $(this).val();
            if (title) {
                const slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
                    .replace(/[\s-]+/g, '-')      // Replace spaces and hyphens with -
                    .replace(/^-+|-+$/g, '');     // Trim - from start and end
                $('#slug').val(slug);
            }
        });

        // Preview image before upload
        $('#category_image').change(function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#categoryImagePreview').attr('src', e.target.result);
                    $('#imagePreviewContainer').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Remove image preview
        $('#removeImageBtn').click(function() {
            $('#category_image').val('');
            $('.custom-file-label').html('Choose new image (leave blank to keep current)');
            $('#imagePreviewContainer').hide();
        });

        // Update file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Meta description character counter
        $('#meta_description').on('input', function() {
            const length = $(this).val().length;
            $('#meta_desc_counter').text(length);

            if (length > 160) {
                $('#meta_desc_counter').addClass('text-danger');
            } else {
                $('#meta_desc_counter').removeClass('text-danger');
            }
        });
    });
</script>
@endsection
