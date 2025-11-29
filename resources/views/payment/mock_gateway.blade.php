@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-center">
                            @if ($appointment->payment_method == 'bkash')
                                <span class="text-danger fw-bold">bKash</span> Payment Gateway
                            @else
                                <span class="text-primary fw-bold">Secure</span> Card Payment
                            @endif
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="display-6 fw-bold mb-2">{{ number_format($appointment->amount, 2) }} BDT</div>
                            <div class="text-muted">Consultation with {{ $appointment->lawyer->user->name }}</div>
                            <div class="small text-muted">{{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                                at {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                        </div>

                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-1"></i> This is a secure payment simulation. No real money will
                            be deducted.
                        </div>

                        <form action="{{ route('payment.process', $appointment->id) }}" method="POST" id="payment-form">
                            @csrf

                            @if ($appointment->payment_method == 'bkash')
                                <div class="mb-3">
                                    <label class="form-label">Your bKash Number</label>
                                    <input type="text" class="form-control" placeholder="01XXXXXXXXX" required
                                        pattern="01[0-9]{9}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">PIN</label>
                                    <input type="password" class="form-control" placeholder="*****" required>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Expiry</label>
                                        <input type="text" class="form-control" placeholder="MM/YY" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">CVC</label>
                                        <input type="text" class="form-control" placeholder="123" required>
                                    </div>
                                </div>
                            @endif

                            <div class="d-grid mt-4">
                                <button type="submit"
                                    class="btn btn-lg {{ $appointment->payment_method == 'bkash' ? 'btn-danger' : 'btn-primary' }}">
                                    Confirm Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
