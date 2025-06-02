{{-- Elegant Business Card Template --}}
<div class="elegant-card">
  <!-- Top Background Image -->
  <div class="elegant-bg" style="width: 100%; height: 180px; background: url('{{ $backgroundUrl ?? asset('images/card-bg-default.jpg') }}') center/cover no-repeat;"></div>
  <!-- Profile Photo -->
  <div style="width: 110px; height: 110px; border-radius: 50%; overflow: hidden; border: 6px solid #fff; position: absolute; top: 130px; left: 50%; transform: translateX(-50%); box-shadow: 0 4px 16px rgba(0,0,0,0.18); background: #fff;">
    <img id="preview-photo" src="{{ $logoUrl ?? asset('images/default-profile.svg') }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
  </div>
  <!-- Name & Subtitle -->
  <div style="margin-top: 90px; text-align: center; padding: 0 24px;">
    <h1 id="preview-full_name" style="font-size: 2.2rem; font-weight: bold; letter-spacing: 2px; margin-bottom: 0.2em;">{{ $full_name ?? 'EVA LITANY' }}</h1>
    <div style="font-size: 1.1rem; font-family: 'Inter', sans-serif; letter-spacing: 1px; color: #e5e5e5; margin-bottom: 0.5em;">
      <span id="preview-job_title">{{ $job_title ?? 'MANICURE PEDICURE & NAILS' }}</span>
    </div>
    <div style="height: 1px; background: #fff; opacity: 0.15; margin: 18px 0 0 0;"></div>
  </div>
  <!-- Icon Buttons -->
  <div style="margin: 38px 0 0 0; display: flex; flex-wrap: wrap; justify-content: center; gap: 36px; padding: 0 32px;">
    <div class="elegant-icon-col">
      <a href="tel:{{ $phone ?? '' }}" class="elegant-icon-btn"><i class="bi bi-telephone"></i></a>
      <div class="elegant-icon-label">Call Me</div>
    </div>
    <div class="elegant-icon-col">
      <a href="{{ $instagram ?? '#' }}" class="elegant-icon-btn"><i class="bi bi-instagram"></i></a>
      <div class="elegant-icon-label">Instagram</div>
    </div>
    <div class="elegant-icon-col">
      <a href="{{ $facebook ?? '#' }}" class="elegant-icon-btn"><i class="bi bi-facebook"></i></a>
      <div class="elegant-icon-label">Facebook</div>
    </div>
    <div class="elegant-icon-col">
      <a href="https://wa.me/{{ $whatsapp ?? '' }}" class="elegant-icon-btn"><i class="bi bi-whatsapp"></i></a>
      <div class="elegant-icon-label">WhatsApp</div>
    </div>
    <div class="elegant-icon-col">
      <a href="{{ $navigate ?? '#' }}" class="elegant-icon-btn"><i class="bi bi-geo-alt"></i></a>
      <div class="elegant-icon-label">Navigate</div>
    </div>
    <div class="elegant-icon-col">
      <a href="mailto:{{ $email ?? '' }}" class="elegant-icon-btn"><i class="bi bi-envelope"></i></a>
      <div class="elegant-icon-label">E-Mail</div>
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
.elegant-card {
  position: relative;
  background: #111;
  color: #fff;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  width: 100%;
  max-width: 600px;
  margin: 0 auto;
}
.elegant-bg {
  width: 100%;
  height: 180px;
  background-size: cover;
  background-position: center;
}
.elegant-icon-col {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 90px;
}
.elegant-icon-btn {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #111;
  border: 2px solid #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: #fff;
  margin-bottom: 8px;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  box-shadow: 0 2px 8px rgba(0,0,0,0.18);
}
.elegant-icon-btn:hover {
  background: #fff;
  color: #111;
}
.elegant-icon-label {
  font-size: 1rem;
  color: #fff;
  font-family: 'Inter', sans-serif;
  margin-top: 2px;
  letter-spacing: 0.5px;
}
@media (max-width: 700px) {
  .elegant-card { width: 100vw; height: auto; border-radius: 0; }
  .elegant-bg { height: 120px; }
  .elegant-icon-btn { width: 48px; height: 48px; font-size: 1.3rem; }
  .elegant-icon-label { font-size: 0.9rem; }
}
@media print {
  .elegant-card {
    width: 210mm;
    height: 297mm;
    margin: 0;
    padding: 0;
    border-radius: 0;
    box-shadow: none;
  }
}
</style> 