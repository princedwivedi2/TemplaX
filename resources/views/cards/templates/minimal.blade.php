
<div id="business-card" style="width: 350px; height: 200px; font-family: 'Inter', 'Segoe UI', sans-serif; background: linear-gradient(to right, #1e3a8a 30%, #ffffff 30%); color: #1e3a8a; border-radius: 12px; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.2); padding: 0; box-sizing: border-box; position: relative; overflow: hidden;">
    <!-- Left Side (Dark Blue) -->
    <div style="position: absolute; left: 0; top: 0; width: 30%; height: 100%; padding: 25px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div style="width: 70px; height: 70px; border-radius: 35px; overflow: hidden; background: white; padding: 3px;">
            <img id="photo-corporate" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 35px;">
        </div>
        <!-- Social Links -->
        <div style="display: flex; gap: 12px; margin-top: 15px;">
            @if(isset($linkedin) && $linkedin)
            <a href="{{ $linkedin }}" id="linkedin-corporate" style="color: white; text-decoration: none;">
                <i class="bi bi-linkedin"></i>
            </a>
            @endif
            @if(isset($twitter) && $twitter)
            <a href="{{ $twitter }}" id="twitter-corporate" style="color: white; text-decoration: none;">
                <i class="bi bi-twitter"></i>
            </a>
            @endif
        </div>
    </div>

    <!-- Right Side (White) -->
    <div style="margin-left: 30%; height: 100%; padding: 25px; box-sizing: border-box;">
        <!-- Header -->
        <div style="margin-bottom: 15px;">
            <h2 id="name-corporate" style="margin: 0; font-size: 20px; font-weight: 600; color: #1e3a8a;">{{ $full_name ?? 'Your Name' }}</h2>
            <p id="role-corporate" style="margin: 4px 0 0 0; font-size: 14px; color: #64748b;">{{ $job_title ?? 'Job Title' }}</p>
            <p id="company-corporate" style="margin: 2px 0 0 0; font-size: 14px; color: #1e3a8a; font-weight: 500;">{{ $company_name ?? 'Company Name' }}</p>
        </div>

        <!-- Contact Information -->
        <div style="font-size: 12px; color: #64748b;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <i class="bi bi-envelope" style="color: #1e3a8a;"></i>
                <span id="email-corporate">{{ $email ?? 'email@example.com' }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <i class="bi bi-telephone" style="color: #1e3a8a;"></i>
                <span id="phone-corporate">{{ $phone ?? '+1 234 567 890' }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <i class="bi bi-globe" style="color: #1e3a8a;"></i>
                <span id="website-corporate">{{ $website ?? 'www.example.com' }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-geo-alt" style="color:rgba(72, 95, 158, 0.56);"></i>
                <span id="address-corporate">{{ $address ?? 'Your Address' }}</span>
            </div>
        </div>
    </div>

    <!-- Bottom Accent -->
    <div style="position: absolute; bottom: 0; left: 30%; right: 0; height: 4px; background: linear-gradient(to right, #3b82f6, #1e3a8a);"></div>
</div>
