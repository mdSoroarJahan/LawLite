@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="h3 mb-4">My Appointments</h1>

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
                    href="{{ route('lawyer.appointments') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'confirmed' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'confirmed']) }}">Confirmed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'completed']) }}">Completed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}"
                    href="{{ route('lawyer.appointments', ['status' => 'cancelled']) }}">Cancelled</a>
            </li>
        </ul>

        @if (empty($appointments) || count($appointments) === 0)
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">No appointments found</p>
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
                                            {{ $appointment->user ? $appointment->user->name : 'Unknown Client' }}
                                        </h5>
                                        <p class="text-muted small mb-0">
                                            {{ $appointment->type ?? 'Consultation' }}
                                        </p>
                                    </div>
                                    <div>
                                        @if ($appointment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($appointment->status === 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($appointment->status === 'completed')
                                            <span class="badge bg-info">Completed</span>
                                        @elseif($appointment->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                        @endif
                                    </div>
                                </div>

                                <hr>

                                <div class="mb-2">
                                    <strong>Date:</strong>
                                    {{ $appointment->date ? \Carbon\Carbon::parse($appointment->date)->format('M d, Y') : 'Not set' }}
                                </div>
                                <div class="mb-2">
                                    <strong>Time:</strong>
                                    {{ $appointment->time ? \Carbon\Carbon::parse($appointment->time)->format('h:i A') : 'Not set' }}
                                </div>

                                @if ($appointment->notes)
                                    <div class="mb-2">
                                        <strong>Notes:</strong>
                                        <p class="mb-0 small">{{ $appointment->notes }}</p>
                                    </div>
                                @endif

                                @if ($appointment->user && $appointment->user->email)
                                    <div class="mb-2 small text-muted">
                                        Contact: {{ $appointment->user->email }}
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
                                                <i class="bi bi-check-circle"></i> Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('lawyer.appointments.reject', $appointment->id) }}"
                                            method="POST" class="flex-fill"
                                            onsubmit="return confirm('Are you sure you want to reject this appointment?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="bi bi-x-circle"></i> Reject
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
