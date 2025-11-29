@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-3">{{ $article->title }}</h1>
                <div class="text-muted mb-4">Published: {{ $article->created_at->format('M d, Y') }}</div>
                <div class="content">{!! nl2br(e($article->content)) !!}</div>
            </div>
        </div>
    </div>
@endsection
