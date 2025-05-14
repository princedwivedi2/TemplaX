<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TemplaX') }} - @yield('title', 'Dashboard')</title>

    <!-- Styles -->
    @section('styles')
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    @show

    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 56px;
            --sidebar-bg: #212529;
            --body-bg: #f8f9fa;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--body-bg);
            min-height: 100vh;
        }

        /* Layout Structure */
        .wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: var(--navbar-height);
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            width: calc(100% - var(--sidebar-width));
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 2rem;
            width: calc(100% - var(--sidebar-width));
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
            height: var(--navbar-height);
            background: white;
            padding: 0.5rem 1rem;
        }

        /* Responsive Layout */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: var(--navbar-height);
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Card Hover Effects */
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-sm btn-primary" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="navbar-brand mb-0 ms-3">@yield('title', 'Dashboard')</h5>
            <div class="ms-auto d-flex align-items-center">
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger p-0">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="h-100 d-flex flex-column">
                <!-- Sidebar Content -->
                <div class="flex-grow-1 p-3">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>

                        <!-- Business Card Section -->
                        <li class="nav-item mt-2">
                            <span class="nav-header text-uppercase text-white small d-block py-2">Cards</span>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cards.index') }}" class="nav-link text-white {{ request()->routeIs('cards.index') ? 'active' : '' }}">
                                <i class="bi bi-credit-card-2-front me-2"></i> {{ Auth::user()->hasRole('super-admin') ? 'All Cards' : 'My Cards' }}
                            </a>
                        </li>

                        @if(Auth::user()->hasRole('admin'))
                            @if(Auth::user()->hasRole('super-admin'))
                            <li class="nav-header text-uppercase text-white-50 small mt-4 mb-2">Super Admin</li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="bi bi-people me-2"></i> Manage Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('settings.index') }}" class="nav-link text-white {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                            </li>
                            @endif
                        @endif
                    </ul>
                </div>

                <!-- Sidebar Footer -->
                <div class="p-3 border-top border-secondary mt-auto">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-white fw-bold">{{ Auth::user()->name }}</div>
                            <small class="text-white-50">
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
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay"></div>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('warning') || session('info'))
                <div class="alert-container mb-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Content -->
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');
            const mainContent = document.querySelector('.main-content');

            // Toggle Sidebar
            sidebarToggle?.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                if (window.innerWidth >= 992) {
                    if (sidebar.classList.contains('show')) {
                        mainContent.style.marginLeft = '0';
                    } else {
                        mainContent.style.marginLeft = 'var(--sidebar-width)';
                    }
                }
            });

            // Close sidebar on overlay click
            sidebarOverlay?.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    mainContent.style.marginLeft = 'var(--sidebar-width)';
                } else {
                    mainContent.style.marginLeft = '0';
                }
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
    @show
</body>
</html>
