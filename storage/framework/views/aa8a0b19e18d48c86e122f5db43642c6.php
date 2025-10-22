<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <img src="<?php echo e($lawyer->photo ?? 'https://via.placeholder.com/80'); ?>" alt="profile" class="rounded"
                    style="width:80px;height:80px;object-fit:cover">
            </div>
            <div>
                <h5 class="card-title mb-1"><?php echo e($lawyer->name); ?> <?php if($lawyer->verified): ?>
                        <span class="badge bg-primary">Verified</span>
                    <?php endif; ?>
                </h5>
                <p class="mb-1"><strong><?php echo app('translator')->get('lawyer.expertise'); ?>:</strong> <?php echo e($lawyer->expertise); ?></p>
                <p class="mb-0 text-muted"><?php echo e($lawyer->city ?? ''); ?></p>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Defence\LawLite\resources\views/components/lawyer_card.blade.php ENDPATH**/ ?>