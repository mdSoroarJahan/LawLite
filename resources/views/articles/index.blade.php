@extends('layouts.landing')

@section('content')
    <style>
        /* ===== LAWLITE ARTICLES THEME ===== */
        
        /* Hero Section */
        .articles-hero {
            background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 50%, #f0fdf4 100%);
            border: 1px solid rgba(16, 185, 129, 0.1);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .articles-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-title {
            color: #0f172a;
            font-weight: 700;
        }

        /* Search */
        .glass-search {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .search-input {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.25s ease;
            background: #ffffff;
            color: #1f2937;
        }

        .search-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .search-btn {
            background: #10b981;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.25s ease;
        }

        .search-btn:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        /* Article Cards */
        .article-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            position: relative;
        }

        .article-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981 0%, #06b6d4 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .article-card:hover::before {
            opacity: 1;
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .article-card .card-body {
            padding: 1.5rem;
        }

        .article-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            color: #1f2937;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-excerpt {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        .read-btn {
            background: #10b981;
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
            text-shadow: none !important;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .read-btn:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
        }

        .read-btn i {
            transition: transform 0.25s ease;
        }

        .read-btn:hover i {
            transform: translateX(3px);
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .articles-hero {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(6, 182, 212, 0.05) 50%, rgba(16, 185, 129, 0.03) 100%);
            border-color: rgba(16, 185, 129, 0.15);
        }

        html[data-theme="dark"] .hero-title {
            color: #f1f5f9;
        }

        html[data-theme="dark"] .glass-search {
            background: #1e293b;
            border-color: #334155;
        }

        html[data-theme="dark"] .search-input {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }

        html[data-theme="dark"] .search-input::placeholder {
            color: #64748b;
        }

        html[data-theme="dark"] .article-card {
            background: #1e293b;
            border-color: #334155;
        }

        html[data-theme="dark"] .article-card:hover {
            border-color: rgba(16, 185, 129, 0.3);
        }

        html[data-theme="dark"] .article-title {
            color: #f1f5f9;
        }

        html[data-theme="dark"] .article-excerpt {
            color: #94a3b8;
        }

        html[data-theme="dark"] .empty-state {
            background: #1e293b;
            border-color: #334155;
        }

        html[data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }
    </style>

    <div class="container py-5">
        <!-- Hero Section -->
        <div class="articles-hero reveal text-center">
            <h1 class="display-5 fw-bold hero-title mb-3">{{ __('messages.articles') }}</h1>
            <p class="text-muted lead mb-0">{{ __('messages.articles_subtitle') }}</p>
        </div>

        <!-- Glass Search Bar -->
        <div class="row mb-5 reveal">
            <div class="col-lg-8 mx-auto">
                <div class="glass-search">
                    <form method="GET" action="{{ route('articles.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-input"
                                placeholder="{{ __('messages.search_articles') }}" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary search-btn ms-2">
                                <i class="bi bi-search me-2"></i>{{ __('messages.search') }}
                            </button>
                            @if (request('search'))
                                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary ms-2" style="border-radius: 12px;">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($articles as $article)
                <div class="col-lg-6 mb-4 reveal" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <div class="card article-card border-0 position-relative">
                        <div class="card-body">
                            <h5 class="article-title">{{ $article->title }}</h5>
                            <p class="article-excerpt">{{ \Illuminate\Support\Str::limit($article->content, 140) }}</p>
                            <a href="{{ route('articles.show', $article->id) }}" class="read-btn text-decoration-none">
                                {{ __('messages.read') }} <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 reveal">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-journal-x" style="font-size: 2.5rem; color: #10b981;"></i>
                        </div>
                        <h4 class="fw-bold mb-2">{{ __('messages.no_articles') }}</h4>
                        <p class="text-muted">Check back later for new content</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
