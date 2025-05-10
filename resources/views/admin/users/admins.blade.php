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
