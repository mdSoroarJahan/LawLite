<nav class="site-header navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ url('/') }}">
            <i class="bi bi-shield-check me-1"></i>LawLite
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center fw-medium">
                @php $user = auth()->user(); @endphp

                @if ($user && $user->role === 'lawyer')
                    {{-- Lawyer Navigation --}}
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('lawyer.dashboard') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('lawyer.articles.index') }}">{{ __('messages.my_articles') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('lawyer.cases.index') }}">{{ __('messages.cases') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('lawyer.appointments') }}">{{ __('messages.appointments') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('messages.inbox') }}">{{ __('messages.messages') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('notifications.index') }}">{{ __('messages.notifications') }}</a></li>
                @else
                    {{-- Guest and User Navigation --}}
                    <li class="nav-item"><a class="nav-link"
                            href="{{ Route::has('home') ? route('home') : url('/') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('lawyers.index') }}">{{ __('messages.find_lawyers') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('articles.index') }}">{{ __('messages.articles') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('appointments.index') }}">{{ __('messages.appointments') }}</a></li>
                @endif

                @guest
                    <li class="nav-item ms-lg-3"><a class="btn btn-outline-primary px-4"
                            href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-primary px-4"
                            href="{{ route('register') }}">{{ __('messages.register') }}</a>
                    </li>
                @else
                    @if ($user && $user->role === 'admin')
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('admin.dashboard') }}">{{ __('messages.admin_panel') }}</a>
                        </li>
                    @elseif ($user && $user->role !== 'lawyer')
                        {{-- Regular user navigation --}}
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('user.cases.index') }}">{{ __('messages.cases') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('client.invoices.index') }}">Invoices</a>
                        </li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('messages.inbox') }}">{{ __('messages.messages') }}</a></li>
                    @endif

                    <li class="nav-item dropdown ms-lg-3">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $user->name ?? $user->email }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3">
                            <a class="dropdown-item py-2"
                                href="{{ route('profile.show') }}">{{ __('messages.profile') }}</a>
                            @if ($user && $user->role !== 'lawyer')
                                <a class="dropdown-item py-2"
                                    href="{{ route('notifications.index') }}">{{ __('messages.notifications') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="px-3 py-2">
                                @csrf
                                <button type="submit"
                                    class="btn btn-link text-danger p-0 text-decoration-none fw-medium">{{ __('messages.logout') }}</button>
                            </form>
                        </div>
                    </li>
                @endguest

                <!-- Language Switcher -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i> {{ app()->getLocale() == 'bn' ? 'বাংলা' : 'EN' }}
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
