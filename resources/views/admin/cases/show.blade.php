@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                class="text-decoration-none text-muted">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.cases.index') }}"
                                class="text-decoration-none text-muted">Cases</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Case #{{ $case->case_number ?? $case->id }}
                        </li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">{{ $case->title }}</h1>
            </div>
            <a href="{{ route('admin.cases.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Cases
            </a>
        </div>

        <div class="row g-4">
            <!-- Left Column: Main Info -->
            <div class="col-lg-8">
                <!-- Case Overview -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title fw-bold mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Case Overview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Case Number</label>
                                <div class="fs-5 fw-semibold text-dark">{{ $case->case_number ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Current Status</label>
                                <div>
                                    @if ($case->status === 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                    @elseif($case->status === 'in_progress')
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">In Progress</span>
                                    @elseif($case->status === 'completed')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">Closed</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($case->description)
                            <div class="mb-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Description</label>
                                <p class="text-dark">{{ $case->description }}</p>
                            </div>
                        @endif

                        @if ($case->notes)
                            <div class="p-3 bg-light rounded border-start border-4 border-info">
                                <label class="text-info small text-uppercase fw-bold mb-1">Internal Notes</label>
                                <p class="mb-0 text-muted fst-italic">{{ $case->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Hearing Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title fw-bold mb-0"><i class="bi bi-calendar-event me-2 text-primary"></i>Hearing
                            Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Hearing Date</label>
                                <div class="fs-5 fw-semibold text-dark">
                                    {{ $case->hearing_date ? $case->hearing_date->format('M d, Y') : 'Not scheduled' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Hearing Time</label>
                                <div class="fs-5 fw-semibold text-dark">
                                    {{ $case->hearing_time ? \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Court Location</label>
                                <div class="fs-5 fw-semibold text-dark">{{ $case->court_location ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Side Info -->
            <div class="col-lg-4">
                <!-- Lawyer Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title fw-bold mb-0"><i class="bi bi-person-badge me-2 text-success"></i>Lawyer</h6>
                    </div>
                    <div class="card-body">
                        @if ($case->lawyer && $case->lawyer->user)
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center me-3"
                                    style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ substr($case->lawyer->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $case->lawyer->user->name }}</div>
                                    <small class="text-muted">{{ $case->lawyer->user->email }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">No lawyer assigned</p>
                        @endif
                    </div>
                </div>

                <!-- Client Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title fw-bold mb-0"><i class="bi bi-person me-2 text-primary"></i>Client</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Name</label>
                            <div class="fw-semibold">{{ $case->client_name }}</div>
                        </div>
                        @if ($case->client_email)
                            <div class="mb-3">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Email</label>
                                <div class="fw-semibold">{{ $case->client_email }}</div>
                            </div>
                        @endif
                        @if ($case->client_phone)
                            <div>
                                <label class="text-muted small text-uppercase fw-bold mb-1">Phone</label>
                                <div class="fw-semibold">{{ $case->client_phone }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title fw-bold mb-0"><i class="bi bi-clock-history me-2 text-info"></i>Timeline</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Created</small>
                            <div class="fw-semibold">{{ $case->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Last Updated</small>
                            <div class="fw-semibold">{{ $case->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
