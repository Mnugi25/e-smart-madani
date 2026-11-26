<!DOCTYPE html>
<html lang="en">
<head>
    @include('template.partials.head')
    @stack('styles')
    <style>
        /* Sidebar Hover & Toggle Logic for Large Screens */
        @media (min-width: 992px) {
            .navbar {
                z-index: 1030 !important;
                height: 75px !important;
            }
            .navbar .navbar-brand-wrapper {
                height: 75px !important;
            }
            .navbar .navbar-menu-wrapper {
                height: 75px !important;
            }
            .page-body-wrapper {
                padding-top: 75px !important;
            }

            /* Custom Scrollbar for Sidebar */
            .sidebar::-webkit-scrollbar {
                width: 5px;
            }
            .sidebar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 10px;
            }
            .sidebar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            /* Ensure Icon is always visible and colored */
            .sidebar .menu-icon {
                color: #ffffff !important;
                opacity: 1 !important;
                visibility: visible !important;
            }

            /* Move footer up a bit on desktop */
            .footer {
                margin-top: -30px !important;
            }

            /* =========================================================
               1. COLLAPSED / ICON-ONLY MODE (Hanya Buka/Tutup via Klik Tombol)
               ========================================================= */
            body.sidebar-icon-only .sidebar {
                width: 70px !important;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                position: fixed !important;
                top: 0;
                padding-top: 75px !important;
                z-index: 1020;
                height: 100vh !important;
                box-shadow: 5px 0 15px rgba(0,0,0,0.05);
            }

            /* Center icons when collapsed */
            body.sidebar-icon-only .sidebar .nav-item .nav-link {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.75rem 0 !important;
                width: 70px !important;
                transition: all 0.3s !important;
            }

            body.sidebar-icon-only .sidebar .nav-item .nav-link .menu-icon {
                margin-right: 0 !important;
                font-size: 1.25rem !important;
                line-height: 1 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 40px !important;
                height: 40px !important;
                transition: margin 0.3s !important;
            }

            /* In collapsed mode, hide titles, badges, arrows, and categories permanently (tidak buka saat di-hover) */
            body.sidebar-icon-only .sidebar .menu-title,
            body.sidebar-icon-only .sidebar .badge,
            body.sidebar-icon-only .sidebar .menu-arrow,
            body.sidebar-icon-only .sidebar .nav-category,
            body.sidebar-icon-only .sidebar .nav-item.hover-open .nav-link .menu-title,
            body.sidebar-icon-only .sidebar .nav-item.hover-open .collapse,
            body.sidebar-icon-only .sidebar .nav-item.hover-open .collapsing {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                white-space: nowrap !important;
                position: absolute !important;
                pointer-events: none !important;
            }
            
            /* Force hiding of nav-category when collapsed */
            body.sidebar-icon-only .sidebar .nav-item.nav-category {
                display: none !important;
            }

            /* Hide sub-menus when sidebar is collapsed */
            body.sidebar-icon-only .sidebar .nav .sub-menu {
                display: none !important;
            }

            /* Main Panel Fix (Static Margin) when collapsed */
            body.sidebar-icon-only .main-panel {
                margin-left: 70px !important;
                width: calc(100% - 70px) !important;
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important, width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }

            /* =========================================================
               2. EXPANDED MODE (Hanya ketika tombol hamburger diklik)
               ========================================================= */
            body:not(.sidebar-icon-only) .sidebar {
                width: 235px !important;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                position: fixed !important;
                top: 0;
                padding-top: 75px !important;
                z-index: 1020;
                height: 100vh !important;
                box-shadow: 5px 0 15px rgba(0,0,0,0.05);
            }

            body:not(.sidebar-icon-only) .main-panel {
                margin-left: 235px !important;
                width: calc(100% - 235px) !important;
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important, width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }

            body:not(.sidebar-icon-only) .sidebar .nav-item .nav-link {
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                padding: 0.75rem 1.5rem !important;
                width: 100% !important;
                transition: all 0.3s !important;
            }

            body:not(.sidebar-icon-only) .sidebar .nav-item .nav-link .menu-icon {
                margin-right: 1.25rem !important;
                font-size: 1.25rem !important;
                line-height: 1 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 40px !important;
                height: 40px !important;
            }

            body:not(.sidebar-icon-only) .sidebar .menu-title,
            body:not(.sidebar-icon-only) .sidebar .badge,
            body:not(.sidebar-icon-only) .sidebar .menu-arrow,
            body:not(.sidebar-icon-only) .sidebar .nav-category {
                opacity: 1 !important;
                visibility: visible !important;
                position: relative !important;
                pointer-events: auto !important;
                white-space: nowrap !important;
                display: inline-block !important;
            }

            body:not(.sidebar-icon-only) .sidebar .nav-item.nav-category {
                display: block !important;
            }
        }

        /* Keep footer at the bottom ONLY on mobile/tablet viewports */
        @media (max-width: 991px) {
            .main-panel {
                display: flex !important;
                flex-direction: column !important;
                min-height: calc(100vh - 55px) !important;
            }
            .content-wrapper {
                flex-grow: 1 !important;
            }
        }

        /* Mobile specific padding for clean modern UI */
        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.85rem 0.85rem 1.5rem 0.85rem !important;
            }
        }
    </style>
</head>
<body class="sidebar-icon-only">
    <script>
        // Synchronously restore sidebar preference before DOM render to prevent layout shift
        (function() {
            try {
                if (localStorage.getItem('sidebar-icon-only') === 'false') {
                    document.body.classList.remove('sidebar-icon-only');
                }
            } catch (e) {}
        })();
    </script>
    <div class="container-scroller">
        {{-- Navbar --}}
        @include('template.partials.navbar')

        <div class="container-fluid page-body-wrapper">
            {{-- Settings Panel --}}
            @include('template.partials.settings-panel')

            {{-- Sidebar --}}
            @include('template.partials.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>

                {{-- Footer --}}
                @include('template.partials.footer')
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    @include('template.partials.scripts')
    @stack('scripts')
</body>
</html><!-- trigger recompile for dark mode cards in reverted template -->
