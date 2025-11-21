@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6">Articles</h1>
                <p class="text-muted">Latest legal articles and guides.</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form method="GET" action="{{ route('articles.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search articles by title or content..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">{{ __('messages.search') }}</button>
                        @if (request('search'))
                            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($articles as $article)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($article->body, 120) }}</p>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-primary">Read</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-6">No articles found.</div>
            @endforelse
        </div>
    </div>
@endsection
