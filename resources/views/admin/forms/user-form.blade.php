<!-- Add User Form Component -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" novalidate>
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

                    <!-- Email Address -->
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

                    <!-- Role Selection -->
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
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="user_password" name="password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="passwordError"></div>
                        <div class="form-text">Password must be at least 8 characters long</div>
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

<!-- Additional CSS for form styling -->
<style>
    .required:after {
        content: ' *';
        color: red;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    .input-group .form-control {
        border-left: none;
    }
    .input-group .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
    }
    .form-control.is-invalid,
    .form-select.is-invalid {
        background-image: none;
    }
    .invalid-feedback {
        font-size: 0.875em;
    }
</style>
