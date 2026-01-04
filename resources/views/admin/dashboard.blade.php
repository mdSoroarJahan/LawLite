@extends('layouts.landing')

@section('content')
    <style>
        /* ===== MODERN PROFESSIONAL ADMIN DASHBOARD ===== */
        .admin-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }
        .admin-title {
            color: #10b981;
            font-weight: 700;
        }
        .admin-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }
        .admin-link {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            text-decoration: none;
            color: #1f2937;
            transition: all 0.25s ease;
            position: relative;
        }
        .admin-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: #10b981;
            transition: width 0.25s ease;
            border-radius: 0 4px 4px 0;
        }
        .admin-link:hover {
            background: #f8fafc;
            transform: translateX(4px);
            color: #1f2937;
        }
        .admin-link:hover::before {
            width: 4px;
        }
        .admin-link:last-child {
            border-bottom: none;
        }
        .admin-link .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 1rem;
            transition: all 0.25s ease;
        }
        .admin-link:hover .icon {
            transform: scale(1.05);
        }
        .icon-users {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        .icon-lawyers {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        .icon-articles {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }
        .icon-dev {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }
        .admin-link-text {
            font-weight: 600;
            font-size: 1rem;
        }
        .admin-link-arrow {
            margin-left: auto;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.25s ease;
            color: #10b981;
        }
        .admin-link:hover .admin-link-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .admin-header {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .admin-title {
            color: #34d399;
        }
        html[data-theme="dark"] .admin-header p {
            color: #94a3b8 !important;
        }
        html[data-theme="dark"] .admin-card {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .admin-link {
            color: #f1f5f9;
            border-bottom-color: #334155;
        }
        html[data-theme="dark"] .admin-link:hover {
            background: rgba(16, 185, 129, 0.08);
            color: #f1f5f9;
        }
        html[data-theme="dark"] .admin-link::before {
            background: #34d399;
        }
        html[data-theme="dark"] .admin-link-arrow {
            color: #34d399;
        }
        html[data-theme="dark"] .icon-users {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }
        html[data-theme="dark"] .icon-lawyers {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }
        html[data-theme="dark"] .icon-articles {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
        }
        html[data-theme="dark"] .icon-dev {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
        }
    </style>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="admin-header reveal text-center">
                    <h1 class="display-5 fw-bold admin-title mb-2">Admin Dashboard</h1>
                    <p class="text-muted mb-0">Manage your LawLite platform</p>
                </div>

                <div class="admin-card reveal" style="animation-delay: 0.1s;">
                    <a href="{{ route('admin.users.index') }}" class="admin-link">
                        <div class="icon icon-users">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <span class="admin-link-text">Manage Users</span>
                        <i class="bi bi-arrow-right admin-link-arrow"></i>
                    </a>
                    <a href="{{ route('admin.verification.index') }}" class="admin-link">
                        <div class="icon icon-lawyers">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <span class="admin-link-text">Manage Lawyers</span>
                        <i class="bi bi-arrow-right admin-link-arrow"></i>
                    </a>
                    <a href="{{ route('admin.articles.index') }}" class="admin-link">
                        <div class="icon icon-articles">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <span class="admin-link-text">Manage Articles</span>
                        <i class="bi bi-arrow-right admin-link-arrow"></i>
                    </a>
                    @if (env('APP_ENV') === 'local')
                    <a href="{{ url('/_dev/login-as/admin') }}" class="admin-link">
                        <div class="icon icon-dev">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <span class="admin-link-text text-warning">Dev: Login as admin</span>
                        <i class="bi bi-arrow-right admin-link-arrow"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
