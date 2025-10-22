@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>{{ $lawyer->name ?? 'Lawyer' }}</h1>
                <p class="text-muted">{{ $lawyer->specialty ?? 'General practice' }}</p>
                <p>Location: {{ $lawyer->city ?? 'Unknown' }}</p>
                <a href="#" class="btn btn-primary">Message</a>
                <a href="#" class="btn btn-outline-secondary">Book appointment</a>
            </div>
        </div>
    </div>
@endsection
