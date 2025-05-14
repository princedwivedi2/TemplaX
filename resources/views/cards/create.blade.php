@extends('layouts.app-dashboard')

@section('title', 'Create Business Card')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
<style>
    :root {
        --bs-primary: #0d6efd;
        --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545;
        --bs-light: #f8f9fa;
        --bs-dark: #212529;
    }

    .template-preview {
        border: 2px solid transparent;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .template-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .template-preview.selected {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .preview-card {
        min-height: 400px;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        background-color: white;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .color-picker {
        width: 40px;
        height: 40px;
        padding: 0;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
    }

    .color-picker::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    .color-picker::-webkit-color-swatch {
        border: none;
        border-radius: 0.375rem;
    }

    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .upload-area:hover {
        border-color: var(--bs-primary);
        background-color: rgba(13, 110, 253, 0.05);
    }

    .font-preview {
        font-size: 1.25rem;
        margin-top: 0.5rem;
    }

    /* Template Selection */
    .template-preview {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        position: relative;
        border: 2px solid transparent;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .template-preview.selected {
        border-color: var(--bs-primary);
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .template-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }
    
    .template-preview .card {
        margin: 0;
        border: none;
    }
    
    /* Logo Upload Area */
    .upload-area {
        border: 2px dashed var(--bs-border-color);
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        background-color: var(--bs-light);
    }
    
    .upload-area:hover {
        border-color: var(--bs-primary);
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .preview-container {
        display: none;
        text-align: center;
    }
    
    .logo-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 1rem auto;
        border-radius: 0.5rem;
    }
    
    /* Color Pickers */
    .color-picker-container {
        position: relative;
    }
    
    .color-picker {
        width: 100%;
        height: 40px;
        padding: 0;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
    }
    
    .color-picker::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    
    .color-picker::-webkit-color-swatch {
        border: none;
        border-radius: 0.375rem;
    }
    
    /* Card Preview */
    .preview-card {
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Form Validation */
    .invalid-feedback {
        display: none;
        font-size: 0.875rem;
        color: var(--bs-danger);
        margin-top: 0.25rem;
    }
    
    .was-validated .form-control:invalid ~ .invalid-feedback,
    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Create Business Card</h1>
            <p class="text-muted mb-0">Design your professional business card</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-secondary me-2" id="previewBtn">
                <i class="bi bi-eye me-2"></i>Preview
            </button>
            <button type="button" class="btn btn-primary" id="saveCardBtn">
                <i class="bi bi-save me-2"></i>Save Card
            </button>
        </div>
    </div>    <form id="cardForm" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="row g-4">
            <!-- Left Column - Card Details -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Card Information</h5>
                        
                        @if(Auth::user()->hasRole('super-admin'))
                            <div class="col-12 mb-4">
                                <h6 class="fw-bold mb-3">Select User</h6>
                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="{{ Auth::id() }}">Create for myself</option>
                                    @foreach(App\Models\User::role(['user', 'admin'])->orderBy('name')->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <div class="form-text">As a Super Admin, you can create cards for other users</div>
                            </div>
                            @endif
                            
                            <!-- Personal Information Section -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name="full_name" required>
                                    <div class="invalid-feedback">Please enter your full name</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="jobTitle" class="form-label">Job Title</label>
                                    <input type="text" class="form-control" id="jobTitle" name="job_title" required>
                                    <div class="invalid-feedback">Please enter your job title</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please enter a valid email address</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                    <div class="invalid-feedback">Please enter your phone number</div>
                                </div>
                            </div>
                        </div>

                        <!-- Company Information Section -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Company Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="company_name" required>
                                    <div class="invalid-feedback">Please enter your company name</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control" id="website" name="website" 
                                           placeholder="https://example.com">
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <div>
                            <h6 class="fw-bold mb-3">Social Media</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="linkedin" class="form-label">
                                        <i class="bi bi-linkedin text-primary me-2"></i>LinkedIn
                                    </label>
                                    <input type="url" class="form-control" id="linkedin" name="linkedin" 
                                           placeholder="https://linkedin.com/in/username">
                                </div>
                                <div class="col-md-6">
                                    <label for="twitter" class="form-label">
                                        <i class="bi bi-twitter text-info me-2"></i>Twitter
                                    </label>
                                    <input type="url" class="form-control" id="twitter" name="twitter" 
                                           placeholder="https://twitter.com/username">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Design Options -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Design Options</h5>
                        
                        <!-- Template Selection -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Select Template</h6>
                            <input type="hidden" name="template" id="selectedTemplate" value="modern">
                            <div class="row g-3">
                                <div class="col-6 col-md-4">
                                    <div class="template-preview selected" data-template="modern">
                                        <div class="card">
                                            <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #0d6efd, #6610f2)">
                                                <div class="text-white">
                                                    <h6 class="mb-3">Modern</h6>
                                                    <div class="placeholder-glow mb-2">
                                                        <span class="placeholder col-6 bg-light opacity-25"></span>
                                                    </div>
                                                    <div class="placeholder-glow mb-3">
                                                        <span class="placeholder col-4 bg-light opacity-25"></span>
                                                    </div>
                                                    <div class="placeholder-glow">
                                                        <span class="placeholder col-8 bg-light opacity-25"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="template-preview" data-template="classic">
                                        <div class="card">
                                            <div class="card-body text-center p-4" style="background: #ffffff">
                                                <div class="text-dark">
                                                    <h6 class="mb-3">Classic</h6>
                                                    <div class="placeholder-glow mb-2">
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                    <div class="placeholder-glow mb-3">
                                                        <span class="placeholder col-4"></span>
                                                    </div>
                                                    <div class="placeholder-glow">
                                                        <span class="placeholder col-8"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="template-preview" data-template="minimal">
                                        <div class="card">
                                            <div class="card-body text-center p-4" style="background: #f8f9fa">
                                                <div class="text-dark">
                                                    <h6 class="mb-3">Minimal</h6>
                                                    <div class="placeholder-glow mb-2">
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                    <div class="placeholder-glow mb-3">
                                                        <span class="placeholder col-4"></span>
                                                    </div>
                                                    <div class="placeholder-glow">
                                                        <span class="placeholder col-8"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Color Scheme -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Color Scheme</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="primaryColor" class="form-label d-block">Primary Color</label>
                                    <input type="color" class="color-picker" id="primaryColor" 
                                           name="primary_color" value="#0d6efd">
                                </div>
                                <div class="col-md-6">
                                    <label for="accentColor" class="form-label d-block">Accent Color</label>
                                    <input type="color" class="color-picker" id="accentColor" 
                                           name="accent_color" value="#6c757d">
                                </div>
                            </div>
                        </div>

                        <!-- Logo Upload -->
                        <div>
                            <h6 class="fw-bold mb-3">Company Logo</h6>
                            <div class="upload-area" id="logoUpload">
                                <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                <p class="mb-0 mt-2">Drop your logo here or <span class="text-primary">browse</span></p>
                                <small class="text-muted">Supported formats: PNG, JPG (Max 2MB)</small>
                                <input type="file" id="logo" name="logo" class="d-none" 
                                       accept="image/png, image/jpeg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Preview -->
            <div class="col-12 col-lg-4">
                <div class="sticky-top pt-4">
                    <div class="preview-card" id="cardPreview">
                        <!-- Preview will be dynamically updated here -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Save Confirmation Modal -->
<div class="modal fade" id="saveConfirmModal" tabindex="-1" aria-labelledby="saveConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveConfirmModalLabel">Save Business Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save this business card?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSaveBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Save Card
                </button>
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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    // Form validation
    function validateForm() {
        let isValid = true;
        const requiredFields = [
            'full_name', 
            'job_title', 
            'email', 
            'phone', 
            'company_name', 
            'template',
            'primary_color',
            'accent_color'
        ];
        
        // Reset validation states
        $('.is-invalid').removeClass('is-invalid');
        
        // Check required fields
        requiredFields.forEach(field => {
            const input = $(`#${field}`);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            }
        });
        
        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test($('#email').val())) {
            $('#email').addClass('is-invalid');
            isValid = false;
        }
        
        // Validate phone format (basic check)
        const phoneRegex = /^[+]?[(]?[0-9]{3}[)]?[-\s.]?[0-9]{3}[-\s.]?[0-9]{4,6}$/;
        if (!phoneRegex.test($('#phone').val())) {
            $('#phone').addClass('is-invalid');
            isValid = false;
        }
        
        // Validate URLs if provided
        const urlFields = ['website', 'linkedin', 'twitter'];
        urlFields.forEach(field => {
            const input = $(`#${field}`);
            if (input.val() && !isValidUrl(input.val())) {
                input.addClass('is-invalid');
                isValid = false;
            }
        });
        
        // Validate file size
        const logo = $('#logo')[0].files[0];
        if (logo && logo.size > 2 * 1024 * 1024) { // 2MB limit
            $('#logo').addClass('is-invalid');
            isValid = false;
        }
        
        return isValid;
    }
    
    function isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }
    
    // Card Form Submission
    $('#cardForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            Swal.fire({
                title: 'Validation Error',
                text: 'Please check the form for errors and try again.',
                icon: 'error',
                confirmButtonColor: 'var(--bs-danger)'
            });
            return;
        }
        
        // Create FormData object to handle file uploads
        const formData = new FormData(this);
        
        // Add CSRF token
        formData.append('_token', '{{ csrf_token() }}');
        
        // Get the save button for loading state
        const saveBtn = $('#saveCardBtn');
        const originalBtnText = saveBtn.html();
        
        // Show loading state
        saveBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...')
            .prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            url: '{{ route('cards.store') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: 'var(--bs-primary)'
                    }).then((result) => {
                        // Redirect to the cards index page
                        window.location.href = '{{ route('cards.index') }}';
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while saving the card.';
                
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    const errorMessages = [];
                    
                    for (const field in errors) {
                        const input = $(`#${field}`);
                        input.addClass('is-invalid');
                        
                        // Add feedback div if not exists
                        if (!input.next('.invalid-feedback').length) {
                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                        } else {
                            input.next('.invalid-feedback').text(errors[field][0]);
                        }
                        
                        errorMessages.push(errors[field][0]);
                    }
                    
                    errorMessage = errorMessages.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showError(errorMessage);
            },
            complete: function() {
                // Reset button state
                saveBtn.html(originalBtnText).prop('disabled', false);
            }
        });
    });
    
    function showError(message) {
        Swal.fire({
            title: 'Error!',
            html: message,
            icon: 'error',
            confirmButtonColor: 'var(--bs-danger)'
        });
    }
    
    // Template Selection
    $('.template-preview').click(function() {
        $('.template-preview').removeClass('selected');
        $(this).addClass('selected');
        $('#selectedTemplate').val($(this).data('template'));
    });

    // Logo Upload Preview
    $('#logo').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#logoPreview').attr('src', e.target.result);
                $('.upload-placeholder').hide();
                $('.preview-container').show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove Logo
    $('#removeLogo').click(function() {
        $('#logo').val('');
        $('#logoPreview').attr('src', '#');
        $('.upload-placeholder').show();
        $('.preview-container').hide();
    });

    // Preview Card
    $('#previewBtn').click(function() {
        // Collect form data
        const formData = new FormData($('#cardForm')[0]);
        const cardData = {};
        formData.forEach((value, key) => {
            cardData[key] = value;
        });

        // Show preview modal with card data
        const template = cardData.template || 'modern';
        const html = generateCardPreview(cardData, template);
        
        Swal.fire({
            title: 'Card Preview',
            html: html,
            width: 800,
            showCloseButton: true,
            showConfirmButton: false
        });
    });
});

