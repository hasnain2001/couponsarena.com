@extends('admin.layouts.master')
@section('title')
    Create Store
@endsection

@section('main-content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-store"></i> Create New Store</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.store.index') }}">Stores</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Alerts Section -->
                <div class="row">
                    <div class="col-12">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Oops! Something went wrong:
                            </h5>
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <form name="CreateStore" id="CreateStore" method="POST" enctype="multipart/form-data" action="{{ route('admin.store.store') }}">
                    @csrf
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Basic Information</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Store Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter store name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">URL/Slug <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}"
                                        placeholder="Enter URL/Slug" required>
                                        </div>
                                        <small id="slug-message" class="form-text"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Short Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brief description of the store" required>{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="destination_url">store URL <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                            </div>
                                            <input type="url" class="form-control" name="destination_url" id="url" value="{{ old('destination_url') }}" placeholder="https://example.com" required>
                                        </div>
                                    </div>
                                                                        <div class="form-group">
                                        <label for="url">affiliate URL <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                            </div>
                                            <input type="affiliate_url" class="form-control" name="affiliate_url" id="affiliate_url" value="{{ old('affiliate_url') }}" placeholder="https://example.com" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">SEO Information</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Meta Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Meta title for SEO">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_keyword">Meta Keywords <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="{{ old('meta_keyword') }}" placeholder="Keywords for SEO">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="2" placeholder="Brief meta description for search engines">{{ old('meta_description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Store Settings</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="enable" name="status" class="custom-control-input" value="enable" {{ old('status', 'enable') == 'enable' ? 'checked' : '' }}>
                                            <label class="custom-control-label text-success" for="enable"><i class="fas fa-check-circle mr-1"></i> Enable</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="disable" name="status" class="custom-control-input" value="disable" {{ old('status') == 'disable' ? 'checked' : '' }}>
                                            <label class="custom-control-label text-danger" for="disable"><i class="fas fa-times-circle mr-1"></i> Disable</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="authentication" name="authentication" value="top_stores" {{ old('authentication') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="authentication"><i class="fas fa-star mr-1 text-warning"></i> Mark as Top Store</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="network">Network <span class="text-danger">*</span></label>
                                        <select name="network_id" id="network_id" class="form-control select2" style="width: 100%;">
                                            <option value="" disabled {{ old('network_id') ? '' : 'selected' }}>-- Select Network --</option>
                                            @foreach ($networks as $network)
                                            <option value="{{ $network->id }}" {{ old('network_id') == $network->id ? 'selected' : '' }}>
                                                {{ $network->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;" required>
                                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Select Category --</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->slug }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="language_id">Language <span class="text-danger">*</span></label>
                                        <select name="language_id" id="language_id" class="form-control select2" style="width: 100%;" required>
                                            <option value="" disabled {{ old('language_id') ? '' : 'selected' }}>-- Select Language --</option>
                                            @foreach ($langs as $lang)
                                            <option value="{{ $lang->id }}" {{ old('language_id') == $lang->id ? 'selected' : '' }}>
                                                {{ strtoupper($lang->code) }} ({{ $lang->name }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Store Media</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="store_image">Store Logo <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="form-control" name="store_image" id="store_image" value="{{ old('store_image') }}" required>
                                            <label class="custom-file-label" for="store_image">Choose file...</label>
                                        </div>
                                        <small class="form-text text-muted">Recommended size: 300x300 pixels</small>
                                    </div>

                                    <div class="text-center">
                                        <!-- Image Preview -->
                                        <img id="imagePreview" src="" class="img-fluid img-thumbnail" style="max-height: 200px; display: none; margin: 0 auto;">
                                    </div>
                                </div>


                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Additional Information</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="about">About Store</label>
                                        <textarea name="about" id="about" class="form-control" rows="3" placeholder="Detailed information about the store">{{ old('about') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width Content Editor -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Main Content</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <textarea id="editor" name="content" >{{ old('content') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-footer text-right">
                                    <button type="reset" class="btn btn-outline-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Save Store
                                    </button>
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
        // Filter non-alphabetic characters in the 'name' input field and auto-fill 'slug' and 'url'
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const destinationUrlInput = document.getElementById('url');

        nameInput.addEventListener('input', () =>
         {
            const value = nameInput.value;

            // Filter out non-alphabetic characters (keeping spaces)
            const filteredValue = value.replace(/[^A-Za-z\s]/g, '');

            // Generate display slug (keep spaces but clean up multiple spaces)
            const displaySlug = filteredValue.toLowerCase().replace(/\s+/g, ' ').trim();

            // Generate URL-friendly slug (replace spaces with hyphens)
            const urlSlug = displaySlug.replace(/\s+/g, '-');

            // Generate destination URL
            const currentUrl = window.location.origin;
            const generatedDestinationUrl = currentUrl + '/store/' + urlSlug;

            // Update slug field with display version (with spaces)
            if (!slugInput.value || slugInput.value === slugInput.dataset.previousGenerated) {
                slugInput.value = displaySlug;
                slugInput.dataset.previousGenerated = displaySlug;
                checkSlugExistence(urlSlug); // Check using the URL-friendly version
            }

            // Update destination URL with hyphenated version
            destinationUrlInput.value = generatedDestinationUrl;
            destinationUrlInput.dataset.previousGenerated = generatedDestinationUrl;
        });

        // Existing slug check functionality (modified to check URL-friendly version)
        $(document).ready(function() {
            $('#slug').on('keyup', function() {
                var displaySlug = $(this).val();
                var urlSlug = displaySlug.replace(/\s+/g, '-');
                if (urlSlug) {
                    checkSlugExistence(urlSlug);
                } else {
                    $('#slug-message').text('Please enter a slug').css('color', 'black');
                }
            });
        });

        function checkSlugExistence(urlSlug) {
            $.ajax({
                url: '{{ route('admin.store.check.slug') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    slug: urlSlug
                },
                success: function(response) {
                    if (response.exists) {
                        $('#slug-message').text('Store already exists').css('color', 'red');
                    } else {
                        $('#slug-message').text('Store is available').css('color', 'green');
                    }
                }
            });
        }
    </script>

    <script>
        // JavaScript to handle image preview
        document.getElementById('store_image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Get the selected file
            const previewImage = document.getElementById('imagePreview'); // Get the image preview element

            if (file) {
                const reader = new FileReader(); // Create a FileReader object

                // Set up the FileReader to update the image source
                reader.onload = function(e) {
                    previewImage.src = e.target.result; // Set the image source to the file's data URL
                    previewImage.style.display = 'block'; // Show the image preview
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            } else {
                previewImage.src = ''; // Clear the image source if no file is selected
                previewImage.style.display = 'none'; // Hide the image preview
            }
        });
    </script>
@endsection
    