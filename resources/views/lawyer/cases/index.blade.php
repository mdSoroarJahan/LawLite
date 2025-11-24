@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">My Cases</h1>
            <a href="{{ route('lawyer.cases.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Case
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index') }}">All Cases</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'in_progress' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'in_progress']) }}">In Progress</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'completed']) }}">Completed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'closed' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'closed']) }}">Closed</a>
            </li>
        </ul>

        @if ($cases->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">No cases found</p>
                    <a href="{{ route('lawyer.cases.create') }}" class="btn btn-primary mt-2">Add Your First Case</a>
                </div>
            </div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Case Title</th>
                                <th>Client</th>
                                <th>Hearing Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cases as $case)
                                <tr>
                                    <td>
                                        <strong>{{ $case->title }}</strong>
                                        @if ($case->case_number)
                                            <br><small class="text-muted">{{ $case->case_number }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $case->client_name }}
                                        @if ($case->client_phone)
                                            <br><small class="text-muted">{{ $case->client_phone }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($case->hearing_date)
                                            {{ $case->hearing_date->format('M d, Y') }}
                                            @if ($case->hearing_time)
                                                <br><small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Not scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($case->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($case->status === 'in_progress')
                                            <span class="badge bg-primary">In Progress</span>
                                        @elseif($case->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('lawyer.cases.show', $case->id) }}"
                                                class="btn btn-outline-primary">View</a>
                                            <a href="{{ route('lawyer.cases.edit', $case->id) }}"
                                                class="btn btn-outline-secondary">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $cases->links() }}
            </div>
        @endif
    </div>
@endsection
