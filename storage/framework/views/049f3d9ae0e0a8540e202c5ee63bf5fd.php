

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">My Cases</h1>
            <a href="<?php echo e(route('lawyer.cases.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Case
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == '' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.cases.index')); ?>">All Cases</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'pending' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.cases.index', ['status' => 'pending'])); ?>">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'in_progress' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.cases.index', ['status' => 'in_progress'])); ?>">In Progress</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'completed' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.cases.index', ['status' => 'completed'])); ?>">Completed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request('status') == 'closed' ? 'active' : ''); ?>"
                    href="<?php echo e(route('lawyer.cases.index', ['status' => 'closed'])); ?>">Closed</a>
            </li>
        </ul>

        <?php if($cases->isEmpty()): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">No cases found</p>
                    <a href="<?php echo e(route('lawyer.cases.create')); ?>" class="btn btn-primary mt-2">Add Your First Case</a>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Case Title</th>
                                <th>Client</th>
                                <th>Hearing Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($case->title); ?></strong>
                                        <?php if($case->case_number): ?>
                                            <br><small class="text-muted"><?php echo e($case->case_number); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($case->client_name); ?>

                                        <?php if($case->client_phone): ?>
                                            <br><small class="text-muted"><?php echo e($case->client_phone); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($case->hearing_date): ?>
                                            <?php echo e($case->hearing_date->format('M d, Y')); ?>

                                            <?php if($case->hearing_time): ?>
                                                <br><small
                                                    class="text-muted"><?php echo e(\Carbon\Carbon::parse($case->hearing_time)->format('h:i A')); ?></small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Not scheduled</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($case->status === 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif($case->status === 'in_progress'): ?>
                                            <span class="badge bg-primary">In Progress</span>
                                        <?php elseif($case->status === 'completed'): ?>
                                            <span class="badge bg-success">Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Closed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('lawyer.cases.show', $case->id)); ?>"
                                                class="btn btn-outline-primary">View</a>
                                            <a href="<?php echo e(route('lawyer.cases.edit', $case->id)); ?>"
                                                class="btn btn-outline-secondary">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <?php echo e($cases->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyer/cases/index.blade.php ENDPATH**/ ?>