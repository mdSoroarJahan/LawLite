@extends('layouts.landing')

@section('content')
    <style>
        .auth-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            padding: 3rem 0;
            background: linear-gradient(180deg, rgba(248, 250, 252, 0) 0%, rgba(241, 245, 249, 0.5) 100%);
        }
        .auth-card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            position: relative;
        }
        .auth-logo {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
        }
        .auth-logo svg {
            width: 28px;
            height: 28px;
            color: white;
        }
        .auth-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.025em;
        }
        .auth-subtitle {
            color: #64748b;
            font-size: 0.925rem;
        }
        .form-label {
            color: #374151;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        .auth-input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            color: #1e293b;
        }
        .auth-input::placeholder {
            color: #94a3b8;
        }
        .auth-input:focus {
            background: white;
            border-color: #1e293b;
            box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.08);
            outline: none;
        }
        .auth-btn {
            background: #1e293b;
            border: none;
            border-radius: 10px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            width: 100%;
            color: white;
        }
        .auth-btn:hover {
            background: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .auth-btn:active {
            transform: translateY(0);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.8rem;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }
        .divider span {
            padding: 0 1rem;
        }
        .dev-section {
            background: #fefce8;
            border: 1px solid #fef08a;
            border-radius: 10px;
            padding: 1rem;
        }
        .dev-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #a16207;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }
        .dev-btn {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.5rem 0.875rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #374151;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }
        .dev-btn:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            color: #111827;
        }
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }
        .register-link a {
            color: #1e293b;
            font-weight: 600;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        
        /* Dark Mode */
        html[data-theme="dark"] .auth-container {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(30, 41, 59, 0.3) 100%);
        }
        html[data-theme="dark"] .auth-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        html[data-theme="dark"] .auth-title {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .auth-subtitle {
            color: #94a3b8;
        }
        html[data-theme="dark"] .form-label {
            color: #cbd5e1;
        }
        html[data-theme="dark"] .auth-input {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        html[data-theme="dark"] .auth-input::placeholder {
            color: #64748b;
        }
        html[data-theme="dark"] .auth-input:focus {
            background: #0f172a;
            border-color: #475569;
            box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.15);
        }
        html[data-theme="dark"] .auth-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff !important;
            border: none;
        }
        html[data-theme="dark"] .auth-btn:hover {
            box-shadow: 0 0 15px rgba(79, 70, 229, 0.5);
            transform: translateY(-1px);
        }
        html[data-theme="dark"] .divider {
            color: #64748b;
        }
        html[data-theme="dark"] .divider::before,
        html[data-theme="dark"] .divider::after {
            background: #334155;
        }
        html[data-theme="dark"] .dev-section {
            background: rgba(250, 204, 21, 0.1);
            border-color: rgba(250, 204, 21, 0.3);
        }
        html[data-theme="dark"] .dev-label {
            color: #fbbf24;
        }
        html[data-theme="dark"] .dev-btn {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        html[data-theme="dark"] .dev-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        html[data-theme="dark"] .register-link {
            border-color: #334155;
        }
        html[data-theme="dark"] .register-link a {
            color: #f1f5f9;
        }
    </style>

    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="auth-card">
                        <div class="text-center mb-4">
                            <div class="auth-logo">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="3" x2="12" y2="6"/>
                                    <line x1="4" y1="8" x2="20" y2="8"/>
                                    <line x1="6" y1="8" x2="4" y2="14"/>
                                    <line x1="6" y1="8" x2="8" y2="14"/>
                                    <line x1="3" y1="14" x2="9" y2="14"/>
                                    <line x1="18" y1="8" x2="16" y2="14"/>
                                    <line x1="18" y1="8" x2="20" y2="14"/>
                                    <line x1="15" y1="14" x2="21" y2="14"/>
                                    <line x1="12" y1="8" x2="12" y2="20"/>
                                    <line x1="8" y1="20" x2="16" y2="20"/>
                                </svg>
                            </div>
                            <h3 class="auth-title mb-2">Welcome back</h3>
                            <p class="auth-subtitle mb-0">Sign in to your LawLite account</p>
                        </div>
                        
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger rounded-3 mb-3 py-2 px-3" style="font-size: 0.875rem;">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('status'))
                                <div class="alert alert-success rounded-3 mb-3 py-2 px-3" style="font-size: 0.875rem;">{{ session('status') }}</div>
                            @endif
                            
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.email') }}</label>
                                <input name="email" type="email" value="{{ old('email') }}" class="form-control auth-input" placeholder="name@example.com" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label">{{ __('messages.password') }}</label>
                                <input name="password" type="password" class="form-control auth-input" placeholder="Enter your password" />
                            </div>
                            <button class="btn btn-primary auth-btn">
                                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('messages.login') }}
                            </button>

                            @if (env('APP_ENV') === 'local')
                                <div class="dev-section">
                                    <div class="small text-muted mb-2">
                                        <i class="bi bi-lightning-charge me-1"></i>Quick sign-in (dev only):
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ url('/_dev/login-as/admin') }}" class="dev-btn text-decoration-none">
                                            <i class="bi bi-shield-check me-1"></i>Admin
                                        </a>
                                        <a href="{{ url('/_dev/login-as/lawyer') }}" class="dev-btn text-decoration-none">
                                            <i class="bi bi-briefcase me-1"></i>Lawyer
                                        </a>
                                        <a href="{{ url('/_dev/login-as/user') }}" class="dev-btn text-decoration-none">
                                            <i class="bi bi-person me-1"></i>User
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
