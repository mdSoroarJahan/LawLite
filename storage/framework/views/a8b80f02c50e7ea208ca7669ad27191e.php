

<?php $__env->startSection('content'); ?>
    <style>
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
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* Pause on hover */
        .marquee-container:hover .marquee-content {
            animation-play-state: paused;
        }
    </style>
    <div class="container py-6">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-6"><?php echo e(__('messages.find_lawyers')); ?></h1>
                <p class="text-muted"><?php echo e(__('messages.find_lawyers_description')); ?></p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form method="GET" action="<?php echo e(route('lawyers.index')); ?>" id="lawyer-search-form">
                    <div class="input-group position-relative">
                        <input type="text" name="search" id="lawyer-search-input" class="form-control"
                            placeholder="<?php echo e(__('messages.search_lawyers_placeholder')); ?>" value="<?php echo e(request('search')); ?>"
                            autocomplete="off">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('messages.search')); ?></button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('lawyers.index')); ?>" class="btn btn-secondary"><?php echo e(__('messages.clear')); ?></a>
                        <?php endif; ?>

                        <!-- Suggestions Dropdown -->
                        <div id="suggestions-dropdown" class="position-absolute bg-white border rounded shadow-sm w-100"
                            style="top: 100%; left: 0; z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-lift">
                        <div class="card-body text-center p-4">
                            <?php if($lawyer->user && $lawyer->user->profile_photo_path): ?>
                                <img src="<?php echo e(asset('storage/' . $lawyer->user->profile_photo_path)); ?>"
                                    alt="<?php echo e($lawyer->user->name); ?>" class="rounded-circle mb-3 object-fit-cover shadow-sm"
                                    style="width: 100px; height: 100px;">
                            <?php else: ?>
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-secondary mb-3 shadow-sm"
                                    style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    <?php echo e(substr($lawyer->user->name ?? 'L', 0, 1)); ?>

                                </div>
                            <?php endif; ?>

                            <h5 class="card-title fw-bold mb-1"><?php echo e($lawyer->user->name ?? __('messages.unnamed_lawyer')); ?>

                            </h5>
                            <p class="text-primary small mb-2 fw-semibold">
                                <?php echo e($lawyer->expertise ?? __('messages.general_practice')); ?></p>

                            <?php if(is_array($lawyer->education) && count($lawyer->education) > 0): ?>
                                <?php $eduText = $lawyer->education[0]; ?>
                                <?php if(strlen($eduText) > 25): ?>
                                    <div class="marquee-container mb-2" title="<?php echo e($eduText); ?>">
                                        <div class="marquee-content small text-muted">
                                            <i class="bi bi-mortarboard-fill me-1"></i> <?php echo e($eduText); ?>

                                        </div>
                                        <div class="marquee-content small text-muted">
                                            <i class="bi bi-mortarboard-fill me-1"></i> <?php echo e($eduText); ?>

                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="small text-muted mb-2 text-truncate" title="<?php echo e($eduText); ?>">
                                        <i class="bi bi-mortarboard-fill me-1"></i> <?php echo e($eduText); ?>

                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <p class="small text-muted mb-3">
                                <i class="bi bi-geo-alt-fill me-1"></i> <?php echo e($lawyer->city ?? __('messages.unknown')); ?>

                            </p>

                            <a href="<?php echo e(route('lawyers.show', $lawyer->id)); ?>"
                                class="btn btn-outline-primary w-100 rounded-pill"><?php echo e(__('messages.view_profile')); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-6">
                    <p class="lead text-muted"><?php echo e(__('messages.no_lawyers_found')); ?></p>
                </div>
            <?php endif; ?>
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
                fetch(`<?php echo e(route('lawyers.index')); ?>?search=${encodeURIComponent(query)}`, {
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
                                '<div class="p-3 text-muted"><?php echo e(__('messages.no_lawyers_found')); ?></div>';
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/lawyers/index.blade.php ENDPATH**/ ?>