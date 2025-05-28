@extends('layouts.app-dashboard')
@section('content')

<div class="container px-4 py-6">
    <div class="row">
        <div class="col-12">
            {{-- Template Switcher --}}
            <div class="mb-4">
                <label for="template-switch" class="form-label fw-medium">Choose a Template:</label>
                <select id="template-switch" class="form-select" style="max-width: 300px;">
                    <option value="modern">Modern (Purple)</option>
                    <option value="minimal">Minimal (Yellow)</option>
                    <option value="classic">Classic (Blue)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Preview (Left Side) --}}
        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" id="template-preview-container">
                    @include('cards.templates.modern') {{-- default view --}}                </div>
            </div>
        </div>

        {{-- Form (Right Side) --}}
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Business Card Information</h5>
                    <form id="card-form" class="row g-3">
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
                        <div class="col-12 mt-4">
                            <button type="button" id="download" class="btn btn-primary w-100">
                                <i class="bi bi-eye me-2"></i>Preview Card
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
const templateSwitch = document.getElementById('template-switch');
const container = document.getElementById('template-preview-container');

// Helper to keep track of current template
let currentTemplate = templateSwitch.value;

function applyLiveBindings(template) {
    currentTemplate = template;

    // Get form inputs
    const fullNameInput = document.getElementById('full_name');
    const jobTitleInput = document.getElementById('job_title');
    const companyNameInput = document.getElementById('company_name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const websiteInput = document.getElementById('website');
    const addressInput = document.getElementById('address');
    const linkedinInput = document.getElementById('linkedin');
    const twitterInput = document.getElementById('twitter');
    const logoInput = document.getElementById('logo');

    // Template element mapping - handle different ID patterns
    const getTemplateElement = (field) => {
        // Try different ID patterns for each template
        const patterns = [
            `${field}-${template}`,
            `${field}-modern`, // fallback for minimal template
            field
        ];

        for (const pattern of patterns) {
            const element = document.getElementById(pattern);
            if (element) return element;
        }
        return null;
    };

    // Set initial values and bind events
    const bindField = (input, fieldName) => {
        if (!input) return;

        const templateElement = getTemplateElement(fieldName);
        if (templateElement) {
            // Set initial value
            templateElement.textContent = input.value || '';

            // Bind input event
            input.oninput = () => {
                templateElement.textContent = input.value || '';
            };
        }
    };

    // Bind all fields
    bindField(fullNameInput, 'name');
    bindField(jobTitleInput, 'role');
    bindField(companyNameInput, 'company');
    bindField(emailInput, 'email');
    bindField(phoneInput, 'phone');
    bindField(websiteInput, 'website');
    bindField(addressInput, 'address');
    bindField(linkedinInput, 'linkedin');
    bindField(twitterInput, 'twitter');

    // Handle logo/photo upload
    if (logoInput) {
        logoInput.onchange = (e) => {
            if (e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = () => {
                    // Try different photo element patterns
                    const photoElement = getTemplateElement('photo') || getTemplateElement('logo');
                    if (photoElement && photoElement.tagName === 'IMG') {
                        photoElement.src = reader.result;
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        };
    }
}

templateSwitch.addEventListener('change', async function () {
    const template = this.value;
    try {
        const res = await fetch(`/cards/templates/${template}`);
        if (!res.ok) throw new Error('Failed to load template');
        const html = await res.text();
        container.innerHTML = html;

        // Apply bindings after template is loaded
        setTimeout(() => {
            applyLiveBindings(template);
        }, 100);
    } catch (error) {
        console.error('Template loading error:', error);
        alert('Failed to load template. Please try again.');
    }
});

// Preview functionality (temporary - will be replaced with PDF generation later)
document.getElementById('download').addEventListener('click', async function() {
    const formData = new FormData(document.getElementById('card-form'));
    formData.append('template', currentTemplate);

    try {
        const response = await fetch('/cards/preview-template', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (response.ok) {
            // Open preview in new window
            const html = await response.text();
            const newWindow = window.open('', '_blank', 'width=800,height=600');
            newWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Business Card Preview</title>
                    <style>
                        body { margin: 0; padding: 20px; background: #f0f0f0; }
                        .preview-container {
                            background: white;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                            max-width: 800px;
                            margin: 0 auto;
                        }
                        .actions {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .btn {
                            background: #007bff;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 4px;
                            cursor: pointer;
                            margin: 0 5px;
                        }
                        .btn:hover { background: #0056b3; }
                    </style>
                </head>
                <body>
                    <div class="preview-container">
                        <div class="actions">
                            <button class="btn" onclick="window.print()">Print</button>
                            <button class="btn" onclick="window.close()">Close</button>
                        </div>
                        ${html}
                    </div>
                </body>
                </html>
            `);
            newWindow.document.close();
        } else {
            throw new Error('Failed to generate preview');
        }
    } catch (error) {
        console.error('Preview error:', error);
        alert('Failed to generate preview. Please try again.');
    }
});

// Initial binding
applyLiveBindings(currentTemplate);
</script>
@endsection
