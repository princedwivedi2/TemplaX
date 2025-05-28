<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body {
  margin: 0;
  padding: 0;
  background: #f4f4f4;
  font-family: 'Poppins', sans-serif;
}

.business-card {
  width: 700px;
  max-width: 100%;
  height: 350px;
  background: linear-gradient(45deg, #333, #111);
  display: flex;
  border-radius: 15px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2), 0 5px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  position: relative;
  margin: 50px auto;
  transition: transform 0.3s ease;
}

.business-card:hover {
  transform: translateY(-5px);
}

.left-section {
  flex: 1;
  background: linear-gradient(135deg, #000, #333);
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;
  position: relative;
  overflow: hidden;
}

.left-section::before {
  content: '';
  position: absolute;
  width: 150%;
  height: 150%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(0,0,0,0) 70%);
  top: -25%;
  left: -25%;
}

.left-section h1 {
  font-size: 32px;
  margin: 0;
  font-weight: 600;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  position: relative;
  z-index: 2;
}

.left-section p {
  font-size: 18px;
  margin-top: 10px;
  color: rgba(255,255,255,0.8);
  font-weight: 300;
  position: relative;
  z-index: 2;
}

.right-section {
  flex: 2;
  padding: 30px;
  background: white;
  color: #333;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.contact-item {
  margin: 10px 0;
  display: flex;
  align-items: center;
  font-size: 16px;
  position: relative;
  z-index: 2;
}

.contact-item i {
  margin-right: 15px;
  color: #e74c3c;
  font-size: 20px;
  width: 25px;
  text-align: center;
}

.curve {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 80px;
  width: 100%;
  background: linear-gradient(to right, #000, #e74c3c, #f5f5f5);
  clip-path: ellipse(100% 100% at 50% 100%);
}

.dotted-line {
  position: absolute;
  left: 33%;
  top: 20px;
  bottom: 20px;
  width: 1px;
  border-left: 2px dotted rgba(0,0,0,0.1);
}

.logo {
  margin-top: 25px;
  width: 100px;
  height: 100px;
  object-fit: contain;
  border-radius: 50%;
  padding: 5px;
  background: rgba(255,255,255,0.1);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  position: relative;
  z-index: 2;
}

/* Responsive adjustments */
@media (max-width: 700px) {
  .business-card {
    flex-direction: column;
    height: auto;
  }

  .left-section {
    padding: 30px 20px;
  }

  .dotted-line {
    display: none;
  }
}
</style>

<div class="business-card">
  <div class="left-section">
    <h1 id="name-modern">{{ $full_name ?? 'Jane Smith' }}</h1>
    <p id="role-modern">{{ $job_title ?? 'Graphic Designer' }}</p>
    <img id="photo-modern" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="Logo" class="logo">
  </div>

  <div class="dotted-line"></div>

  <div class="right-section">
    <div class="contact-item">
      <i class="fas fa-building"></i> <span id="company-modern">{{ $company_name ?? 'ABC Company' }}</span>
    </div>
    <div class="contact-item">
      <i class="fas fa-envelope"></i> <span id="email-modern">{{ $email ?? 'jane@example.com' }}</span>
    </div>
    <div class="contact-item">
      <i class="fas fa-phone"></i> <span id="phone-modern">{{ $phone ?? '+1 234 567 8900' }}</span>
    </div>
    <div class="contact-item">
      <i class="fas fa-globe"></i> <span id="website-modern">{{ $website ?? 'www.example.com' }}</span>
    </div>
    <div class="contact-item">
      <i class="fas fa-map-marker-alt"></i> <span id="address-modern">{{ $address ?? '123 Main St, City' }}</span>
    </div>
    <div class="contact-item">
      <i class="fab fa-twitter"></i> <span id="twitter-modern">{{ $twitter ?? '@janesmith' }}</span>
    </div>

    <div class="curve"></div>
  </div>
</div>
