@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">{{ __('messages.my_cases') }}</h1>
            <a href="{{ route('lawyer.cases.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> {{ __('messages.add_new_case') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index') }}">{{ __('messages.all_cases') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'pending']) }}">{{ __('messages.pending') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'in_progress' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'in_progress']) }}">{{ __('messages.in_progress') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'completed']) }}">{{ __('messages.completed') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'closed' ? 'active' : '' }}"
                    href="{{ route('lawyer.cases.index', ['status' => 'closed']) }}">{{ __('messages.closed') }}</a>
            </li>
        </ul>

        @if ($cases->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <p class="text-muted">{{ __('messages.no_cases_found') }}</p>
                    <a href="{{ route('lawyer.cases.create') }}"
                        class="btn btn-primary mt-2">{{ __('messages.add_your_first_case') }}</a>
                </div>
            </div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('messages.case_title') }}</th>
                                <th>{{ __('messages.client') }}</th>
                                <th>{{ __('messages.hearing_date') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.actions') }}</th>
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
                                            <span class="text-muted">{{ __('messages.not_scheduled') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($case->status === 'pending')
                                            <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                        @elseif($case->status === 'in_progress')
                                            <span class="badge bg-primary">{{ __('messages.in_progress') }}</span>
                                        @elseif($case->status === 'completed')
                                            <span class="badge bg-success">{{ __('messages.completed') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('messages.closed') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('lawyer.cases.show', $case->id) }}"
                                                class="btn btn-outline-primary">{{ __('messages.view') }}</a>
                                            <a href="{{ route('lawyer.cases.edit', $case->id) }}"
                                                class="btn btn-outline-secondary">{{ __('messages.edit') }}</a>
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
