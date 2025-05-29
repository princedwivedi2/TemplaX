<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body {
  margin: 0;
  padding: 0;
  background: #f4f4f4;
  font-family: 'Poppins', sans-serif;
}

.business-card-modern {
  width: 400px;
  min-height: 220px;
  background: rgba(34, 40, 49, 0.85);
  border-radius: 22px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18), 0 2px 8px rgba(0,0,0,0.10);
  color: #fff;
  font-family: 'Montserrat', sans-serif;
  display: flex;
  overflow: hidden;
  margin: 32px auto;
  position: relative;
  backdrop-filter: blur(8px);
  border: 1.5px solid rgba(255,255,255,0.18);
  transition: transform 0.2s, box-shadow 0.2s;
}
.business-card-modern:hover {
  transform: translateY(-4px) scale(1.025);
  box-shadow: 0 16px 40px 0 rgba(31, 38, 135, 0.22), 0 4px 16px rgba(0,0,0,0.13);
}
.bc-modern-left {
  background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
  color: #fff;
  width: 120px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 28px 12px;
  position: relative;
}
.bc-modern-left img {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #fff;
  margin-bottom: 18px;
  box-shadow: 0 2px 8px rgba(67,206,162,0.18);
  background: #fff;
}
.bc-modern-left .bc-modern-company {
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 1px;
  text-align: center;
  color: #fff;
  text-shadow: 0 1px 4px rgba(24,90,157,0.12);
}
.bc-modern-right {
  flex: 1;
  padding: 32px 28px 24px 28px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: rgba(255,255,255,0.08);
  border-left: 1.5px solid rgba(255,255,255,0.10);
}
.bc-modern-name {
  font-size: 1.35rem;
  font-weight: 700;
  margin-bottom: 2px;
  letter-spacing: 0.5px;
  color: #fff;
  text-shadow: 0 1px 4px rgba(24,90,157,0.10);
}
.bc-modern-role {
  font-size: 1.05rem;
  font-weight: 400;
  color: #b2fefa;
  margin-bottom: 16px;
}
.bc-modern-contact {
  display: flex;
  flex-direction: column;
  gap: 7px;
  font-size: 0.97rem;
}
.bc-modern-contact i {
  color: #43cea2;
  margin-right: 10px;
  width: 18px;
  text-align: center;
}
.bc-modern-contact span {
  color: #e0e0e0;
}
.bc-modern-social {
  margin-top: 18px;
  display: flex;
  gap: 14px;
}
.bc-modern-social a {
  color: #43cea2;
  font-size: 1.15rem;
  background: rgba(47, 160, 150, 0.63);
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s, color 0.2s;
  box-shadow: 0 1px 4px rgba(24,90,157,0.10);
}
.bc-modern-social a:hover {
  background: #43cea2;
  color: #fff;
}
@media (max-width: 500px) {
  .business-card-modern {
    flex-direction: column;
    width: 98vw;
    min-width: 0;
  }
  .bc-modern-left {
    width: 100%;
    flex-direction: row;
    justify-content: flex-start;
    padding: 16px 12px;
  }
  .bc-modern-left img {
    margin-bottom: 0;
    margin-right: 16px;
  }
}
</style>
<div class="business-card-modern">
  <div class="bc-modern-left">
    <img id="photo-modern" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="Logo">
    <div class="bc-modern-company" id="company-modern">{{ $company_name ?? 'Company Name' }}</div>
  </div>
  <div class="bc-modern-right">
    <div class="bc-modern-name" id="name-modern">{{ $full_name ?? 'Jane Smith' }}</div>
    <div class="bc-modern-role" id="role-modern">{{ $job_title ?? 'Graphic Designer' }}</div>
    <div class="bc-modern-contact">
      <div><i class="fas fa-envelope"></i><span id="email-modern">{{ $email ?? 'jane@example.com' }}</span></div>
      <div><i class="fas fa-phone"></i><span id="phone-modern">{{ $phone ?? '+1 234 567 8900' }}</span></div>
      <div><i class="fas fa-globe"></i><span id="website-modern">{{ $website ?? 'www.example.com' }}</span></div>
      <div><i class="fas fa-map-marker-alt"></i><span id="address-modern">{{ $address ?? '123 Main St, City' }}</span></div>
    </div>
    <div class="bc-modern-social">
      @if(!empty($linkedin))
      <a href="{{ $linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
      @endif
      @if(!empty($twitter))
      <a href="{{ $twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
      @endif
    </div>
  </div>
</div>
