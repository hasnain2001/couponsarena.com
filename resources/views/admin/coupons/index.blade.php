@extends('admin.layouts.datatable-layout')

@section('datatable-title', 'Coupons Management')

@push('styles')
<style>
    /* Drag and Drop Styles */
    .drag-handle {
        cursor: move;
        color: #adb5bd;
        font-size: 1.1rem;
        transition: all 0.2s ease;
        padding: 5px;
        border-radius: 4px;
    }

    .drag-handle:hover {
        color: #4361ee;
        background-color: rgba(67, 97, 238, 0.1);
        transform: scale(1.2);
    }

    .row1 {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .row1:hover {
        background-color: rgba(67, 97, 238, 0.05);
        border-left-color: #4361ee;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .row1.ui-sortable-helper {
        background-color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        z-index: 9999 !important;
    }

    .ui-sortable-placeholder {
        visibility: visible !important;
        background: linear-gradient(45deg, rgba(67, 97, 238, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
        border: 2px dashed #4361ee !important;
        border-radius: 8px;
        height: 60px !important;
        margin: 4px 0;
    }

    /* Table styling for better drag and drop */
    .cursor-move {
        cursor: move;
    }

    /* Status badges styling */
    .badge-status {
        padding: 0.35em 0.65em;
        border-radius: 50px;
        font-size: 0.75em;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 70px;
    }

    .badge-status.active {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }

    .badge-status.inactive {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.2);
    }

    /* Loading indicator for drag and drop */
    .sort-loading {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        background: #4361ee;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    /* Store filter card */
    .store-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
    }

    /* Page header styling */
    .page-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border-left: 5px solid #4361ee;
    }
</style>
@endpush

@section('datatable-content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-ticket-alt text-primary me-2"></i>Coupons Management
                </h1>
                <p class="text-muted mb-0">Drag rows to reorder • Manage all coupons in your system</p>
            </div>
            <div>
                <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Add New Coupon
                </a>
            </div>
        </div>

        <!-- Store Filter Card -->
        <div class="store-filter mb-4">
            <h6 class="text-white mb-3">
                <i class="fas fa-filter me-2"></i>Filter by Store
            </h6>
            <form method="GET" action="{{ route('admin.coupon.index') }}">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <select class="form-select form-select-lg" name="store_id" id="category-select" onchange="this.form.submit()">
                            <option value="">All Stores</option>
                            @foreach($couponstore as $coupon)
                                <option value="{{ $coupon->store_id }}" {{ $selectedCoupon == $coupon->store_id ? 'selected' : '' }}>
                                    {{ $coupon->stores->name ?? $coupon->store }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge bg-light text-dark px-3 py-2">
                            <i class="fas fa-store me-1"></i>
                            {{ $coupons->count() }} Coupons
                        </span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Bulk Actions -->
        <form id="bulk-delete-form" action="{{ route('admin.coupon.deleteSelected') }}" method="POST">
            @csrf
            <div class="bulk-actions mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all">
                            <label class="form-check-label fw-bold" for="select-all">
                                Select All
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" id="bulk-delete-btn" class="btn btn-danger" disabled>
                            <i class="fas fa-trash-alt me-2"></i>Delete Selected
                        </button>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="SearchTable" class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">
                                        <input type="checkbox" id="select-all-footer" class="form-check-input">
                                    </th>
                                    <th width="60">ID</th>
                                    <th width="50" class="text-center">
                                        <i class="fas fa-grip-vertical drag-handle-header"></i>
                                    </th>
                                    <th>Coupon Name</th>
                                    <th>Store</th>
                                    <th width="100" class="text-center">Type</th>
                                    <th width="100" class="text-center">Status</th>
                                    <th width="160">Created At</th>
                                    <th width="160">Last Updated</th>
                                    <th width="140" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($coupons as $coupon)
                                    <tr class="row1 align-middle" data-id="{{ $coupon->id }}">
                                        <td class="text-center">
                                            <input type="checkbox" name="selected_coupons[]" value="{{ $coupon->id }}"
                                                class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">#{{ $coupon->id }}</span>
                                        </td>
                                        <td class="text-center text-muted">
                                            <i class="fas fa-grip-vertical drag-handle cursor-move"></i>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="fas fa-ticket-alt text-primary"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $coupon->name }}</strong>
                                                    @if($coupon->code)
                                                    <div class="text-muted small">Code: {{ $coupon->code }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1">
                                                <i class="fas fa-store me-1"></i>{{ $coupon->stores->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($coupon->code)
                                                <span class="badge-status bg-primary text-white">
                                                    <i class="fas fa-code me-1"></i>Code
                                                </span>
                                            @else
                                                <span class="badge-status bg-success text-white">
                                                    <i class="fas fa-percent me-1"></i>Deal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($coupon->status == "disable")
                                                <span class="badge-status inactive">
                                                    <i class="fas fa-times-circle me-1"></i>Disabled
                                                </span>
                                            @else
                                                <span class="badge-status active">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">{{ $coupon->created_at->format('M d, Y') }}</span>
                                                <span class="text-muted smaller">
                                                    <i class="fas fa-clock me-1"></i>{{ $coupon->created_at->format('h:i A') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">{{ $coupon->updated_at->format('M d, Y') }}</span>
                                                <span class="text-muted smaller">
                                                    <i class="fas fa-clock me-1"></i>{{ $coupon->updated_at->format('h:i A') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="tooltip"
                                                title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.coupon.delete', $coupon->id) }}"
                                                onclick="return confirm('Are you sure you want to delete this coupon?')"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Delete">
                                                    <i class="fas fa-trash"></i>
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
                <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">
                            Showing {{ $coupons->count() }} entries
                        </span>
                    </div>
                    <div>
                        <button type="submit" id="bulk-delete-btn-bottom" class="btn btn-danger btn-sm" disabled>
                            <i class="fas fa-trash-alt me-1"></i>Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize drag and drop functionality
        $("#tablecontents").sortable({
            items: "tr.row1",
            handle: ".drag-handle",
            placeholder: "ui-sortable-placeholder",
            axis: "y",
            cursor: "move",
            opacity: 0.8,
            helper: function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                $helper.addClass('ui-sortable-helper');
                return $helper;
            },
            start: function(e, ui) {
                ui.placeholder.height(ui.item.height());
                ui.placeholder.css('visibility', 'visible');
            },
            update: function(event, ui) {
                sendOrderToServer();
            }
        }).disableSelection();

        // Function to send order to server
        function sendOrderToServer() {
            var order = [];
            var token = '{{ csrf_token() }}';

            $('#tablecontents tr.row1').each(function(index, element) {
                order.push({
                    id: $(this).data("id"),
                    position: index + 1
                });
            });

            // Show loading indicator
            const loadingToast = $(`
                <div class="sort-loading" id="sort-loading-indicator">
                    <i class="fas fa-spinner fa-spin"></i>
                    Saving new order...
                </div>
            `).appendTo('body');

            $.ajax({
                url: "{{ route('admin.coupon.reorder') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    order: order,
                    _token: token
                },
                success: function(response) {
                    // Remove loading indicator
                    $('#sort-loading-indicator').remove();

                    // Show success message
                    if (response.status === "success") {
                        showToast('success', response.message || 'Order updated successfully!');

                        // Update ID numbers in table (optional)
                        updateTableNumbers();
                    } else {
                        showToast('error', response.message || 'Failed to update order.');
                    }
                },
                error: function(xhr, status, error) {
                    // Remove loading indicator
                    $('#sort-loading-indicator').remove();

                    console.error("Error updating order:", error);
                    showToast('error', 'Error while updating order. Please try again.');

                    // Reload page to sync with server state
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        }

        // Function to update table numbers after reorder
        function updateTableNumbers() {
            $('#tablecontents tr.row1').each(function(index) {
                $(this).find('td:nth-child(2) .badge').text('#' + (index + 1));
            });
        }

        // Toast notification function
        function showToast(type, message) {
            // Remove any existing toast
            $('.custom-toast').remove();

            const toastClass = type === 'success' ? 'bg-success' : 'bg-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const toast = $(`
                <div class="custom-toast position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
                    <div class="toast align-items-center text-white ${toastClass} border-0 show" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas ${icon} me-2"></i>${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
            `).appendTo('body');

            // Auto remove after 3 seconds
            setTimeout(function() {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Select All Checkbox functionality
        function updateBulkDeleteButtons() {
            const checkedCount = $('input.row-checkbox:checked').length;
            const anyChecked = checkedCount > 0;

            $('#bulk-delete-btn').prop('disabled', !anyChecked);
            $('#bulk-delete-btn-bottom').prop('disabled', !anyChecked);

            if (anyChecked) {
                $('#bulk-delete-btn').html(`<i class="fas fa-trash-alt me-2"></i>Delete Selected (${checkedCount})`);
                $('#bulk-delete-btn-bottom').html(`<i class="fas fa-trash-alt me-1"></i>Delete (${checkedCount})`);
            } else {
                $('#bulk-delete-btn').html('<i class="fas fa-trash-alt me-2"></i>Delete Selected');
                $('#bulk-delete-btn-bottom').html('<i class="fas fa-trash-alt me-1"></i>Delete Selected');
            }
        }

        // Select All checkboxes
        $('#select-all, #select-all-footer').on('change', function() {
            const isChecked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', isChecked);
            updateBulkDeleteButtons();
        });

        // Individual checkbox change
        $(document).on('change', '.row-checkbox', function() {
            const totalCheckboxes = $('.row-checkbox').length;
            const checkedCount = $('.row-checkbox:checked').length;

            $('#select-all').prop('checked', checkedCount === totalCheckboxes);
            $('#select-all-footer').prop('checked', checkedCount === totalCheckboxes);

            updateBulkDeleteButtons();
        });

        // Row click to select checkbox (excluding drag handle and action buttons)
        $('#tablecontents').on('click', 'tr.row1', function(e) {
            if (!$(e.target).closest('.drag-handle, .btn-group, a, button').length) {
                const checkbox = $(this).find('.row-checkbox');
                checkbox.prop('checked', !checkbox.prop('checked'));
                checkbox.trigger('change');
            }
        });

        // Confirm delete for bulk action
        $('#bulk-delete-form').on('submit', function(e) {
            const selectedCount = $('input.row-checkbox:checked').length;

            if (selectedCount === 0) {
                e.preventDefault();
                showToast('warning', 'Please select at least one coupon to delete.');
                return false;
            }

            if (!confirm(`Are you sure you want to delete ${selectedCount} selected coupon(s)?`)) {
                e.preventDefault();
                return false;
            }
        });

        // Confirm delete for single item
        $('.btn-outline-danger').on('click', function(e) {
            if (!confirm('Are you sure you want to delete this coupon?')) {
                e.preventDefault();
            }
        });

        // Initialize all tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Show instructions for drag and drop
        $(document).ready(function() {
            if ($('#tablecontents tr.row1').length > 1) {
                showToast('info', 'Drag the grip icon to reorder coupons');
            }
        });
    });
</script>

<!-- Add CSS for custom toast -->
<style>
    .custom-toast .toast {
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        min-width: 300px;
    }

    .toast-body {
        padding: 1rem;
    }

    .drag-handle-header {
        color: #adb5bd;
        font-size: 1.1rem;
    }

    /* Animation for row reorder */
    @keyframes highlightRow {
        0% { background-color: rgba(67, 97, 238, 0.1); }
        100% { background-color: transparent; }
    }

    .row-highlight {
        animation: highlightRow 1s ease;
    }
</style>
@endpush
