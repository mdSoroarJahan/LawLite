@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6">Find Lawyers</h1>
                <p class="text-muted">Browse verified lawyers and view profiles. Use search to narrow results.</p>
            </div>
        </div>

        <div class="row">
            @forelse($lawyers as $lawyer)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $lawyer->name ?? 'Unnamed Lawyer' }}</h5>
                            <p class="card-text text-muted">{{ $lawyer->specialty ?? 'General Practice' }}</p>
                            <p class="mb-1"><small class="text-muted">Location: {{ $lawyer->city ?? 'Unknown' }}</small>
                            </p>
                            <a href="{{ route('lawyers.show', $lawyer->id) }}"
                                class="btn btn-sm btn-outline-primary mt-2">View profile</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-6">
                    <p class="lead text-muted">No lawyers found yet. Try seeding sample data: <code>php artisan
                            db:seed</code></p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
