

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6">Find Lawyers</h1>
                <p class="text-muted">Browse verified lawyers and view profiles. Use search to narrow results.</p>
            </div>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($lawyer->name ?? 'Unnamed Lawyer'); ?></h5>
                            <p class="card-text text-muted"><?php echo e($lawyer->specialty ?? 'General Practice'); ?></p>
                            <p class="mb-1"><small class="text-muted">Location: <?php echo e($lawyer->city ?? 'Unknown'); ?></small>
                            </p>
                            <a href="<?php echo e(route('lawyers.show', $lawyer->id)); ?>"
                                class="btn btn-sm btn-outline-primary mt-2">View profile</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-6">
                    <p class="lead text-muted">No lawyers found yet. Try seeding sample data: <code>php artisan
                            db:seed</code></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/index.blade.php ENDPATH**/ ?>