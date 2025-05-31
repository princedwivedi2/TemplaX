
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="mb-4">A4 Business Card Preview</h2>
    <div id="a4-card-preview" style="width: 210mm; height: 297mm; background: #fff; padding: 20mm; box-shadow: 0 0 10px #ccc;">
        
        <?php echo $__env->make("cards.templates." . $card->template, [
            'full_name' => $card->full_name,
            'job_title' => $card->job_title,
            'company_name' => $card->company_name,
            'email' => $card->email,
            'phone' => $card->phone,
            'website' => $card->website,
            'address' => $card->address,
            'linkedin' => $card->linkedin,
            'twitter' => $card->twitter,
            'logoUrl' => $card->logo_url
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/a4-preview.blade.php ENDPATH**/ ?>