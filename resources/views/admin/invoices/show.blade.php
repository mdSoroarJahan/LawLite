@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                class="text-decoration-none text-muted">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}"
                                class="text-decoration-none text-muted">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice #{{ $invoice->invoice_number }}</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">Invoice #{{ $invoice->invoice_number }}</h1>
            </div>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Invoices
            </a>
        </div>

        <div class="row g-4">
            <!-- Main Invoice Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Invoice
                                Details</h5>
                            <span
                                class="badge rounded-pill px-3 py-2 bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'cancelled' ? 'secondary' : 'warning text-dark') }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Invoice Number</label>
                                <div class="fs-5 fw-semibold text-dark">#{{ $invoice->invoice_number }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Amount</label>
                                <div class="fs-4 fw-bold text-success">${{ number_format($invoice->amount, 2) }}</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Due Date</label>
                                <div class="fs-5 fw-semibold text-dark">{{ $invoice->due_date->format('M d, Y') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Created</label>
                                <div class="fs-6 fw-semibold text-dark">{{ $invoice->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                        </div>

                        @if ($invoice->description)
                            <div class="mb-0">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Description</label>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{{ $invoice->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Side Info -->
            <div class="col-lg-4">
                <!-- Lawyer Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title fw-bold mb-0"><i class="bi bi-person-badge me-2 text-success"></i>Lawyer</h6>
                    </div>
                    <div class="card-body">
                        @if ($invoice->lawyer && $invoice->lawyer->user)
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center me-3"
                                    style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ substr($invoice->lawyer->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $invoice->lawyer->user->name }}</div>
                                    <small class="text-muted">{{ $invoice->lawyer->user->email }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">No lawyer assigned</p>
                        @endif
                    </div>
                </div>

                <!-- Client Info -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title fw-bold mb-0"><i class="bi bi-person me-2 text-primary"></i>Client</h6>
                    </div>
                    <div class="card-body">
                        @if ($invoice->client)
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                    style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ substr($invoice->client->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $invoice->client->name }}</div>
                                    <small class="text-muted">{{ $invoice->client->email }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">No client linked</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
