@extends('layouts.app-dashboard')

@section('title', 'User Management - Card View')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
<style>
    /* Custom Variables */
    :root {
        --bs-primary: #0d6efd;
        --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545;
        --bs-light: #f8f9fa;
        --bs-dark: #212529;
        --bs-border-color: #dee2e6;
    }

    /* Card Styling */
    .user-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        height: 100%;
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .user-card .card-body {
        padding: 1.5rem;
    }

    .user-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background-color: var(--bs-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .user-info {
        margin-bottom: 1rem;
    }

    .user-info .bi {
        width: 20px;
        margin-right: 0.5rem;
        color: var(--bs-secondary);
    }

    .role-badge {
        font-size: 0.75rem;
        padding: 0.5em 1em;
        border-radius: 50rem;
    }

    .role-badge.admin {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        border: 1px solid rgba(var(--bs-primary-rgb), 0.2);
    }

    .role-badge.user {
        background-color: rgba(var(--bs-info-rgb), 0.1);
        color: var(--bs-info);
        border: 1px solid rgba(var(--bs-info-rgb), 0.2);
    }

    /* Search and Filter Styling */
    .search-box {
        max-width: 300px;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: none;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <h1 class="h3 mb-0 text-gray-800">User Management</h1>
            <span class="ms-2 badge rounded-pill bg-primary">{{ auth()->user()->hasRole('super-admin') ? 'Super Admin' : 'Admin' }}</span>
        </div>
        <div class="d-flex gap-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary d-flex align-items-center">
                <i class="bi bi-table me-2"></i> Table View
            </a>
            <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-circle me-2"></i> Add New User
            </button>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search users...">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select" id="roleFilter">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="row g-4" id="usersGrid">
        <!-- User cards will be dynamically inserted here -->
    </div>
</div>

<!-- Include the modals from the table view -->
@include('admin.forms.user-form')

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    let users = [];
    const grid = $('#usersGrid');
    const spinner = $('#loadingSpinner');

    // Function to create a user card
    function createUserCard(user) {
        const roleBadgeClass = user.roles && user.roles.length > 0 
            ? (user.roles[0].toLowerCase() === 'admin' ? 'admin' : 'user') 
            : 'user';
        const roleName = user.roles && user.roles.length > 0 ? user.roles[0] : 'User';
        const createdAt = new Date(user.created_at).toLocaleDateString();
        const initial = user.name.charAt(0).toUpperCase();

        return `
            <div class="col-12 col-md-6 col-lg-4 user-card-wrapper">
                <div class="card user-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center mb-3">
                            <div class="user-avatar">${initial}</div>
                            <h5 class="card-title mb-1">${user.name}</h5>
                            <span class="role-badge ${roleBadgeClass.toLowerCase()}">${roleName}</span>
                        </div>
                        <div class="user-info">
                            <p class="mb-2 d-flex align-items-center">
                                <i class="bi bi-envelope"></i>
                                ${user.email}
                            </p>
                            <p class="mb-2 d-flex align-items-center">
                                <i class="bi bi-building"></i>
                                ${user.organization || 'N/A'}
                            </p>
                            <p class="mb-0 d-flex align-items-center">
                                <i class="bi bi-calendar"></i>
                                ${createdAt}
                            </p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-outline-danger delete-user" 
                                    data-id="${user.id}" 
                                    data-bs-toggle="tooltip" 
                                    title="Delete User">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to load and display users
    function loadUsers() {
        spinner.css('display', 'flex');
        grid.hide();

        $.ajax({
            url: '{{ route("admin.users.data") }}',
            type: 'GET',
            success: function(response) {
                if (response.data) {
                    users = response.data;
                    displayUsers(users);
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load users.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            },
            complete: function() {
                spinner.hide();
                grid.show();
            }
        });
    }

    // Function to display filtered users
    function displayUsers(filteredUsers) {
        grid.empty();
        filteredUsers.forEach(user => {
            grid.append(createUserCard(user));
        });
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    // Search functionality
    $('#searchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        const roleFilter = $('#roleFilter').val();
        
        const filteredUsers = users.filter(user => {
            const matchesSearch = user.name.toLowerCase().includes(searchTerm) || 
                                user.email.toLowerCase().includes(searchTerm) ||
                                (user.organization && user.organization.toLowerCase().includes(searchTerm));
            const matchesRole = !roleFilter || (user.roles && user.roles[0].toLowerCase() === roleFilter);
            return matchesSearch && matchesRole;
        });
        
        displayUsers(filteredUsers);
    });

    // Role filter functionality
    $('#roleFilter').on('change', function() {
        $('#searchInput').trigger('input');
    });

    // Delete user functionality (reuse from table view)
    $(document).on('click', '.delete-user', function() {
        const userId = $(this).data('id');
        const userCard = $(this).closest('.user-card-wrapper');
        const user = users.find(u => u.id === userId);
        
        if (user) {
            $('#delete_user_id').val(userId);
            $('#deleteUserName').text(user.name);
            $('#deleteUserModal').modal('show');
        }
    });

    // Confirm delete handler
    $('#confirmDeleteBtn').on('click', function() {
        const btn = $(this);
        const spinner = btn.find('.spinner-border');
        const userId = $('#delete_user_id').val();
        
        btn.prop('disabled', true);
        spinner.removeClass('d-none');

        $.ajax({
            url: `{{ url('admin/users') }}/${userId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                btn.prop('disabled', false);
                spinner.addClass('d-none');

                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message || 'User deleted successfully!',
                        icon: 'success',
                        confirmButtonColor: '#0d6efd'
                    });

                    $('#deleteUserModal').modal('hide');
                    loadUsers(); // Reload all users
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message || 'Failed to delete user.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function() {
                btn.prop('disabled', false);
                spinner.addClass('d-none');

                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete user. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Load users on page load
    loadUsers();
});
</script>
@endsection
