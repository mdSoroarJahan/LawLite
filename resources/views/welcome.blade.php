@extends('layouts.landing')

@section('no-padding', true)

@push('styles')
<style>
    /* Hero Section with Advanced Effects */
    .hero-section {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 50%, #f0fdf4 100%);
        padding: 10rem 0 8rem;
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 80%;
        height: 150%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
        animation: pulse-bg 8s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 60%;
        height: 100%;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.05) 0%, transparent 60%);
    }

    /* Grid Pattern Overlay */
    .hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(16, 185, 129, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(16, 185, 129, 0.03) 1px, transparent 1px);
        background-size: 60px 60px;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
    }

    /* Glowing Orbs */
    .hero-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        animation: orb-float 20s ease-in-out infinite;
    }

    .hero-orb-1 {
        width: 400px;
        height: 400px;
        background: rgba(16, 185, 129, 0.15);
        top: 10%;
        right: 10%;
        animation-delay: 0s;
    }

    .hero-orb-2 {
        width: 300px;
        height: 300px;
        background: rgba(139, 92, 246, 0.1);
        bottom: 20%;
        left: 5%;
        animation-delay: -7s;
    }

    .hero-orb-3 {
        width: 200px;
        height: 200px;
        background: rgba(59, 130, 246, 0.1);
        top: 40%;
        left: 30%;
        animation-delay: -14s;
    }

    @keyframes orb-float {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        25% {
            transform: translate(30px, -30px) scale(1.1);
        }

        50% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        75% {
            transform: translate(20px, 10px) scale(1.05);
        }
    }

    @keyframes pulse-bg {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }

    /* Widen and scale hero on large screens */
    @media (min-width: 1200px) {
        .hero-section .container {
            max-width: 1320px;
        }

        .hero-title {
            font-size: 4.4rem;
        }

        .hero-section .lead {
            font-size: 1.35rem;
        }
    }

    @media (min-width: 1440px) {
        .hero-section .container {
            max-width: 1400px;
        }

        .hero-title {
            font-size: 4.6rem;
        }
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        line-height: 1.05;
    }

    @media (max-width: 991px) {
        .hero-title {
            font-size: 2.75rem;
        }

        .hero-section {
            padding: 7rem 0 5rem;
            min-height: auto;
        }
    }

    .hero-gradient-text {
        background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
        position: relative;
    }

    .hero-gradient-text::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 8px;
        background: rgba(16, 185, 129, 0.2);
        border-radius: 4px;
        z-index: -1;
    }

    /* Feature Cards with 3D Effect */
    .feature-icon {
        width: 72px;
        height: 72px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        transition: all 0.4s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .feature-icon.green {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
        color: #10b981;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.15);
    }

    .feature-icon.blue {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
        color: #3b82f6;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
    }

    .feature-icon.amber {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
        color: #f59e0b;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.15);
    }

    .feature-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 2.5rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #3b82f6, #f59e0b);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    /* Step Numbers */
    .step-number {
        width: 48px;
        height: 48px;
        background: var(--gradient-accent);
        color: white;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.25rem;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
    }

    /* AI Card */
    .ai-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .ai-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-accent);
    }

    .ai-icon-wrapper {
        width: 56px;
        height: 56px;
        background: var(--gradient-accent);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
    }

    /* Stats Section */
    .stats-section {
        background: var(--gradient-primary);
        position: relative;
    }

    .stat-card {
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: linear-gradient(180deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    }

    .stat-card:last-child::after {
        display: none;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.05em;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    /* Floating Elements */
    .floating-badge {
        position: absolute;
        background: white;
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        animation: float 3s ease-in-out infinite;
    }

    .floating-badge.badge-1 {
        top: 15%;
        right: 5%;
        animation-delay: 0s;
    }

    .floating-badge.badge-2 {
        bottom: 25%;
        right: 10%;
        animation-delay: 1s;
    }

    .floating-badge.badge-3 {
        top: 40%;
        left: 5%;
        animation-delay: 2s;
    }

    /* Image Container */
    .image-container {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
    }

    .image-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
        z-index: 1;
    }

    .image-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    /* CTA Section */
    .cta-section {
        background: var(--gradient-primary);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -25%;
        width: 150%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
    }

    .cta-glow {
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(16, 185, 129, 0.2);
        border-radius: 50%;
        filter: blur(80px);
        animation: pulse-glow 4s ease-in-out infinite;
    }

    /* Hover Effects */
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
    }

    /* Animated Text */
    .text-shimmer {
        background: linear-gradient(90deg, var(--primary), var(--accent), var(--primary));
        background-size: 200% auto;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 3s linear infinite;
    }

    @keyframes shimmer {
        to {
            background-position: 200% center;
        }
    }

    /* Pulse Ring */
    .pulse-ring {
        position: relative;
    }

    .pulse-ring::before {
        content: '';
        position: absolute;
        inset: -5px;
        border: 2px solid var(--accent);
        border-radius: inherit;
        animation: pulse-ring 2s ease-out infinite;
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(1.2);
            opacity: 0;
        }
    }

    /* Live Indicator */
    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--accent);
    }

    .live-dot {
        width: 8px;
        height: 8px;
        background: var(--accent);
        border-radius: 50%;
        animation: live-pulse 1.5s ease-in-out infinite;
    }

    @keyframes live-pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.3);
            opacity: 0.7;
        }
    }

    /* Morphing Card */
    .morph-card {
        animation: card-morph 8s ease-in-out infinite;
    }

    @keyframes card-morph {

        0%,
        100% {
            border-radius: 24px 24px 24px 24px;
        }

        25% {
            border-radius: 24px 60px 24px 60px;
        }

        50% {
            border-radius: 60px 24px 60px 24px;
        }

        75% {
            border-radius: 24px 60px 24px 60px;
        }
    }

    /* Button Ripple Effect */
    .btn-ripple {
        position: relative;
        overflow: hidden;
    }

    .btn-ripple span {
        position: relative;
        z-index: 1;
    }

    /* Trust Badges */
    .trust-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--muted);
        transition: all 0.3s ease;
    }

    .trust-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .trust-badge i {
        color: var(--accent);
    }

    /* Dark mode overrides for welcome */
    html[data-theme="dark"] .hero-section {
        background: linear-gradient(135deg, #07122a 0%, #0d1b30 50%, #07122a 100%);
    }

    html[data-theme="dark"] .hero-section::before {
        background: radial-gradient(circle, rgba(52, 211, 153, 0.08) 0%, transparent 70%);
    }

    html[data-theme="dark"] .hero-section::after {
        background: radial-gradient(circle, rgba(139, 92, 246, 0.04) 0%, transparent 60%);
    }

    html[data-theme="dark"] .hero-grid {
        background-image:
            linear-gradient(rgba(52, 211, 153, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(52, 211, 153, 0.05) 1px, transparent 1px);
    }

    html[data-theme="dark"] .hero-orb-1 {
        background: rgba(52, 211, 153, 0.1);
    }

    html[data-theme="dark"] .hero-orb-2 {
        background: rgba(139, 92, 246, 0.07);
    }

    html[data-theme="dark"] .ai-card {
        background: rgba(11, 18, 32, 0.95);
        border-color: rgba(255, 255, 255, 0.08);
    }

    html[data-theme="dark"] .ai-card textarea {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #e6eef8;
    }

    html[data-theme="dark"] .trust-badge,
    html[data-theme="dark"] .floating-badge {
        background: rgba(11, 18, 32, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #e6eef8;
    }

    html[data-theme="dark"] .feature-card {
        background: rgba(11, 18, 32, 0.9);
        border-color: rgba(255, 255, 255, 0.08);
    }

    html[data-theme="dark"] .feature-card h4 {
        color: #e6eef8;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <!-- Background Effects -->
    <div class="hero-grid"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 reveal reveal-left">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge-modern d-inline-flex align-items-center">
                        <i class="bi bi-stars me-2"></i> {{ __('messages.hero_badge') }}
                    </span>
                    <span class="live-indicator">
                        <span class="live-dot"></span>
                        {{ __('messages.ai_online') }}
                    </span>
                </div>
                <h1 class="hero-title mb-4">
                    {{ __('messages.hero_title_1') }}
                    <span class="hero-gradient-text">{{ __('messages.hero_title_2') }}</span>
                </h1>
                <p class="lead text-muted mb-5" style="font-size: 1.25rem; line-height: 1.8;">
                    {{ __('messages.hero_desc') }}
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                    @guest
                    <a href="{{ route('lawyers.index') }}"
                        class="btn btn-primary btn-lg px-5 py-3 fw-semibold btn-ripple btn-glow">
                        <span><i class="bi bi-search me-2"></i>{{ __('messages.find_lawyer_btn') }}</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5 py-3 fw-semibold">
                        {{ __('messages.get_started_btn') }}
                    </a>
                    @else
                    <a href="{{ route('lawyers.index') }}"
                        class="btn btn-primary btn-lg px-5 py-3 fw-semibold">
                        <i class="bi bi-search me-2"></i>{{ __('messages.find_lawyer_btn') }}
                    </a>
                    @if (Auth::user()->role === 'lawyer')
                    <a href="{{ route('lawyer.dashboard') }}" class="btn btn-dark btn-lg px-5 py-3 fw-semibold">
                        <i class="bi bi-speedometer2 me-2"></i>{{ __('messages.dashboard') }}
                    </a>
                    @elseif(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-lg px-5 py-3 fw-semibold">
                        {{ __('messages.admin_panel') }}
                    </a>
                    @else
                    <a href="{{ route('appointments.index') }}"
                        class="btn btn-dark btn-lg px-5 py-3 fw-semibold">
                        {{ __('messages.my_appointments') }}
                    </a>
                    @endif
                    @endguest
                </div>

                <div class="d-flex align-items-center gap-4 mt-5 pt-3">
                    <div class="d-flex">
                        <div class="rounded-circle bg-success" style="width: 10px; height: 10px; margin-right: 8px; margin-top: 6px;"></div>
                        <span class="text-muted fw-medium">{{ __('messages.ai_powered') }}</span>
                    </div>
                    <div class="d-flex">
                        <div class="rounded-circle bg-primary" style="width: 10px; height: 10px; margin-right: 8px; margin-top: 6px;"></div>
                        <span class="text-muted fw-medium">{{ __('messages.secure_private') }}</span>
                    </div>
                    <div class="d-flex">
                        <div class="rounded-circle bg-warning" style="width: 10px; height: 10px; margin-right: 8px; margin-top: 6px;"></div>
                        <span class="text-muted fw-medium">{{ __('messages.bd_law_expert') }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1 reveal reveal-right">
                <div class="ai-card p-4 p-md-5 tilt-effect">
                    <div class="d-flex align-items-center mb-4">
                        <div class="ai-icon-wrapper me-3 pulse-ring" style="border-radius: 16px;">
                            <i class="bi bi-robot text-white fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">{{ __('messages.ai_card_title') }}</h5>
                            <small class="text-muted">{{ __('messages.ai_card_subtitle') }}</small>
                        </div>
                    </div>

                    <form action="{{ route('ai.ask') }}" method="POST" id="aiQuestionForm">
                        @csrf
                        <div class="mb-3">
                            <textarea name="question" class="form-control p-3" rows="4"
                                placeholder="{{ __('messages.ai_input_placeholder') }}" style="resize: none; background: #f8fafc;" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold btn-magnetic">
                            <i class="bi bi-send me-2"></i>{{ __('messages.ai_submit_btn') }}
                        </button>
                    </form>

                    <div id="aiResponse" class="mt-4" style="display:none;">
                        <div class="alert alert-light border-0 shadow-sm rounded-3"></div>
                    </div>

                    <div class="d-flex justify-content-center gap-4 mt-4 pt-2">
                        <a href="{{ route('ai.features') }}" class="text-decoration-none d-flex align-items-center gap-2 text-muted hover-underline icon-bounce" style="font-size: 0.875rem;">
                            <i class="bi bi-grid-3x3-gap text-accent"></i>
                            <span>More AI Tools</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Badges Row -->
        <div class="row mt-5 pt-4 reveal stagger-3">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <div class="trust-badge">
                        <i class="bi bi-shield-lock"></i>
                        <span>{{ __('messages.bank_level_security') }}</span>
                    </div>
                    <div class="trust-badge">
                        <i class="bi bi-patch-check"></i>
                        <span>{{ __('messages.verified_lawyers_short') }}</span>
                    </div>
                    <div class="trust-badge">
                        <i class="bi bi-headset"></i>
                        <span>{{ __('messages.support_24_7') }}</span>
                    </div>
                    <div class="trust-badge">
                        <i class="bi bi-translate"></i>
                        <span>{{ __('messages.available_langs') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Badges -->
    <div class="floating-badge badge-1 d-none d-lg-flex">
        <i class="bi bi-shield-check text-success"></i>
        <span>{{ __('messages.verified_lawyers_short') }}</span>
    </div>
    <div class="floating-badge badge-2 d-none d-lg-flex">
        <i class="bi bi-translate text-primary"></i>
        <span>{{ __('messages.available_langs') }}</span>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-4 reveal stagger-1">
                <div class="stat-card">
                    <div class="stat-number counter" data-target="100">0</div>
                    <div class="stat-label">{{ __('messages.stat_secure_platform') }}</div>
                </div>
            </div>
            <div class="col-md-4 reveal stagger-2">
                <div class="stat-card">
                    <div class="stat-number counter" data-target="98">0</div>
                    <div class="stat-label">{{ __('messages.stat_client_satisfaction') }}</div>
                </div>
            </div>
            <div class="col-md-4 reveal stagger-3">
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">{{ __('messages.stat_ai_support') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-6 bg-light-section">
    <div class="container py-5">
        <div class="text-center mb-5 reveal">
            <span class="badge-modern mb-3">{{ __('messages.why_choose_badge') }}</span>
            <h2 class="fw-bold mb-3 gradient-text-animate" style="font-size: 2.75rem; letter-spacing: -0.02em;">{{ __('messages.why_choose_title') }}</h2>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                {{ __('messages.why_choose_desc') }}
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4 reveal stagger-1">
                <div class="feature-card h-100 tilt-effect">
                    <div class="feature-icon green">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __('messages.feature_1_title') }}</h4>
                    <p class="text-muted mb-0">
                        {{ __('messages.feature_1_desc') }}
                    </p>
                </div>
            </div>
            <div class="col-md-4 reveal stagger-2">
                <div class="feature-card h-100 tilt-effect">
                    <div class="feature-icon blue">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __('messages.feature_2_title') }}</h4>
                    <p class="text-muted mb-0">
                        {{ __('messages.feature_2_desc') }}
                    </p>
                </div>
            </div>
            <div class="col-md-4 reveal stagger-3">
                <div class="feature-card h-100 tilt-effect">
                    <div class="feature-icon amber">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __('messages.feature_3_title') }}</h4>
                    <p class="text-muted mb-0">
                        {{ __('messages.feature_3_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How it Works -->
<section class="py-6 bg-white position-relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="position-absolute" style="top: 10%; right: -5%; width: 300px; height: 300px; background: rgba(16, 185, 129, 0.05); border-radius: 50%; filter: blur(60px);"></div>
    <div class="position-absolute" style="bottom: 10%; left: -5%; width: 200px; height: 200px; background: rgba(59, 130, 246, 0.05); border-radius: 50%; filter: blur(40px);"></div>

    <div class="container py-5 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 reveal reveal-left">
                <div class="image-container morph-card" style="animation: none;">
                    <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Legal Meeting" class="hover-lift" style="transition: transform 0.5s ease;">
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1 reveal reveal-right">
                <span class="badge-modern mb-3">{{ __('messages.simple_process') }}</span>
                <h2 class="fw-bold mb-5" style="font-size: 2.75rem; letter-spacing: -0.02em;">{{ __('messages.how_it_works_title') }}</h2>

                <div class="d-flex mb-4 p-4 rounded-4 hover-lift glow-border" style="background: linear-gradient(135deg, #f8fafc 0%, #fff 100%); border-radius: 20px;">
                    <div class="me-4">
                        <div class="step-number">1</div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ __('messages.step_1_title') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.step_1_desc') }}</p>
                    </div>
                </div>

                <div class="d-flex mb-4 p-4 rounded-4 hover-lift glow-border" style="background: linear-gradient(135deg, #f8fafc 0%, #fff 100%); border-radius: 20px;">
                    <div class="me-4">
                        <div class="step-number">2</div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ __('messages.step_2_title') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.step_2_desc') }}</p>
                    </div>
                </div>

                <div class="d-flex p-4 rounded-4 hover-lift glow-border" style="background: linear-gradient(135deg, #f8fafc 0%, #fff 100%); border-radius: 20px;">
                    <div class="me-4">
                        <div class="step-number">3</div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ __('messages.step_3_title') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.step_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-6 text-white position-relative overflow-hidden">
    <div class="cta-glow" style="top: -150px; left: -150px;"></div>
    <div class="cta-glow" style="bottom: -150px; right: -150px;"></div>

    <!-- Animated Grid -->
    <div class="position-absolute" style="inset: 0; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="container text-center py-5 position-relative reveal">
        <span class="badge px-4 py-2 rounded-pill mb-4 fw-semibold" style="background: rgba(16, 185, 129, 0.2); color: #34d399; backdrop-filter: blur(10px); border: 1px solid rgba(52, 211, 153, 0.3);">
            <i class="bi bi-rocket-takeoff me-2"></i>{{ __('messages.get_started_today') }}
        </span>
        <h2 class="fw-bold mb-4 gradient-text-animate" style="font-size: 3rem; -webkit-text-fill-color: white;">{{ __('messages.cta_title') }}</h2>
        <p class="lead mb-5 text-white-50" style="max-width: 600px; margin: 0 auto; font-size: 1.25rem;">{{ __('messages.cta_desc') }}</p>

        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            @guest
            <a href="{{ route('register') }}"
                class="btn btn-accent btn-lg px-5 py-3 fw-bold btn-magnetic ripple" style="font-size: 1.1rem;">
                <i class="bi bi-arrow-right-circle me-2"></i>{{ __('messages.cta_btn_guest') }}
            </a>
            <a href="{{ route('lawyers.index') }}"
                class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold" style="border-width: 2px;">
                <i class="bi bi-search me-2"></i>{{ __('messages.browse_lawyers') }}
            </a>
            @else
            <a href="{{ route('lawyers.index') }}"
                class="btn btn-accent btn-lg px-5 py-3 fw-bold btn-magnetic ripple" style="font-size: 1.1rem;">
                <i class="bi bi-search me-2"></i>{{ __('messages.cta_btn_user') }}
            </a>
            @endguest
        </div>

        <!-- Floating Stats -->
        <div class="d-flex justify-content-center gap-5 mt-5 pt-4 flex-wrap">
            <div class="text-center">
                <div class="h3 fw-bold mb-0" style="color: var(--gold);">500+</div>
                <small class="text-white-50">{{ __('messages.stat_verified_lawyers') }}</small>
            </div>
            <div class="text-center">
                <div class="h3 fw-bold mb-0" style="color: var(--accent-light);">10K+</div>
                <small class="text-white-50">{{ __('messages.cases_handled') }}</small>
            </div>
            <div class="text-center">
                <div class="h3 fw-bold mb-0" style="color: var(--gold);">98%</div>
                <small class="text-white-50">{{ __('messages.satisfaction_rate') }}</small>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const i18n = {
        processing: "{{ __('messages.processing') }}",
        analyzing: "{{ __('messages.analyzing_question') }}",
        aiResponseLabel: "{{ __('messages.ai_response_label') }}",
        errorOccurred: "{{ __('messages.error_occurred') }}",
        networkError: "{{ __('messages.network_error') }}",
    };

    document.getElementById('aiQuestionForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const responseDiv = document.getElementById('aiResponse');
        const responseAlert = responseDiv.querySelector('.alert');

        // Show loading state with animation
        submitBtn.disabled = true;
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>' + i18n.processing;
        responseDiv.style.display = 'block';
        responseDiv.style.opacity = '0';
        responseDiv.style.transform = 'translateY(20px)';
        responseAlert.className = 'alert alert-info border-0 shadow-sm';
        responseAlert.innerHTML = '<div class="d-flex align-items-center"><div class="spinner-grow spinner-grow-sm me-2" style="color: var(--accent);"></div>' + i18n.analyzing + '</div>';

        // Animate in
        setTimeout(() => {
            responseDiv.style.transition = 'all 0.5s ease';
            responseDiv.style.opacity = '1';
            responseDiv.style.transform = 'translateY(0)';
        }, 100);

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.ok) {
                responseAlert.className = 'alert alert-success border-0 shadow-sm';
                responseAlert.style.background = 'linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%)';
                responseAlert.style.borderLeft = '4px solid var(--accent)';
                const answer = typeof data.result === 'string' ? data.result : JSON.stringify(data.result, null, 2);
                responseAlert.innerHTML = '<div class="d-flex align-items-center mb-2"><i class="bi bi-check-circle-fill me-2" style="color: var(--accent);"></i><strong>' + i18n.aiResponseLabel + '</strong></div><div style="white-space: pre-wrap;" class="mt-2">' + answer + '</div>';
            } else {
                responseAlert.className = 'alert alert-danger border-0 shadow-sm';
                responseAlert.style.borderLeft = '4px solid #ef4444';
                responseAlert.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + (data.error || data.message || i18n.errorOccurred);
            }
        } catch (error) {
            responseAlert.className = 'alert alert-danger border-0 shadow-sm';
            responseAlert.style.borderLeft = '4px solid #ef4444';
            responseAlert.innerHTML = '<i class="bi bi-wifi-off me-2"></i>' + i18n.networkError;
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
</script>
@endpush