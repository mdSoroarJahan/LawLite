@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold mb-0">{{ __('messages.all_invoices') ?? 'All Invoices' }}</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
        @endif

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                    href="{{ route('admin.invoices.index') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'unpaid' ? 'active' : '' }}"
                    href="{{ route('admin.invoices.index', ['status' => 'unpaid']) }}">Unpaid</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'paid' ? 'active' : '' }}"
                    href="{{ route('admin.invoices.index', ['status' => 'paid']) }}">Paid</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}"
                    href="{{ route('admin.invoices.index', ['status' => 'cancelled']) }}">Cancelled</a>
            </li>
        </ul>

        @if ($invoices->isEmpty())
            <div class="alert alert-info shadow-sm border-0">No invoices found.</div>
        @else
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4">Invoice #</th>
                                    <th class="py-3">Lawyer</th>
                                    <th class="py-3">Client</th>
                                    <th class="py-3">Amount</th>
                                    <th class="py-3">Due Date</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="ps-4 fw-semibold">#{{ $invoice->invoice_number }}</td>
                                        <td>
                                            @if ($invoice->lawyer && $invoice->lawyer->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        {{ substr($invoice->lawyer->user->name, 0, 1) }}
                                                    </div>
                                                    {{ $invoice->lawyer->user->name }}
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($invoice->client)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        {{ substr($invoice->client->name, 0, 1) }}
                                                    </div>
                                                    {{ $invoice->client->name }}
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">${{ number_format($invoice->amount, 2) }}</td>
                                        <td class="text-muted">{{ $invoice->due_date->format('M d, Y') }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill px-3 bg-{{ $invoice->status === 'paid' ? 'success-subtle text-success' : ($invoice->status === 'cancelled' ? 'secondary-subtle text-secondary' : 'warning-subtle text-warning') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
