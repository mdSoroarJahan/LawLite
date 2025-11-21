

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Users</h1>
            <form class="d-flex" method="GET">
                <input name="q" value="<?php echo e($q ?? ''); ?>" class="form-control form-control-sm me-2"
                    placeholder="Search name or email" />
                <select name="role" class="form-select form-select-sm me-2">
                    <option value="">All roles</option>
                    <option value="user" <?php if(($role ?? '') == 'user'): ?> selected <?php endif; ?>>User</option>
                    <option value="lawyer" <?php if(($role ?? '') == 'lawyer'): ?> selected <?php endif; ?>>Lawyer</option>
                    <option value="admin" <?php if(($role ?? '') == 'admin'): ?> selected <?php endif; ?>>Admin</option>
                </select>
                <button class="btn btn-sm btn-primary">Filter</button>
            </form>
        </div>

        <?php if(session('status')): ?>
            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($u->id); ?></td>
                        <td><?php echo e($u->name); ?></td>
                        <td><?php echo e($u->email); ?></td>
                        <td><?php echo e($u->role); ?></td>
                        <td><?php echo e($u->created_at->format('Y-m-d')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.users.edit', $u->id)); ?>"
                                class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="<?php echo e(route('admin.users.destroy', $u->id)); ?>" method="POST"
                                style="display:inline-block;" onsubmit="return confirm('Delete this user?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($users->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/admin/users/index.blade.php ENDPATH**/ ?>