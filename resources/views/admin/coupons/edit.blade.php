@extends('admin.layouts.master')
@section('title')
    Update Coupon
@endsection
@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Coupon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.coupon.index') }}">Coupons</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form name="UpdateCoupon" id="UpdateCoupon" method="POST" action="{{ route('admin.coupon.update', $coupons->id) }}">
                @csrf
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Coupon Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-section">
                                    <div class="form-group">
                                        <label for="name" class="required-field">Coupon Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $coupons->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" style="resize: none;">{{ $coupons->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="switch-container">
                                        <label class="switch">
                                            <input type="checkbox" id="toggleCodeCheckbox" onchange="toggleCodeInput(this)" {{ $coupons->code ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span class="switch-label">Enable Coupon Code</span>
                                    </div>
                                    <div id="codeInputGroup" style="display: {{ $coupons->code ? 'block' : 'none' }};">
                                        <input type="text" class="form-control" name="code" id="code" value="{{ $coupons->code }}" placeholder="Enter coupon code">
                                    </div>
                                </div>

                                <div class="form-section">
                                    {{-- <div class="form-group">
                                        <label for="destination_url" class="required-field">Destination URL</label>
                                        <input type="url" class="form-control" name="destination_url" id="destination_url" value="{{ $coupons->destination_url }}" required>
                                    </div> --}}

                                    <div class="form-group">
                                        <label for="ending_date" class="required-field">Ending Date</label>
                                        <input type="date" class="form-control" name="ending_date" id="ending_date" value="{{ \Carbon\Carbon::parse($coupons->ending_date)->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Settings</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-section">
                                    <div class="form-group">
                                        <label for="store" class="required-field">Store</label>
                                        <select name="store" id="store" class="form-control" required>
                                            <option value="" disabled>-- Select Store --</option>
                                            @foreach($stores as $store)
                                                <option value="{{ $store->id }}"
                                                    data-language="{{ $store->language_id }}"
                                                    {{ $coupons->stores->id == $store->id ? 'selected' : '' }}>
                                                    {{ $store->name }} ({{ $store->slug }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="language_id" class="required-field">Language</label>
                                        <select name="language_id" id="language_id" class="form-control" required>
                                            <option disabled>-- Select Language --</option>
                                            @foreach ($langs as $lang)
                                                <option value="{{ $lang->id }}" {{ $coupons->language_id == $lang->id ? 'selected' : '' }}>{{ $lang->name }} ({{ $lang->code }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="form-group">
                                        <label class="required-field">Top Coupons Ranking</label>
                                        <div class="top-coupons-group">
                                            @for ($i = 0; $i <= 5; $i++)
                                                <div class="top-coupon-option">
                                                    <input type="radio" name="top_coupons" id="top_{{ $i }}" value="{{ $i }}"
                                                        {{ $coupons->top_coupons == $i ? 'checked' : '' }}>
                                                    <label for="top_{{ $i }}">{{ $i }}</label>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="form-group">
                                        <label class="required-field">Status</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="status" id="enable" value="enable" {{ $coupons->status == 'enable' ? 'checked' : '' }} required>
                                                <label for="enable">Enable</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="status" id="disable" value="disable" {{ $coupons->status == 'disable' ? 'checked' : '' }} required>
                                                <label for="disable">Disable</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i> Update Coupon
                                </button>
                                <a href="{{ route('admin.coupon.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times mr-2"></i> Cancel
                                </a>
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
    /* Base Styles */
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        border: none;
        border-radius: 0.35rem;
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.35rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    label {
        font-weight: 600;
        color: #4e73df;
    }
    .form-control {
        border-radius: 0.35rem;
        border: 1px solid #d1d3e2;
        font-weight: bold;
        color: #333;
    }
    .form-control:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
    }
    .btn-secondary {
        padding: 0.5rem 1.5rem;
        font-weight: 600;
    }
    .required-field::after {
        content: "*";
        color: #e74a3b;
        margin-left: 4px;
    }

    /* Toggle Switch Styles */
    .switch-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
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
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #4e73df;
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    .switch-label {
        font-weight: 600;
        color: #5a5c69;
    }

    /* Radio and Checkbox Groups */
    .radio-group, .top-coupons-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    .radio-option, .top-coupon-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .radio-group, .top-coupons-group {
            gap: 0.75rem;
        }
        .switch-container {
            margin-bottom: 1rem;
        }
    }

    /* Form Layout */
    .form-section {
        margin-bottom: 2rem;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e3e6f0;
    }
</style>
@endpush
@push('scripts')
<script>
    // Toggle coupon code input visibility
    function toggleCodeInput(checkboxElement) {
        const codeInputGroup = document.getElementById('codeInputGroup');
        if (checkboxElement.checked) {
            codeInputGroup.style.display = 'block';
            setTimeout(() => {
                codeInputGroup.style.opacity = '1';
            }, 10);
        } else {
            codeInputGroup.style.opacity = '0';
            setTimeout(() => {
                codeInputGroup.style.display = 'none';
            }, 300);
        }
    }

    // Automatically select language when store is selected
    document.getElementById('store').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const languageId = selectedOption.getAttribute('data-language');

        if (languageId) {
            document.getElementById('language_id').value = languageId;
        }
    });

    // Initialize form based on existing values
    document.addEventListener('DOMContentLoaded', function() {
        // If there's a store selected, trigger the change event to set language
        const storeSelect = document.getElementById('store');
        if (storeSelect.value) {
            storeSelect.dispatchEvent(new Event('change'));
        }

        // If there's a code value, show the code input
        if ("{{ $coupons->code }}") {
            document.getElementById('toggleCodeCheckbox').checked = true;
            document.getElementById('codeInputGroup').style.display = 'block';
        }
    });
</script>
@endpush
