@extends('layouts.landing')

@section('content')
<style>
    /* ===== MODERN PROFESSIONAL THEME ===== */
    .profile-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        position: relative;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .profile-photo {
        position: relative;
        z-index: 1;
        margin-top: 50px;
    }

    .profile-photo img,
    .profile-photo .avatar-placeholder {
        border: 4px solid white;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .profile-photo:hover img,
    .profile-photo:hover .avatar-placeholder {
        transform: scale(1.03);
    }

    .avatar-placeholder {
        background: #10b981 !important;
    }

    .verified-badge {
        background: #10b981;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .expertise-badge {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .action-btn-primary {
        background: #10b981;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        color: white;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 48px;
    }

    .action-btn-primary:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .action-btn-outline {
        background: transparent;
        border: 2px solid #10b981;
        color: #10b981;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 48px;
    }

    .action-btn-outline:hover {
        background: #10b981;
        border-color: #10b981;
        color: white;
        transform: translateY(-2px);
    }

    .detail-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .detail-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .section-title {
        color: #10b981;
        font-weight: 700;
    }

    .education-item,
    .experience-item {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        transition: all 0.25s ease;
        color: #374151;
    }

    .education-item:hover,
    .experience-item:hover {
        background: rgba(16, 185, 129, 0.05);
        border-color: rgba(16, 185, 129, 0.2);
        transform: translateX(4px);
    }

    .language-badge {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s ease;
    }

    .language-badge:hover {
        background: rgba(16, 185, 129, 0.15);
        transform: scale(1.03);
    }

    /* ===== DARK MODE ===== */
    html[data-theme="dark"] .profile-card {
        background: #1e293b;
        border-color: #334155;
    }

    html[data-theme="dark"] .profile-card::before {
        background: #0f172a;
        border-bottom-color: #334155;
    }

    html[data-theme="dark"] .profile-photo img,
    html[data-theme="dark"] .profile-photo .avatar-placeholder {
        border-color: #1e293b;
    }

    html[data-theme="dark"] .detail-card {
        background: #1e293b;
        border-color: #334155;
    }

    html[data-theme="dark"] .detail-card:hover {
        border-color: rgba(52, 211, 153, 0.3);
    }

    html[data-theme="dark"] .education-item,
    html[data-theme="dark"] .experience-item {
        background: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    html[data-theme="dark"] .education-item:hover,
    html[data-theme="dark"] .experience-item:hover {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(52, 211, 153, 0.3);
    }

    html[data-theme="dark"] .section-title {
        color: #34d399;
    }

    html[data-theme="dark"] .action-btn-outline {
        color: #34d399;
        border-color: #34d399;
    }

    html[data-theme="dark"] .action-btn-outline:hover {
        background: #10b981;
        color: white;
    }

    html[data-theme="dark"] .text-muted {
        color: #94a3b8 !important;
    }

    html[data-theme="dark"] .fw-bold,
    html[data-theme="dark"] h3 {
        color: #f1f5f9;
    }

    html[data-theme="dark"] .expertise-badge {
        background: rgba(52, 211, 153, 0.1);
        color: #34d399;
        border-color: rgba(52, 211, 153, 0.2);
    }

    html[data-theme="dark"] .language-badge {
        background: rgba(52, 211, 153, 0.1);
        color: #34d399;
        border-color: rgba(52, 211, 153, 0.2);
    }
</style>

<div class="container py-5 pb-5 mb-5">
    <div class="row g-4">
        <!-- Left Column: Profile Card -->
        <div class="col-lg-4">
            <div class="profile-card reveal">
                <div class="card-body text-center p-4">
                    <div class="profile-photo d-inline-block mb-4">
                        @if ($lawyer->user->profile_photo_path)
                        <img src="{{ asset('storage/' . $lawyer->user->profile_photo_path) }}"
                            alt="{{ $lawyer->user->name }}" class="rounded-circle"
                            style="width: 160px; height: 160px; object-fit: cover;">
                        @else
                        <div class="rounded-circle avatar-placeholder text-white d-inline-flex align-items-center justify-content-center"
                            style="width: 160px; height: 160px; font-size: 4rem;">
                            {{ substr($lawyer->user->name, 0, 1) }}
                        </div>
                        @endif
                        @if ($lawyer->verification_status === 'verified')
                        <div class="position-absolute bottom-0 end-0 translate-middle-x mb-2">
                            <span class="badge verified-badge rounded-pill p-2" title="Verified Lawyer">
                                <i class="bi bi-check-lg text-white"></i>
                            </span>
                        </div>
                        @endif
                    </div>

                    <h3 class="fw-bold mb-2">{{ $lawyer->user->name ?? 'Lawyer' }}</h3>
                    <div class="expertise-badge mb-3">{{ $lawyer->expertise ?? __('messages.general_practice') }}</div>
                    <p class="text-muted small mb-4">
                        <i class="bi bi-geo-alt-fill me-1 text-danger"></i>{{ $lawyer->city ?? __('messages.unknown') }}
                    </p>

                    <div class="d-grid gap-3">
                        @auth
                        <a href="{{ route('messages.inbox', ['with' => $lawyer->user->id]) }}" class="btn btn-primary action-btn-primary">
                            <i class="bi bi-chat-dots-fill me-2"></i>{{ __('messages.message') }}
                        </a>
                        <button class="btn action-btn-outline" data-bs-toggle="modal"
                            data-bs-target="#appointmentModal" data-lawyer-id="{{ $lawyer->id }}"
                            data-hourly-rate="{{ $lawyer->hourly_rate ?? 500 }}"
                            data-lawyer-name="{{ $lawyer->user->name ?? 'Lawyer' }}">
                            <i class="bi bi-calendar-check me-2"></i>{{ __('messages.book_appointment') }}
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary action-btn-primary">
                            {{ __('messages.sign_in_to_message') }}
                        </a>
                        <a href="{{ route('login') }}" class="btn action-btn-outline">
                            {{ __('messages.sign_in_to_book') }}
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-lg-8">
            <!-- About Section -->
            <div class="detail-card mb-4 reveal">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4 section-title"><i class="bi bi-person-lines-fill me-2"></i>About</h5>
                    <p class="text-muted leading-relaxed mb-0">{{ $lawyer->bio ?? 'No biography available.' }}</p>
                </div>
            </div>

            <!-- Education Section -->
            @if (is_array($lawyer->education) && count($lawyer->education) > 0)
            <div class="detail-card mb-4 reveal" style="animation-delay: 0.1s;">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4 section-title"><i class="bi bi-mortarboard-fill me-2"></i>Education</h5>
                    @foreach ($lawyer->education as $edu)
                    <div class="education-item d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-3"></i>
                        <span>{{ $edu }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Experience Section -->
            @if (is_array($lawyer->experience) && count($lawyer->experience) > 0)
            <div class="detail-card mb-4 reveal" style="animation-delay: 0.2s;">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4 section-title"><i class="bi bi-briefcase-fill me-2"></i>Experience</h5>
                    @foreach ($lawyer->experience as $exp)
                    <div class="experience-item d-flex align-items-center">
                        <i class="bi bi-briefcase text-primary me-3"></i>
                        <span>{{ $exp }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Languages Section -->
            @if (is_array($lawyer->languages) && count($lawyer->languages) > 0)
            <div class="detail-card mb-4 reveal" style="animation-delay: 0.3s;">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4 section-title"><i class="bi bi-translate me-2"></i>Languages</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($lawyer->languages as $lang)
                        <span class="language-badge">{{ $lang }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@include('components.appointment_modal')
@endsection