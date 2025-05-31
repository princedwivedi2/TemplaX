<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div id="business-card" style="width: 350px; height: 200px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 15px; box-shadow: 0 8px 16px rgba(0,0,0,0.3); padding: 20px; box-sizing: border-box; display: flex; flex-direction: row; align-items: center;">
    <div style="flex: 0 0 100px; display: flex; justify-content: center; align-items: center;">
        <img id="photo-modern" src="<?php echo e($logoUrl ?? asset('images/default-profile.svg')); ?>" alt="Logo" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid white; background: white;">
    </div>
    <div style="flex: 1; margin-left: 20px;">
        <h2 id="name-modern" style="margin: 0 0 5px 0; font-size: 1.5rem; font-weight: 700;"><?php echo e($full_name ?? 'Your Name'); ?></h2>
        <p id="role-modern" style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 500; opacity: 0.85;"><?php echo e($job_title ?? 'Job Title'); ?></p>
        <p id="company-modern" style="margin: 0 0 10px 0; font-size: 1rem; font-weight: 600;"><?php echo e($company_name ?? 'Company Name'); ?></p>
        <div style="font-size: 0.9rem; line-height: 1.3;">
            <p id="email-modern" style="margin: 2px 0;">Email: <a href="mailto:<?php echo e($email ?? 'email@example.com'); ?>" style="color: #cbd5e0; text-decoration: none;"><?php echo e($email ?? 'email@example.com'); ?></a></p>
            <p id="phone-modern" style="margin: 2px 0;">Phone: <span><?php echo e($phone ?? '+1 234 567 890'); ?></span></p>
            <p id="website-modern" style="margin: 2px 0;">Website: <a href="<?php echo e($website ?? '#'); ?>" style="color: #cbd5e0; text-decoration: none;"><?php echo e($website ?? 'www.example.com'); ?></a></p>
            <p id="address-modern" style="margin: 2px 0;">Address: <span><?php echo e($address ?? 'Your Address'); ?></span></p>
            <div style="margin-top: 10px;">
                <a id="linkedin-modern" href="<?php echo e($linkedin ?? '#'); ?>" style="color: #cbd5e0; text-decoration: none; margin-right: 10px;"><i class="fab fa-linkedin"></i> <?php echo e($linkedin ?? 'LinkedIn'); ?></a>
                <a id="twitter-modern" href="<?php echo e($twitter ?? '#'); ?>" style="color: #cbd5e0; text-decoration: none;"><i class="fab fa-twitter"></i> <?php echo e($twitter ?? 'Twitter'); ?></a>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/templates/modern.blade.php ENDPATH**/ ?>