<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - @yield('datatable-title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- DataTables + Responsive -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/admin-styles.css') }}">

    <!-- Page-specific styles -->
    @stack('styles')

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --sidebar-bg: #1a1a2e;
            --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .drag-handle { cursor: move; color: #adb5bd; font-size: 1.3em; }
        .drag-handle:hover { color: var(--primary-color); transform: scale(1.2); }
        .sortable-row:hover { background: rgba(67, 97, 238, 0.05); }
        .ui-sortable-placeholder { background: #e3f2fd !important; border: 3px dashed var(--primary-color); visibility: visible !important; }
        .store-header-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; }
        .store-image-lg { width: 80px; height: 80px; object-fit: cover; border: 4px solid rgba(255,255,255,0.3); }
        .badge-status { padding: 0.5em 1em; border-radius: 50px; font-weight: 600; font-size: 0.85em; }
    </style>
</head>
<body class="admin-body">

<div class="container-fluid">
    <!-- Navigation -->
    <header>@include('admin.layouts.navigation')</header>

    <div class="row">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4 py-4">
            <div class="content-wrapper">
                @yield('datatable-content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="admin-footer mt-auto py-3 border-top">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <strong>Copyright © {{ date('Y') }} <a href="#" class="text-primary">CouponsArena</a>.</strong> All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="text-muted">Version 3.2.0</span>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Core Scripts (Loaded ONCE and in correct order) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom Admin JS -->
<script src="{{ asset('admin/js/admin-scripts.js') }}"></script>

<!-- Page-specific scripts -->
@stack('scripts')
@stack('scripts')

</body>
</html>
