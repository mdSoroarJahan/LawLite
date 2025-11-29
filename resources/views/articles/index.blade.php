@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6">{{ __('messages.articles') }}</h1>
                <p class="text-muted">{{ __('messages.articles_subtitle') }}</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form method="GET" action="{{ route('articles.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ __('messages.search_articles') }}" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">{{ __('messages.search') }}</button>
                        @if (request('search'))
                            <a href="{{ route('articles.index') }}" class="btn btn-secondary">{{ __('messages.clear') }}</a>
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
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($article->content, 120) }}</p>
                            <a href="{{ route('articles.show', $article->id) }}"
                                class="btn btn-sm btn-primary">{{ __('messages.read') }}</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-6">{{ __('messages.no_articles') }}</div>
            @endforelse
        </div>
    </div>
@endsection
