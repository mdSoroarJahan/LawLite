@extends('layouts.landing')

@section('content')
    <div class="container py-4">
        <h1 class="h3 mb-4">My Cases</h1>

        @if ($cases->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">You are not linked to any active cases.</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($cases as $case)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">
                                        <a href="{{ route('user.cases.show', $case->id) }}" class="text-decoration-none">
                                            {{ $case->title }}
                                        </a>
                                    </h5>
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
                                <p class="text-muted small mb-2">
                                    Lawyer: {{ $case->lawyer->user->name ?? 'Unknown' }}
                                </p>
                                <p class="card-text text-truncate">{{ $case->description }}</p>

                                @if ($case->hearing_date)
                                    <div class="alert alert-light border py-2 px-3 mb-0">
                                        <small class="text-muted d-block">Next Hearing</small>
                                        <strong>{{ $case->hearing_date->format('M d, Y') }}</strong>
                                        @if ($case->hearing_time)
                                            <span class="text-muted ms-1">at
                                                {{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <a href="{{ route('user.cases.show', $case->id) }}"
                                    class="btn btn-outline-primary btn-sm w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
