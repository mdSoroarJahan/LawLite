@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-start mb-5">
                            <div>
                                <h2 class="mb-1">INVOICE</h2>
                                <p class="text-muted mb-0">#{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-6">
                                <h6 class="text-uppercase text-muted small">Bill To</h6>
                                <h5 class="mb-1">{{ $invoice->client->name }}</h5>
                                <p class="mb-0">{{ $invoice->client->email }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-uppercase text-muted small">Status</h6>
                                @if ($invoice->status === 'paid')
                                    <h4 class="text-success">PAID</h4>
                                @elseif($invoice->status === 'cancelled')
                                    <h4 class="text-secondary">CANCELLED</h4>
                                @else
                                    <h4 class="text-danger">UNPAID</h4>
                                    <p class="text-muted small mb-0">Due: {{ $invoice->due_date->format('M d, Y') }}</p>
                                @endif
                            </div>
                        </div>

                        <table class="table mb-5">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->description }}</td>
                                    <td class="text-end">${{ number_format($invoice->amount, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">${{ number_format($invoice->amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="d-print-none mt-4 d-flex justify-content-between">
                            <a href="{{ route('lawyer.invoices.index') }}" class="btn btn-secondary">Back</a>
                            <div>
                                <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                                @if ($invoice->status === 'unpaid')
                                    <form action="{{ route('lawyer.invoices.pay', $invoice->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Mark this invoice as paid?');">
                                        @csrf
                                        <button class="btn btn-success">Mark as Paid</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
