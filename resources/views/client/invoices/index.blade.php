@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">{{ __('messages.my_invoices') }}</h2>

        @if ($invoices->isEmpty())
            <div class="alert alert-info">{{ __('messages.no_invoices') ?? 'You have no invoices.' }}</div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Lawyer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->lawyer->user->name ?? 'Unknown' }}</td>
                                        <td>${{ number_format($invoice->amount, 2) }}</td>
                                        <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if ($invoice->status === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($invoice->status === 'cancelled')
                                                <span class="badge bg-secondary">Cancelled</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
