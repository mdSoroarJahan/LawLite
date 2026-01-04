@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Articles</h1>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create Article
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Title</th>
                            <th>Author</th>
                            <th>Language</th>
                            <th>Published</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $article)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $article->title }}</td>
                                <td>{{ $article->author->name ?? 'Unknown' }}</td>
                                <td>
                                    @if ($article->language === 'en')
                                        <span class="badge bg-primary">English</span>
                                    @else
                                        <span class="badge bg-success">Bengali</span>
                                    @endif
                                </td>
                                <td>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('M d, Y') : 'Draft' }}
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="btn btn-sm btn-outline-secondary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-journal-x display-6 mb-3 d-block"></i>
                                    No articles found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($articles->hasPages())
                <div class="card-footer bg-white">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
