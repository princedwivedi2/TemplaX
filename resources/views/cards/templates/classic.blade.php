<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&display=swap" rel="stylesheet">
<style>
body {
  margin: 0;
  padding: 0;
  background: #f4f4f4;
  font-family: 'Segoe UI', sans-serif;
}

.portrait-classic-card {
  width: 320px;
  height: 540px;
  background: #232323;
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
  color: #fff;
  font-family: 'Montserrat', sans-serif;
  padding: 0 28px 32px 28px;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
}
.pcc-top-bar {
  width: 100%;
  height: 16px;
  background: #ff7f2a;
  border-top-left-radius: 18px;
  border-top-right-radius: 18px;
  position: absolute;
  top: 0; left: 0;
}
.pcc-logo {
  margin-top: 36px;
  margin-bottom: 18px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.pcc-logo-icon {
  font-size: 2.1rem;
  color: #ff7f2a;
  margin-bottom: 6px;
}
.pcc-logo-text {
  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  color: #fff;
}
.pcc-photo {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  border: 5px solid #ff7f2a;
  object-fit: cover;
  margin: 0 auto 18px auto;
  background: #fff;
  box-shadow: 0 2px 12px rgba(255,127,42,0.13);
}
.pcc-name {
  font-size: 1.25rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 2px;
  letter-spacing: 0.02em;
}
.pcc-role {
  font-size: 1.05rem;
  color: #ff7f2a;
  font-weight: 700;
  text-align: center;
  margin-bottom: 18px;
  letter-spacing: 0.08em;
}
.pcc-contact {
  text-align: center;
  font-size: 1.01rem;
  color: #e0e0e0;
  margin-bottom: 10px;
}
.pcc-contact i {
  color: #ff7f2a;
  margin-right: 8px;
}
.pcc-divider {
  width: 80%;
  height: 2px;
  background: #ff7f2a;
  margin: 18px auto 10px auto;
  border-radius: 2px;
  opacity: 0.7;
}
.pcc-website {
  text-align: center;
  color: #fff;
  font-size: 1.01rem;
  margin-top: 8px;
  letter-spacing: 0.04em;
  background: #ff7f2a;
  padding: 6px 0;
  border-radius: 6px;
  width: 100%;
  font-weight: 600;
  box-shadow: 0 1px 4px rgba(255,127,42,0.10);
}
@media (max-width: 400px) {
  .portrait-classic-card {
    width: 98vw;
    height: auto;
    padding: 0 8px 18px 8px;
  }
}
</style>
<div class="portrait-classic-card">
  <div class="pcc-top-bar"></div>
  <div class="pcc-logo">
    <div class="pcc-logo-icon">
      <i class="fas fa-gem"></i>
    </div>
    <div class="pcc-logo-text" id="company-classic">{{ $company_name ?? 'Borcelle' }}</div>
  </div>
  <img id="photo-classic" src="{{ $logoUrl ?? asset('images/default-profile.png') }}" alt="Profile Image" class="pcc-photo">
  <div class="pcc-name" id="name-classic">{{ $full_name ?? 'Daniel Gallego' }}</div>
  <div class="pcc-role" id="role-classic">{{ $job_title ?? 'MANAGER' }}</div>
  <div class="pcc-contact"><i class="fas fa-phone"></i><span id="phone-classic">{{ $phone ?? }}</span></div>
  <div class="pcc-contact"><i class="fas fa-envelope"></i><span id="email-classic">{{ $email ??  }}</span></div>
  <div class="pcc-contact"><i class="fas fa-id-badge"></i><span>{{ $address ??  }}</span></div>
  <div class="pcc-divider"></div>
  <div class="pcc-website" id="website-classic">{{ $website ?? '' }}</div>
</div>
