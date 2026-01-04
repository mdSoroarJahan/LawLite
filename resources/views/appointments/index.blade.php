@extends('layouts.landing')

@section('content')
    <style>
        .appointments-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(79, 70, 229, 0.08) 50%, rgba(16, 185, 129, 0.06) 100%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .appointments-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
        }
        .appointments-title {
            background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .appointment-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }
        .appointment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #4f46e5, #10b981);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .appointment-card:hover::before {
            opacity: 1;
        }
        .appointment-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }
        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-confirmed {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        .status-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        .status-cancelled {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        .appointment-info {
            background: rgba(59, 130, 246, 0.08);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
        }
        .appointment-info i {
            color: #3b82f6;
            width: 24px;
        }
        .join-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .join-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        .join-btn:hover::before {
            left: 100%;
        }
        .join-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        .empty-state {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 4rem 2rem;
            text-align: center;
        }
        .empty-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(79, 70, 229, 0.1) 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .find-lawyer-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .find-lawyer-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }
        html[data-theme="dark"] .appointments-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(79, 70, 229, 0.12) 50%, rgba(16, 185, 129, 0.1) 100%);
        }
        html[data-theme="dark"] .appointment-card {
            background: rgba(30, 41, 59, 0.85);
            border-color: rgba(255, 255, 255, 0.1);
        }
        html[data-theme="dark"] .appointment-info {
            background: rgba(59, 130, 246, 0.15);
        }
        html[data-theme="dark"] .empty-state {
            background: rgba(30, 41, 59, 0.7);
        }
    </style>

    <div class="container py-5">
        <div class="appointments-header reveal">
            <h1 class="h3 fw-bold appointments-title mb-0">{{ __('messages.my_appointments') }}</h1>
        </div>

        @if ($appointments->isEmpty())
            <div class="empty-state reveal">
                <div class="empty-icon">
                    <i class="bi bi-calendar-x" style="font-size: 2.5rem; color: #3b82f6;"></i>
                </div>
                <h4 class="fw-bold mb-2">No Appointments Yet</h4>
                <p class="text-muted mb-4">{{ __('messages.book_appointment_description') }}</p>
                <a href="{{ route('lawyers.index') }}" class="btn btn-primary find-lawyer-btn">
                    <i class="bi bi-search me-2"></i>Find a Lawyer
                </a>
            </div>
        @else
            <div class="row">
                @foreach ($appointments as $appointment)
                    <div class="col-lg-6 mb-4 reveal" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <div class="appointment-card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $appointment->lawyer->user->name ?? 'Lawyer' }}</h5>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-briefcase me-1"></i>{{ $appointment->type ?? 'Consultation' }}
                                        </p>
                                    </div>
                                    <span class="status-badge status-{{ $appointment->status === 'confirmed' ? 'confirmed' : ($appointment->status === 'cancelled' ? 'cancelled' : 'pending') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>

                                <div class="appointment-info d-flex align-items-center">
                                    <i class="bi bi-calendar-event"></i>
                                    <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</span>
                                </div>
                                <div class="appointment-info d-flex align-items-center mb-4">
                                    <i class="bi bi-clock"></i>
                                    <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</span>
                                </div>

                                @if ($appointment->meeting_link)
                                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="btn btn-primary join-btn w-100">
                                        <i class="bi bi-camera-video me-2"></i>Join Meeting
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
