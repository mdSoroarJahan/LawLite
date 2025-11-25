@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Create New Invoice</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lawyer.invoices.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Client Email</label>
                                <input type="email" name="client_email" class="form-control" required
                                    placeholder="client@example.com">
                                <div class="form-text">Enter the email address of the registered user.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" required
                                    placeholder="Consultation fee, Case filing fee, etc."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Amount ($)</label>
                                    <input type="number" name="amount" class="form-control" step="0.01" min="0"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('lawyer.invoices.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Invoice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
