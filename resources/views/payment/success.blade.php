@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm text-center">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="mb-3">Payment Successful!</h2>
                        <p class="text-muted mb-4">
                            Thank you for your payment. Your transaction has been completed successfully.
                        </p>

                        <div class="d-grid gap-2 col-8 mx-auto">
                            <a href="{{ route('appointments.index') }}" class="btn btn-primary">
                                View My Appointments
                            </a>
                            <a href="{{ route('client.invoices.index') }}" class="btn btn-outline-secondary">
                                View Invoices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
