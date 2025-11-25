@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3">{{ __('messages.dashboard') }}</h1>
                <p class="text-muted">{{ __('messages.welcome_back') }}, {{ $user->name }}</p>
            </div>
            <a href="{{ route('lawyer.cases.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> {{ __('messages.add_new_case') }}
            </a>
            <a href="{{ route('lawyer.availability.index') }}" class="btn btn-outline-primary ms-2">
                <i class="bi bi-calendar-check"></i> {{ __('messages.manage_availability') }}
            </a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="row">
            <!-- Upcoming Cases Section -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('messages.upcoming_cases') }}</h5>
                        <a href="{{ route('lawyer.cases.index') }}"
                            class="btn btn-sm btn-outline-primary">{{ __('messages.view_all') }}</a>
                    </div>
                    <div class="card-body">
                        @if ($upcomingCases->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">{{ __('messages.no_upcoming_cases') }}</p>
                                <a href="{{ route('lawyer.cases.create') }}" class="btn btn-sm btn-primary mt-2">
                                    {{ __('messages.add_first_case') }}
                                </a>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($upcomingCases as $case)
                                    <a href="{{ route('lawyer.cases.show', $case->id) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $case->title }}</h6>
                                                <p class="mb-1 text-muted small">
                                                    <strong>{{ __('messages.client') }}:</strong> {{ $case->client_name }}
                                                    @if ($case->client_phone)
                                                        <span class="ms-2">📞 {{ $case->client_phone }}</span>
                                                    @endif
                                                </p>
                                                @if ($case->description)
                                                    <p class="mb-1 small">
                                                        {{ \Illuminate\Support\Str::limit($case->description, 100) }}</p>
                                                @endif
                                                @if ($case->court_location)
                                                    <p class="mb-0 text-muted small">📍 {{ $case->court_location }}</p>
                                                @endif
                                            </div>
                                            <div class="text-end ms-3">
                                                @if ($case->hearing_date)
                                                    <div class="badge bg-info mb-1">
                                                        {{ $case->hearing_date->format('M d, Y') }}
                                                    </div>
                                                    @if ($case->hearing_time)
                                                        <div class="small text-muted">
                                                            {{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="mt-1">
                                                    @if ($case->status === 'pending')
                                                        <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                                    @elseif($case->status === 'in_progress')
                                                        <span
                                                            class="badge bg-primary">{{ __('messages.in_progress') }}</span>
                                                    @elseif($case->status === 'completed')
                                                        <span
                                                            class="badge bg-success">{{ __('messages.completed') }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ __('messages.closed') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- AI Assistant Section -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('messages.ai_assistant') }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-3">{{ __('messages.ai_assistant_intro') }}</p>

                        <form action="{{ route('ai.ask') }}" method="POST" id="aiQuestionForm">
                            @csrf
                            <div class="mb-3">
                                <textarea name="question" class="form-control" rows="4" placeholder="{{ __('messages.ai_placeholder') }}"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('messages.ai_submit') }}
                            </button>
                        </form>

                        <div id="aiResponse" class="mt-3" style="display:none;">
                            <div class="alert alert-info"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                @if ($lawyer)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('messages.practice_analytics') }}</h6>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="border rounded p-2 text-center">
                                        <small class="text-muted d-block">{{ __('messages.earnings') }}</small>
                                        <h5 class="mb-0 text-success">${{ number_format($totalEarnings, 2) }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 text-center">
                                        <small class="text-muted d-block">{{ __('messages.pending_payment') }}</small>
                                        <h5 class="mb-0 text-warning">${{ number_format($pendingInvoices, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('messages.total_cases') }}</span>
                                <strong>{{ $totalCases }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('messages.active_cases') }}</span>
                                <strong>{{ $activeCases }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('messages.cases_won') }}</span>
                                <strong class="text-success">{{ $casesWon }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('messages.cases_lost') }}</span>
                                <strong class="text-danger">{{ $casesLost }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">{{ __('messages.verification') }}</span>
                                @if ($lawyer->verification_status === 'verified')
                                    <span class="badge bg-success">{{ __('messages.verified') }}</span>
                                @elseif($lawyer->verification_status === 'requested')
                                    <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('messages.not_verified') }}</span>
                                @endif
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('lawyer.invoices.index') }}"
                                    class="btn btn-outline-primary btn-sm">{{ __('messages.manage_invoices') }}</a>
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
