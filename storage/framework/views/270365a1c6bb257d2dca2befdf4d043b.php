

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-4">
                    <h3>Your Lawyer Dashboard</h3>
                    <p class="small-muted">Welcome <?php echo e($user->name); ?> — this area is for lawyer tools (appointments,
                        profile, availability).</p>

                    <div class="mt-3 d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline-primary">Edit Profile</a>
                        <a href="<?php echo e(route('lawyers.index')); ?>" class="btn btn-outline-secondary">View Public Listings</a>
                        <a href="#" class="btn btn-outline-success">Manage Appointments</a>
                        <a href="#" class="btn btn-outline-warning">Verification Status</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 card-ghost">
                    <h6>Quick Info</h6>
                    <p class="small-muted mb-0">Verified lawyers get priority in search results. Fill out your license and
                        documents in your profile.</p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/dashboard.blade.php ENDPATH**/ ?>