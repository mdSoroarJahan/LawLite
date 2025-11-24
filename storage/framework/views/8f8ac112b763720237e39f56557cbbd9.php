<nav class="site-header navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="<?php echo e(url('/')); ?>">LawLite</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <?php $user = Auth::user(); ?>

                <?php if($user && $user->role === 'lawyer'): ?>
                    
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('lawyer.dashboard')); ?>"><?php echo e(__('messages.home')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('articles.index')); ?>"><?php echo e(__('messages.articles')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('lawyer.cases.index')); ?>"><?php echo e(__('messages.cases')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('lawyer.appointments')); ?>"><?php echo e(__('messages.appointments')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('messages.inbox')); ?>"><?php echo e(__('messages.messages')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('notifications.index')); ?>"><?php echo e(__('messages.notifications')); ?></a></li>
                <?php else: ?>
                    
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(Route::has('home') ? route('home') : url('/')); ?>"><?php echo e(__('messages.home')); ?></a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('lawyers.index')); ?>"><?php echo e(__('messages.find_lawyers')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('articles.index')); ?>"><?php echo e(__('messages.articles')); ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white"
                            href="<?php echo e(route('appointments.index')); ?>"><?php echo e(__('messages.appointments')); ?></a></li>
                <?php endif; ?>

                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item ms-3"><a class="btn btn-sm btn-accent"
                            href="<?php echo e(route('login')); ?>"><?php echo e(__('messages.login')); ?></a></li>
                    <li class="nav-item ms-2"><a class="nav-link text-white"
                            href="<?php echo e(route('register')); ?>"><?php echo e(__('messages.register')); ?></a>
                    </li>
                <?php else: ?>
                    <?php if($user && $user->role === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link text-white"
                                href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('messages.admin_panel')); ?></a>
                        </li>
                    <?php elseif($user && $user->role !== 'lawyer'): ?>
                        
                        <li class="nav-item"><a class="nav-link text-white"
                                href="<?php echo e(route('messages.inbox')); ?>"><?php echo e(__('messages.messages')); ?></a></li>
                    <?php endif; ?>

                    <li class="nav-item dropdown ms-3">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e(Auth::user()->name ?? Auth::user()->email); ?>

                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><?php echo e(__('messages.profile')); ?></a>
                            <?php if($user && $user->role !== 'lawyer'): ?>
                                <a class="dropdown-item" href="<?php echo e(route('notifications.index')); ?>">Notifications</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="px-3 py-1">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="btn btn-link text-danger p-0"><?php echo e(__('messages.logout')); ?></button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Language Switcher -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                        data-bs-toggle="dropdown">
                        <?php echo e(app()->getLocale() == 'bn' ? 'বাংলা' : 'English'); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="?lang=en">English</a>
                        <a class="dropdown-item" href="?lang=bn">বাংলা</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH F:\Defence\LawLite\resources\views/components/navbar.blade.php ENDPATH**/ ?>