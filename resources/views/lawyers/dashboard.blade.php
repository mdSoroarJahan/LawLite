@extends('layouts.landing')

@section('content')
    <style>
        /* ===== MODERN PROFESSIONAL LAWYER DASHBOARD ===== */
        
        /* Header */
        .dashboard-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
        }
        .welcome-text {
            color: #10b981;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-btn {
            background: #10b981;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.25s ease;
        }
        .action-btn:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
            color: white;
        }
        .action-btn-outline {
            background: transparent;
            border: 2px solid #10b981;
            color: #10b981;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            transition: all 0.25s ease;
        }
        .action-btn-outline:hover {
            background: #10b981;
            border-color: #10b981;
            color: white;
            transform: translateY(-2px);
        }

        /* Cards */
        .glass-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .glass-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .glass-card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
        }
        .glass-card-header h5 {
            color: #1f2937;
        }
        .glass-card-header .text-primary {
            color: #10b981 !important;
        }
        .glass-card-body {
            padding: 1.5rem;
        }

        /* Case List Items */
        .case-item {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            transition: all 0.25s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .case-item:hover {
            background: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.3);
            transform: translateX(4px);
            color: inherit;
        }
        .case-item h6 {
            color: #1f2937;
        }
        .case-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
        }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-in-progress { background: #dbeafe; color: #2563eb; }
        .badge-completed { background: #d1fae5; color: #059669; }
        .badge-closed { background: #f1f5f9; color: #64748b; }

        /* AI Card */
        .ai-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
        }
        .ai-card .glass-card-header {
            background: #f0fdf4;
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
        }
        .ai-card .glass-card-header h5 .bi-robot {
            color: #10b981 !important;
        }
        .ai-textarea {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            transition: all 0.25s ease;
            color: #1f2937;
        }
        .ai-textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            outline: none;
        }
        .ai-submit-btn {
            background: #10b981;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: all 0.25s ease;
        }
        .ai-submit-btn:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        }

        /* Stats Card */
        .stats-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
        }
        .stats-card .glass-card-body h6 {
            color: #1f2937;
        }
        .stats-card .text-success {
            color: #10b981 !important;
        }
        .stat-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            transition: all 0.25s ease;
        }
        .stat-box:hover {
            background: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.2);
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .stat-value.success { color: #10b981; }
        .stat-value.warning { color: #f59e0b; }
        .stat-value.danger { color: #ef4444; }
        .stat-value.primary { color: #10b981; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }
        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .empty-icon i {
            color: #10b981 !important;
        }

        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .dashboard-header {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .dashboard-header h1 {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .welcome-text {
            color: #34d399;
        }
        html[data-theme="dark"] .action-btn-outline {
            border-color: #34d399;
            color: #34d399;
        }
        html[data-theme="dark"] .action-btn-outline:hover {
            background: #10b981;
            color: white;
        }
        html[data-theme="dark"] .glass-card {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .glass-card:hover {
            border-color: rgba(52, 211, 153, 0.3);
        }
        html[data-theme="dark"] .glass-card-header {
            background: #0f172a;
            border-bottom-color: #334155;
        }
        html[data-theme="dark"] .glass-card-header h5 {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .glass-card-header .text-primary {
            color: #34d399 !important;
        }
        html[data-theme="dark"] .case-item {
            background: #0f172a;
            border-color: #334155;
        }
        html[data-theme="dark"] .case-item:hover {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(52, 211, 153, 0.3);
        }
        html[data-theme="dark"] .case-item h6 {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .case-item .text-muted {
            color: #94a3b8 !important;
        }
        html[data-theme="dark"] .badge-pending { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
        html[data-theme="dark"] .badge-in-progress { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
        html[data-theme="dark"] .badge-completed { background: rgba(16, 185, 129, 0.15); color: #34d399; }
        html[data-theme="dark"] .badge-closed { background: rgba(100, 116, 139, 0.15); color: #94a3b8; }
        html[data-theme="dark"] .ai-card {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .ai-card .glass-card-header {
            background: rgba(16, 185, 129, 0.1);
            border-bottom-color: rgba(16, 185, 129, 0.2);
        }
        html[data-theme="dark"] .ai-card .glass-card-header h5 .bi-robot {
            color: #34d399 !important;
        }
        html[data-theme="dark"] .ai-textarea {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        html[data-theme="dark"] .ai-textarea:focus {
            border-color: #34d399;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
        }
        html[data-theme="dark"] .ai-textarea::placeholder {
            color: #94a3b8;
        }
        html[data-theme="dark"] .stats-card {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .stats-card .glass-card-body h6 {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .stats-card .text-muted {
            color: #94a3b8 !important;
        }
        html[data-theme="dark"] .stat-box {
            background: #0f172a;
            border-color: #334155;
        }
        html[data-theme="dark"] .stat-box:hover {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(52, 211, 153, 0.2);
        }
        html[data-theme="dark"] .stat-box small {
            color: #94a3b8 !important;
        }
        html[data-theme="dark"] .stat-value.primary { color: #34d399; }
        html[data-theme="dark"] .empty-icon {
            background: rgba(16, 185, 129, 0.15);
        }
        html[data-theme="dark"] .empty-icon i {
            color: #34d399 !important;
        }
        html[data-theme="dark"] .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
            color: #34d399;
        }
        html[data-theme="dark"] #aiResponse .alert-info {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
            color: #93c5fd;
        }
        html[data-theme="dark"] #aiResponse .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
            color: #34d399;
        }
        html[data-theme="dark"] #aiResponse .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #f87171;
        }
    </style>

    <div class="container py-4">
        <!-- Premium Header -->
        <div class="dashboard-header reveal">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">{{ __('messages.dashboard') }}</h1>
                    <p class="mb-0 text-muted">{{ __('messages.welcome_back') }}, <span class="welcome-text fw-semibold">{{ $user->name }}</span></p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('lawyer.cases.create') }}" class="btn btn-primary action-btn">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('messages.add_new_case') }}
                    </a>
                    <a href="{{ route('lawyer.availability.index') }}" class="btn action-btn-outline">
                        <i class="bi bi-calendar-check me-2"></i>{{ __('messages.manage_availability') }}
                    </a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success rounded-4 mb-4 reveal">{{ session('status') }}</div>
        @endif

        <div class="row">
            <!-- Upcoming Cases Section -->
            <div class="col-lg-8 mb-4">
                <div class="glass-card reveal">
                    <div class="glass-card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-briefcase me-2 text-primary"></i>{{ __('messages.upcoming_cases') }}
                        </h5>
                        <a href="{{ route('lawyer.cases.index') }}" class="btn btn-sm action-btn-outline">
                            {{ __('messages.view_all') }} <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="glass-card-body">
                        @if ($upcomingCases->isEmpty())
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-folder-x" style="font-size: 2rem; color: #4f46e5;"></i>
                                </div>
                                <p class="text-muted mb-3">{{ __('messages.no_upcoming_cases') }}</p>
                                <a href="{{ route('lawyer.cases.create') }}" class="btn btn-sm action-btn">
                                    <i class="bi bi-plus me-1"></i>{{ __('messages.add_first_case') }}
                                </a>
                            </div>
                        @else
                            @foreach ($upcomingCases as $case)
                                <a href="{{ route('lawyer.cases.show', $case->id) }}" class="case-item">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $case->title }}</h6>
                                            <p class="mb-1 text-muted small">
                                                <strong>{{ __('messages.client') }}:</strong> {{ $case->client_name }}
                                                @if ($case->client_phone)
                                                    <span class="ms-2"><i class="bi bi-telephone-fill me-1"></i>{{ $case->client_phone }}</span>
                                                @endif
                                            </p>
                                            @if ($case->description)
                                                <p class="mb-1 small text-muted">
                                                    {{ \Illuminate\Support\Str::limit($case->description, 100) }}</p>
                                            @endif
                                            @if ($case->court_location)
                                                <p class="mb-0 text-muted small">
                                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>{{ $case->court_location }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-end ms-3">
                                            @if ($case->hearing_date)
                                                <div class="case-badge badge-in-progress mb-1">
                                                    <i class="bi bi-calendar me-1"></i>{{ $case->hearing_date->format('M d, Y') }}
                                                </div>
                                                @if ($case->hearing_time)
                                                    <div class="small text-muted">
                                                        <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="mt-1">
                                                @if ($case->status === 'pending')
                                                    <span class="case-badge badge-pending">{{ __('messages.pending') }}</span>
                                                @elseif($case->status === 'in_progress')
                                                    <span class="case-badge badge-in-progress">{{ __('messages.in_progress') }}</span>
                                                @elseif($case->status === 'completed')
                                                    <span class="case-badge badge-completed">{{ __('messages.completed') }}</span>
                                                @else
                                                    <span class="case-badge badge-closed">{{ __('messages.closed') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- AI Assistant Section -->
            <div class="col-lg-4 mb-4">
                <div class="glass-card ai-card reveal" style="animation-delay: 0.1s;">
                    <div class="glass-card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-robot me-2" style="color: #8b5cf6;"></i>{{ __('messages.ai_assistant') }}
                        </h5>
                    </div>
                    <div class="glass-card-body">
                        <p class="small text-muted mb-3">{{ __('messages.ai_assistant_intro') }}</p>

                        <form action="{{ route('ai.ask') }}" method="POST" id="aiQuestionForm">
                            @csrf
                            <div class="mb-3">
                                <textarea name="question" class="form-control ai-textarea" rows="4" placeholder="{{ __('messages.ai_placeholder') }}"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 ai-submit-btn">
                                <i class="bi bi-sparkles me-2"></i>{{ __('messages.ai_submit') }}
                            </button>
                        </form>

                        <div id="aiResponse" class="mt-3" style="display:none;">
                            <div class="alert alert-info rounded-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                @if ($lawyer)
                    <div class="glass-card stats-card mt-4 reveal" style="animation-delay: 0.2s;">
                        <div class="glass-card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-graph-up-arrow me-2 text-success"></i>{{ __('messages.practice_analytics') }}
                            </h6>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="stat-box">
                                        <small class="text-muted d-block">{{ __('messages.earnings') }}</small>
                                        <h5 class="stat-value success mb-0">${{ number_format($totalEarnings, 2) }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-box">
                                        <small class="text-muted d-block">{{ __('messages.pending_payment') }}</small>
                                        <h5 class="stat-value warning mb-0">${{ number_format($pendingInvoices, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2 py-1">
                                <span class="text-muted">{{ __('messages.total_cases') }}</span>
                                <strong class="stat-value primary" style="font-size: 1rem;">{{ $totalCases }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 py-1">
                                <span class="text-muted">{{ __('messages.active_cases') }}</span>
                                <strong style="color: #3b82f6;">{{ $activeCases }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 py-1">
                                <span class="text-muted">{{ __('messages.cases_won') }}</span>
                                <strong class="text-success">{{ $casesWon }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 py-1">
                                <span class="text-muted">{{ __('messages.cases_lost') }}</span>
                                <strong class="text-danger">{{ $casesLost }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3 py-1">
                                <span class="text-muted">{{ __('messages.verification') }}</span>
                                @if ($lawyer->verification_status === 'verified')
                                    <span class="case-badge badge-completed">{{ __('messages.verified') }}</span>
                                @elseif($lawyer->verification_status === 'requested')
                                    <span class="case-badge badge-pending">{{ __('messages.pending') }}</span>
                                @else
                                    <span class="case-badge badge-closed">{{ __('messages.not_verified') }}</span>
                                @endif
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('lawyer.invoices.index') }}" class="btn action-btn-outline btn-sm">
                                    <i class="bi bi-receipt me-2"></i>{{ __('messages.manage_invoices') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('aiQuestionForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const responseDiv = document.getElementById('aiResponse');
            const responseAlert = responseDiv.querySelector('.alert');

            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>{{ __('messages.processing') }}';
            responseDiv.style.display = 'block';
            responseAlert.className = 'alert alert-info';
            responseAlert.textContent = '{{ __('messages.thinking') }}';

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
                    const answer = typeof data.result === 'string' ? data.result : JSON.stringify(data.result,
                        null, 2);
                    responseAlert.innerHTML =
                        '<strong>{{ __('messages.answer_label') }}</strong><br><div style="white-space: pre-wrap;">' +
                        answer + '</div>';
                } else {
                    responseAlert.className = 'alert alert-danger';
                    responseAlert.textContent = data.error || data.message ||
                        '{{ __('messages.error_occurred') }}';
                }
            } catch (error) {
                responseAlert.className = 'alert alert-danger';
                responseAlert.textContent = '{{ __('messages.network_error') }}';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = '{{ __('messages.ai_submit') }}';
            }
        });
    </script>
@endpush
