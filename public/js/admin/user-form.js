$(document).ready(function() {
    // Initialize form submission handler
    $('#saveUserBtn').on('click', function() {
        const btn = $(this);
        const spinner = btn.find('.spinner-border');
        const form = $('#addUserForm');

        // Form validation
        if (!form[0].checkValidity()) {
            form.addClass('was-validated');
            return;
        }

        // Reset previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        form.removeClass('was-validated');

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
            url: adminUsersStoreUrl,
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

                // Refresh DataTable
                if (typeof refreshUserTable === 'function') {
                    refreshUserTable();
                } else {
                    window.location.reload();
                }
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
                        text: xhr.responseJSON?.message || 'Failed to create user. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            }
        });
    });

    // Toggle password visibility
    $('.toggle-password').on('click', function() {
        const input = $(this).closest('.input-group').find('input');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });

    // Reset form when modal is closed
    $('#addUserModal').on('hidden.bs.modal', function() {
        const form = $('#addUserForm');
        form[0].reset();
        form.removeClass('was-validated');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
    });
});
