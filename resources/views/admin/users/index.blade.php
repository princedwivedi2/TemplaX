@extends('layouts.app-dashboard')

@section('title', 'User Management')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle me-1"></i> Add New User
        </button>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item filter-item" href="#" data-filter="all">All Users</a></li>
                    <li><a class="dropdown-item filter-item" href="#" data-filter="admin">Admins Only</a></li>
                    <li><a class="dropdown-item filter-item" href="#" data-filter="user">Regular Users Only</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Role</th>
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

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="organization" class="form-label">Organization</label>
                        <input type="text" class="form-control" id="organization" name="organization" required>
                        <div class="invalid-feedback" id="organizationError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="userType" class="form-label">User Type</label>
                        <select class="form-select" id="userType" name="userType" required>
                            <option value="" selected disabled>Select user type</option>
                            <option value="regular">Regular User</option>
                            <option value="super-admin">Super Admin</option>
                        </select>
                    </div>

                    <div class="mb-3 regular-user-role">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="" selected disabled>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <div class="invalid-feedback" id="roleError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="edit_user_id" name="user_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <div class="invalid-feedback" id="editNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                        <div class="invalid-feedback" id="editEmailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_organization" class="form-label">Organization</label>
                        <input type="text" class="form-control" id="edit_organization" name="organization" required>
                        <div class="invalid-feedback" id="editOrganizationError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_userType" class="form-label">User Type</label>
                        <select class="form-select" id="edit_userType" name="userType" required>
                            <option value="" selected disabled>Select user type</option>
                            <option value="regular">Regular User</option>
                            <option value="super-admin">Super Admin</option>
                        </select>
                    </div>

                    <div class="mb-3 edit-regular-user-role">
                        <label for="edit_role" class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role">
                            <option value="" selected disabled>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <div class="invalid-feedback" id="editRoleError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Leave blank to keep current)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_password" name="password">
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="editPasswordError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateUserBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Update User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                <p><strong>User: </strong><span id="deleteUserName"></span></p>
                <input type="hidden" id="delete_user_id">
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

@endsection

