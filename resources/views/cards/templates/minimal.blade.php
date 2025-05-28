<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body {
    margin: 0;
    padding: 0;
    background: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.profile-section-create-wrapper .profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.3);
    z-index: 0;
}

.profile-section-create-wrapper .profile-pic-container,
.profile-card h1,
.profile-card p,
.profile-card .grid {
    position: relative;
    z-index: 1;
}

.profile-section-create-wrapper .profile-pic-container {
    border: 3px solid white;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.profile-section-create-wrapper .icon-circle {
    background-color: rgba(255,255,255,0.15);
    width: 44px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    border: 1px solid #fff;
    transition: transform 0.2s;
}

.profile-section-create-wrapper .icon-circle:hover {
    transform: scale(1.08);
}

.profile-section-create-wrapper .fa-phone { color: #6c5ce7; }
.profile-section-create-wrapper .fa-envelope { color: #0984e3; }
.profile-section-create-wrapper .fa-instagram { color: #dd2850; }
.profile-section-create-wrapper .fa-whatsapp { color: #25D366; }
.profile-section-create-wrapper .fa-facebook-f { color: #005fda; }
.profile-section-create-wrapper .fa-telegram-plane { color: #0088CC; }
.profile-section-create-wrapper .fa-linkedin { color: #0077b5; }
.profile-section-create-wrapper .fa-twitter { color: #1da1f2; }
.profile-section-create-wrapper .fa-globe { color: #28a745; }

.profile-section-create-wrapper .margin-bottom-change {
    margin-bottom: 85px;
}

</style>

  <div class="card-container" style="perspective: 1000px; width: 100%; max-width: 450px; margin: 0 auto;">
    <div class="card" style="width: 100%; height: 100%; position: relative; transform-style: preserve-3d; transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275); border-radius: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); overflow: hidden; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3), 0 5px 15px rgba(0, 0, 0, 0.2);">

        <!-- Glassmorphism effect container -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.18); z-index: 1; overflow: hidden;">

            <!-- Decorative elements -->
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; top: -150px; right: -100px; z-index: 0;"></div>
            <div style="position: absolute; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; bottom: -100px; left: -50px; z-index: 0;"></div>
        <!-- Overlay for better text visibility -->
        <div class="card-overlay"></div>
            <!-- Content container -->
            <div style="position: relative; padding: 40px 30px; z-index: 2; text-align: center;">
                <!-- Profile image with floating effect -->
                <div style="width: 140px; height: 140px; position: relative; margin: 0 auto 25px; z-index: 3;">
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: linear-gradient(45deg, rgba(255,255,255,0.2), rgba(255,255,255,0.05)); backdrop-filter: blur(5px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); animation: float 6s ease-in-out infinite; top: 0; left: 0;"></div>
                    <div style="width: 130px; height: 130px; border-radius: 50%; overflow: hidden; position: absolute; top: 5px; left: 5px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); border: 3px solid rgba(255, 255, 255, 0.3);">
                        <img id="photo-minimal" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="{{ $full_name ?? 'Profile' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>

                <!-- Name and title with text shadow for better readability -->
                <h1 id="name-minimal" style="font-size: 32px; font-weight: 700; margin-bottom: 8px; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.1); letter-spacing: 0.5px;">{{ $full_name ?? 'Johnathan Doe' }}</h1>
                <div style="width: 60px; height: 3px; background: rgba(255,255,255,0.7); margin: 12px auto 15px; border-radius: 2px;"></div>
                <p id="role-minimal" style="font-size: 18px; color: rgba(255,255,255,0.95); margin-bottom: 6px; font-weight: 500; letter-spacing: 0.5px;">{{ $job_title ?? 'Marketing Expert' }}</p>
                <p id="company-minimal" style="font-size: 16px; color: rgba(255,255,255,0.85); margin-bottom: 35px; font-weight: 300;">{{ $company_name ?? 'ABC Company' }}</p>
                <!-- Social media icons in modern glass effect design -->
                <div style="display: flex; justify-content: center; gap: 18px; margin-bottom: 25px; flex-wrap: wrap; max-width: 320px; margin-left: auto; margin-right: auto;">
                    <a href="tel:{{ $phone ?? '#' }}" style="text-decoration: none;">
                        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                            <i class="fas fa-phone" style="font-size: 18px; color: white; position: relative; z-index: 2;"></i>
                            <span id="phone-minimal" style="display:none">{{ $phone ?? '' }}</span>
                        </div>
                    </a>
                    <a href="mailto:{{ $email ?? '#' }}" style="text-decoration: none;">
                        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                            <i class="fas fa-envelope" style="font-size: 18px; color: white; position: relative; z-index: 2;"></i>
                            <span id="email-minimal" style="display:none">{{ $email ?? '' }}</span>
                        </div>
                    </a>
                    <a href="{{ $website ?? '#' }}" target="_blank" style="text-decoration: none;">
                        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                            <i class="fas fa-globe" style="font-size: 18px; color: white; position: relative; z-index: 2;"></i>
                            <span id="website-minimal" style="display:none">{{ $website ?? '' }}</span>
                        </div>
                    </a>
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $phone ?? '') }}" target="_blank" style="text-decoration: none;">
                        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                            <i class="fab fa-whatsapp" style="font-size: 18px; color: white; position: relative; z-index: 2;"></i>
                            <span id="whatsapp-minimal" style="display:none">{{ $phone ?? '' }}</span>
                        </div>
                    </a>
                    <a href="{{ $linkedin ?? '#' }}" target="_blank" style="text-decoration: none;">
                        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                            <i class="fab fa-linkedin-in" style="font-size: 18px; color: white; position: relative; z-index: 2;"></i>
                            <span id="linkedin-minimal" style="display:none">{{ $linkedin ?? '' }}</span>
                        </div>
                    </a>
                    <a href="{{ $twitter ?? '#' }}" target="_blank" style="text-decoration: none;">
                        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                            <i class="fab fa-twitter" style="font-size: 18px; color: white; position: relative; z-index: 2;"></i>
                            <span id="twitter-minimal" style="display:none">{{ $twitter ?? '' }}</span>
                        </div>
                    </a>
                </div>

                <!-- Hidden spans for JavaScript binding -->
                <div style="display: none;">
                    <span id="address-minimal">{{ $address ?? '' }}</span>
                    <span id="instagram-minimal">{{ $instagram ?? '' }}</span>
                    <span id="facebook-minimal">{{ $facebook ?? '' }}</span>
                    <span id="telegram-minimal">{{ $telegram ?? '' }}</span>
                </div>

                <!-- Footer watermark -->
                <div style="position: absolute; bottom: 15px; width: 100%; text-align: center; left: 0; font-size: 12px; color: rgba(255,255,255,0.5); font-weight: 300; letter-spacing: 1px;">
                    {{ $full_name ?? 'Johnathan Doe' }} • {{ $company_name ?? 'ABC Company' }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Hover effects for social icons */
a:hover div {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

a:hover div > div {
    opacity: 1;
}
</style>
