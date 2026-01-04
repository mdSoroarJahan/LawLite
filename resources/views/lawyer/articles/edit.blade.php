@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Edit Article</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lawyer.articles.update', $article->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $article->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <select class="form-select @error('language') is-invalid @enderror" id="language"
                                    name="language" required>
                                    <option value="en"
                                        {{ old('language', $article->language) == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="bn"
                                        {{ old('language', $article->language) == 'bn' ? 'selected' : '' }}>Bengali</option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                    required>{{ old('content', $article->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('lawyer.articles.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Article</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
