
<div id="business-card" style="width: 350px; height: 200px; font-family: 'Inter', 'Segoe UI', sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); padding: 0; box-sizing: border-box; position: relative; overflow: hidden;">
    <!-- Decorative Elements -->
    <div style="position: absolute; top: -20px; right: -20px; width: 150px; height: 150px; background: linear-gradient(45deg, #4361ee 0%, #3a0ca3 100%); border-radius: 75px; opacity: 0.2;"></div>
    <div style="position: absolute; bottom: -30px; left: -30px; width: 120px; height: 120px; background: linear-gradient(45deg, #7209b7 0%, #4cc9f0 100%); border-radius: 60px; opacity: 0.2;"></div>

    <!-- Content Wrapper -->
    <div style="position: relative; z-index: 1; height: 100%; display: flex; padding: 25px; box-sizing: border-box;">
        <!-- Left Side - Photo and Social -->
        <div style="width: 35%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding-right: 20px;">
            <div style="width: 90px; height: 90px; border-radius: 45px; overflow: hidden; background: white; padding: 3px; box-shadow: 0 10px 20px -5px rgba(0,0,0,0.3);">
                <img id="photo-landscape" src="<?php echo e($logoUrl ?? asset('images/default-profile.svg')); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 45px;">
            </div>
            <!-- Social Links -->
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <?php if(isset($linkedin) && $linkedin): ?>
                <a href="<?php echo e($linkedin); ?>" id="linkedin-landscape" style="color: #4cc9f0; text-decoration: none; transition: all 0.3s ease;">
                    <i class="bi bi-linkedin" style="font-size: 18px;"></i>
                </a>
                <?php endif; ?>
                <?php if(isset($twitter) && $twitter): ?>
                <a href="<?php echo e($twitter); ?>" id="twitter-landscape" style="color: #4361ee; text-decoration: none; transition: all 0.3s ease;">
                    <i class="bi bi-twitter" style="font-size: 18px;"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Side - Information -->
        <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
            <!-- Header -->
            <div style="margin-bottom: 15px;">
                <h2 id="name-landscape" style="margin: 0; font-size: 24px; font-weight: 700; background: linear-gradient(90deg, #4361ee, #4cc9f0); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo e($full_name ?? 'Your Name'); ?></h2>
                <p id="role-landscape" style="margin: 4px 0 0 0; font-size: 14px; color: #4cc9f0; font-weight: 500;"><?php echo e($job_title ?? 'Job Title'); ?></p>
                <p id="company-landscape" style="margin: 2px 0 0 0; font-size: 14px; color: #e2e8f0;"><?php echo e($company_name ?? 'Company Name'); ?></p>
            </div>

            <!-- Contact Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; font-size: 12px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-envelope" style="color: #4361ee;"></i>
                    <span id="email-landscape" style="color: #e2e8f0;"><?php echo e($email ?? 'email@example.com'); ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-telephone" style="color: #4cc9f0;"></i>
                    <span id="phone-landscape" style="color: #e2e8f0;"><?php echo e($phone ?? '+1 234 567 890'); ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-globe" style="color: #7209b7;"></i>
                    <span id="website-landscape" style="color: #e2e8f0;"><?php echo e($website ?? 'www.example.com'); ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-geo-alt" style="color: #3a0ca3;"></i>
                    <span id="address-landscape" style="color: #e2e8f0;"><?php echo e($address ?? 'Your Address'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Accent -->
    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: linear-gradient(to right, #4361ee, #4cc9f0, #7209b7);"></div>
</div> <?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/templates/landscape.blade.php ENDPATH**/ ?>