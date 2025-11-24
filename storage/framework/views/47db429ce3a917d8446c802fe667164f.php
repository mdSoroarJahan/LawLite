

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1><?php echo e($lawyer->user->name ?? 'Lawyer'); ?></h1>
                <p class="text-muted"><?php echo e($lawyer->expertise ?? __('messages.general_practice')); ?></p>
                <p><?php echo e(__('messages.location')); ?>: <?php echo e($lawyer->city ?? __('messages.unknown')); ?></p>
                <?php if(auth()->guard()->check()): ?>
                    <button class="btn btn-primary"
                        onclick="openChatWith(<?php echo e($lawyer->user_id ?? 0); ?>)"><?php echo e(__('messages.message')); ?></button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#appointmentModal"
                        data-lawyer-id="<?php echo e($lawyer->id); ?>"
                        data-lawyer-name="<?php echo e($lawyer->user->name ?? 'Lawyer'); ?>"><?php echo e(__('messages.book_appointment')); ?></button>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary"><?php echo e(__('messages.sign_in_to_message')); ?></a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary"><?php echo e(__('messages.sign_in_to_book')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/show.blade.php ENDPATH**/ ?>