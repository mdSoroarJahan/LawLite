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
                                        <form action="{{ route('lawyer.appointments.reject', $appointment->id) }}"
                                            method="POST" class="flex-fill"
                                            onsubmit="return confirm('{{ __('messages.confirm_reject_appointment') }}');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="bi bi-x-circle"></i> {{ __('messages.reject') }}
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
