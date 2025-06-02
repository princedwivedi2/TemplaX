
<div class="a4-page">
    <!-- Left: Logo & Info -->
    <div style="flex: 0 0 320px; display: flex; flex-direction: column; align-items: center; justify-content: center; background:rgba(48, 93, 138, 0.26); padding: 48px 24px;">
        <div style="width: 120px; height: 120px; border-radius: 16px; overflow: hidden; background: #f3f4f6; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px;">
            <img id="preview-photo" src="<?php echo e($logoUrl ?? asset('images/default-profile.svg')); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h1 style="margin: 0; font-size: 32px; font-weight: 800; color: #1e293b; text-align: center;"><span id="preview-full_name" data-default="Your Name"><?php echo e($full_name ?? 'Your Name'); ?></span></h1>
        <p style="margin: 8px 0 0 0; font-size: 18px; color: #6366f1; font-weight: 600; text-align: center;"><span id="preview-job_title" data-default="Job Title"><?php echo e($job_title ?? 'Job Title'); ?></span></p>
        <p style="margin: 4px 0 0 0; font-size: 15px; color: #64748b; text-align: center;"><span id="preview-company_name" data-default="Company Name"><?php echo e($company_name ?? 'Company Name'); ?></span></p>
    </div>
    <!-- Right: Details -->
    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; padding: 48px 48px 32px 48px;">
        <div style="display: flex; gap: 32px;">
            <div style="flex: 1; background: #f8fafc; border-radius: 12px; padding: 24px;">
                <h3 style="margin: 0 0 16px 0; font-size: 17px; color: #1e293b; font-weight: 600;">Contact</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div><span style="color:#64748b;">Email:</span> <span id="preview-email" data-default="email@example.com"><?php echo e($email ?? 'email@example.com'); ?></span></div>
                    <div><span style="color:#64748b;">Phone:</span> <span id="preview-phone" data-default="+1 234 567 890"><?php echo e($phone ?? '+1 234 567 890'); ?></span></div>
                </div>
            </div>
            <div style="flex: 1; background: #f8fafc; border-radius: 12px; padding: 24px;">
                <h3 style="margin: 0 0 16px 0; font-size: 17px; color: #1e293b; font-weight: 600;">Location & Web</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div><span style="color:#64748b;">Address:</span> <span id="preview-address" data-default="Your Address"><?php echo e($address ?? 'Your Address'); ?></span></div>
                    <div><span style="color:#64748b;">Website:</span> <span id="preview-website" data-default="www.example.com"><?php echo e($website ?? 'www.example.com'); ?></span></div>
                </div>
            </div>
        </div>
        <div style="margin-top: 32px;">
            <h3 style="margin: 0 0 12px 0; font-size: 17px; color: #1e293b; font-weight: 600;">Connect</h3>
            <div style="display: flex; gap: 16px;">
                <a id="preview-linkedin" href="<?php echo e($linkedin ?? '#'); ?>" style="width: 44px; height: 44px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="bi bi-linkedin" style="font-size: 22px; color: #6366f1;"></i></a>
                <a id="preview-twitter" href="<?php echo e($twitter ?? '#'); ?>" style="width: 44px; height: 44px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="bi bi-twitter" style="font-size: 22px; color: #6366f1;"></i></a>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 16px; margin-top: 32px;">
            <div style="font-size: 14px; color: #64748b;">© <?php echo e(date('Y')); ?> <span id="preview-company_name-footer" data-default="Company Name"><?php echo e($company_name ?? 'Company Name'); ?></span></div>
            <div style="font-family: monospace; font-size: 14px; color: #64748b; letter-spacing: 2px;"><?php echo e(strtoupper($full_name ?? 'NAME')); ?></div>
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
  max-width: 900px;
  margin: 0 auto;
  background: #fff;
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: row;
}
@media  print {
  .a4-page {
    width: 297mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    border-radius: 0;
    box-shadow: none;
  }
}
</style> <?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/templates/landscape.blade.php ENDPATH**/ ?>