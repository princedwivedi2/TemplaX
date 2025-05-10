@extends('layouts.app-dashboard')

@section('title', 'Admin Management')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin Management</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="bi bi-plus-circle me-1"></i> Add New Admin
        </button>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Administrators</h6>
            <div class="input-group w-25">
                <input type="text" class="form-control" id="adminSearch" placeholder="Search...">
                <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="adminsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdminForm">
                    <div class="mb-3">
                        <label for="admin_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="admin_name" name="name" required>
                        <div class="invalid-feedback" id="adminNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="admin_email" name="email" required>
                        <div class="invalid-feedback" id="adminEmailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="admin_organization" class="form-label">Organization</label>
                        <input type="text" class="form-control" id="admin_organization" name="organization" required>
                        <div class="invalid-feedback" id="adminOrganizationError"></div>
                    </div>
                    <input type="hidden" id="admin_role" name="role" value="admin">
                    <div class="mb-3">
                        <label for="admin_password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="admin_password" name="password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="adminPasswordError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAdminBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Save Admin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAdminForm">
                    <input type="hidden" id="edit_admin_id" name="user_id">
                    <div class="mb-3">
                        <label for="edit_admin_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="edit_admin_name" name="name" required>
                        <div class="invalid-feedback" id="editAdminNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_admin_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="edit_admin_email" name="email" required>
                        <div class="invalid-feedback" id="editAdminEmailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_admin_organization" class="form-label">Organization</label>
                        <input type="text" class="form-control" id="edit_admin_organization" name="organization" required>
                        <div class="invalid-feedback" id="editAdminOrganizationError"></div>
                    </div>
                    <input type="hidden" id="edit_admin_role" name="role" value="admin">
                    <div class="mb-3">
                        <label for="edit_admin_password" class="form-label">Password (Leave blank to keep current)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_admin_password" name="password">
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="editAdminPasswordError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateAdminBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Update Admin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdminModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this administrator? This action cannot be undone.</p>
                <p><strong>Admin: </strong><span id="deleteAdminName"></span></p>
                <input type="hidden" id="delete_admin_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAdminBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Delete Admin
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Function to load admins data
    function loadAdmins(searchTerm = '') {
        // Show loading indicator
        $('#adminsTable tbody').html('<tr><td colspan="6" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>');

        // Send AJAX request
        $.ajax({
            url: adminAdminsDataUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let admins = response.data;
                    let tableRows = '';

                    // Filter by search term if provided
                    if (searchTerm) {
                        const term = searchTerm.toLowerCase();
                        admins = admins.filter(admin =>
                            admin.name.toLowerCase().includes(term) ||
                            admin.email.toLowerCase().includes(term) ||
                            (admin.organization && admin.organization.toLowerCase().includes(term))
                        );
                    }

                    // Generate table rows
                    if (admins.length > 0) {
                        admins.forEach(admin => {
                            const createdAt = new Date(admin.created_at).toLocaleDateString();

                            tableRows += `
                                <tr>
                                    <td>${admin.id}</td>
                                    <td>${admin.name}</td>
                                    <td>${admin.email}</td>
                                    <td>${admin.organization || 'N/A'}</td>
                                    <td>${createdAt}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-admin-btn" data-id="${admin.id}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-admin-btn" data-id="${admin.id}" data-name="${admin.name}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        tableRows = '<tr><td colspan="6" class="text-center">No administrators found</td></tr>';
                    }

                    // Update table
                    $('#adminsTable tbody').html(tableRows);

                    // Initialize edit and delete buttons
                    initializeAdminButtons();
                } else {
                    showAlert('danger', 'Failed to load administrators data.');
                }
            },
            error: function() {
                $('#adminsTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Error loading administrators data</td></tr>');
                showAlert('danger', 'An error occurred while loading administrators data.');
            }
        });
    }

    // Function to show alert message
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        $('#alertContainer').html(alertHtml);

        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }

    // Function to initialize admin buttons
    function initializeAdminButtons() {
        // Edit admin button
        $('.edit-admin-btn').on('click', function() {
            const userId = $(this).data('id');

            // Fetch admin data
            $.ajax({
                url: adminUsersShowUrl.replace('__ID__', userId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const admin = response.data;

                        // Populate form fields
                        $('#edit_admin_id').val(admin.id);
                        $('#edit_admin_name').val(admin.name);
                        $('#edit_admin_email').val(admin.email);
                        $('#edit_admin_organization').val(admin.organization);

                        // Clear password field
                        $('#edit_admin_password').val('');

                        // Show modal
                        $('#editAdminModal').modal('show');
                    } else {
                        showAlert('danger', 'Failed to load admin data.');
                    }
                },
                error: function() {
                    showAlert('danger', 'An error occurred while loading admin data.');
                }
            });
        });

        // Delete admin button
        $('.delete-admin-btn').on('click', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('name');

            // Populate delete modal
            $('#delete_admin_id').val(userId);
            $('#deleteAdminName').text(userName);

            // Show modal
            $('#deleteAdminModal').modal('show');
        });

        // Update admin button
        $('#updateAdminBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');
            const userId = $('#edit_admin_id').val();

            // Reset previous errors
            $('.is-invalid').removeClass('is-invalid');

            // Show loading spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const formData = {
                name: $('#edit_admin_name').val(),
                email: $('#edit_admin_email').val(),
                organization: $('#edit_admin_organization').val(),
                role: $('#edit_admin_role').val(),
                password: $('#edit_admin_password').val(),
                _token: csrfToken,
                _method: 'PUT'
            };

            // Send AJAX request
            $.ajax({
                url: adminUsersUpdateUrl.replace('__ID__', userId),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    // Close modal and show success message
                    $('#editAdminModal').modal('hide');
                    showAlert('success', response.message);

                    // Reload admins table
                    loadAdmins();
                },
                error: function(xhr) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Display validation errors
                        if (errors.name) {
                            $('#edit_admin_name').addClass('is-invalid');
                            $('#editAdminNameError').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#edit_admin_email').addClass('is-invalid');
                            $('#editAdminEmailError').text(errors.email[0]);
                        }
                        if (errors.organization) {
                            $('#edit_admin_organization').addClass('is-invalid');
                            $('#editAdminOrganizationError').text(errors.organization[0]);
                        }
                        if (errors.password) {
                            $('#edit_admin_password').addClass('is-invalid');
                            $('#editAdminPasswordError').text(errors.password[0]);
                        }
                    } else {
                        showAlert('danger', 'An error occurred while updating the admin.');
                    }
                }
            });
        });

        // Confirm delete button
        $('#confirmDeleteAdminBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');
            const userId = $('#delete_admin_id').val();

            // Show loading spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Send AJAX request
            $.ajax({
                url: adminUsersDeleteUrl.replace('__ID__', userId),
                type: 'DELETE',
                data: {
                    _token: csrfToken
                },
                success: function(response) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    // Close modal and show success message
                    $('#deleteAdminModal').modal('hide');
                    showAlert('success', response.message);

                    // Reload admins table
                    loadAdmins();
                },
                error: function(xhr) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    // Close modal and show error message
                    $('#deleteAdminModal').modal('hide');

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        showAlert('danger', xhr.responseJSON.message);
                    } else {
                        showAlert('danger', 'An error occurred while deleting the admin.');
                    }
                }
            });
        });
    }

    $(document).ready(function() {
        // Load admins data
        loadAdmins();

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const passwordInput = $(this).siblings('input');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });

        // Search functionality
        $('#searchBtn').on('click', function() {
            const searchTerm = $('#adminSearch').val();
            loadAdmins(searchTerm);
        });

        // Add admin form submission
        $('#saveAdminBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');

            // Reset previous errors
            $('.is-invalid').removeClass('is-invalid');

            // Show loading spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const formData = {
                name: $('#admin_name').val(),
                email: $('#admin_email').val(),
                organization: $('#admin_organization').val(),
                role: $('#admin_role').val(),
                password: $('#admin_password').val(),
                _token: '{{ csrf_token() }}'
            };

            // Send AJAX request
            $.ajax({
                url: '{{ route("admin.users.store") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    // Close modal and show success message
                    $('#addAdminModal').modal('hide');
                    showAlert('success', response.message);

                    // Reset form
                    $('#addAdminForm')[0].reset();

                    // Reload admins table
                    loadAdmins();
                },
                error: function(xhr) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Display validation errors
                        if (errors.name) {
                            $('#admin_name').addClass('is-invalid');
                            $('#adminNameError').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#admin_email').addClass('is-invalid');
                            $('#adminEmailError').text(errors.email[0]);
                        }
                        if (errors.organization) {
                            $('#admin_organization').addClass('is-invalid');
                            $('#adminOrganizationError').text(errors.organization[0]);
                        }
                        if (errors.password) {
                            $('#admin_password').addClass('is-invalid');
                            $('#adminPasswordError').text(errors.password[0]);
                        }
                    } else {
                        showAlert('danger', 'An error occurred while creating the admin.');
                    }
                }
            });
        });
    });
</script>
@endsection
