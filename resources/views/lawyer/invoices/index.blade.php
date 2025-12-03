@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">{{ __('messages.invoices') }}</h1>
            <a href="{{ route('lawyer.invoices.create') }}"
                class="btn btn-primary">{{ __('messages.create_invoice') ?? 'Create Invoice' }}</a>
        </div>

        @if ($invoices->isEmpty())
            <div class="alert alert-info">No invoices found.</div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Client</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->client->name }}</td>
                                        <td>${{ number_format($invoice->amount, 2) }}</td>
                                        <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'cancelled' ? 'secondary' : 'warning') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('lawyer.invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
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
