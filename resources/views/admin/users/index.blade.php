@extends('layouts.app-dashboard')

@section('title', 'User Management')
@
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        padding: 1rem;
    }
    
    #usersTable {
        width: 100% !important;
    }
    
    .dataTables_scrollBody {
        min-height: 400px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle me-1"></i> Add New User
        </button>
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
                        @csrf
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="user_name" name="name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="user_email" name="email" required>
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_organization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="user_organization" name="organization" required>
                            <div class="invalid-feedback" id="organizationError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">Role</label>
                            <select class="form-select" id="user_role" name="role" required>
                                <option value="" selected disabled>Select a role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <div class="invalid-feedback" id="roleError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <div class="input-group">
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

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
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
                        <!-- Table data will be loaded dynamically via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    const adminUsersDataUrl = '{{ route('admin.users.data') }}';
</script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#usersTable').DataTable({
            ajax: {
                url: adminUsersDataUrl,
                type: 'GET',
                dataSrc: function(json) {
                    if (json.success) {
                        return json.data;
                    } else {
                        showAlert('danger', 'Failed to load users data.');
                        return [];
                    }
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'organization', defaultContent: 'N/A' },
                { data: 'roles', render: function(data) {
                    return data.map(role => `<span class="badge bg-info">${role}</span>`).join(' ');
                }},
                { data: 'created_at', render: function(data) {
                    return new Date(data).toLocaleDateString();
                }},
                { data: null, render: function(data) {
                    return `
                        <button class="btn btn-sm btn-info edit-user-btn" data-id="${data.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-user-btn" data-id="${data.id}" data-name="${data.name}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }}
            ],
            pageLength: 10, // Number of rows per page
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']], // Page length options
            responsive: true, // Make table responsive
            scrollX: true, // Enable horizontal scrolling
            autoWidth: false, // Disable auto-width calculation
            columnDefs: [
                { width: '5%', targets: 0 }, // ID column
                { width: '15%', targets: 1 }, // Name column
                { width: '20%', targets: 2 }, // Email column
                { width: '15%', targets: 3 }, // Organization column
                { width: '15%', targets: 4 }, // Role column
                { width: '15%', targets: 5 }, // Created At column
                { width: '15%', targets: 6 }  // Actions column
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        });

        // Adjust table when window resizes
        $(window).on('resize', function() {
            table.columns.adjust();
        });

        // Reload table data on filter change
        $('.filter-item').on('click', function(e) {
            e.preventDefault();
            const filter = $(this).data('filter');
            $('#filterDropdown').text($(this).text());
            table.ajax.url(`${adminUsersDataUrl}?filter=${filter}`).load();
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
            const form = $('#addUserForm');

            // Reset previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            // Show loading spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Get form data
            const formData = {
                name: $('#user_name').val(),
                email: $('#user_email').val(),
                organization: $('#user_organization').val(),
                role: $('#user_role').val(),
                password: $('#user_password').val(),
                _token: csrfToken
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

                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: response.message || 'User created successfully!',
                        icon: 'success',
                        confirmButtonColor: '#0d6efd'
                    });

                    // Close modal and reset form
                    $('#addUserModal').modal('hide');
                    form[0].reset();

                    // Reload DataTable
                    table.ajax.reload();
                },
                error: function(xhr) {
                    // Hide loading spinner
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
                        // Show error message
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

        // Edit user button
        $('#usersTable').on('click', '.edit-user-btn', function() {
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
        $('#usersTable').on('click', '.delete-user-btn', function() {
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
                    table.ajax.reload();
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
                    table.ajax.reload();
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
    });
</script>
@endsection

@section('scripts')
<script>
    // Define URLs for AJAX requests
    const adminUsersDataUrl = '{{ route("admin.users.data") }}';
    const adminUsersShowUrl = '{{ route("admin.users.show", ["id" => "__ID__"]) }}';
    const adminUsersUpdateUrl = '{{ route("admin.users.update", ["id" => "__ID__"]) }}';
    const adminUsersDeleteUrl = '{{ route("admin.users.destroy", ["id" => "__ID__"]) }}';
    const csrfToken = '{{ csrf_token() }}';

    $(document).ready(function() {
        // Initialize DataTable with server-side processing
        const table = $('#usersTable').DataTable({
            processing: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
            ajax: {
                url: adminUsersDataUrl,
                type: 'GET',
                dataSrc: function(json) {
                    if (json.success) {
                        return json.data;
                    } else {
                        showAlert('danger', 'Failed to load users data.');
                        return [];
                    }
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'organization', defaultContent: 'N/A' },
                { data: 'roles', render: function(data) {
                    return data.map(role => `<span class="badge bg-info">${role.name}</span>`).join(' ');
                }},
                { data: 'created_at', render: function(data) {
                    return new Date(data).toLocaleDateString();
                }},
                { data: null, render: function(data) {
                    return `
                        <button class="btn btn-sm btn-info edit-user-btn" data-id="${data.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-user-btn" data-id="${data.id}" data-name="${data.name}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }}
            ],
            responsive: true,
            scrollX: true,
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '15%', targets: 1 },
                { width: '20%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '15%', targets: 4 },
                { width: '15%', targets: 5 },
                { width: '15%', targets: 6 }
            ]
        });

        // Handle window resize
        $(window).on('resize', function() {
            table.columns.adjust();
        });

        // Rest of the event handlers...
    });
</script>
@endsection
