@extends('employee.layouts.datatable_master')
@section('datatable-title')
    Stores Management
@endsection
@section('datatable-content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-store"></i> Stores Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <a href="{{ route('employee.store.create') }}" class="btn btn-dark mr-2">
                                <i class="fas fa-plus-circle mr-1"></i> Add New Store
                            </a>
                            <a href="{{ route('employee.coupon.create') }}" class="btn btn-warning">
                                <i class="fas fa-tag mr-1"></i> Add New Coupon
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card card-dark card-outline">
                            <div class="card-header">
                                <h3 class="card-title">All Stores</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="bulk-delete-form" action="{{ route('employee.store.deleteSelected') }}" method="POST">
                                    @csrf
                                    <div class="table-responsive">
                                        <table id="SearchTable" class="table table-bordered table-hover table-striped">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th width="40px"><input type="checkbox" id="select-all"></th>
                                                    <th width="60px">#</th>
                                                    <th>Store Name</th>
                                                    <th width="80px">Image</th>
                                                    <th>Network</th>
                                                    <th>Category</th>
                                                    <th width="100px">Status</th>
                                                    <th width="160px">Created At</th>
                                                    <th width="160px">Last Updated</th>
                                                    <th width="150px">Actions</th>
                                                    <th width="150px">Coupons</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stores as $store)
                                                    <tr>
                                                        <td><input type="checkbox" name="selected_stores[]" value="{{ $store->id }}"></td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <a href="{{ route('employee.store.edit', $store->id) }}" class="text-dark ">
                                                                {{ $store->name }}
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <img class="img-thumbnail rounded-circle"
                                                                 src="{{ $store->store_image ? asset('uploads/stores/' . $store->store_image) : asset('front/assets/images/no-image-found.jpg') }}"
                                                                 alt="{{ $store->name }}"
                                                                 style="width: 40px; height: 40px; object-fit: cover;"
                                                                 loading="lazy">
                                                        </td>
                                                        <td>
                                                            <span>{{ $store->networks->title ?? '' }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="">{{ $store->categories->title ?? '' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($store->status == "disable")
                                                                <span class="badge bg-danger"><i class="fas fa-times-circle mr-1"></i> Disabled</span>
                                                            @else
                                                                <span class="badge bg-success"><i class="fas fa-check-circle mr-1"></i> Enabled</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <small class="text-muted" data-toggle="tooltip" title="{{ $store->created_at->setTimezone('Asia/Karachi')->format('l, F j, Y h:i A') }}">
                                                                <i class="far fa-calendar-alt mr-1"></i>
                                                                {{ $store->created_at->setTimezone('Asia/Karachi')->format('M d, Y h:i A') }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted" data-toggle="tooltip" title="{{ $store->updated_at->setTimezone('Asia/Karachi')->format('l, F j, Y h:i A') }}">
                                                                <i class="far fa-clock mr-1"></i>
                                                                {{ $store->updated_at->setTimezone('Asia/Karachi')->format('M d, Y h:i A') }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('employee.store.edit', $store->id) }}"
                                                                   class="btn btn-info"
                                                                   data-toggle="tooltip"
                                                                   title="Edit Store">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('employee.store.delete', $store->id) }}"
                                                                   class="btn btn-danger"
                                                                   onclick="return confirm('Are you sure you want to delete this store?')"
                                                                   data-toggle="tooltip"
                                                                   title="Delete Store">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('employee.store.store_details', ['slug' => Str::slug($store->slug)]) }}"
                                                               class="btn btn-success btn-sm"
                                                               data-toggle="tooltip"
                                                               title="Manage Coupons">
                                                                <i class="fas fa-tags mr-1"></i> Coupons
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete the selected stores and their coupons?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete Selected
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        // JavaScript to handle the select all functionality
        document.getElementById('select-all').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('input[name="selected_stores[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });

        document.getElementById('select-all-footer').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('input[name="selected_stores[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
@endpush
