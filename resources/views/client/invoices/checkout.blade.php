@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white p-4 text-center">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-shield-lock me-2"></i>Secure Checkout</h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h6 class="text-uppercase text-muted small fw-bold">Total Amount</h6>
                            <h1 class="display-4 fw-bold text-primary mb-0">${{ number_format($invoice->amount, 2) }}</h1>
                            <p class="text-muted">Invoice #{{ $invoice->invoice_number }}</p>
                        </div>

                        <div class="d-flex justify-content-center mb-4">
                            <div class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-lock-fill text-success me-1"></i> 256-bit SSL Encrypted
                            </div>
                        </div>

                        <form action="{{ route('client.invoices.pay', $invoice->id) }}" method="POST" id="payment-form">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Cardholder Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="John Doe" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control form-control-lg border-start-0 ps-0" placeholder="0000 0000 0000 0000" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-4">
                                    <label class="form-label fw-semibold">Expiry Date</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="MM/YY" required>
                                </div>
                                <div class="col-6 mb-4">
                                    <label class="form-label fw-semibold">CVC</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="123" required>
                                </div>
                            </div>

                            <div class="alert alert-info small border-0 bg-info-subtle text-info-emphasis rounded-3 mb-4">
                                <i class="bi bi-info-circle-fill me-2"></i> This is a secure mock payment gateway. No real money will
                                be charged.
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    Pay ${{ number_format($invoice->amount, 2) }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('client.invoices.show', $invoice->id) }}" class="text-decoration-none text-muted fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Cancel Payment
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
