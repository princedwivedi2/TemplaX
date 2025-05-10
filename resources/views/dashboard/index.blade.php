@extends('layouts.app-dashboard')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Dashboard specific styles */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2rem;
        color: var(--primary-color);
        width: 60px;
        height: 60px;
        background-color: rgba(52, 144, 220, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--dark-color);
    }

    .stat-content p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    .action-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .action-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        transition: var(--transition);
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .card-icon {
        font-size: 1.5rem;
        color: var(--primary-color);
        width: 50px;
        height: 50px;
        background-color: rgba(52, 144, 220, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-color);
        margin: 0;
    }

    .card-content {
        margin-bottom: 1.5rem;
    }

    .card-content p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--dark-color);
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .table-container {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        padding: 0.75rem 1rem;
        text-align: left;
    }

    .data-table th {
        background-color: var(--gray-light-color);
        font-weight: 600;
        color: var(--dark-color);
    }

    .data-table tr {
        border-bottom: 1px solid var(--border-color);
    }

    .data-table tr:last-child {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-pending {
        background-color: rgba(246, 153, 63, 0.1);
        color: var(--secondary-color);
    }

    .status-approved {
        background-color: rgba(56, 193, 114, 0.1);
        color: var(--success-color);
    }

    .status-rejected {
        background-color: rgba(227, 52, 47, 0.1);
        color: var(--danger-color);
    }

    @media (max-width: 768px) {
        .stats-container,
        .action-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Welcome Section -->
<div class="welcome-section">
    <h2>Welcome to TemplaX Dashboard</h2>
    <p>Your internal business card management system</p>
</div>

<!-- Stats Section -->
<div class="stats-container">
    @role('super-admin')
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3>{{ $totalUsers ?? 0 }}</h3>
                <p>Total Users</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👑</div>
            <div class="stat-content">
                <h3>{{ $totalAdmins ?? 0 }}</h3>
                <p>Administrators</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📇</div>
            <div class="stat-content">
                <h3>{{ $totalCards ?? 0 }}</h3>
                <p>Business Cards</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🖼️</div>
            <div class="stat-content">
                <h3>{{ $totalTemplates ?? 0 }}</h3>
                <p>Card Templates</p>
            </div>
        </div>
    @endrole

    @role('admin')
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3>{{ $departmentUsers ?? 0 }}</h3>
                <p>Department Users</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📇</div>
            <div class="stat-content">
                <h3>{{ $pendingApprovals ?? 0 }}</h3>
                <p>Pending Approvals</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3>{{ $approvedCards ?? 0 }}</h3>
                <p>Approved Cards</p>
            </div>
        </div>
    @endrole

    @role('user')
        <div class="stat-card">
            <div class="stat-icon">📇</div>
            <div class="stat-content">
                <h3>{{ $userCards ?? 0 }}</h3>
                <p>My Cards</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏱️</div>
            <div class="stat-content">
                <h3>{{ $pendingCards ?? 0 }}</h3>
                <p>Pending Approval</p>
            </div>
        </div>
    @endrole
</div>

<!-- Action Cards Section -->
<h3 class="section-title">Quick Actions</h3>
<div class="action-cards">
    @role('user')
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">✨</div>
                <h4 class="card-title">Create Business Card</h4>
            </div>
            <div class="card-content">
                <p>Create a new business card with your information</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Create Card</a>
            </div>
        </div>
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">📇</div>
                <h4 class="card-title">Manage My Cards</h4>
            </div>
            <div class="card-content">
                <p>View and manage your existing business cards</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">View Cards</a>
            </div>
        </div>
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">📥</div>
                <h4 class="card-title">Download PDF</h4>
            </div>
            <div class="card-content">
                <p>Download your approved business cards in PDF format</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('card.download') }}" class="btn btn-secondary">Download</a>
            </div>
        </div>
    @endrole

    @role('admin')
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">✅</div>
                <h4 class="card-title">Pending Approvals</h4>
            </div>
            <div class="card-content">
                <p>Review and approve submitted business cards</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Review Cards</a>
            </div>
        </div>
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">🖼️</div>
                <h4 class="card-title">Manage Templates</h4>
            </div>
            <div class="card-content">
                <p>View and manage business card templates</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">View Templates</a>
            </div>
        </div>
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">👥</div>
                <h4 class="card-title">Department Users</h4>
            </div>
            <div class="card-content">
                <p>Manage users in your department</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">View Users</a>
            </div>
        </div>
    @endrole

    @role('super-admin')
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">👥</div>
                <h4 class="card-title">Manage Users</h4>
            </div>
            <div class="card-content">
                <p>Add, edit, or remove users from the system</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Manage Users</a>
            </div>
        </div>
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">👑</div>
                <h4 class="card-title">Manage Admins</h4>
            </div>
            <div class="card-content">
                <p>Add, edit, or remove administrator accounts</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Manage Admins</a>
            </div>
        </div>
        <div class="action-card">
            <div class="card-header">
                <div class="card-icon">🖼️</div>
                <h4 class="card-title">Card Templates</h4>
            </div>
            <div class="card-content">
                <p>Manage business card templates used by the organization</p>
            </div>
            <div class="card-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Manage Templates</a>
            </div>
        </div>
    @endrole
</div>

<!-- My Cards Section for Users -->
@role('user')
<h3 class="section-title">My Business Cards</h3>
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Card Name</th>
                <th>Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($userBusinessCards) && count($userBusinessCards) > 0)
                @foreach($userBusinessCards as $card)
                <tr>
                    <td>{{ $card->name ?? 'Unnamed Card' }}</td>
                    <td>{{ $card->created_at ?? 'Unknown Date' }}</td>
                    <td>
                        @if($card->status == 'pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($card->status == 'approved')
                            <span class="status-badge status-approved">Approved</span>
                        @elseif($card->status == 'rejected')
                            <span class="status-badge status-rejected">Rejected</span>
                        @else
                            <span class="status-badge">{{ $card->status ?? 'Unknown' }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="card-actions">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">Edit</a>
                            @if($card->status == 'approved')
                                <a href="{{ route('card.download') }}" class="btn btn-sm btn-secondary">Download PDF</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">No business cards found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endrole

<!-- Pending Approvals for Admins -->
@role('admin')
<h3 class="section-title">Pending Approvals</h3>
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Card Name</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($pendingApprovalCards) && count($pendingApprovalCards) > 0)
                @foreach($pendingApprovalCards as $card)
                <tr>
                    <td>{{ $card->user_name ?? 'Unknown User' }}</td>
                    <td>{{ $card->name ?? 'Unnamed Card' }}</td>
                    <td>{{ $card->created_at ?? 'Unknown Date' }}</td>
                    <td>
                        <div class="card-actions">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">Review</a>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">Approve</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">No pending approvals</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endrole
@endsection
