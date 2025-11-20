@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3>Lawyer Verification Requests</h3>
        @if ($lawyers->isEmpty())
            <div class="alert alert-info">No verification requests.</div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Lawyer</th>
                        <th>Email</th>
                        <th>Documents</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lawyers as $l)
                        <tr>
                            <td>{{ $l->user->name ?? '—' }}</td>
                            <td>{{ $l->user->email ?? '—' }}</td>
                            <td>
                                @if (is_array($l->documents) && count($l->documents))
                                    @foreach ($l->documents as $doc)
                                        <div><a href="{{ \Illuminate\Support\Facades\Storage::url($doc) }}"
                                                target="_blank">{{ basename($doc) }}</a></div>
                                    @endforeach
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $l->city ?? '—' }}</td>
                            <td>{{ $l->verification_status }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.verification.approve', $l->id) }}"
                                    style="display:inline">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
                                <form method="POST" action="{{ route('admin.verification.reject', $l->id) }}"
                                    style="display:inline">@csrf<button class="btn btn-sm btn-danger">Reject</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
