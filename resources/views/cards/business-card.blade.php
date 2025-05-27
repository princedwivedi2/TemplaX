@php
$colors = [
    'modern' => ['bg' => '#ffffff', 'text' => '#333333'],
    'classic' => ['bg' => '#f8f9fa', 'text' => '#000000'],
    'minimal' => ['bg' => '#ffffff', 'text' => '#212529']
];

$templateStyle = $colors[$template] ?? $colors['modern'];
@endphp

<div class="business-card {{ $template }}-template" style="background: {{ $templateStyle['bg'] }}; color: {{ $primary_color }};">
    <div class="card-header">
        @if(isset($logoUrl) && $logoUrl)
        <div class="logo">
            <img src="{{ $logoUrl }}" alt="Company Logo" style="max-width: 100px; max-height: 60px;">
        </div>
        @endif
        <div class="main-info">
            <h2 class="name" style="color: {{ $primary_color }};">{{ $full_name }}</h2>
            <p class="job-title" style="color: {{ $accent_color }};">{{ $job_title }}</p>
            <p class="company" style="color: {{ $accent_color }};">{{ $company_name }}</p>
        </div>
    </div>
    
    <div class="card-body">
        <div class="contact-info">
            @if(isset($email))
            <div class="info-item">
                <i class="bi bi-envelope" style="color: {{ $accent_color }};"></i>
                <span>{{ $email }}</span>
            </div>
            @endif
            
            @if(isset($phone))
            <div class="info-item">
                <i class="bi bi-telephone" style="color: {{ $accent_color }};"></i>
                <span>{{ $phone }}</span>
            </div>
            @endif
            
            @if(isset($website) && $website)
            <div class="info-item">
                <i class="bi bi-globe" style="color: {{ $accent_color }};"></i>
                <span>{{ $website }}</span>
            </div>
            @endif
            
            @if(isset($address) && $address)
            <div class="info-item">
                <i class="bi bi-geo-alt" style="color: {{ $accent_color }};"></i>
                <span>{{ $address }}</span>
            </div>
            @endif
        </div>
        
        @if((isset($linkedin) && $linkedin) || (isset($twitter) && $twitter))
        <div class="social-links" style="color: {{ $accent_color }};">
            @if(isset($linkedin) && $linkedin)
            <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" style="color: {{ $accent_color }};">
                <i class="bi bi-linkedin"></i>
            </a>
            @endif
            
            @if(isset($twitter) && $twitter)
            <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" style="color: {{ $accent_color }};">
                <i class="bi bi-twitter"></i>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

<style>
.business-card {
    padding: 2rem;
    border-radius: 8px;
    font-family: 'Nunito', sans-serif;
}

.card-header {
    margin-bottom: 1.5rem;
    text-align: center;
}

.logo {
    margin-bottom: 1rem;
}

.name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.job-title, .company {
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.contact-info {
    margin-top: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.info-item i {
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

.social-links {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-links a {
    text-decoration: none;
    font-size: 1.25rem;
}

/* Template-specific styles */
.modern-template {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.classic-template {
    border: 2px solid #dee2e6;
}

.minimal-template {
    border: 1px solid #eee;
}
</style>
