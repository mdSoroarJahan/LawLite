

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <h1 class="h3 mb-4"><?php echo e(__('messages.my_appointments')); ?></h1>

        <?php if($appointments->isEmpty()): ?>
            <div class="text-center py-5">
                <p class="text-muted"><?php echo e(__('messages.book_appointment_description')); ?></p>
                <a href="<?php echo e(route('lawyers.index')); ?>" class="btn btn-primary">Find a Lawyer</a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1"><?php echo e($appointment->lawyer->user->name ?? 'Lawyer'); ?></h5>
                                        <p class="text-muted small mb-0"><?php echo e($appointment->type ?? 'Consultation'); ?></p>
                                    </div>
                                    <span
                                        class="badge bg-<?php echo e($appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'warning')); ?>">
                                        <?php echo e(ucfirst($appointment->status)); ?>

                                    </span>
                                </div>

                                <div class="mb-2">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <?php echo e(\Carbon\Carbon::parse($appointment->date)->format('M d, Y')); ?>

                                </div>
                                <div class="mb-3">
                                    <i class="bi bi-clock me-2"></i>
                                    <?php echo e(\Carbon\Carbon::parse($appointment->time)->format('h:i A')); ?>

                                </div>

                                <?php if($appointment->meeting_link): ?>
                                    <a href="<?php echo e($appointment->meeting_link); ?>" target="_blank"
                                        class="btn btn-primary w-100">
                                        <i class="bi bi-camera-video me-2"></i> Join Meeting
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/appointments/index.blade.php ENDPATH**/ ?>