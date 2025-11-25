@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Secure Checkout</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5 class="text-muted">Total Amount</h5>
                            <h2 class="text-primary">${{ number_format($invoice->amount, 2) }}</h2>
                            <p class="text-muted">Invoice #{{ $invoice->invoice_number }}</p>
                        </div>

                        <hr>

                        <form action="{{ route('client.invoices.pay', $invoice->id) }}" method="POST" id="payment-form">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Cardholder Name</label>
                                <input type="text" class="form-control" placeholder="John Doe" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CVC</label>
                                    <input type="text" class="form-control" placeholder="123" required>
                                </div>
                            </div>

                            <div class="alert alert-info small">
                                <i class="bi bi-info-circle"></i> This is a secure mock payment gateway. No real money will
                                be charged.
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Pay ${{ number_format($invoice->amount, 2) }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('client.invoices.show', $invoice->id) }}" class="text-muted">Cancel Payment</a>
                </div>
            </div>
        </div>
    </div>
@endsection
