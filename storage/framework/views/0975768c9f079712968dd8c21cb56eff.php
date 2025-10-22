

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6">Articles</h1>
                <p class="text-muted">Latest legal articles and guides.</p>
            </div>
        </div>
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($article->title); ?></h5>
                            <p class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($article->body, 120)); ?></p>
                            <a href="<?php echo e(route('articles.show', $article->id)); ?>" class="btn btn-sm btn-primary">Read</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-6">No articles found.</div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/articles/index.blade.php ENDPATH**/ ?>