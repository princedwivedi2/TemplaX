<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body {
  margin: 0;
  padding: 0;
  background: #f4f4f4;
  font-family: 'Segoe UI', sans-serif;
}

.business-card {
  width: 700px;
  height: 350px;
  background: white;
  display: flex;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  position: relative;
  margin: 50px auto;
}

.left-section {
  flex: 1;
  background: black;
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.left-section h1 {
  font-size: 32px;
  margin: 0;
}

.left-section p {
  font-size: 18px;
  margin-top: 10px;
}

.right-section {
  flex: 2;
  padding: 30px;
  background: white;
  color: #5a4e4e;
  position: relative;
}

.contact-item {
  margin: 10px 0;
  display: flex;
  align-items: center;
  font-size: 16px;
}

.contact-item i {
  margin-right: 15px;
  color: #c0392b;
  font-size: 20px;
  width: 25px;
}

.curve {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 80px;
  width: 100%;
  background: linear-gradient(to right, black, red, #d3b9b9);
  clip-path: ellipse(100% 100% at 50% 100%);
}

.dotted-line {
  position: absolute;
  left: 33%;
  top: 20px;
  bottom: 20px;
  width: 1px;
  border-left: 2px dotted #a44;
}

.logo {
  margin-top: 20px;
  max-width: 80px;
  max-height: 80px;
  object-fit: contain;
}
    /* Paste same CSS from previous answer here */
  </style>

  <div class="business-card">
    <div class="left-section">
      <div class="profile-image">
        <img id="photo-classic" src="{{ $logoUrl ?? asset('images/default-profile.png') }}" alt="Profile Image" class="logo">
      </div>
    </div>
    <div class="dotted-line"></div>
    <div class="right-section">
      <h1 id="name-classic" class="name">{{ $full_name ?? 'Your Name' }}</h1>
      <p id="role-classic" class="job-title">{{ $job_title ?? 'Job Title' }}</p>
      <p id="company-classic" class="company">{{ $company_name ?? 'Company Name' }}</p>
      
      <div class="contact-info">
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span id="phone-classic">{{ $phone ?? 'Phone Number' }}</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <span id="email-classic">{{ $email ?? 'Email Address' }}</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-globe"></i>
          <span id="website-classic">{{ $website ?? 'Website' }}</span>
        </div>
        <div class="social-links">
          <a href="{{ $linkedin ?? '#' }}" class="social-link">
            <i class="fab fa-linkedin"></i>
            <span id="linkedin-classic" style="display:none">{{ $linkedin ?? '' }}</span>
          </a>
          <a href="{{ $twitter ?? '#' }}" class="social-link">
            <i class="fab fa-twitter"></i>
            <span id="twitter-classic" style="display:none">{{ $twitter ?? '' }}</span>
          </a>
        </div>
      </div>

      <div class="curve"></div>
    </div>
  </div>
