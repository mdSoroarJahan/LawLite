

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>Profile</h1>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td><?php echo e($user->name); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($user->email); ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><?php echo e($user->role); ?></td>
                    </tr>
                    <tr>
                        <th>Language</th>
                        <td><?php echo e($user->language_preference); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/profile/show.blade.php ENDPATH**/ ?>