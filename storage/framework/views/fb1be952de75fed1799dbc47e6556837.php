

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h1 class="h3 mb-4"><?php echo e(__('messages.my_appointments')); ?></h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == '' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.appointments')); ?>"><?php echo e(__('messages.all')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'pending' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.appointments', ['status' => 'pending'])); ?>"><?php echo e(__('messages.pending')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'confirmed' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.appointments', ['status' => 'confirmed'])); ?>"><?php echo e(__('messages.confirmed')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'completed' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.appointments', ['status' => 'completed'])); ?>"><?php echo e(__('messages.completed')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'cancelled' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.appointments', ['status' => 'cancelled'])); ?>"><?php echo e(__('messages.cancelled')); ?></a>
            </li>
        </ul>

        <?php if(empty($appointments) || count($appointments) === 0): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted"><?php echo e(__('messages.no_appointments_found')); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="card-title mb-1">
                                            <?php echo e($appointment->user ? $appointment->user->name : __('messages.unknown_client')); ?>

                                        </h5>
                                        <p class="text-muted small mb-0">
                                            <?php echo e($appointment->type ?? __('messages.consultation')); ?>

                                        </p>
                                    </div>
                                    <div>
                                        <?php if($appointment->status === 'pending'): ?>
                                            <span class="badge bg-warning"><?php echo e(__('messages.pending')); ?></span>
                                        <?php elseif($appointment->status === 'confirmed'): ?>
                                            <span class="badge bg-success"><?php echo e(__('messages.confirmed')); ?></span>
                                        <?php elseif($appointment->status === 'completed'): ?>
                                            <span class="badge bg-info"><?php echo e(__('messages.completed')); ?></span>
                                        <?php elseif($appointment->status === 'cancelled'): ?>
                                            <span class="badge bg-danger"><?php echo e(__('messages.cancelled')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo e($appointment->status); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <hr>

                                <div class="mb-2">
                                    <strong><?php echo e(__('messages.date')); ?>:</strong>
                                    <?php echo e($appointment->date ? \Carbon\Carbon::parse($appointment->date)->format('M d, Y') : __('messages.not_set')); ?>

                                </div>
                                <div class="mb-2">
                                    <strong><?php echo e(__('messages.time')); ?>:</strong>
                                    <?php echo e($appointment->time ? \Carbon\Carbon::parse($appointment->time)->format('h:i A') : __('messages.not_set')); ?>

                                </div>

                                <?php if($appointment->notes): ?>
                                    <div class="mb-2">
                                        <strong><?php echo e(__('messages.notes')); ?>:</strong>
                                        <p class="mb-0 small"><?php echo e($appointment->notes); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if($appointment->user && $appointment->user->email): ?>
                                    <div class="mb-2 small text-muted">
                                        <?php echo e(__('messages.contact')); ?>: <?php echo e($appointment->user->email); ?>

                                        <?php if($appointment->user->phone): ?>
                                            | <?php echo e($appointment->user->phone); ?>

                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if($appointment->status === 'pending'): ?>
                                    <div class="mt-3 d-flex gap-2">
                                        <form action="<?php echo e(route('lawyer.appointments.accept', $appointment->id)); ?>"
                                            method="POST" class="flex-fill">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="bi bi-check-circle"></i> <?php echo e(__('messages.accept')); ?>

                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('lawyer.appointments.reject', $appointment->id)); ?>"
                                            method="POST" class="flex-fill"
                                            onsubmit="return confirm('<?php echo e(__('messages.confirm_reject_appointment')); ?>');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="bi bi-x-circle"></i> <?php echo e(__('messages.reject')); ?>

                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/appointments.blade.php ENDPATH**/ ?>