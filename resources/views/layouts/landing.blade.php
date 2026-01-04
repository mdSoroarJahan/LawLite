<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LawLite') }} - Bangladesh Legal AI Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Premium Font Stack: Inter for UI, Outfit for headings, JetBrains Mono for code, Noto Sans Bengali for Bangla -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Advanced UI Styles -->
    <link rel="stylesheet" href="{{ asset('css/advanced-ui.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #10b981;
            --accent-light: #34d399;
            --accent-dark: #059669;
            --gold: #f59e0b;
            --purple: #8b5cf6;
            --blue: #3b82f6;
            --pink: #ec4899;
            --muted: #64748b;
            --light-bg: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            --gradient-accent: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-purple: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            --gradient-mesh: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --shadow-glow: 0 0 40px rgba(16, 185, 129, 0.3);
            --shadow-glow-purple: 0 0 40px rgba(139, 92, 246, 0.3);

            /* Premium Font Variables */
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

        html[lang="bn"] h1,
        html[lang="bn"] h2,
        html[lang="bn"] h3,
        html[lang="bn"] h4,
        html[lang="bn"] h5,
        html[lang="bn"] h6,
        html[lang="bn"] .card-title,
        html[lang="bn"] .modal-title {
            font-family: var(--font-bengali), var(--font-display);
        }

        body {
            font-family: var(--font-body);
            background-color: var(--light-bg);
            color: var(--primary);
            line-height: 1.7;
            font-size: 15px;
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            transition: background-color 0.35s ease, color 0.35s ease;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
        }

        /* Premium Typography System */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .display-1,
        .display-2,
        .display-3,
        .display-4,
        .display-5,
        .display-6 {
            font-family: var(--font-display);
            font-weight: 700;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        h1,
        .display-1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
        }

        h2,
        .display-2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
        }

        h3,
        .display-3 {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 700;
        }

        h4,
        .display-4 {
            font-size: clamp(1.25rem, 2.5vw, 1.75rem);
            font-weight: 600;
        }

        h5,
        .display-5 {
            font-size: clamp(1.1rem, 2vw, 1.35rem);
            font-weight: 600;
        }

        h6,
        .display-6 {
            font-size: clamp(1rem, 1.5vw, 1.15rem);
            font-weight: 600;
        }

        /* Body text optimization */
        p {
            font-family: var(--font-body);
            line-height: 1.75;
            letter-spacing: -0.01em;
        }

        .lead {
            font-size: 1.15rem;
            font-weight: 400;
            line-height: 1.8;
            letter-spacing: -0.01em;
        }

        /* Small text refinement */
        small,
        .small,
        .text-sm {
            font-size: 0.875rem;
            letter-spacing: 0;
        }

        .text-xs {
            font-size: 0.75rem;
            letter-spacing: 0.01em;
        }

        /* Labels and captions */
        label,
        .form-label {
            font-family: var(--font-body);
            font-weight: 500;
            font-size: 0.875rem;
            letter-spacing: 0;
        }

        /* Buttons typography */
        .btn {
            font-family: var(--font-body);
            font-weight: 600;
            letter-spacing: -0.01em;
            font-size: 0.9375rem;
        }

        .btn-sm {
            font-size: 0.8125rem;
        }

        .btn-lg {
            font-size: 1.0625rem;
        }

        /* Navigation */
        .nav-link,
        .navbar-nav .nav-link {
            font-family: var(--font-body);
            font-weight: 500;
            font-size: 0.9375rem;
            letter-spacing: -0.01em;
        }

        /* Card titles */
        .card-title {
            font-family: var(--font-display);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        /* Code and monospace */
        code,
        pre,
        .font-mono {
            font-family: var(--font-mono);
            font-size: 0.875em;
        }

        /* Badge typography */
        .badge {
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        /* Form inputs */
        .form-control,
        .form-select {
            font-family: var(--font-body);
            font-size: 0.9375rem;
            letter-spacing: -0.01em;
        }

        /* Table text */
        .table {
            font-family: var(--font-body);
            font-size: 0.9375rem;
        }

        .table th {
            font-weight: 600;
            letter-spacing: 0;
        }

        /* Alert text */
        .alert {
            font-family: var(--font-body);
            font-size: 0.9375rem;
        }

        /* Modal titles */
        .modal-title {
            font-family: var(--font-display);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-family: var(--font-body);
            font-size: 0.875rem;
        }

        /* Dropdown */
        .dropdown-item {
            font-family: var(--font-body);
            font-size: 0.9375rem;
        }

        /* List group */
        .list-group-item {
            font-family: var(--font-body);
        }

        /* Tooltip & Popover */
        .tooltip,
        .popover {
            font-family: var(--font-body);
            font-size: 0.8125rem;
        }

        /* Special accent text */
        .text-accent,
        .text-gradient {
            font-family: var(--font-display);
            font-weight: 700;
        }

        /* Logo text */
        .logo-text,
        .brand-text {
            font-family: var(--font-display);
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        /* Section titles */
        .section-title {
            font-family: var(--font-display);
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        /* Feature titles */
        .feature-title {
            font-family: var(--font-display);
            font-weight: 600;
        }

        /* Stats and numbers */
        .stat-number,
        .display-number {
            font-family: var(--font-display);
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        /* Blockquote */
        blockquote {
            font-family: var(--font-body);
            font-style: italic;
            font-size: 1.125rem;
            line-height: 1.8;
        }

        /* Footer text */
        footer {
            font-family: var(--font-body);
        }

        footer h5,
        footer h6 {
            font-family: var(--font-display);
        }

        /* Custom Cursor */
        .custom-cursor {
            width: 20px;
            height: 20px;
            border: 2px solid var(--accent);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.15s ease, opacity 0.15s ease;
            mix-blend-mode: difference;
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: linear-gradient(180deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--accent) 0%, var(--accent-dark) 100%);
            border-radius: 5px;
            border: 2px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--accent-dark) 0%, #047857 100%);
        }

        /* Page Loader */
        .page-loader {
            position: fixed;
            inset: 0;
            background: var(--primary);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-content {
            text-align: center;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #0891b2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: pulse-loader 1.5s ease-in-out infinite;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.5), 0 0 60px rgba(16, 185, 129, 0.3);
        }

        @keyframes pulse-loader {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 30px rgba(16, 185, 129, 0.5), 0 0 60px rgba(16, 185, 129, 0.3);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 40px rgba(16, 185, 129, 0.6), 0 0 80px rgba(16, 185, 129, 0.4);
            }
        }

        .loader-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .loader-bar {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            margin: 1rem auto 0;
            overflow: hidden;
        }

        .loader-bar-inner {
            height: 100%;
            background: var(--gradient-accent);
            border-radius: 2px;
            animation: loading-bar 1.5s ease-in-out infinite;
        }

        @keyframes loading-bar {
            0% {
                width: 0%;
                margin-left: 0;
            }

            50% {
                width: 70%;
                margin-left: 15%;
            }

            100% {
                width: 0%;
                margin-left: 100%;
            }
        }

        /* Logo Styles */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo-icon-wrapper {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #0891b2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5), 0 0 40px rgba(16, 185, 129, 0.3), inset 0 0 20px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .logo-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
            border-radius: 50%;
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

        .logo:hover .logo-icon-wrapper {
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.5);
            transform: translateY(-2px);
        }

        .logo:hover .logo-icon-inner svg {
            transform: scale(1.1);
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #0891b2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5), 0 0 40px rgba(16, 185, 129, 0.3), inset 0 0 20px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .logo-icon svg {
            width: 28px;
            height: 28px;
            color: white;
            transition: transform 0.3s ease;
        }

        .logo-icon .logo-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon .logo-img {
            transform: scale(1.1);
        }

        .logo:hover .logo-icon {
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.6), 0 0 60px rgba(16, 185, 129, 0.4);
        }

        .logo:hover .logo-icon svg {
            transform: scale(1.1);
        }

        .logo-text {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .logo-text .law {
            color: #0f172a;
        }

        .logo-text .lite {
            color: #10b981;
        }

        /* Header */
        .site-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .site-header.scrolled {
            box-shadow: var(--shadow-md);
        }

        /* Navigation */
        .nav-link {
            color: var(--primary) !important;
            font-weight: 500;
            padding: 0.5rem 0.9rem !important;
            border-radius: 8px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--gradient-accent);
            transition: all 0.25s ease;
            transform: translateX(-50%);
            border-radius: 999px;
        }

        .nav-link:hover::after {
            width: 70%;
        }

        .nav-link:hover {
            color: var(--accent) !important;
            background: rgba(16, 185, 129, 0.08);
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: var(--accent) !important;
        }

        .nav-link.active::after {
            width: 70%;
        }

        .nav-utility-btn {
            font-size: 0.85rem;
            color: var(--muted);
            gap: 0.4rem;
        }

        .nav-utility-btn i {
            font-size: 1rem;
        }

        .btn-icon-compact {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon.small {
            width: 40px;
            height: 40px;
            border-radius: 12px;
        }

        .premium-sidebar {
            background: radial-gradient(circle at top, #111827 0%, #05080f 60%);
            color: #f8fafc;
            width: min(320px, 90vw);
            padding-bottom: 2rem;
        }

        .premium-sidebar .offcanvas-header {
            border-bottom: 1px solid rgba(248, 250, 252, 0.08);
            padding: 1.5rem 1.5rem 1rem;
        }

        .premium-sidebar .offcanvas-body {
            padding: 2rem 1.5rem;
        }

        .sidebar-label {
            letter-spacing: 0.25em;
        }

        .sidebar-menu li+li {
            margin-top: 0.35rem;
        }

        .sidebar-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            color: inherit;
            padding: 0.65rem 0;
            border-bottom: 1px solid rgba(248, 250, 252, 0.08);
            font-family: var(--font-display);
            letter-spacing: 0.08em;
            font-size: 1.05rem;
            text-transform: uppercase;
            transition: color 0.2s ease, padding-left 0.2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: var(--accent);
            padding-left: 0.35rem;
        }

        .sidebar-user {
            border: 1px solid rgba(248, 250, 252, 0.12);
            background: rgba(15, 23, 42, 0.4);
        }

        .sidebar-link-minor {
            color: rgba(248, 250, 252, 0.6);
            text-decoration: none;
            letter-spacing: 0.1em;
        }

        .sidebar-link-minor:hover {
            color: var(--accent);
        }

        /* Buttons with Advanced Animations */
        .btn {
            font-weight: 600;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
        }

        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
            z-index: -1;
        }

        .btn:hover::before {
            transform: translateX(100%);
        }

        .btn-primary {
            background: var(--gradient-accent);
            color: white;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.45);
        }

        .btn-primary:active {
            transform: translateY(-1px) scale(0.98);
        }

        .btn-outline-primary {
            border: 2px solid var(--accent);
            color: var(--accent);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-dark {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.35);
        }

        .btn-dark:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.45);
        }

        .btn-accent {
            background: var(--gradient-gold);
            color: #0b2540;
            font-weight: 700;
        }

        .btn-accent:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
        }

        .btn-glow {
            animation: btn-glow-pulse 2s ease-in-out infinite;
        }

        @keyframes btn-glow-pulse {

            0%,
            100% {
                box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            }

            50% {
                box-shadow: 0 4px 30px rgba(16, 185, 129, 0.6);
            }
        }

        /* Magnetic Button Effect */
        .btn-magnetic {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Cards with 3D Effect */
        .card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.03) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-2xl);
            transform: translateY(-8px) rotateX(2deg);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .card:hover::before {
            opacity: 1;
        }

        /* Glass Effect Cards */
        .card-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Form Controls with Glow */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15), var(--shadow-glow);
            background: white;
            transform: scale(1.01);
        }

        .form-control::placeholder {
            color: #94a3b8;
            transition: opacity 0.3s ease;
        }

        .form-control:focus::placeholder {
            opacity: 0.5;
        }

        /* Focus States for Accessibility */
        .btn:focus-visible,
        .nav-link:focus-visible,
        .social-icon:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* Elastic Button Press */
        .btn:active {
            transform: scale(0.97);
        }

        /* Text Colors */
        .text-primary {
            color: var(--primary) !important;
        }

        .text-accent {
            color: var(--accent) !important;
        }

        .text-gradient {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Backgrounds */
        .bg-light-section {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        }

        .bg-gradient-dark {
            background: var(--gradient-primary);
        }

        .bg-gradient-primary {
            background: var(--gradient-accent) !important;
        }

        /* Utilities */
        .small-muted {
            color: var(--muted);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Footer */
        .modern-footer {
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
        }

        .modern-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }

        .footer-logo .logo-icon {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #0891b2 100%);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.4), 0 0 30px rgba(16, 185, 129, 0.2);
        }

        .footer-logo .logo-icon::before {
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.15) 0%, transparent 60%);
        }

        .footer-logo .logo-icon svg {
            color: white;
        }

        .footer-logo .logo-text .law {
            color: white;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            }

            50% {
                box-shadow: 0 0 40px rgba(16, 185, 129, 0.6);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Badge Styles */
        .badge-modern {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }

        .badge-modern:hover {
            background: rgba(16, 185, 129, 0.15);
            transform: scale(1.05);
        }

        /* Dropdown with Animation */
        .dropdown-menu {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-2xl);
            padding: 0.75rem;
            animation: dropdown-fade 0.3s ease;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
        }

        @keyframes dropdown-fade {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            transform: translateX(5px);
        }

        /* Scroll Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-scale.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Stagger Animation */
        .stagger-1 {
            transition-delay: 0.1s;
        }

        .stagger-2 {
            transition-delay: 0.2s;
        }

        .stagger-3 {
            transition-delay: 0.3s;
        }

        .stagger-4 {
            transition-delay: 0.4s;
        }

        .stagger-5 {
            transition-delay: 0.5s;
        }

        /* Parallax Effect */
        .parallax-bg {
            transition: transform 0.1s linear;
            will-change: transform;
        }

        /* Tilt Effect */
        .tilt-effect {
            transition: transform 0.3s ease;
            transform-style: preserve-3d;
        }

        /* Typing Animation */
        .typing-text {
            overflow: hidden;
            border-right: 3px solid var(--accent);
            white-space: nowrap;
            animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink-caret {

            from,
            to {
                border-color: transparent;
            }

            50% {
                border-color: var(--accent);
            }
        }

        /* Gradient Text Animation */
        .gradient-text-animate {
            background: linear-gradient(90deg, var(--accent), var(--blue), var(--purple), var(--accent));
            background-size: 300% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Morphing Background */
        .morph-bg {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation: morph 8s ease-in-out infinite;
            filter: blur(40px);
        }

        @keyframes morph {
            0% {
                border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            }

            50% {
                border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
            }

            100% {
                border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            }
        }

        /* Particle Effect */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            opacity: 0.3;
            animation: particle-float 15s linear infinite;
        }

        @keyframes particle-float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.3;
            }

            90% {
                opacity: 0.3;
            }

            100% {
                transform: translateY(-100vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* Glowing Border */
        .glow-border {
            position: relative;
        }

        .glow-border::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, var(--accent), var(--blue), var(--purple), var(--accent));
            background-size: 400% 400%;
            border-radius: inherit;
            z-index: -1;
            animation: glow-rotate 3s linear infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .glow-border:hover::before {
            opacity: 1;
        }

        @keyframes glow-rotate {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Ripple Effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, var(--accent) 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform 0.5s, opacity 1s;
        }

        .ripple:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }

        /* Hover Underline Animation */
        .hover-underline {
            position: relative;
        }

        .hover-underline::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-accent);
            transition: width 0.3s ease;
        }

        .hover-underline:hover::after {
            width: 100%;
        }

        /* Icon Bounce */
        .icon-bounce:hover i {
            animation: icon-bounce 0.5s ease;
        }

        @keyframes icon-bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            25% {
                transform: translateY(-5px);
            }

            50% {
                transform: translateY(0);
            }

            75% {
                transform: translateY(-3px);
            }
        }

        /* Counter Animation */
        .counter {
            display: inline-block;
        }

        /* Social Icons */
        .social-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-accent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .social-icon:hover::before {
            opacity: 1;
        }

        .social-icon i {
            position: relative;
            z-index: 1;
        }

        /* Footer Link Hover */
        .footer-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 0;
        }

        .footer-link:hover {
            color: white;
            padding-left: 10px;
        }

        .footer-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 0;
            height: 2px;
            background: var(--accent);
            transform: translateY(-50%);
            transition: width 0.3s ease;
        }

        .footer-link:hover::before {
            width: 5px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .logo-text {
                font-size: 1.35rem;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
            }

            .page-loader .loader-logo {
                width: 60px;
                height: 60px;
            }
        }

        /* Prefers Reduced Motion */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Dark theme overrides (toggle by setting html[data-theme="dark"]) */
        html[data-theme="dark"] {
            --primary: #e6eef8;
            --primary-light: #0b1220;
            --accent: #34d399;
            --accent-light: #60f0b0;
            --accent-dark: #059669;
            --gold: #f59e0b;
            --muted: #9fb0c8;
            --light-bg: #07122a;
            --gradient-primary: linear-gradient(135deg, #07122a 0%, #0b2440 50%, #07122a 100%);
            --gradient-accent: linear-gradient(135deg, #34d399 0%, #059669 100%);
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.5);
            --shadow-md: 0 6px 18px rgba(0, 0, 0, 0.6);
            --shadow-lg: 0 18px 30px rgba(0, 0, 0, 0.6);
            --shadow-2xl: 0 30px 60px rgba(0, 0, 0, 0.7);
            --shadow-glow: 0 0 40px rgba(52, 211, 153, 0.12);
        }

        /* Dark mode component overrides */
        html[data-theme="dark"] body {
            background: var(--light-bg);
            color: var(--primary);
        }

        html[data-theme="dark"] .site-header {
            background: rgba(7, 18, 42, 0.95);
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }

        html[data-theme="dark"] .nav-link {
            color: #cbd5e1 !important;
        }

        html[data-theme="dark"] .nav-link:hover,
        html[data-theme="dark"] .nav-link.active {
            color: var(--accent) !important;
            background: rgba(52, 211, 153, 0.1);
        }

        html[data-theme="dark"] .card,
        html[data-theme="dark"] .ai-card,
        html[data-theme="dark"] .feature-card {
            background: rgba(11, 18, 32, 0.9);
            border-color: rgba(255, 255, 255, 0.08);
        }

        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] .form-select {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.12);
            color: #e6eef8;
        }

        html[data-theme="dark"] .form-control::placeholder {
            color: #64748b;
        }

        html[data-theme="dark"] .form-control:focus,
        html[data-theme="dark"] .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
        }

        html[data-theme="dark"] .dropdown-menu {
            background: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .dropdown-item {
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .dropdown-item:hover {
            background: rgba(52, 211, 153, 0.15) !important;
            color: #34d399 !important;
        }

        /* Select dropdowns and options */
        html[data-theme="dark"] .form-select {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        html[data-theme="dark"] .form-select option {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] select option {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        /* Button overrides for dark mode */
        html[data-theme="dark"] .btn-primary,
        html[data-theme="dark"] .btn-accent {
            color: #ffffff !important;
        }

        html[data-theme="dark"] .btn-primary i,
        html[data-theme="dark"] .btn-accent i {
            color: #ffffff !important;
        }

        /* Suggestion dropdowns and autocomplete */
        html[data-theme="dark"] #suggestions-dropdown,
        html[data-theme="dark"] .suggestions-dropdown,
        html[data-theme="dark"] .autocomplete-dropdown,
        html[data-theme="dark"] [id*="suggestion"],
        html[data-theme="dark"] [class*="suggestion"] {
            background-color: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .suggestion-item,
        html[data-theme="dark"] #suggestions-dropdown a,
        html[data-theme="dark"] #suggestions-dropdown div,
        html[data-theme="dark"] .suggestions-dropdown a {
            color: #e2e8f0 !important;
            background-color: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        html[data-theme="dark"] .suggestion-item:hover,
        html[data-theme="dark"] #suggestions-dropdown a:hover {
            background-color: #1e293b !important;
            color: #34d399 !important;
        }

        html[data-theme="dark"] .suggestion-item .fw-bold,
        html[data-theme="dark"] #suggestions-dropdown .fw-bold {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .suggestion-item .text-muted,
        html[data-theme="dark"] #suggestions-dropdown .text-muted {
            color: #94a3b8 !important;
        }

        /* Any element with bg-white in dark mode */
        html[data-theme="dark"] .position-absolute.bg-white,
        html[data-theme="dark"] div.bg-white {
            background-color: #0f172a !important;
        }

        /* Datalist styling */
        html[data-theme="dark"] datalist,
        html[data-theme="dark"] datalist option {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        /* List items in dropdowns */
        html[data-theme="dark"] .list-group-item-action {
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .list-group-item-action:hover,
        html[data-theme="dark"] .list-group-item-action:focus {
            background-color: #1e293b !important;
            color: #34d399 !important;
        }

        html[data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        html[data-theme="dark"] .bg-light-section {
            background: linear-gradient(180deg, #0a1628 0%, #07122a 100%);
        }

        html[data-theme="dark"] .hero-section {
            background: linear-gradient(135deg, #07122a 0%, #0d1b30 50%, #07122a 100%);
        }

        html[data-theme="dark"] .trust-badge,
        html[data-theme="dark"] .floating-badge {
            background: rgba(11, 18, 32, 0.9);
            border-color: rgba(255, 255, 255, 0.08);
            color: #e6eef8;
        }

        /* Bootstrap Utility Overrides for Dark Mode */
        html[data-theme="dark"] .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        html[data-theme="dark"] .bg-white {
            background-color: rgba(11, 18, 32, 0.95) !important;
        }

        html[data-theme="dark"] .text-dark {
            color: #e6eef8 !important;
        }

        html[data-theme="dark"] .border {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .border-bottom {
            border-bottom-color: rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .border-top {
            border-top-color: rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .list-group-item {
            background-color: transparent;
            border-color: rgba(255, 255, 255, 0.1);
            color: #e6eef8;
        }

        html[data-theme="dark"] .list-group-item-action:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--accent);
        }

        html[data-theme="dark"] .btn-outline-primary {
            border-color: var(--accent);
            color: var(--accent);
        }

        html[data-theme="dark"] .btn-outline-primary:hover {
            background: var(--accent);
            color: #07122a;
        }

        html[data-theme="dark"] .logo-text .law {
            color: #ffffff;
        }

        html[data-theme="dark"] .logo-text .lite {
            color: #10b981 !important;
        }

        html[data-theme="dark"] ::-webkit-scrollbar-track {
            background: #0a1628;
        }

        /* Fix for user dropdown background in dark mode */
        html[data-theme="dark"] #navbarDropdown {
            background-color: transparent !important;
            border: 1px solid transparent;
        }

        html[data-theme="dark"] #navbarDropdown:hover,
        html[data-theme="dark"] #navbarDropdown[aria-expanded="true"] {
            background-color: rgba(52, 211, 153, 0.1) !important;
            border-color: rgba(52, 211, 153, 0.2);
        }

        /* ===== COMPREHENSIVE DARK MODE TEXT FIXES ===== */

        /* Global text colors */
        html[data-theme="dark"] h1,
        html[data-theme="dark"] h2,
        html[data-theme="dark"] h3,
        html[data-theme="dark"] h4,
        html[data-theme="dark"] h5,
        html[data-theme="dark"] h6 {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] p,
        html[data-theme="dark"] span,
        html[data-theme="dark"] label,
        html[data-theme="dark"] small,
        html[data-theme="dark"] div {
            color: #e2e8f0;
        }

        html[data-theme="dark"] a:not(.btn) {
            color: #7dd3fc;
        }

        html[data-theme="dark"] a:not(.btn):hover {
            color: #38bdf8;
        }

        /* Card content - Lawyer cards, Article cards, etc. */
        html[data-theme="dark"] .card-title,
        html[data-theme="dark"] .card-text,
        html[data-theme="dark"] .card-body h5,
        html[data-theme="dark"] .card-body h6,
        html[data-theme="dark"] .card-body p,
        html[data-theme="dark"] .card-body span,
        html[data-theme="dark"] .card-body small {
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .card-header,
        html[data-theme="dark"] .card-footer {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        /* Form labels and text */
        html[data-theme="dark"] .form-label,
        html[data-theme="dark"] label,
        html[data-theme="dark"] .form-text {
            color: #cbd5e1 !important;
        }

        /* Links styled as text */
        html[data-theme="dark"] .text-decoration-none,
        html[data-theme="dark"] .card a {
            color: #94a3b8 !important;
        }

        html[data-theme="dark"] .card a:hover {
            color: #34d399 !important;
        }

        /* Page titles and subtitles */
        html[data-theme="dark"] .page-title,
        html[data-theme="dark"] .section-title,
        html[data-theme="dark"] .lead {
            color: #f1f5f9 !important;
        }

        /* Quick sign-in links and similar */
        html[data-theme="dark"] .btn-link {
            color: #7dd3fc !important;
        }

        html[data-theme="dark"] .btn-link:hover {
            color: #38bdf8 !important;
        }

        /* Location, specialization text in cards */
        html[data-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }

        /* Article/content descriptions */
        html[data-theme="dark"] .article-excerpt,
        html[data-theme="dark"] .description,
        html[data-theme="dark"] .excerpt {
            color: #cbd5e1 !important;
        }

        /* Modal content */
        html[data-theme="dark"] .modal-content {
            background-color: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .modal-header,
        html[data-theme="dark"] .modal-footer {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        html[data-theme="dark"] .modal-title {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .modal-body {
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .modal-body p,
        html[data-theme="dark"] .modal-body span,
        html[data-theme="dark"] .modal-body label {
            color: #e2e8f0 !important;
        }

        /* Close button */
        html[data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Tables */
        html[data-theme="dark"] .table {
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .table th,
        html[data-theme="dark"] .table td {
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        /* Badges */
        html[data-theme="dark"] .badge.bg-light {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        /* Icons */
        html[data-theme="dark"] .bi,
        html[data-theme="dark"] i {
            color: #94a3b8;
        }

        /* Specific fix for lawyer cards */
        html[data-theme="dark"] .lawyer-name,
        html[data-theme="dark"] .lawyer-specialization,
        html[data-theme="dark"] .lawyer-location {
            color: #e2e8f0 !important;
        }

        /* Alert boxes */
        html[data-theme="dark"] .alert {
            background-color: rgba(15, 23, 42, 0.9) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        /* Breadcrumbs */
        html[data-theme="dark"] .breadcrumb-item,
        html[data-theme="dark"] .breadcrumb-item a {
            color: #94a3b8 !important;
        }

        html[data-theme="dark"] .breadcrumb-item.active {
            color: #e2e8f0 !important;
        }

        /* Pagination */
        html[data-theme="dark"] .page-link {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .page-link:hover {
            background-color: rgba(52, 211, 153, 0.2) !important;
            color: #34d399 !important;
        }

        /* Input group text */
        html[data-theme="dark"] .input-group-text {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
        }

        /* Ensure all text in dark mode is readable */
        html[data-theme="dark"] .text-body {
            color: #e2e8f0 !important;
        }

        html[data-theme="dark"] .text-dark {
            color: #f1f5f9 !important;
        }

        html[data-theme="dark"] .text-black {
            color: #f1f5f9 !important;
        }

        /* Navbar Padding Helper */
        .pt-navbar {
            padding-top: 100px;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="40" height="40">
                    <!-- Balance beam -->
                    <line x1="12" y1="3" x2="12" y2="6" />
                    <line x1="4" y1="8" x2="20" y2="8" />
                    <!-- Left scale -->
                    <line x1="6" y1="8" x2="4" y2="14" />
                    <line x1="6" y1="8" x2="8" y2="14" />
                    <path d="M3 14 Q4 17 5 14" />
                    <path d="M7 14 Q8 17 9 14" />
                    <line x1="3" y1="14" x2="9" y2="14" />
                    <!-- Right scale -->
                    <line x1="18" y1="8" x2="16" y2="14" />
                    <line x1="18" y1="8" x2="20" y2="14" />
                    <path d="M15 14 Q16 17 17 14" />
                    <path d="M19 14 Q20 17 21 14" />
                    <line x1="15" y1="14" x2="21" y2="14" />
                    <!-- Center pillar -->
                    <line x1="12" y1="8" x2="12" y2="20" />
                    <line x1="8" y1="20" x2="16" y2="20" />
                </svg>
            </div>
            <div class="loader-text">LawLite</div>
            <div class="loader-bar">
                <div class="loader-bar-inner"></div>
            </div>
        </div>
    </div>

    <!-- Particles Background -->
    <div class="particles" id="particles"></div>

    @include('components.navbar')

    <main class="@hasSection('no-padding') @else pt-navbar @endif">
        @yield('content')
    </main>

    <footer class="modern-footer text-white py-5 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0 reveal reveal-left">
                    <a href="{{ url('/') }}" class="logo footer-logo text-decoration-none mb-3 d-inline-flex">
                        <div class="logo-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <!-- Balance beam -->
                                <line x1="12" y1="3" x2="12" y2="6" />
                                <line x1="4" y1="8" x2="20" y2="8" />
                                <!-- Left scale -->
                                <line x1="6" y1="8" x2="4" y2="14" />
                                <line x1="6" y1="8" x2="8" y2="14" />
                                <path d="M3 14 Q4 17 5 14" />
                                <path d="M7 14 Q8 17 9 14" />
                                <line x1="3" y1="14" x2="9" y2="14" />
                                <!-- Right scale -->
                                <line x1="18" y1="8" x2="16" y2="14" />
                                <line x1="18" y1="8" x2="20" y2="14" />
                                <path d="M15 14 Q16 17 17 14" />
                                <path d="M19 14 Q20 17 21 14" />
                                <line x1="15" y1="14" x2="21" y2="14" />
                                <!-- Center pillar -->
                                <line x1="12" y1="8" x2="12" y2="20" />
                                <line x1="8" y1="20" x2="16" y2="20" />
                            </svg>
                        </div>
                        <span class="logo-text">
                            <span class="law">Law</span><span class="lite">Lite</span>
                        </span>
                    </a>
                    <p class="text-white-50 mt-3">{{ __('messages.hero_desc') }}</p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="#" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0 reveal stagger-1">
                    <h6 class="fw-bold mb-3 text-white">{{ __('messages.footer_platform') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('ai.features') }}" class="footer-link">{{ __('messages.ai_features') }}</a></li>
                        <li class="mb-2"><a href="{{ route('lawyers.index') }}" class="footer-link">{{ __('messages.find_lawyers') }}</a></li>
                        <li class="mb-2"><a href="{{ route('articles.index') }}" class="footer-link">{{ __('messages.articles') }}</a></li>
                        <li class="mb-2"><a href="{{ route('appointments.index') }}" class="footer-link">{{ __('messages.appointments') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0 reveal stagger-2">
                    <h6 class="fw-bold mb-3 text-white">{{ __('messages.footer_company') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about') }}" class="footer-link">{{ __('messages.footer_about') }}</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="footer-link">{{ __('messages.footer_contact') }}</a></li>
                        <li class="mb-2"><a href="{{ route('privacy') }}" class="footer-link">{{ __('messages.footer_privacy') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4 reveal reveal-right">
                    <h6 class="fw-bold mb-3 text-white">{{ __('messages.footer_subscribe') }}</h6>
                    <p class="text-white-50 small mb-3">{{ __('messages.footer_subscribe_desc') }}</p>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;" placeholder="{{ __('messages.email_placeholder') }}">
                        <button class="btn btn-accent btn-glow" type="button">{{ __('messages.footer_subscribe_btn') }}</button>
                    </form>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 d-flex flex-wrap justify-content-between align-items-center reveal">
                <small class="text-white-50">&copy; {{ date('Y') }} LawLite. {{ __('messages.footer_rights') }}</small>
                <small class="text-white-50">
                    <span class="me-2">🇧🇩</span> {{ __('messages.made_with_love') }}
                </small>
            </div>
        </div>
    </footer>

    @if(!request()->is('messages'))
    @include('components.chat_ui')
    @endif
    @include('components.appointment_modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Page Loader
        (function() {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;
            const hasSeenLoader = sessionStorage.getItem('lawlite_loader_seen');
            if (hasSeenLoader) {
                loader.classList.add('hidden');
            }

            window.addEventListener('load', function() {
                if (sessionStorage.getItem('lawlite_loader_seen')) {
                    loader.classList.add('hidden');
                    return;
                }
                setTimeout(function() {
                    loader.classList.add('hidden');
                    sessionStorage.setItem('lawlite_loader_seen', '1');
                }, 800);
            });
        })();

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.site-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Scroll Reveal Animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        reveal(); // Initial check

        // Parallax Effect
        window.addEventListener('scroll', function() {
            const parallaxElements = document.querySelectorAll('.parallax-bg');
            parallaxElements.forEach(element => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.3;
                element.style.transform = `translateY(${rate}px)`;
            });
        });

        // Create Particles
        function createParticles() {
            const container = document.getElementById('particles');
            if (!container) return;

            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.width = (Math.random() * 4 + 2) + 'px';
                particle.style.height = particle.style.width;
                container.appendChild(particle);
            }
        }

        createParticles();

        // Counter Animation
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 30);
        }

        // Observe counters
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.target);
                    animateCounter(entry.target, target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        document.querySelectorAll('.counter').forEach(counter => {
            counterObserver.observe(counter);
        });

        // Tilt Effect
        document.querySelectorAll('.tilt-effect').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
            });
        });

        // Magnetic Button Effect
        document.querySelectorAll('.btn-magnetic').forEach(btn => {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translate(0, 0)';
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Theme: initialize and toggle dark/light mode
        (function() {
            const stored = localStorage.getItem('lawlite_theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initial = stored || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', initial === 'dark' ? 'dark' : 'light');

            function updateThemeIcon() {
                const icon = document.getElementById('themeIcon');
                if (!icon) return;
                const theme = document.documentElement.getAttribute('data-theme');
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill';
                } else {
                    icon.className = 'bi bi-moon-fill';
                }
            }

            document.addEventListener('DOMContentLoaded', updateThemeIcon);

            const toggle = document.getElementById('themeToggle');
            if (toggle) {
                toggle.addEventListener('click', function() {
                    const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    const next = current === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', next);
                    localStorage.setItem('lawlite_theme', next);
                    updateThemeIcon();
                });
            }
            updateThemeIcon();
        })();
    </script>

    <!-- Advanced UI Scroll Reveal & Animations -->
    <script>
        // Scroll Reveal Animation
        function initScrollReveal() {
            const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            reveals.forEach(el => observer.observe(el));
        }

        // Scroll Progress Indicator
        function initScrollProgress() {
            const indicator = document.createElement('div');
            indicator.className = 'scroll-indicator';
            document.body.appendChild(indicator);

            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const progress = scrollTop / docHeight;
                indicator.style.transform = `scaleX(${progress})`;
            });
        }

        // Particle Background
        function initParticles() {
            const container = document.querySelector('.particles');
            if (!container) return;

            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particle.style.width = (4 + Math.random() * 4) + 'px';
                particle.style.height = particle.style.width;
                container.appendChild(particle);
            }
        }

        // Parallax Effect on Mouse Move
        function initParallax() {
            document.addEventListener('mousemove', (e) => {
                const parallaxElements = document.querySelectorAll('[data-parallax]');
                const x = (window.innerWidth / 2 - e.clientX) / 50;
                const y = (window.innerHeight / 2 - e.clientY) / 50;

                parallaxElements.forEach(el => {
                    const speed = el.dataset.parallax || 1;
                    el.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
                });
            });
        }

        // Tilt Effect on Cards
        function initTiltEffect() {
            const cards = document.querySelectorAll('.tilt-effect');

            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
                });
            });
        }

        // Magnetic Button Effect
        function initMagneticButtons() {
            const buttons = document.querySelectorAll('.magnetic-btn');

            buttons.forEach(btn => {
                btn.addEventListener('mousemove', (e) => {
                    const rect = btn.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;

                    btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
                });

                btn.addEventListener('mouseleave', () => {
                    btn.style.transform = 'translate(0, 0)';
                });
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

        // Initialize all effects
        document.addEventListener('DOMContentLoaded', () => {
            initScrollReveal();
            initScrollProgress();
            initParticles();
            initParallax();
            initTiltEffect();
            initMagneticButtons();
            initCounters();
        });
    </script>

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
                });
            }
        } catch (e) {
            console.warn('Echo/Pusher not configured', e);
        }
    </script>
    @stack('scripts')
</body>

</html>