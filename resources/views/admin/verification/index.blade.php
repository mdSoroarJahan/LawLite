@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3>Lawyer Verification Requests</h3>
        @if ($lawyers->isEmpty())
            <div class="alert alert-info">No verification requests.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Lawyer</th>
                            <th>Bar Council ID</th>
                            <th>Documents</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lawyers as $l)
                            <tr>
                                <td>
                                    <div><strong>{{ $l->user->name ?? '—' }}</strong></div>
                                    <div class="text-muted small">{{ $l->user->email ?? '—' }}</div>
                                    <div class="text-muted small">{{ $l->city ?? '—' }}</div>
                                </td>
                                <td>{{ $l->bar_council_id ?? '—' }}</td>
                                <td>
                                    @if (is_array($l->documents) && count($l->documents))
                                        @foreach ($l->documents as $doc)
                                            <div><a href="{{ \Illuminate\Support\Facades\Storage::url($doc) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary mb-1">View
                                                    {{ basename($doc) }}</a></div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No documents</span>
                                    @endif
                                </td>
                                <td>
                                    @if (is_array($l->education))
                                        <div class="mb-1"><strong>Edu:</strong> {{ count($l->education) }} entries</div>
                                    @endif
                                    @if (is_array($l->experience))
                                        <div class="mb-1"><strong>Exp:</strong> {{ count($l->experience) }} entries</div>
                                    @endif
                                    @if (is_array($l->languages))
                                        <div><strong>Lang:</strong> {{ implode(', ', $l->languages) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ ucfirst($l->verification_status) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.verification.show', $l->id) }}"
                                            class="btn btn-sm btn-primary">Review</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
