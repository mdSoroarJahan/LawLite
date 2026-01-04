@extends('layouts.app')

@section('content')
    <style>
        /* ===== MODERN ARTICLE THEME ===== */
        .article-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .article-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .article-title {
            color: #0f172a;
            font-weight: 700;
            font-size: 2rem;
            line-height: 1.3;
            margin-bottom: 0;
        }
        .article-date {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .article-content {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            line-height: 1.8;
            font-size: 1.05rem;
            color: #374151;
        }
        
        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .article-header {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .article-title {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .article-date {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border-color: rgba(52, 211, 153, 0.2);
        }
        html[data-theme="dark"] .article-content {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }
    </style>

    <div class="container py-5">
        <div class="article-container">
            <div class="article-header reveal">
                <h1 class="article-title mb-4">{{ $article->title }}</h1>
                <span class="article-date">
                    <i class="bi bi-calendar3"></i>
                    Published: {{ $article->created_at->format('M d, Y') }}
                </span>
            </div>
            <div class="article-content reveal" style="animation-delay: 0.1s;">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
    </div>
@endsection
