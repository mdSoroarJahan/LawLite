@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Add New Case</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lawyer.cases.store') }}" method="POST">
                            @csrf

                            <h5 class="mb-3">Case Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="title" class="form-label">Case Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="case_number" class="form-label">Case Number</label>
                                    <input type="text" class="form-control @error('case_number') is-invalid @enderror"
                                        id="case_number" name="case_number" value="{{ old('case_number') }}">
                                    @error('case_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Case Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">Client Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="client_name" class="form-label">Client Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                        id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="client_email" class="form-label">Client Email</label>
                                    <input type="email" class="form-control @error('client_email') is-invalid @enderror"
                                        id="client_email" name="client_email" value="{{ old('client_email') }}">
                                    @error('client_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="client_phone" class="form-label">Client Phone</label>
                                <input type="text" class="form-control @error('client_phone') is-invalid @enderror"
                                    id="client_phone" name="client_phone" value="{{ old('client_phone') }}">
                                @error('client_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">Hearing Details</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="hearing_date" class="form-label">Hearing Date</label>
                                    <input type="date" class="form-control @error('hearing_date') is-invalid @enderror"
                                        id="hearing_date" name="hearing_date" value="{{ old('hearing_date') }}">
                                    @error('hearing_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="hearing_time" class="form-label">Hearing Time</label>
                                    <input type="time" class="form-control @error('hearing_time') is-invalid @enderror"
                                        id="hearing_time" name="hearing_time" value="{{ old('hearing_time') }}">
                                    @error('hearing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="court_location" class="form-label">Court Location</label>
                                <input type="text" class="form-control @error('court_location') is-invalid @enderror"
                                    id="court_location" name="court_location" value="{{ old('court_location') }}">
                                @error('court_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('lawyer.cases.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Case</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
