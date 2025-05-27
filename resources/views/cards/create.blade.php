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
            <div class="card">
                <div class="card-body">
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" placeholder="Enter your full name" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" id="role" placeholder="Enter your role" class="form-control">
                        </div>
                       
                         <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" placeholder="Enter your Email" class="form-control">
                        </div>
                         <div class="col-12">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" placeholder="Enter your Phone " class="form-control">
                        </div> 
                        <div class="col-12">
                            <label for="website" class="form-label">Website</label>
                            <input type="text" id="website" placeholder="Enter company Website" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" placeholder="Enter your Address" class="form-control">
                        </div>
                         <div class="col-12">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" id="company" placeholder="Enter company name" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" id="photo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12 mt-4">
                            <button id="download" class="btn btn-primary w-100">
                                <i class="bi bi-download me-2"></i>Download PDF
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
    const map = {
        name: document.getElementById(`name-${template}`),
        role: document.getElementById(`role-${template}`),
        company: document.getElementById(`company-${template}`),
        photo: document.getElementById(`photo-${template}`),
        email: document.getElementById(`email-${template}`),
        phone: document.getElementById(`phone-${template}`),
        website: document.getElementById(`website-${template}`),
        address: document.getElementById(`address-${template}`),
        twitter: document.getElementById(`twitter-${template}`)
    };
    const nameInput = document.getElementById('name');
    const roleInput = document.getElementById('role');
    const companyInput = document.getElementById('company');
    const photoInput = document.getElementById('photo');
    // Add new input fields for email, phone, website, address, twitter
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const websiteInput = document.getElementById('website');
    const addressInput = document.getElementById('address');
    const twitterInput = document.getElementById('twitter');
    // Set initial values
    if (map.name) map.name.textContent = nameInput.value;
    if (map.role) map.role.textContent = roleInput.value;
    if (map.company) map.company.textContent = companyInput.value;
    if (map.email && emailInput) map.email.textContent = emailInput.value;
    if (map.phone && phoneInput) map.phone.textContent = phoneInput.value;
    if (map.website && websiteInput) map.website.textContent = websiteInput.value;
    if (map.address && addressInput) map.address.textContent = addressInput.value;
    if (map.twitter && twitterInput) map.twitter.textContent = twitterInput.value;
    // Bind events
    nameInput.oninput = () => { if (map.name) map.name.textContent = nameInput.value; };
    roleInput.oninput = () => { if (map.role) map.role.textContent = roleInput.value; };
    companyInput.oninput = () => { if (map.company) map.company.textContent = companyInput.value; };
    if (emailInput) emailInput.oninput = () => { if (map.email) map.email.textContent = emailInput.value; };
    if (phoneInput) phoneInput.oninput = () => { if (map.phone) map.phone.textContent = phoneInput.value; };
    if (websiteInput) websiteInput.oninput = () => { if (map.website) map.website.textContent = websiteInput.value; };
    if (addressInput) addressInput.oninput = () => { if (map.address) map.address.textContent = addressInput.value; };
    if (twitterInput) twitterInput.oninput = () => { if (map.twitter) map.twitter.textContent = twitterInput.value; };
    photoInput.onchange = (e) => {
        if (map.photo && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = () => map.photo.src = reader.result;
            reader.readAsDataURL(e.target.files[0]);
        }
    };
}

templateSwitch.addEventListener('change', async function () {
    const template = this.value;
    try {
        const res = await fetch(`/cards/templates/${template}`);
        if (!res.ok) throw new Error('Failed to load template');
        container.innerHTML = res.text ? await res.text() : '';
        applyLiveBindings(template);
    } catch (error) {
        alert('Failed to load template.');
    }
});
// Initial binding
applyLiveBindings(currentTemplate);
</script>
@endsection
