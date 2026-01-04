<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LawLite') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Premium Font Stack: Same as landing.blade.php -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Advanced UI Styles -->
    <link rel="stylesheet" href="{{ asset('css/advanced-ui.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* ========== LIGHT MODE (Default) - Clean White/Teal ========== */
        :root {
            --primary: #0f172a;
            --primary-hover: #1e293b;
            --accent: #10b981;
            --accent-light: rgba(16, 185, 129, 0.1);
            --accent-glow: rgba(16, 185, 129, 0.25);
            --muted: #64748b;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --bg-body: #f1f5f9;
            --bg-card: #ffffff;
            --bg-card-hover: #f8fafc;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);

            /* Premium Font Variables - Same as landing */
            --font-display: 'Outfit', 'Space Grotesk', system-ui, sans-serif;
            --font-body: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            --font-mono: 'JetBrains Mono', 'Fira Code', monospace;
            --font-bengali: 'Noto Sans Bengali', 'Hind Siliguri', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Bengali language support */
        html[lang="bn"] body,
        html[lang="bn"] p,
        html[lang="bn"] span,
        html[lang="bn"] label,
        html[lang="bn"] .form-control,
        html[lang="bn"] .form-select,
        html[lang="bn"] .btn,
        html[lang="bn"] .nav-link,
        html[lang="bn"] .dropdown-item,
        html[lang="bn"] .list-group-item {
            font-family: var(--font-bengali), var(--font-body);
        }

        body {
            font-family: var(--font-body);
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.16), transparent 55%),
                radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.16), transparent 55%),
                var(--bg-body);
            color: var(--text-secondary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.7;
            transition: background-color 0.35s ease, color 0.35s ease, background 0.6s ease;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-display);
            color: var(--text-primary);
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        /* Navbar - Light Mode */
        .site-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .site-header.scrolled {
            box-shadow: var(--shadow-md);
            border-bottom-color: rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .nav-link {
            color: var(--text-muted) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--accent) !important;
            background: var(--accent-light);
        }

        .nav-link.active {
            color: var(--accent) !important;
            background: var(--accent-light);
            font-weight: 600;
        }

        /* Cards - Light Mode */
        .card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            box-shadow: var(--shadow-sm);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            transform-origin: center;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.06) 0%, transparent 55%);
            opacity: 0;
            transition: opacity 0.35s ease;
            pointer-events: none;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            border-color: rgba(16, 185, 129, 0.25);
            transform: translateY(-6px);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            padding: 1rem 1.25rem;
            color: var(--text-primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons - Emerald Accent */
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px var(--accent-glow);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            box-shadow: 0 4px 16px var(--accent-glow);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            color: var(--accent);
            border: 2px solid var(--accent);
            background: transparent;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-outline-primary:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
            box-shadow: 0 2px 8px var(--accent-glow);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            box-shadow: 0 2px 8px var(--accent-glow);
        }

        .btn-accent {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            font-weight: 600;
            box-shadow: 0 2px 8px var(--accent-glow);
        }

        .btn-accent:hover {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: white;
        }

        /* Form Inputs */
        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.95);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: #ffffff;
            transform: translateY(-1px);
        }

        /* List Groups */
        .list-group-item {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .list-group-item-action:hover {
            background-color: var(--bg-card-hover);
            border-color: rgba(16, 185, 129, 0.15);
        }

        /* Tables */
        .table {
            color: var(--text-secondary);
        }

        .table> :not(caption)>*>* {
            background-color: var(--bg-card);
            border-bottom-color: var(--border-color);
        }

        .table-hover>tbody>tr:hover>* {
            background-color: var(--bg-card-hover);
        }

        .table thead th {
            background-color: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
            border-bottom: 2px solid rgba(16, 185, 129, 0.2);
        }

        /* Dropdowns */
        .dropdown-menu {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-secondary);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--accent-light);
            color: var(--accent);
        }

        .dropdown-item.active {
            background-color: var(--accent);
            color: #ffffff;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            border-radius: 6px;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .alert-info {
            background-color: rgba(6, 182, 212, 0.1);
            color: #0891b2;
        }

        /* Text utilities */
        .text-primary {
            color: var(--accent) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .small-muted {
            color: var(--muted);
        }

        .bg-primary {
            background-color: var(--accent) !important;
        }

        .border-primary {
            border-color: var(--accent) !important;
        }

        /* ========== PREMIUM LOGO STYLES ========== */
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo-text,
        .brand-text {
            font-family: 'Outfit', 'Space Grotesk', 'Inter', system-ui, sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.03em;
            display: flex;
            align-items: baseline;
        }

        .logo-text .law {
            color: #0f172a;
            position: relative;
        }

        .logo-text .lite {
            color: #10b981;
            position: relative;
        }

        .logo-icon-wrapper {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #0891b2 100%);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5), 0 0 40px rgba(16, 185, 129, 0.3), inset 0 0 20px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .logo-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
            border-radius: 50%;
        }

        .logo:hover .logo-icon-wrapper {
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.5);
            transform: translateY(-2px);
        }

        .logo-icon-inner {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon-inner svg {
            width: 28px;
            height: 28px;
            color: white;
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon-inner svg {
            transform: scale(1.1);
        }

        /* Avatar */
        .avatar-circle {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        /* Pagination */
        .page-link {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-secondary);
            border-radius: 8px;
            margin: 0 2px;
        }

        .page-link:hover {
            background-color: var(--accent-light);
            border-color: var(--accent);
            color: var(--accent);
        }

        .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
        }

        /* Scrollbar - Light */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Selection */
        ::selection {
            background: var(--accent);
            color: #ffffff;
        }

        /* ===== Advanced Background Ornaments (App) ===== */
        .app-orbit {
            position: fixed;
            inset: -120px;
            pointer-events: none;
            z-index: -1;
        }

        .app-orbit__blob {
            position: absolute;
            width: 440px;
            height: 440px;
            border-radius: 60% 40% 30% 70% / 55% 35% 65% 45%;
            background: radial-gradient(circle at 10% 0%, rgba(59, 130, 246, 0.14), transparent 55%),
                radial-gradient(circle at 80% 100%, rgba(16, 185, 129, 0.18), transparent 55%);
            filter: blur(32px);
            opacity: 0.6;
            animation: app-orbit-morph 18s ease-in-out infinite alternate;
        }

        .app-orbit__blob--top {
            top: -120px;
            left: -80px;
        }

        .app-orbit__blob--bottom {
            bottom: -120px;
            right: -80px;
            animation-delay: 4s;
        }

        @keyframes app-orbit-morph {
            0% {
                transform: translate3d(0, 0, 0) scale(1);
                border-radius: 60% 40% 30% 70% / 55% 35% 65% 45%;
            }

            50% {
                transform: translate3d(20px, -10px, 0) scale(1.04);
                border-radius: 40% 60% 65% 35% / 50% 60% 30% 60%;
            }

            100% {
                transform: translate3d(-10px, 20px, 0) scale(1.02);
                border-radius: 55% 45% 35% 65% / 65% 30% 60% 40%;
            }
        }

        /* ===== Reusable Motion Utilities (dashboards, tables, etc.) ===== */
        .reveal,
        .reveal-left,
        .reveal-right,
        .reveal-scale {
            opacity: 0;
            transform: translateY(24px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-left {
            transform: translateX(-32px);
        }

        .reveal-right {
            transform: translateX(32px);
        }

        .reveal-scale {
            transform: scale(0.94);
        }

        .reveal.active,
        .reveal-left.active,
        .reveal-right.active,
        .reveal-scale.active {
            opacity: 1;
            transform: translateX(0) translateY(0) scale(1);
        }

        .stagger-1 {
            transition-delay: 0.08s;
        }

        .stagger-2 {
            transition-delay: 0.16s;
        }

        .stagger-3 {
            transition-delay: 0.24s;
        }

        .stagger-4 {
            transition-delay: 0.32s;
        }

        .stagger-5 {
            transition-delay: 0.4s;
        }

        .page-section-title {
            font-family: var(--font-display);
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .page-subtitle {
            color: var(--text-muted);
        }

        /* ========== PREMIUM DARK TEAL THEME ========== */
        html[data-theme="dark"] {
            --primary: #f0fdfa;
            --primary-hover: #ccfbf1;
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.4);
            --muted: #5eead4;
            --border-color: rgba(45, 212, 191, 0.15);
            --bg-body: #0a1628;
            --bg-card: #0f2132;
            --bg-card-hover: #143048;
            --text-primary: #f0fdfa;
            --text-secondary: #99f6e4;
            --text-muted: #5eead4;
        }

        html[data-theme="dark"] body {
            background: linear-gradient(180deg, #020617 0%, #020617 12%, #020617 100%);
            background-attachment: fixed;
            color: var(--text-secondary);
        }

        html[data-theme="dark"] h1,
        html[data-theme="dark"] h2,
        html[data-theme="dark"] h3,
        html[data-theme="dark"] h4,
        html[data-theme="dark"] h5,
        html[data-theme="dark"] h6 {
            color: var(--text-primary);
        }

        /* Header / Navbar */
        html[data-theme="dark"] .site-header {
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }

        html[data-theme="dark"] .nav-link {
            color: var(--text-muted) !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        html[data-theme="dark"] .nav-link:hover {
            color: var(--accent) !important;
        }

        html[data-theme="dark"] .nav-link.active {
            color: var(--accent) !important;
            text-shadow: 0 0 12px var(--accent-glow);
        }

        /* Cards with glassmorphism */
        html[data-theme="dark"] .card {
            background: rgba(15, 33, 50, 0.96);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.7);
        }

        html[data-theme="dark"] .card:hover {
            background: var(--bg-card-hover);
            border-color: rgba(16, 185, 129, 0.45);
        }

        html[data-theme="dark"] .card-header {
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            background: transparent;
        }

        html[data-theme="dark"] .card-body {
            color: var(--text-secondary);
        }

        /* List groups */
        html[data-theme="dark"] .list-group-item {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-secondary);
        }

        html[data-theme="dark"] .list-group-item.bg-light {
            background-color: var(--bg-card-hover) !important;
        }

        html[data-theme="dark"] .list-group-item-action:hover {
            background-color: var(--bg-card-hover);
            border-color: rgba(16, 185, 129, 0.25);
        }

        /* Form inputs with glow effect */
        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] .form-select {
            background-color: rgba(15, 33, 50, 0.8);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        html[data-theme="dark"] .form-control::placeholder {
            color: rgba(94, 234, 212, 0.5);
        }

        html[data-theme="dark"] .form-control:focus,
        html[data-theme="dark"] .form-select:focus {
            background-color: rgba(15, 33, 50, 0.95);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            color: var(--text-primary);
        }

        /* Buttons - Emerald accent */
        html[data-theme="dark"] .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 14px var(--accent-glow);
            transition: all 0.3s ease;
        }

        html[data-theme="dark"] .btn-primary:hover {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            box-shadow: 0 6px 20px var(--accent-glow);
            transform: translateY(-1px);
        }

        html[data-theme="dark"] .btn-outline-primary {
            color: var(--accent);
            border-color: var(--accent);
            background: transparent;
        }

        html[data-theme="dark"] .btn-outline-primary:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #0a1628;
            box-shadow: 0 4px 14px var(--accent-glow);
        }

        html[data-theme="dark"] .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            box-shadow: 0 4px 14px var(--accent-glow);
        }

        /* Text utilities */
        html[data-theme="dark"] .text-muted {
            color: var(--text-muted) !important;
        }

        html[data-theme="dark"] .text-dark {
            color: var(--text-primary) !important;
        }

        html[data-theme="dark"] .text-primary {
            color: var(--accent) !important;
        }

        /* Backgrounds */
        html[data-theme="dark"] .bg-light {
            background-color: var(--bg-card-hover) !important;
        }

        html[data-theme="dark"] .bg-white {
            background-color: var(--bg-card) !important;
        }

        /* Dropdowns */
        html[data-theme="dark"] .dropdown-menu {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        html[data-theme="dark"] .dropdown-item {
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        html[data-theme="dark"] .dropdown-item:hover {
            background-color: var(--bg-card-hover);
            color: var(--accent);
        }

        html[data-theme="dark"] .dropdown-item.active {
            background-color: var(--accent);
            color: #0a1628;
        }

        /* Tables */
        html[data-theme="dark"] .table {
            color: var(--text-secondary);
        }

        html[data-theme="dark"] .table> :not(caption)>*>* {
            background-color: var(--bg-card);
            border-bottom-color: var(--border-color);
            color: var(--text-secondary);
        }

        html[data-theme="dark"] .table-hover>tbody>tr:hover>* {
            background-color: var(--bg-card-hover);
        }

        html[data-theme="dark"] .table thead th {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            font-weight: 600;
        }

        /* Badges */
        html[data-theme="dark"] .badge.bg-light {
            background-color: var(--bg-card-hover) !important;
            color: var(--text-secondary) !important;
        }

        html[data-theme="dark"] .badge.bg-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        html[data-theme="dark"] .badge.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        html[data-theme="dark"] .badge.bg-info {
            background: rgba(16, 185, 129, 0.2) !important;
            color: var(--accent) !important;
        }

        /* Shadows and borders */
        html[data-theme="dark"] .shadow-sm {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
        }

        html[data-theme="dark"] .border-bottom {
            border-bottom-color: var(--border-color) !important;
        }

        html[data-theme="dark"] .border {
            border-color: var(--border-color) !important;
        }

        /* Logo */
        html[data-theme="dark"] .logo-text .law {
            color: #ffffff !important;
        }

        html[data-theme="dark"] .logo-text .lite {
            color: #10b981 !important;
        }

        html[data-theme="dark"] .logo-icon-wrapper {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #0891b2 100%);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5), 0 0 40px rgba(16, 185, 129, 0.3);
        }

        html[data-theme="dark"] .logo-icon-inner svg {
            color: #ffffff;
        }

        /* Avatar */
        html[data-theme="dark"] .avatar-circle {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 2px 12px var(--accent-glow);
        }

        /* Footer */
        html[data-theme="dark"] footer.bg-dark {
            background: radial-gradient(circle at top, #022c22 0%, #020617 50%, #020617 100%) !important;
            border-top: 1px solid var(--border-color);
        }

        /* Alert boxes */
        html[data-theme="dark"] .alert {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-secondary);
        }

        html[data-theme="dark"] .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
            color: var(--accent);
        }

        html[data-theme="dark"] .alert-info {
            background-color: rgba(6, 182, 212, 0.15);
            border-color: rgba(6, 182, 212, 0.3);
            color: #22d3ee;
        }

        html[data-theme="dark"] .alert-warning {
            background-color: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fbbf24;
        }

        html[data-theme="dark"] .alert-danger {
            background-color: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        /* Pagination */
        html[data-theme="dark"] .page-link {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-secondary);
        }

        html[data-theme="dark"] .page-link:hover {
            background-color: var(--bg-card-hover);
            border-color: var(--accent);
            color: var(--accent);
        }

        html[data-theme="dark"] .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #0a1628;
        }

        /* Scrollbar */
        html[data-theme="dark"] ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        html[data-theme="dark"] ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }

        html[data-theme="dark"] ::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 4px;
        }

        html[data-theme="dark"] ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Icons in dark mode */
        html[data-theme="dark"] .bi {
            color: inherit;
        }

        html[data-theme="dark"] .text-success {
            color: var(--accent) !important;
        }

        html[data-theme="dark"] .text-info {
            color: #22d3ee !important;
        }

        html[data-theme="dark"] .text-warning {
            color: #fbbf24 !important;
        }

        html[data-theme="dark"] .text-danger {
            color: #f87171 !important;
        }

        /* Offcanvas / Sidebar */
        html[data-theme="dark"] .offcanvas {
            background-color: var(--bg-card);
            border-color: var(--border-color);
        }

        html[data-theme="dark"] .offcanvas-header {
            border-bottom-color: var(--border-color);
        }

        /* Modal */
        html[data-theme="dark"] .modal-content {
            background-color: var(--bg-card);
            border-color: var(--border-color);
        }

        html[data-theme="dark"] .modal-header {
            border-bottom-color: var(--border-color);
        }

        html[data-theme="dark"] .modal-footer {
            border-top-color: var(--border-color);
        }

        /* Selection */
        html[data-theme="dark"] ::selection {
            background: var(--accent);
            color: #0a1628;
        }
    </style>
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="app-orbit">
        <div class="app-orbit__blob app-orbit__blob--top"></div>
        <div class="app-orbit__blob app-orbit__blob--bottom"></div>
    </div>
    @include('components.navbar')
    <main class="container py-4" style="padding-top: 100px !important;">
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-5 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3 text-white">LawLite</h5>
                    <p class="text-white-50">{{ __('messages.hero_desc') }}
                    </p>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3 text-white">{{ __('messages.footer_platform') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('lawyers.index') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.find_lawyers') }}</a></li>
                        <li class="mb-2"><a href="{{ route('articles.index') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.articles') }}</a></li>
                        <li class="mb-2"><a href="{{ route('appointments.index') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.appointments') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3 text-white">{{ __('messages.footer_company') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.footer_about') }}</a>
                        </li>
                        <li class="mb-2"><a href="{{ route('contact') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.footer_contact') }}</a></li>
                        <li class="mb-2"><a href="{{ route('privacy') }}"
                                class="text-white-50 text-decoration-none">{{ __('messages.footer_privacy') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3 text-white">{{ __('messages.footer_subscribe') }}</h6>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control"
                            placeholder="{{ __('messages.email_placeholder') }}">
                        <button class="btn btn-accent"
                            type="button">{{ __('messages.footer_subscribe_btn') }}</button>
                    </form>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 text-center text-white-50">
                <small>&copy; {{ date('Y') }} LawLite. {{ __('messages.footer_rights') }}</small>
            </div>
        </div>
    </footer>

    @unless (request()->routeIs('messages.inbox'))
    @include('components.chat_ui')
    @endunless
    @include('components.appointment_modal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Pusher & Echo (optional - requires Pusher keys in .env) -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script>
        window.LAWLITE_USER_ID = "{{ auth()->id() }}";
        try {
            Pusher.logToConsole = false;
            const echo = new Echo({
                broadcaster: 'pusher',
                key: "{{ env('PUSHER_APP_KEY') }}",
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                forceTLS: true
            });

            if (window.LAWLITE_USER_ID) {
                echo.private('user.' + window.LAWLITE_USER_ID).listen('MessageSent', function(e) {
                    console.log('MessageSent event', e);
                    // Optionally update chat UI live
                });
            }
        } catch (e) {
            console.warn('Echo/Pusher not configured', e);
        }
    </script>
    <!-- Theme + motion utilities for dashboards (synced with landing) -->
    <script>
        (function() {
            const storageKey = 'lawlite_theme'; // Same key as landing.blade.php
            const stored = localStorage.getItem(storageKey);
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initial = stored || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', initial === 'dark' ? 'dark' : 'light');

            function updateThemeIcon() {
                const icon = document.getElementById('themeIcon');
                if (!icon) return;
                const theme = document.documentElement.getAttribute('data-theme');
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill fs-6';
                } else {
                    icon.className = 'bi bi-moon-fill fs-6';
                }
            }

            document.addEventListener('DOMContentLoaded', updateThemeIcon);

            const toggle = document.getElementById('themeToggle');
            if (toggle) {
                toggle.addEventListener('click', function() {
                    const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    const next = current === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', next);
                    localStorage.setItem(storageKey, next);
                    updateThemeIcon();
                });
            }

            // Navbar scroll state
            function handleHeaderScroll() {
                const header = document.querySelector('.site-header');
                if (!header) return;
                if (window.scrollY > 48) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }

            window.addEventListener('scroll', handleHeaderScroll, {
                passive: true
            });
            handleHeaderScroll();

            // Scroll reveal for dashboard sections
            function revealOnScroll() {
                const nodes = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                const threshold = 120;

                nodes.forEach(function(el) {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < windowHeight - threshold) {
                        el.classList.add('active');
                    }
                });
            }

            window.addEventListener('scroll', revealOnScroll, {
                passive: true
            });
            document.addEventListener('DOMContentLoaded', revealOnScroll);

            // Tilt Effect on Cards
            function initTiltEffect() {
                const cards = document.querySelectorAll('.tilt-effect, .glass-card');

                cards.forEach(card => {
                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;
                        const rotateX = (y - centerY) / 30;
                        const rotateY = (centerX - x) / 30;

                        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
                    });

                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
                    });
                });
            }

            // Scroll Progress Indicator
            function initScrollProgress() {
                const indicator = document.createElement('div');
                indicator.className = 'scroll-indicator';
                document.body.appendChild(indicator);

                window.addEventListener('scroll', () => {
                    const scrollTop = window.scrollY;
                    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                    const progress = docHeight > 0 ? scrollTop / docHeight : 0;
                    indicator.style.transform = `scaleX(${progress})`;
                });
            }

            // Counter Animation
            function initCounters() {
                const counters = document.querySelectorAll('[data-counter]');

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const target = parseInt(entry.target.dataset.counter);
                            const duration = 2000;
                            const start = 0;
                            const startTime = performance.now();

                            function updateCounter(currentTime) {
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);
                                const easeProgress = 1 - Math.pow(1 - progress, 3);
                                const current = Math.floor(easeProgress * (target - start) + start);

                                entry.target.textContent = current.toLocaleString() + (entry.target.dataset.suffix || '');

                                if (progress < 1) {
                                    requestAnimationFrame(updateCounter);
                                }
                            }

                            requestAnimationFrame(updateCounter);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                counters.forEach(counter => observer.observe(counter));
            }

            // Initialize advanced effects
            document.addEventListener('DOMContentLoaded', () => {
                initTiltEffect();
                initScrollProgress();
                initCounters();
            });

            updateThemeIcon();
        })();
    </script>
    @stack('scripts')
</body>

</html>