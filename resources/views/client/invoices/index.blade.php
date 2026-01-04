@extends('layouts.landing')

@section('content')
    <style>
        /* ===== LAWLITE INVOICES THEME ===== */
        .page-title {
            color: #0f172a;
            font-weight: 700;
        }

        .invoices-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
        }

        .invoices-table {
            margin-bottom: 0;
        }

        .invoices-table thead {
            background: #f8fafc;
        }

        .invoices-table thead th {
            color: #10b981;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem;
        }

        .invoices-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s ease;
        }

        .invoices-table tbody tr:hover {
            background: #f8fafc;
        }

        .invoices-table tbody tr:last-child {
            border-bottom: none;
        }

        .invoices-table tbody td {
            padding: 1rem;
            color: #1f2937;
            vertical-align: middle;
        }

        .invoice-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-weight: 600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .badge-paid {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-unpaid {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-cancelled {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .view-btn {
            border: 1px solid #10b981;
            color: #10b981;
            background: transparent;
            border-radius: 8px;
            padding: 0.4rem 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.25s ease;
        }

        .view-btn:hover {
            background: #10b981;
            color: white;
        }

        .empty-alert {
            background: #f0fdfa;
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #0f766e;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }

        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .page-title {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .invoices-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        html[data-theme="dark"] .invoices-table {
            background: #1e293b !important;
        }

        html[data-theme="dark"] .invoices-table thead {
            background: #0f172a !important;
        }

        html[data-theme="dark"] .invoices-table thead th {
            color: #34d399 !important;
            border-bottom-color: #334155 !important;
            background: #0f172a !important;
        }

        html[data-theme="dark"] .invoices-table tbody {
            background: #1e293b !important;
        }

        html[data-theme="dark"] .invoices-table tbody tr {
            border-bottom-color: #334155 !important;
            background: #1e293b !important;
        }

        html[data-theme="dark"] .invoices-table tbody tr:hover {
            background: rgba(16, 185, 129, 0.08) !important;
        }

        html[data-theme="dark"] .invoices-table tbody td {
            color: #f1f5f9 !important;
            background: transparent !important;
        }

        html[data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        html[data-theme="dark"] .fw-semibold,
        html[data-theme="dark"] .fw-bold {
            color: #f1f5f9 !important;
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

        html[data-theme="dark"] .view-btn {
            border-color: #34d399 !important;
            color: #34d399 !important;
            background: transparent !important;
        }

        html[data-theme="dark"] .view-btn:hover {
            background: #10b981 !important;
            color: white !important;
            border-color: #10b981 !important;
        }

        html[data-theme="dark"] .empty-alert {
            background: rgba(16, 185, 129, 0.1) !important;
            border-color: rgba(16, 185, 129, 0.2) !important;
            color: #34d399 !important;
        }

        html[data-theme="dark"] .table-responsive {
            background: #1e293b !important;
        }
    </style>

    <div class="container py-5">
        <h2 class="mb-4 page-title">{{ __('messages.my_invoices') }}</h2>

        @if ($invoices->isEmpty())
            <div class="empty-alert">
                <i class="bi bi-info-circle me-2"></i>{{ __('messages.no_invoices') ?? 'You have no invoices.' }}
            </div>
        @else
            <div class="invoices-card">
                <div class="table-responsive">
                    <table class="table invoices-table">
                        <thead>
                            <tr>
                                <th class="ps-4">Invoice #</th>
                                <th>Lawyer</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="ps-4 fw-semibold">#{{ $invoice->invoice_number }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="invoice-avatar">
                                                {{ substr($invoice->lawyer->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span>{{ $invoice->lawyer->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold">${{ number_format($invoice->amount, 2) }}</td>
                                    <td class="text-muted">{{ $invoice->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if ($invoice->status === 'paid')
                                            <span class="badge-paid">Paid</span>
                                        @elseif($invoice->status === 'cancelled')
                                            <span class="badge-cancelled">Cancelled</span>
                                        @else
                                            <span class="badge-unpaid">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('client.invoices.show', $invoice->id) }}" class="view-btn text-decoration-none">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
