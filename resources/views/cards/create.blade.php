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
                    <form id="card-form" class="row g-3">
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
                            <input type="file" id="logo" name="logo" class="form-control" accept="image/*">                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission and validation logic
    const form = document.getElementById('card-form');
        try {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating PDF...';

            const form = document.getElementById('card-form');
            const formData = new FormData(form);
            const template = document.getElementById('template-switch')?.value || 'modern';
            
            const data = {
                template,
                full_name: formData.get('full_name'),
                job_title: formData.get('job_title'),
                company_name: formData.get('company_name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                website: formData.get('website'),
                address: formData.get('address'),
                linkedin: formData.get('linkedin'),
                twitter: formData.get('twitter'),
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            const response = await fetch('{{ route('cards.generate-pdf') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/pdf, application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to generate PDF');
            }

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `business_card_${template}.pdf`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();

            btn.innerHTML = '<i class="bi bi-download me-2"></i>Download PDF';
        } catch (error) {
            console.error('PDF generation failed:', error);
            alert('Failed to generate PDF: ' + error.message);
        } finally {
            btn.disabled = false;
        }
    });
    
    const templateSwitch = document.getElementById('template-switch');
    const container = document.getElementById('template-preview-container');
    const form = document.getElementById('card-form');
    let currentTemplate = templateSwitch.value;

    // --- Helper: Update preview fields with current form data ---
    function updatePreviewFields(template) {
        const getTemplateElement = (field) => {
            const patterns = [
                `${field}-${template}`,
                `${field}-modern`,
                field
            ];
            for (const pattern of patterns) {
                const element = document.getElementById(pattern);
                if (element) return element;
            }
            return null;
        };

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
        Object.entries(fieldMappings).forEach(([inputName, previewField]) => {
            const value = formData.get(inputName) || '';
            const templateElement = getTemplateElement(previewField);
            if (templateElement) {
                templateElement.textContent = value;
            }
        });

        // Handle logo/photo
        const logoInput = document.getElementById('logo');
        if (logoInput && logoInput.files && logoInput.files[0]) {
            const reader = new FileReader();
            reader.onload = () => {
                const photoElement = getTemplateElement('photo') || getTemplateElement('logo');
                if (photoElement && photoElement.tagName === 'IMG') {
                    photoElement.src = reader.result;
                }
            };
            reader.readAsDataURL(logoInput.files[0]);
        }
    }

    // --- Real-time preview update ---
    function bindFormInputs() {
        // Bind to form inputs using event delegation
        form.addEventListener('input', (event) => {
            if (event.target.matches('input, textarea')) {
                updatePreviewFields(currentTemplate);
            }
        });

        // Special handling for file input
        const logoInput = document.getElementById('logo');
        if (logoInput) {
            logoInput.addEventListener('change', () => updatePreviewFields(currentTemplate));
        }
    }

    // Initial setup
    bindFormInputs();
    updatePreviewFields(currentTemplate);

    // Template switching
    templateSwitch.addEventListener('change', async function() {
        const template = this.value;
        currentTemplate = template;
        try {
            const response = await fetch(`/cards/templates/${template}`);
            if (!response.ok) throw new Error('Failed to load template');
            const html = await response.text();
            
            // Update the preview container
            container.innerHTML = html;
            
            // Update preview with current form data
            requestAnimationFrame(() => {
                updatePreviewFields(template);
            });
        } catch (error) {
            console.error('Template loading error:', error);
            alert('Failed to load template. Please try again.');
        }
    });
});
</script>
@endsection
