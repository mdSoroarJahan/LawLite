

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h1>Admin Dashboard</h1>
                <div class="list-group">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="<?php echo e(route('admin.verification.index')); ?>" class="list-group-item list-group-item-action">Manage
                        Lawyers</a>
                    <a href="#" class="list-group-item list-group-item-action">Manage Articles</a>
                    <a href="<?php echo e(url('/_dev/login-as/admin')); ?>"
                        class="list-group-item list-group-item-action text-warning">Dev: Login as admin</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>