@extends('admin.layouts.datatable_master')
@section('datatable-title')
    Categories Management
@endsection
@section('datatable-content')
<style>
    .card-primary.card-outline {
        border-top: 3px solid #007bff;
    }
    .table thead th {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85em;
        font-weight: 500;
        padding: 5px 10px;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.765625rem;
    }
    .dataTables_wrapper .dataTables_filter {
        float: none;
        text-align: right;
    }
    .img-thumbnail {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-primary"><i class="fas fa-tags mr-2"></i>Categories</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <div class="btn-group">
                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-1"></i> Add New
                        </a>
                        <button type="button" class="btn btn-danger" id="deleteSelectedBtn">
                            <i class="fas fa-trash-alt mr-1"></i> Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="icon fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">All Categories</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    {{-- <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form id="bulk-delete-form" action="{{ route('admin.category.deleteSelected') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table id="SearchTable" class="table table-bordered table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="5%">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="select-all">
                                                        <label class="custom-control-label" for="select-all"></label>
                                                    </div>
                                                </th>
                                                <th width="5%">#</th>
                                                <th width="25%">Category Name</th>
                                                <th width="15%">Image</th>
                                                <th width="10%">Status</th>
                                                <th width="15%">Created At</th>
                                                <th width="25%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input select-checkbox"
                                                                   id="category-{{ $category->id }}" name="selected_categories[]"
                                                                   value="{{ $category->id }}">
                                                            <label class="custom-control-label" for="category-{{ $category->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <strong>{{ $category->title }}</strong>
                                                        <div class="text-muted small">{{ $category->slug }}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <img class="img-thumbnail"
                                                             src="{{ asset('uploads/categories/' . $category->category_image) }}"
                                                             style="max-height: 50px; max-width: 80px;"
                                                             data-toggle="tooltip"
                                                             title="Click to enlarge"
                                                             onclick="showImageModal('{{ asset('uploads/categories/' . $category->category_image) }}')">
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($category->status == "disable")
                                                            <span class="badge badge-danger">Disabled</span>
                                                        @else
                                                            <span class="badge badge-success">Enabled</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('admin.category.edit', $category->id) }}"
                                                               class="btn btn-info"
                                                               data-toggle="tooltip"
                                                               title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('admin.category.delete', $category->id) }}"
                                                               class="btn btn-danger"
                                                               data-toggle="tooltip"
                                                               title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this category?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                            <a href="{{ route('category.details', ['slug' => Str::slug($category->slug)]) }}"
                                                                target="_blank"
                                                               class="btn btn-secondary"
                                                               data-toggle="tooltip"
                                                               title="View Details">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Select all functionality
        $('#select-all').change(function() {
            $('.select-checkbox').prop('checked', $(this).prop('checked'));
            toggleDeleteButton();
        });

        // Individual checkbox change
        $('.select-checkbox').change(function() {
            if ($('.select-checkbox:checked').length == $('.select-checkbox').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
            toggleDeleteButton();
        });

        // Delete selected button
        $('#deleteSelectedBtn').click(function() {
            if ($('.select-checkbox:checked').length > 0) {
                if (confirm('Are you sure you want to delete the selected categories?')) {
                    $('#bulk-delete-form').submit();
                }
            } else {
                alert('Please select at least one category to delete.');
            }
        });

        // Toggle delete button based on selections
        function toggleDeleteButton() {
            if ($('.select-checkbox:checked').length > 0) {
                $('#deleteSelectedBtn').prop('disabled', false);
            } else {
                $('#deleteSelectedBtn').prop('disabled', true);
            }
        }

        // Initialize DataTable
        $('#categoriesTable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "dom": '<"top"f>rt<"bottom"lip><"clear">',
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search categories...",
                "emptyTable": "No categories found",
                "zeroRecords": "No matching categories found"
            }
        });

        // Search functionality
        $('#searchInput').keyup(function() {
            $('#categoriesTable').DataTable().search($(this).val()).draw();
        });
    });

    // Show image in modal
    function showImageModal(imageSrc) {
        $('#modalImage').attr('src', imageSrc);
        $('#imageModal').modal('show');
    }
</script>
@endsection

