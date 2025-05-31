
<div id="business-card" style="width: 350px; height: 200px; font-family: 'Inter', 'Segoe UI', sans-serif; background: #000000; color: white; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); padding: 25px; box-sizing: border-box; position: relative; overflow: hidden;">
    <!-- Decorative Elements -->
    <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: linear-gradient(45deg, #ff6b6b 0%, #feca57 100%); border-radius: 75px; opacity: 0.15;"></div>
    <div style="position: absolute; bottom: -30px; left: -30px; width: 100px; height: 100px; background: linear-gradient(45deg, #4834d4 0%, #686de0 100%); border-radius: 50px; opacity: 0.15;"></div>

    <!-- Content Wrapper -->
    <div style="position: relative; z-index: 1; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
        <!-- Header Section -->
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h2 id="name-modern" style="margin: 0; font-size: 22px; font-weight: 700; background: linear-gradient(90deg, #ff6b6b, #feca57); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo e($full_name ?? 'Your Name'); ?></h2>
                <p id="role-modern" style="margin: 4px 0 0 0; font-size: 14px; color: #e2e8f0;"><?php echo e($job_title ?? 'Job Title'); ?></p>
                <p id="company-modern" style="margin: 2px 0 0 0; font-size: 14px; color: #94a3b8; font-weight: 500;"><?php echo e($company_name ?? 'Company Name'); ?></p>
            </div>
            <div style="width: 60px; height: 60px; position: relative;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(45deg, #ff6b6b, #feca57); border-radius: 12px; transform: rotate(-15deg);"></div>
                <div style="position: absolute; top: 2px; left: 2px; right: 2px; bottom: 2px; border-radius: 10px; overflow: hidden; background: #000000;">
                    <img id="photo-modern" src="<?php echo e($logoUrl ?? asset('images/default-profile.svg')); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- Contact Grid -->
        <div style="margin-top: auto;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; font-size: 12px; color: #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-envelope" style="color: #ff6b6b;"></i>
                    <span id="email-modern"><?php echo e($email ?? 'email@example.com'); ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-telephone" style="color: #feca57;"></i>
                    <span id="phone-modern"><?php echo e($phone ?? '+1 234 567 890'); ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-globe" style="color: #4834d4;"></i>
                    <span id="website-modern"><?php echo e($website ?? 'www.example.com'); ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-geo-alt" style="color: #686de0;"></i>
                    <span id="address-modern"><?php echo e($address ?? 'Your Address'); ?></span>
                </div>
            </div>

            <!-- Social Links -->
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <?php if(isset($linkedin) && $linkedin): ?>
                <a href="<?php echo e($linkedin); ?>" id="linkedin-modern" style="color: #ff6b6b; text-decoration: none; transition: color 0.3s ease;">
                    <i class="bi bi-linkedin"></i>
                </a>
                <?php endif; ?>
                <?php if(isset($twitter) && $twitter): ?>
                <a href="<?php echo e($twitter); ?>" id="twitter-modern" style="color: #feca57; text-decoration: none; transition: color 0.3s ease;">
                    <i class="bi bi-twitter"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/templates/modern.blade.php ENDPATH**/ ?>