
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
                        <div id="card-container">
                            <?php echo $__env->make("cards.templates.{$card->template}", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadButton = document.getElementById('download-pdf');
    const cardContainer = document.getElementById('card-container');

    downloadButton.addEventListener('click', async function() {
        try {
            // Show loading state
            downloadButton.disabled = true;
            downloadButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating PDF...';

            // Configure PDF options
            const opt = {
                margin: 10,
                filename: 'business-card.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2,
                    useCORS: true,
                    logging: false
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'a4', 
                    orientation: 'portrait' 
                }
            };

            // Generate PDF
            await html2pdf().set(opt).from(cardContainer).save();

            // Reset button state
            downloadButton.disabled = false;
            downloadButton.innerHTML = '<i class="bi bi-download me-2"></i>Download as PDF';
        } catch (error) {
            console.error('PDF generation error:', error);
            alert('Failed to generate PDF. Please try again.');
            
            // Reset button state
            downloadButton.disabled = false;
            downloadButton.innerHTML = '<i class="bi bi-download me-2"></i>Download as PDF';
        }
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/preview.blade.php ENDPATH**/ ?>