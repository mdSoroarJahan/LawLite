

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-3"><?php echo e($article->title); ?></h1>
                <div class="text-muted mb-4">Published: <?php echo e($article->created_at->format('M d, Y')); ?></div>
                <div class="content"><?php echo nl2br(e($article->body)); ?></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/articles/show.blade.php ENDPATH**/ ?>