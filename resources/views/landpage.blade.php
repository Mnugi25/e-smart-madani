<!DOCTYPE html>
<html lang="id" class="dark-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning & Smart School — SMK Al-Madani Pontianak</title>

    <!-- Favicon (SMK Al-Madani Logo) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />
    <link rel="shortcut icon" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />
    <link rel="apple-touch-icon" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Theme State Initializer (Permanently Locked to Dark Mode) -->
    <script>
        document.documentElement.classList.add('dark-theme');
        localStorage.setItem('elearning-theme', 'dark');
    </script>

    <style>
        /* ========================================================
           🎨 CSS VARIABLES & BULLETPROOF COLOR CONTRAST SYSTEM
           ======================================================== */
        :root {
            /* LIGHT THEME (Clean, Crisp, High-Contrast) */
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --bg-card-solid: #ffffff;
            --bg-input: #f1f5f9;
            --bg-strip: #f8fafc;
            --border-color: #e2e8f0;
            --border-highlight: rgba(37, 99, 235, 0.25);
            --text-heading: #0f172a;       /* Deep obsidian black - AAA contrast */
            --text-body: #334155;          /* Crisp slate-700 - AAA contrast */
            --text-muted: #64748b;         /* Slate-500/600 - High legibility */
            --primary: #2563eb;
            --primary-glow: #1d4ed8;
            --accent: #4f46e5;
            --emerald: #059669;
            --amber: #d97706;
            --nav-bg: rgba(255, 255, 255, 0.95);
            --shadow-card: 0 10px 30px -5px rgba(15, 23, 42, 0.05), 0 0 0 1px rgba(226, 232, 240, 0.8);
            --shadow-hover: 0 20px 40px -10px rgba(37, 99, 235, 0.12), 0 0 0 1px rgba(37, 99, 235, 0.3);
            --gradient-primary: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%);
            --gradient-text: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #4f46e5 100%);
        }

        /* 🌙 DARK THEME (Luminous, High-Contrast Text, No Dark-on-Dark Text) */
        html.dark-theme {
            --bg-page: #080d1a;
            --bg-card: #0f172a;
            --bg-card-solid: #131c31;
            --bg-input: #1e293b;
            --bg-strip: rgba(255, 255, 255, 0.05);
            --border-color: rgba(255, 255, 255, 0.12);
            --border-highlight: rgba(96, 165, 250, 0.4);
            --text-heading: #ffffff;       /* Pure white - 100% contrast */
            --text-body: #e2e8f0;          /* Bright silver-white - AAA contrast */
            --text-muted: #cbd5e1;         /* Crisp light slate - High legibility */
            --primary: #3b82f6;
            --primary-glow: #60a5fa;
            --accent: #818cf8;
            --emerald: #10b981;
            --amber: #f59e0b;
            --nav-bg: rgba(8, 13, 26, 0.92);
            --shadow-card: 0 16px 40px -8px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.08);
            --shadow-hover: 0 24px 50px -10px rgba(59, 130, 246, 0.3), 0 0 0 1px rgba(96, 165, 250, 0.4);
            --gradient-primary: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #06b6d4 100%);
            --gradient-text: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #38bdf8 100%);
        }

        /* ========================================================
           🚨 GLOBAL OVERRIDES: STOP BOOTSTRAP TEXT-MUTED CONFLICTS
           ======================================================== */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-body);
            overflow-x: hidden;
            position: relative;
            transition: background-color 0.25s ease, color 0.25s ease;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.025em;
            color: var(--text-heading) !important;
        }

        /* Enforce crystal clear readability on all text & descriptions */
        p, .card-desc, .hero-description, .section-subtitle {
            color: var(--text-body) !important;
            line-height: 1.7;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .gradient-text {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Ambient Background Glow */
        .ambient-mesh {
            position: absolute;
            width: 100%; height: 100%;
            top: 0; left: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: -1;
        }
        .glow-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.4;
            animation: float-ambient 20s infinite alternate ease-in-out;
        }
        .glow-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, transparent 70%);
            top: -100px; right: -80px;
        }
        .glow-2 {
            width: 650px; height: 650px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.18) 0%, transparent 70%);
            top: 450px; left: -150px;
            animation-delay: -6s;
        }

        @keyframes float-ambient {
            0% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.1) translate(30px, -20px); }
            100% { transform: scale(0.95) translate(-20px, 20px); }
        }

        /* ================= 🚀 GLASS NAVBAR ================= */
        .glass-navbar {
            background: var(--nav-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            padding: 14px 0;
            z-index: 1040;
        }
        .glass-navbar.scrolled {
            padding: 10px 0;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15);
        }
        .school-logo-pill {
            width: 44px; height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(59, 130, 246, 0.4);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            transition: transform 0.25s ease;
        }
        .school-logo-pill:hover {
            transform: scale(1.06) rotate(3deg);
        }
        .brand-badge {
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 6px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.25);
            margin-left: 8px;
        }
        .nav-link-custom {
            font-weight: 600;
            font-size: 15px;
            color: var(--text-heading) !important;
            padding: 8px 16px !important;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .nav-link-custom:hover {
            color: var(--primary) !important;
            background: rgba(59, 130, 246, 0.08);
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            width: 40px; height: 40px;
            border-radius: 12px;
            border: 1.5px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-heading);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .theme-toggle-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: scale(1.05);
        }

        /* Buttons */
        .btn-modern-primary {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 15px;
            padding: 13px 28px;
            border-radius: 14px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.35);
            text-decoration: none;
        }
        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -4px rgba(37, 99, 235, 0.45);
        }
        .btn-modern-secondary {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #1e293b !important;
            font-weight: 700;
            font-size: 15px;
            padding: 13px 26px;
            border-radius: 14px;
            border: 1.5px solid rgba(203, 213, 225, 0.85);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }
        .btn-modern-secondary:hover {
            border-color: #93c5fd;
            color: var(--primary) !important;
            transform: translateY(-2px);
            background: #eff6ff;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.12);
        }
        html.dark-theme .btn-modern-secondary {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.15);
            color: #ffffff !important;
            box-shadow: none;
        }
        html.dark-theme .btn-modern-secondary:hover {
            background: rgba(59, 130, 246, 0.12);
            border-color: #60a5fa;
            color: #60a5fa !important;
        }

        /* ================= 🌌 HERO SECTION ================= */
        .hero-section {
            padding: 130px 0 70px;
            position: relative;
            background-image: 
                linear-gradient(180deg, rgba(255, 255, 255, 0.08) 0%, transparent 15%, transparent 92%, var(--bg-page) 100%),
                linear-gradient(to right, rgba(248, 250, 252, 0.62) 0%, rgba(248, 250, 252, 0.38) 20%, rgba(248, 250, 252, 0.08) 32%, transparent 42%),
                url("{{ asset('template/images/gedung_smk_almadani.jpg') }}?v=4");
            background-size: cover;
            background-position: 68% center;
            background-repeat: no-repeat;
            border-bottom: 1px solid var(--border-color);
            min-height: calc(100vh - 40px);
            display: flex;
            align-items: center;
            transition: background 0.4s ease;
        }

        html.dark-theme .hero-section {
            background-image: 
                linear-gradient(180deg, rgba(15, 23, 42, 0.25) 0%, transparent 20%, transparent 75%, var(--bg-page) 100%),
                linear-gradient(to right, rgba(11, 19, 41, 0.95) 0%, rgba(11, 19, 41, 0.82) 24%, rgba(11, 19, 41, 0.20) 36%, transparent 45%),
                url("{{ asset('template/images/gedung_smk_almadani.jpg') }}?v=4");
        }

        /* Full Campus Focus Mode (Hides UI clutter so full building is seen) */
        .hero-section.campus-focus-mode {
            background-image: url("{{ asset('template/images/gedung_smk_almadani.jpg') }}?v=4") !important;
        }
        .hero-section.campus-focus-mode .hero-left-content {
            opacity: 0.06 !important;
            pointer-events: none;
            transform: scale(0.97);
            transition: all 0.4s ease;
        }
        .hero-section.campus-focus-mode .btn-campus-focus {
            opacity: 1 !important;
            pointer-events: auto !important;
            position: relative;
            z-index: 1050;
        }

        /* Clean content wrapper (Tightly tucked to the left edge) */
        .hero-left-content {
            position: relative;
            z-index: 10;
            max-width: 410px;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(203, 213, 225, 0.8);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
        html.dark-theme .hero-pill {
            background: rgba(15, 23, 42, 0.92);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);
            color: #93c5fd;
        }

        .btn-campus-focus {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1.5px solid rgba(191, 219, 254, 0.9);
            border-radius: 100px;
            padding: 6px 15px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
        }
        .btn-campus-focus:hover {
            background: var(--primary);
            color: #ffffff !important;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        }
        .btn-campus-focus:hover i {
            color: #ffffff !important;
        }
        html.dark-theme .btn-campus-focus {
            background: rgba(15, 23, 42, 0.92);
            border-color: rgba(96, 165, 250, 0.35);
            color: #ffffff;
        }

        .pulse-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--emerald);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .hero-title {
            font-size: 33px;
            font-weight: 850;
            line-height: 1.22;
            margin: 14px 0 12px;
            max-width: 400px;
            color: #0f172a !important;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.85);
            letter-spacing: -0.025em;
        }
        @media (min-width: 1400px) {
            .hero-title { font-size: 36px; max-width: 420px; }
        }
        html.dark-theme .hero-title {
            color: #ffffff !important;
            text-shadow: 0 2px 14px rgba(0, 0, 0, 0.7);
        }

        .hero-description {
            font-size: 14px;
            line-height: 1.62;
            margin-bottom: 22px;
            color: #1e293b !important;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.85);
            max-width: 390px;
        }
        html.dark-theme .hero-description {
            color: #cbd5e1 !important;
            font-weight: 500;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.6);
        }

        /* Role Switcher Pills */
        .role-switch-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 4px;
            display: inline-flex;
            gap: 4px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }
        html.dark-theme .role-switch-wrapper {
            background: rgba(15, 23, 42, 0.92);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);
        }

        .role-switch-btn {
            border: 1px solid transparent;
            background: transparent;
            color: #64748b;
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .role-switch-btn:hover {
            color: #2563eb;
            background: #f8fafc;
        }
        .role-switch-btn.active {
            background: #eff6ff;
            color: #2563eb !important;
            font-weight: 700;
            border-color: #bfdbfe;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);
        }
        html.dark-theme .role-switch-btn {
            color: #cbd5e1;
        }
        html.dark-theme .role-switch-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }
        html.dark-theme .role-switch-btn.active {
            background: #1e293b;
            color: #60a5fa !important;
            border-color: rgba(96, 165, 250, 0.35);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-trust-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            flex-wrap: wrap;
        }
        html.dark-theme .hero-trust-bar {
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            color: #1e293b;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 5px 12px;
            border-radius: 100px;
            border: 1px solid rgba(203, 213, 225, 0.85);
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }
        .trust-item:hover {
            transform: translateY(-1px);
            border-color: #bfdbfe;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.08);
        }
        html.dark-theme .trust-item {
            background: rgba(15, 23, 42, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        .trust-item i {
            color: var(--primary);
            font-size: 15px;
        }

        /* ================= 🖥️ RIGHT COLUMN: APP SHOWCASE WINDOW ================= */
        .showcase-window-wrapper {
            position: relative;
        }
        .showcase-window-wrapper::before {
            content: '';
            position: absolute;
            top: -20px; right: -20px; bottom: -20px; left: -20px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.12) 0%, rgba(99, 102, 241, 0.06) 50%, transparent 70%);
            border-radius: 40px;
            z-index: 0;
            pointer-events: none;
        }
        html.dark-theme .showcase-window-wrapper::before {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.22) 0%, rgba(129, 140, 248, 0.12) 50%, transparent 70%);
        }

        .showcase-window {
            background: rgba(255, 255, 255, 0.80) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.85) !important;
            box-shadow: 0 12px 32px -8px rgba(15, 23, 42, 0.10), 0 0 0 1px rgba(255, 255, 255, 0.6) !important;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }
        html.dark-theme .showcase-window {
            background: rgba(15, 23, 42, 0.68) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-color: rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.45) !important;
        }
        .showcase-window:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 45px -10px rgba(37, 99, 235, 0.16), 0 0 0 1px rgba(37, 99, 235, 0.3) !important;
        }
        .window-header {
            background: rgba(248, 250, 252, 0.85);
            border-bottom: 1px solid #e2e8f0;
            padding: 9px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        html.dark-theme .window-header {
            background: rgba(30, 41, 59, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .window-dots {
            display: flex;
            gap: 5px;
        }
        .dot {
            width: 9px; height: 9px;
            border-radius: 50%;
        }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        .window-url-bar {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 3px 12px;
            font-size: 11px;
            color: #475569;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        }
        html.dark-theme .window-url-bar {
            background: rgba(15, 23, 42, 0.85);
            border-color: rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
        }

        .showcase-body {
            padding: 16px 18px;
        }

        .preview-avatar-box {
            width: 38px; height: 38px;
            border-radius: 11px;
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
        }

        .geofence-radar-box {
            background: #f8fafc !important;
            border: 1px solid #dbeafe !important;
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.04);
        }
        html.dark-theme .geofence-radar-box {
            background: rgba(30, 41, 59, 0.65) !important;
            border-color: rgba(59, 130, 246, 0.3) !important;
        }

        .radar-pulse-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .mockup-stat-tile {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 11px;
            padding: 8px 10px;
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.02);
            transition: all 0.2s ease;
        }
        .mockup-stat-tile:hover {
            transform: translateY(-2px);
            border-color: #bfdbfe !important;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.08);
        }
        html.dark-theme .mockup-stat-tile {
            background: rgba(30, 41, 59, 0.65) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* ================= 🍱 BENTO GRID SECTION ================= */
        .section-tag {
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 100px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.25);
            display: inline-block;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 38px;
            font-weight: 850;
            margin-bottom: 12px;
        }
        .section-subtitle {
            font-size: 16.5px;
            max-width: 620px;
            margin: 0 auto;
        }

        .bento-card {
            background: var(--bg-card);
            border-radius: 22px;
            padding: 32px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-card);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .bento-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 3.5px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .bento-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--border-highlight);
        }
        .bento-card:hover::before {
            opacity: 1;
        }
        .bento-icon-wrapper {
            width: 54px; height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .bento-card:hover .bento-icon-wrapper {
            transform: scale(1.08) rotate(4deg);
        }

        .card-inner-strip {
            background: var(--bg-strip);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 14px 18px;
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: gap-2;
        }

        /* ================= 👥 USER PORTAL CARDS ================= */
        .portal-section {
            padding: 85px 0;
            background: var(--bg-input);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }
        .portal-card {
            background: var(--bg-card-solid);
            border-radius: 22px;
            border: 1px solid var(--border-color);
            padding: 36px 28px;
            text-align: center;
            transition: all 0.35s ease;
            box-shadow: var(--shadow-card);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .portal-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
        }
        .portal-avatar-icon {
            width: 70px; height: 70px;
            border-radius: 50%;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            transition: transform 0.3s ease;
        }
        .portal-card:hover .portal-avatar-icon {
            transform: scale(1.1);
        }
        .feature-checklist {
            list-style: none;
            padding: 0;
            margin: 20px 0 28px;
            text-align: left;
        }
        .feature-checklist li {
            padding: 8px 0;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-body) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .feature-checklist li i {
            color: var(--emerald);
            font-size: 17px;
        }

        .btn-portal-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 13px 20px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14.5px;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-portal-siswa {
            background: #eff6ff;
            color: #2563eb !important;
            border: 1.5px solid #bfdbfe;
        }
        .btn-portal-siswa:hover {
            background: #2563eb;
            color: #ffffff !important;
            border-color: #2563eb;
            box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.4);
            transform: translateY(-2px);
        }
        html.dark-theme .btn-portal-siswa {
            background: rgba(37, 99, 235, 0.15);
            border-color: rgba(96, 165, 250, 0.4);
            color: #60a5fa !important;
        }
        html.dark-theme .btn-portal-siswa:hover {
            background: #2563eb;
            color: #ffffff !important;
        }

        .btn-portal-guru {
            background: #ecfdf5;
            color: #059669 !important;
            border: 1.5px solid #a7f3d0;
        }
        .btn-portal-guru:hover {
            background: #059669;
            color: #ffffff !important;
            border-color: #059669;
            box-shadow: 0 8px 20px -4px rgba(5, 150, 105, 0.4);
            transform: translateY(-2px);
        }
        html.dark-theme .btn-portal-guru {
            background: rgba(5, 150, 105, 0.15);
            border-color: rgba(52, 211, 153, 0.4);
            color: #34d399 !important;
        }
        html.dark-theme .btn-portal-guru:hover {
            background: #059669;
            color: #ffffff !important;
        }

        .btn-portal-admin {
            background: #fffbeb;
            color: #d97706 !important;
            border: 1.5px solid #fde68a;
        }
        .btn-portal-admin:hover {
            background: #d97706;
            color: #ffffff !important;
            border-color: #d97706;
            box-shadow: 0 8px 20px -4px rgba(217, 119, 6, 0.4);
            transform: translateY(-2px);
        }
        html.dark-theme .btn-portal-admin {
            background: rgba(217, 119, 6, 0.15);
            border-color: rgba(251, 191, 36, 0.4);
            color: #fbbf24 !important;
        }
        html.dark-theme .btn-portal-admin:hover {
            background: #d97706;
            color: #ffffff !important;
        }

        /* ================= ❓ FAQ ACCORDION ================= */
        .accordion-modern .accordion-item {
            border: 1px solid var(--border-color);
            border-radius: 14px !important;
            margin-bottom: 12px;
            overflow: hidden;
            background: var(--bg-card-solid);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }
        .accordion-modern .accordion-button {
            padding: 18px 22px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 16.5px;
            color: var(--text-heading) !important;
            background: var(--bg-card-solid);
            box-shadow: none !important;
        }
        .accordion-modern .accordion-button:not(.collapsed) {
            color: var(--primary) !important;
            background: rgba(37, 99, 235, 0.06);
        }
        .accordion-modern .accordion-body {
            padding: 0 22px 20px;
            color: var(--text-body) !important;
            font-size: 14.5px;
            line-height: 1.7;
        }

        /* ================= 🌌 FOOTER ================= */
        footer {
            background: var(--bg-card-solid);
            color: var(--text-body);
            padding: 70px 0 30px;
            border-top: 1px solid var(--border-color);
            position: relative;
        }
        .footer-brand-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 850;
            font-size: 22px;
            color: var(--text-heading);
        }
        .footer-link {
            color: var(--text-body) !important;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .footer-link:hover {
            color: var(--primary) !important;
            transform: translateX(4px);
        }
        .social-pill {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-heading);
            font-size: 17px;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .social-pill:hover {
            background: var(--primary);
            color: #ffffff !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.4);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-section {
                padding: 110px 0 50px;
                text-align: center;
                background-image: 
                    linear-gradient(180deg, rgba(255, 255, 255, 0.25) 0%, transparent 20%, transparent 72%, var(--bg-page) 100%),
                    url("{{ asset('template/images/gedung_smk_almadani.jpg') }}?v=4");
            }
            html.dark-theme .hero-section {
                background-image: 
                    linear-gradient(180deg, transparent 72%, var(--bg-page) 100%),
                    linear-gradient(180deg, rgba(8, 13, 26, 0.7) 0%, rgba(8, 13, 26, 0.5) 50%, var(--bg-page) 100%),
                    url("{{ asset('template/images/gedung_smk_almadani.jpg') }}?v=4");
            }
            .hero-title { font-size: 32px; margin: 0 auto 14px; }
            .hero-description { margin: 0 auto 20px; }
            .hero-trust-bar { justify-content: center; }
            .showcase-window { margin-top: 24px; }
            .hero-glass-card { padding: 24px 20px; text-align: center; }
        }
        @media (max-width: 576px) {
            .hero-title { font-size: 26px; }
            .btn-modern-primary, .btn-modern-secondary { width: 100%; justify-content: center; }

            /* Segmented Role Switcher on Mobile */
            .role-switch-wrapper {
                width: 100%;
                display: flex;
                flex-direction: row;
                gap: 4px;
                padding: 4px;
                background: rgba(15, 23, 42, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 14px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .role-switch-btn {
                flex: 1 1 0;
                justify-content: center;
                text-align: center;
                font-size: 11.5px;
                padding: 8px 4px;
                white-space: nowrap;
                border-radius: 9px;
            }
            .role-switch-btn i {
                font-size: 13px;
            }

            /* Window Header on Mobile */
            .window-header {
                padding: 8px 10px;
                gap: 6px;
            }
            .window-dots {
                gap: 4px;
            }
            .dot {
                width: 7px;
                height: 7px;
            }
            .window-url-bar {
                padding: 3px 8px;
                font-size: 10px;
                max-width: 155px;
            }
            .window-url-bar span {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                display: inline-block;
                max-width: 125px;
            }
            .window-header .badge {
                font-size: 9px !important;
                padding: 3px 6px !important;
            }

            /* Showcase Body on Mobile */
            .showcase-body {
                padding: 12px 10px;
            }
            .preview-avatar-box {
                width: 34px;
                height: 34px;
                font-size: 13px;
                border-radius: 9px;
            }
            .mockup-stat-tile {
                padding: 7px 4px;
            }
            .mockup-stat-tile .fs-5 {
                font-size: 14px !important;
                margin: 2px 0 !important;
            }
            .mockup-stat-tile .small {
                font-size: 9.5px !important;
            }
            .mockup-stat-tile .badge {
                font-size: 8.5px !important;
                padding: 2px 4px !important;
            }

            /* Geofence radar card on mobile */
            .geofence-radar-box {
                padding: 8px 10px;
            }
            .radar-pulse-icon {
                width: 26px;
                height: 26px;
                font-size: 13px;
            }

            /* User Portal cards on mobile */
            .portal-card {
                padding: 26px 18px;
                border-radius: 18px;
            }
            .portal-avatar-icon {
                width: 56px;
                height: 56px;
                font-size: 24px;
                margin-bottom: 14px;
            }
            .feature-checklist li {
                font-size: 13px;
                padding: 6px 0;
            }
            .btn-portal-action {
                padding: 12px 16px;
                font-size: 13.5px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Lights -->
    <div class="ambient-mesh">
        <div class="glow-sphere glow-1"></div>
        <div class="glow-sphere glow-2"></div>
    </div>

    <!-- 🚀 STICKY GLASS NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top glass-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('template/images/smk madani.jpg') }}" alt="Logo SMK Al-Madani" class="school-logo-pill" />
                <div class="ms-2">
                    <span class="fw-bold font-heading" style="font-size: 19px; color: var(--text-heading);">E-Learning</span>
                    <span class="gradient-text font-heading fw-bold" style="font-size: 19px;">Madani</span>
                    <span class="brand-badge d-none d-sm-inline">Smart School</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list fs-2" style="color: var(--text-heading);"></i>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#demo-live">Demo Sistem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#fitur">Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#portal">Portal Akses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#faq">FAQ</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center justify-content-center gap-2 mt-3 mt-lg-0">
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="btn-modern-primary py-2 px-3">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sistem
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 🌌 HERO SECTION (CINEMATIC CAMPUS HERO - TUCKED TO THE LEFT EDGE) -->
    <section class="hero-section" id="beranda">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row align-items-center">
                
                <!-- Main Value Proposition (Tightly aligned to the far left) -->
                <div class="col-12 col-md-6 col-lg-5 col-xl-4 text-start hero-left-col">
                    <div class="hero-left-content">
                    
                        <!-- Top Pill with Pulse, Realtime Clock, & Full Campus View Toggle -->
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <div class="hero-pill">
                                <span class="pulse-dot"></span>
                                <span>SMK Al-Madani Pontianak</span>
                            </div>
                            <div class="hero-pill" style="border-color: rgba(16, 185, 129, 0.4);">
                                <i class="bi bi-clock-fill text-success"></i>
                                <span id="live-clock">--:--:-- WIB</span>
                            </div>
                            <button type="button" class="btn-campus-focus" id="campusViewToggleBtn" onclick="toggleCampusFocus()" title="Klik untuk melihat foto gedung sekolah secara utuh">
                                <i class="bi bi-eye-fill me-1 text-primary"></i> <span id="campusToggleText">Lihat Foto Kampus</span>
                            </button>
                        </div>

                        <!-- Main Dynamic Headline -->
                        <h1 class="hero-title">
                            Belajar Mandiri, Presensi Presisi, <span class="gradient-text">Prestasi Teruji.</span>
                        </h1>

                        <!-- Subtitle (High Contrast) -->
                        <p class="hero-description">
                            Ekosistem pembelajaran digital terpadu SMK Al-Madani Pontianak: Presensi berbasis radius GPS Geofencing, modul RPP Kurikulum Merdeka berbantuan AI, dan analisis siswa teladan dengan algoritma ilmiah SAW.
                        </p>

                        <!-- Call To Action Buttons (Tucked compactly to the left) -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <a href="{{ route('login') }}" class="btn-modern-primary py-2 px-3 fs-6" id="cta-login-btn">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sistem
                            </a>
                            <a href="#demo-live" class="btn-modern-secondary py-2 px-3 fs-6">
                                <i class="bi bi-play-circle-fill me-1 text-primary"></i> Demo Sistem
                            </a>
                            <a href="#fitur" class="btn-modern-secondary py-2 px-3 fs-6">
                                <i class="bi bi-grid-1x2-fill me-1"></i> Fitur
                            </a>
                        </div>

                        <!-- Trust Bar / Key Highlights -->
                        <div class="hero-trust-bar">
                            <div class="trust-item">
                                <i class="bi bi-shield-check"></i>
                                <span>GPS Geofencing 50m</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-stars"></i>
                                <span>RPP AI Generator</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-award"></i>
                                <span>Matriks Ranking SAW</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 💻 SECTION: INTERACTIVE LIVE SYSTEM DEMO -->
    <section class="py-5" id="demo-live" style="background: var(--bg-card); border-bottom: 1px solid var(--border-color);">
        <div class="container py-4">
            <div class="row align-items-center justify-content-between g-5">
                
                <!-- Left: Info & Role Selector -->
                <div class="col-lg-5 text-start">
                    <span class="section-tag"><i class="bi bi-display me-1"></i> Live Interactive Demo</span>
                    <h2 class="section-title">Eksplorasi Fitur <span class="gradient-text">Smart School</span></h2>
                    <p class="text-secondary mb-4" style="color: var(--text-body) !important; font-size: 15px; line-height: 1.7;">
                        Coba simulasi langsung antarmuka digital E-Learning SMK Al-Madani. Pilih peran di bawah untuk melihat fitur presensi geofencing siswa, modul ajar RPP AI guru, dan analisis perankingan siswa dengan metode SAW.
                    </p>

                    <!-- Role Switcher -->
                    <div class="mb-4">
                        <div class="small fw-bold mb-2 text-uppercase" style="letter-spacing: 0.5px; font-size: 11px; color: var(--text-body);">
                            <i class="bi bi-person-lines-fill me-1"></i> Pilih Simulasi Peran:
                        </div>
                        <div class="role-switch-wrapper">
                            <button type="button" class="role-switch-btn active" onclick="switchRole('siswa')">
                                <i class="bi bi-mortarboard-fill"></i> Siswa
                            </button>
                            <button type="button" class="role-switch-btn" onclick="switchRole('guru')">
                                <i class="bi bi-person-workspace"></i> Guru
                            </button>
                            <button type="button" class="role-switch-btn" onclick="switchRole('saw')">
                                <i class="bi bi-trophy-fill"></i> Analisis SAW
                            </button>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="{{ route('login') }}" class="btn-modern-primary py-2 px-4" id="demo-login-btn">
                            <i class="bi bi-rocket-takeoff-fill me-1"></i> Masuk ke Portal Siswa
                        </a>
                        <a href="#fitur" class="btn-modern-secondary py-2 px-4">
                            <i class="bi bi-grid-1x2-fill me-1"></i> Pelajari Fitur
                        </a>
                    </div>
                </div>

                <!-- Right: The Showcase Window (Mac style browser window) -->
                <div class="col-lg-7">
                    <div class="showcase-window text-start">
                        
                        <!-- Window Header -->
                        <div class="window-header">
                            <div class="window-dots">
                                <span class="dot dot-red"></span>
                                <span class="dot dot-yellow"></span>
                                <span class="dot dot-green"></span>
                            </div>
                            <div class="window-url-bar">
                                <i class="bi bi-lock-fill text-success" style="font-size: 11px;"></i>
                                <span id="window-url-text">elearning.smkalmadani.sch.id/siswa</span>
                            </div>
                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 10px;">
                                <i class="bi bi-broadcast me-1"></i> Live Sistem
                            </span>
                        </div>

                        <!-- Window Content: TAB 1 (SISWA) -->
                        <div id="tab-siswa-view" class="showcase-body">
                            <!-- Student Profile Bar -->
                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2 gap-sm-3">
                                    <div class="preview-avatar-box">AF</div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Ahmad Fajarudin</h6>
                                        <div class="small" style="color: var(--text-body); font-size: 11.5px; font-weight: 500;">Kelas XII RPL 1 &bull; NIS: 20261104</div>
                                    </div>
                                </div>
                                <span class="badge bg-primary-subtle text-primary fw-bold px-2.5 py-1.5 rounded-pill" style="font-size: 10.5px;">Siswa Aktif</span>
                            </div>

                            <!-- Geofencing Real-Time Verification Card -->
                            <div class="geofence-radar-box">
                                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="radar-pulse-icon">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold small" style="color: var(--text-heading); font-size: 12.5px;">Presensi Geofencing GPS</div>
                                            <div class="small" style="font-size: 10.5px; color: var(--text-body);">SMK Al-Madani Pontianak</div>
                                        </div>
                                    </div>
                                    <span class="badge bg-success text-white px-2 py-1" style="font-size: 10px;">Radius Valid</span>
                                </div>
                                <div class="p-2 rounded-3 small d-flex justify-content-between align-items-center mt-2 flex-wrap gap-1" style="background: var(--bg-card); border: 1px solid var(--border-color); font-size: 11.5px;">
                                    <span style="color: var(--text-body); font-weight: 500;">Jarak ke Sekolah:</span>
                                    <strong class="text-success"><i class="bi bi-check2-circle me-1"></i> 32 Meter (Tervalidasi)</strong>
                                </div>
                            </div>

                            <!-- Metrics Tiles -->
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="mockup-stat-tile text-center">
                                        <div class="small fw-bold" style="font-size: 11px; color: var(--text-body);">Kehadiran</div>
                                        <div class="fs-5 fw-bold text-primary">98.5%</div>
                                        <span class="badge bg-success-subtle text-success" style="font-size: 9.5px;">Rajin</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mockup-stat-tile text-center">
                                        <div class="small fw-bold" style="font-size: 11px; color: var(--text-body);">Tugas</div>
                                        <div class="fs-5 fw-bold text-success">18 / 20</div>
                                        <span class="badge bg-info-subtle text-info" style="font-size: 9.5px;">Selesai</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mockup-stat-tile text-center">
                                        <div class="small fw-bold" style="font-size: 11px; color: var(--text-body);">Ujian CBT</div>
                                        <div class="fs-5 fw-bold text-warning">94.0</div>
                                        <span class="badge bg-warning-subtle text-warning" style="font-size: 9.5px;">Unggul</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Today Schedule Item -->
                            <div class="p-2 px-3 rounded-3 border" style="background: var(--bg-card); border-color: var(--border-color) !important;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-laptop text-primary fs-5"></i>
                                        <div>
                                            <div class="fw-bold small" style="color: var(--text-heading); font-size: 12.5px;">Pemrograman Web & Mobile</div>
                                            <div class="small" style="font-size: 10.5px; color: var(--text-body); font-weight: 500;">Pak Budi, M.Kom &bull; 07.30 - 09.30 WIB</div>
                                        </div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success" style="font-size: 10px;">Berlangsung</span>
                                </div>
                            </div>

                        </div>

                        <!-- Window Content: TAB 2 (GURU) -->
                        <div id="tab-guru-view" class="showcase-body d-none">
                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2 gap-sm-3">
                                    <div class="preview-avatar-box" style="background: linear-gradient(135deg, #10b981, #059669);">BK</div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Budi Kusuma, S.Kom</h6>
                                        <div class="small" style="color: var(--text-body); font-size: 11.5px; font-weight: 500;">Guru Produktif RPL &bull; Wali Kelas XII RPL 1</div>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1.5 rounded-pill" style="font-size: 10.5px;">Wali Kelas</span>
                            </div>

                            <!-- AI Assistant Box -->
                            <div class="p-3 rounded-3 mb-3" style="background: var(--bg-strip); border: 1.5px solid var(--border-highlight);">
                                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-1">
                                    <span class="fw-bold small" style="color: var(--accent); font-size: 12.5px;"><i class="bi bi-magic me-1"></i> Asisten RPP AI Kurikulum Merdeka</span>
                                    <span class="badge bg-primary" style="font-size: 9.5px;">1-Click</span>
                                </div>
                                <p class="card-desc small mb-2" style="font-size: 11.5px; line-height: 1.45;">
                                    Modul ajar dan asesmen kompetensi ter-generate otomatis sesuai standar Kurikulum Merdeka.
                                </p>
                                <div class="p-2 rounded-2 small" style="font-size: 10.5px; background: var(--bg-card); border: 1px solid var(--border-color); line-height: 1.4;">
                                    <strong>Tema:</strong> Arsitektur Database & REST API Laravel &bull; Status: <span class="text-success fw-bold">Siap Dicetak</span>
                                </div>
                            </div>

                            <!-- Monitoring Progress -->
                            <div class="p-3 rounded-3 border" style="background: var(--bg-card); border-color: var(--border-color) !important;">
                                <div class="d-flex justify-content-between small mb-1 flex-wrap gap-1" style="color: var(--text-body); font-weight: 500; font-size: 12px;">
                                    <span>Presensi Kelas XII RPL 1:</span>
                                    <strong class="text-success">32 Hadir (94%)</strong>
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 94%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small pt-1 border-top flex-wrap gap-1" style="color: var(--text-body); font-size: 11px;">
                                    <span>2 Siswa Izin Sakit</span>
                                    <span class="badge bg-light text-dark border">Cetak Rekap PDF</span>
                                </div>
                            </div>
                        </div>

                        <!-- Window Content: TAB 3 (SAW RANKING) -->
                        <div id="tab-saw-view" class="showcase-body d-none">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge bg-warning-subtle text-warning fw-bold px-2 py-1 mb-1" style="font-size: 10px;">Sistem Pendukung Keputusan</span>
                                    <h6 class="fw-bold m-0">Ranking Prestasi Metode SAW</h6>
                                </div>
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(245, 158, 11, 0.15); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                            </div>

                            <p class="card-desc small mb-3" style="font-size: 12.5px;">
                                Penilaian objektif berdasarkan bobot C1 (Tugas 50%), C2 (Kehadiran 20%), dan C3 (Kedisiplinan 30%).
                            </p>

                            <!-- Table Mini Ranking -->
                            <div class="table-responsive border rounded-3 overflow-hidden">
                                <table class="table table-sm table-hover m-0" style="font-size: 12px; color: var(--text-heading);">
                                    <thead style="background: var(--bg-input);">
                                        <tr>
                                            <th>Rank</th>
                                            <th>Nama Siswa</th>
                                            <th>Skor V</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-warning text-dark">
                                            <td><strong>🥇 1</strong></td>
                                            <td><strong>Ahmad Fajarudin</strong></td>
                                            <td><strong>0.984</strong></td>
                                            <td><span class="badge bg-success">Juara Kelas</span></td>
                                        </tr>
                                        <tr>
                                            <td>🥈 2</td>
                                            <td>Siti Nurhaliza</td>
                                            <td>0.942</td>
                                            <td><span class="badge bg-primary">Sangat Baik</span></td>
                                        </tr>
                                        <tr>
                                            <td>🥉 3</td>
                                            <td>Dimas Pratama</td>
                                            <td>0.915</td>
                                            <td><span class="badge bg-primary">Sangat Baik</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 🍱 BENTO GRID: FITUR UTAMA (100% CONTRAST GUARANTEED) -->
    <section class="py-5" id="fitur">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="section-tag">Arsitektur Digital Kreatif</span>
                <h2 class="section-title">Fitur Masa Depan Sekolah Modern</h2>
                <p class="section-subtitle">
                    Kombinasi teknologi presensi terverifikasi, otomasi kecerdasan buatan, dan evaluasi berbasis algoritma ilmiah.
                </p>
            </div>

            <div class="row g-4">
                
                <!-- BENTO 1: Smart Geofencing (8 Kolom) -->
                <div class="col-lg-8">
                    <div class="bento-card">
                        <div>
                            <div class="bento-icon-wrapper" style="background: rgba(37, 99, 235, 0.12); color: var(--primary);">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-3 font-heading">Presensi Geofencing GPS & Izin Digital</h4>
                            <p class="card-desc" style="font-size: 15px; font-weight: 500;">
                                Mencegah kecurangan dan titip absen dengan memvalidasi koordinat lokasi perangkat siswa secara real-time terhadap radius resmi SMK Al-Madani Pontianak. Siswa yang berhalangan dapat langsung melampirkan surat keterangan secara digital untuk diverifikasi guru.
                            </p>
                        </div>
                        <div class="card-inner-strip">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-shield-check text-success fs-4"></i>
                                <span class="small fw-bold" style="color: var(--text-heading);">Radius Sekolah Terproteksi &bull; Anti Fake GPS</span>
                            </div>
                            <span class="badge bg-primary px-3 py-2 fw-bold">Realtime Coordinates</span>
                        </div>
                    </div>
                </div>

                <!-- BENTO 2: AI RPP Generator (4 Kolom) -->
                <div class="col-lg-4">
                    <div class="bento-card">
                        <div>
                            <div class="bento-icon-wrapper" style="background: rgba(79, 70, 229, 0.12); color: var(--accent);">
                                <i class="bi bi-magic"></i>
                            </div>
                            <h4 class="fw-bold mb-3 font-heading">Asisten RPP AI</h4>
                            <p class="card-desc" style="font-size: 14.5px; font-weight: 500;">
                                Guru dapat membuat dokumen RPP Kurikulum Merdeka lengkap dengan capaian pembelajaran dan instrumen evaluasi secara instan menggunakan kecerdasan buatan.
                            </p>
                        </div>
                        <div class="mt-4">
                            <span class="badge bg-primary text-white px-3 py-2 fw-bold">
                                <i class="bi bi-stars"></i> Otomasi 1-Click
                            </span>
                        </div>
                    </div>
                </div>

                <!-- BENTO 3: CBT & Ujian Digital (4 Kolom) -->
                <div class="col-lg-4">
                    <div class="bento-card">
                        <div>
                            <div class="bento-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: var(--emerald);">
                                <i class="bi bi-laptop-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-3 font-heading">CBT & Ujian Digital</h4>
                            <p class="card-desc" style="font-size: 14.5px; font-weight: 500;">
                                Pelaksanaan kuis harian dan ujian sekolah terpusat tanpa kertas. Dilengkapi timer otomatis, pencegahan kecurangan, dan rekap nilai seketika.
                            </p>
                        </div>
                        <div class="mt-4">
                            <span class="badge bg-success text-white px-3 py-2 fw-bold">
                                <i class="bi bi-check-circle-fill"></i> Nilai Otomatis
                            </span>
                        </div>
                    </div>
                </div>

                <!-- BENTO 4: SPK SAW Decision Making (8 Kolom) -->
                <div class="col-lg-8">
                    <div class="bento-card">
                        <div>
                            <div class="bento-icon-wrapper" style="background: rgba(217, 119, 6, 0.12); color: var(--amber);">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-3 font-heading">Sistem Pendukung Keputusan (Metode SAW)</h4>
                            <p class="card-desc" style="font-size: 15px; font-weight: 500;">
                                Menghitung pemeringkatan siswa berprestasi dan kedisiplinan secara matematis melalui metode *Simple Additive Weighting*. Kriteria kehadiran, nilai tugas, dan keaktifan diproses secara transparan sehingga hasil juara kelas dapat dipertanggungjawabkan.
                            </p>
                        </div>
                        <div class="card-inner-strip">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-graph-up-arrow text-warning fs-4"></i>
                                <span class="small fw-bold" style="color: var(--text-heading);">Normalisasi Matriks Matematis &bull; Hasil Objektif</span>
                            </div>
                            <span class="badge fw-bold px-3 py-2" style="background: rgba(217, 119, 6, 0.15); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.3);">Decision Support</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 👥 USER PORTALS (ROLE ACCESS) -->
    <section class="portal-section" id="portal">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-tag">Akses Multi-Role</span>
                <h2 class="section-title">Portal Terpadu Seluruh Pengguna</h2>
                <p class="section-subtitle">
                    Silakan masuk ke portal login yang sesuai dengan hak akses Anda.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                
                <!-- SISWA -->
                <div class="col-lg-4 col-md-6">
                    <div class="portal-card">
                        <div>
                            <div class="portal-avatar-icon" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-2 font-heading">Portal Siswa</h4>
                            <p class="card-desc small" style="font-weight: 500;">Ruang mandiri belajar, absensi harian, dan pantau hasil evaluasi akademik.</p>
                            
                            <ul class="feature-checklist">
                                <li><i class="bi bi-check-circle-fill"></i> Presensi GPS Mandiri saat Jam Belajar</li>
                                <li><i class="bi bi-check-circle-fill"></i> Unduh E-Modul & Materi Interaktif</li>
                                <li><i class="bi bi-check-circle-fill"></i> Kumpul Tugas & Kerjakan Ujian CBT</li>
                                <li><i class="bi bi-check-circle-fill"></i> Cek Peringkat Prestasi & Izin Sakit</li>
                            </ul>
                        </div>
                        <a href="{{ route('login') }}" class="btn-portal-action btn-portal-siswa w-100">
                            Masuk Portal Siswa <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- GURU -->
                <div class="col-lg-4 col-md-6">
                    <div class="portal-card">
                        <div>
                            <div class="portal-avatar-icon" style="background: rgba(5, 150, 105, 0.12); color: #059669;">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <h4 class="fw-bold mb-2 font-heading">Portal Guru</h4>
                            <p class="card-desc small" style="font-weight: 500;">Kelola kelas, input presensi, evaluasi tugas, dan susun modul dengan AI.</p>
                            
                            <ul class="feature-checklist">
                                <li><i class="bi bi-check-circle-fill text-success"></i> Kelola Presensi Siswa & Kelas Binaan</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Generate RPP Kurikulum Merdeka AI</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Buat Bank Soal & Ujian Online CBT</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Rekap Nilai & Cetak Surat Panggilan</li>
                            </ul>
                        </div>
                        <a href="{{ route('login') }}" class="btn-portal-action btn-portal-guru w-100">
                            Masuk Portal Guru <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- ADMIN -->
                <div class="col-lg-4 col-md-6">
                    <div class="portal-card">
                        <div>
                            <div class="portal-avatar-icon" style="background: rgba(217, 119, 6, 0.12); color: #d97706;">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-2 font-heading">Portal Admin / Operator</h4>
                            <p class="card-desc small" style="font-weight: 500;">Kendali penuh master data, jadwal KBM, dan konfigurasi sistem sekolah.</p>
                            
                            <ul class="feature-checklist">
                                <li><i class="bi bi-check-circle-fill text-warning"></i> Kelola Master Guru, Siswa, & Jurusan</li>
                                <li><i class="bi bi-check-circle-fill text-warning"></i> Atur Koordinat & Radius Geofencing</li>
                                <li><i class="bi bi-check-circle-fill text-warning"></i> Konfigurasi Kriteria & Bobot SAW</li>
                                <li><i class="bi bi-check-circle-fill text-warning"></i> Ekspor Laporan Rekap PDF & Excel</li>
                            </ul>
                        </div>
                        <a href="{{ route('login') }}" class="btn-portal-action btn-portal-admin w-100">
                            Masuk Portal Admin <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 🏫 KAMPUS AL-MADANI SHOWCASE BANNER -->
    <section class="py-4">
        <div class="container">
            <div class="campus-showcase-card p-4 p-md-5 text-white" style="
                background: linear-gradient(135deg, #0b1329 0%, #1e293b 45%, #1e3a8a 100%);
                border-radius: 28px;
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
                position: relative;
                overflow: hidden;
            ">
                <!-- Abstract Decorative Ambient Orbs -->
                <div style="position: absolute; top: -50px; right: -50px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, rgba(59, 130, 246, 0.35) 0%, transparent 70%); pointer-events: none;"></div>
                <div style="position: absolute; bottom: -70px; left: 25%; width: 280px; height: 280px; border-radius: 50%; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%); pointer-events: none;"></div>

                <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <span class="badge bg-success px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="font-size: 11px;">
                            <i class="bi bi-geo-alt-fill me-1"></i> Kampus SMK Al-Madani Pontianak
                        </span>
                        <h2 class="fw-bold text-white mb-2" style="font-size: 2.1rem;">
                            Lingkungan Belajar Asri & Terintegrasi Digital
                        </h2>
                        <p class="text-white-50 mb-4" style="font-size: 15px; max-width: 620px; line-height: 1.7;">
                            Gedung kampus Yayasan Al-Madani Syarif Abdurrahman Pontianak dilengkapi laboratorium komputer modern, koneksi internet terpadu, serta sistem presensi Geofencing GPS presisi.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
                            </a>
                            <a href="https://www.google.com/maps/place/Al+Madani/@-0.0716603,109.3588745,17z" target="_blank" class="btn btn-outline-light rounded-pill px-4 py-2.5 fw-bold">
                                <i class="bi bi-compass me-1"></i> Buka Peta Lokasi
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end d-none d-lg-block">
                        <div class="d-inline-flex flex-column gap-2 text-start p-3 rounded-4" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.25);">
                            <div class="small text-white-50"><i class="bi bi-check-circle-fill text-success me-1"></i> Status Kampus</div>
                            <div class="fw-bold text-white fs-6">Aktif & Terverifikasi</div>
                            <div class="small text-white-50 mt-1"><i class="bi bi-pin-map-fill text-warning me-1"></i> Pontianak Tenggara, Kalbar</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ❓ FAQ ACCORDION -->
    <section class="py-5" id="faq">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <span class="section-tag">Pusat Informasi</span>
                        <h2 class="section-title">Pertanyaan Umum (FAQ)</h2>
                        <p class="section-subtitle">
                            Seputar cara kerja sistem E-Learning dan fitur pintar di SMK Al-Madani Pontianak.
                        </p>
                    </div>

                    <div class="accordion accordion-modern" id="faqAccordion">
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Bagaimana cara kerja presensi radius GPS (Geofencing)?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Siswa membuka fitur presensi dari smartphone pada saat jam belajar aktif. Sistem akan meminta izin GPS dan menghitung jarak posisi siswa ke titik pusat sekolah. Jika siswa berada dalam radius yang telah ditentukan (misal 50 meter), presensi tercatat otomatis.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana guru menggunakan fitur RPP AI?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Guru cukup memilih mata pelajaran, kelas, dan topik materi yang akan diajarkan. Sistem kecerdasan buatan akan menyusun rencana pembelajaran sesuai format Kurikulum Merdeka secara otomatis dan siap diunduh.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Bagaimana ranking siswa dihitung dengan metode SAW?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Metode Simple Additive Weighting (SAW) mencari penjumlahan terbobot dari rating kinerja siswa. Kriteria meliputi pengumpulan tugas, persentase kehadiran, dan tingkat kedisiplinan. Hasilnya berupa nilai preferensi objektif untuk menentukan siswa teladan.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🌌 MODERN FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-5">
                
                <!-- School Info -->
                <div class="col-lg-4 col-md-12">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('template/images/smk madani.jpg') }}" alt="Logo" class="school-logo-pill" />
                        <div>
                            <div class="footer-brand-title">E-Learning Madani</div>
                            <div class="small fw-semibold" style="color: var(--text-body);">SMK Al-Madani Pontianak</div>
                        </div>
                    </div>
                    <p class="small mb-4" style="line-height: 1.7; color: var(--text-body);">
                        Inovasi digital untuk mendukung ekosistem pembelajaran modern, transparan, dan berkarakter unggul di Kalimantan Barat.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/share/1H5nzbD297/" class="social-pill" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/smkalmadaniptk_official/" class="social-pill" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="col-lg-2 col-md-4 col-6">
                    <h6 class="fw-bold mb-3 small text-uppercase" style="letter-spacing: 1px; color: var(--text-heading);">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li><a href="#beranda" class="footer-link">Beranda</a></li>
                        <li><a href="#fitur" class="footer-link">Fitur Unggulan</a></li>
                        <li><a href="#portal" class="footer-link">Portal Akses</a></li>
                        <li><a href="#faq" class="footer-link">Tanya Jawab</a></li>
                        <li><a href="{{ route('login') }}" class="footer-link">Login Sistem</a></li>
                    </ul>
                </div>

                <!-- Features Link -->
                <div class="col-lg-2 col-md-4 col-6">
                    <h6 class="fw-bold mb-3 small text-uppercase" style="letter-spacing: 1px; color: var(--text-heading);">Fitur Pintar</h6>
                    <ul class="list-unstyled">
                        <li><span class="footer-link">Presensi Geofencing</span></li>
                        <li><span class="footer-link">RPP AI Generator</span></li>
                        <li><span class="footer-link">CBT Ujian Digital</span></li>
                        <li><span class="footer-link">Analisis SPK SAW</span></li>
                        <li><span class="footer-link">E-Modul Pembelajaran</span></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-4">
                    <h6 class="fw-bold mb-3 small text-uppercase" style="letter-spacing: 1px; color: var(--text-heading);">Alamat & Kontak</h6>
                    <ul class="list-unstyled small" style="color: var(--text-body);">
                        <li class="d-flex gap-3 mb-3">
                            <i class="bi bi-geo-alt-fill text-primary fs-5"></i>
                            <span>Jl. Sungai Raya Dalam, Komplek Mitra Utama III No. 16 B, Kec. Pontianak Tenggara, Kota Pontianak, Kalimantan Barat</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-2">
                            <i class="bi bi-envelope-fill text-primary"></i>
                            <span>smkalmadani@gmail.com</span>
                        </li>
                        <li class="d-flex align-items-center gap-3">
                            <i class="bi bi-telephone-fill text-primary"></i>
                            <span>0561-8110-48</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="border-top mt-5 pt-4 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small" style="border-color: var(--border-color) !important; color: var(--text-body);">
                <div>
                    &copy; {{ date('Y') }} <strong>SMK Al-Madani Pontianak</strong>. Matakuliah Digital Kreatif.
                </div>
                <div>
                    Dibuat dengan <i class="bi bi-heart-fill text-danger"></i> untuk Kemajuan Pendidikan Digital
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Real-Time Clock WIB
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            const clockEl = document.getElementById('live-clock');
            if (clockEl) {
                clockEl.textContent = timeString + ' WIB';
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.glass-navbar');
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Landing page permanently locked in Dark Mode
        localStorage.setItem('elearning-theme', 'dark');

        // Interactive Role Switcher in Live Demo Section
        function switchRole(role) {
            const btnSiswa = document.getElementById('tab-siswa-view');
            const btnGuru = document.getElementById('tab-guru-view');
            const btnSaw = document.getElementById('tab-saw-view');
            const urlText = document.getElementById('window-url-text');
            const demoBtn = document.getElementById('demo-login-btn');

            if (!btnSiswa || !btnGuru || !btnSaw) return;

            // Reset all tabs
            btnSiswa.classList.add('d-none');
            btnGuru.classList.add('d-none');
            btnSaw.classList.add('d-none');

            // Reset switcher buttons
            const buttons = document.querySelectorAll('.role-switch-btn');
            buttons.forEach(b => b.classList.remove('active'));

            if (role === 'siswa') {
                btnSiswa.classList.remove('d-none');
                if (buttons[0]) buttons[0].classList.add('active');
                if (urlText) urlText.textContent = 'elearning.smkalmadani.sch.id/siswa';
                if (demoBtn) demoBtn.innerHTML = '<i class="bi bi-rocket-takeoff-fill me-1"></i> Masuk ke Portal Siswa';
            } else if (role === 'guru') {
                btnGuru.classList.remove('d-none');
                if (buttons[1]) buttons[1].classList.add('active');
                if (urlText) urlText.textContent = 'elearning.smkalmadani.sch.id/guru';
                if (demoBtn) demoBtn.innerHTML = '<i class="bi bi-person-workspace me-1"></i> Masuk ke Portal Guru';
            } else if (role === 'saw') {
                btnSaw.classList.remove('d-none');
                if (buttons[2]) buttons[2].classList.add('active');
                if (urlText) urlText.textContent = 'elearning.smkalmadani.sch.id/guru/analisis-siswa';
                if (demoBtn) demoBtn.innerHTML = '<i class="bi bi-trophy-fill me-1"></i> Akses Evaluasi Prestasi SAW';
            }
        }

        // Toggle Full Campus Background View Mode
        function toggleCampusFocus() {
            const hero = document.getElementById('beranda');
            const isFocused = hero.classList.toggle('campus-focus-mode');
            const btnText = document.getElementById('campusToggleText');
            const btn = document.getElementById('campusViewToggleBtn');
            const icon = btn.querySelector('i');
            
            if (isFocused) {
                btnText.textContent = 'Kembalikan Tampilan';
                icon.className = 'bi bi-x-circle-fill me-1 text-danger';
                btn.style.borderColor = 'rgba(239, 68, 68, 0.4)';
            } else {
                btnText.textContent = 'Lihat Foto Kampus';
                icon.className = 'bi bi-eye-fill me-1 text-primary';
                btn.style.borderColor = '';
            }
        }
    </script>
</body>
</html>
