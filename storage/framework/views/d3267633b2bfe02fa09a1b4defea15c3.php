

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <h3>Lawyer Verification Requests</h3>
        <?php if($lawyers->isEmpty()): ?>
            <div class="alert alert-info">No verification requests.</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Lawyer</th>
                        <th>Email</th>
                        <th>Documents</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($l->user->name ?? '—'); ?></td>
                            <td><?php echo e($l->user->email ?? '—'); ?></td>
                            <td>
                                <?php if(is_array($l->documents) && count($l->documents)): ?>
                                    <?php $__currentLoopData = $l->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div><a href="<?php echo e(\Illuminate\Support\Facades\Storage::url($doc)); ?>" target="_blank"><?php echo e(basename($doc)); ?></a></div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($l->city ?? '—'); ?></td>
                            <td><?php echo e($l->verification_status); ?></td>
                            <td>
                                <form method="POST" action="<?php echo e(route('admin.verification.approve', $l->id)); ?>"
                                    style="display:inline"><?php echo csrf_field(); ?><button class="btn btn-sm btn-success">Approve</button></form>
                                <form method="POST" action="<?php echo e(route('admin.verification.reject', $l->id)); ?>"
                                    style="display:inline"><?php echo csrf_field(); ?><button class="btn btn-sm btn-danger">Reject</button></form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/admin/verification/index.blade.php ENDPATH**/ ?>