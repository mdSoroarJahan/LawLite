<nav class="site-header navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="<?php echo e(url('/')); ?>">
            <i class="bi bi-shield-check me-1"></i>LawLite
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center fw-medium">
                <?php $user = auth()->user(); ?>

                <?php if($user && $user->role === 'lawyer'): ?>
                    
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('lawyer.dashboard')); ?>"><?php echo e(__('messages.home')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('lawyer.articles.index')); ?>"><?php echo e(__('messages.my_articles')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('lawyer.cases.index')); ?>"><?php echo e(__('messages.cases')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('lawyer.appointments')); ?>"><?php echo e(__('messages.appointments')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('messages.inbox')); ?>"><?php echo e(__('messages.messages')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('notifications.index')); ?>"><?php echo e(__('messages.notifications')); ?></a></li>
                <?php else: ?>
                    
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(Route::has('home') ? route('home') : url('/')); ?>"><?php echo e(__('messages.home')); ?></a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('lawyers.index')); ?>"><?php echo e(__('messages.find_lawyers')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('articles.index')); ?>"><?php echo e(__('messages.articles')); ?></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo e(route('appointments.index')); ?>"><?php echo e(__('messages.appointments')); ?></a></li>
                <?php endif; ?>

                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-outline-primary px-4"
                            href="<?php echo e(route('login')); ?>"><?php echo e(__('messages.login')); ?></a></li>
                    <li class="nav-item ms-2"><a class="btn btn-primary px-4"
                            href="<?php echo e(route('register')); ?>"><?php echo e(__('messages.register')); ?></a>
                    </li>
                <?php else: ?>
                    <?php if($user && $user->role === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('messages.admin_panel')); ?></a>
                        </li>
                    <?php elseif($user && $user->role !== 'lawyer'): ?>
                        
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo e(route('user.cases.index')); ?>"><?php echo e(__('messages.cases')); ?></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo e(route('client.invoices.index')); ?>"><?php echo e(__('messages.invoices')); ?></a>
                        </li>
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo e(route('messages.inbox')); ?>"><?php echo e(__('messages.messages')); ?></a></li>
                    <?php endif; ?>

                    <li class="nav-item dropdown ms-lg-3">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($user->name ?? $user->email); ?>

                        </a>

                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3">
                            <a class="dropdown-item py-2"
                                href="<?php echo e(route('profile.show')); ?>"><?php echo e(__('messages.profile')); ?></a>
                            <?php if($user && $user->role !== 'lawyer'): ?>
                                <a class="dropdown-item py-2"
                                    href="<?php echo e(route('notifications.index')); ?>"><?php echo e(__('messages.notifications')); ?></a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="px-3 py-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="btn btn-link text-danger p-0 text-decoration-none fw-medium"><?php echo e(__('messages.logout')); ?></button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Language Switcher -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i> <?php echo e(app()->getLocale() == 'bn' ? 'বাংলা' : 'EN'); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3">
                        <a class="dropdown-item py-2" href="?lang=en">English</a>
                        <a class="dropdown-item py-2" href="?lang=bn">বাংলা</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH F:\Defence\LawLite\resources\views/components/navbar.blade.php ENDPATH**/ ?>