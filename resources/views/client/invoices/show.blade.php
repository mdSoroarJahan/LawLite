@extends('layouts.landing')

@section('content')
    <style>
        /* ===== INVOICE DETAIL THEME ===== */
        .invoice-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
        }

        .invoice-title {
            color: #10b981;
        }

        .invoice-table {
            background: #ffffff;
        }

        .invoice-table thead {
            background: #f8fafc;
        }

        .invoice-table thead th {
            color: #6b7280;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .invoice-table tbody td,
        .invoice-table tfoot th {
            color: #1f2937;
        }

        .btn-back {
            background: #f1f5f9;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .btn-back:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        .btn-print {
            border: 1px solid #10b981;
            color: #10b981;
            background: transparent;
        }

        .btn-print:hover {
            background: #10b981;
            color: white;
        }

        .badge-paid {
            background: rgba(16, 185, 129, 0.1) !important;
            color: #059669 !important;
        }

        .badge-unpaid {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #dc2626 !important;
        }

        .badge-cancelled {
            background: rgba(107, 114, 128, 0.1) !important;
            color: #6b7280 !important;
        }

        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .invoice-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        html[data-theme="dark"] .invoice-title {
            color: #34d399 !important;
        }

        html[data-theme="dark"] .invoice-card h5,
        html[data-theme="dark"] .invoice-card h6,
        html[data-theme="dark"] .invoice-card p:not(.text-muted) {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .invoice-card .text-muted {
            color: #94a3b8 !important;
        }

        html[data-theme="dark"] .invoice-card .fw-bold {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .invoice-table,
        html[data-theme="dark"] .invoice-table tbody,
        html[data-theme="dark"] .invoice-table tfoot,
        html[data-theme="dark"] .table-responsive {
            background: #1e293b !important;
        }

        html[data-theme="dark"] .invoice-table thead {
            background: #0f172a !important;
        }

        html[data-theme="dark"] .invoice-table thead th {
            color: #94a3b8 !important;
            background: #0f172a !important;
        }

        html[data-theme="dark"] .invoice-table tbody td {
            color: #f1f5f9 !important;
            background: #1e293b !important;
        }

        html[data-theme="dark"] .invoice-table tfoot {
            border-color: #334155 !important;
        }

        html[data-theme="dark"] .invoice-table tfoot th {
            color: #f1f5f9 !important;
            background: #1e293b !important;
        }

        html[data-theme="dark"] .invoice-table tfoot th.text-primary {
            color: #34d399 !important;
        }

        html[data-theme="dark"] .btn-back {
            background: #334155 !important;
            border-color: #475569 !important;
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .btn-back:hover {
            background: #475569 !important;
            color: #ffffff !important;
        }

        html[data-theme="dark"] .btn-print {
            border-color: #34d399 !important;
            color: #34d399 !important;
            background: transparent !important;
        }

        html[data-theme="dark"] .btn-print:hover {
            background: #10b981 !important;
            color: white !important;
            border-color: #10b981 !important;
        }

        html[data-theme="dark"] .badge-paid {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
        }

        html[data-theme="dark"] .badge-unpaid {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #f87171 !important;
        }

        html[data-theme="dark"] .badge-cancelled {
            background: rgba(107, 114, 128, 0.15) !important;
            color: #9ca3af !important;
        }

        html[data-theme="dark"] .alert-success {
            background: rgba(16, 185, 129, 0.15) !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
            color: #34d399 !important;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="invoice-card shadow-lg overflow-hidden">
                    <div class="card-body p-5">
                        @if (session('success'))
                            <div class="alert alert-success mb-4 rounded-3 shadow-sm border-0">{{ session('success') }}</div>
                        @endif

                        <div class="d-flex justify-content-between align-items-start mb-5">
                            <div>
                                <h2 class="mb-1 fw-bold invoice-title">INVOICE</h2>
                                <p class="text-muted mb-0">#{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-1 fw-bold">{{ $invoice->lawyer->user->name ?? 'Lawyer' }}</h5>
                                <p class="text-muted mb-0">{{ $invoice->lawyer->user->email ?? '' }}</p>
                                <p class="text-muted mb-0">{{ $invoice->lawyer->city ?? '' }}</p>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-6">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Bill To</h6>
                                <h5 class="mb-1 fw-bold">{{ Auth::user()->name }}</h5>
                                <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Status</h6>
                                @if ($invoice->status === 'paid')
                                    <span class="badge badge-paid rounded-pill px-3 py-2 fs-6">PAID</span>
                                @elseif($invoice->status === 'cancelled')
                                    <span class="badge badge-cancelled rounded-pill px-3 py-2 fs-6">CANCELLED</span>
                                @else
                                    <span class="badge badge-unpaid rounded-pill px-3 py-2 fs-6">UNPAID</span>
                                    <p class="text-muted small mb-0 mt-2">Due:
                                        {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive mb-5">
                            <table class="table table-borderless invoice-table">
                                <thead>
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
                            <a href="{{ route('client.invoices.index') }}" class="btn btn-back rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <div>
                                <button onclick="window.print()" class="btn btn-print rounded-pill px-4 me-2">
                                    <i class="bi bi-printer me-2"></i>Print
                                </button>
                                @if ($invoice->status === 'unpaid')
                                    <a href="{{ route('client.invoices.checkout', $invoice->id) }}"
                                        class="btn btn-primary rounded-pill px-4 shadow-sm" style="background: #10b981; border-color: #10b981;">
                                        <i class="bi bi-credit-card me-2"></i>Pay Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
