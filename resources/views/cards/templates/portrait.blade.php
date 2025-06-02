<div class="a4-page">
  <!-- Decorative Gradients -->
  <div class="gradient top-right"></div>
  <div class="gradient bottom-left"></div>

  <!-- Header -->
  <div class="header">
    <div class="avatar">
      <img id="preview-photo" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="Logo">
      <div class="overlay"></div>
    </div>
    <div>
      <h1 id="preview-full_name">{{ $full_name ?? 'Your Name' }}</h1>
      <p class="job-title" id="preview-job_title">{{ $job_title ?? 'Job Title' }}</p>
      <p class="company-name" id="preview-company_name">{{ $company_name ?? 'Company Name' }}</p>
    </div>
  </div>

  <!-- Contact Info -->
  <div class="info-row">
    <div class="info-box">
      <h3><i class="bi bi-envelope"></i> Contact</h3>
      <div class="info-item">
        <i class="bi bi-envelope-fill"></i>
        <span id="preview-email">{{ $email ?? 'email@example.com' }}</span>
      </div>
      <div class="info-item">
        <i class="bi bi-telephone-fill"></i>
        <span id="preview-phone">{{ $phone ?? '+1 234 567 890' }}</span>
      </div>
    </div>
    <div class="info-box">
      <h3><i class="bi bi-geo-alt"></i> Location & Web</h3>
      <div class="info-item">
        <i class="bi bi-pin-map-fill"></i>
        <span id="preview-address">{{ $address ?? 'Your Address' }}</span>
      </div>
      <div class="info-item">
        <i class="bi bi-globe"></i>
        <span id="preview-website">{{ $website ?? 'www.example.com' }}</span>
      </div>
    </div>
  </div>

  <!-- Social Links -->
  <div class="social-section">
    <h3>Connect With Me</h3>
    <div class="social-icons">
      <a id="preview-linkedin" href="{{ $linkedin ?? '#' }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
      <a id="preview-twitter" href="{{ $twitter ?? '#' }}" class="twitter"><i class="bi bi-twitter-x"></i></a>
    </div>
  </div>
</div>

<style>
html, body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}
.a4-page {
  width: 100%;
  max-width: 794px;
  margin: 0 auto;
  background: linear-gradient(135deg, #ffffff, #f8fafc);
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  font-family: 'Inter', 'Helvetica Neue', sans-serif;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
  padding: 32px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

/* Gradient Decorations */
.gradient {
  position: absolute;
  border-radius: 50%;
}
.top-right {
  top: -120px;
  right: -120px;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.08), transparent 70%);
}
.bottom-left {
  bottom: -80px;
  left: -80px;
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(236, 72, 153, 0.05), transparent 70%);
}

/* Header */
.header {
  display: flex;
  gap: 32px;
  align-items: center;
  margin-bottom: 32px;
}
.avatar {
  width: 140px;
  height: 140px;
  border-radius: 20px;
  overflow: hidden;
  position: relative;
  background: linear-gradient(45deg,rgba(86, 86, 198, 0.5),rgb(255, 254, 255));
  box-shadow: 0 12px 24px rgba(32, 32, 65, 0.15);
}
.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.9;

}


.header h1 {
  font-size: 42px;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
  letter-spacing: -0.5px;
}
.job-title {
  margin: 8px 0 0;
  font-size: 22px;
  font-weight: 600;
  color: #6366f1;
}
.company-name {
  margin: 8px 0 0;
  font-size: 18px;
  color: #64748b;
  font-weight: 500;
}

/* Info Boxes */
.info-row {
  display: flex;
  gap: 32px;
  margin-bottom: 32px;
}
.info-box {
  flex: 1 1 auto;
  background: rgba(255, 255, 255, 0.75);
  border-radius: 12px;
  padding: 28px;
  backdrop-filter: blur(8px);
  border: 1px solid rgba(226, 232, 240, 0.6);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
}
.info-box h3 {
  margin-bottom: 20px;
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
  display: flex;
  align-items: center;
  gap: 8px;
}
.info-item {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 16px;
  color: #475569;
  margin-bottom: 12px;
}
.info-item i {
  color: #6366f1;
  font-size: 18px;
}

/* Social Icons */
.social-section h3 {
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 16px;
}
.social-icons {
  display: flex;
  gap: 16px;
}
.social-icons a {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 24px;
  text-decoration: none;
  transition: transform 0.3s ease;
}
.social-icons .linkedin {
  background: #0a66c2;
  box-shadow: 0 4px 12px rgba(10, 102, 194, 0.2);
}
.social-icons .twitter {
  background: #000000;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

@media print {
  .a4-page {
    width: 210mm;
    height: 297mm;
    margin: 0;
    padding: 0;
    border-radius: 0;
    box-shadow: none;
  }
}
</style>
