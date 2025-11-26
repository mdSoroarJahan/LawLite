

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <h3>Lawyer Verification Requests</h3>
        <?php if($lawyers->isEmpty()): ?>
            <div class="alert alert-info">No verification requests.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Lawyer</th>
                            <th>Bar Council ID</th>
                            <th>Documents</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div><strong><?php echo e($l->user->name ?? '—'); ?></strong></div>
                                    <div class="text-muted small"><?php echo e($l->user->email ?? '—'); ?></div>
                                    <div class="text-muted small"><?php echo e($l->city ?? '—'); ?></div>
                                </td>
                                <td><?php echo e($l->bar_council_id ?? '—'); ?></td>
                                <td>
                                    <?php if(is_array($l->documents) && count($l->documents)): ?>
                                        <?php $__currentLoopData = $l->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div><a href="<?php echo e(\Illuminate\Support\Facades\Storage::url($doc)); ?>"
                                                    target="_blank" class="btn btn-sm btn-outline-primary mb-1">View
                                                    <?php echo e(basename($doc)); ?></a></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No documents</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(is_array($l->education)): ?>
                                        <div class="mb-1"><strong>Edu:</strong> <?php echo e(count($l->education)); ?> entries</div>
                                    <?php endif; ?>
                                    <?php if(is_array($l->experience)): ?>
                                        <div class="mb-1"><strong>Exp:</strong> <?php echo e(count($l->experience)); ?> entries</div>
                                    <?php endif; ?>
                                    <?php if(is_array($l->languages)): ?>
                                        <div><strong>Lang:</strong> <?php echo e(implode(', ', $l->languages)); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark"><?php echo e(ucfirst($l->verification_status)); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo e(route('admin.verification.show', $l->id)); ?>"
                                            class="btn btn-sm btn-primary">Review</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/admin/verification/index.blade.php ENDPATH**/ ?>