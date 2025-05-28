@extends('layouts.app-dashboard')
@section('content')

<div class="container px-4 py-6">
    <div class="row">
        <div class="col-12">
            {{-- Template Switcher --}}
            <div class="mb-4">
                <label for="template-switch" class="form-label fw-medium">Choose a Template:</label>
                <select id="template-switch" class="form-select" style="max-width: 300px;">
                    <option value="minimal">Minimal - Modern Glass</option>
                </select>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Select a template from the dropdown above to see a preview.
                    </div>

                    <div id="template-preview" class="mt-4">
                        <!-- Template preview will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load the selected template into the preview area
function loadTemplate(templateName) {
    const previewArea = document.getElementById('template-preview');

    fetch(`/cards/templates/${templateName}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Template not found');
            }
            return response.text();
        })
        .then(html => {
            previewArea.innerHTML = html;
        })
        .catch(error => {
            previewArea.innerHTML = `<div class="alert alert-danger">Error loading template: ${error.message}</div>`;
        });
}

// Initialize with the default template
document.addEventListener('DOMContentLoaded', function() {
    const templateSwitch = document.getElementById('template-switch');
    loadTemplate(templateSwitch.value);

    // Handle template switching
    templateSwitch.addEventListener('change', function() {
        loadTemplate(this.value);
    });
});
</script>
@endsection
