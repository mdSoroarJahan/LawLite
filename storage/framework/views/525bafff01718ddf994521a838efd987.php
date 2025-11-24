

<?php $__env->startSection('content'); ?>
    <div class="container py-6 text-center">
        <h1 class="display-6"><?php echo e(__('messages.appointments')); ?></h1>
        <p class="text-muted"><?php echo e(__('messages.book_appointment_description')); ?></p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/appointments/index.blade.php ENDPATH**/ ?>