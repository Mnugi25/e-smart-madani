<style>
    /* Prevent navbar from wrapping on all screen sizes & add polished depth */
    .navbar.default-layout {
        flex-wrap: nowrap !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.2) !important;
    }
    .navbar.default-layout .navbar-menu-wrapper {
        width: auto !important;
        flex-grow: 1 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
    }
    html.dark-mode .navbar.default-layout,
    html.dark-mode .navbar.default-layout .navbar-menu-wrapper {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
    }

    /* Desktop: Perfectly align navbar brand wrapper width (235px / 70px) with sidebar width */
    @media (min-width: 992px) {
        /* When expanded (matches sidebar 235px) */
        body:not(.sidebar-icon-only) .navbar.default-layout .navbar-brand-wrapper {
            width: 235px !important;
            min-width: 235px !important;
            max-width: 235px !important;
            height: 75px !important;
            padding-left: 18px !important;
            padding-right: 14px !important;
            border-right: 1px solid rgba(255, 255, 255, 0.15) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            box-sizing: border-box !important;
            flex-shrink: 0 !important;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        body:not(.sidebar-icon-only) .navbar.default-layout .navbar-brand-wrapper .brand-logo {
            display: flex !important;
        }
        body:not(.sidebar-icon-only) .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini {
            display: none !important;
        }

        /* When collapsed (matches sidebar 70px) */
        body.sidebar-icon-only .navbar.default-layout .navbar-brand-wrapper {
            width: 70px !important;
            min-width: 70px !important;
            max-width: 70px !important;
            height: 75px !important;
            padding: 0 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.15) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            flex-shrink: 0 !important;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        body.sidebar-icon-only .navbar.default-layout .navbar-brand-wrapper .brand-logo {
            display: none !important;
        }

        body.sidebar-icon-only .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        body.sidebar-icon-only .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini span {
            display: none !important;
        }

        .navbar.default-layout .navbar-menu-wrapper {
            height: 75px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-left: 22px !important;
            padding-right: 25px !important;
            display: flex !important;
            align-items: center !important;
        }
    }
    html.dark-mode .navbar.default-layout .navbar-brand-wrapper {
        border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    /* Mobile-specific navbar menu wrapper layout tweaks */
    @media (max-width: 991px) {
        .page-body-wrapper {
            padding-top: 55px !important;
        }
        .navbar.default-layout {
            height: 55px !important;
        }
        .navbar.default-layout .navbar-brand-wrapper {
            width: auto !important;
            flex-shrink: 0 !important;
            height: 55px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
            border-right: none !important;
        }
        .navbar.default-layout .navbar-brand-wrapper .brand-logo {
            display: none !important;
        }
        .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini {
            display: flex !important;
        }
        .navbar.default-layout .navbar-menu-wrapper {
            height: 55px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            justify-content: flex-end !important;
        }
        .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini img {
            width: 30px !important;
            height: 30px !important;
        }
        .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini span span:first-child {
            font-size: 9px !important;
        }
        .navbar.default-layout .navbar-brand-wrapper .brand-logo-mini span span:last-child {
            font-size: 7px !important;
        }
        .navbar.default-layout .navbar-menu-wrapper .navbar-toggler {
            height: 55px !important;
            line-height: 55px !important;
            padding: 0 10px !important;
        }
    }
    /* Fix datepicker in navbar styling */
    .navbar-date-picker {
        display: flex !important;
        align-items: center !important;
        background: rgba(255, 255, 255, 0.12) !important;
        border: 1px solid rgba(255, 255, 255, 0.22) !important;
        border-radius: 30px !important;
        padding: 0 14px !important;
        height: 38px !important;
        margin-bottom: 0 !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12) !important;
        backdrop-filter: blur(8px) !important;
    }
    .navbar-date-picker .input-group-prepend,
    .navbar-date-picker .input-group-addon {
        border: none !important;
        background: transparent !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 8px 0 0 !important;
        margin: 0 8px 0 0 !important;
        border-right: 1px solid rgba(255, 255, 255, 0.2) !important;
        height: 18px !important;
    }
    .navbar-date-picker .calendar-icon {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        color: #93c5fd !important;
        font-size: 15px !important;
        display: flex !important;
        align-items: center !important;
    }
    .navbar-date-picker .form-control {
        border: none !important;
        background: transparent !important;
        background-color: transparent !important;
        height: 36px !important;
        line-height: 36px !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        width: 85px !important;
        box-shadow: none !important;
        text-align: center !important;
        padding: 0 !important;
    }
    .navbar-date-picker .clock-separator {
        color: rgba(255, 255, 255, 0.35) !important;
        font-weight: 300 !important;
        display: flex !important;
        align-items: center !important;
        height: 18px !important;
    }
    .navbar-date-picker .clock-text {
        font-size: 0.825rem !important;
        font-weight: 700 !important;
        color: #facc15 !important;
        display: flex !important;
        align-items: center !important;
        height: 36px !important;
        line-height: 36px !important;
        width: 65px !important;
        justify-content: center !important;
        letter-spacing: 0.5px !important;
    }

    /* Dark Mode Overrides for Datepicker */
    .dark-mode .navbar-date-picker,
    html.dark-mode .navbar-date-picker {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
    .dark-mode .navbar-date-picker input,
    html.dark-mode .navbar-date-picker input,
    .dark-mode .navbar-date-picker .form-control,
    html.dark-mode .navbar-date-picker .form-control,
    .dark-mode #datepicker-popup input,
    html.dark-mode #datepicker-popup input {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        color: #ffffff !important;
    }
    .dark-mode .navbar-date-picker input:focus,
    html.dark-mode .navbar-date-picker input:focus,
    .dark-mode .navbar-date-picker .form-control:focus,
    html.dark-mode .navbar-date-picker .form-control:focus {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* ===================================================
       🍔 SQUIRCLE HAMBURGER TOGGLE BUTTON
       Matches media_1794208728484_d2eeec28: rounded squircle
       with 3 horizontal bars, clean borders & subtle shadow
       =================================================== */
    .sidebar-toggle-btn,
    .navbar.default-layout .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn,
    .navbar.default-layout .navbar-menu-wrapper .navbar-toggler.sidebar-toggle-btn {
        width: 33px !important;
        height: 33px !important;
        min-width: 33px !important;
        min-height: 33px !important;
        max-width: 33px !important;
        max-height: 33px !important;
        line-height: 1 !important;
        padding: 0 !important;
        margin: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: #ffffff !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 9px !important;
        color: #64748b !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04) !important;
        cursor: pointer !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-decoration: none !important;
        outline: none !important;
        flex-shrink: 0 !important;
        transform: none !important;
    }

    .sidebar-toggle-btn:hover,
    .navbar.default-layout .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn:hover,
    .navbar.default-layout .navbar-menu-wrapper .navbar-toggler.sidebar-toggle-btn:hover {
        background: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -1px rgba(0, 0, 0, 0.04) !important;
    }

    .sidebar-toggle-btn:active,
    .sidebar-toggle-btn:focus-visible {
        transform: scale(0.95) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
    }

    /* Dark Mode Theme for Toggle Button */
    html.dark-mode .sidebar-toggle-btn,
    .dark-mode .sidebar-toggle-btn,
    html.dark-mode .navbar.default-layout .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn,
    html.dark-mode .navbar.default-layout .navbar-menu-wrapper .navbar-toggler.sidebar-toggle-btn {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
    }

    html.dark-mode .sidebar-toggle-btn:hover,
    .dark-mode .sidebar-toggle-btn:hover,
    html.dark-mode .navbar.default-layout .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn:hover,
    html.dark-mode .navbar.default-layout .navbar-menu-wrapper .navbar-toggler.sidebar-toggle-btn:hover {
        background: #27354f !important;
        border-color: #475569 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4) !important;
    }

    /* Prevent template.js 180deg rotate from breaking alignment */
    .sidebar-icon-only .navbar .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn {
        transform: none !important;
    }
    .sidebar-icon-only .navbar .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn:hover {
        transform: translateY(-1px) !important;
    }
    .sidebar-icon-only .navbar .navbar-brand-wrapper .navbar-toggler.sidebar-toggle-btn:active {
        transform: scale(0.95) !important;
    }

    /* Mobile Backdrop Overlay */
    .sidebar-mobile-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        z-index: 1024;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .sidebar-mobile-backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }
</style>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="navbar-brand brand-logo"
       style="align-items: center !important; justify-content: flex-start !important; max-width: none !important; margin: 0 !important; padding: 0 !important; text-decoration: none !important; overflow: visible !important;">
            <img src="{{ asset('template/images/smk madani.jpg') }}" alt="logo" style="width: 44px; height: 44px; margin-right: 10px; object-fit: cover; border-radius: 10px; border: 1.5px solid rgba(255,255,255,0.25); box-shadow: 0 4px 10px rgba(0,0,0,0.18); flex-shrink: 0;" />
            <span style="display: inline-flex; flex-direction: column; line-height: 1.15; text-align: left; flex-shrink: 0; overflow: visible !important;">
                <span style="font-size: 15px !important; font-weight: 800 !important; font-family: var(--font-heading), 'Outfit', sans-serif; color: #ffffff !important; letter-spacing: 0.5px; white-space: nowrap !important; text-transform: uppercase;">
                    E-Learning
                </span>
                <span style="font-size: 13px !important; font-weight: 800 !important; font-family: var(--font-heading), 'Outfit', sans-serif; color: #4ade80 !important; letter-spacing: -0.3px; white-space: nowrap !important;">
                    SMK Al-Madani
                </span>
            </span>
        </div>
     
        <div class="navbar-brand brand-logo-mini"
         style="align-items: center !important; justify-content: flex-start !important; margin: 0 !important; padding: 0 !important; text-decoration: none !important; overflow: visible !important;">
            <img src="{{ asset('template/images/smk madani.jpg') }}" alt="logo" style="width: 36px; height: 36px; margin-right: 8px; object-fit: cover; border-radius: 9px; border: 1.5px solid rgba(255,255,255,0.25);" />
            <span style="display: inline-flex; flex-direction: column; line-height: 1.1; text-align: left;">
                <span style="font-size: 11px !important; font-weight: 800 !important; font-family: var(--font-heading), 'Outfit', sans-serif; color: #ffffff !important; letter-spacing: 0.5px; white-space: nowrap !important; text-transform: uppercase;">
                    E-Learning
                </span>
                <span style="font-size: 9px !important; font-weight: 800 !important; font-family: var(--font-heading), 'Outfit', sans-serif; color: #4ade80 !important; white-space: nowrap !important;">
                    Al-Madani
                </span>
            </span>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        {{-- 🍔 Squircle Toggle Button & Portal Header (Desktop) - Matches user reference --}}
        @php
            $currentUser = auth()->user();
            $userRole = $currentUser->role ?? 'guest';
            $isGuru = $userRole === 'guru';
            $guruModel = $isGuru ? $currentUser->guru : null;
            $kelasWali = $guruModel?->kelasWali;
            $isWaliKelas = $isGuru && ($kelasWali || str_contains(strtoupper($guruModel?->jabatan ?? ''), 'WALI'));
            $namaKelasWali = $kelasWali?->nama_kelas;
            $siswaModel = ($userRole === 'siswa') ? $currentUser->siswa : null;
            $namaKelasSiswa = $siswaModel?->kelas?->nama_kelas;
        @endphp
        <div class="d-none d-lg-flex align-items-center me-auto" style="gap: 16px;">
            <button class="navbar-toggler navbar-toggler align-self-center sidebar-toggle-btn" type="button" data-bs-toggle="minimize" id="desktopSidebarToggle" title="Buka/Tutup Sidebar" aria-label="Toggle Sidebar">
                <svg width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.2 1.5H13.8M1.2 5.5H13.8M1.2 9.5H13.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px 10px;">
                    <h1 class="welcome-text mb-0" style="color: #ffffff !important; font-size: 1.15rem; font-weight: 700; line-height: 1.25;">
                        Selamat Datang, <span class="fw-bold" style="color: #facc15 !important;">{{ $currentUser->nama ?? 'Pengguna' }}</span>
                    </h1>
                    @if($isGuru)
                        @if($isWaliKelas)
                            <span class="badge rounded-pill d-inline-flex align-items-center shadow-xs" 
                                  style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.28) 0%, rgba(5, 150, 105, 0.42) 100%); border: 1.2px solid #34d399; color: #a7f3d0; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; letter-spacing: 0.3px; line-height: 1.2;"
                                  title="Penugasan: Wali Kelas {{ $namaKelasWali ?? '' }}">
                                <i class="mdi mdi-shield-account me-1" style="font-size: 0.92rem; color: #34d399;"></i>
                                Wali Kelas{{ $namaKelasWali ? ' • ' . $namaKelasWali : '' }}
                            </span>
                        @else
                            <span class="badge rounded-pill d-inline-flex align-items-center shadow-xs" 
                                  style="background: linear-gradient(135deg, rgba(56, 189, 248, 0.22) 0%, rgba(14, 165, 233, 0.35) 100%); border: 1.2px solid #38bdf8; color: #bae6fd; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; letter-spacing: 0.3px; line-height: 1.2;"
                                  title="Guru Mata Pelajaran (Bukan Wali Kelas)">
                                <i class="mdi mdi-book-open-page-variant me-1" style="font-size: 0.92rem; color: #38bdf8;"></i>
                                Guru Mapel
                            </span>
                        @endif
                    @elseif($userRole === 'admin')
                        <span class="badge rounded-pill d-inline-flex align-items-center shadow-xs" 
                              style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.25) 0%, rgba(79, 70, 229, 0.35) 100%); border: 1.2px solid #818cf8; color: #c7d2fe; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; letter-spacing: 0.3px; line-height: 1.2;">
                            <i class="mdi mdi-shield-crown me-1" style="font-size: 0.92rem; color: #a5b4fc;"></i>
                            Administrator
                        </span>
                    @elseif($userRole === 'siswa')
                        <span class="badge rounded-pill d-inline-flex align-items-center shadow-xs" 
                              style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.25) 0%, rgba(147, 51, 234, 0.35) 100%); border: 1.2px solid #c084fc; color: #e9d5ff; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; letter-spacing: 0.3px; line-height: 1.2;">
                            <i class="mdi mdi-school me-1" style="font-size: 0.92rem; color: #c084fc;"></i>
                            Siswa{{ $namaKelasSiswa ? ' • ' . $namaKelasSiswa : '' }}
                        </span>
                    @endif
                </div>
                <h3 class="welcome-sub-text mb-0" style="color: rgba(255, 255, 255, 0.75) !important; font-size: 0.8rem; font-weight: 400; margin-top: 2px;">
                    Portal Pembelajaran & Presensi
                    @if($isGuru)
                        @if($isWaliKelas)
                            <span style="opacity: 0.5; margin: 0 4px;">•</span>
                            <span style="color: #6ee7b7 !important; font-weight: 600;"><i class="mdi mdi-shield-check me-0.5"></i>Wali Kelas{{ $namaKelasWali ? ' ' . $namaKelasWali : '' }}</span>
                        @else
                            <span style="opacity: 0.5; margin: 0 4px;">•</span>
                            <span style="color: #7dd3fc !important; font-weight: 600;"><i class="mdi mdi-book-education me-0.5"></i>Guru Mapel (Guru Biasa)</span>
                        @endif
                    @endif
                </h3>
            </div>
        </div>
        <ul class="navbar-nav ms-auto align-items-center">
            {{-- 📅 Datepicker & Realtime Clock (Desktop Only) --}}
            <li class="nav-item d-none d-lg-flex align-items-center me-3">
                <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                    <span class="input-group-addon input-group-prepend border-right">
                        <span class="icon-calendar input-group-text calendar-icon"></span>
                    </span>
                    <input type="text" class="form-control">
                    <span class="clock-separator mx-2">|</span>
                    <span id="realtime-clock" class="clock-text">00:00:00</span>
                </div>
            </li>

            {{-- 🌓 Dark Mode Toggle Switch --}}
            <li class="nav-item me-2 me-lg-3 d-flex align-items-center">
                <button type="button" id="dark-mode-toggle" class="btn btn-link nav-link p-0 text-white border-0 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; border-radius: 50%; font-size: 1.35rem; transition: background-color 0.2s;" title="Ubah Tema">
                    <i class="mdi mdi-weather-night"></i>
                </button>
            </li>

            {{-- 🍔 Mobile Squircle Offcanvas Hamburger Toggle --}}
            <li class="nav-item d-lg-none d-flex align-items-center">
                <button class="navbar-toggler navbar-toggler-right sidebar-toggle-btn d-flex align-items-center justify-content-center" type="button" id="mobileSidebarToggle" title="Buka Menu Navigasi" aria-label="Toggle Navigation">
                    <svg width="15" height="11" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.2 1.5H13.8M1.2 5.5H13.8M1.2 9.5H13.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </li>

            {{-- 👤 User Profile Dropdown (Desktop Only) --}}
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link p-0" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle border border-2 border-white-50 shadow-xs" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? 'User') }}&background=2563eb&color=ffffff&bold=true&size=80" alt="Profile image" style="width: 38px; height: 38px; object-fit: cover;">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown shadow-lg border-0" aria-labelledby="UserDropdown" style="border-radius: 16px;">
                    <div class="dropdown-header text-center p-4">
                        <img class="img-md rounded-circle border border-2 border-primary mb-2 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode($currentUser->nama ?? 'User') }}&background=2563eb&color=ffffff&bold=true&size=120" alt="Profile image" style="width: 72px; height: 72px; object-fit: cover;">
                        <p class="mb-1 font-weight-bold text-dark fs-6">{{ $currentUser->nama ?? 'Belum Login' }}</p>
                        @if($isGuru)
                            @if($isWaliKelas)
                                <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-3 py-1.5" style="font-size: 11px;">
                                    <i class="mdi mdi-shield-account me-1"></i> Wali Kelas{{ $namaKelasWali ? ' ' . $namaKelasWali : '' }}
                                </span>
                            @else
                                <span class="badge bg-info-subtle text-info fw-bold rounded-pill px-3 py-1.5" style="font-size: 11px;">
                                    <i class="mdi mdi-book-open-page-variant me-1"></i> Guru Mapel (Guru Biasa)
                                </span>
                            @endif
                        @elseif($userRole === 'admin')
                            <span class="badge bg-primary-subtle text-primary fw-bold text-uppercase rounded-pill px-3 py-1" style="font-size: 11px;">
                                <i class="mdi mdi-shield-crown me-1"></i> Administrator
                            </span>
                        @elseif($userRole === 'siswa')
                            <span class="badge bg-purple-subtle text-purple fw-bold rounded-pill px-3 py-1" style="font-size: 11px; background-color: rgba(168, 85, 247, 0.15); color: #9333ea;">
                                <i class="mdi mdi-school me-1"></i> Siswa{{ $namaKelasSiswa ? ' (' . $namaKelasSiswa . ')' : '' }}
                            </span>
                        @else
                            <span class="badge bg-primary-subtle text-primary fw-bold text-uppercase rounded-pill px-3 py-1" style="font-size: 11px;">{{ $userRole }}</span>
                        @endif
                    </div>
                    <a class="dropdown-item" href="{{ auth()->user()->role == 'siswa' ? route('siswa.profil') : route('admin.profil') }}">
                        <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>
                        Profil Saya
                    </a>

                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out
                    </a>
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="sidebar-mobile-backdrop d-lg-none" id="sidebarMobileBackdrop"></div>

