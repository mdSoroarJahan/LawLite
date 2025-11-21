

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h1 class="mb-4"><?php echo e(__('messages.messages')); ?></h1>

        <?php if($conversations->isEmpty()): ?>
            <div class="alert alert-info">
                <p class="mb-0"><?php echo e(__('messages.no_messages')); ?></p>
            </div>
        <?php else: ?>
            <div class="list-group">
                <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="javascript:void(0)" onclick="openChatWith(<?php echo e($conversation['partner']->id); ?>)"
                        class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                <?php echo e($conversation['partner']->name); ?>

                                <?php if($conversation['unread_count'] > 0): ?>
                                    <span class="badge bg-primary"><?php echo e($conversation['unread_count']); ?></span>
                                <?php endif; ?>
                            </h5>
                            <small
                                class="text-muted"><?php echo e($conversation['latest_message']->created_at->diffForHumans()); ?></small>
                        </div>
                        <p class="mb-1 text-muted">
                            <?php if($conversation['latest_message']->sender_id === auth()->id()): ?>
                                <strong>You:</strong>
                            <?php endif; ?>
                            <?php echo e(\Illuminate\Support\Str::limit($conversation['latest_message']->content, 80)); ?>

                        </p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/chat/inbox.blade.php ENDPATH**/ ?>