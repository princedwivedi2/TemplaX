<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TemplaX') }} - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #212529;
            --sidebar-color: #fff;
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --body-bg: #f8f9fa;
            --card-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --transition-speed: 0.3s;
            --navbar-height: 56px;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--body-bg);
            overflow-x: hidden;
            padding-top: var(--navbar-height); /* For fixed navbar */
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: var(--navbar-height); /* Below fixed navbar */
            padding: 0;
            z-index: 1030;
            transition: all var(--transition-speed);
            display: flex;
            flex-direction: column;
            height: calc(100vh - var(--navbar-height));
            overflow-y: auto;
        }

        .sidebar .nav-link {
            padding: 0.8rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            transition: all var(--transition-speed);
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
        }

        .nav-header {
            font-size: 0.75rem;
            letter-spacing: 0.05rem;
            font-weight: 700;
            opacity: 0.6;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: calc(100vh - var(--navbar-height));
            transition: all var(--transition-speed);
            background-color: var(--body-bg);
            padding-top: 1rem;
        }

        /* Card Styles */
        .card {
            transition: all var(--transition-speed);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 0;
            }

            .sidebar {
                margin-left: calc(-1 * 250px);
                width: 250px;
            }

            .sidebar.show {
                margin-left: 0;
            }

            /* Add overlay when sidebar is active */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: var(--navbar-height);
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1025;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Offcanvas sidebar for mobile */
        @media (max-width: 767.98px) {
            .sidebar {
                width: 100%;
                max-width: 280px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white sidebar" id="sidebar-wrapper">
            <div class="sidebar-header py-3 px-3 border-bottom border-secondary">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                        <span class="fw-bold">T</span>
                    </div>
                    <h4 class="m-0 text-white">TemplaX</h4>
                </div>
            </div>

            <div class="px-3 py-2">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    @if(!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('super-admin'))
                    <li class="nav-item mt-2">
                        <span class="nav-header text-uppercase text-muted small d-block py-2">Cards</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cards.create') }}" class="nav-link text-white {{ request()->routeIs('cards.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle me-2"></i> Create Card
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cards.index') }}" class="nav-link text-white {{ request()->routeIs('cards.index') ? 'active' : '' }}">
                            <i class="bi bi-credit-card-2-front me-2"></i> My Cards
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->hasRole('admin'))
                    <li class="nav-item mt-2">
                        <span class="nav-header text-uppercase text-muted small d-block py-2">Admin</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('templates.index') }}" class="nav-link text-white {{ request()->routeIs('templates.index') ? 'active' : '' }}">
                            <i class="bi bi-grid-3x3 me-2"></i> Templates
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cards.approval') }}" class="nav-link text-white {{ request()->routeIs('cards.approval') ? 'active' : '' }}">
                            <i class="bi bi-check-circle me-2"></i> Approvals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Users
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->hasRole('super-admin'))
                    <li class="nav-item mt-2">
                        <span class="nav-header text-uppercase text-muted small d-block py-2">Super Admin</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-white {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.admins') }}" class="nav-link text-white {{ request()->routeIs('admin.users.admins') ? 'active' : '' }}">
                            <i class="bi bi-person-badge me-2"></i> Manage Admins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('settings.index') }}" class="nav-link text-white {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                            <i class="bi bi-gear me-2"></i> Settings
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="mt-auto p-3 border-top border-secondary">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <small class="text-muted">
                            @if(Auth::user()->hasRole('super-admin'))
                                Super Admin
                            @elseif(Auth::user()->hasRole('admin'))
                                Admin
                            @else
                                User
                            @endif
                        </small>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="main-content">
            <!-- Fixed Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
                <div class="container-fluid">
                    <button class="btn btn-sm btn-primary" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="navbar-brand mb-0 ms-3 fw-bold">@yield('title', 'Dashboard')</h5>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                   <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Overlay (for mobile) -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>

            <!-- Flash Messages Container (hidden, used for SweetAlert2) -->
            <div class="d-none">
                @if (session('success'))
                    <div id="success-message" data-message="{{ session('success') }}"></div>
                @endif

                @if (session('error'))
                    <div id="error-message" data-message="{{ session('error') }}"></div>
                @endif

                @if (session('warning'))
                    <div id="warning-message" data-message="{{ session('warning') }}"></div>
                @endif

                @if (session('info'))
                    <div id="info-message" data-message="{{ session('info') }}"></div>
                @endif

                @if (session('status'))
                    <div id="status-message" data-message="{{ session('status') }}"></div>
                @endif
            </div>

            <div class="container-fluid">

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    <!-- User Management JS -->
    @if(request()->routeIs('admin.users.*') || request()->routeIs('admin.users.admins'))
    <script>
        // Define URLs for AJAX requests
        const adminUsersDataUrl = "{{ route('admin.users.data') }}";
        const adminAdminsDataUrl = "{{ route('admin.admins.data') }}";
        const adminUsersShowUrl = "{{ route('admin.users.show', ['id' => '__ID__']) }}";
        const adminUsersUpdateUrl = "{{ route('admin.users.update', ['id' => '__ID__']) }}";
        const adminUsersDeleteUrl = "{{ route('admin.users.destroy', ['id' => '__ID__']) }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/user-management.js') }}"></script>
    @endif

    <!-- Dashboard Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar-wrapper');
            const pageContent = document.getElementById('page-content-wrapper');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const wrapper = document.getElementById('wrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');

                    // For larger screens
                    if (window.innerWidth >= 992) {
                        if (getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width') === '250px') {
                            document.documentElement.style.setProperty('--sidebar-width', '0px');
                        } else {
                            document.documentElement.style.setProperty('--sidebar-width', '250px');
                        }
                    }
                });
            }

            // Close sidebar when clicking on overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }

            // Handle responsive behavior
            function handleResize() {
                if (window.innerWidth < 992) {
                    document.documentElement.style.setProperty('--sidebar-width', '0px');
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                } else {
                    document.documentElement.style.setProperty('--sidebar-width', '250px');
                }
            }

            // Initial call and event listener
            handleResize();
            window.addEventListener('resize', handleResize);

            // Add hover effect to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 0.5rem 1rem rgba(0, 0, 0, 0.15)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)';
                });
            });

            // SweetAlert2 Flash Messages
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            const warningMessage = document.getElementById('warning-message');
            const infoMessage = document.getElementById('info-message');
            const statusMessage = document.getElementById('status-message');

            if (successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage.dataset.message,
                    icon: 'success',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage.dataset.message,
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            }

            if (warningMessage) {
                Swal.fire({
                    title: 'Warning!',
                    text: warningMessage.dataset.message,
                    icon: 'warning',
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: 'OK'
                });
            }

            if (infoMessage) {
                Swal.fire({
                    title: 'Information',
                    text: infoMessage.dataset.message,
                    icon: 'info',
                    confirmButtonColor: '#0dcaf0',
                    confirmButtonText: 'OK'
                });
            }

            if (statusMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: statusMessage.dataset.message,
                    icon: 'success',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                });
            }

            // Toast notification for logout
            const logoutButtons = document.querySelectorAll('button[type="submit"][form*="logout"]');
            logoutButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Logging out',
                        text: 'Are you sure you want to log out?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, log me out'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show toast notification
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Logging out...'
                            });

                            // Submit the form after a short delay
                            setTimeout(() => {
                                form.submit();
                            }, 1000);
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