{{-- 🌓 Dark Mode & Sidebar Persistence Script --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Mobile Sidebar Toggle and Backdrop
    const mobileToggler = document.getElementById('mobileSidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarMobileBackdrop');

    function toggleMobileSidebar(force) {
        if (!sidebar) return;
        const willBeActive = (typeof force === 'boolean') ? force : !sidebar.classList.contains('active');
        if (willBeActive) {
            sidebar.classList.add('active');
            if (backdrop) backdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.remove('active');
            if (backdrop) backdrop.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    if (mobileToggler) {
        mobileToggler.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileSidebar();
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileSidebar(false);
        });
    }

    // Auto-close mobile sidebar when clicking a navigation link
    document.querySelectorAll('#sidebar .nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992 && !this.getAttribute('data-bs-toggle')) {
                toggleMobileSidebar(false);
            }
        });
    });

    // Close on click outside sidebar
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('active')) {
            if (!sidebar.contains(e.target) && mobileToggler && !mobileToggler.contains(e.target)) {
                toggleMobileSidebar(false);
            }
        }
    });

    // Close button inside mobile sidebar
    document.querySelectorAll('.btn-close-sidebar-mobile').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileSidebar(false);
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) {
            toggleMobileSidebar(false);
        }
    });
    // Sidebar Minimize State Persistence across page reloads
    try {
        const savedSidebar = localStorage.getItem('sidebar-icon-only');
        if (savedSidebar === 'false') {
            document.body.classList.remove('sidebar-icon-only');
        } else if (savedSidebar === 'true') {
            document.body.classList.add('sidebar-icon-only');
        }
    } catch(e) {}

    const desktopToggler = document.getElementById('desktopSidebarToggle');
    if (desktopToggler) {
        desktopToggler.addEventListener('click', function () {
            setTimeout(function () {
                const isIconOnly = document.body.classList.contains('sidebar-icon-only');
                localStorage.setItem('sidebar-icon-only', isIconOnly ? 'true' : 'false');
            }, 60);
        });
    }

    // Real-time Clock initialization
    function updateClock() {
        const clockElement = document.getElementById('realtime-clock');
        if (!clockElement) return;
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock(); // call immediately

    const toggleBtn = document.getElementById('dark-mode-toggle');
    if (!toggleBtn) return;

    const icon = toggleBtn.querySelector('i');

    function updateIcon() {
        if (document.documentElement.classList.contains('dark-mode')) {
            icon.classList.remove('mdi-weather-night');
            icon.classList.add('mdi-weather-sunny');
            toggleBtn.title = "Mode Terang";
        } else {
            icon.classList.remove('mdi-weather-sunny');
            icon.classList.add('mdi-weather-night');
            toggleBtn.title = "Mode Gelap";
        }
    }

    // Set initial state
    updateIcon();

    toggleBtn.addEventListener('click', function () {
        if (document.documentElement.classList.contains('dark-mode')) {
            document.documentElement.classList.remove('dark-mode');
            localStorage.setItem('dark-mode', 'disabled');
        } else {
            document.documentElement.classList.add('dark-mode');
            localStorage.setItem('dark-mode', 'enabled');
        }
        updateIcon();
    });
});
</script>
