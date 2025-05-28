@extends('layouts.app-dashboard')

@section('title', 'Template Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Template Management</h2>
                    <p class="text-muted">Manage business card templates for your organization</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                    <i class="bi bi-plus-circle me-2"></i>Add New Template
                </button>
            </div>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="row">
        @forelse($templates as $template)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ $template->name }}</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('templates.preview', $template) }}" target="_blank">
                                <i class="bi bi-eye me-2"></i>Preview
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('templates.edit', $template) }}">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><button class="dropdown-item" onclick="toggleStatus({{ $template->id }})">
                                <i class="bi bi-{{ $template->is_active ? 'pause' : 'play' }} me-2"></i>
                                {{ $template->is_active ? 'Deactivate' : 'Activate' }}
                            </button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item text-danger" onclick="deleteTemplate({{ $template->id }})">
                                <i class="bi bi-trash me-2"></i>Delete
                            </button></li>
                        </ul>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Preview Image -->
                    <div class="template-preview mb-3" style="height: 150px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        @if($template->preview_image)
                            <img src="{{ $template->preview_image_url }}" alt="{{ $template->name }}" class="img-fluid" style="max-height: 100%; max-width: 100%;">
                        @else
                            <div class="text-center text-muted">
                                <i class="bi bi-image fs-1"></i>
                                <p class="mb-0 small">No preview available</p>
                            </div>
                        @endif
                    </div>

                    <!-- Template Info -->
                    <p class="text-muted small mb-2">{{ $template->description ?: 'No description available' }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-{{ $template->is_active ? 'success' : 'secondary' }}">
                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge bg-info">{{ ucfirst($template->category) }}</span>
                    </div>

                    <div class="small text-muted">
                        <div>Used by: {{ $template->business_cards_count }} cards</div>
                        <div>Created: {{ $template->created_at->format('M d, Y') }}</div>
                        @if($template->creator)
                        <div>By: {{ $template->creator->name }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-grid-3x3-gap fs-1 text-muted"></i>
                <h4 class="mt-3">No Templates Found</h4>
                <p class="text-muted">Get started by creating your first template.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                    <i class="bi bi-plus-circle me-2"></i>Create Template
                </button>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Create Template Modal -->
<div class="modal fade" id="createTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createTemplateForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Template Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" required>
                                <div class="form-text">URL-friendly identifier (auto-generated from name)</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="business">Business</option>
                                    <option value="personal">Personal</option>
                                    <option value="creative">Creative</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="preview_image" class="form-label">Preview Image</label>
                        <input type="file" class="form-control" id="preview_image" name="preview_image" accept="image/*">
                        <div class="form-text">Upload a preview image for this template</div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Active (available for use)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const slug = this.value.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Handle form submission
document.getElementById('createTemplateForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("templates.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed to create template'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating the template');
    }
});

// Toggle template status
async function toggleStatus(templateId) {
    try {
        const response = await fetch(`/templates/${templateId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed to update template status'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while updating the template status');
    }
}

// Delete template
async function deleteTemplate(templateId) {
    if (!confirm('Are you sure you want to delete this template? This action cannot be undone.')) {
        return;
    }
    
    try {
        const response = await fetch(`/templates/${templateId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed to delete template'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the template');
    }
}
</script>
@endsection
