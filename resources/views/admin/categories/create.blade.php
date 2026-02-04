@extends('admin.layouts.master')
@section('title')
    Create Category
@endsection
@section('main-content')
<div class="content-wrapper">
    <!-- Header with breadcrumb -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-primary"><i class="fas fa-plus-circle mr-2"></i>Create Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
            <form name="CreateCategory" id="CreateCategory" method="POST" enctype="multipart/form-data" action="{{ route('admin.category.store') }}">
                @csrf
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
                                           value="{{ old('title') }}" required>
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
                                               value="{{ old('slug') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        </div>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Only lowercase letters, numbers, and hyphens allowed</small>
                                </div>
                                <div class="form-group">
                                    <label for="category_image">Category Image <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('category_image') is-invalid @enderror"
                                               name="category_image" id="category_image" accept="image/*" required>
                                        <label class="custom-file-label" for="category_image">Choose file</label>
                                        @error('category_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Recommended size: 800x600px, Max: 2MB</small>
                                    <div class="mt-2" id="image-preview">
                                        <img id="categoryImagePreview" src="#" alt="Category Image Preview" class="img-fluid rounded" style="max-height: 150px; display: none;">
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
                                           value="{{ old('meta_tag') }}" required>
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
                                           value="{{ old('meta_keyword') }}" required>
                                    @error('meta_keyword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control"
                                              rows="3" placeholder="Brief description for search engines">{{ old('meta_description') }}</textarea>
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                    <div class="d-flex justify-content-end">
                                        <span id="meta_desc_counter">0</span>/160
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
                                        <input class="custom-control-input" type="radio" id="enable" name="status" value="enable" checked>
                                        <label for="enable" class="custom-control-label font-weight-normal text-success">Enable</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="disable" name="status" value="disable">
                                        <label for="disable" class="custom-control-label font-weight-normal text-danger">Disable</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Save Category
                                    </button>
                                    <a href="{{ route('admin.category.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        // Slug generation
        $('#title').on('input', function () {
            let slug = $(this).val().toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, ' ')
                .replace(/-+/g, ' ');
            $('#slug').val(slug);
        });

        // Image preview
        $('#category_image').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#categoryImagePreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

@endsection
