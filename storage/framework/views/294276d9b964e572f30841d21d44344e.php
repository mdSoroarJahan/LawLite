

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h1 class="h3 mb-4">My Cases</h1>

        <?php if($cases->isEmpty()): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">You are not linked to any active cases.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">
                                        <a href="<?php echo e(route('user.cases.show', $case->id)); ?>" class="text-decoration-none">
                                            <?php echo e($case->title); ?>

                                        </a>
                                    </h5>
                                    <?php if($case->status === 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif($case->status === 'in_progress'): ?>
                                        <span class="badge bg-primary">In Progress</span>
                                    <?php elseif($case->status === 'completed'): ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Closed</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-muted small mb-2">
                                    Lawyer: <?php echo e($case->lawyer->user->name ?? 'Unknown'); ?>

                                </p>
                                <p class="card-text text-truncate"><?php echo e($case->description); ?></p>

                                <?php if($case->hearing_date): ?>
                                    <div class="alert alert-light border py-2 px-3 mb-0">
                                        <small class="text-muted d-block">Next Hearing</small>
                                        <strong><?php echo e($case->hearing_date->format('M d, Y')); ?></strong>
                                        <?php if($case->hearing_time): ?>
                                            <span class="text-muted ms-1">at
                                                <?php echo e(\Carbon\Carbon::parse($case->hearing_time)->format('h:i A')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <a href="<?php echo e(route('user.cases.show', $case->id)); ?>"
                                    class="btn btn-outline-primary btn-sm w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/user/cases/index.blade.php ENDPATH**/ ?>