

<?php $__env->startPush('styles'); ?>
    <style>
        .hero-section {
            background-color: #ffffff;
            padding: 6rem 0 4rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #eff6ff;
            /* Blue 50 */
            color: var(--accent);
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
        }

        .step-number {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .ai-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .stat-card {
            padding: 2rem;
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }

        .stat-card:last-child {
            border-right: none;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.05em;
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-stars me-1"></i> <?php echo e(__('messages.hero_badge')); ?>

                    </span>
                    <h1 class="display-4 fw-bold mb-4 lh-tight">
                        <?php echo e(__('messages.hero_title_1')); ?> <span class="text-primary"><?php echo e(__('messages.hero_title_2')); ?></span>
                    </h1>
                    <p class="lead text-muted mb-5">
                        <?php echo e(__('messages.hero_desc')); ?>

                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('lawyers.index')); ?>"
                                class="btn btn-primary btn-lg px-4 py-3 fw-semibold shadow-sm">
                                <i class="bi bi-search me-2"></i><?php echo e(__('messages.find_lawyer_btn')); ?>

                            </a>
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-primary btn-lg px-4 py-3 fw-semibold">
                                <?php echo e(__('messages.get_started_btn')); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('lawyers.index')); ?>"
                                class="btn btn-primary btn-lg px-4 py-3 fw-semibold shadow-sm">
                                <i class="bi bi-search me-2"></i><?php echo e(__('messages.find_lawyer_btn')); ?>

                            </a>
                            <?php if(Auth::user()->role === 'lawyer'): ?>
                                <a href="<?php echo e(route('lawyer.dashboard')); ?>" class="btn btn-accent btn-lg px-4 py-3 fw-semibold">
                                    <i class="bi bi-speedometer2 me-2"></i><?php echo e(__('messages.dashboard')); ?>

                                </a>
                            <?php elseif(Auth::user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-accent btn-lg px-4 py-3 fw-semibold">
                                    <?php echo e(__('messages.admin_panel')); ?>

                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('appointments.index')); ?>"
                                    class="btn btn-accent btn-lg px-4 py-3 fw-semibold">
                                    <?php echo e(__('messages.my_appointments')); ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Trust/avatars removed per design request -->
                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="ai-card p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-robot text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0"><?php echo e(__('messages.ai_card_title')); ?></h5>
                                <small class="text-muted"><?php echo e(__('messages.ai_card_subtitle')); ?></small>
                            </div>
                        </div>

                        <form action="<?php echo e(route('ai.ask')); ?>" method="POST" id="aiQuestionForm">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <textarea name="question" class="form-control bg-light border-0 p-3" rows="4"
                                    placeholder="<?php echo e(__('messages.ai_input_placeholder')); ?>" style="resize: none;" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-send me-2"></i><?php echo e(__('messages.ai_submit_btn')); ?>

                            </button>
                        </form>

                        <div id="aiResponse" class="mt-3" style="display:none;">
                            <div class="alert alert-light border shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="border-bottom bg-white">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">100%</div>
                        <div class="text-muted fw-semibold"><?php echo e(__('messages.stat_secure_platform')); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">98%</div>
                        <div class="text-muted fw-semibold"><?php echo e(__('messages.stat_client_satisfaction')); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="text-muted fw-semibold"><?php echo e(__('messages.stat_ai_support')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-6 bg-light-section">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6 mb-3"><?php echo e(__('messages.why_choose_title')); ?></h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    <?php echo e(__('messages.why_choose_desc')); ?>

                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="fw-bold mb-3"><?php echo e(__('messages.feature_1_title')); ?></h4>
                        <p class="text-muted mb-0">
                            <?php echo e(__('messages.feature_1_desc')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                        <div class="feature-icon">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <h4 class="fw-bold mb-3"><?php echo e(__('messages.feature_2_title')); ?></h4>
                        <p class="text-muted mb-0">
                            <?php echo e(__('messages.feature_2_desc')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3"><?php echo e(__('messages.feature_3_title')); ?></h4>
                        <p class="text-muted mb-0">
                            <?php echo e(__('messages.feature_3_desc')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="py-6 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Legal Meeting" class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <h2 class="fw-bold display-6 mb-5"><?php echo e(__('messages.how_it_works_title')); ?></h2>

                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="step-number">1</div>
                        </div>
                        <div>
                            <h5 class="fw-bold"><?php echo e(__('messages.step_1_title')); ?></h5>
                            <p class="text-muted"><?php echo e(__('messages.step_1_desc')); ?></p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="step-number">2</div>
                        </div>
                        <div>
                            <h5 class="fw-bold"><?php echo e(__('messages.step_2_title')); ?></h5>
                            <p class="text-muted"><?php echo e(__('messages.step_2_desc')); ?></p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-4">
                            <div class="step-number">3</div>
                        </div>
                        <div>
                            <h5 class="fw-bold"><?php echo e(__('messages.step_3_title')); ?></h5>
                            <p class="text-muted"><?php echo e(__('messages.step_3_desc')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center py-4">
            <h2 class="fw-bold mb-3"><?php echo e(__('messages.cta_title')); ?></h2>
            <p class="lead mb-4 text-white-50"><?php echo e(__('messages.cta_desc')); ?></p>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>"
                    class="btn btn-accent btn-lg px-5 fw-bold"><?php echo e(__('messages.cta_btn_guest')); ?></a>
            <?php else: ?>
                <a href="<?php echo e(route('lawyers.index')); ?>"
                    class="btn btn-accent btn-lg px-5 fw-bold"><?php echo e(__('messages.cta_btn_user')); ?></a>
            <?php endif; ?>
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
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span><?php echo e(__('messages.processing')); ?>';
            responseDiv.style.display = 'block';
            responseAlert.className = 'alert alert-info';
            responseAlert.textContent = '<?php echo e(__('messages.analyzing_question')); ?>';

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
                        '<strong><?php echo e(__('messages.ai_response_label')); ?></strong><br><div style="white-space: pre-wrap;" class="mt-2">' +
                        answer + '</div>';
                } else {
                    responseAlert.className = 'alert alert-danger';
                    responseAlert.textContent = data.error || data.message ||
                        '<?php echo e(__('messages.error_occurred')); ?>';
                }
            } catch (error) {
                responseAlert.className = 'alert alert-danger';
                responseAlert.textContent = '<?php echo e(__('messages.network_error')); ?>';
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/welcome.blade.php ENDPATH**/ ?>