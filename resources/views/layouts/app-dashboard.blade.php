<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TemplaX') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #3490dc;
            --primary-hover: #2779bd;
            --secondary-color: #f6993f;
            --secondary-hover: #e68a2e;
            --success-color: #38c172;
            --danger-color: #e3342f;
            --warning-color: #ffed4a;
            --info-color: #6cb2eb;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --gray-light-color: #f1f3f5;
            --border-color: #dee2e6;
            --text-color: #333;
            --text-muted: #6c757d;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 0.375rem;
            --sidebar-width: 250px;
            --header-height: 60px;
            --sidebar-collapsed-width: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f8fa;
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-color);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            color: var(--primary-color);
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            transition: var(--transition);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .nav-section {
            margin-bottom: 1rem;
        }

        .nav-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
        }

        .sidebar-nav li {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            gap: 0.75rem;
        }

        .sidebar-nav a:hover,
        .sidebar-nav li.active a {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-nav .icon {
            font-size: 1.25rem;
            min-width: 1.5rem;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-details {
            overflow: hidden;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            border-radius: var(--border-radius);
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .dashboard-header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-sidebar {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            width: 30px;
            height: 30px;
            position: relative;
        }

        .toggle-sidebar span {
            display: block;
            width: 100%;
            height: 2px;
            background-color: var(--dark-color);
            position: absolute;
            left: 0;
            transition: var(--transition);
        }

        .toggle-sidebar span:nth-child(1) {
            top: 8px;
        }

        .toggle-sidebar span:nth-child(2) {
            top: 14px;
        }

        .toggle-sidebar span:nth-child(3) {
            top: 20px;
        }

        .header-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .header-user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Dashboard Content */
        .dashboard-content {
            flex: 1;
            padding: 1.5rem;
        }

        /* Alert */
        .alert {
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: rgba(56, 193, 114, 0.1);
            border: 1px solid rgba(56, 193, 114, 0.2);
            color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(227, 52, 47, 0.1);
            border: 1px solid rgba(227, 52, 47, 0.2);
            color: var(--danger-color);
        }

        /* Common Components */
        .btn {
            display: inline-block;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            line-height: 1.5;
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            color: white;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-secondary {
            color: white;
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-hover);
            border-color: var(--secondary-hover);
        }

        .btn-danger {
            color: white;
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .logo-text,
            .sidebar-nav a span:not(.icon),
            .nav-section-title,
            .user-details,
            .btn-logout span:not(.icon) {
                display: none;
            }

            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }

            .sidebar-collapsed .sidebar {
                width: var(--sidebar-width);
            }

            .sidebar-collapsed .logo-text,
            .sidebar-collapsed .sidebar-nav a span:not(.icon),
            .sidebar-collapsed .nav-section-title,
            .sidebar-collapsed .user-details,
            .sidebar-collapsed .btn-logout span:not(.icon) {
                display: inline-block;
            }
        }

        @media (max-width: 768px) {
            .toggle-sidebar {
                display: block;
            }

            .sidebar {
                left: -100%;
                width: var(--sidebar-width);
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .logo-text,
            .sidebar-nav a span:not(.icon),
            .nav-section-title,
            .user-details,
            .btn-logout span:not(.icon) {
                display: inline-block;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-collapsed .sidebar {
                left: 0;
            }

            .header-user-name,
            .header-user-role {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container" id="dashboardContainer">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">T</div>
                    <div class="logo-text">TemplaX</div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <span class="icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <div class="nav-section">
                        <div class="nav-section-title">Cards</div>
                        <li class="{{ request()->routeIs('cards.index') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">📇</span>
                                <span>My Cards</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('cards.create') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">✨</span>
                                <span>Create Card</span>
                            </a>
                        </li>
                    </div>

                    @if(Auth::user()->hasRole('admin'))
                    <div class="nav-section">
                        <div class="nav-section-title">Admin</div>
                        <li class="{{ request()->routeIs('templates.index') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">🖼️</span>
                                <span>Templates</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('cards.approval') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">✅</span>
                                <span>Approvals</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">👥</span>
                                <span>Users</span>
                            </a>
                        </li>
                    </div>
                    @endif

                    @if(Auth::user()->hasRole('super-admin'))
                    <div class="nav-section">
                        <div class="nav-section-title">Super Admin</div>
                        <li class="{{ request()->routeIs('admins.index') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">👑</span>
                                <span>Manage Admins</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('settings.index') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <span class="icon">⚙️</span>
                                <span>Settings</span>
                            </a>
                        </li>
                    </div>
                    @endif
                </ul>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">
                            @if(Auth::user()->hasRole('super-admin'))
                                Super Admin
                            @elseif(Auth::user()->hasRole('admin'))
                                Admin
                            @else
                                User
                            @endif
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <span class="icon">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="dashboard-header">
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                <div class="header-actions">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div class="header-user-info">
                        <div class="header-user-name">{{ Auth::user()->name }}</div>
                        <div class="header-user-role">
                            @if(Auth::user()->hasRole('super-admin'))
                                Super Admin
                            @elseif(Auth::user()->hasRole('admin'))
                                Admin
                            @else
                                User
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Simple JavaScript for sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const dashboard = document.getElementById('dashboardContainer');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    dashboard.classList.toggle('sidebar-collapsed');
                });
            }
        });
    </script>
</body>
</html>
