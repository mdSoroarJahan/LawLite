@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3">{{ __('messages.dashboard') }}</h1>
                <p class="text-muted">Welcome back, {{ $user->name }}</p>
            </div>
            <a href="{{ route('lawyer.cases.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Case
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
                        <h5 class="mb-0">Upcoming Cases</h5>
                        <a href="{{ route('lawyer.cases.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @if ($upcomingCases->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">No upcoming cases scheduled</p>
                                <a href="{{ route('lawyer.cases.create') }}" class="btn btn-sm btn-primary mt-2">
                                    Add Your First Case
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
                                                    <strong>Client:</strong> {{ $case->client_name }}
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
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($case->status === 'in_progress')
                                                        <span class="badge bg-primary">In Progress</span>
                                                    @elseif($case->status === 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-secondary">Closed</span>
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
                        <p class="small text-muted mb-3">Ask legal questions and get AI-powered assistance</p>

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
                            <h6 class="card-title">Quick Stats</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Cases</span>
                                <strong>{{ \App\Models\LawyerCase::where('lawyer_id', $lawyer->id)->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Active Cases</span>
                                <strong>{{ \App\Models\LawyerCase::where('lawyer_id', $lawyer->id)->whereIn('status', ['pending', 'in_progress'])->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Verification</span>
                                @if ($lawyer->verification_status === 'verified')
                                    <span class="badge bg-success">Verified</span>
                                @elseif($lawyer->verification_status === 'requested')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">Not Verified</span>
                                @endif
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
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            responseDiv.style.display = 'block';
            responseAlert.className = 'alert alert-info';
            responseAlert.textContent = 'Thinking...';

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
                        '<strong>Answer:</strong><br><div style="white-space: pre-wrap;">' + answer + '</div>';
                } else {
                    responseAlert.className = 'alert alert-danger';
                    responseAlert.textContent = data.error || data.message ||
                        'An error occurred. Please try again.';
                }
            } catch (error) {
                responseAlert.className = 'alert alert-danger';
                responseAlert.textContent = 'Network error. Please check your connection and try again.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = '{{ __('messages.ai_submit') }}';
            }
        });
    </script>
@endpush
