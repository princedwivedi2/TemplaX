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
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: auto;
        display: inline-block;
        margin: 0 0.5rem;
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
    .btn-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-group .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease-in-out;
    }

    .btn-info {
        background-color: rgba(13, 202, 240, 0.1);
        border-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }

    .btn-info:hover {
        background-color: rgba(13, 202, 240, 0.2);
        border-color: rgba(13, 202, 240, 0.2);
        color: #0dcaf0;
    }

    .btn-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .btn-danger:hover {
        background-color: rgba(220, 53, 69, 0.2);
        border-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
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
$(document).ready(function() {
    // Initialize DataTable with Bootstrap 5 styling
    const table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("admin.users.data") }}',
            type: 'GET',
            dataSrc: function(json) {
                // Update total users count
                $('#totalUsers').html(`<i class="bi bi-people-fill me-1"></i>${json.data.length} Total`);
                return json.data;
            }
        },
        columns: [
            { 
                data: 'id',
                width: '5%'
            },
            { 
                data: 'name',
                width: '20%'
            },
            { 
                data: 'email',
                width: '20%'
            },
            { 
                data: 'organization',
                width: '15%'
            },
            { 
                data: 'roles',
                width: '15%',
                render: function(data) {
                    return data && data.length > 0 
                        ? data.map(role => `<span class="badge bg-info text-capitalize">${role.name}</span>`).join(' ')
                        : '<span class="badge bg-secondary">No Role</span>';
                }
            },
            { 
                data: 'created_at',
                width: '15%',
                render: function(data) {
                    return new Date(data).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                }
            },
            {
                data: null,
                width: '10%',
                orderable: false,
                className: 'text-end',
                render: function(data) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-info edit-user" title="Edit User" data-id="${data.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger delete-user" title="Delete User" data-id="${data.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            search: "",
            searchPlaceholder: "Search users...",
            lengthMenu: "_MENU_ users per page",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users found",
            infoFiltered: "(filtered from _MAX_ total users)"
        },
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        pageLength: 10,
        order: [[0, 'desc']]
    });

    // Save User with improved validation
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

    // Clear validation errors when input changes
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').empty();
    });
});
</script>
@endsection
