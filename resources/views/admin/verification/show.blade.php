@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Verification Request: {{ $lawyer->user->name }}</h3>
            <a href="{{ route('admin.verification.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @if ($lawyer->user->profile_photo_path)
                            <img src="{{ Storage::url($lawyer->user->profile_photo_path) }}" class="rounded-circle mb-3"
                                width="150" height="150" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 150px; height: 150px; font-size: 3rem;">
                                {{ substr($lawyer->user->name, 0, 1) }}
                            </div>
                        @endif
                        <h4>{{ $lawyer->user->name }}</h4>
                        <p class="text-muted">{{ $lawyer->user->email }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $lawyer->user->phone ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>City:</strong> {{ $lawyer->city ?? 'N/A' }}</p>
                        <div class="mt-3">
                            <span
                                class="badge bg-{{ $lawyer->verification_status === 'verified' ? 'success' : ($lawyer->verification_status === 'rejected' ? 'danger' : 'warning') }} fs-6">
                                {{ ucfirst($lawyer->verification_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Actions</div>
                    <div class="card-body d-grid gap-2">
                        <form method="POST" action="{{ route('admin.verification.approve', $lawyer->id) }}">
                            @csrf
                            <button class="btn btn-success w-100">Approve Verification</button>
                        </form>
                        <form method="POST" action="{{ route('admin.verification.request_info', $lawyer->id) }}">
                            @csrf
                            <button class="btn btn-warning w-100">Request More Info</button>
                        </form>
                        <form method="POST" action="{{ route('admin.verification.reject', $lawyer->id) }}"
                            onsubmit="return confirm('Are you sure you want to reject this application?');">
                            @csrf
                            <button class="btn btn-danger w-100">Reject Application</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Professional Details</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Bar Council ID</div>
                            <div class="col-md-8">{{ $lawyer->bar_council_id ?? 'Not Provided' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Expertise</div>
                            <div class="col-md-8">{{ $lawyer->expertise ?? 'Not Provided' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Bio</div>
                            <div class="col-md-8">{{ $lawyer->bio ?? 'No bio provided.' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Documents</div>
                    <div class="card-body">
                        @if (is_array($lawyer->documents) && count($lawyer->documents) > 0)
                            <div class="row">
                                @foreach ($lawyer->documents as $doc)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body d-flex align-items-center justify-content-between">
                                                <div class="text-truncate me-2" title="{{ basename($doc) }}">
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    {{ basename($doc) }}
                                                </div>
                                                <a href="{{ Storage::url($doc) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">View</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No documents uploaded.</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Education & Experience</div>
                    <div class="card-body">
                        <h6 class="fw-bold">Education</h6>
                        @if (is_array($lawyer->education) && count($lawyer->education) > 0)
                            <ul class="list-group list-group-flush mb-3">
                                @foreach ($lawyer->education as $edu)
                                    <li class="list-group-item">{{ $edu }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-3">No education details.</p>
                        @endif

                        <h6 class="fw-bold">Experience</h6>
                        @if (is_array($lawyer->experience) && count($lawyer->experience) > 0)
                            <ul class="list-group list-group-flush mb-3">
                                @foreach ($lawyer->experience as $exp)
                                    <li class="list-group-item">{{ $exp }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-3">No experience details.</p>
                        @endif

                        <h6 class="fw-bold">Languages</h6>
                        @if (is_array($lawyer->languages) && count($lawyer->languages) > 0)
                            <p>{{ implode(', ', $lawyer->languages) }}</p>
                        @else
                            <p class="text-muted">No languages listed.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
