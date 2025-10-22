

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-3">Welcome to LawLite</h1>
            <p class="lead">Bilingual legal help and verified lawyers.</p>

            <?php
                $sample = (object) [
                    'name' => 'Adv. Rahman',
                    'expertise' => 'Family Law, Civil',
                    'city' => 'Dhaka',
                    'verified' => true,
                    'photo' => null,
                ];
            ?>

            <?php echo $__env->make('components.lawyer_card', ['lawyer' => $sample], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('components.lawyer_card', [
                'lawyer' => (object) [
                    'name' => 'Adv. Karim',
                    'expertise' => 'Criminal',
                    'city' => 'Chattogram',
                    'verified' => false,
                ],
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>AI Assistant</h5>
                <p>Ask legal questions in Bangla or English.</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/welcome.blade.php ENDPATH**/ ?>