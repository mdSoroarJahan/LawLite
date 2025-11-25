@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <h1 class="h3 mb-4">{{ __('messages.my_appointments') }}</h1>

        @if ($appointments->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">{{ __('messages.book_appointment_description') }}</p>
                <a href="{{ route('lawyers.index') }}" class="btn btn-primary">Find a Lawyer</a>
            </div>
        @else
            <div class="row">
                @foreach ($appointments as $appointment)
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $appointment->lawyer->user->name ?? 'Lawyer' }}</h5>
                                        <p class="text-muted small mb-0">{{ $appointment->type ?? 'Consultation' }}</p>
                                    </div>
                                    <span
                                        class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                                </div>
                                <div class="mb-3">
                                    <i class="bi bi-clock me-2"></i>
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                </div>

                                @if ($appointment->meeting_link)
                                    <a href="{{ $appointment->meeting_link }}" target="_blank"
                                        class="btn btn-primary w-100">
                                        <i class="bi bi-camera-video me-2"></i> Join Meeting
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
