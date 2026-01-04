@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold mb-0">{{ __('messages.all_cases') ?? 'All Cases' }}</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
        @endif

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                    href="{{ route('admin.cases.index') }}">{{ __('messages.all_cases') ?? 'All' }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('admin.cases.index', ['status' => 'pending']) }}">{{ __('messages.pending') ?? 'Pending' }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'in_progress' ? 'active' : '' }}"
                    href="{{ route('admin.cases.index', ['status' => 'in_progress']) }}">{{ __('messages.in_progress') ?? 'In Progress' }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                    href="{{ route('admin.cases.index', ['status' => 'completed']) }}">{{ __('messages.completed') ?? 'Completed' }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'closed' ? 'active' : '' }}"
                    href="{{ route('admin.cases.index', ['status' => 'closed']) }}">{{ __('messages.closed') ?? 'Closed' }}</a>
            </li>
        </ul>

        @if ($cases->isEmpty())
            <div class="alert alert-info shadow-sm border-0">{{ __('messages.no_cases_found') ?? 'No cases found.' }}</div>
        @else
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4">{{ __('messages.case_title') ?? 'Case Title' }}</th>
                                    <th class="py-3">{{ __('messages.lawyer') ?? 'Lawyer' }}</th>
                                    <th class="py-3">{{ __('messages.client') ?? 'Client' }}</th>
                                    <th class="py-3">{{ __('messages.hearing_date') ?? 'Hearing Date' }}</th>
                                    <th class="py-3">{{ __('messages.status') ?? 'Status' }}</th>
                                    <th class="py-3 pe-4 text-end">{{ __('messages.actions') ?? 'Action' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cases as $case)
                                    <tr>
                                        <td class="ps-4">
                                            <strong>{{ $case->title }}</strong>
                                            @if ($case->case_number)
                                                <br><small class="text-muted">{{ $case->case_number }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($case->lawyer && $case->lawyer->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        {{ substr($case->lawyer->user->name, 0, 1) }}
                                                    </div>
                                                    {{ $case->lawyer->user->name }}
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
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
                                                <span
                                                    class="text-muted">{{ __('messages.not_scheduled') ?? 'Not scheduled' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($case->status === 'pending')
                                                <span
                                                    class="badge rounded-pill px-3 bg-warning-subtle text-warning">{{ __('messages.pending') ?? 'Pending' }}</span>
                                            @elseif($case->status === 'in_progress')
                                                <span
                                                    class="badge rounded-pill px-3 bg-primary-subtle text-primary">{{ __('messages.in_progress') ?? 'In Progress' }}</span>
                                            @elseif($case->status === 'completed')
                                                <span
                                                    class="badge rounded-pill px-3 bg-success-subtle text-success">{{ __('messages.completed') ?? 'Completed' }}</span>
                                            @else
                                                <span
                                                    class="badge rounded-pill px-3 bg-secondary-subtle text-secondary">{{ __('messages.closed') ?? 'Closed' }}</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('admin.cases.show', $case->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">{{ __('messages.view') ?? 'View' }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $cases->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
