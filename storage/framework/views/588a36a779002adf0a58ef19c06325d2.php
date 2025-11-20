

<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold">Legal help, simplified — in Bangla & English</h1>
                    <p class="lead small-muted">Connect with verified lawyers, get fast AI-powered summaries, and manage
                        appointments — all in one modern, secure app.</p>

                    <div class="mt-4 d-flex gap-2">
                        <a href="<?php echo e(route('lawyers.index')); ?>" class="btn btn-lg btn-primary me-2">Find a Lawyer</a>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-lg btn-outline-secondary">Sign in</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="card card-ghost p-4">
                        <h5 class="mb-3">AI Assistant</h5>
                        <p class="small-muted">Ask legal questions in natural language and get concise summaries and next
                            steps.</p>
                        <hr>
                        <h6 class="mb-1">Featured lawyers</h6>
                        <?php
                            $sample = (object) [
                                'name' => 'Adv. Rahman',
                                'expertise' => 'Family Law, Civil',
                                'city' => 'Dhaka',
                                'verified' => true,
                                'photo' => null,
                            ];
                        ?>
                        <?php echo $__env->make('components.lawyer_card', ['lawyer' => $sample], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="card p-4 h-100 card-ghost">
                        <h5>Verified Lawyers</h5>
                        <p class="small-muted mb-0">All professionals are vetted — find the right expertise quickly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 h-100 card-ghost">
                        <h5>AI Summaries</h5>
                        <p class="small-muted mb-0">Short, bilingual summaries of legal text and contracts to speed
                            decisions.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 h-100 card-ghost">
                        <h5>Secure Appointments</h5>
                        <p class="small-muted mb-0">Book and manage consultations with calendar sync and reminders.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/welcome.blade.php ENDPATH**/ ?>