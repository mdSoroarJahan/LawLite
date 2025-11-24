@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6">{{ __('messages.find_lawyers') }}</h1>
                <p class="text-muted">{{ __('messages.find_lawyers_description') }}</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form method="GET" action="{{ route('lawyers.index') }}" id="lawyer-search-form">
                    <div class="input-group position-relative">
                        <input type="text" name="search" id="lawyer-search-input" class="form-control"
                            placeholder="{{ __('messages.search_lawyers_placeholder') }}" value="{{ request('search') }}"
                            autocomplete="off">
                        <button type="submit" class="btn btn-primary">{{ __('messages.search') }}</button>
                        @if (request('search'))
                            <a href="{{ route('lawyers.index') }}" class="btn btn-secondary">{{ __('messages.clear') }}</a>
                        @endif

                        <!-- Suggestions Dropdown -->
                        <div id="suggestions-dropdown" class="position-absolute bg-white border rounded shadow-sm w-100"
                            style="top: 100%; left: 0; z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($lawyers as $lawyer)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $lawyer->user->name ?? __('messages.unnamed_lawyer') }}</h5>
                            <p class="card-text text-muted">{{ $lawyer->expertise ?? __('messages.general_practice') }}</p>
                            <p class="mb-1"><small class="text-muted">{{ __('messages.location') }}:
                                    {{ $lawyer->city ?? __('messages.unknown') }}</small>
                            </p>
                            <a href="{{ route('lawyers.show', $lawyer->id) }}"
                                class="btn btn-sm btn-outline-primary mt-2">{{ __('messages.view_profile') }}</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-6">
                    <p class="lead text-muted">{{ __('messages.no_lawyers_found') }}</p>
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
                                '<div class="p-3 text-muted">{{ __('messages.no_lawyers_found') }}</div>';
                            suggestionsDropdown.style.display = 'block';
                            return;
                        }

                        // Build suggestions list
                        let suggestionsHTML = '';
                        lawyerCards.forEach(card => {
                            const name = card.querySelector('.card-title')?.textContent?.trim() || '';
                            const expertise = card.querySelector('.card-text')?.textContent?.trim() ||
                                '';
                            const location = card.querySelector('small')?.textContent?.trim() || '';
                            const profileLink = card.querySelector('a')?.getAttribute('href') || '#';

                            suggestionsHTML += `
                            <a href="${profileLink}" class="d-block p-3 text-decoration-none text-dark border-bottom suggestion-item" 
                               style="cursor: pointer;">
                                <div class="fw-bold">${name}</div>
                                <div class="small text-muted">${expertise}</div>
                                <div class="small text-muted">${location}</div>
                            </a>
                        `;
                        });

                        suggestionsDropdown.innerHTML = suggestionsHTML;
                        suggestionsDropdown.style.display = 'block';

                        // Add hover effect
                        document.querySelectorAll('.suggestion-item').forEach(item => {
                            item.addEventListener('mouseenter', function() {
                                this.style.backgroundColor = '#f8f9fa';
                            });
                            item.addEventListener('mouseleave', function() {
                                this.style.backgroundColor = 'white';
                            });
                        });
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
