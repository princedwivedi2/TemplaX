<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<div id="business-card" style="width: 350px; height: 200px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: white; color: #333; border-radius: 15px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); padding: 20px; box-sizing: border-box; display: flex; flex-direction: row; border: 1px solid #eee;">
    <div style="flex: 0 0 120px; background: #f8f9fa; border-radius: 10px; padding: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-right: 2px dotted #ddd;">
        <img id="photo-minimal" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="Logo" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
        <h2 id="name-minimal" style="margin: 10px 0 0 0; font-size: 1rem; font-weight: 600; text-align: center;">{{ $full_name ?? 'Your Name' }}</h2>
        <p id="role-minimal" style="margin: 5px 0 0 0; font-size: 0.8rem; color: #666; text-align: center;">{{ $job_title ?? 'Your Title' }}</p>
    </div>
    
    <div style="flex: 1; margin-left: 20px;">
        <p id="company-minimal" style="margin: 0 0 15px 0; font-size: 1.1rem; font-weight: 600; color: #444;">{{ $company_name ?? 'Company Name' }}</p>
        <div style="font-size: 0.85rem; line-height: 1.4;">
            <p id="address-minimal" style="margin: 5px 0;"><i class="fas fa-map-marker-alt" style="width: 16px; color: #666;"></i> {{ $address ?? 'Your Address' }}</p>
            <p id="phone-minimal" style="margin: 5px 0;"><i class="fas fa-phone" style="width: 16px; color: #666;"></i> {{ $phone ?? '+1 234 567 890' }}</p>
            <p id="email-minimal" style="margin: 5px 0;"><i class="fas fa-envelope" style="width: 16px; color: #666;"></i> {{ $email ?? 'email@example.com' }}</p>
            <p id="website-minimal" style="margin: 5px 0;"><i class="fas fa-globe" style="width: 16px; color: #666;"></i> {{ $website ?? 'www.example.com' }}</p>
        </div>
        <div style="margin-top: 10px; font-size: 0.85rem;">
            <a id="linkedin-minimal" href="{{ $linkedin ?? '#' }}" style="color: #0077b5; text-decoration: none; margin-right: 15px;"><i class="fab fa-linkedin"></i> {{ $linkedin ?? 'LinkedIn' }}</a>
            <a id="twitter-minimal" href="{{ $twitter ?? '#' }}" style="color: #1da1f2; text-decoration: none;"><i class="fab fa-twitter"></i> {{ $twitter ?? 'Twitter' }}</a>
        </div>
    </div>
</div>
