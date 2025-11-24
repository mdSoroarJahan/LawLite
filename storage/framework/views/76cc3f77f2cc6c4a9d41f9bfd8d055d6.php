

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="mb-3"><?php echo e(__('messages.login')); ?></h3>
                    <form method="POST" action="<?php echo e(route('login.post')); ?>">
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
                        <?php if(session('status')): ?>
                            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label><?php echo e(__('messages.email')); ?></label>
                            <input name="email" value="<?php echo e(old('email')); ?>" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label><?php echo e(__('messages.password')); ?></label>
                            <input name="password" type="password" class="form-control" />
                        </div>
                        <button class="btn btn-primary"><?php echo e(__('messages.login')); ?></button>

                        <?php if(env('APP_ENV') === 'local'): ?>
                            <hr class="my-3">
                            <div class="small text-muted">Quick sign-in (development only):</div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="<?php echo e(url('/_dev/login-as/admin')); ?>" class="btn btn-sm btn-outline-secondary">Sign in
                                    as Admin</a>
                                <a href="<?php echo e(url('/_dev/login-as/lawyer')); ?>" class="btn btn-sm btn-outline-secondary">Sign
                                    in as Lawyer</a>
                                <a href="<?php echo e(url('/_dev/login-as/user')); ?>" class="btn btn-sm btn-outline-secondary">Sign in
                                    as User</a>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/auth/login.blade.php ENDPATH**/ ?>