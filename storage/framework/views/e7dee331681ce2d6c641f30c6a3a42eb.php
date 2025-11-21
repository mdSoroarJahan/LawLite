

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h3>Edit Lawyer Profile</h3>
                    <form method="POST" action="<?php echo e(route('lawyer.profile.edit')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label>Name</label>
                            <input name="name" value="<?php echo e(old('name', $user->name)); ?>" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>City</label>
                            <input name="city" value="<?php echo e(old('city', $lawyer->city ?? '')); ?>" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Expertise</label>
                            <input name="expertise" value="<?php echo e(old('expertise', $lawyer->expertise ?? '')); ?>"
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Documents (license, ID) — PDF or images</label>
                            <input name="documents[]" type="file" class="form-control" multiple accept=".pdf,image/*" />
                            <div class="form-text">Upload scanned license, NID, or other supporting docs. Files are private
                                but accessible to admins for verification.</div>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/profile_edit.blade.php ENDPATH**/ ?>