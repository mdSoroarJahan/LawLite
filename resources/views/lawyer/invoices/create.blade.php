@extends('layouts.landing')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0 fw-bold text-primary">Create New Invoice</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('lawyer.invoices.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Client Email</label>
                                <input type="email" name="client_email" class="form-control form-control-lg" required
                                    placeholder="client@example.com">
                                <div class="form-text">Enter the email address of the registered user.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control form-control-lg" rows="3" required
                                    placeholder="Consultation fee, Case filing fee, etc."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Amount ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">$</span>
                                        <input type="number" name="amount" class="form-control form-control-lg border-start-0 ps-0" step="0.01" min="0"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Due Date</label>
                                    <input type="date" name="due_date" class="form-control form-control-lg" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-2">
                                <a href="{{ route('lawyer.invoices.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                                    <i class="bi bi-plus-lg me-2"></i>Create Invoice
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
