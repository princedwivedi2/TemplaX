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
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
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
                        <label for="edit_role" class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role" required>
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
            const formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                organization: $('#organization').val(),
                role: $('#role').val(),
                password: $('#password').val(),
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
