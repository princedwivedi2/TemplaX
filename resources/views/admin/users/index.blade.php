@extends('layouts.app-dashboard')

@section('title', 'User Management')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
    }

    .card-header {
        background-color: var(--bs-light);
        border-bottom: 1px solid var(--bs-border-color);
    }

    /* DataTable Styling */
    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        width: 300px !important;
        margin-left: 0.5rem;
        display: inline-block;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid var(--bs-border-color);
        border-radius: 0.375rem;
    }

    div.dataTables_wrapper div.dataTables_length {
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 70px !important;
        display: inline-block;
        margin: 0 0.5rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        border: 1px solid var(--bs-border-color);
        border-radius: 0.375rem;
        background-color: #fff;
        font-size: 0.875rem;
    }

    div.dataTables_wrapper div.dataTables_length label {
        display: flex;
        align-items: center;
        margin-bottom: 0;
        white-space: nowrap;
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1rem;
        padding-top: 0.5rem;
        border-top: 1px solid var(--bs-border-color);
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 1rem;
    }

    /* Table Styling */
    .table > :not(caption) > * > * {
        padding: 0.75rem;
    }

    .table > thead {
        background-color: var(--bs-light);
    }

    .table > thead > tr > th {
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--bs-border-color);
    }

    /* Role Badge Styling */
    /* Badge Styling */
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
        font-size: 0.75rem;
        border-radius: 0.375rem;
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

    .role-badge.no-role {
        background-color: rgba(var(--bs-secondary-rgb), 0.1);
        color: var(--bs-secondary);
        border: 1px solid rgba(var(--bs-secondary-rgb), 0.2);
    }

    /* Form Styling */
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-label.required:after {
        content: ' *';
        color: #dc3545;
        font-weight: bold;
    }

    .form-control,
    .form-select {
        padding: 0.5rem 0.75rem;
        border-color: #dee2e6;
        font-size: 0.875rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Action Buttons Styling */
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
        margin: 0 0.125rem;
    }

    .action-btn i {
        font-size: 1rem;
    }



    .action-btn.delete-btn {
        background-color: rgba(var(--bs-danger-rgb), 0.1);
        border: 1px solid rgba(var(--bs-danger-rgb), 0.1);
        color: var(--bs-danger);
    }

    .action-btn.delete-btn:hover {
        background-color: var(--bs-danger);
        border-color: var(--bs-danger);
        color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(var(--bs-danger-rgb), 0.4);
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-header .modal-title {
        font-weight: 600;
        color: #212529;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        font-weight: 500;
    }

    .spinner-border {
        margin-right: 0.5rem;
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }

    /* Additional Table Styling */
    .card-body {
        padding: 1rem 1.5rem;
    }

    .table > :not(caption) > * > * {
        padding: 1rem;
    }

    .table > thead > tr > th {
        white-space: nowrap;
    }

    .table > tbody > tr > td {
        vertical-align: middle;
    }

    /* Loading State */
    .dataTables_processing {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <h1 class="h3 mb-0 text-gray-800">User Management</h1>
            <span class="ms-2 badge rounded-pill bg-primary">{{ auth()->user()->hasRole('super-admin') ? 'Super Admin' : 'Admin' }}</span>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle me-2"></i> Add New User
        </button>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="bi bi-person-plus me-2"></i>Add New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="user_name" class="form-label required">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="user_name" name="name" required>
                            </div>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="user_email" class="form-label required">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="user_email" name="email" required>
                            </div>
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>

                        <!-- Organization -->
                        <div class="mb-3">
                            <label for="user_organization" class="form-label required">Organization</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control" id="user_organization" name="organization" required>
                            </div>
                            <div class="invalid-feedback" id="organizationError"></div>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="user_role" class="form-label required">Role</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <select class="form-select" id="user_role" name="role" required>
                                    <option value="" selected disabled>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="invalid-feedback" id="roleError"></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="user_password" class="form-label required">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="user_password" name="password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveUserBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Save User
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="deleteUserModalLabel">
                        <i class="bi bi-trash me-2"></i>Delete User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteUserName"></strong>?</p>
                    <input type="hidden" id="delete_user_id" name="user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-white border-bottom-0">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                        <i class="bi bi-people me-2"></i>All Users
                    </h6>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="badge bg-light text-dark border" id="totalUsers">
                            <i class="bi bi-people-fill me-1"></i>Loading...
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="usersTable">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables with Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
<script>
    let table;

    $(document).ready(function() {
        // Initialize DataTable
        table = $('#usersTable').DataTable({
            ajax: {
                url: '{{ route("admin.users.data") }}',
                dataSrc: 'data'
            },
            columns: [
                {
                    data: 'id',
                    className: 'text-center'
                },
                {
                    data: 'name',
                    render: function(data, type, row) {
                        return `<div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle text-muted me-2"></i>${data}
                                </div>`;
                    }
                },
                { 
                    data: 'email',
                    render: function(data) {
                        return `<div class="d-flex align-items-center">
                                    <i class="bi bi-envelope text-muted me-2"></i>${data}
                                </div>`;
                    }
                },
                { 
                    data: 'organization',
                    render: function(data) {
                        return `<div class="d-flex align-items-center">
                                    <i class="bi bi-building text-muted me-2"></i>${data || '-'}
                                </div>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let roleBadge = 'secondary';
                        let roleName = 'No Role';
                        
                        if (row.roles && row.roles.length > 0) {
                            const role = row.roles[0];
                            roleName = typeof role === 'object' ? role.name : role;
                            
                            roleBadge = roleName.toLowerCase() === 'super-admin' ? 'danger' : 
                                       roleName.toLowerCase() === 'admin' ? 'primary' : 
                                       'info';
                        }
                        
                        return `<span class="badge bg-${roleBadge}">${roleName}</span>`;
                    }
                },
                {
                    data: 'created_at',
                    render: function(data) {
                        return new Date(data).toLocaleDateString();
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function(data) {
                        return `<div class="d-flex gap-2 justify-content-end">
                            <button class="action-btn btn btn-outline-danger delete-user" 
                                    data-id="${data.id}" 
                                    data-bs-toggle="tooltip" 
                                    title="Delete User">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>`;
                    }
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search users...",
                lengthMenu: "Show _MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                infoEmpty: "No users found",
                infoFiltered: "(filtered from _MAX_ total users)"
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            drawCallback: function(settings) {
                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
                
                // Update total users count
                const api = this.api();
                const totalUsers = api.page.info().recordsTotal;
                $('#totalUsers').html(`<i class="bi bi-people-fill me-1"></i>${totalUsers} Total Users`);
            },
        });

        // Add User Form Submit Handler
        $('#saveUserBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');
            
            // Reset previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            
            // Show loading state
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const formData = {
                name: $('#user_name').val(),
                email: $('#user_email').val(),
                organization: $('#user_organization').val(),
                role: $('#user_role').val(),
                password: $('#user_password').val(),
                _token: '{{ csrf_token() }}'
            };

            // Send AJAX request
            $.ajax({
                url: '{{ route("admin.users.store") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Hide loading state
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'User created successfully!',
                            icon: 'success',
                            confirmButtonColor: '#0d6efd'
                        });

                        // Reset form and close modal
                        $('#addUserForm')[0].reset();
                        $('#addUserModal').modal('hide');

                        // Reload DataTable
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || 'Failed to create user.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function(xhr) {
                    // Hide loading state
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(field => {
                            $(`#user_${field}`).addClass('is-invalid');
                            $(`#${field}Error`).text(errors[field][0]);
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to create user. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                }
            });
        });



        // Delete User Click Handler
        $(document).on('click', '.delete-user', function() {
            const userId = $(this).data('id');
            const user = table.row($(this).closest('tr')).data();
            
            // Set user info in delete modal
            $('#delete_user_id').val(userId);
            $('#deleteUserName').text(user.name);
            
            // Show delete modal
            $('#deleteUserModal').modal('show');
        });

        // Confirm Delete Handler
        $('#confirmDeleteBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');
            const userId = $('#delete_user_id').val();
            
            // Show loading state
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Send AJAX request
            $.ajax({
                url: `{{ url('super-admin/users') }}/${userId}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    // Hide loading state
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'User deleted successfully!',
                            icon: 'success',
                            confirmButtonColor: '#0d6efd'
                        });

                        // Close modal
                        $('#deleteUserModal').modal('hide');

                        // Reload DataTable
                        table.ajax.reload();
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
                    // Hide loading state
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

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const passwordField = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
    });
</script>
@endsection
