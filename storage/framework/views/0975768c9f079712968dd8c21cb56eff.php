

<?php $__env->startSection('content'); ?>
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6"><?php echo e(__('messages.articles')); ?></h1>
                <p class="text-muted"><?php echo e(__('messages.articles_subtitle')); ?></p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form method="GET" action="<?php echo e(route('articles.index')); ?>">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="<?php echo e(__('messages.search_articles')); ?>" value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('messages.search')); ?></button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-secondary"><?php echo e(__('messages.clear')); ?></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($article->title); ?></h5>
                            <p class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($article->content, 120)); ?></p>
                            <a href="<?php echo e(route('articles.show', $article->id)); ?>"
                                class="btn btn-sm btn-primary"><?php echo e(__('messages.read')); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-6"><?php echo e(__('messages.no_articles')); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/articles/index.blade.php ENDPATH**/ ?>