<div class="d-flex align-items-start mb-3">
    <div class="flex-shrink-0 me-3">
        <div
            style="width:72px;height:72px;overflow:hidden;border-radius:12px;background:#e6eefc;display:flex;align-items:center;justify-content:center">
            <img src="<?php echo e($lawyer->photo ?? 'https://via.placeholder.com/72'); ?>" alt="profile"
                style="width:72px;height:72px;object-fit:cover;border-radius:8px">
        </div>
    </div>
    <div class="flex-grow-1">
        <div class="d-flex align-items-start justify-content-between">
            <div>
                <h6 class="mb-1"><?php echo e($lawyer->name); ?> <?php if($lawyer->verified): ?>
                        <span class="badge bg-success ms-2">Verified</span>
                    <?php endif; ?>
                </h6>
                <div class="small small-muted"><?php echo e($lawyer->expertise); ?></div>
            </div>
            <div class="text-end small small-muted"><?php echo e($lawyer->city ?? ''); ?></div>
        </div>
    </div>
</div>
<?php /**PATH F:\Defence\LawLite\resources\views/components/lawyer_card.blade.php ENDPATH**/ ?>