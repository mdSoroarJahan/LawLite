

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="mb-3">Create account</h3>
                    <form method="POST" action="<?php echo e(route('register.post')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($err); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label>Name</label>
                            <input name="name" value="<?php echo e(old('name')); ?>" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input name="email" value="<?php echo e(old('email')); ?>" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Confirm password</label>
                            <input name="password_confirmation" type="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Account type</label>
                            <select name="role" class="form-select">
                                <option value="user" <?php if(old('role', 'user') === 'user'): ?> selected <?php endif; ?>>Register as User
                                </option>
                                <option value="lawyer" <?php if(old('role') === 'lawyer'): ?> selected <?php endif; ?>>Register as Lawyer
                                </option>
                            </select>
                            <div class="form-text">If you are a practicing lawyer, choose "Register as Lawyer". Lawyers will
                                be reviewed by admins before verification.</div>
                        </div>

                        <button class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/auth/register.blade.php ENDPATH**/ ?>