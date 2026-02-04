@extends('admin.layouts.datatable-layout')
@section('datatable-title', 'Coupons - ' . $store->name)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #eef2ff;
        --success: #06d6a0;
        --success-light: #d8f3ea;
        --danger: #ef476f;
        --danger-light: #fde8ee;
        --warning: #ffd166;
        --warning-light: #fff6e0;
        --dark: #2b2d42;
        --light: #f8f9fa;
        --border-color: #e0e0e0;
        --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .drag-handle {
        cursor: move;
        color: #adb5bd;
        font-size: 1.3em;
        transition: all 0.2s;
    }
    .drag-handle:hover { color: var(--primary); transform: scale(1.2); }

    .sortable-row {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .sortable-row:hover {
        background: rgba(67, 97, 238, 0.05);
        border-left-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .sortable-row.ui-sortable-helper {
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border-radius: 8px;
    }
    .ui-sortable-placeholder {
        background: #e3f2fd !important;
        border: 3px dashed var(--primary);
        visibility: visible !important;
        border-radius: 8px;
        height: 60px !important;
    }

    .store-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
    }
    .store-image-lg {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.3);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .badge-status {
        padding: 0.5em 1em;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85em;
    }
    .table th {
        background: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8em;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
    }

    /* Fix for sortable placeholder */
    .ui-sortable-placeholder {
        visibility: visible !important;
        background: #e3f2fd !important;
        border: 2px dashed #4361ee !important;
        border-radius: 8px;
        margin: 4px 0;
    }

    /* Enhanced Modal Styling */
    .coupon-modal .modal-dialog {
        max-width: 900px;
    }

    .coupon-modal .modal-content {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .coupon-modal .modal-header {
        background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
        border-bottom: none;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .coupon-modal .modal-header:before {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .coupon-modal .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .coupon-modal .modal-title i {
        font-size: 1.8rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .coupon-modal .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .coupon-modal .btn-close:hover {
        opacity: 1;
    }

    .coupon-modal .card {
        border: 1px solid var(--border-color);
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .coupon-modal .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .coupon-modal .card-header {
        background: var(--primary-light);
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        border-radius: 15px 15px 0 0 !important;
    }

    .coupon-modal .card-title {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .coupon-modal .card-title i {
        font-size: 1.2rem;
    }

    .coupon-modal .card-body {
        padding: 1.5rem;
    }

    .coupon-modal .form-section {
        margin-bottom: 1.75rem;
    }

    .coupon-modal .form-section:last-child {
        margin-bottom: 0;
    }

    .coupon-modal .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .coupon-modal .form-label.required-field:after {
        content: '*';
        color: var(--danger);
        margin-left: 4px;
    }

    .coupon-modal .form-control,
    .coupon-modal .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .coupon-modal .form-control:focus,
    .coupon-modal .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }

    .coupon-modal .form-control:hover,
    .coupon-modal .form-select:hover {
        border-color: #b0b7d0;
    }

    /* Switch Styling */
    .switch-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 1rem;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--success);
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

    .switch-label {
        font-weight: 500;
        color: #495057;
        font-size: 0.95rem;
    }

    /* Radio Group Styling */
    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 0.5rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .radio-option input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
    }

    .radio-option label {
        font-weight: 500;
        color: #495057;
        cursor: pointer;
        font-size: 0.95rem;
    }

    /* Top Coupons Styling */
    .top-coupons-group {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 8px;
        margin-top: 0.5rem;
    }

    .top-coupon-option {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .top-coupon-option input[type="radio"] {
        display: none;
    }

    .top-coupon-option label {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .top-coupon-option input[type="radio"]:checked + label {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: scale(1.1);
    }

    .top-coupon-option label:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    /* Form Actions */
    .form-actions {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0 0 15px 15px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn-modal {
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-modal-primary {
        background: var(--primary);
        border: 2px solid var(--primary);
        color: white;
    }

    .btn-modal-primary:hover {
        background: #3a56d4;
        border-color: #3a56d4;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
    }

    .btn-modal-secondary {
        background: white;
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-modal-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        transform: translateY(-2px);
    }

    /* Success Message Styling */
    .alert-success {
        background: var(--success-light);
        border: none;
        border-left: 4px solid var(--success);
        border-radius: 10px;
        color: #0a3622;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 15px rgba(6, 214, 160, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .coupon-modal .modal-dialog {
            margin: 1rem;
        }

        .top-coupons-group {
            grid-template-columns: repeat(4, 1fr);
        }

        .radio-group {
            flex-direction: column;
            gap: 10px;
        }
    }

    /* Date Input Styling */
    .date-input-group {
        position: relative;
    }

    .date-input-group i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    /* Store Selection Highlight */
    .store-option-highlight {
        background: var(--primary-light);
        padding: 8px 12px;
        border-radius: 8px;
        border: 2px solid var(--primary);
        margin-bottom: 10px;
    }
</style>
@endpush

@section('datatable-content')
<div class="content-wrapper pb-5">
    <!-- Store Header Card -->
    <div class="container-fluid mb-4">
        <div class="card store-header-card shadow-lg border-0">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap align-items-center gap-4 text-white">
                    <img src="{{ $store->store_image ? asset('uploads/stores/' . $store->store_image) : asset('front/assets/images/no-image-found.jpg') }}"
                         alt="{{ $store->name }}" class="rounded-circle store-image-lg shadow">

                    <div class="flex-grow-1">
                        <h2 class="mb-1 fw-bold">{{ $store->name }}</h2>
                        <div class="d-flex flex-wrap gap-3 small opacity-90">
                            <span><i class="fas fa-globe me-2"></i>{{ $store->language->name ?? 'N/A' }}</span>
                            <span><i class="fas fa-sitemap me-2"></i>{{ $store->networks->title ?? 'N/A' }}</span>
                            <span><i class="fas fa-tag me-2"></i>{{ $store->categories->title ?? 'N/A' }}</span>
                            <span><i class="fas fa-calendar me-2"></i>{{ $store->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.store.edit', $store->id) }}" class="btn btn-light btn-lg shadow-sm">
                            <i class="fas fa-edit me-2"></i>Edit Store
                        </a>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('store_details', ['slug' => Str::slug($store->slug)]) }}" target="_blank" class="btn btn-light btn-lg shadow-sm">
                           <i class="fa fa-eye" aria-hidden="true"></i> View Store
                        </a>
                    </div>
                    <div class="text-end">
                        <form action="{{ route('admin.store.delete', $store->id) }}" method="GET" onsubmit="return confirm('Are you sure you want to delete this store? This action cannot be undone.');">
                        @csrf
                        @method('DELETE') 
                        <button type="submit" class="btn btn-light btn-lg shadow-sm">
                        <i class="fas fa-trash me-2"></i>Delete Store
                        </button>

                       </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Coupons ({{ $coupons->count() }})</h3>
                <p class="text-muted mb-0">Drag rows using the drag icon to reorder</p>
            </div>
            <button class="btn btn-primary btn-lg shadow" data-bs-toggle="modal" data-bs-target="#couponModal">
                <i class="fas fa-plus me-2"></i>Add New Coupon
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Coupons Table -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <form id="bulk-delete-form" action="{{ route('admin.coupon.deleteSelected') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="coupons-table">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="select-all" class="form-check-input rounded">
                                    </th>
                                    <th width="60">#</th>
                                    <th width="50"></th> <!-- Drag Handle -->
                                    <th>Coupon Name</th>
                                    <th>Type</th>
                                    <th>Code/Deal</th>
                                    <th>Status</th>
                                    <th>Expires</th>
                                    <th>Created</th>
                                    <th width="140" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @forelse($coupons as $index => $coupon)
                                <tr class="sortable-row" data-id="{{ $coupon->id }}">
                                    <td>
                                        <input type="checkbox" name="selected_coupons[]" value="{{ $coupon->id }}" class="form-check-input">
                                    </td>
                                    <td><strong class="text-primary">{{ $index + 1 }}</strong></td>
                                    <td class="text-center">
                                        <i class="fas fa-grip-vertical drag-handle"></i>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $coupon->name }}</div>
                                        <small class="text-muted">{{ Str::limit($coupon->description, 60) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $coupon->code ? 'info' : 'success' }} badge-status">
                                            {{ $coupon->code ? 'CODE' : 'DEAL' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($coupon->code)
                                            <code class="bg-dark text-white px-3 py-2 rounded">{{ $coupon->code }}</code>
                                        @else
                                            <span class="text-success fw-bold">Auto Deal</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $coupon->status == 'enable' ? 'success' : 'secondary' }} badge-status">
                                            {{ ucfirst($coupon->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-danger fw-bold">
                                            {{ \Carbon\Carbon::parse($coupon->ending_date)->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $coupon->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.coupon.delete', $coupon->id) }}"
                                           onclick="return confirm('Delete this coupon?')"
                                           class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-4x mb-3 opacity-50"></i>
                                            <h5>No coupons yet</h5>
                                            <p>Click "Add New Coupon" to get started!</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($coupons->count() > 0)
                    <div class="card-footer bg-white border-top-0">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete selected coupons?')">
                            <i class="fas fa-trash me-2"></i>Delete Selected
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade coupon-modal" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-gift"></i> Create New Coupon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="CreateCoupon" id="CreateCoupon" method="POST" action="{{ route('admin.coupon.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Left Column: Coupon Information -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="fas fa-info-circle"></i> Coupon Information</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Store Info -->
                                    <div class="form-section">
                                        <div class="store-option-highlight">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-store text-primary me-2"></i>
                                                <div>
                                                    <strong>Store:</strong> {{ $store->name }}
                                                    <small class="d-block text-muted">{{ $store->slug }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Coupon Name -->
                                    <div class="form-section">
                                        <label for="name" class="form-label required-field">
                                            <i class="fas fa-tag"></i> Coupon Name
                                        </label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               value="{{ old('name') }}" required
                                               placeholder="e.g., Summer Sale 2024 - 50% Off">
                                    </div>

                                    <!-- Description -->
                                    <div class="form-section">
                                        <label for="description" class="form-label required-field">
                                            <i class="fas fa-align-left"></i> Description
                                        </label>
                                        <textarea name="description" id="description" class="form-control"
                                                  rows="4" style="resize: none;"
                                                  placeholder="Describe this coupon...">{{ old('description') }}</textarea>
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-lightbulb"></i> Tip: Be descriptive to help users understand the offer
                                        </small>
                                    </div>

                                    <!-- Coupon Code Toggle -->
                                    <div class="form-section">
                                        <div class="switch-container">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div>
                                                    <label class="switch">
                                                        <input type="checkbox" id="toggleCodeCheckbox" onchange="toggleCodeInput(this)" {{ old('code') ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <span class="switch-label ms-3">
                                                        <i class="fas fa-key me-1"></i> Add Coupon Code
                                                    </span>
                                                </div>
                                                <span class="badge bg-info">Optional</span>
                                            </div>
                                        </div>
                                        <div id="codeInputGroup" style="display: {{ old('code') ? 'block' : 'none' }}; margin-top: 0.5rem;">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-barcode"></i>
                                                </span>
                                                <input type="text" class="form-control" name="code" id="code"
                                                       value="{{ old('code') }}" placeholder="Enter coupon code (e.g., SUMMER50)">
                                            </div>
                                            <small class="text-muted mt-1 d-block">
                                                <i class="fas fa-info-circle"></i> Leave empty for automatic deals (no code required)
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Expiration Date -->
                                    <div class="form-section">
                                        <label for="ending_date" class="form-label required-field">
                                            <i class="fas fa-calendar-times"></i> Expiration Date
                                        </label>
                                        <div class="date-input-group">
                                            <input type="date" class="form-control" name="ending_date" id="ending_date"
                                                   value="{{ old('ending_date') }}" required>
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Settings -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="fas fa-cogs"></i> Settings</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Store Selection -->
                                    <div class="form-section">
                                        <label for="store_id" class="form-label required-field">
                                            <i class="fas fa-store"></i> Store
                                        </label>
                                        <select name="store_id" id="store_id" class="form-select" required>
                                            <option value="" disabled {{ old('store_id') ? '' : 'selected' }}>-- Select a Store --</option>
                                            @foreach($stores as $couponstore)
                                                <option value="{{ $couponstore->id }}"
                                                    data-language="{{ $couponstore->language_id }}"
                                                    {{ $couponstore->id == $store->id ? 'selected' : (old('store_id') == $couponstore->id ? 'selected' : '') }}>
                                                    {{ $couponstore->name }} <small class="text-muted">({{ $couponstore->slug }})</small>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Language -->
                                    <div class="form-section">
                                        <label for="language_id" class="form-label required-field">
                                            <i class="fas fa-language"></i> Language
                                        </label>
                                        <select name="language_id" id="language_id" class="form-select" required>
                                            <option disabled {{ old('language_id') ? '' : 'selected' }}>-- Select Language --</option>
                                            @foreach ($langs as $lang)
                                                <option value="{{ $lang->id }}" {{ $lang->id == $store->language_id ? 'selected' : (old('language_id') == $lang->id ? 'selected' : '') }}>
                                                    {{ $lang->name }} <small class="text-muted">({{ $lang->code }})</small>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Top Coupons Ranking -->
                                    <div class="form-section">
                                        <label class="form-label required-field">
                                            <i class="fas fa-star"></i> Top Coupons Ranking
                                        </label>
                                        <div class="top-coupons-group">
                                            @for ($i = 0; $i <= 7; $i++)
                                                <div class="top-coupon-option">
                                                    <input type="radio" name="top_coupons" id="top_{{ $i }}"
                                                           value="{{ $i }}" {{ old('top_coupons') == $i ? 'checked' : '' }}>
                                                    <label for="top_{{ $i }}">{{ $i }}</label>
                                                </div>
                                            @endfor
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="fas fa-lightbulb"></i> 0 = Not featured, 7 = Highest priority
                                        </small>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-section">
                                        <label class="form-label required-field">
                                            <i class="fas fa-toggle-on"></i> Status
                                        </label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="status" id="enable" value="enable"
                                                       {{ old('status', 'enable') == 'enable' ? 'checked' : '' }} required>
                                                <label for="enable" class="d-flex align-items-center">
                                                    <span class="status-indicator bg-success me-2"></span>
                                                    <span>Enable</span>
                                                </label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="status" id="disable" value="disable"
                                                       {{ old('status') == 'disable' ? 'checked' : '' }} required>
                                                <label for="disable" class="d-flex align-items-center">
                                                    <span class="status-indicator bg-secondary me-2"></span>
                                                    <span>Disable</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="form-actions mt-4">
                                        <button type="button" class="btn btn-modal btn-modal-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-modal btn-modal-primary">
                                            <i class="fas fa-save"></i> Save Coupon
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize sortable on the tbody
    $("#tablecontents").sortable({
        items: "tr[data-id]",
        handle: ".drag-handle",
        placeholder: "ui-sortable-placeholder",
        axis: "y",
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },
        start: function(e, ui){
            ui.placeholder.height(ui.item.height());
            ui.placeholder.css('visibility', 'visible');
        },
        update: function(event, ui) {
            const order = [];
            $("#tablecontents tr[data-id]").each(function(index) {
                order.push({
                    id: $(this).data('id'),
                    position: index + 1
                });
            });

            // Show loading toast
            const toast = $(`
                <div class="toast align-items-center text-bg-info border-0 position-fixed" style="top:20px;right:20px;z-index:9999;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-spinner fa-spin me-2"></i>Saving order...
                        </div>
                    </div>
                </div>
            `).appendTo('body');
            new bootstrap.Toast(toast[0]).show();

            $.ajax({
                url: "{{ route('admin.coupon.reorder') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order: order
                },
                success: function(response) {
                    if(response.status === 'success') {
                        toast.find('.toast-body').html('<i class="fas fa-check-circle me-2"></i>Order saved successfully!');
                        toast.removeClass('text-bg-info').addClass('text-bg-success');

                        // Update the index numbers
                        $("#tablecontents tr[data-id]").each(function(index) {
                            $(this).find('td:nth-child(2) strong').text(index + 1);
                        });
                    } else {
                        toast.find('.toast-body').html('<i class="fas fa-exclamation-triangle me-2"></i>Failed to save order!');
                        toast.removeClass('text-bg-info').addClass('text-bg-warning');
                    }

                    setTimeout(() => toast.remove(), 3000);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toast.find('.toast-body').html('<i class="fas fa-times-circle me-2"></i>Error saving order!');
                    toast.removeClass('text-bg-info').addClass('text-bg-danger');
                    setTimeout(() => location.reload(), 2000);
                }
            });
        }
    }).disableSelection();

    // Select All Checkbox
    $("#select-all").on('change', function() {
        $("input[name='selected_coupons[]']").prop('checked', this.checked);
    });

    // Handle individual checkbox changes
    $("input[name='selected_coupons[]']").on('change', function() {
        const totalCheckboxes = $("input[name='selected_coupons[]']").length;
        const checkedCheckboxes = $("input[name='selected_coupons[]']:checked").length;
        $("#select-all").prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Auto show modal if session has 'show_modal' flag
    @if(session('show_modal'))
        $(document).ready(function() {
            var couponModal = new bootstrap.Modal(document.getElementById('couponModal'));
            couponModal.show();
        });
    @endif

    // Set today as min date for ending date
    const today = new Date().toISOString().split('T')[0];
    $('#ending_date').attr('min', today);

    // Set default ending date to 30 days from today if empty
    if (!$('#ending_date').val()) {
        const futureDate = new Date();
        futureDate.setDate(futureDate.getDate() + 30);
        const futureDateString = futureDate.toISOString().split('T')[0];
        $('#ending_date').val(futureDateString);
    }

    // Store change event to auto-select language
    $('#store_id').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const languageId = selectedOption.data('language');
        if (languageId) {
            $('#language_id').val(languageId);
        }
    });

    // Toggle code input function
    window.toggleCodeInput = function(checkbox) {
        const codeInputGroup = document.getElementById('codeInputGroup');
        if (checkbox.checked) {
            codeInputGroup.style.display = 'block';
            $('#code').focus();
        } else {
            codeInputGroup.style.display = 'none';
            $('#code').val('');
        }
    };

    // Form validation before submit
    $('#CreateCoupon').on('submit', function(e) {
        let isValid = true;

        // Check required fields
        $(this).find('[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('is-invalid');
                $(this).focus();
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            toastr.error('Please fill in all required fields');
        }
    });

    // Remove invalid class on input
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>

<!-- Add status indicator styling -->
<style>
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endpush
