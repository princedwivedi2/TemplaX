<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&display=swap" rel="stylesheet">
<style>
.minimal-card {
  width: 320px;
  height: 540px;
  background: #f8f9fa;
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.10);
  color: #232323;
  font-family: 'Montserrat', sans-serif;
  padding: 0 28px 32px 28px;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
}
.minimal-accent {
  width: 100%;
  height: 8px;
  background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
  border-top-left-radius: 18px;
  border-top-right-radius: 18px;
  margin-bottom: 24px;
}
.minimal-photo {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  border: 4px solid #43cea2;
  object-fit: cover;
  margin: 24px auto 18px auto;
  background: #fff;
  box-shadow: 0 2px 12px rgba(67,206,162,0.13);
}
.minimal-name {
  font-size: 1.25rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 2px;
  letter-spacing: 0.02em;
}
.minimal-role {
  font-size: 1.05rem;
  color: #43cea2;
  font-weight: 500;
  text-align: center;
  margin-bottom: 18px;
  letter-spacing: 0.08em;
}
.minimal-company {
  font-size: 1.01rem;
  color: #185a9d;
  font-weight: 500;
  text-align: center;
  margin-bottom: 18px;
}
.minimal-contact {
  text-align: center;
  font-size: 1.01rem;
  color: #232323;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}
.minimal-contact i {
  color: #43cea2;
}
.minimal-divider {
  width: 80%;
  height: 2px;
  background: #43cea2;
  margin: 18px auto 10px auto;
  border-radius: 2px;
  opacity: 0.7;
}
.minimal-website {
  text-align: center;
  color: #fff;
  font-size: 1.01rem;
  margin-top: 8px;
  letter-spacing: 0.04em;
  background: #43cea2;
  padding: 6px 0;
  border-radius: 6px;
  width: 100%;
  font-weight: 600;
  box-shadow: 0 1px 4px rgba(67,206,162,0.10);
}
@media (max-width: 400px) {
  .minimal-card {
    width: 98vw;
    height: auto;
    padding: 0 8px 18px 8px;
  }
}
</style>
<div class="minimal-card">
  <div class="minimal-accent"></div>
  <img id="photo-minimal" src="{{ $logoUrl ?? asset('images/default-profile.png') }}" alt="Profile Image" class="minimal-photo">
  <div class="minimal-name" id="name-minimal">{{ $full_name ?? 'John Doe' }}</div>
  <div class="minimal-role" id="role-minimal">{{ $job_title ?? 'Web Developer' }}</div>
  <div class="minimal-company" id="company-minimal">{{ $company_name ?? 'Company Name' }}</div>
  <div class="minimal-contact"><i class="fas fa-phone"></i><span id="phone-minimal">{{ $phone ?? '' }}</span></div>
  <div class="minimal-contact"><i class="fas fa-envelope"></i><span id="email-minimal">{{ $email ?? '' }}</span></div>
  <div class="minimal-contact"><i class="fas fa-map-marker-alt"></i><span id="address-minimal">{{ $address ?? '' }}</span></div>
  <div class="minimal-divider"></div>
  <div class="minimal-website" id="website-minimal">{{ $website ?? '' }}</div>
</div>