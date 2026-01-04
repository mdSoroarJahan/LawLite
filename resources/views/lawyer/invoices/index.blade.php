@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold mb-0">{{ __('messages.invoices') }}</h1>
            <a href="{{ route('lawyer.invoices.create') }}"
                class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>{{ __('messages.create_invoice') ?? 'Create Invoice' }}
            </a>
        </div>

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
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    {{ substr($invoice->client->name ?? 'C', 0, 1) }}
                                                </div>
                                                {{ $invoice->client->name }}
                                            </div>
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
                                            <a href="{{ route('lawyer.invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $invoices->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
