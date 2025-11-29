@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="h3 mb-4">{{ __('messages.my_appointments') }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments') }}">{{ __('messages.all') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'pending']) }}">{{ __('messages.pending') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'confirmed' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'confirmed']) }}">{{ __('messages.confirmed') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'completed']) }}">{{ __('messages.completed') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'cancelled']) }}">{{ __('messages.cancelled') }}</a>
            </li>
        </ul>

        @if (empty($appointments) || count($appointments) === 0)
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">{{ __('messages.no_appointments_found') }}</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($appointments as $appointment)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="card-title mb-1">
                                            {{ $appointment->user ? $appointment->user->name : __('messages.unknown_client') }}
                                        </h5>
                                        <p class="text-muted small mb-0">
                                            {{ $appointment->type ?? __('messages.consultation') }}
                                        </p>
                                    </div>
                                    <div>
                                        @if ($appointment->status === 'pending')
                                            <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                        @elseif($appointment->status === 'confirmed')
                                            <span class="badge bg-success">{{ __('messages.confirmed') }}</span>
                                        @elseif($appointment->status === 'completed')
                                            <span class="badge bg-info">{{ __('messages.completed') }}</span>
                                        @elseif($appointment->status === 'cancelled')
                                            <span class="badge bg-danger">{{ __('messages.cancelled') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                        @endif
                                    </div>
                                </div>

                                <hr>

                                <div class="mb-2">
                                    <strong>{{ __('messages.date') }}:</strong>
                                    {{ $appointment->date ? \Carbon\Carbon::parse($appointment->date)->format('M d, Y') : __('messages.not_set') }}
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('messages.time') }}:</strong>
                                    {{ $appointment->time ? \Carbon\Carbon::parse($appointment->time)->format('h:i A') : __('messages.not_set') }}
                                </div>

                                @if ($appointment->notes)
                                    <div class="mb-2">
                                        <strong>{{ __('messages.notes') }}:</strong>
                                        <p class="mb-0 small">{{ $appointment->notes }}</p>
                                    </div>
                                @endif

                                @if ($appointment->user && $appointment->user->email)
                                    <div class="mb-2 small text-muted">
                                        {{ __('messages.contact') }}: {{ $appointment->user->email }}
                                        @if ($appointment->user->phone)
                                            | {{ $appointment->user->phone }}
                                        @endif
                                    </div>
                                @endif

                                @if ($appointment->status === 'pending')
                                    <div class="mt-3 d-flex gap-2">
                                        <form action="{{ route('lawyer.appointments.accept', $appointment->id) }}"
                                            method="POST" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="bi bi-check-circle"></i> {{ __('messages.accept') }}
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-outline-danger btn-sm flex-fill"
                                            onclick="showConfirmation('{{ route('lawyer.appointments.reject', $appointment->id) }}', 'Reject Appointment', 'Are you sure you want to reject this appointment? This action cannot be undone.', 'btn-danger', 'Reject Appointment', 'text-danger')">
                                            <i class="bi bi-x-circle"></i> {{ __('messages.reject') }}
                                        </button>
                                    </div>
                                @elseif ($appointment->status === 'confirmed')
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-info btn-sm w-100 text-white"
                                            onclick="showConfirmation('{{ route('lawyer.appointments.complete', $appointment->id) }}', 'Complete Appointment', 'Are you sure you want to mark this appointment as completed?', 'btn-info text-white', 'Mark Completed', 'text-info')">
                                            <i class="bi bi-check2-all"></i> Mark as Completed
                                        </button>
                                    </div>
                                @endif

                                @if ($appointment->meeting_link)
                                    <div class="mt-3">
                                        <a href="{{ $appointment->meeting_link }}" target="_blank"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-camera-video"></i> Join Online Meeting
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-3">
                        <div class="avatar-md mx-auto mb-3 text-warning" id="modalIcon">
                            <i class="bi bi-exclamation-circle display-4"></i>
                        </div>
                        <p class="text-muted mb-0 fs-5" id="modalMessage">Are you sure you want to proceed?</p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form id="confirmationForm" method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4" id="modalConfirmBtn">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showConfirmation(actionUrl, title, message, btnClass = 'btn-danger', btnText = 'Confirm', iconClass =
            'text-warning') {
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            document.getElementById('confirmationForm').action = actionUrl;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;

            const confirmBtn = document.getElementById('modalConfirmBtn');
            confirmBtn.className = `btn ${btnClass} px-4`;
            confirmBtn.textContent = btnText;

            const iconContainer = document.getElementById('modalIcon');
            iconContainer.className = `avatar-md mx-auto mb-3 ${iconClass}`;

            modal.show();
        }
    </script>
@endsection
