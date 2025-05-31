@extends('layouts.app-dashboard')
@section('content')

<div class="container px-4 py-6">
    <div class="row">
        <div class="col-12">
            {{-- Template Switcher --}}
            <div class="mb-4">
                <label for="template-switch" class="form-label fw-medium">Choose a Template:</label>
                <select id="template-switch" class="form-select" style="max-width: 300px;">
                    @foreach($templates as $slug => $name)
                        <option value="{{ $slug }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Preview (Left Side) --}}
        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" id="template-preview-container">
                    @if(!empty($templates))
                        @php $firstTemplate = array_key_first($templates); @endphp
                        @include("cards.templates.{$firstTemplate}") {{-- default view --}}
                    @endif
                </div>
            </div>
        </div>

        {{-- Form (Right Side) --}}
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Business Card Information</h5>
                    <form id="card-form" class="row g-3" method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data" onsubmit="return handleCardFormSubmit(event)">
                        @csrf
                        <div class="col-12">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" id="job_title" name="job_title" placeholder="Enter your job title" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" id="company_name" name="company_name" placeholder="Enter company name" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" id="website" name="website" placeholder="Enter your website" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="address" placeholder="Enter your address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="linkedin" class="form-label">LinkedIn</label>
                            <input type="url" id="linkedin" name="linkedin" placeholder="Enter your LinkedIn URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="url" id="twitter" name="twitter" placeholder="Enter your Twitter URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="logo" class="form-label">Logo/Photo</label>
                            <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="template" id="template-hidden" value="{{ array_key_first($templates) }}">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const templateSwitch = document.getElementById('template-switch');
    const container = document.getElementById('template-preview-container');
    const form = document.getElementById('card-form');
    let currentTemplate = templateSwitch.value;

    // --- Helper: Update preview fields with current form data ---
    function updatePreviewFields(template) {
        // Template-specific ID mappings
        const templateMappings = {
            'minimal': {
                prefix: 'corporate',
                fields: ['name', 'role', 'company', 'email', 'phone', 'website', 'address', 'linkedin', 'twitter', 'photo']
            },
            'modern': {
                prefix: 'modern',
                fields: ['name', 'role', 'company', 'email', 'phone', 'website', 'address', 'linkedin', 'twitter', 'photo']
            },
            'classic': {
                prefix: 'corporate',
                fields: ['name', 'role', 'company', 'email', 'phone', 'website', 'address', 'linkedin', 'twitter', 'photo']
            },
            'landscape': {
                prefix: 'landscape',
                fields: ['name', 'role', 'company', 'email', 'phone', 'website', 'address', 'linkedin', 'twitter', 'photo']
            },
            'portrait': {
                prefix: 'portrait',
                fields: ['name', 'role', 'company', 'email', 'phone', 'website', 'address', 'linkedin', 'twitter', 'photo']
            }
        };

        const currentMapping = templateMappings[template] || templateMappings['minimal'];
        const prefix = currentMapping.prefix;

        // Get all form data
        const formData = new FormData(form);
        
        // Update text fields
        const fieldMappings = {
            'full_name': 'name',
            'job_title': 'role',
            'company_name': 'company',
            'email': 'email',
            'phone': 'phone',
            'website': 'website',
            'address': 'address',
            'linkedin': 'linkedin',
            'twitter': 'twitter'
        };

        // Update each field in the preview
        Object.entries(fieldMappings).forEach(([inputName, field]) => {
            const value = formData.get(inputName) || '';
            const elementId = `${field}-${prefix}`;
            const element = document.getElementById(elementId);
            
            if (element) {
                if (element.tagName === 'A') {
                    element.href = value;
                } else {
                    element.textContent = value;
                }
            }
        });

        // Handle logo/photo
        const logoInput = document.getElementById('logo');
        if (logoInput && logoInput.files && logoInput.files[0]) {
            const reader = new FileReader();
            reader.onload = () => {
                const photoElement = document.getElementById(`photo-${prefix}`);
                if (photoElement && photoElement.tagName === 'IMG') {
                    photoElement.src = reader.result;
                }
            };
            reader.readAsDataURL(logoInput.files[0]);
        }
    }

    // --- Real-time preview update ---
    function bindFormInputs() {
        // Bind to all form inputs
        const formInputs = form.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', () => updatePreviewFields(currentTemplate));
            input.addEventListener('change', () => updatePreviewFields(currentTemplate));
        });

        // Special handling for file input
        const logoInput = document.getElementById('logo');
        if (logoInput) {
            logoInput.addEventListener('change', () => {
                const file = logoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const templateMappings = {
                            'minimal': 'corporate',
                            'modern': 'modern',
                            'classic': 'corporate',
                            'landscape': 'landscape',
                            'portrait': 'portrait'
                        };
                        const prefix = templateMappings[currentTemplate] || 'corporate';
                        const photoElement = document.getElementById(`photo-${prefix}`);
                        if (photoElement && photoElement.tagName === 'IMG') {
                            photoElement.src = e.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // Initial setup
    bindFormInputs();
    updatePreviewFields(currentTemplate);

    // Template switching
    templateSwitch.addEventListener('change', async function() {
        const template = this.value;
        currentTemplate = template;
        document.getElementById('template-hidden').value = template;
        
        try {
            const response = await fetch(`{{ route('cards.template.view', '') }}/${template}`);
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to load template');
            }
            
            if (data.success && data.html) {
                // Update the preview container
                container.innerHTML = data.html;
                
                // Update preview with current form data after template is loaded
                setTimeout(() => {
                    updatePreviewFields(template);
                }, 100);
            } else {
                throw new Error(data.message || 'Invalid template data received');
            }
        } catch (error) {
            console.error('Template loading error:', error);
            alert(error.message || 'Failed to load template. Please try again.');
            // Reset to previous template
            templateSwitch.value = currentTemplate;
        }
    });
});

function handleCardFormSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    
    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.data) {
            // Redirect to preview page
            window.location.href = `/cards/${data.data.id}/preview`;
        } else {
            throw new Error(data.message || 'Failed to create card');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert(error.message || 'An error occurred while submitting the form.');
        // Reset button state
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    });
    return false;
}
</script>
@endsection
