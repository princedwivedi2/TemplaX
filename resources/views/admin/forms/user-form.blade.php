<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="POST">
                    @csrf
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="user_name" name="name" required>
                        </div>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="user_email" name="email" required>
                        </div>
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>

                    <!-- Organization Field -->
                    <div class="mb-3">
                        <label for="user_organization" class="form-label">Organization <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" class="form-control" id="user_organization" name="organization" required>
                        </div>
                        <div class="invalid-feedback" id="organizationError"></div>
                    </div>

                    <!-- Role Field -->
                    <div class="mb-3">
                        <label for="user_role" class="form-label">Role <span class="text-danger">*</span></label>
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

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Password <span class="text-danger">*</span></label>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_user_id">

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="invalid-feedback" id="editNameError"></div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="invalid-feedback" id="editEmailError"></div>
                    </div>

                    <!-- Organization Field -->
                    <div class="mb-3">
                        <label for="edit_organization" class="form-label">Organization <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" class="form-control" id="edit_organization" name="organization" required>
                        </div>
                        <div class="invalid-feedback" id="editOrganizationError"></div>
                    </div>

                    <!-- Role Field -->
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="invalid-feedback" id="editRoleError"></div>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password <small>(Leave empty to keep unchanged)</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
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

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user: <strong><span id="deleteUserName"></span></strong>?</p>
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

<script>
$(document).ready(function() {
    // Save User Button Click Handler
    $('#saveUserBtn').on('click', function() {
        const form = $('#addUserForm');
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
            _token: $('input[name="_token"]').val()
        };

        // Validate form data
        let isValid = true;
        if (!formData.name) {
            $('#user_name').addClass('is-invalid');
            $('#nameError').text('The name field is required.');
            isValid = false;
        }
        if (!formData.email) {
            $('#user_email').addClass('is-invalid');
            $('#emailError').text('The email field is required.');
            isValid = false;
        }
        if (!formData.organization) {
            $('#user_organization').addClass('is-invalid');
            $('#organizationError').text('The organization field is required.');
            isValid = false;
        }
        if (!formData.role) {
            $('#user_role').addClass('is-invalid');
            $('#roleError').text('Please select a role.');
            isValid = false;
        }
        if (!formData.password) {
            $('#user_password').addClass('is-invalid');
            $('#passwordError').text('The password field is required.');
            isValid = false;
        }

        if (!isValid) {
            // Hide loading state if validation fails
            btn.prop('disabled', false);
            spinner.addClass('d-none');
            return;
        }

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
                    form[0].reset();
                    $('#addUserModal').modal('hide');

                    // Reload DataTable
                    if (typeof table !== 'undefined') {
                        table.ajax.reload();
                    }
                } else {
                    // Show error message
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
                    // Validation errors from server
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        $(`#user_${field}`).addClass('is-invalid');
                        $(`#${field}Error`).text(errors[field][0]);
                    });
                } else {
                    // Show error message for other errors
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while creating the user. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            }
        });
    });

    // Password toggle functionality
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
