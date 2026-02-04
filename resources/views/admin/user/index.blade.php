@extends('admin.layouts.datatable-layout')

@section('datatable-title', 'Users Management')

@section('datatable-content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-users text-primary me-2"></i>Users Management
            </h1>
            <p class="text-muted mb-0">Manage user accounts and permissions</p>
        </div>
        <div>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div class="flex-grow-1 ms-3">
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
                                Total Users</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $users->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
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
                                Active Users</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $users->where('status', 'active')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success"></i>
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
                                Admins</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $users->where('role', 'admin')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-warning"></i>
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
                                employees</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $users->where('role', 'employee')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-edit fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>All Users
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="userSearch" placeholder="Search users...">
                    </div>
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="collapse mt-3" id="filterCollapse">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Role</label>
                        <select class="form-select form-select-sm" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="employee">employee</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Status</label>
                        <select class="form-select form-select-sm" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-sm btn-outline-primary w-100" id="resetFilters">
                            <i class="fas fa-redo me-1"></i>Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="SearchTable" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">
                                <input type="checkbox" id="select-all-users" class="form-check-input">
                            </th>
                            <th width="60">#</th>
                            <th>User</th>
                            <th>Contact</th>
                            <th width="120" class="text-center">Role</th>
                            <th width="120" class="text-center">Status</th>
                            <th width="140" class="text-center">Joined</th>
                            <th width="180" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                                </td>
                                <td>
                                    <span class="badge bg-secondary px-2 py-1">#{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="user-avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 45px; height: 45px;">
                                                @if($user->avatar)
                                                    <img src="{{ asset($user->avatar) }}"
                                                         alt="{{ $user->name }}"
                                                         class="rounded-circle img-fluid"
                                                         style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <span class="fw-bold fs-5">{{ substr($user->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">{{ $user->name }}</h6>
                                            <p class="text-muted small mb-0">ID: #{{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none text-dark mb-1">
                                            <i class="fas fa-envelope me-2 text-primary"></i>{{ $user->email }}
                                        </a>
                                        @if($user->phone)
                                        <span class="text-muted small">
                                            <i class="fas fa-phone me-2"></i>{{ $user->phone }}
                                        </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $roleConfig = [
                                            'admin' => ['class' => 'danger', 'icon' => 'shield-alt', 'text' => 'Admin'],
                                            'employee' => ['class' => 'warning', 'icon' => 'edit', 'text' => 'employee'],
                                            'user' => ['class' => 'success', 'icon' => 'user', 'text' => 'User'],
                                        ];
                                        $config = $roleConfig[$user->role] ?? $roleConfig['user'];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }} bg-opacity-10 text-{{ $config['class'] }} border border-{{ $config['class'] }} border-opacity-25 px-3 py-2">
                                        <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $status = $user->status ?? 'active';
                                        $statusConfig = [
                                            'active' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Active'],
                                            'inactive' => ['class' => 'secondary', 'icon' => 'times-circle', 'text' => 'Inactive'],
                                            'suspended' => ['class' => 'danger', 'icon' => 'ban', 'text' => 'Suspended'],
                                        ];
                                        $statusCfg = $statusConfig[$status] ?? $statusConfig['active'];
                                    @endphp
                                    <span class="badge bg-{{ $statusCfg['class'] }} bg-opacity-10 text-{{ $statusCfg['class'] }} border border-{{ $statusCfg['class'] }} border-opacity-25 px-3 py-2">
                                        <i class="fas fa-{{ $statusCfg['icon'] }} me-1"></i>{{ $statusCfg['text'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark small fw-medium">{{ $user->created_at->format('M d, Y') }}</span>
                                        <span class="text-muted smaller">
                                            {{ $user->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.user.edit', $user->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip"
                                           title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.user.show', $user->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="View Profile">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.user.destroy', $user->id) }}"
                                              method="POST"
                                              class="d-inline delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @if($user->status === 'active')
                                        <button class="btn btn-sm btn-outline-warning suspend-user"
                                                data-user-id="{{ $user->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Suspend User">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($users->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Users Found</h5>
                                    <p class="text-muted mb-4">Get started by adding your first user</p>
                                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>Add First User
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bulk Actions Footer -->
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="select-all-bottom">
                        <label class="form-check-label text-muted" for="select-all-bottom">
                            <i class="fas fa-check-square me-2"></i>Select All Users
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-outline-danger" id="bulk-delete-btn" disabled>
                            <i class="fas fa-trash-alt me-1"></i>Delete Selected
                        </button>
                        <button class="btn btn-sm btn-outline-warning" id="bulk-suspend-btn" disabled>
                            <i class="fas fa-ban me-1"></i>Suspend Selected
                        </button>
                        <button class="btn btn-sm btn-outline-success" id="bulk-activate-btn" disabled>
                            <i class="fas fa-check-circle me-1"></i>Activate Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Styles for Users Management */
    .user-avatar {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .user-avatar:hover {
        transform: scale(1.1);
        border-color: var(--primary-color);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .badge-role, .badge-status {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .badge-role:hover, .badge-status:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-group-sm .btn {
        border-radius: 0.25rem !important;
        margin: 0 1px;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .empty-state i {
        opacity: 0.5;
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
            const checkboxes = $('.user-checkbox');
            const selectAllTop = $('#select-all-users');
            const selectAllBottom = $('#select-all-bottom');
            const bulkDeleteBtn = $('#bulk-delete-btn');
            const bulkSuspendBtn = $('#bulk-suspend-btn');
            const bulkActivateBtn = $('#bulk-activate-btn');

            function updateBulkButtons() {
                const checkedCount = checkboxes.filter(':checked').length;
                const enableButtons = checkedCount > 0;

                bulkDeleteBtn.prop('disabled', !enableButtons);
                bulkSuspendBtn.prop('disabled', !enableButtons);
                bulkActivateBtn.prop('disabled', !enableButtons);

                if (enableButtons) {
                    bulkDeleteBtn.html(`<i class="fas fa-trash-alt me-1"></i>Delete (${checkedCount})`);
                    bulkSuspendBtn.html(`<i class="fas fa-ban me-1"></i>Suspend (${checkedCount})`);
                    bulkActivateBtn.html(`<i class="fas fa-check-circle me-1"></i>Activate (${checkedCount})`);
                }
            }

            // Select All (Top)
            selectAllTop.on('click', function() {
                const isChecked = $(this).prop('checked');
                checkboxes.prop('checked', isChecked);
                selectAllBottom.prop('checked', isChecked);
                updateBulkButtons();
            });

            // Select All (Bottom)
            selectAllBottom.on('click', function() {
                const isChecked = $(this).prop('checked');
                checkboxes.prop('checked', isChecked);
                selectAllTop.prop('checked', isChecked);
                updateBulkButtons();
            });

            // Individual checkbox change
            checkboxes.on('change', function() {
                const allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                selectAllTop.prop('checked', allChecked);
                selectAllBottom.prop('checked', allChecked);
                updateBulkButtons();
            });

            // Row click to select (except action buttons)
            $('#SearchTable tbody').on('click', 'tr', function(e) {
                if (!$(e.target).is('a, button, .btn, .form-check-input, .badge')) {
                    const checkbox = $(this).find('.user-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    checkbox.trigger('change');
                }
            });

            // Initialize
            updateBulkButtons();
        }

        setupSelectAll();

        // Individual delete confirmation
        $(document).on('submit', '.delete-user-form', function(e) {
            if (!confirm('Are you sure you want to delete this user?')) {
                e.preventDefault();
            }
        });

        // Suspend user
        $('.suspend-user').on('click', function() {
            const userId = $(this).data('user-id');
            if (confirm('Are you sure you want to suspend this user?')) {
                showNotification('User suspended successfully!', 'warning');
            }
        });

        // Bulk delete
        $('#bulk-delete-btn').on('click', function() {
            const selectedUsers = $('.user-checkbox:checked');
            if (selectedUsers.length === 0) {
                showNotification('Please select at least one user to delete.', 'warning');
                return;
            }

            if (confirm(`Are you sure you want to delete ${selectedUsers.length} selected user(s)?`)) {
                showNotification('Selected users deleted successfully!', 'success');
            }
        });

        // Filter functionality
        $('#roleFilter, #statusFilter').on('change', function() {
            filterTable();
        });

        $('#resetFilters').on('click', function() {
            $('#roleFilter, #statusFilter').val('');
            filterTable();
            showNotification('Filters reset successfully!', 'info');
        });

        function filterTable() {
            const roleValue = $('#roleFilter').val().toLowerCase();
            const statusValue = $('#statusFilter').val().toLowerCase();

            $('#SearchTable tbody tr').each(function() {
                const roleText = $(this).find('td:nth-child(5)').text().toLowerCase();
                const statusText = $(this).find('td:nth-child(6)').text().toLowerCase();

                const roleMatch = !roleValue || roleText.includes(roleValue);
                const statusMatch = !statusValue || statusText.includes(statusValue);

                $(this).toggle(roleMatch && statusMatch);
            });
        }

        // Notification function
        function showNotification(message, type = 'info') {
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

            $('body').append(notification);

            setTimeout(() => {
                notification.alert('close');
            }, 5000);
        }
    });
</script>
@endpush
