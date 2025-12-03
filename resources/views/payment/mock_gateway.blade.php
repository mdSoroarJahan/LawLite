@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Confirm Payment</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://securepay.sslcommerz.com/public/image/sslcommerz.png" alt="SSLCommerz"
                                style="height: 50px;">
                            <p class="text-muted mt-2">Secure Payment Gateway</p>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Service:</span>
                            <span class="fw-bold">Legal Consultation</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Lawyer:</span>
                            <span class="fw-bold">{{ $appointment->lawyer->user->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Date & Time:</span>
                            <span>{{ $appointment->date }} at {{ $appointment->time }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total Amount:</span>
                            <span class="h5 text-primary">৳
                                {{ number_format($appointment->lawyer->hourly_rate ?? 500, 2) }}</span>
                        </div>

                        <form action="{{ route('payment.process', $appointment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Pay Now with SSLCommerz
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">You will be redirected to SSLCommerz sandbox for testing.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
