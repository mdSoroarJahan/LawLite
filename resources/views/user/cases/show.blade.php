@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">{{ $case->title }}</h1>
                    <a href="{{ route('user.cases.index') }}" class="btn btn-outline-secondary btn-sm">Back to Cases</a>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Case Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4 text-muted">Case Number</div>
                                    <div class="col-md-8 fw-bold">{{ $case->case_number ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 text-muted">Status</div>
                                    <div class="col-md-8">
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
                                <div class="row mb-3">
                                    <div class="col-md-4 text-muted">Description</div>
                                    <div class="col-md-8">{{ $case->description }}</div>
                                </div>

                                @if ($case->notes)
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Notes</div>
                                        <div class="col-md-8">{{ $case->notes }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Documents</h5>
                            </div>
                            <div class="card-body">
                                @if ($case->documents->isEmpty())
                                    <p class="text-muted mb-0">No documents attached to this case.</p>
                                @else
                                    <div class="list-group">
                                        @foreach ($case->documents as $doc)
                                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    {{ $doc->file_name }}
                                                </div>
                                                <small class="text-muted">{{ $doc->created_at->format('M d, Y') }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Lawyer Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Your Lawyer</h5>
                            </div>
                            <div class="card-body text-center">
                                @if ($case->lawyer->user->profile_photo_path)
                                    <img src="{{ Storage::url($case->lawyer->user->profile_photo_path) }}"
                                        class="rounded-circle mb-3" width="80" height="80" alt="Lawyer">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 80px; height: 80px; font-size: 2rem;">
                                        {{ substr($case->lawyer->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <h5 class="card-title">{{ $case->lawyer->user->name }}</h5>
                                <p class="text-muted mb-2">{{ $case->lawyer->expertise ?? 'Legal Expert' }}</p>
                                <a href="{{ route('lawyers.show', $case->lawyer->id) }}"
                                    class="btn btn-sm btn-outline-primary">View Profile</a>
                            </div>
                        </div>

                        <!-- Hearing Info -->
                        @if ($case->hearing_date)
                            <div class="card bg-light border-info">
                                <div class="card-body">
                                    <h6 class="card-title text-info">Next Hearing</h6>
                                    <h4 class="mb-2">{{ $case->hearing_date->format('M d, Y') }}</h4>
                                    @if ($case->hearing_time)
                                        <p class="mb-1"><i
                                                class="bi bi-clock me-2"></i>{{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}
                                        </p>
                                    @endif
                                    @if ($case->court_location)
                                        <p class="mb-0"><i class="bi bi-geo-alt me-2"></i>{{ $case->court_location }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
