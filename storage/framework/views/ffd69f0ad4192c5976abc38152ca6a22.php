

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h1 class="mb-4">Notifications</h1>

        <?php if($notifications->isEmpty()): ?>
            <div class="alert alert-info">
                <p class="mb-0">No notifications yet. We'll notify you about important updates.</p>
            </div>
        <?php else: ?>
            <div class="list-group">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="list-group-item <?php echo e($notification->read_at ? '' : 'list-group-item-primary'); ?>">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <?php if(!$notification->read_at): ?>
                                    <span class="badge bg-primary me-2">New</span>
                                <?php endif; ?>
                                <?php echo e($notification->data['title'] ?? 'Notification'); ?>

                            </h6>
                            <small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                        </div>
                        <p class="mb-1"><?php echo e($notification->data['message'] ?? 'You have a new notification'); ?></p>
                        <?php if(!$notification->read_at): ?>
                            <form method="POST" action="<?php echo e(route('notifications.mark-read', $notification->id)); ?>"
                                class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-link p-0">Mark as read</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-3">
                <?php echo e($notifications->links()); ?>

            </div>

            <?php if($notifications->where('read_at', null)->count() > 0): ?>
                <div class="mt-3">
                    <form method="POST" action="<?php echo e(route('notifications.mark-all-read')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-secondary">Mark all as read</button>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/notifications/index.blade.php ENDPATH**/ ?>