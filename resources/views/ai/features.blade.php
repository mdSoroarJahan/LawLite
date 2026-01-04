@extends('layouts.landing')

@section('no-padding', true)

@push('styles')
    <style>
        .ai-hero {
            background: var(--gradient-primary);
            padding: 8rem 0 5rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .ai-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 60%);
            animation: pulse-bg 8s ease-in-out infinite;
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

        .ai-hero-badge {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 1.75rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
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
            background: linear-gradient(90deg, #10b981, #3b82f6);
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

        .feature-card.active {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2), 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .feature-card.active::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .feature-icon.blue {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
            color: #3b82f6;
        }

        .feature-icon.green {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
            color: #10b981;
        }

        .feature-icon.purple {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
            color: #8b5cf6;
        }

        .feature-icon.orange {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(234, 88, 12, 0.15) 100%);
            color: #f97316;
        }

        .feature-icon.red {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
            color: #ef4444;
        }

        .feature-icon.teal {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.15) 0%, rgba(13, 148, 136, 0.15) 100%);
            color: #14b8a6;
        }

        .feature-icon.indigo {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(79, 70, 229, 0.15) 100%);
            color: #6366f1;
        }

        .ai-workspace {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 24px;
            padding: 2.5rem;
            min-height: 500px;
            border: 1px solid #e2e8f0;
            box-shadow: var(--shadow-lg);
        }

        .tool-panel {
            display: none;
        }

        .tool-panel.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .result-box {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 2rem;
            margin-top: 1.5rem;
            white-space: pre-wrap;
            font-size: 0.95rem;
            line-height: 1.8;
            max-height: 450px;
            overflow-y: auto;
            box-shadow: var(--shadow-sm);
            position: relative;
        }

        /* Custom scrollbar styling for result box */
        .result-box::-webkit-scrollbar {
            width: 10px;
        }

        .result-box::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .result-box::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        .result-box::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #059669 0%, #047857 100%);
        }

        /* Firefox scrollbar */
        .result-box {
            scrollbar-width: thin;
            scrollbar-color: #10b981 #f1f5f9;
        }

        .result-box .typewriter-content {
            display: inline;
        }

        .result-box .typing-cursor {
            display: inline-block;
            color: #10b981;
            font-weight: bold;
            animation: blink 0.7s infinite;
            margin-left: 2px;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
            }
        }

        .result-box.loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top-color: #10b981;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .quick-action {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-action:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
        }

        .lang-toggle {
            display: inline-flex;
            background: #e2e8f0;
            border-radius: 8px;
            padding: 4px;
        }

        .lang-toggle button {
            border: none;
            background: transparent;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .lang-toggle button.active {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .bd-flag {
            width: 20px;
            height: 14px;
            display: inline-block;
            margin-right: 6px;
            background: #006a4e;
            border-radius: 2px;
            position: relative;
        }

        .bd-flag::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: #f42a41;
            border-radius: 50%;
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%);
        }

        /* Dark mode overrides for AI features */
        html[data-theme="dark"] .ai-workspace {
            background: linear-gradient(135deg, #0a1628 0%, #0d1b30 100%);
            border-color: rgba(255, 255, 255, 0.08);
        }

        html[data-theme="dark"] .feature-card {
            background: rgba(11, 18, 32, 0.95);
            border-color: rgba(255, 255, 255, 0.08);
        }

        html[data-theme="dark"] .feature-card h6 {
            color: #e6eef8;
        }

        html[data-theme="dark"] .feature-card p {
            color: #94a3b8;
        }

        html[data-theme="dark"] .result-box {
            background: rgba(11, 18, 32, 0.95);
            border-color: rgba(255, 255, 255, 0.08);
            color: #e6eef8;
            scrollbar-color: #10b981 rgba(255, 255, 255, 0.05);
        }

        html[data-theme="dark"] .result-box::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        html[data-theme="dark"] .result-box::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            border-color: rgba(11, 18, 32, 0.95);
        }

        html[data-theme="dark"] .quick-action {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
        }

        html[data-theme="dark"] .quick-action:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        html[data-theme="dark"] .lang-toggle {
            background: rgba(255, 255, 255, 0.08);
        }

        html[data-theme="dark"] .lang-toggle button {
            color: #cbd5e1;
        }

        html[data-theme="dark"] .lang-toggle button.active {
            background: rgba(52, 211, 153, 0.2);
            color: #34d399;
        }

        /* Dark mode select and option styling */
        html[data-theme="dark"] .form-select,
        html[data-theme="dark"] select {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        html[data-theme="dark"] .form-select option,
        html[data-theme="dark"] select option {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .form-label,
        html[data-theme="dark"] label {
            color: #cbd5e1 !important;
        }

        html[data-theme="dark"] .tool-section h5,
        html[data-theme="dark"] .tool-section p,
        html[data-theme="dark"] .tool-section span {
            color: #e2e8f0 !important;
        }

        /* Dark mode input styling */
        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] input[type="text"],
        html[data-theme="dark"] input[type="number"],
        html[data-theme="dark"] input[type="date"],
        html[data-theme="dark"] textarea {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        html[data-theme="dark"] .form-control:focus,
        html[data-theme="dark"] input:focus,
        html[data-theme="dark"] textarea:focus {
            background-color: #1e293b !important;
            border-color: #3b82f6 !important;
            color: #e2e8f0 !important;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25) !important;
        }

        html[data-theme="dark"] .form-control::placeholder,
        html[data-theme="dark"] input::placeholder,
        html[data-theme="dark"] textarea::placeholder {
            color: #64748b !important;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="ai-hero">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="ai-hero-badge">
                            <span class="bd-flag"></span>
                            {{ __('messages.ai_hero_badge') }}
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-4" style="letter-spacing: -0.03em;">
                        {{ __('messages.ai_hero_title') }}
                    </h1>
                    <p class="lead opacity-75 mb-4" style="font-size: 1.25rem; line-height: 1.8; max-width: 600px;">
                        {{ __('messages.ai_hero_desc') }}
                    </p>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="position-relative">
                        <div
                            style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.05) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: float 3s ease-in-out infinite;">
                            <i class="bi bi-robot" style="font-size: 6rem; color: rgba(255,255,255,0.9);"></i>
                        </div>
                        <div
                            style="position: absolute; top: 10%; right: 10%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.875rem; animation: float 3s ease-in-out infinite; animation-delay: 0.5s;">
                            <i class="bi bi-cpu me-2" style="color: #10b981;"></i>Smart AI
                        </div>
                        <div
                            style="position: absolute; bottom: 10%; left: 0%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.875rem; animation: float 3s ease-in-out infinite; animation-delay: 1s;">
                            <i class="bi bi-translate me-2" style="color: #f59e0b;"></i>Bilingual
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Feature Cards -->
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-grid-3x3-gap me-2" style="color: #10b981;"></i>
                        {{ __('messages.select_ai_tools') }}
                    </h5>

                    <div class="row g-3">
                        <!-- Dhara Lookup -->
                        <div class="col-6">
                            <div class="feature-card active" data-tool="dhara" onclick="selectTool('dhara')">
                                <div class="feature-icon blue">
                                    <i class="bi bi-book"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_dhara') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_dhara_desc') }}</small>
                            </div>
                        </div>

                        <!-- Legal Terms -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="terms" onclick="selectTool('terms')">
                                <div class="feature-icon green">
                                    <i class="bi bi-translate"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_terms') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_terms_desc') }}</small>
                            </div>
                        </div>

                        <!-- Document Analysis -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="document" onclick="selectTool('document')">
                                <div class="feature-icon purple">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_document') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_document_desc') }}</small>
                            </div>
                        </div>

                        <!-- Case Predictor -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="case" onclick="selectTool('case')">
                                <div class="feature-icon orange">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_case') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_case_desc') }}</small>
                            </div>
                        </div>

                        <!-- Legal Procedure -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="procedure" onclick="selectTool('procedure')">
                                <div class="feature-icon teal">
                                    <i class="bi bi-list-check"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_procedure') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_procedure_desc') }}</small>
                            </div>
                        </div>

                        <!-- Rights Checker -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="rights" onclick="selectTool('rights')">
                                <div class="feature-icon red">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_rights') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_rights_desc') }}</small>
                            </div>
                        </div>

                        <!-- Draft Document -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="draft" onclick="selectTool('draft')">
                                <div class="feature-icon indigo">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_draft') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_draft_desc') }}</small>
                            </div>
                        </div>

                        <!-- General Question -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="question" onclick="selectTool('question')">
                                <div class="feature-icon blue">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_question') }}</h6>
                                <small class="text-muted">{{ __('messages.tool_question_desc') }}</small>
                            </div>
                        </div>

                        <!-- =========== EXTRAORDINARY AI FEATURES =========== -->

                        <!-- Inheritance Calculator -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="inheritance" onclick="selectTool('inheritance')">
                                <div class="feature-icon"
                                    style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(22, 163, 74, 0.15) 100%); color: #22c55e;">
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_inheritance') ?? 'Inheritance Calculator' }}
                                </h6>
                                <small
                                    class="text-muted">{{ __('messages.tool_inheritance_desc') ?? 'Islamic/Hindu Shares' }}</small>
                            </div>
                        </div>

                        <!-- Case Timeline Builder -->
                        <div class="col-6">
                            <div class="feature-card" data-tool="timeline" onclick="selectTool('timeline')">
                                <div class="feature-icon"
                                    style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(109, 40, 217, 0.15) 100%); color: #8b5cf6;">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ __('messages.tool_timeline') ?? 'Case Timeline' }}</h6>
                                <small
                                    class="text-muted">{{ __('messages.tool_timeline_desc') ?? 'Build Legal Timeline' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Workspace -->
                <div class="col-lg-8">
                    <div class="ai-workspace">
                        <!-- Dhara Tool -->
                        <div class="tool-panel active" id="tool-dhara">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-book text-primary me-2"></i>
                                {{ __('messages.dhara_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.dhara_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.law_name') }}</label>
                                <select class="form-select" id="dhara-law">
                                    <option value="{{ __('messages.penal_code_1860') }}">
                                        {{ __('messages.penal_code_1860') }}</option>
                                    <option value="{{ __('messages.crpc_1898') }}">{{ __('messages.crpc_1898') }}
                                    </option>
                                    <option value="{{ __('messages.cpc_1908') }}">{{ __('messages.cpc_1908') }}</option>
                                    <option value="{{ __('messages.evidence_act_1872') }}">
                                        {{ __('messages.evidence_act_1872') }}</option>
                                    <option value="{{ __('messages.property_transfer_act') }}">
                                        {{ __('messages.property_transfer_act') }}</option>
                                    <option value="{{ __('messages.contract_act_1872') }}">
                                        {{ __('messages.contract_act_1872') }}</option>
                                    <option value="{{ __('messages.women_children_act') }}">
                                        {{ __('messages.women_children_act') }}</option>
                                    <option value="{{ __('messages.family_court_ordinance') }}">
                                        {{ __('messages.family_court_ordinance') }}</option>
                                    <option value="{{ __('messages.labour_act_2006') }}">
                                        {{ __('messages.labour_act_2006') }}</option>
                                    <option value="{{ __('messages.consumer_rights_act') }}">
                                        {{ __('messages.consumer_rights_act') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.section_number') }}</label>
                                <input type="text" class="form-control" id="dhara-section"
                                    placeholder="{{ __('messages.section_placeholder') }}">
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="quick-action"
                                    onclick="setDhara('302')">{{ __('messages.section_302') }}</span>
                                <span class="quick-action"
                                    onclick="setDhara('420')">{{ __('messages.section_420') }}</span>
                                <span class="quick-action"
                                    onclick="setDhara('376')">{{ __('messages.section_376') }}</span>
                                <span class="quick-action"
                                    onclick="setDhara('497')">{{ __('messages.section_497') }}</span>
                            </div>

                            <button class="btn btn-primary px-4" onclick="searchDhara()">
                                <i class="bi bi-search me-2"></i>{{ __('messages.btn_search') }}
                            </button>

                            <div id="dhara-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Legal Terms Tool -->
                        <div class="tool-panel" id="tool-terms">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-translate text-success me-2"></i>
                                {{ __('messages.terms_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.terms_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.legal_term') }}</label>
                                <input type="text" class="form-control" id="term-input"
                                    placeholder="{{ __('messages.term_placeholder') }}">
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_bail') }}')">{{ __('messages.term_bail') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_heba') }}')">{{ __('messages.term_heba') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_waqf') }}')">{{ __('messages.term_waqf') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_heir') }}')">{{ __('messages.term_heir') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_deed') }}')">{{ __('messages.term_deed') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_joint') }}')">{{ __('messages.term_joint') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_complaint') }}')">{{ __('messages.term_complaint') }}</span>
                                <span class="quick-action"
                                    onclick="setTerm('{{ __('messages.term_plaint') }}')">{{ __('messages.term_plaint') }}</span>
                            </div>

                            <button class="btn btn-success px-4" onclick="searchTerm()">
                                <i class="bi bi-search me-2"></i>{{ __('messages.btn_meaning') }}
                            </button>

                            <div id="term-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Document Analysis Tool -->
                        <div class="tool-panel" id="tool-document">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-file-earmark-text text-purple me-2"></i>
                                {{ __('messages.document_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.document_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.analysis_type') }}</label>
                                <select class="form-select" id="analysis-type">
                                    <option value="summary">{{ __('messages.analysis_summary') }}</option>
                                    <option value="legal_issues">{{ __('messages.analysis_issues') }}</option>
                                    <option value="risks">{{ __('messages.analysis_risks') }}</option>
                                    <option value="recommendations">{{ __('messages.analysis_recommendations') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.document_text') }}</label>
                                <textarea class="form-control" id="document-text" rows="8"
                                    placeholder="{{ __('messages.document_placeholder') }}"></textarea>
                            </div>

                            <button class="btn btn-primary px-4" onclick="analyzeDocument()">
                                <i class="bi bi-cpu me-2"></i>{{ __('messages.btn_analyze') }}
                            </button>

                            <div id="document-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Case Analysis Tool -->
                        <div class="tool-panel" id="tool-case">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-graph-up-arrow text-warning me-2"></i>
                                {{ __('messages.case_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.case_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.case_type') }}</label>
                                <select class="form-select" id="case-type">
                                    <option value="{{ __('messages.case_criminal') }}">{{ __('messages.case_criminal') }}
                                    </option>
                                    <option value="{{ __('messages.case_civil') }}">{{ __('messages.case_civil') }}
                                    </option>
                                    <option value="{{ __('messages.case_family') }}">{{ __('messages.case_family') }}
                                    </option>
                                    <option value="{{ __('messages.case_labour') }}">{{ __('messages.case_labour') }}
                                    </option>
                                    <option value="{{ __('messages.case_property') }}">{{ __('messages.case_property') }}
                                    </option>
                                    <option value="{{ __('messages.case_consumer') }}">{{ __('messages.case_consumer') }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.case_facts') }}</label>
                                <textarea class="form-control" id="case-facts" rows="6" placeholder="{{ __('messages.case_placeholder') }}"></textarea>
                            </div>

                            <button class="btn btn-warning text-dark px-4" onclick="analyzeCase()">
                                <i class="bi bi-lightning me-2"></i>{{ __('messages.btn_predict') }}
                            </button>

                            <div id="case-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Legal Procedure Tool -->
                        <div class="tool-panel" id="tool-procedure">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-list-check text-info me-2"></i>
                                {{ __('messages.procedure_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.procedure_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.procedure_type') }}</label>
                                <select class="form-select" id="procedure-type">
                                    <option value="{{ __('messages.procedure_fir') }}">
                                        {{ __('messages.procedure_fir') }}</option>
                                    <option value="{{ __('messages.procedure_bail') }}">
                                        {{ __('messages.procedure_bail') }}</option>
                                    <option value="{{ __('messages.procedure_civil') }}">
                                        {{ __('messages.procedure_civil') }}</option>
                                    <option value="{{ __('messages.procedure_divorce') }}">
                                        {{ __('messages.procedure_divorce') }}</option>
                                    <option value="{{ __('messages.procedure_inheritance') }}">
                                        {{ __('messages.procedure_inheritance') }}</option>
                                    <option value="{{ __('messages.procedure_consumer') }}">
                                        {{ __('messages.procedure_consumer') }}</option>
                                    <option value="{{ __('messages.procedure_land') }}">
                                        {{ __('messages.procedure_land') }}</option>
                                    <option value="{{ __('messages.procedure_company') }}">
                                        {{ __('messages.procedure_company') }}</option>
                                </select>
                            </div>

                            <button class="btn btn-info text-white px-4" onclick="getProcedure()">
                                <i class="bi bi-arrow-right-circle me-2"></i>{{ __('messages.btn_guide') }}
                            </button>

                            <div id="procedure-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Rights Checker Tool -->
                        <div class="tool-panel" id="tool-rights">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-shield-check text-danger me-2"></i>
                                {{ __('messages.rights_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.rights_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.rights_category') }}</label>
                                <select class="form-select" id="rights-category">
                                    <option value="{{ __('messages.rights_arrest') }}">
                                        {{ __('messages.rights_arrest') }}</option>
                                    <option value="{{ __('messages.rights_women') }}">{{ __('messages.rights_women') }}
                                    </option>
                                    <option value="{{ __('messages.rights_children') }}">
                                        {{ __('messages.rights_children') }}</option>
                                    <option value="{{ __('messages.rights_consumer') }}">
                                        {{ __('messages.rights_consumer') }}</option>
                                    <option value="{{ __('messages.rights_property') }}">
                                        {{ __('messages.rights_property') }}</option>
                                    <option value="{{ __('messages.rights_labour') }}">
                                        {{ __('messages.rights_labour') }}</option>
                                    <option value="{{ __('messages.rights_cyber') }}">{{ __('messages.rights_cyber') }}
                                    </option>
                                </select>
                            </div>

                            <button class="btn btn-danger px-4" onclick="checkRights()">
                                <i class="bi bi-shield-check me-2"></i>{{ __('messages.btn_check_rights') }}
                            </button>

                            <div id="rights-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Draft Document Tool -->
                        <div class="tool-panel" id="tool-draft">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-pencil-square text-indigo me-2"></i>
                                {{ __('messages.draft_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.draft_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.draft_type') }}</label>
                                <select class="form-select" id="draft-type">
                                    <option value="legal_notice">{{ __('messages.draft_legal_notice') }}</option>
                                    <option value="application">{{ __('messages.draft_application') }}</option>
                                    <option value="complaint">{{ __('messages.draft_complaint') }}</option>
                                    <option value="contract">{{ __('messages.draft_agreement') }}</option>
                                    <option value="affidavit">{{ __('messages.draft_affidavit') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.draft_details') }}</label>
                                <textarea class="form-control" id="draft-details" rows="6"
                                    placeholder="{{ __('messages.draft_placeholder') }}"></textarea>
                            </div>

                            <button class="btn btn-primary px-4" onclick="draftDocument()">
                                <i class="bi bi-file-earmark-plus me-2"></i>{{ __('messages.btn_draft') }}
                            </button>

                            <div id="draft-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- General Question Tool -->
                        <div class="tool-panel" id="tool-question">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-chat-dots text-primary me-2"></i>
                                {{ __('messages.question_title') }}
                            </h5>
                            <p class="text-muted mb-4">{{ __('messages.question_desc') }}</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('messages.your_question') }}</label>
                                <textarea class="form-control" id="question-input" rows="4"
                                    placeholder="{{ __('messages.question_placeholder') }}"></textarea>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">{{ __('messages.sample_questions') }}:</small>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="quick-action"
                                        onclick="setQuestion('{{ __('messages.sample_q1') }}')">{{ __('messages.sample_q1') }}</span>
                                    <span class="quick-action"
                                        onclick="setQuestion('{{ __('messages.sample_q2') }}')">{{ __('messages.sample_q2') }}</span>
                                    <span class="quick-action"
                                        onclick="setQuestion('{{ __('messages.sample_q3') }}')">{{ __('messages.sample_q3') }}</span>
                                </div>
                            </div>

                            <button class="btn btn-primary px-4" onclick="askQuestion()">
                                <i class="bi bi-send me-2"></i>{{ __('messages.btn_ask') }}
                            </button>

                            <div id="question-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- =========== EXTRAORDINARY AI TOOL PANELS =========== -->

                        <!-- Inheritance Calculator Tool Panel -->
                        <div class="tool-panel" id="tool-inheritance">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-diagram-3 me-2" style="color: #22c55e;"></i>
                                {{ Lang::has('messages.inheritance_title') ? __('messages.inheritance_title') : 'Inheritance Calculator' }}
                            </h5>
                            <p class="text-muted mb-4">
                                {{ Lang::has('messages.inheritance_desc') ? __('messages.inheritance_desc') : 'Calculate inheritance shares according to Islamic (Faraid) or Hindu Succession Law of Bangladesh' }}
                            </p>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.law_system') ? __('messages.law_system') : 'Inheritance Law System' }}</label>
                                    <select class="form-select" id="inheritance-system">
                                        <option value="islamic">
                                            {{ Lang::has('messages.islamic_faraid') ? __('messages.islamic_faraid') : 'Islamic Law (ফারায়েজ)' }}
                                        </option>
                                        <option value="hindu">
                                            {{ Lang::has('messages.hindu_succession') ? __('messages.hindu_succession') : 'Hindu Succession Law' }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.deceased_gender') ? __('messages.deceased_gender') : 'Deceased Gender' }}</label>
                                    <select class="form-select" id="inheritance-gender">
                                        <option value="male">
                                            {{ Lang::has('messages.male') ? __('messages.male') : 'Male (পুরুষ)' }}
                                        </option>
                                        <option value="female">
                                            {{ Lang::has('messages.female') ? __('messages.female') : 'Female (মহিলা)' }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.total_estate') ? __('messages.total_estate') : 'Total Estate Value (৳)' }}</label>
                                    <input type="number" class="form-control" id="inheritance-estate"
                                        placeholder="e.g., 5000000">
                                </div>
                                <div class="col-md-4">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.sons') ? __('messages.sons') : 'Number of Sons' }}</label>
                                    <input type="number" class="form-control" id="inheritance-sons" value="0"
                                        min="0">
                                </div>
                                <div class="col-md-4">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.daughters') ? __('messages.daughters') : 'Number of Daughters' }}</label>
                                    <input type="number" class="form-control" id="inheritance-daughters" value="0"
                                        min="0">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inheritance-spouse">
                                        <label class="form-check-label" for="inheritance-spouse">
                                            {{ Lang::has('messages.has_spouse') ? __('messages.has_spouse') : 'Spouse Alive (স্বামী/স্ত্রী)' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inheritance-mother">
                                        <label class="form-check-label" for="inheritance-mother">
                                            {{ Lang::has('messages.has_mother') ? __('messages.has_mother') : 'Mother Alive (মা)' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inheritance-father">
                                        <label class="form-check-label" for="inheritance-father">
                                            {{ Lang::has('messages.has_father') ? __('messages.has_father') : 'Father Alive (বাবা)' }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button class="btn px-4"
                                style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white;"
                                onclick="calculateInheritance()">
                                <i
                                    class="bi bi-calculator me-2"></i>{{ Lang::has('messages.btn_calculate_inheritance') ? __('messages.btn_calculate_inheritance') : 'Calculate Shares' }}
                            </button>

                            <div id="inheritance-result" class="result-box" style="display: none;"></div>
                        </div>

                        <!-- Case Timeline Builder Tool Panel -->
                        <div class="tool-panel" id="tool-timeline">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-clock-history me-2" style="color: #8b5cf6;"></i>
                                {{ Lang::has('messages.timeline_title') ? __('messages.timeline_title') : 'Case Timeline Builder' }}
                            </h5>
                            <p class="text-muted mb-4">
                                {{ Lang::has('messages.timeline_desc') ? __('messages.timeline_desc') : 'Build a comprehensive legal timeline with key events, deadlines, and limitation periods' }}
                            </p>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.case_nature') ? __('messages.case_nature') : 'Case Nature' }}</label>
                                    <select class="form-select" id="timeline-nature">
                                        <option value="civil">
                                            {{ Lang::has('messages.nature_civil') ? __('messages.nature_civil') : 'Civil Suit' }}
                                        </option>
                                        <option value="criminal">
                                            {{ Lang::has('messages.nature_criminal') ? __('messages.nature_criminal') : 'Criminal Case' }}
                                        </option>
                                        <option value="family">
                                            {{ Lang::has('messages.nature_family') ? __('messages.nature_family') : 'Family Court Case' }}
                                        </option>
                                        <option value="labor">
                                            {{ Lang::has('messages.nature_labor') ? __('messages.nature_labor') : 'Labor Court Case' }}
                                        </option>
                                        <option value="writ">
                                            {{ Lang::has('messages.nature_writ') ? __('messages.nature_writ') : 'Writ Petition' }}
                                        </option>
                                        <option value="company">
                                            {{ Lang::has('messages.nature_company') ? __('messages.nature_company') : 'Company Law Matter' }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-semibold">{{ Lang::has('messages.start_date') ? __('messages.start_date') : 'Incident/Case Start Date' }}</label>
                                    <input type="date" class="form-control" id="timeline-startdate">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label
                                    class="form-label fw-semibold">{{ Lang::has('messages.events_description') ? __('messages.events_description') : 'Events Description' }}</label>
                                <textarea class="form-control" id="timeline-events" rows="5"
                                    placeholder="{{ Lang::has('messages.timeline_placeholder') ? __('messages.timeline_placeholder') : 'List all events with dates: incident occurred, FIR filed, arrest made, bail obtained, hearing dates, evidence submitted...' }}"></textarea>
                            </div>

                            <button class="btn px-4"
                                style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;"
                                onclick="buildCaseTimeline()">
                                <i
                                    class="bi bi-clock-history me-2"></i>{{ Lang::has('messages.btn_build_timeline') ? __('messages.btn_build_timeline') : 'Build Timeline' }}
                            </button>

                            <div id="timeline-result" class="result-box" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .upload-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.02) 0%, rgba(220, 38, 38, 0.02) 100%);
        }

        .upload-zone:hover {
            border-color: #ef4444;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(220, 38, 38, 0.05) 100%);
        }

        .upload-zone.dragover {
            border-color: #ef4444;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
            transform: scale(1.02);
        }

        .upload-zone.has-file {
            border-color: #22c55e;
            border-style: solid;
        }

        html[data-theme="dark"] .upload-zone {
            border-color: rgba(255, 255, 255, 0.1);
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(220, 38, 38, 0.05) 100%);
        }

        html[data-theme="dark"] .upload-zone:hover {
            border-color: #ef4444;
        }

        /* Scroll indicator for result box */
        .result-box-wrapper {
            position: relative;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0) 100%);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 8px;
            pointer-events: none;
            border-radius: 0 0 16px 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .scroll-indicator.visible {
            opacity: 1;
        }

        .scroll-indicator span {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            color: #10b981;
            font-weight: 500;
            animation: bounceDown 1.5s infinite;
        }

        .scroll-indicator span i {
            font-size: 1rem;
        }

        @keyframes bounceDown {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(4px);
            }
        }

        html[data-theme="dark"] .scroll-indicator {
            background: linear-gradient(to top, rgba(11, 18, 32, 0.98) 0%, rgba(11, 18, 32, 0) 100%);
        }
    </style>
@endpush

@push('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const currentLang = '{{ app()->getLocale() }}';

        function selectTool(tool) {
            document.querySelectorAll('.feature-card').forEach(card => {
                card.classList.toggle('active', card.dataset.tool === tool);
            });
            document.querySelectorAll('.tool-panel').forEach(panel => {
                panel.classList.toggle('active', panel.id === 'tool-' + tool);
            });

            // Scroll to the tool panel for better UX (with offset for fixed navbar)
            const toolPanel = document.getElementById('tool-' + tool);
            if (toolPanel) {
                setTimeout(() => {
                    const navbarHeight = 80; // Account for fixed navbar
                    const elementPosition = toolPanel.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navbarHeight;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }, 100);
            }
        }

        function showLoading(elementId) {
            const el = document.getElementById(elementId);
            el.style.display = 'block';
            el.classList.add('loading');
            el.innerHTML = '<div class="loading-spinner"></div>';
        }

        function showResult(elementId, content) {
            const el = document.getElementById(elementId);
            el.classList.remove('loading');

            // Wrap result box in a wrapper if not already wrapped
            if (!el.parentElement.classList.contains('result-box-wrapper')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'result-box-wrapper';
                el.parentNode.insertBefore(wrapper, el);
                wrapper.appendChild(el);

                // Add scroll indicator
                const indicator = document.createElement('div');
                indicator.className = 'scroll-indicator';
                indicator.innerHTML = '<span><i class="bi bi-chevron-double-down"></i> ' +
                    (currentLang === 'bn' ? 'আরও দেখতে স্ক্রল করুন' : 'Scroll for more') + '</span>';
                wrapper.appendChild(indicator);
            }

            const wrapper = el.parentElement;
            const indicator = wrapper.querySelector('.scroll-indicator');

            // Format the content first
            const formattedContent = formatResult(content);

            // Create a wrapper for the typewriter effect
            el.innerHTML = '<div class="typewriter-content"></div><span class="typing-cursor">|</span>';
            const contentEl = el.querySelector('.typewriter-content');
            const cursorEl = el.querySelector('.typing-cursor');

            // Handle scroll indicator visibility
            function updateScrollIndicator() {
                if (indicator) {
                    const isScrollable = el.scrollHeight > el.clientHeight;
                    const isAtBottom = el.scrollHeight - el.scrollTop - el.clientHeight < 30;
                    indicator.classList.toggle('visible', isScrollable && !isAtBottom);
                }
            }

            el.addEventListener('scroll', updateScrollIndicator);

            // Track if user has manually scrolled up
            let userScrolledUp = false;
            let lastScrollTop = 0;

            el.addEventListener('scroll', function() {
                // Detect if user scrolled up manually
                if (el.scrollTop < lastScrollTop) {
                    userScrolledUp = true;
                }
                // Reset if user scrolls back to bottom
                const isAtBottom = el.scrollHeight - el.scrollTop - el.clientHeight < 50;
                if (isAtBottom) {
                    userScrolledUp = false;
                }
                lastScrollTop = el.scrollTop;
            });

            // Typewriter effect - character by character
            let i = 0;
            const plainText = content;
            const speed = 15; // milliseconds per character (faster = lower number)

            function typeWriter() {
                if (i < plainText.length) {
                    // Add character and format progressively
                    const currentText = plainText.substring(0, i + 1);
                    contentEl.innerHTML = formatResult(currentText);
                    i++;

                    // Only auto-scroll if user hasn't scrolled up manually
                    if (!userScrolledUp) {
                        el.scrollTop = el.scrollHeight;
                    }

                    // Update scroll indicator
                    updateScrollIndicator();

                    // Vary speed slightly for natural feel
                    const variance = Math.random() * 10;
                    setTimeout(typeWriter, speed + variance);
                } else {
                    // Remove cursor when done
                    cursorEl.style.display = 'none';

                    // Show scroll indicator after typing completes (don't force scroll)
                    setTimeout(() => {
                        updateScrollIndicator();
                    }, 300);
                }
            }

            typeWriter();
        }

        function showError(elementId, message) {
            const el = document.getElementById(elementId);
            el.classList.remove('loading');
            el.innerHTML =
                `<div class="alert alert-danger mb-0"><i class="bi bi-exclamation-triangle me-2"></i>${message}</div>`;
        }

        function formatResult(text) {
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/^### (.*$)/gm, '<h5 class="mt-3 mb-2 text-primary">$1</h5>')
                .replace(/^## (.*$)/gm, '<h4 class="mt-3 mb-2 text-primary">$1</h4>')
                .replace(/^# (.*$)/gm, '<h3 class="mt-3 mb-2 text-primary">$1</h3>')
                .replace(/^- (.*$)/gm, '<li>$1</li>')
                .replace(/^(\d+)\. (.*$)/gm, '<li><strong>$1.</strong> $2</li>')
                .replace(/\n\n/g, '<br><br>');
        }

        async function makeRequest(url, data) {
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ...data,
                        language: currentLang
                    })
                });

                const result = await response.json();

                // If server returned an error, throw it so it can be caught
                if (!response.ok && !result.ok) {
                    throw new Error(result.error || 'Server error');
                }

                return result;
            } catch (error) {
                // Check if it's a network error or a server error
                if (error.name === 'TypeError' && error.message.includes('fetch')) {
                    throw new Error(currentLang === 'bn' ? 'নেটওয়ার্ক ত্রুটি। অনুগ্রহ করে আপনার সংযোগ পরীক্ষা করুন।' :
                        'Network error. Please check your connection.');
                }
                throw error;
            }
        }

        // Dhara Functions
        function setDhara(section) {
            document.getElementById('dhara-section').value = section;
        }

        async function searchDhara() {
            const law = document.getElementById('dhara-law').value;
            const section = document.getElementById('dhara-section').value;

            if (!section) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে ধারা নম্বর লিখুন' : 'Please enter a section number');
                return;
            }

            showLoading('dhara-result');

            try {
                const data = await makeRequest('/ai/dhara', {
                    law_name: law,
                    section: section
                });
                if (data.ok) {
                    showResult('dhara-result', data.result);
                } else {
                    showError('dhara-result', data.error);
                }
            } catch (e) {
                showError('dhara-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Term Functions
        function setTerm(term) {
            document.getElementById('term-input').value = term;
        }

        async function searchTerm() {
            const term = document.getElementById('term-input').value;

            if (!term) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে একটি শব্দ লিখুন' : 'Please enter a term');
                return;
            }

            showLoading('term-result');

            try {
                const data = await makeRequest('/ai/legal-term', {
                    term: term
                });
                if (data.ok) {
                    showResult('term-result', data.result);
                } else {
                    showError('term-result', data.error);
                }
            } catch (e) {
                showError('term-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Document Analysis
        async function analyzeDocument() {
            const text = document.getElementById('document-text').value;
            const type = document.getElementById('analysis-type').value;

            if (!text) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে দলিলের টেক্সট পেস্ট করুন' : 'Please paste document text');
                return;
            }

            showLoading('document-result');

            try {
                const data = await makeRequest('/ai/analyze-document', {
                    document_text: text,
                    analysis_type: type
                });
                if (data.ok) {
                    showResult('document-result', data.result);
                } else {
                    showError('document-result', data.error);
                }
            } catch (e) {
                showError('document-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Case Analysis
        async function analyzeCase() {
            const caseType = document.getElementById('case-type').value;
            const facts = document.getElementById('case-facts').value;

            if (!facts) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে মামলার তথ্য লিখুন' : 'Please enter case details');
                return;
            }

            showLoading('case-result');

            try {
                const data = await makeRequest('/ai/predict-case', {
                    case_type: caseType,
                    facts: facts
                });
                if (data.ok) {
                    showResult('case-result', data.result);
                } else {
                    showError('case-result', data.error);
                }
            } catch (e) {
                showError('case-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Procedure
        async function getProcedure() {
            const procedure = document.getElementById('procedure-type').value;

            showLoading('procedure-result');

            try {
                const data = await makeRequest('/ai/procedure', {
                    procedure_type: procedure
                });
                if (data.ok) {
                    showResult('procedure-result', data.result);
                } else {
                    showError('procedure-result', data.error);
                }
            } catch (e) {
                showError('procedure-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Rights Checker
        async function checkRights() {
            const category = document.getElementById('rights-category').value;

            showLoading('rights-result');

            try {
                const data = await makeRequest('/ai/check-rights', {
                    category: category
                });
                if (data.ok) {
                    showResult('rights-result', data.result);
                } else {
                    showError('rights-result', data.error);
                }
            } catch (e) {
                showError('rights-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Draft Document
        async function draftDocument() {
            const type = document.getElementById('draft-type').value;
            const details = document.getElementById('draft-details').value;

            if (!details) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে বিস্তারিত তথ্য দিন' : 'Please provide details');
                return;
            }

            showLoading('draft-result');

            try {
                const data = await makeRequest('/ai/draft-document', {
                    document_type: type,
                    details: details
                });
                if (data.ok) {
                    showResult('draft-result', data.result);
                } else {
                    showError('draft-result', data.error);
                }
            } catch (e) {
                showError('draft-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // General Question
        function setQuestion(question) {
            document.getElementById('question-input').value = question;
        }

        async function askQuestion() {
            const question = document.getElementById('question-input').value;

            if (!question) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে আপনার প্রশ্ন লিখুন' : 'Please enter your question');
                return;
            }

            showLoading('question-result');

            try {
                const data = await makeRequest('/ai/question', {
                    question: question
                });
                if (data.ok) {
                    showResult('question-result', data.result);
                } else {
                    showError('question-result', data.error);
                }
            } catch (e) {
                showError('question-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // =====================================================
        // EXTRAORDINARY AI FEATURES - 2 New Tools
        // =====================================================

        // Inheritance Calculator
        async function calculateInheritance() {
            const system = document.getElementById('inheritance-system').value;
            const gender = document.getElementById('inheritance-gender').value;
            const estate = document.getElementById('inheritance-estate').value;
            const sons = parseInt(document.getElementById('inheritance-sons').value) || 0;
            const daughters = parseInt(document.getElementById('inheritance-daughters').value) || 0;
            const hasSpouse = document.getElementById('inheritance-spouse').checked;
            const hasMother = document.getElementById('inheritance-mother').checked;
            const hasFather = document.getElementById('inheritance-father').checked;

            if (!estate || estate <= 0) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে সম্পত্তির মূল্য দিন' : 'Please enter estate value');
                return;
            }

            showLoading('inheritance-result');

            try {
                const data = await makeRequest('/ai/inheritance', {
                    law_system: system,
                    deceased_gender: gender,
                    estate_value: parseFloat(estate),
                    sons: sons,
                    daughters: daughters,
                    has_spouse: hasSpouse,
                    has_mother: hasMother,
                    has_father: hasFather,
                    language: currentLang
                });
                if (data.ok) {
                    showResult('inheritance-result', data.result);
                } else {
                    showError('inheritance-result', data.error);
                }
            } catch (e) {
                showError('inheritance-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }

        // Case Timeline Builder
        async function buildCaseTimeline() {
            const nature = document.getElementById('timeline-nature').value;
            const startDate = document.getElementById('timeline-startdate').value;
            const events = document.getElementById('timeline-events').value;

            if (!events) {
                alert(currentLang === 'bn' ? 'অনুগ্রহ করে ঘটনাগুলো বর্ণনা করুন' : 'Please describe the events');
                return;
            }

            showLoading('timeline-result');

            try {
                const data = await makeRequest('/ai/case-timeline', {
                    case_nature: nature,
                    start_date: startDate,
                    events_description: events,
                    language: currentLang
                });
                if (data.ok) {
                    showResult('timeline-result', data.result);
                } else {
                    showError('timeline-result', data.error);
                }
            } catch (e) {
                showError('timeline-result', currentLang === 'bn' ? 'একটি ত্রুটি হয়েছে। আবার চেষ্টা করুন।' :
                    'An error occurred. Please try again.');
            }
        }
    </script>
@endpush
