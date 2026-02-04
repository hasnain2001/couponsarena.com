@extends('admin.layouts.master')
@section('title')
    Update Store
@endsection

@section('main-content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-store"></i> Update Store</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.store.index') }}">Stores</a></li>
                            <li class="breadcrumb-item active">Update</li>
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
                                <i class="fas fa-exclamation-triangle mr-2"></i> Validation Errors
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

                <form name="UpdateStore" id="UpdateStore" method="POST" enctype="multipart/form-data" action="{{ route('admin.store.update', $stores->id) }}">
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
                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $stores->name) }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">URL/Slug <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ url('/store/') }}/</span>
                                            </div>
                                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $stores->slug) }}" required>
                                        </div>
                                        <small id="slug-message" class="form-text"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Short Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $stores->description) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="destination_url">Destination URL <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                            </div>
                                            <input type="url" class="form-control" name="destination_url" id="destination_url" value="{{ old('destination_url', $stores->destination_url) }}" required>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="affiliate_url">affiliate URL <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                            </div>
                                            <input type="url" class="form-control" name="affiliate_url" id="affiliate_url" value="{{ old('affiliate_url', $stores->affiliate_url) }}" required>
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
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $stores->title) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_tag">Meta Tags <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="meta_tag" id="meta_tag" value="{{ old('meta_tag', $stores->meta_tag) }}">
                                        <small class="form-text text-muted">Example: shopping, deals, discounts</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keyword">Meta Keywords <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="{{ old('meta_keyword', $stores->meta_keyword) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="2">{{ old('meta_description', $stores->meta_description) }}</textarea>
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
                                            <input type="radio" id="enable" name="status" class="custom-control-input" value="enable" {{ old('status', $stores->status) == 'enable' ? 'checked' : '' }}>
                                            <label class="custom-control-label text-success" for="enable"><i class="fas fa-check-circle mr-1"></i> Enable</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="disable" name="status" class="custom-control-input" value="disable" {{ old('status', $stores->status) == 'disable' ? 'checked' : '' }}>
                                            <label class="custom-control-label text-danger" for="disable"><i class="fas fa-times-circle mr-1"></i> Disable</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="authentication" name="authentication" value="top_stores" {{ old('authentication', $stores->authentication) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="authentication"><i class="fas fa-star mr-1 text-warning"></i> Mark as Top Store</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="network">Network <span class="text-danger">*</span></label>
                                        <select name="network_id" id="network_id" class="form-control select2" style="width: 100%;">
                                            <option value="" disabled>-- Select Network --</option>
                                            @foreach ($networks as $network)
                                            <option value="{{ $network->id }}" {{ old('network_id', $stores->network_id) == $network->id ? 'selected' : '' }}>
                                                {{ $network->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;" required>
                                            <option value="" disabled>-- Select Category --</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $stores->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->slug }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="language_id">Language <span class="text-danger">*</span></label>
                                        <select name="language_id" id="language_id" class="form-control select2" style="width: 100%;" required>
                                            <option value="" disabled>-- Select Language --</option>
                                            @foreach ($langs as $lang)
                                            <option value="{{ $lang->id }}" {{ old('language_id', $stores->language_id) == $lang->id ? 'selected' : '' }}>
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
                                        <label for="store_image">Store Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="store_image" name="store_image">
                                            <label class="custom-file-label" for="store_image">Choose new image...</label>
                                        </div>
                                        <small class="form-text text-muted">Recommended size: 300x300 pixels</small>
                                        @if($stores->store_image)
                                        <input type="hidden" name="previous_image" value="{{ $stores->store_image }}">
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        @if($stores->store_image)
                                        <img id="currentImage" src="{{ asset('uploads/stores/'.$stores->store_image) }}" class="img-fluid img-thumbnail" style="max-height: 200px;">
                                        @else
                                        <img id="currentImage" src="https://via.placeholder.com/300x300?text=No+Image" class="img-fluid img-thumbnail" style="max-height: 200px;">
                                        @endif
                                        <img id="imagePreview" class="img-fluid img-thumbnail mt-2" style="max-height: 200px; display: none;">
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
                                        <textarea name="about" id="about" class="form-control" rows="3">{{ old('about', $stores->about) }}</textarea>
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
                                    <textarea id="editor" name="content" >{{ old('content', $stores->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-footer text-right">
                                    <a href="{{ route('admin.store.index') }}" class="btn btn-outline-secondary mr-2">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                    <button type="reset" class="btn btn-outline-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Update Store
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        // JavaScript to preview the selected image
        document.getElementById('store_image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
        var reader = new FileReader();
        reader.onload = function(event) {
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', event.target.result);
        imgElement.setAttribute('class', 'preview-image'); // Optional: Add CSS class for styling
        imgElement.setAttribute('style', 'max-width: 100%; height: auto;'); // Optional: Add styling
        document.getElementById('imagePreview').innerHTML = ''; // Clear previous preview, if any
        document.getElementById('imagePreview').appendChild(imgElement);
        }
        reader.readAsDataURL(file);
        } else {
        document.getElementById('imagePreview').innerHTML = ''; // Clear preview if no file selected
        }
        });
        </script>
           <script>
            // Filter non-alphabetic characters in the 'name' input field and auto-fill 'slug'
            const inputOne = document.getElementById('name');
            const textOnlyInput = document.getElementById('slug');

            inputOne.addEventListener('input', () => {
                const value = inputOne.value;
                // Filter out non-alphabetic characters and update slug automatically
                const filteredValue = value.replace(/[^A-Za-z\s]/g, '');
                textOnlyInput.value = filteredValue;

                // Automatically check slug existence after auto-filling
                checkSlugExistence(filteredValue);
            });

            $(document).ready(function() {
                // Check slug existence when the user types manually in the slug field
                $('#slug').on('keyup', function() {
                    var slug = $(this).val();

                    // Check if the slug has any value (optional: avoid AJAX if empty)
                    if (slug) {
                        checkSlugExistence(slug);
                    } else {
                        $('#slug-message').text('Please enter a slug').css('color', 'black');
                    }
                });
            });

            // Function to check if the slug exists
            function checkSlugExistence(slug) {
                $.ajax({
                    url: '{{ route('admin.store.check.slug') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        slug: slug
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
