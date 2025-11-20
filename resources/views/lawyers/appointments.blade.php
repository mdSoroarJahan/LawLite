@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3>Your Appointments</h3>
        @if (empty($appointments) || count($appointments) === 0)
            <div class="alert alert-info">No appointments yet.</div>
        @else
            <div class="list-group">
                @foreach ($appointments as $a)
                    <div class="list-group-item">
                        <strong>{{ $a->client_name ?? 'Client' }}</strong>
                        <div class="small text-muted">{{ $a->scheduled_at ?? 'Time not set' }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
