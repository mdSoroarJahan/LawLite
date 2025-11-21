

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <h3>Your Appointments</h3>
        <?php if(empty($appointments) || count($appointments) === 0): ?>
            <div class="alert alert-info">No appointments yet.</div>
        <?php else: ?>
            <div class="list-group">
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="list-group-item">
                        <strong><?php echo e($a->client_name ?? 'Client'); ?></strong>
                        <div class="small text-muted"><?php echo e($a->scheduled_at ?? 'Time not set'); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/appointments.blade.php ENDPATH**/ ?>