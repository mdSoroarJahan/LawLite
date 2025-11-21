

<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold"><?php echo e(__('messages.welcome_title')); ?></h1>
                    <p class="lead small-muted"><?php echo e(__('messages.welcome_subtitle')); ?></p>

                    <?php if(auth()->guard()->guest()): ?>
                        <div class="mt-4 d-flex gap-2">
                            <a href="<?php echo e(route('lawyers.index')); ?>"
                                class="btn btn-lg btn-primary me-2"><?php echo e(__('messages.find_lawyers')); ?></a>
                            <a href="<?php echo e(route('login')); ?>"
                                class="btn btn-lg btn-outline-secondary"><?php echo e(__('messages.login')); ?></a>
                        </div>
                    <?php else: ?>
                        <div class="mt-4 d-flex gap-2">
                            <a href="<?php echo e(route('lawyers.index')); ?>"
                                class="btn btn-lg btn-primary me-2"><?php echo e(__('messages.find_lawyers')); ?></a>
                            <?php if(Auth::user()->role === 'lawyer'): ?>
                                <a href="<?php echo e(route('lawyer.dashboard')); ?>"
                                    class="btn btn-lg btn-accent"><?php echo e(__('messages.dashboard')); ?></a>
                            <?php elseif(Auth::user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>"
                                    class="btn btn-lg btn-accent"><?php echo e(__('messages.admin_panel')); ?></a>
                            <?php else: ?>
                                <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-lg btn-accent">Appointments</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="card card-ghost p-4">
                        <h5 class="mb-3"><?php echo e(__('messages.ai_assistant')); ?></h5>
                        <p class="small-muted mb-3">Ask legal questions in natural language and get concise summaries and
                            next steps.</p>

                        <form action="<?php echo e(route('ai.ask')); ?>" method="POST" id="aiQuestionForm">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <textarea name="question" class="form-control" rows="3" placeholder="<?php echo e(__('messages.ai_placeholder')); ?>"
                                    required></textarea>
                            </div>
                            <button type="submit"
                                class="btn btn-primary btn-sm w-100"><?php echo e(__('messages.ai_submit')); ?></button>
                        </form>

                        <div id="aiResponse" class="mt-3" style="display:none;">
                            <div class="alert alert-info"></div>
                        </div>

                        <hr class="my-3">
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
                    <a href="<?php echo e(route('lawyers.index')); ?>" class="text-decoration-none">
                        <div class="card p-4 h-100 card-ghost">
                            <h5><?php echo e(__('messages.find_lawyers_title')); ?></h5>
                            <p class="small-muted mb-0"><?php echo e(__('messages.find_lawyers_desc')); ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo e(route('articles.index')); ?>" class="text-decoration-none">
                        <div class="card p-4 h-100 card-ghost">
                            <h5><?php echo e(__('messages.legal_advice_title')); ?></h5>
                            <p class="small-muted mb-0"><?php echo e(__('messages.legal_advice_desc')); ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo e(route('appointments.index')); ?>" class="text-decoration-none">
                        <div class="card p-4 h-100 card-ghost">
                            <h5><?php echo e(__('messages.book_appointment_title')); ?></h5>
                            <p class="small-muted mb-0"><?php echo e(__('messages.book_appointment_desc')); ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById('aiQuestionForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const responseDiv = document.getElementById('aiResponse');
            const responseAlert = responseDiv.querySelector('.alert');

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            responseDiv.style.display = 'block';
            responseAlert.className = 'alert alert-info';
            responseAlert.textContent = 'Thinking...';

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.ok) {
                    responseAlert.className = 'alert alert-success';
                    // Handle different result formats
                    const answer = typeof data.result === 'string' ? data.result : JSON.stringify(data.result,
                        null, 2);
                    responseAlert.innerHTML =
                        '<strong>Answer:</strong><br><div style="white-space: pre-wrap;">' + answer + '</div>';
                } else {
                    responseAlert.className = 'alert alert-danger';
                    responseAlert.textContent = data.error || data.message ||
                        'An error occurred. Please try again.';
                }
            } catch (error) {
                responseAlert.className = 'alert alert-danger';
                responseAlert.textContent = 'Network error. Please check your connection and try again.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Ask AI';
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/welcome.blade.php ENDPATH**/ ?>