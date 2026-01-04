@php
    $user = auth()->user();
    $isLawyer = $user && $user->role === 'lawyer';
    $isAdmin = $user && $user->role === 'admin';
    $isAdminRoute = request()->routeIs('admin.*');

    if ($isAdmin) {
        $primaryLinks = [
            [
                'label' => 'Admin Panel',
                'route' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
            ],
            [
                'label' => 'Users',
                'route' => route('admin.users.index'),
                'active' => request()->routeIs('admin.users.*'),
            ],
            [
                'label' => 'Lawyers',
                'route' => route('admin.verification.index'),
                'active' => request()->routeIs('admin.verification.*'),
            ],
            [
                'label' => 'Articles',
                'route' => route('admin.articles.index'),
                'active' => request()->routeIs('admin.articles.*'),
            ],
            [
                'label' => __('messages.cases'),
                'route' => route('admin.cases.index'),
                'active' => request()->routeIs('admin.cases.*'),
            ],
            [
                'label' => __('messages.invoices'),
                'route' => route('admin.invoices.index'),
                'active' => request()->routeIs('admin.invoices.*'),
            ],
        ];
        $secondaryLinks = [];
    } elseif ($isLawyer) {
        $primaryLinks = [
            [
                'label' => __('messages.home'),
                'route' => route('lawyer.dashboard'),
                'active' => request()->routeIs('lawyer.dashboard'),
            ],
            [
                'label' => __('messages.ai_features'),
                'route' => route('ai.features'),
                'active' => request()->routeIs('ai.features'),
                'icon' => 'bi bi-stars me-2 text-accent',
            ],
            [
                'label' => __('messages.my_articles'),
                'route' => route('lawyer.articles.index'),
                'active' => request()->routeIs('lawyer.articles.*'),
            ],
            [
                'label' => __('messages.cases'),
                'route' => route('lawyer.cases.index'),
                'active' => request()->routeIs('lawyer.cases.*'),
            ],
            [
                'label' => __('messages.appointments'),
                'route' => route('lawyer.appointments'),
                'active' => request()->routeIs('lawyer.appointments'),
            ],
            [
                'label' => __('messages.messages'),
                'route' => route('messages.inbox'),
                'active' => request()->routeIs('messages.inbox'),
            ],
            [
                'label' => __('messages.notifications'),
                'route' => route('notifications.index'),
                'active' => request()->routeIs('notifications.*'),
            ],
        ];
    } else {
        $primaryLinks = [
            [
                'label' => __('messages.home'),
                'route' => Route::has('home') ? route('home') : url('/'),
                'active' => request()->routeIs('home') || request()->is('/'),
            ],
            [
                'label' => __('messages.ai_features'),
                'route' => route('ai.features'),
                'active' => request()->routeIs('ai.features'),
                'icon' => 'bi bi-stars me-2 text-accent',
            ],
            [
                'label' => __('messages.find_lawyers'),
                'route' => route('lawyers.index'),
                'active' => request()->routeIs('lawyers.index'),
            ],
            [
                'label' => __('messages.articles'),
                'route' => route('articles.index'),
                'active' => request()->routeIs('articles.index'),
            ],
            [
                'label' => __('messages.appointments'),
                'route' => route('appointments.index'),
                'active' => request()->routeIs('appointments.index'),
            ],
        ];
    }

    $secondaryLinks = $secondaryLinks ?? [];
    if ($user && $user->role === 'admin' && !$isAdmin) {
        $secondaryLinks[] = [
            'label' => __('messages.admin_panel'),
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ];
    } elseif ($user && !$isLawyer && !$isAdmin) {
        $secondaryLinks[] = [
            'label' => __('messages.cases'),
            'route' => route('user.cases.index'),
            'active' => request()->routeIs('user.cases.index'),
        ];
        $secondaryLinks[] = [
            'label' => __('messages.invoices'),
            'route' => route('client.invoices.index'),
            'active' => request()->routeIs('client.invoices.*'),
        ];
        $secondaryLinks[] = [
            'label' => __('messages.messages'),
            'route' => route('messages.inbox'),
            'active' => request()->routeIs('messages.inbox'),
        ];
    }
@endphp

