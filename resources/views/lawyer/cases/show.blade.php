@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">{{ $case->title }}</h1>
                    <div class="btn-group">
                        <a href="{{ route('lawyer.cases.edit', $case->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('lawyer.cases.destroy', $case->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this case?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Case Details</h5>
                            </div>
                            <div class="card-body">
                                @if ($case->case_number)
                                    <div class="mb-3">
                                        <strong>Case Number:</strong>
                                        <span class="ms-2">{{ $case->case_number }}</span>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <strong>Status:</strong>
                                    <span class="ms-2">
                                        @if ($case->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($case->status === 'in_progress')
                                            <span class="badge bg-primary">In Progress</span>
                                        @elseif($case->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </span>
                                </div>

                                @if ($case->description)
                                    <div class="mb-3">
                                        <strong>Description:</strong>
                                        <p class="mt-2 text-muted">{{ $case->description }}</p>
                                    </div>
                                @endif

                                @if ($case->notes)
                                    <div class="mb-3">
                                        <strong>Notes:</strong>
                                        <p class="mt-2 text-muted">{{ $case->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Client Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>Name:</strong> {{ $case->client_name }}
                                </div>
                                @if ($case->client_email)
                                    <div class="mb-2">
                                        <strong>Email:</strong> <a
                                            href="mailto:{{ $case->client_email }}">{{ $case->client_email }}</a>
                                    </div>
                                @endif
                                @if ($case->client_phone)
                                    <div class="mb-2">
                                        <strong>Phone:</strong> <a
                                            href="tel:{{ $case->client_phone }}">{{ $case->client_phone }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Hearing Information</h5>
                            </div>
                            <div class="card-body">
                                @if ($case->hearing_date)
                                    <div class="mb-3">
                                        <strong>Date:</strong>
                                        <div class="mt-1">{{ $case->hearing_date->format('l, F d, Y') }}</div>
                                    </div>
                                @endif

                                @if ($case->hearing_time)
                                    <div class="mb-3">
                                        <strong>Time:</strong>
                                        <div class="mt-1">
                                            {{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}
                                        </div>
                                    </div>
                                @endif

                                @if ($case->court_location)
                                    <div class="mb-3">
                                        <strong>Location:</strong>
                                        <div class="mt-1">{{ $case->court_location }}</div>
                                    </div>
                                @endif

                                @if (!$case->hearing_date && !$case->hearing_time && !$case->court_location)
                                    <p class="text-muted">No hearing scheduled yet</p>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="small text-muted">
                                    <div>Created: {{ $case->created_at->format('M d, Y h:i A') }}</div>
                                    <div>Updated: {{ $case->updated_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('lawyer.cases.index') }}" class="btn btn-secondary">Back to Cases</a>
                </div>
            </div>
        </div>
    </div>
@endsection
