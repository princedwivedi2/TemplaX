

<?php $__env->startSection('title', 'Business Cards'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Business Cards</h5>
            <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Card
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Template</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($card->full_name); ?></td>
                            <td><?php echo e($card->job_title); ?></td>
                            <td><?php echo e($card->company_name); ?></td>
                            <td class="text-capitalize"><?php echo e($card->template); ?></td>
                            <td><?php echo e($card->created_at->format('Y-m-d')); ?></td>
                            <td>
                                <a href="<?php echo e(route('cards.preview', $card)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                                <a href="<?php echo e(route('cards.edit', $card)); ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="<?php echo e(route('cards.destroy', $card)); ?>" method="POST" style="display:inline-block;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this card?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No business cards found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\TemplaX\resources\views/cards/index.blade.php ENDPATH**/ ?>