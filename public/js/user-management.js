/**
 * User Management JavaScript
 * Handles AJAX functionality for user and admin management
 */

// Function to load users data
function loadUsers(filter = 'all') {
    // Show loading indicator
    $('#usersTable tbody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>');
    
    // Determine URL based on filter
    let url = adminUsersDataUrl;
    
    // Send AJAX request
    $.ajax({
        url: url,
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
            url: `${adminUsersShowUrl.replace('__ID__', userId)}`,
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
                    
                    // Set role
                    if (user.roles && user.roles.length > 0) {
                        $('#edit_role').val(user.roles[0].name);
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
        const formData = {
            name: $('#edit_name').val(),
            email: $('#edit_email').val(),
            organization: $('#edit_organization').val(),
            role: $('#edit_role').val(),
            password: $('#edit_password').val(),
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
