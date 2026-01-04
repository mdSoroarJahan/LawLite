@extends('layouts.landing')

@section('content')
    <style>
        html[data-theme="dark"] .invoice-card {
            background-color: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .card {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .table-responsive {
            background-color: transparent !important;
        }
        html[data-theme="dark"] .invoice-table {
            --bs-table-bg: transparent !important;
            --bs-table-color: #e2e8f0 !important;
            color: #e2e8f0 !important;
            background-color: transparent !important;
        }
        /* Nuke any nested background that might leak white */
        html[data-theme="dark"] .invoice-table,
        html[data-theme="dark"] .invoice-table * {
            background-color: transparent !important;
        }
        /* Reinforce on specific elements to beat any specificity */
        html[data-theme="dark"] table.invoice-table,
        html[data-theme="dark"] table.invoice-table thead,
        html[data-theme="dark"] table.invoice-table tbody,
        html[data-theme="dark"] table.invoice-table tfoot,
        html[data-theme="dark"] table.invoice-table tr,
        html[data-theme="dark"] table.invoice-table th,
        html[data-theme="dark"] table.invoice-table td {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .invoice-table th,
        html[data-theme="dark"] .invoice-table td {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        html[data-theme="dark"] .invoice-table thead,
        html[data-theme="dark"] .invoice-table tbody,
        html[data-theme="dark"] .invoice-table tr {
            background-color: #1e293b !important;
        }
        html[data-theme="dark"] .invoice-header {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .invoice-table .bg-light {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .invoice-table tfoot {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }
        html[data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }
        html[data-theme="dark"] .text-primary {
            color: #818cf8 !important;
        }
        html[data-theme="dark"] .btn-light {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .btn-light:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        .invoice-logo-circle {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);
        }
        .invoice-logo-circle i {
            font-size: 1.1rem;
            line-height: 1;
        }
        @media print {
            body {
                background: #ffffff !important;
            }
            .invoice-card {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
            .invoice-brand {
                display: flex !important;
            }
            .invoice-logo-circle {
                box-shadow: none !important;
            }
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card invoice-card shadow-lg border-0 overflow-hidden rounded-4">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4 invoice-brand d-print-flex">
                            <div class="d-flex align-items-center gap-2">
                                <span class="invoice-logo-circle">
                                    <i class="bi bi-balance-scale"></i>
                                </span>
                                <span class="fw-bold" style="font-size:1.1rem;">{{ config('app.name', 'LawLite') }}</span>
                            </div>
                            <div class="text-end small text-muted d-none d-print-block">
                                {{ config('app.url') ?? 'lowlite.local' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-start mb-5">
                            <div>
                                <h2 class="mb-1 fw-bold text-primary">INVOICE</h2>
                                <p class="text-muted mb-0">#{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-1 fw-bold">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-6">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Bill To</h6>
                                <h5 class="mb-1 fw-bold">{{ $invoice->client->name }}</h5>
                                <p class="mb-0 text-muted">{{ $invoice->client->email }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Status</h6>
                                @if ($invoice->status === 'paid')
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fs-6">PAID</span>
                                @elseif($invoice->status === 'cancelled')
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 fs-6">CANCELLED</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fs-6">UNPAID</span>
                                    <p class="text-muted small mb-0 mt-2">Due: {{ $invoice->due_date->format('M d, Y') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive mb-5">
                            <table class="table invoice-table table-borderless">
                                <thead class="invoice-header">
                                    <tr>
                                        <th class="py-3 ps-4 rounded-start">Description</th>
                                        <th class="text-end py-3 pe-4 rounded-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3">{{ $invoice->description }}</td>
                                        <td class="text-end pe-4 py-3 fw-bold">${{ number_format($invoice->amount, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <th class="ps-4 py-3 h5">Total</th>
                                        <th class="text-end pe-4 py-3 h5 text-primary">${{ number_format($invoice->amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-print-none mt-4 d-flex justify-content-between align-items-center">
                            <a href="{{ route('lawyer.invoices.index') }}" class="btn btn-light rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <div>
                                <button onclick="window.print()" class="btn btn-outline-primary rounded-pill px-4 me-2">
                                    <i class="bi bi-printer me-2"></i>Print
                                </button>
                                @if ($invoice->status === 'unpaid')
                                    <form action="{{ route('lawyer.invoices.pay', $invoice->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Mark this invoice as paid?');">
                                        @csrf
                                        <button class="btn btn-success rounded-pill px-4 shadow-sm">
                                            <i class="bi bi-check-lg me-2"></i>Mark as Paid
                                        </button>
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
