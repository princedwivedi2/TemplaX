
<?php $__env->startSection('content'); ?>

<div class="container px-4 py-6">
    <div class="row">
        <div class="col-12">
            
            <div class="mb-4">
                <label for="template-switch" class="form-label fw-medium">Choose a Template:</label>
                <select id="template-switch" class="form-select" style="max-width: 300px;">
                    <option value="portrait">Portrait</option>
                    <option value="landscape">Landscape</option>
                    <option value="elegant">Elegant</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" style="background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; height: 900px; min-height: 900px;">
                    <div id="template-preview-container" class="card-wrapper" style="width: 100%; max-width: 842px; aspect-ratio: 842/595; position: relative; transform-origin: center center;">
                        <div id="portrait-template" class="template-variant"><?php echo $__env->make('cards.templates.portrait', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                        <div id="landscape-template" class="template-variant" style="display:none;"><?php echo $__env->make('cards.templates.landscape', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                        <div id="elegant-template" class="template-variant" style="display:none;"><?php echo $__env->make('cards.templates.elegant', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Business Card Information</h5>
                    <form id="card-form" class="row g-3" method="POST" action="<?php echo e(route('cards.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="col-12">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" id="job_title" name="job_title" placeholder="Enter your job title" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" id="company_name" name="company_name" placeholder="Enter company name" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" id="website" name="website" placeholder="Enter your website" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="address" placeholder="Enter your address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="linkedin" class="form-label">LinkedIn</label>
                            <input type="url" id="linkedin" name="linkedin" placeholder="Enter your LinkedIn URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="url" id="twitter" name="twitter" placeholder="Enter your Twitter URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="logo" class="form-label">Logo/Photo</label>
                            <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label for="background_image" class="form-label">Background Image URL</label>
                            <input type="url" id="background_image" name="background_image" placeholder="Enter background image URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="url" id="instagram" name="instagram" placeholder="Enter your Instagram URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" id="facebook" name="facebook" placeholder="Enter your Facebook URL" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="whatsapp" class="form-label">WhatsApp Number</label>
                            <input type="text" id="whatsapp" name="whatsapp" placeholder="Enter your WhatsApp number" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="navigate" class="form-label">Navigate Link</label>
                            <input type="url" id="navigate" name="navigate" placeholder="Enter navigation link (Google Maps, etc.)" class="form-control">
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="template" id="template-hidden" value="portrait">
                            <button type="submit" class="btn btn-primary w-100">Create Business Card</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const templateSwitch = document.getElementById('template-switch');
    const container = document.getElementById('template-preview-container');
    const form = document.getElementById('card-form');
    let currentTemplate = templateSwitch.value;

    function adjustScale() {
        let cardWidth = 595, cardHeight = 842;
        if (currentTemplate === 'landscape') {
            cardWidth = 842; cardHeight = 595;
        }
        const areaWidth = container.parentElement.clientWidth;
        const areaHeight = container.parentElement.clientHeight;
        const scaleX = areaWidth / cardWidth;
        const scaleY = areaHeight / cardHeight;
        const scale = Math.min(scaleX, scaleY, 1);
        container.style.transform = `scale(${scale})`;
        container.style.height = cardHeight + 'px';
        container.style.width = cardWidth + 'px';
    }

    function updatePreviewFields() {
        const formData = new FormData(form);
        formData.forEach((value, key) => {
            const els = document.querySelectorAll('#template-preview-container [id^="preview-' + key + '"]');
            els.forEach(el => {
                if (el.tagName === 'A') {
                    el.href = value || '#';
                } else if (el.tagName === 'IMG') {
                    // Handled below for photo
                } else {
                    el.textContent = value || el.dataset.default || '';
                }
            });
        });
        // Handle photo
        const logoInput = document.getElementById('logo');
        if (logoInput && logoInput.files && logoInput.files[0]) {
            const reader = new FileReader();
            reader.onload = () => {
                document.querySelectorAll('#template-preview-container [id^="preview-photo"]').forEach(photoElement => {
                    if (photoElement && photoElement.tagName === 'IMG') {
                        photoElement.src = reader.result;
                    }
                });
            };
            reader.readAsDataURL(logoInput.files[0]);
        }
        // Handle background image for elegant
        const bgInput = document.getElementById('background_image');
        if (bgInput) {
            document.querySelectorAll('.elegant-bg').forEach(bg => {
                bg.style.backgroundImage = bgInput.value ? `url('${bgInput.value}')` : '';
            });
        }
    }

    function bindFormInputs() {
        const formInputs = form.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', updatePreviewFields);
            input.addEventListener('change', updatePreviewFields);
        });
    }

    templateSwitch.addEventListener('change', function() {
        currentTemplate = this.value;
        document.getElementById('template-hidden').value = currentTemplate;
        // Show/hide templates
        document.getElementById('portrait-template').style.display = (currentTemplate === 'portrait') ? '' : 'none';
        document.getElementById('landscape-template').style.display = (currentTemplate === 'landscape') ? '' : 'none';
        document.getElementById('elegant-template').style.display = (currentTemplate === 'elegant') ? '' : 'none';
        setTimeout(() => {
            updatePreviewFields();
            adjustScale();
        }, 100);
    });

    // Initial state
    document.getElementById('portrait-template').style.display = (currentTemplate === 'portrait') ? '' : 'none';
    document.getElementById('landscape-template').style.display = (currentTemplate === 'landscape') ? '' : 'none';
    document.getElementById('elegant-template').style.display = (currentTemplate === 'elegant') ? '' : 'none';
    adjustScale();
    window.addEventListener('resize', adjustScale);
    updatePreviewFields();
    bindFormInputs();
});
</script>

<style>
.card-wrapper {
    width: 100%;
    max-width: 842px;
    aspect-ratio: 842 / 595;
    position: relative;
    transform-origin: center center;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/create.blade.php ENDPATH**/ ?>