<nav class="site-header navbar navbar-expand-lg navbar-light fixed-top py-3 transition-all">
    <div class="container">
        <a class="logo text-decoration-none d-flex align-items-center gap-3 me-5" href="{{ url('/') }}">
            <div class="logo-icon-wrapper">
                <div class="logo-icon-inner">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <!-- Balance beam -->
                        <line x1="12" y1="3" x2="12" y2="6" />
                        <line x1="4" y1="8" x2="20" y2="8" />
                        <!-- Left scale -->
                        <line x1="6" y1="8" x2="4" y2="14" />
                        <line x1="6" y1="8" x2="8" y2="14" />
                        <path d="M3 14 Q4 17 5 14" />
                        <path d="M7 14 Q8 17 9 14" />
                        <line x1="3" y1="14" x2="9" y2="14" />
                        <!-- Right scale -->
                        <line x1="18" y1="8" x2="16" y2="14" />
                        <line x1="18" y1="8" x2="20" y2="14" />
                        <path d="M15" y1="14" d="M15 14 Q16 17 17 14" />
                        <path d="M19 14 Q20 17 21 14" />
                        <line x1="15" y1="14" x2="21" y2="14" />
                        <!-- Center pillar -->
                        <line x1="12" y1="8" x2="12" y2="20" />
                        <line x1="8" y1="20" x2="16" y2="20" />
                    </svg>
                </div>
            </div>
            <span class="logo-text">
                <span class="law">Law</span><span class="lite">Lite</span>
            </span>
        </a>

        <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#navSidebar" aria-controls="navSidebar">
            <div class="hamburger-icon">
                <i class="bi bi-list fs-1 text-primary"></i>
            </div>
        </button>

        <div class="d-none d-lg-flex flex-grow-1 align-items-center justify-content-between" id="mainNav">
            <ul class="navbar-nav align-items-lg-center gap-1 gap-lg-4 my-3 my-lg-0">
                @foreach ($primaryLinks as $link)
                    <li class="nav-item">
                        <a class="nav-link {{ $link['active'] ? 'active' : '' }}" href="{{ $link['route'] }}">
                            @if (!empty($link['icon']))
                                <i class="{{ $link['icon'] }}"></i>
                            @endif
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach

                @foreach ($secondaryLinks as $link)
                    <li class="nav-item">
                        <a class="nav-link {{ $link['active'] ? 'active' : '' }}" href="{{ $link['route'] }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex align-items-center gap-3">
                @guest
                    <a class="btn btn-outline-primary btn-magnetic rounded-pill px-4 fw-semibold"
                        href="{{ route('login') }}">
                        {{ __('messages.login') }}
                    </a>
                    <a class="btn btn-primary btn-magnetic rounded-pill px-4 fw-semibold shadow-lg"
                        href="{{ route('register') }}">
                        {{ __('messages.register') }}
                    </a>
                @else
                    <div class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                            href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="avatar-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm"
                                style="width: 35px; height: 35px; font-size: 0.9rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="d-none d-lg-block fw-semibold">{{ $user->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-2xl mt-3 rounded-4 overflow-hidden p-2 animate__animated animate__fadeIn"
                            style="min-width: 200px;">
                            <div class="px-3 py-2 border-bottom border-light mb-2">
                                <p class="mb-0 fw-bold text-dark">{{ $user->name }}</p>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>

                            <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2"
                                href="{{ route('profile.show') }}">
                                <i class="bi bi-person-gear text-primary"></i> {{ __('messages.profile') }}
                            </a>

                            @if ($user && $user->role !== 'lawyer')
                                <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2"
                                    href="{{ route('notifications.index') }}">
                                    <i class="bi bi-bell text-warning"></i> {{ __('messages.notifications') }}
                                </a>
                            @endif

                            <div class="dropdown-divider my-2"></div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2 text-danger">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                <div class="d-flex align-items-center gap-2 border-start ps-3 border-secondary border-opacity-10">
                    @if ($user)
                        <button id="notification-bell"
                            class="btn btn-link nav-utility-btn text-decoration-none p-0 position-relative"
                            type="button" data-target-url="{{ route('notifications.index') }}"
                            title="Notifications">
                            <i class="bi bi-bell fs-6"></i>
                            <span id="notification-badge"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none"
                                style="font-size: 0.65rem; min-width: 18px; height: 18px; line-height: 12px;"></span>
                        </button>
                    @endif

                    <!-- Language Switcher -->
                    <div class="dropdown">
                        <button class="btn btn-link nav-utility-btn text-decoration-none p-0 d-flex align-items-center"
                            type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i>
                            <span class="text-uppercase fw-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 p-1"
                            style="min-width: 120px;">
                            <li><a class="dropdown-item rounded-2 {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                    href="{{ route('lang.switch', 'en') }}">🇺🇸 English</a></li>
                            <li><a class="dropdown-item rounded-2 {{ app()->getLocale() == 'bn' ? 'active' : '' }}"
                                    href="{{ route('lang.switch', 'bn') }}">🇧🇩 বাংলা</a></li>
                        </ul>
                    </div>

                    <!-- Theme Toggle -->
                    <button class="btn btn-link btn-icon-compact text-muted transition-transform hover-rotate"
                        id="themeToggle" title="Toggle Theme">
                        <i class="bi bi-moon-fill fs-6" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start premium-sidebar text-white" tabindex="-1" id="navSidebar"
    aria-labelledby="navSidebarLabel">
    <div class="offcanvas-header">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-icon small">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                    <path d="M2 17l10 5 10-5" />
                    <path d="M2 12l10 5 10-5" />
                </svg>
            </div>
            <div>
                <span class="logo-text text-white">LawLite</span>

                @auth
                    <script>
                        (() => {
                            const userId = "{{ auth()->id() }}";
                            const bell = document.getElementById('notification-bell');
                            const badge = document.getElementById('notification-badge');
                            const targetUrl = bell ? bell.dataset.targetUrl : null;

                            if (bell && targetUrl) {
                                bell.addEventListener('click', () => {
                                    window.location.href = targetUrl;
                                });
                            }

                            function showNotificationToast(message) {
                                const toast = document.createElement('div');
                                toast.className = 'toast align-items-center text-bg-dark border-0 show';
                                toast.style.position = 'fixed';
                                toast.style.bottom = '1rem';
                                toast.style.right = '1rem';
                                toast.style.zIndex = '1080';
                                toast.innerHTML =
                                    `<div class="d-flex"><div class="toast-body">${message || 'New notification'}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
                                document.body.appendChild(toast);
                                setTimeout(() => toast.remove(), 4000);
                            }

                            async function refreshNotificationBadge() {
                                if (!badge) return;
                                try {
                                    const res = await fetch('/notifications/json', {
                                        headers: {
                                            'Accept': 'application/json'
                                        }
                                    });
                                    const data = await res.json();
                                    const unread = (data.notifications || []).filter(n => !n.read_at).length;
                                    if (unread > 0) {
                                        badge.textContent = unread > 99 ? '99+' : unread;
                                        badge.classList.remove('d-none');
                                    } else {
                                        badge.classList.add('d-none');
                                    }
                                } catch (e) {
                                    // silently ignore
                                }
                            }

                            refreshNotificationBadge();

                            if (window.Echo && userId) {
                                window.Echo.private('App.Models.User.' + userId)
                                    .notification((notification) => {
                                        refreshNotificationBadge();
                                        showNotificationToast(notification.message || notification.type || 'New notification');
                                    });
                            }
                        })
                        ();
                    </script>
                @endauth
                <p class="sidebar-label text-uppercase small text-muted mb-0">Menu</p>
            </div>
        </div>
        <button type="button" class="btn btn-outline-light btn-icon-compact" data-bs-dismiss="offcanvas"
            aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
        <div>
            <p class="sidebar-label text-uppercase small fw-semibold text-muted mb-2">Navigation</p>
            <ul class="list-unstyled sidebar-menu mb-4">
                @foreach ($primaryLinks as $link)
                    <li>
                        <a class="sidebar-link {{ $link['active'] ? 'active' : '' }}" href="{{ $link['route'] }}">
                            <span>
                                @if (!empty($link['icon']))
                                    <i class="{{ $link['icon'] }}"></i>
                                @endif
                                {{ strtoupper($link['label']) }}
                            </span>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </li>
                @endforeach
            </ul>

            @if (!empty($secondaryLinks))
                <p class="sidebar-label text-uppercase small fw-semibold text-muted mb-2">Dashboard</p>
                <ul class="list-unstyled sidebar-menu mb-4">
                    @foreach ($secondaryLinks as $link)
                        <li>
                            <a class="sidebar-link {{ $link['active'] ? 'active' : '' }}"
                                href="{{ $link['route'] }}">
                                <span>{{ strtoupper($link['label']) }}</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            @guest
                <div class="d-grid gap-2 mb-4">
                    <a class="btn btn-outline-primary rounded-pill"
                        href="{{ route('login') }}">{{ __('messages.login') }}</a>
                    <a class="btn btn-primary rounded-pill"
                        href="{{ route('register') }}">{{ __('messages.register') }}</a>
                </div>
            @else
                <div class="sidebar-user border rounded-4 p-3 mb-4">
                    <p class="mb-1 text-uppercase small text-muted">{{ __('messages.profile') }}</p>
                    <h6 class="mb-1">{{ $user->name }}</h6>
                    <small class="text-muted d-block mb-3">{{ $user->email }}</small>
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-light btn-sm flex-grow-1"
                            href="{{ route('profile.show') }}">{{ __('messages.profile') }}</a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0 flex-grow-1">
                            @csrf
                            <button type="submit"
                                class="btn btn-danger btn-sm w-100">{{ __('messages.logout') }}</button>
                        </form>
                    </div>
                </div>
            @endguest

            <div class="sidebar-contact">
                <p class="sidebar-label text-uppercase small fw-semibold text-muted mb-1">Email</p>
                <a href="mailto:support@lawlite.com"
                    class="d-block mb-3 text-white text-decoration-none">support@lawlite.com</a>
                <p class="sidebar-label text-uppercase small fw-semibold text-muted mb-1">Phone</p>
                <a href="tel:+8801700000000" class="d-block text-white text-decoration-none mb-3">+880 1700-000000</a>
                <div class="d-flex flex-wrap gap-3 text-uppercase small text-muted">
                    <a href="#" class="sidebar-link-minor">Twitter</a>
                    <a href="#" class="sidebar-link-minor">LinkedIn</a>
                    <a href="#" class="sidebar-link-minor">Behance</a>
                    <a href="#" class="sidebar-link-minor">Dribbble</a>
                </div>
            </div>
        </div>
    </div>
</div>
