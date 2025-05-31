
<?php $__env->startSection('content'); ?>

<div class="container px-4 py-6">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Business Card Preview</h5>
                    <div>
                        <button id="download-pdf" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Download as PDF
                        </button>
                        <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-arrow-left me-2"></i>Back to Editor
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 400px;">
                        <div id="card-container" style="transform: scale(1); width: 350px; height: 200px; overflow: hidden;">
                            <?php echo $__env->make("cards.templates.{$card->template}", $data, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay for PDF export (off-screen but visible) -->
<div id="pdf-overlay"
     style="position: absolute; top: 0; left: 0; width: 350px; height: 200px; background: #fff; z-index: 99999; box-shadow: none; overflow: hidden; visibility: hidden;">
    <?php echo $__env->make("cards.templates.{$card->template}", $data, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadButton = document.getElementById('download-pdf');
    const pdfOverlay = document.getElementById('pdf-overlay');

    downloadButton.addEventListener('click', async function() {
        try {
            downloadButton.disabled = true;
            downloadButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating PDF...';

            // Make overlay visible but keep it off-screen
            pdfOverlay.style.visibility = 'visible';
            pdfOverlay.style.position = 'absolute';
            pdfOverlay.style.top = '0';
            pdfOverlay.style.left = '0';

            // Wait for images to load
            const images = pdfOverlay.querySelectorAll('img');
            await Promise.all(Array.from(images).map(img => {
                if (img.complete) return Promise.resolve();
                return new Promise(resolve => { img.onload = img.onerror = resolve; });
            }));

            // PDF options
            const opt = {
                margin: 0,
                filename: '<?php echo e($card->full_name); ?>-business-card.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { 
                    scale: 2,
                    useCORS: true,
                    logging: true,
                    backgroundColor: '#ffffff',
                    width: 350,
                    height: 200,
                    windowWidth: 350,
                    windowHeight: 200,
                    x: 0,
                    y: 0,
                    scrollX: 0,
                    scrollY: 0,
                    onclone: function(clonedDoc) {
                        const cardContainer = clonedDoc.querySelector('#pdf-overlay');
                        if (cardContainer) {
                            cardContainer.style.position = 'absolute';
                            cardContainer.style.top = '0';
                            cardContainer.style.left = '0';
                            cardContainer.style.margin = '0';
                            cardContainer.style.padding = '0';
                            cardContainer.style.visibility = 'visible';
                        }
                    }
                },
                jsPDF: { 
                    unit: 'px', 
                    format: [350, 200],
                    orientation: 'landscape',
                    compress: true
                }
            };

            // Generate PDF
            await html2pdf().set(opt).from(pdfOverlay).save();

            // Reset overlay visibility
            pdfOverlay.style.visibility = 'hidden';

            downloadButton.disabled = false;
            downloadButton.innerHTML = '<i class="bi bi-download me-2"></i>Download as PDF';
        } catch (error) {
            console.error('PDF generation error:', error);
            alert('Failed to generate PDF. Please try again.');
            pdfOverlay.style.visibility = 'hidden';
            downloadButton.disabled = false;
            downloadButton.innerHTML = '<i class="bi bi-download me-2"></i>Download as PDF';
        }
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/preview.blade.php ENDPATH**/ ?>