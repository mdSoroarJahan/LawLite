<nav class="site-header navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">LawLite</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link text-white"
                        href="{{ Route::has('home') ? route('home') : url('/') }}">{{ __('messages.home') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('lawyers.index') }}">{{ __('messages.find_lawyers') }}</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('articles.index') }}">Articles</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white"
                        href="{{ route('appointments.index') }}">Appointments</a></li>

                @auth
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('messages.inbox') }}">{{ __('messages.messages') }}</a>
                    </li>
                @endauth

                @guest
                    <li class="nav-item ms-3"><a class="btn btn-sm btn-accent" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                    <li class="nav-item ms-2"><a class="nav-link text-white" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                    </li>
                    {{-- Dev quick-links moved to the sign-in page to avoid showing role options on the homepage. --}}
                @else
                    @php $user = Auth::user(); @endphp
                    @if ($user && $user->role === 'admin')
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.dashboard') }}">{{ __('messages.admin_panel') }}</a>
                        </li>
                    @elseif ($user && $user->role === 'lawyer')
                        <li class="nav-item"><a class="nav-link text-white"
                                href="{{ route('lawyer.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    @endif

                    <li class="nav-item dropdown ms-3">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name ?? Auth::user()->email }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">{{ __('messages.profile') }}</a>
                            <a class="dropdown-item" href="#">Notifications</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger p-0">{{ __('messages.logout') }}</button>
                            </form>
                        </div>
                    </li>
                @endguest
                
                <!-- Language Switcher -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        {{ app()->getLocale() == 'bn' ? 'বাংলা' : 'English' }}
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
