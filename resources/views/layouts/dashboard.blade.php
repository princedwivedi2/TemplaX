<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TemplaX') }} - Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #3490dc;
            --primary-hover: #2779bd;
            --secondary-color: #f6993f;
            --secondary-hover: #e68a2e;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --danger-color: #e3342f;
            --success-color: #38c172;
            --border-color: #dee2e6;
            --text-color: #333;
            --text-muted: #6c757d;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 0.375rem;
            --sidebar-width: 250px;
            --header-height: 70px;
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
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo svg {
            width: 30px;
            height: 30px;
            fill: white;
        }

        .logo span {
            font-size: 1.25rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            transition: var(--transition);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .sidebar-nav ul {
            list-style: none;
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
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            border-radius: var(--border-radius);
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.1);
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

        .header-welcome h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .header-welcome p {
            font-size: 0.9rem;
            color: var(--text-muted);
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

        .user-menu {
            position: relative;
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
            cursor: pointer;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            width: 180px;
            margin-top: 0.5rem;
            display: none;
            z-index: 100;
            overflow: hidden;
        }

        .user-menu.active .dropdown {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            border: none;
            background: none;
            text-align: left;
            width: 100%;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: var(--light-color);
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

        /* Stats Row */
        .stats-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-content p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Action Cards */
        .action-cards {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .action-card {
            flex: 1;
            min-width: 250px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .action-card h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .action-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.75rem 1.5rem;
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
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            color: white;
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-hover);
            border-color: var(--secondary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Recent Activity */
        .recent-activity {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .recent-activity h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .empty-state {
            text-align: center;
            padding: 2rem 0;
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar .logo span,
            .sidebar-nav a span,
            .btn-logout span {
                display: none;
            }

            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }

            .sidebar-collapsed .sidebar {
                width: var(--sidebar-width);
            }

            .sidebar-collapsed .sidebar .logo span,
            .sidebar-collapsed .sidebar-nav a span,
            .sidebar-collapsed .btn-logout span {
                display: inline;
            }
        }

        @media (max-width: 768px) {
            .toggle-sidebar {
                display: block;
            }

            .sidebar {
                left: -100%;
                width: var(--sidebar-width);
            }

            .sidebar .logo span,
            .sidebar-nav a span,
            .btn-logout span {
                display: inline;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-collapsed .sidebar {
                left: 0;
            }

            .stats-row,
            .action-cards {
                flex-direction: column;
            }

            .stat-card,
            .action-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @yield('content')

    <script>
        // Simple JavaScript for sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const dashboard = document.querySelector('.dashboard-container');
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    dashboard.classList.toggle('sidebar-collapsed');
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const userMenu = document.querySelector('.user-menu');
                if (userMenu && !userMenu.contains(event.target)) {
                    userMenu.classList.remove('active');
                }
            });
            
            // Toggle user dropdown
            const userAvatar = document.querySelector('.user-avatar');
            if (userAvatar) {
                userAvatar.addEventListener('click', function() {
                    document.querySelector('.user-menu').classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
