

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1><?php echo e($lawyer->name ?? 'Lawyer'); ?></h1>
                <p class="text-muted"><?php echo e($lawyer->specialty ?? 'General practice'); ?></p>
                <p>Location: <?php echo e($lawyer->city ?? 'Unknown'); ?></p>
                <?php if(auth()->guard()->check()): ?>
                    <button class="btn btn-primary" onclick="alert('Chat feature coming soon!')">Message</button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#appointmentModal"
                        data-lawyer-id="<?php echo e($lawyer->id); ?>" data-lawyer-name="<?php echo e($lawyer->name ?? 'Lawyer'); ?>">Book
                        appointment</button>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Sign in to Message</a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary">Sign in to Book</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/show.blade.php ENDPATH**/ ?>