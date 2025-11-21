

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <h1>Edit User</h1>
        <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-3">
                <label>Name</label>
                <input name="name" value="<?php echo e(old('name', $user->name)); ?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="<?php echo e(old('email', $user->email)); ?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select">
                    <option value="user" <?php if($user->role == 'user'): ?> selected <?php endif; ?>>User</option>
                    <option value="lawyer" <?php if($user->role == 'lawyer'): ?> selected <?php endif; ?>>Lawyer</option>
                    <option value="admin" <?php if($user->role == 'admin'): ?> selected <?php endif; ?>>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Language</label>
                <input name="language_preference" value="<?php echo e(old('language_preference', $user->language_preference)); ?>"
                    class="form-control" />
            </div>
            <div class="mb-3">
                <label>New Password (leave blank to keep)</label>
                <input name="password" type="password" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" />
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>