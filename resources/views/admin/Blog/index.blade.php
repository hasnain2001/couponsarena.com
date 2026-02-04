@extends('admin.layouts.datatable_master')

@section('datatable-title', 'Blogs Management')

@section('datatable-content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-blog text-primary me-2"></i>Blogs Management
            </h1>
            <p class="text-muted mb-0">Manage and publish your blog content</p>
        </div>
        <div>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Add New Blog
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-3 fs-4"></i>
            <div>
                <h5 class="alert-heading mb-1">Success!</h5>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Blogs</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $blogs->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Categories</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $blogs->unique('category')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Published</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $blogs->where('status', 'enable')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Drafts</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $blogs->where('status', 'draft')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <form id="bulkDeleteForm" action="{{ route('admin.blog.bulkDelete') }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- Bulk Actions Panel -->
        <div class="bulk-actions-card card shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="select-all">
                            <label class="form-check-label fw-bold text-dark" for="select-all">
                                <i class="fas fa-check-square me-2"></i>Select All Blogs
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" id="bulk-delete-btn" class="btn btn-danger" disabled>
                                <i class="fas fa-trash-alt me-2"></i>Delete Selected
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="quickActionsBtn">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blogs Table -->
        @if ($blogs->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-newspaper fa-4x text-muted"></i>
                </div>
                <h4 class="text-muted mb-3">No Blogs Available</h4>
                <p class="text-muted mb-4">Get started by creating your first blog post!</p>
                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus-circle me-2"></i>Create First Blog
                </a>
            </div>
        </div>
        @else
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>All Blogs
                    </h5>
                    <span class="badge bg-light text-dark">
                        {{ $blogs->count() }} {{ Str::plural('Blog', $blogs->count()) }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="SearchTable" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center">
                                    <input type="checkbox" id="select-all-footer" class="form-check-input">
                                </th>
                                <th width="60">#</th>
                                <th>Title & Description</th>
                                <th>Category</th>
                                <th width="100" class="text-center">Image</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="140" class="text-center">Created</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="selected_blogs[]" value="{{ $blog->id }}"
                                               class="form-check-input row-checkbox">
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary px-2 py-1">#{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <di class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-1">
                                                <small class="mb-1 text-dark">{{ $blog->title }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1">
                                            <i class="fas fa-tag me-1"></i>{{ $blog->category ? $blog->category->title : 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($blog->category_image)
                                            <div class="blog-image-wrapper position-relative mx-auto" style="width: 60px;">
                                                <img src="{{ asset($blog->category_image) }}"
                                                     alt="{{ $blog->title }}"
                                                     class="img-fluid rounded-circle border blog-thumbnail"
                                                     style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                                     loading="lazy"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#imageModal{{ $blog->id }}">
                                                <div class="image-hover-overlay">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                            </div>

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="imageModal{{ $blog->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-image me-2 text-primary"></i>{{ $blog->title }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-0">
                                                            <img src="{{ asset($blog->category_image) }}"
                                                                 alt="{{ $blog->title }}"
                                                                 class="img-fluid rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="no-image-placeholder rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $status = $blog->status ?? 'draft';
                                            $statusConfig = [
                                                'published' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Published'],
                                                'draft' => ['class' => 'warning', 'icon' => 'edit', 'text' => 'Draft'],
                                                'archived' => ['class' => 'secondary', 'icon' => 'archive', 'text' => 'Archived'],
                                                'enable' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Published'],
                                                'disabled' => ['class' => 'warning', 'icon' => 'edit', 'text' => 'Draft'],
                                                'delete' => ['class' => 'danger', 'icon' => 'trash', 'text' => 'Deleted']
                                            ];
                                            $config = $statusConfig[$status] ?? $statusConfig['draft'];
                                        @endphp
                                        <span class="badge bg-{{ $config['class'] }} bg-opacity-10 text-{{ $config['class'] }} border border-{{ $config['class'] }} border-opacity-25 px-3 py-2">
                                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column">
                                            <span class="text-dark small fw-medium">{{ $blog->created_at->format('M d, Y') }}</span>
                                            <span class="text-muted smaller">
                                                <i class="fas fa-clock me-1"></i>{{ $blog->created_at->format('h:i A') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                               class="btn btn-sm btn-outline-primary border-end-0"
                                               data-bs-toggle="tooltip"
                                               title="Edit Blog">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.show', $blog->id) }}"
                                               class="btn btn-sm btn-outline-dark border-end-0"
                                               data-bs-toggle="tooltip"
                                               title="View Blog on admin panel">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.blog.delete', $blog->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-bs-toggle="tooltip"
                                                        onclick="return confirm('Are you sure you want to delete this blog?');"
                                                        title="Delete Blog">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('blog-details', ['slug' => Str::slug($blog->slug)]) }}"
                                               class="btn btn-sm btn-outline-info border-end-0"
                                               data-bs-toggle="tooltip"
                                               title="View Blog on Site"
                                               target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Footer -->
            <div class="card-footer bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="select-all-bottom">
                            <label class="form-check-label text-muted" for="select-all-bottom">
                                Select All
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" id="bulk-delete-btn-bottom" class="btn btn-danger btn-sm" disabled>
                            <i class="fas fa-trash-alt me-1"></i>Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </form>
</div>

<!-- Quick Actions Modal -->
<div class="modal fade" id="quickActionsModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>New Blog
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i>Export
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-cog me-2"></i>Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Styles for Blog Management */
    .blog-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .blog-thumbnail {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .blog-thumbnail:hover {
        transform: scale(1.1);
        border-color: var(--primary-color);
    }

    .blog-image-wrapper {
        position: relative;
        display: inline-block;
    }

    .image-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(67, 97, 238, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .blog-image-wrapper:hover .image-hover-overlay {
        opacity: 1;
    }

    .no-image-placeholder {
        border: 2px dashed #dee2e6;
        color: #adb5bd;
    }

    .bulk-actions-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .badge-category {
        transition: all 0.3s ease;
    }

    .badge-category:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-group .btn {
        border-radius: 0.25rem !important;
        margin: 0 1px;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem !important;
        border-bottom-left-radius: 0.375rem !important;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem !important;
        border-bottom-right-radius: 0.375rem !important;
    }

    .delete-btn:hover {
        background-color: #dc3545;
        color: white !important;
    }

    .empty-state-icon {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Select all functionality
        function setupSelectAll() {
            const checkboxes = $('.row-checkbox');
            const selectAll = $('#select-all');
            const selectAllFooter = $('#select-all-footer');
            const selectAllBottom = $('#select-all-bottom');
            const bulkDeleteBtn = $('#bulk-delete-btn');
            const bulkDeleteBtnBottom = $('#bulk-delete-btn-bottom');

            function updateBulkButtons() {
                const checkedCount = checkboxes.filter(':checked').length;
                if (checkedCount > 0) {
                    bulkDeleteBtn.text(`Delete Selected (${checkedCount})`).prop('disabled', false);
                    bulkDeleteBtnBottom.text(`Delete (${checkedCount})`).prop('disabled', false);
                } else {
                    bulkDeleteBtn.text('Delete Selected').prop('disabled', true);
                    bulkDeleteBtnBottom.text('Delete Selected').prop('disabled', true);
                }
            }

            function updateSelectAll() {
                const allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                selectAll.prop('checked', allChecked);
                selectAllFooter.prop('checked', allChecked);
                selectAllBottom.prop('checked', allChecked);
                updateBulkButtons();
            }

            // Select All (Top)
            selectAll.on('click', function() {
                const isChecked = $(this).prop('checked');
                checkboxes.prop('checked', isChecked);
                selectAllFooter.prop('checked', isChecked);
                selectAllBottom.prop('checked', isChecked);
                updateBulkButtons();
            });

            // Select All (Footer)
            selectAllFooter.on('click', function() {
                const isChecked = $(this).prop('checked');
                checkboxes.prop('checked', isChecked);
                selectAll.prop('checked', isChecked);
                selectAllBottom.prop('checked', isChecked);
                updateBulkButtons();
            });

            // Select All (Bottom)
            selectAllBottom.on('click', function() {
                const isChecked = $(this).prop('checked');
                checkboxes.prop('checked', isChecked);
                selectAll.prop('checked', isChecked);
                selectAllFooter.prop('checked', isChecked);
                updateBulkButtons();
            });

            // Individual checkbox change
            checkboxes.on('change', updateSelectAll);

            // Row click to select (except action buttons)
            $('#SearchTable tbody').on('click', 'tr', function(e) {
                if (!$(e.target).is('a, button, .btn, .form-check-input, .blog-thumbnail, .image-hover-overlay')) {
                    const checkbox = $(this).find('.row-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    checkbox.trigger('change');
                }
            });

            // Initialize
            updateSelectAll();
        }

        setupSelectAll();

        // Bulk delete confirmation
        $('#bulkDeleteForm').on('submit', function(e) {
            const checkedCount = $('.row-checkbox:checked').length;

            if (checkedCount === 0) {
                e.preventDefault();
                showNotification('Please select at least one blog to delete.', 'warning');
                return false;
            }

            return confirm(`Are you sure you want to delete ${checkedCount} selected blog(s)?`);
        });

        // Individual delete confirmation
        $(document).on('submit', 'form[action*="delete"]', function(e) {
            if (!confirm('Are you sure you want to delete this blog?')) {
                e.preventDefault();
            }
        });

        // Quick actions button
        $('#quickActionsBtn').on('click', function() {
            $('#quickActionsModal').modal('show');
        });

        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification
            const alertClass = type === 'success' ? 'alert-success' :
                             type === 'error' ? 'alert-danger' :
                             type === 'warning' ? 'alert-warning' : 'alert-info';

            const icon = type === 'success' ? 'check-circle' :
                        type === 'error' ? 'exclamation-circle' :
                        type === 'warning' ? 'exclamation-triangle' : 'info-circle';

            const notification = $(`
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed shadow-lg"
                     style="top: 20px; right: 20px; z-index: 1060; min-width: 300px; max-width: 400px;"
                     role="alert">
                    <div class="d-flex">
                        <i class="fas fa-${icon} me-3 fs-4"></i>
                        <div class="flex-grow-1">
                            <p class="mb-0">${message}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            `);

            // Add to body
            $('body').append(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.alert('close');
            }, 5000);
        }
    });
</script>
@endpush
