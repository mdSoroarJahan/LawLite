@extends('layouts.landing')

@section('content')
    <style>
        /* ===== LAWLITE PROFESSIONAL THEME ===== */
        :root {
            --ll-primary: #10b981;
            --ll-primary-dark: #059669;
            --ll-primary-light: #34d399;
            --ll-secondary: #0f172a;
            --ll-accent: #06b6d4;
            --ll-text: #1f2937;
            --ll-text-muted: #6b7280;
            --ll-bg: #f8fafc;
            --ll-card-bg: #ffffff;
            --ll-border: #e5e7eb;
            --ll-shadow: rgba(0, 0, 0, 0.08);
            --ll-shadow-lg: rgba(0, 0, 0, 0.12);
        }

        .marquee-container {
            display: flex;
            overflow: hidden;
            width: 100%;
            mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        }

        .marquee-content {
            white-space: nowrap;
            padding-right: 2rem;
            flex-shrink: 0;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }

        .marquee-container:hover .marquee-content {
            animation-play-state: paused;
        }

        /* ===== PAGE HEADER ===== */
        .page-header-premium {
            background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 50%, #f0fdf4 100%);
            border: 1px solid rgba(16, 185, 129, 0.1);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header-premium::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-title-gradient {
            color: #0f172a;
            font-weight: 700;
        }

        /* ===== SEARCH BAR ===== */
        .glass-search-container {
            background: var(--ll-card-bg);
            border: 1px solid var(--ll-border);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 20px var(--ll-shadow);
            transition: all 0.3s ease;
            position: relative;
            z-index: 100;
        }

        .glass-search-container:focus-within {
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.12);
            border-color: var(--ll-primary);
        }

        .search-input-premium {
            border: 2px solid var(--ll-border);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            background: var(--ll-card-bg);
            color: var(--ll-text);
        }

        .search-input-premium:focus {
            border-color: var(--ll-primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .search-input-premium::placeholder {
            color: var(--ll-text-muted);
        }

        .search-btn-premium {
            background: var(--ll-primary);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.25s ease;
        }

        .search-btn-premium:hover {
            background: var(--ll-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        /* ===== LAWYER CARDS ===== */
        .lawyer-card-premium {
            background: var(--ll-card-bg);
            border: 1px solid var(--ll-border);
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .lawyer-card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--ll-primary) 0%, var(--ll-accent) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lawyer-card-premium:hover::before {
            opacity: 1;
        }

        .lawyer-card-premium:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px var(--ll-shadow-lg);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .lawyer-avatar {
            position: relative;
            display: inline-block;
        }

        .lawyer-avatar img,
        .lawyer-avatar .avatar-placeholder {
            border: 3px solid rgba(16, 185, 129, 0.15);
            transition: all 0.3s ease;
        }

        .lawyer-card-premium:hover .lawyer-avatar img,
        .lawyer-card-premium:hover .lawyer-avatar .avatar-placeholder {
            border-color: var(--ll-primary);
            transform: scale(1.03);
        }

        .avatar-placeholder {
            background: linear-gradient(135deg, var(--ll-primary) 0%, var(--ll-primary-dark) 100%) !important;
        }

        .expertise-badge {
            background: rgba(16, 185, 129, 0.1);
            color: var(--ll-primary-dark);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid rgba(16, 185, 129, 0.15);
        }

        .view-profile-btn {
            background: var(--ll-primary);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
            text-shadow: none !important;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .view-profile-btn:hover, .view-profile-btn:focus, .view-profile-btn:active {
            background: var(--ll-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
        }

        /* ===== SUGGESTIONS DROPDOWN ===== */
        .suggestions-dropdown {
            background: var(--ll-card-bg);
            border: 1px solid var(--ll-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 12px 40px var(--ll-shadow-lg) !important;
            overflow: hidden;
            margin-top: 8px;
            z-index: 99999 !important;
        }

        .suggestion-item {
            transition: all 0.2s ease !important;
            border-bottom: 1px solid var(--ll-border) !important;
            color: var(--ll-text);
        }

        .suggestion-item:last-child {
            border-bottom: none !important;
        }

        .suggestion-item:hover {
            background: #f0fdfa !important;
        }

        .suggestion-item .fw-semibold {
            color: var(--ll-text);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
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
        html[data-theme="dark"] {
            --ll-text: #f1f5f9;
            --ll-text-muted: #94a3b8;
            --ll-bg: #0f172a;
            --ll-card-bg: #1e293b;
            --ll-border: #334155;
            --ll-shadow: rgba(0, 0, 0, 0.3);
            --ll-shadow-lg: rgba(0, 0, 0, 0.4);
        }

        html[data-theme="dark"] .page-header-premium {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(6, 182, 212, 0.05) 50%, rgba(16, 185, 129, 0.03) 100%);
            border-color: rgba(16, 185, 129, 0.15);
        }

        html[data-theme="dark"] .page-title-gradient {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .glass-search-container {
            background: var(--ll-card-bg);
            border-color: var(--ll-border);
        }

        html[data-theme="dark"] .search-input-premium {
            background: #0f172a;
            border-color: var(--ll-border);
            color: var(--ll-text);
        }

        html[data-theme="dark"] .search-input-premium::placeholder {
            color: var(--ll-text-muted);
        }

        html[data-theme="dark"] .lawyer-card-premium {
            background: var(--ll-card-bg);
            border-color: var(--ll-border);
        }

        html[data-theme="dark"] .lawyer-card-premium:hover {
            border-color: rgba(16, 185, 129, 0.3);
        }

        html[data-theme="dark"] .lawyer-card-premium h5,
        html[data-theme="dark"] .lawyer-card-premium .card-title {
            color: var(--ll-text) !important;
        }

        html[data-theme="dark"] .expertise-badge {
            background: rgba(16, 185, 129, 0.15);
            color: var(--ll-primary-light);
            border-color: rgba(16, 185, 129, 0.25);
        }

        html[data-theme="dark"] .suggestions-dropdown {
            background: var(--ll-card-bg) !important;
            border-color: var(--ll-border) !important;
        }

        html[data-theme="dark"] .suggestion-item {
            border-bottom-color: var(--ll-border) !important;
            color: var(--ll-text);
        }

        html[data-theme="dark"] .suggestion-item:hover {
            background: rgba(16, 185, 129, 0.08) !important;
        }

        html[data-theme="dark"] .suggestion-item .fw-semibold {
            color: var(--ll-text) !important;
        }

        html[data-theme="dark"] .empty-state-icon {
            background: rgba(16, 185, 129, 0.15);
        }

        html[data-theme="dark"] .text-muted {
            color: var(--ll-text-muted) !important;
        }

        html[data-theme="dark"] .text-primary {
            color: var(--ll-primary-light) !important;
        }

        html[data-theme="dark"] .text-danger {
            color: #f87171 !important;
        }
    </style>

    <div class="container py-5">
        <!-- Premium Header -->
        <div class="page-header-premium reveal text-center">
            <h1 class="display-5 fw-bold mb-3 page-title-gradient">
                {{ __('messages.find_lawyers') }}
            </h1>
            <p class="text-muted lead mb-0">{{ __('messages.find_lawyers_description') }}</p>
        </div>

        <!-- Glass Search Bar -->
        <div class="row mb-5 pb-3 reveal" style="position: relative; z-index: 100;">
            <div class="col-lg-8 mx-auto">
                <div class="glass-search-container">
                    <form method="GET" action="{{ route('lawyers.index') }}" id="lawyer-search-form">
                        <div class="d-flex gap-2 position-relative">
                            <div class="flex-grow-1 position-relative">
                                <input type="text" name="search" id="lawyer-search-input" 
                                    class="form-control search-input-premium w-100"
                                    placeholder="{{ __('messages.search_lawyers_placeholder') }}" 
                                    value="{{ request('search') }}"
                                    autocomplete="off">
                                <!-- Suggestions Dropdown -->
                                <div id="suggestions-dropdown" class="position-absolute w-100 suggestions-dropdown"
                                    style="top: calc(100% + 8px); left: 0; z-index: 99999; display: none; max-height: 320px; overflow-y: auto;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary search-btn-premium">
                                <i class="bi bi-search me-2"></i>{{ __('messages.search') }}
                            </button>
                            @if (request('search'))
                                <a href="{{ route('lawyers.index') }}" class="btn btn-outline-secondary" style="border-radius: 12px;">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($lawyers as $lawyer)
                <div class="col-lg-4 col-md-6 mb-4 reveal" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <div class="card h-100 lawyer-card-premium border-0">
                        <div class="card-body text-center p-4">
                            <div class="lawyer-avatar mb-3">
                                @if ($lawyer->user && $lawyer->user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $lawyer->user->profile_photo_path) }}"
                                        alt="{{ $lawyer->user->name }}" class="rounded-circle object-fit-cover shadow"
                                        style="width: 100px; height: 100px;">
                                @else
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white avatar-placeholder shadow-sm"
                                        style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                        {{ substr($lawyer->user->name ?? 'L', 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <h5 class="card-title fw-bold mb-2">{{ $lawyer->user->name ?? __('messages.unnamed_lawyer') }}</h5>
                            <div class="expertise-badge mb-3">
                                {{ $lawyer->expertise ?? __('messages.general_practice') }}
                            </div>

                            @if (is_array($lawyer->education) && count($lawyer->education) > 0)
                                @php $eduText = $lawyer->education[0]; @endphp
                                @if (strlen($eduText) > 25)
                                    <div class="marquee-container mb-2" title="{{ $eduText }}">
                                        <div class="marquee-content small text-muted">
                                            <i class="bi bi-mortarboard-fill me-1 text-primary"></i> {{ $eduText }}
                                        </div>
                                        <div class="marquee-content small text-muted">
                                            <i class="bi bi-mortarboard-fill me-1 text-primary"></i> {{ $eduText }}
                                        </div>
                                    </div>
                                @else
                                    <p class="small text-muted mb-2 text-truncate" title="{{ $eduText }}">
                                        <i class="bi bi-mortarboard-fill me-1 text-primary"></i> {{ $eduText }}
                                    </p>
                                @endif
                            @endif

                            <p class="small text-muted mb-4">
                                <i class="bi bi-geo-alt-fill me-1 text-danger"></i> {{ $lawyer->city ?? __('messages.unknown') }}
                            </p>

                            <a href="{{ route('lawyers.show', $lawyer->id) }}" class="view-profile-btn w-100 d-inline-block text-center text-decoration-none">
                                <i class="bi bi-person-lines-fill me-2"></i>{{ __('messages.view_profile') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state reveal">
                        <div class="empty-state-icon">
                            <i class="bi bi-person-x" style="font-size: 2rem; color: #10b981;"></i>
                        </div>
                        <h4 class="fw-bold mb-2">{{ __('messages.no_lawyers_found') }}</h4>
                        <p class="text-muted">Try adjusting your search criteria</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('lawyer-search-input');
            const suggestionsDropdown = document.getElementById('suggestions-dropdown');
            let debounceTimer;

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // Clear previous timer
                clearTimeout(debounceTimer);

                // Hide suggestions if query is empty
                if (query.length < 2) {
                    suggestionsDropdown.style.display = 'none';
                    return;
                }

                // Debounce the search (wait 300ms after user stops typing)
                debounceTimer = setTimeout(() => {
                    fetchSuggestions(query);
                }, 300);
            });

            function fetchSuggestions(query) {
                fetch(`{{ route('lawyers.index') }}?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Parse the HTML to extract lawyer data
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const lawyerCards = doc.querySelectorAll('.card .card-body');

                        if (lawyerCards.length === 0) {
                            suggestionsDropdown.innerHTML =
                                '<div class="px-4 py-3 text-center" style="color: #6b7280;"><i class="bi bi-search me-2"></i>{{ __('messages.no_lawyers_found') }}</div>';
                            suggestionsDropdown.style.display = 'block';
                            return;
                        }

                        // Build suggestions list
                        let suggestionsHTML = '';
                        lawyerCards.forEach(card => {
                            const name = card.querySelector('.card-title')?.textContent?.trim() || '';
                            const profileLink = card.querySelector('a')?.getAttribute('href') || '#';

                            // Skip empty entries
                            if (!name || name === '' || profileLink === '#') {
                                return;
                            }

                            suggestionsHTML += `
                            <a href="${profileLink}" class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none suggestion-item">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 36px; height: 36px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; font-size: 0.875rem; flex-shrink: 0;">
                                    ${name.charAt(0).toUpperCase()}
                                </div>
                                <div class="fw-semibold" style="font-size: 0.95rem;">${name}</div>
                            </a>
                        `;
                        });

                        // Only show dropdown if we have valid suggestions
                        if (suggestionsHTML.trim() === '') {
                            suggestionsDropdown.innerHTML =
                                '<div class="px-4 py-3 text-center" style="color: #6b7280;"><i class="bi bi-search me-2"></i>{{ __('messages.no_lawyers_found') }}</div>';
                        } else {
                            suggestionsDropdown.innerHTML = suggestionsHTML;
                        }
                        suggestionsDropdown.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                    });
            }

            // Close suggestions when clicking outside
            document.addEventListener('click', function(event) {
                if (!searchInput.contains(event.target) && !suggestionsDropdown.contains(event.target)) {
                    suggestionsDropdown.style.display = 'none';
                }
            });

            // Show suggestions again when input is focused and has value
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    fetchSuggestions(this.value.trim());
                }
            });
        });
    </script>
@endsection
