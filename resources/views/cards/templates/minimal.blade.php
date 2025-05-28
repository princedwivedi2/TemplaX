<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
/* Reset and base styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f0f0;
    padding: 20px;
}

/* Minimal template container */
.minimal-template-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    padding: 20px;
}

/* Profile card */
.minimal-profile-card {
    width: 350px;
    min-height: 500px;
    max-height: 600px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 25px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    padding: 40px 30px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
    margin: 0 auto;
}

/* Background overlay */
.minimal-profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('/images/Group 5.png') center/cover;
    opacity: 0.1;
    z-index: 0;
}

/* Content wrapper */
.minimal-content {
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Profile picture */
.minimal-profile-pic {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    margin: 0 auto 20px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}

.minimal-profile-pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.minimal-profile-pic .default-avatar {
    font-size: 48px;
    color: rgba(255, 255, 255, 0.7);
}

/* Text styles */
.minimal-name {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.minimal-role {
    font-size: 16px;
    opacity: 0.9;
    margin-bottom: 4px;
}

.minimal-company {
    font-size: 14px;
    opacity: 0.8;
    margin-bottom: 30px;
}

/* Icons grid */
.minimal-icons-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    max-width: 240px;
    margin: 0 auto;
}

.minimal-icon-circle {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    backdrop-filter: blur(10px);
}

.minimal-icon-circle:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.minimal-icon-circle i {
    font-size: 20px;
    color: white;
}

/* Specific icon colors on hover */
.minimal-icon-circle:hover .fa-phone { color: #6c5ce7; }
.minimal-icon-circle:hover .fa-envelope { color: #0984e3; }
.minimal-icon-circle:hover .fa-instagram { color: #dd2850; }
.minimal-icon-circle:hover .fa-whatsapp { color: #25D366; }
.minimal-icon-circle:hover .fa-facebook-f { color: #005fda; }
.minimal-icon-circle:hover .fa-telegram-plane { color: #0088CC; }
.minimal-icon-circle:hover .fa-linkedin { color: #0077b5; }
.minimal-icon-circle:hover .fa-twitter { color: #1da1f2; }
.minimal-icon-circle:hover .fa-globe { color: #28a745; }

/* Hidden elements */
.minimal-hidden {
    display: none;
}

/* Responsive design */
@media (max-width: 480px) {
    .minimal-profile-card {
        width: 300px;
        height: 450px;
        padding: 30px 20px;
    }

    .minimal-profile-pic {
        width: 100px;
        height: 100px;
    }

    .minimal-name {
        font-size: 24px;
    }

    .minimal-icons-grid {
        gap: 15px;
        max-width: 200px;
    }

    .minimal-icon-circle {
        width: 45px;
        height: 45px;
    }

    .minimal-icon-circle i {
        font-size: 18px;
    }
}
</style>

<div class="minimal-template-container">
    <div class="minimal-profile-card">
        <div class="minimal-content">
            <!-- Profile Picture -->
            <div class="minimal-profile-pic">
                <img id="photo-minimal" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="{{ $full_name ?? 'Profile' }}">
            </div>

            <!-- Profile Info -->
            <div class="minimal-profile-info">
                <h1 id="name-minimal" class="minimal-name">{{ $full_name ?? 'Johnathan Doe' }}</h1>
                <p id="role-minimal" class="minimal-role">{{ $job_title ?? 'Marketing Expert' }}</p>
                <p id="company-minimal" class="minimal-company">{{ $company_name ?? 'ABC Company' }}</p>
            </div>

            <!-- Contact Icons -->
            <div class="minimal-icons-grid">
                <a href="tel:{{ $phone ?? '#' }}" class="minimal-icon-circle" title="Phone">
                    <i class="fas fa-phone"></i>
                    <span id="phone-minimal" class="minimal-hidden">{{ $phone ?? '' }}</span>
                </a>
                <a href="mailto:{{ $email ?? '#' }}" class="minimal-icon-circle" title="Email">
                    <i class="fas fa-envelope"></i>
                    <span id="email-minimal" class="minimal-hidden">{{ $email ?? '' }}</span>
                </a>
                <a href="{{ $website ?? '#' }}" class="minimal-icon-circle" title="Website" target="_blank">
                    <i class="fas fa-globe"></i>
                    <span id="website-minimal" class="minimal-hidden">{{ $website ?? '' }}</span>
                </a>
                <a href="{{ $linkedin ?? '#' }}" class="minimal-icon-circle" title="LinkedIn" target="_blank">
                    <i class="fab fa-linkedin"></i>
                    <span id="linkedin-minimal" class="minimal-hidden">{{ $linkedin ?? '' }}</span>
                </a>
                <a href="{{ $twitter ?? '#' }}" class="minimal-icon-circle" title="Twitter" target="_blank">
                    <i class="fab fa-twitter"></i>
                    <span id="twitter-minimal" class="minimal-hidden">{{ $twitter ?? '' }}</span>
                </a>
                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $phone ?? '') }}" class="minimal-icon-circle" title="WhatsApp" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    <span id="whatsapp-minimal" class="minimal-hidden">{{ $phone ?? '' }}</span>
                </a>
            </div>

            <!-- Hidden spans for additional JavaScript binding -->
            <div class="minimal-hidden">
                <span id="address-minimal">{{ $address ?? '' }}</span>
                <span id="instagram-minimal">{{ $instagram ?? '' }}</span>
                <span id="facebook-minimal">{{ $facebook ?? '' }}</span>
                <span id="telegram-minimal">{{ $telegram ?? '' }}</span>
            </div>
        </div>
    </div>
</div>