@section('scripts')
<script>
    // Function to load users data
    function loadUsers(filter = 'all') {
        // Show loading indicator
        $('#usersTable tbody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>');

        // Send AJAX request
        $.ajax({
            url: adminUsersDataUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let users = response.data;
                    let tableRows = '';

                    // Filter users if needed
                    if (filter !== 'all') {
                        users = users.filter(user => {
                            const userRoles = user.roles.map(role => role.name);
                            return userRoles.includes(filter);
                        });
                    }

                    // Generate table rows
                    if (users.length > 0) {
                        users.forEach(user => {
                            const roles = user.roles.map(role => role.name).join(', ');
                            const createdAt = new Date(user.created_at).toLocaleDateString();

                            tableRows += `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.organization || 'N/A'}</td>
                                    <td><span class="badge ${getBadgeClass(roles)}">${roles}</span></td>
                                    <td>${createdAt}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-user-btn" data-id="${user.id}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-user-btn" data-id="${user.id}" data-name="${user.name}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        tableRows = '<tr><td colspan="7" class="text-center">No users found</td></tr>';
                    }

                    // Update table
                    $('#usersTable tbody').html(tableRows);

                    // Initialize edit and delete buttons
                    initializeUserButtons();
                } else {
                    showAlert('danger', 'Failed to load users data.');
                }
            },
            error: function() {
                $('#usersTable tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading users data</td></tr>');
                showAlert('danger', 'An error occurred while loading users data.');
            }
        });
    }

    // Function to get badge class based on role
    function getBadgeClass(role) {
        if (role.includes('super-admin')) {
            return 'bg-danger';
        } else if (role.includes('admin')) {
            return 'bg-warning';
        } else {
            return 'bg-info';
        }
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

    // Function to initialize user buttons
    function initializeUserButtons() {
        // Edit user button
        $('.edit-user-btn').on('click', function() {
            const userId = $(this).data('id');

            // Fetch user data
            $.ajax({
                url: adminUsersShowUrl.replace('__ID__', userId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const user = response.data;

                        // Populate form fields
                        $('#edit_user_id').val(user.id);
                        $('#edit_name').val(user.name);
                        $('#edit_email').val(user.email);
                        $('#edit_organization').val(user.organization);

                        // Set user type and role
                        if (user.roles && user.roles.length > 0) {
                            const isSuperAdmin = user.roles.some(role => role.name === 'super-admin');

                            if (isSuperAdmin) {
                                $('#edit_userType').val('super-admin');
                                $('.edit-regular-user-role').hide();
                                $('#edit_role').prop('required', false);
                            } else {
                                $('#edit_userType').val('regular');
                                $('.edit-regular-user-role').show();
                                $('#edit_role').prop('required', true);
                                $('#edit_role').val(user.roles[0].name);
                            }
                        }

                        // Clear password field
                        $('#edit_password').val('');

                        // Show modal
                        $('#editUserModal').modal('show');
                    } else {
                        showAlert('danger', 'Failed to load user data.');
                    }
                },
                error: function() {
                    showAlert('danger', 'An error occurred while loading user data.');
                }
            });
        });

        // Delete user button
        $('.delete-user-btn').on('click', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('name');

            // Populate delete modal
            $('#delete_user_id').val(userId);
            $('#deleteUserName').text(userName);

            // Show modal
            $('#deleteUserModal').modal('show');
        });

        // Update user button
        $('#updateUserBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');
            const userId = $('#edit_user_id').val();

            // Reset previous errors
            $('.is-invalid').removeClass('is-invalid');

            // Show loading spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const userType = $('#edit_userType').val();
            const formData = {
                name: $('#edit_name').val(),
                email: $('#edit_email').val(),
                organization: $('#edit_organization').val(),
                password: $('#edit_password').val(),
                _token: csrfToken,
                _method: 'PUT'
            };

            // Add appropriate role information
            if (userType === 'super-admin') {
                formData.is_super_admin = 'true';
            } else {
                formData.role = $('#edit_role').val();
            }

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
                    $('#editUserModal').modal('hide');
                    showAlert('success', response.message);

                    // Reload users table
                    loadUsers();
                },
                error: function(xhr) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Display validation errors
                        if (errors.name) {
                            $('#edit_name').addClass('is-invalid');
                            $('#editNameError').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#edit_email').addClass('is-invalid');
                            $('#editEmailError').text(errors.email[0]);
                        }
                        if (errors.organization) {
                            $('#edit_organization').addClass('is-invalid');
                            $('#editOrganizationError').text(errors.organization[0]);
                        }
                        if (errors.role) {
                            $('#edit_role').addClass('is-invalid');
                            $('#editRoleError').text(errors.role[0]);
                        }
                        if (errors.password) {
                            $('#edit_password').addClass('is-invalid');
                            $('#editPasswordError').text(errors.password[0]);
                        }
                    } else {
                        showAlert('danger', 'An error occurred while updating the user.');
                    }
                }
            });
        });

        // Confirm delete button
        $('#confirmDeleteBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');
            const userId = $('#delete_user_id').val();

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
                    $('#deleteUserModal').modal('hide');
                    showAlert('success', response.message);

                    // Reload users table
                    loadUsers();
                },
                error: function(xhr) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    // Close modal and show error message
                    $('#deleteUserModal').modal('hide');

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        showAlert('danger', xhr.responseJSON.message);
                    } else {
                        showAlert('danger', 'An error occurred while deleting the user.');
                    }
                }
            });
        });
    }

    $(document).ready(function() {
        // Load users data
        loadUsers();

        // Filter users
        $('.filter-item').on('click', function(e) {
            e.preventDefault();
            const filter = $(this).data('filter');
            $('#filterDropdown').text($(this).text());
            loadUsers(filter);
        });

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const passwordInput = $(this).siblings('input');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });

        // Handle user type selection in add form
        $('#userType').on('change', function() {
            const userType = $(this).val();
            if (userType === 'super-admin') {
                $('.regular-user-role').hide();
                $('#role').prop('required', false);
            } else {
                $('.regular-user-role').show();
                $('#role').prop('required', true);
            }
        });

        // Handle user type selection in edit form
        $('#edit_userType').on('change', function() {
            const userType = $(this).val();
            if (userType === 'super-admin') {
                $('.edit-regular-user-role').hide();
                $('#edit_role').prop('required', false);
            } else {
                $('.edit-regular-user-role').show();
                $('#edit_role').prop('required', true);
            }
        });

        // Add user form submission
        $('#saveUserBtn').on('click', function() {
            const btn = $(this);
            const spinner = btn.find('.spinner-border');

            // Reset previous errors
            $('.is-invalid').removeClass('is-invalid');

            // Show loading spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const userType = $('#userType').val();
            const formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                organization: $('#organization').val(),
                password: $('#password').val(),
                _token: '{{ csrf_token() }}'
            };

            // Add appropriate role information
            if (userType === 'super-admin') {
                formData.is_super_admin = 'true';
            } else {
                formData.role = $('#role').val();
            }

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
                    $('#addUserModal').modal('hide');
                    showAlert('success', response.message);

                    // Reset form
                    $('#addUserForm')[0].reset();

                    // Reload users table
                    loadUsers();
                },
                error: function(xhr) {
                    // Hide loading spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Display validation errors
                        if (errors.name) {
                            $('#name').addClass('is-invalid');
                            $('#nameError').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#emailError').text(errors.email[0]);
                        }
                        if (errors.organization) {
                            $('#organization').addClass('is-invalid');
                            $('#organizationError').text(errors.organization[0]);
                        }
                        if (errors.role) {
                            $('#role').addClass('is-invalid');
                            $('#roleError').text(errors.role[0]);
                        }
                        if (errors.password) {
                            $('#password').addClass('is-invalid');
                            $('#passwordError').text(errors.password[0]);
                        }
                    } else {
                        showAlert('danger', 'An error occurred while creating the user.');
                    }
                }
            });
        });
    });
</script>
@endsection
