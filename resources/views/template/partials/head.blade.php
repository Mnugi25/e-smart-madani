<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title> @yield('title', 'Dashboard')</title>

<!-- Theme Loader (Executes instantly to prevent page load flash) -->
<script>
    (function () {
        const darkMode = localStorage.getItem('dark-mode');
        if (darkMode === 'enabled') {
            document.documentElement.classList.add('dark-mode');
        }
    })();
</script>

<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('template/vendors/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('template/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('template/vendors/typicons/typicons.css') }}">
<link rel="stylesheet" href="{{ asset('template/vendors/simple-line-icons/css/simple-line-icons.css') }}">
<link rel="stylesheet" href="{{ asset('template/vendors/css/vendor.bundle.base.css') }}">

<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('template/js/select.dataTables.min.css') }}">

<!-- Google Fonts: Plus Jakarta Sans & Outfit -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<!-- inject:css -->
<link rel="stylesheet" href="{{ asset('template/css/vertical-layout-light/style.css') }}">

<!-- Favicon (SMK Al-Madani Logo) -->
<link rel="icon" type="image/jpeg" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />
<link rel="shortcut icon" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />

<!-- Global Design System & Dark Mode CSS -->
<style>
    /* ===================================================
       GLOBAL TYPOGRAPHY & MODERN DESIGN SYSTEM
       =================================================== */
    :root {
        --font-heading: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 20px;
        --radius-xl: 24px;
        --shadow-soft: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 0 0 1px rgba(226, 232, 240, 0.7);
        --shadow-hover: 0 12px 30px -4px rgba(15, 23, 42, 0.1), 0 0 0 1px rgba(59, 130, 246, 0.2);
    }

    body, .content-wrapper, .main-panel, input, select, textarea, button, p, span, li, a {
        font-family: var(--font-body) !important;
        letter-spacing: -0.01em;
    }

    h1, h2, h3, h4, h5, h6, .card-title, .brand-logo, .welcome-text {
        font-family: var(--font-heading) !important;
        letter-spacing: -0.02em;
    }

    /* Polish default cards */
    .card {
        border-radius: var(--radius-md) !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: var(--shadow-soft) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Table styling polish */
    .table thead th {
        font-family: var(--font-heading) !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0 !important;
        padding: 12px 16px !important;
    }
    .table tbody td {
        padding: 14px 16px !important;
        vertical-align: middle;
        font-size: 0.875rem;
    }

    /* Smooth Modern Scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.4);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.7);
    }

    /* Form Controls Polish */
    .form-control, .form-select {
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 9px 14px !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    /* ===================================================
       WHITE BORDER SEPARATOR BETWEEN NAVBAR & SIDEBAR
       =================================================== */
    .navbar,
    .navbar .navbar-brand-wrapper,
    .navbar .navbar-menu-wrapper {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
    }
    .sidebar {
        border-right: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    /* ===================================================
       DARK MODE THEME OVERRIDES
       =================================================== */
    html.dark-mode,
    html.dark-mode body {
        background-color: #09090b !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .content-wrapper,
    html.dark-mode .main-panel {
        background: #09090b !important;
    }
    
    /* Navbar & Sidebar in Dark Mode */
    html.dark-mode .navbar,
    html.dark-mode .navbar .navbar-menu-wrapper,
    html.dark-mode .navbar .navbar-brand-wrapper {
        background: #121212 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .sidebar,
    html.dark-mode .sidebar .sidebar-brand-wrapper {
        background: #121212 !important;
        border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-bottom: none !important;
    }
    .sidebar .nav .nav-item .nav-link:before,
    .sidebar .nav .nav-item .nav-link:after,
    .sidebar .nav .nav-item.active > .nav-link:before,
    .sidebar .nav .nav-item.active > .nav-link:after,
    .sidebar .nav:not(.sub-menu) > .nav-item:hover > .nav-link:before {
        display: none !important;
        content: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    html.dark-mode .sidebar .nav .nav-item .nav-link {
        color: #94a3b8 !important;
    }
    html.dark-mode .sidebar .nav .nav-item.active > .nav-link {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
    }
    html.dark-mode .sidebar .nav .nav-item.active > .nav-link i.menu-icon {
        color: #ffffff !important;
    }
    html.dark-mode .sidebar-mini .sidebar .nav .nav-item .sub-menu {
        background: #121212 !important;
    }

    /* Welcome block styling */
    html.dark-mode .welcome-text span.text-black {
        color: #ffd700 !important;
    }

    /* Helper classes for subtle gradient headers and white bodies that support Dark Mode */
    .card-header-subtle {
        background: linear-gradient(135deg, #f8faff 0%, #eef2ff 100%) !important;
        border-bottom: 1px solid #e8ecf8 !important;
    }
    .card-body-subtle {
        background: #ffffff !important;
    }
    html.dark-mode .card-header-subtle {
        background: linear-gradient(135deg, #18181b 0%, #09090b 100%) !important;
        border-bottom: 1px solid #27272a !important;
    }
    html.dark-mode .card-body-subtle {
        background: #18181b !important;
    }
    html.dark-mode .card-header-subtle h5 {
        color: #ffffff !important;
    }
    html.dark-mode .card-body-subtle span[style*="color: #374151"] {
        color: #e2e8f0 !important;
    }
    html.dark-mode .card-body-subtle div[style*="background: #f1f5f9"] {
        background: #27272a !important;
    }
    html.dark-mode .card-body-subtle div[style*="border-top: 1px solid #f1f5f9"] {
        border-top: 1px solid #27272a !important;
    }

    html.dark-mode .card:not(.bg-gradient-primary):not(.bg-gradient-saw),
    html.dark-mode .schedule-card-premium {
        background-color: #18181b !important;
        color: #e2e8f0 !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        border: 1px solid #27272a !important;
    }
    html.dark-mode .card .card-body,
    html.dark-mode .card-body {
        color: #e2e8f0 !important;
    }
    html.dark-mode .card .card-title,
    html.dark-mode .card-title.card-title-dash,
    html.dark-mode h1,
    html.dark-mode h2,
    html.dark-mode h3,
    html.dark-mode h4,
    html.dark-mode h5,
    html.dark-mode h6,
    html.dark-mode .text-dark,
    html.dark-mode .modal-title {
        color: #ffffff !important;
    }
    html.dark-mode p,
    html.dark-mode .text-muted,
    html.dark-mode .welcome-sub-text,
    html.dark-mode .breadcrumb-item.active {
        color: #94a3b8 !important;
    }

    /* Preserve pure white text on gradient & colored stat cards in Dark Mode */
    html.dark-mode .text-white,
    html.dark-mode .text-white *,
    html.dark-mode .text-white p,
    html.dark-mode .text-white span,
    html.dark-mode .text-white small,
    html.dark-mode .text-white i,
    html.dark-mode .stat-card-admin,
    html.dark-mode .stat-card-admin *,
    html.dark-mode .stat-card-admin p,
    html.dark-mode .stat-card-admin .card-title,
    html.dark-mode .stat-card-admin .card-val,
    html.dark-mode .stat-card-admin .small,
    html.dark-mode .stat-card-admin span,
    html.dark-mode .stat-card-admin i {
        color: #ffffff !important;
    }
    html.dark-mode .stat-card-admin .card-title {
        color: #ffffff !important;
        opacity: 0.95 !important;
    }
    html.dark-mode .stat-card-admin .small {
        color: #ffffff !important;
        opacity: 0.92 !important;
    }

    /* Table styles */
    html.dark-mode table:not(.datepicker-table-condensed) {
        color: #e2e8f0 !important;
        background-color: transparent !important;
    }
    html.dark-mode table thead tr th {
        background-color: #202024 !important;
        color: #cbd5e1 !important;
        border-bottom: 1.5px solid #2e2e34 !important;
    }
    html.dark-mode table th,
    html.dark-mode table td {
        border-color: #27272a !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .table-responsive {
        border-color: #27272a !important;
    }
    html.dark-mode .table-hover tbody tr:hover,
    html.dark-mode .table-hover tbody tr:hover td,
    html.dark-mode .table-hover tbody tr:hover > * {
        background-color: rgba(255, 255, 255, 0.04) !important;
    }
    html.dark-mode .table-hover tbody tr:hover td,
    html.dark-mode .table-hover tbody tr:hover td *,
    html.dark-mode .table-hover tbody tr:hover td i {
        color: #ffffff !important;
    }

    /* Global Modern Table & Badges in Dark Mode */
    html.dark-mode .modern-table {
        background-color: transparent !important;
    }
    html.dark-mode .modern-table thead th {
        background: #202025 !important;
        color: #a1a1aa !important;
        border-bottom: 1.5px solid #2e2e34 !important;
    }
    html.dark-mode .modern-table tbody tr {
        background: transparent !important;
        border-bottom: 1px solid #27272a !important;
    }
    html.dark-mode .modern-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.035) !important;
    }
    html.dark-mode .modern-table tbody td {
        background: transparent !important;
        color: #f1f5f9 !important;
        border-color: #27272a !important;
    }
    html.dark-mode .modern-table tbody td .text-dark {
        color: #ffffff !important;
    }
    .code-badge {
        display: inline-flex;
        align-items: center;
        line-height: 1.2;
    }
    html.dark-mode .code-badge {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #f4f4f5 !important;
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2) !important;
    }
    html.dark-mode .btn-action-detail {
        background: rgba(56, 189, 248, 0.16) !important;
        color: #38bdf8 !important;
        border: 1px solid rgba(56, 189, 248, 0.35) !important;
    }
    html.dark-mode .btn-action-detail:hover {
        background: #0284c7 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4) !important;
    }
    html.dark-mode .btn-action-edit {
        background: rgba(245, 158, 11, 0.16) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(245, 158, 11, 0.35) !important;
    }
    html.dark-mode .btn-action-edit:hover {
        background: #d97706 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.4) !important;
    }
    html.dark-mode .btn-action-delete {
        background: rgba(244, 63, 94, 0.16) !important;
        color: #fb7185 !important;
        border: 1px solid rgba(244, 63, 94, 0.35) !important;
    }
    html.dark-mode .btn-action-delete:hover {
        background: #e11d48 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.4) !important;
    }
    html.dark-mode .bg-inverse-primary {
        background-color: rgba(59, 130, 246, 0.18) !important;
        color: #93c5fd !important;
        border: 1px solid rgba(59, 130, 246, 0.3) !important;
    }


    /* Input & form styles */
    html.dark-mode input.form-control:not(.navbar-date-picker input):not(#datepicker-popup input),
    html.dark-mode select.form-control,
    html.dark-mode textarea.form-control,
    html.dark-mode input:not(.navbar-date-picker input):not(#datepicker-popup input),
    html.dark-mode select,
    html.dark-mode textarea {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #334155 !important;
    }
    html.dark-mode input:not(.navbar-date-picker input):not(#datepicker-popup input):focus,
    html.dark-mode select:focus,
    html.dark-mode textarea:focus {
        border-color: #3b82f6 !important;
    }

    /* Native Date/Time/Week/Month picker indicators in Dark Mode (Pure White #ffffff) */
    html.dark-mode input[type="date"],
    html.dark-mode input[type="time"],
    html.dark-mode input[type="week"],
    html.dark-mode input[type="month"],
    html.dark-mode input[type="datetime-local"] {
        color-scheme: dark !important;
    }
    html.dark-mode input[type="date"]::-webkit-calendar-picker-indicator,
    html.dark-mode input[type="week"]::-webkit-calendar-picker-indicator,
    html.dark-mode input[type="month"]::-webkit-calendar-picker-indicator,
    html.dark-mode input[type="datetime-local"]::-webkit-calendar-picker-indicator,
    html.dark-mode .filter-input::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="%23ffffff"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2zm-8 4h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/></svg>') !important;
        background-size: 18px 18px !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        cursor: pointer !important;
        opacity: 1 !important;
        filter: none !important;
    }
    html.dark-mode input[type="time"]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="%23ffffff"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/></svg>') !important;
        background-size: 18px 18px !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        cursor: pointer !important;
        opacity: 1 !important;
        filter: none !important;
    }

    /* Navbar Date Picker in Dark Mode (keep seamless transparent glassmorphism, no black box) */
    html.dark-mode .navbar-date-picker,
    .dark-mode .navbar-date-picker {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
    html.dark-mode .navbar-date-picker input,
    html.dark-mode .navbar-date-picker .form-control,
    html.dark-mode #datepicker-popup input,
    .dark-mode .navbar-date-picker input,
    .dark-mode .navbar-date-picker .form-control,
    .dark-mode #datepicker-popup input {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        color: #ffffff !important;
    }
    html.dark-mode .navbar-date-picker input:focus,
    html.dark-mode .navbar-date-picker .form-control:focus,
    .dark-mode .navbar-date-picker input:focus,
    .dark-mode .navbar-date-picker .form-control:focus {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    html.dark-mode .form-label,
    html.dark-mode label {
        color: #cbd5e1 !important;
    }
    html.dark-mode .form-control::placeholder {
        color: #475569 !important;
    }

    /* Credential Box & Inline Light Containers in Dark Mode */
    html.dark-mode .credential-box,
    html.dark-mode .card-credential,
    html.dark-mode div[style*="background-color: #f8fafc"],
    html.dark-mode div[style*="background-color:#f8fafc"],
    html.dark-mode div[style*="background: #f8fafc"],
    html.dark-mode div[style*="background:#f8fafc"],
    html.dark-mode div[style*="background-color: #f1f5f9"],
    html.dark-mode div[style*="background-color:#f1f5f9"],
    html.dark-mode thead[style*="background-color: #f8fafc"],
    html.dark-mode thead[style*="background-color:#f8fafc"] {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    html.dark-mode .credential-box h6,
    html.dark-mode div[style*="background-color: #f8fafc"] h6,
    html.dark-mode div[style*="background-color:#f8fafc"] h6 {
        color: #60a5fa !important;
    }

    html.dark-mode input[readonly],
    html.dark-mode input:disabled,
    html.dark-mode input[style*="background-color: #f1f5f9"] {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }

    html.dark-mode hr,
    html.dark-mode hr[style*="border-top: 1px solid #e2e8f0"] {
        border-color: #334155 !important;
        opacity: 0.25 !important;
    }

    /* Badges & Pills */
    html.dark-mode .bg-light {
        background-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    html.dark-mode .bg-light-info {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .badge.bg-white {
        background-color: rgba(255, 255, 255, 0.12) !important;
    }
    html.dark-mode .badge.bg-white.text-success {
        color: #4ade80 !important;
    }
    html.dark-mode .badge.bg-white.text-primary {
        color: #60a5fa !important;
    }
    html.dark-mode .badge.bg-white.text-dark {
        color: #ffffff !important;
    }
    html.dark-mode .card-premium.text-white p {
        color: #e2e8f0 !important;
    }

    /* List Groups & Option Elements */
    html.dark-mode .list-group-item {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }
    html.dark-mode select option {
        background-color: #1e293b !important;
        color: #ffffff !important;
    }

    /* Premium Buttons in Dark Mode */
    html.dark-mode .btn-outline-primary {
        color: #60a5fa !important;
        border-color: #3b82f6 !important;
        background-color: rgba(59, 130, 246, 0.15) !important;
    }
    html.dark-mode .btn-outline-primary:hover {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        border-color: #3b82f6 !important;
    }
    html.dark-mode .btn-outline-success {
        color: #4ade80 !important;
        border-color: #22c55e !important;
        background-color: rgba(34, 197, 94, 0.15) !important;
    }
    html.dark-mode .btn-outline-success:hover {
        background-color: #22c55e !important;
        color: #ffffff !important;
        border-color: #22c55e !important;
    }

    /* Subtle Badge Overrides */
    html.dark-mode .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.2) !important;
        color: #a7f3d0 !important;
    }
    html.dark-mode .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.2) !important;
        color: #fca5a5 !important;
    }
    html.dark-mode .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.2) !important;
        color: #fde047 !important;
    }
    html.dark-mode .bg-info-subtle {
        background-color: rgba(6, 182, 212, 0.2) !important;
        color: #a5f3fc !important;
    }
    html.dark-mode .badge-belum-mulai {
        background-color: #ef4444 !important;
        color: #ffffff !important;
        border: 1px solid #ef4444 !important;
    }

    /* Riwayat Kehadiran (Student History) in Dark Mode */
    html.dark-mode .history-item-premium,
    html.dark-mode .empty-state-card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        color: #e2e8f0 !important;
    }

    @media (max-width: 767px) {
        .table-responsive-mobile td,
        .table-responsive-mobile th {
            font-size: 0.65rem !important;
            padding: 8px 4px !important;
        }
    }

    /* Ujian Online (Student Ujian) in Dark Mode */
    html.dark-mode .ujian-card,
    html.dark-mode .nilai-box {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .mapel-badge {
        background-color: rgba(96, 165, 250, 0.15) !important;
        color: #60a5fa !important;
    }

    /* Mobile Responsive Table Cards in Dark Mode */
    @media (max-width: 768px) {
        html.dark-mode .table-responsive-mobile tr {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
        }
        html.dark-mode .table-responsive-mobile td:nth-child(2) {
            color: #ffffff !important;
        }
        html.dark-mode .table-responsive-mobile td:nth-child(3) {
            color: #94a3b8 !important;
        }
        html.dark-mode .table-responsive-mobile td:nth-child(4) {
            border-top: 1px dashed #334155 !important;
        }
    }

    /* Modals */
    html.dark-mode .modal-content {
        background-color: #1e293b !important;
        color: #ffffff !important;
        border: 1px solid #334155 !important;
    }
    html.dark-mode .modal-header,
    html.dark-mode .modal-footer {
        border-color: #334155 !important;
    }
    html.dark-mode .btn-close {
        filter: invert(1) grayscale(1) brightness(2) !important;
    }

    /* Alerts */
    html.dark-mode .alert-success {
        background-color: #064e3b !important;
        border: 1px solid #047857 !important;
        color: #a7f3d0 !important;
    }
    html.dark-mode .alert-danger {
        background-color: #7f1d1d !important;
        border: 1px solid #b91c1c !important;
        color: #fca5a5 !important;
    }

    /* Footer styling */
    html.dark-mode .footer {
        background-color: #0f172a !important;
        color: #94a3b8 !important;
        border-top: 1px solid #1e293b !important;
    }

    /* Dropdowns */
    html.dark-mode .dropdown-menu {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
    }
    html.dark-mode .dropdown-item {
        color: #cbd5e1 !important;
    }
    html.dark-mode .dropdown-item:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    html.dark-mode .dropdown-header {
        border-bottom: 1px solid #334155 !important;
        color: #ffffff !important;
    }
    html.dark-mode .dropdown-divider {
        border-top: 1px solid #334155 !important;
    }

    /* Datepicker styling overrides */
    html.dark-mode .datepicker {
        background-color: #1e293b !important;
        color: #ffffff !important;
        border: 1px solid #334155 !important;
    }
    html.dark-mode .datepicker table tr td,
    html.dark-mode .datepicker table tr th {
        color: #ffffff !important;
    }
    html.dark-mode .datepicker table tr td.day:hover {
        background-color: #334155 !important;
    }
    html.dark-mode .datepicker table tr td.old,
    html.dark-mode .datepicker table tr td.new {
        color: #64748b !important;
    }
</style>
