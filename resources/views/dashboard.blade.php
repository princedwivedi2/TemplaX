@extends('layouts.dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
                    <path d="M158 0C70.7 0 0 70.7 0 158s70.7 158 158 158 158-70.7 158-158S245.3 0 158 0zm-35.7 256h-22.1V60h22.1v196zm93.5 0h-22.1v-87.7l-50.2-74.6h27l36.2 58.9 35.4-58.9h26.6l-52.9 74.6V256z"/>
                </svg>
                <span>TemplaX</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li class="active">
                    <a href="{{ route('dashboard') }}">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon">📇</span>
                        <span>My Cards</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon">✨</span>
                        <span>Create Card</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon">👤</span>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon">⚙️</span>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
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
            <div class="header-welcome">
                <h1>Welcome, {{ Auth::user()->name }}</h1>
                <p>Manage your digital business cards</p>
            </div>
            <div class="header-actions">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="user-menu">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="dropdown">
                        <a href="{{ route('dashboard') }}" class="dropdown-item">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
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

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon">📇</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Total Cards</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👁️</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Card Views</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📱</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>QR Scans</p>
                    </div>
                </div>
            </div>

            <div class="action-cards">
                <div class="action-card">
                    <div class="card-icon">✨</div>
                    <h2>Create New Card</h2>
                    <p>Design a new business card from scratch or use a template</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Create Card</a>
                </div>
                <div class="action-card">
                    <div class="card-icon">📇</div>
                    <h2>My Cards</h2>
                    <p>View and manage your existing business cards</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">View Cards</a>
                </div>
                <div class="action-card">
                    <div class="card-icon">👤</div>
                    <h2>Manage Profile</h2>
                    <p>Update your profile information and preferences</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Edit Profile</a>
                </div>
            </div>

            <div class="recent-activity">
                <h2>Recent Activity</h2>
                <div class="activity-list">
                    <div class="empty-state">
                        <p>No recent activity to display</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
