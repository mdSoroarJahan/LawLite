@extends('layouts.landing')

@section('content')
    <style>
        .auth-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #4f46e5, #f59e0b);
        }
        .auth-title {
            background: linear-gradient(135deg, #10b981 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        .auth-input {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
        }
        .auth-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            background: white;
        }
        .auth-select {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
        }
        .auth-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .auth-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        .role-info {
            background: rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
        }
        html[data-theme="dark"] .auth-card {
            background: rgba(30, 41, 59, 0.9);
            border-color: rgba(255, 255, 255, 0.1);
        }
        html[data-theme="dark"] .auth-input,
        html[data-theme="dark"] .auth-select {
            background: rgba(15, 23, 42, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        html[data-theme="dark"] .role-info {
            background: rgba(79, 70, 229, 0.2);
        }
    </style>

    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card reveal">
                        <div class="text-center mb-4">
                            <h3 class="auth-title mb-2">{{ __('messages.register') }}</h3>
                            <p class="text-muted small">Create your account to get started.</p>
                        </div>
                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger rounded-3 mb-3">
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.name') }}</label>
                                <input name="name" value="{{ old('name') }}" class="form-control auth-input" placeholder="Your full name" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.email') }}</label>
                                <input name="email" value="{{ old('email') }}" class="form-control auth-input" placeholder="your@email.com" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.password') }}</label>
                                <input name="password" type="password" class="form-control auth-input" placeholder="••••••••" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.confirm_password') }}</label>
                                <input name="password_confirmation" type="password" class="form-control auth-input" placeholder="••••••••" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.register_as') }}</label>
                                <select name="role" class="form-select auth-select">
                                    <option value="user" @if (old('role', 'user') === 'user') selected @endif>
                                        {{ __('messages.user') }}
                                    </option>
                                    <option value="lawyer" @if (old('role') === 'lawyer') selected @endif>
                                        {{ __('messages.lawyer') }}
                                    </option>
                                </select>
                                <div class="role-info mt-2">
                                    <i class="bi bi-info-circle me-1 text-primary"></i>
                                    If you are a practicing lawyer, choose "Register as Lawyer". Lawyers will be reviewed by admins before verification.
                                </div>
                            </div>

                            <button class="btn btn-success auth-btn">
                                <i class="bi bi-person-plus me-2"></i>{{ __('messages.register') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
