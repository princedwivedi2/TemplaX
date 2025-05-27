@extends('layouts.app-dashboard')

@section('title', 'Create Business Card')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
    .card-preview-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
    .card-preview-box {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        padding: 2rem 2.5rem;
        min-width: 320px;
        max-width: 100%;
        min-height: 250px;
        margin-bottom: 2rem;
        width: 100%;
    }
    .color-picker-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .color-picker-wrapper input[type="color"] {
        padding: 0;
        width: 50px;
        height: 38px;
        margin-right: 10px;
    }
    .color-picker-wrapper input[type="text"] {
        flex: 1;
    }
    @media (max-width: 768px) {
        .card-preview-box {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Create Business Card</h2>
    <form id="cardForm" enctype="multipart/form-data" method="POST" action="{{ route('cards.store') }}" autocomplete="off">
        @csrf
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="job_title" class="form-label">Job Title</label>
                    <input type="text" name="job_title" id="job_title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" name="website" id="website" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="linkedin" class="form-label">LinkedIn</label>
                    <input type="url" name="linkedin" id="linkedin" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="twitter" class="form-label">Twitter</label>
                    <input type="url" name="twitter" id="twitter" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="template" class="form-label">Template</label>
                    <select name="template" id="template" class="form-select" required>
                        <option value="">-- Select Template --</option>
                     
                    </select>
                </div>
                <div class="mb-3">
                    <label for="primary_color" class="form-label">Primary Color</label>
                    <div class="color-picker-wrapper">
                        <input type="color" id="primary_color_picker" value="#000000" class="form-control">
                        <input type="text" name="primary_color" id="primary_color" class="form-control" value="#000000" required pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="accent_color" class="form-label">Accent Color</label>
                    <div class="color-picker-wrapper">
                        <input type="color" id="accent_color_picker" value="#333333" class="form-control">
                        <input type="text" name="accent_color" id="accent_color" class="form-control" value="#333333" required pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                </div>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <button type="button" id="downloadPdfBtn" class="btn btn-primary">Download PDF</button>
                    <button type="submit" class="btn btn-success">Save Card</button>
                </div>
            </div>
            <div class="col-12 col-lg-6 card-preview-container">
                <div id="cardPreview" class="card-preview-box w-100">
                    <div class="text-muted">Fill out the form, select a template, and preview your card here.</div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function getFormData(form) {
    return new FormData(form);
}

async function renderPreview() {
    const form = document.getElementById('cardForm');
    const previewBox = document.getElementById('cardPreview');
    const fd = getFormData(form);
    try {
        const resp = await fetch("{{ route('cards.preview-template') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: fd
        });
        if (!resp.ok) throw new Error('Preview failed');
        const html = await resp.text();
        previewBox.innerHTML = html;
    } catch (e) {
        previewBox.innerHTML = '<div class="alert alert-danger">Preview failed.</div>';
    }
}

async function downloadPdf() {
    const form = document.getElementById('cardForm');
    const fd = getFormData(form);
    try {
        const resp = await fetch("{{ route('cards.download-temp') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: fd
        });
        if (!resp.ok) throw new Error('PDF download failed');
        const blob = await resp.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'business-card.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    } catch (e) {
        alert('PDF download failed.');
    }
}

// Color picker sync
function setupColorPicker(pickerId, inputId) {
    const picker = document.getElementById(pickerId);
    const input = document.getElementById(inputId);
    
    picker.addEventListener('input', (e) => {
        input.value = e.target.value;
        renderPreview();
    });
    
    input.addEventListener('input', (e) => {
        if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
            picker.value = e.target.value;
            renderPreview();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setupColorPicker('primary_color_picker', 'primary_color');
    setupColorPicker('accent_color_picker', 'accent_color');

    // Add event listeners for all form inputs
    document.querySelectorAll('#cardForm input, #cardForm select').forEach(input => {
        input.addEventListener('input', () => {
            renderPreview();
        });
    });

    // AJAX form submission
    document.getElementById('cardForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        try {
            const resp = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            });
            
            const data = await resp.json();
            
            if (data.success) {
                // Show success message and redirect to cards list
                alert('Business card created successfully!');
                window.location.href = "{{ route('cards.index') }}";
            } else {
                // Show error message
                alert(data.message || 'Failed to create business card');
                submitBtn.disabled = false;
            }
        } catch (e) {
            alert('An error occurred while saving the card');
            submitBtn.disabled = false;
        }
    });

    // Handle Download PDF button
    document.getElementById('downloadPdfBtn').addEventListener('click', function(e) {
        e.preventDefault();
        downloadPdf();
    });

    // Initial preview
    renderPreview();
});
</script>
@endsection