function generateCardPreview(data, template) {
    // Template-specific preview generation
    switch(template) {
        case 'modern':
            return `
                <div class="card preview-card" style="background: linear-gradient(135deg, ${data.primary_color}, ${data.accent_color})">
                    <div class="card-body text-white">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                ${data.logo ? `<img src="${URL.createObjectURL(data.logo)}" class="img-fluid mb-3" style="max-height: 100px;">` : ''}
                            </div>
                            <div class="col-md-8">
                                <h3 class="mb-1">${data.full_name}</h3>
                                <p class="mb-2">${data.job_title}</p>
                                <p class="mb-0">${data.company_name}</p>
                            </div>
                        </div>
                        <hr class="border-white">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><i class="bi bi-envelope me-2"></i>${data.email}</p>
                                <p class="mb-1"><i class="bi bi-telephone me-2"></i>${data.phone}</p>
                            </div>
                            <div class="col-md-6">
                                ${data.website ? `<p class="mb-1"><i class="bi bi-globe me-2"></i>${data.website}</p>` : ''}
                                ${data.address ? `<p class="mb-1"><i class="bi bi-geo-alt me-2"></i>${data.address}</p>` : ''}
                            </div>
                        </div>
                        ${(data.linkedin || data.twitter) ? `
                        <div class="text-center mt-3">
                            ${data.linkedin ? `<a href="${data.linkedin}" class="text-white me-3"><i class="bi bi-linkedin"></i></a>` : ''}
                            ${data.twitter ? `<a href="${data.twitter}" class="text-white"><i class="bi bi-twitter"></i></a>` : ''}
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
        // Add more templates here
        default:
            return '<p>Template not found</p>';
    }
}
</script>
@endsection
