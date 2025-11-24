<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LawLite') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #0b3d91;
            --primary-dark: #08306a;
            --accent: #ffd166;
            --muted: #64748b;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background-color: #fff;
            color: #0f172a;
        }

        .site-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .btn-accent {
            background: var(--accent);
            color: #0b2540;
            border: none;
            font-weight: 600;
        }

        .btn-accent:hover {
            background: #ffc107;
            color: #0b2540;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-light-section {
            background-color: var(--light-bg);
        }

        .small-muted {
            color: var(--muted);
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-5 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">LawLite</h5>
                    <p class="text-white-50">{{ __('messages.hero_desc') }}
                    </p>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">{{ __('messages.footer_platform') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('lawyers.index') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.find_lawyers') }}</a></li>
                        <li class="mb-2"><a href="{{ route('articles.index') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.articles') }}</a></li>
                        <li class="mb-2"><a href="{{ route('appointments.index') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.appointments') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">{{ __('messages.footer_company') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#"
                                class="text-white-50 text-decoration-none">{{ __('messages.footer_about') }}</a>
                        </li>
                        <li class="mb-2"><a href="#"
                                class="text-white-50 text-decoration-none">{{ __('messages.footer_contact') }}</a></li>
                        <li class="mb-2"><a href="#"
                                class="text-white-50 text-decoration-none">{{ __('messages.footer_privacy') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">{{ __('messages.footer_subscribe') }}</h6>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control"
                            placeholder="{{ __('messages.email_placeholder') }}">
                        <button class="btn btn-accent"
                            type="button">{{ __('messages.footer_subscribe_btn') }}</button>
                    </form>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 text-center text-white-50">
                <small>&copy; {{ date('Y') }} LawLite. {{ __('messages.footer_rights') }}</small>
            </div>
        </div>
    </footer>

    @include('components.chat_ui')
    @include('components.appointment_modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Pusher & Echo (optional - requires Pusher keys in .env) -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script>
        window.LAWLITE_USER_ID = {{ auth()->id() ?? 'null' }};
        try {
            Pusher.logToConsole = false;
            const echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });

            if (window.LAWLITE_USER_ID) {
                echo.private('user.' + window.LAWLITE_USER_ID).listen('MessageSent', function(e) {
                    console.log('MessageSent event', e);
                    // Optionally update chat UI live
                });
            }
        } catch (e) {
            console.warn('Echo/Pusher not configured', e);
        }
    </script>
    @stack('scripts')
</body>

</html>
