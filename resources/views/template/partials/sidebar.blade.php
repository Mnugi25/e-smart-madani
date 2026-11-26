<style>
    /*
    ==================================================================
    🎨 MODERN SIDEBAR LAYOUT (Colors Preserved)
    ==================================================================
    */

    #sidebar {
        overflow-y: auto !important;
        max-height: 100vh;
        transition: all 0.3s ease;
    }

    @media (max-width: 991px) {
        #sidebar,
        .sidebar.sidebar-offcanvas,
        .sidebar-offcanvas {
            position: fixed !important;
            top: 55px !important;
            bottom: 0 !important;
            right: 0 !important;
            height: calc(100vh - 55px) !important;
            max-height: calc(100vh - 55px) !important;
            width: 275px !important;
            max-width: 85vw !important;
            z-index: 1050 !important;
            transform: translateX(100%) !important;
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s ease !important;
            box-shadow: none !important;
            visibility: hidden !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            background: #0f1b54 !important;
            display: block !important;
        }
        #sidebar.active,
        .sidebar.sidebar-offcanvas.active,
        .sidebar-offcanvas.active {
            transform: translateX(0) !important;
            visibility: visible !important;
            box-shadow: -10px 0 35px rgba(0, 0, 0, 0.45) !important;
        }

        /* Dark mode mobile sidebar */
        html.dark-mode #sidebar,
        html.dark-mode .sidebar.sidebar-offcanvas {
            background: #0f172a !important;
            border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        /* Ensure all text and icons inside sidebar are fully visible and readable on mobile */
        #sidebar .menu-title,
        #sidebar .nav-category,
        #sidebar .badge,
        #sidebar .menu-arrow {
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
            position: static !important;
            pointer-events: auto !important;
            white-space: normal !important;
        }
        #sidebar .nav-item.nav-category {
            display: block !important;
        }
        #sidebar .nav-link {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            width: 100% !important;
            padding: 12px 18px !important;
        }
        #sidebar .nav-link .menu-icon {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 14px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Close Button inside Mobile Sidebar */
        .btn-close-sidebar-mobile {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            line-height: 1;
            padding: 0;
            transition: all 0.2s ease;
            z-index: 10;
        }
        .btn-close-sidebar-mobile:hover,
        .btn-close-sidebar-mobile:active {
            background: rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.5);
        }
    }

    #sidebar .nav {
        padding-top: 1.5rem !important;
        padding-bottom: 5rem !important;
    }

    /* TYPOGRAPHY & BASE STYLE */
    body #sidebar .nav-link,
    body #sidebar .menu-title {
        font-family: var(--font-body), 'Plus Jakarta Sans', sans-serif !important;
        font-weight: 500 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease-in-out;
    }

    /* NAV ITEM SPACING */
    #sidebar .nav-item {
        margin: 0 12px 4px 12px !important;
    }

    #sidebar .nav-link {
        padding: 12px 18px !important;
        border-radius: 12px !important;
        display: flex !important;
        align-items: center !important;
        color: rgba(255, 255, 255, 0.85) !important;
        pointer-events: auto !important;
        background: transparent !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* ICON ALIGNMENT */
    #sidebar .nav-link .menu-icon {
        margin-right: 1rem !important;
        font-size: 1.15rem !important;
        line-height: 1 !important;
        width: 20px !important;
        text-align: center !important;
        color: inherit !important;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), color 0.25s ease !important;
    }

    /* HOVER EFFECT (Subtle & Fluid Micro-interaction) */
    #sidebar .nav-item:not(.active):not(.active-menu-induk) .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    #sidebar .nav-item:not(.active):not(.active-menu-induk) .nav-link:hover .menu-icon {
        color: #60a5fa !important;
        transform: scale(1.12);
    }

    /* In compact/icon-only mode, keep icon centered on hover without shifting */
    body.sidebar-icon-only #sidebar .nav-item:not(.active):not(.active-menu-induk) .nav-link:hover {
        transform: none !important;
    }

    /* ACTIVE STATE (Modern Vibrant Glow) */
    #sidebar .nav-item.active-menu-induk>.nav-link,
    #sidebar .nav-item.active>.nav-link,
    #sidebar .nav-link.active-sub {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.35) 0%, rgba(37, 99, 235, 0.45) 100%) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
        border: 1px solid rgba(147, 197, 253, 0.3) !important;
    }

    /* REMOVE LEGACY STARADMIN FLAT WHITE BORDER ON ACTIVE / HOVER NAV-LINK */
    #sidebar .nav-item > .nav-link:before,
    #sidebar .nav-item > .nav-link:after,
    #sidebar .nav-item.active > .nav-link:before,
    #sidebar .nav-item.active-menu-induk > .nav-link:before,
    #sidebar .nav-item:hover > .nav-link:before,
    .sidebar-dark #sidebar .nav .nav-item.active > .nav-link:before,
    .sidebar-dark #sidebar .nav:not(.sub-menu) > .nav-item:hover > .nav-link:before,
    .sidebar-icon-only #sidebar .nav .nav-item.active .nav-link:before {
        display: none !important;
        content: none !important;
        width: 0 !important;
        height: 0 !important;
        background: transparent !important;
        border: none !important;
    }

    /* SUB-MENU REFINEMENT */
    #sidebar .sub-menu {
        background: rgba(0, 0, 0, 0.1) !important;
        margin: 4px 8px 12px 32px !important;
        padding: 6px 0 !important;
        border-radius: 8px !important;
        border-left: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    #sidebar .sub-menu .nav-item {
        margin: 0 !important;
    }

    #sidebar .sub-menu .nav-item .nav-link {
        padding: 8px 16px !important;
        font-size: 0.8rem !important;
        border-radius: 0 !important;
        transition: all 0.2s ease !important;
    }

    #sidebar .sub-menu .nav-item .nav-link:hover {
        background: transparent !important;
        padding-left: 20px !important;
        color: #60a5fa !important;
    }

    /* CATEGORY HEADERS (Polished & Highly Legible) */
    #sidebar .nav-category {
        font-family: 'Inter', sans-serif !important;
        color: #94a3b8 !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.68rem !important;
        letter-spacing: 1.25px !important;
        margin: 22px 0 8px 24px !important;
        padding: 0 !important;
        opacity: 0.95 !important;
    }

    /* LOGOUT BUTTON (Keeping it Red) */
    #sidebar .btn-logout-sidebar .nav-link {
        color: #ff6b6b !important;
    }

    #sidebar .btn-logout-sidebar .nav-link:hover {
        background: rgba(255, 107, 107, 0.15) !important;
        color: #ff4d4d !important;
    }

    /* SCROLLBAR REFINEMENT */
    #sidebar::-webkit-scrollbar {
        width: 4px;
    }

    #sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }

    #sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebarLinks = document.querySelectorAll('#sidebar .nav-link');
        sidebarLinks.forEach(function(link) {
            link.style.pointerEvents = 'auto';
        });
    });
</script>

<nav class="sidebar sidebar-offcanvas {{ Auth::user()?->role == 'guru' ? 'role-guru' : '' }}" id="sidebar">
    <ul class="nav">

        {{-- ==================================================================
           🟨 MENU KHUSUS UNTUK ADMIN
           ================================================================== --}}
        @if (Auth::user()?->role == 'admin')
            {{-- 👤 PROFILE WIDGET CARD UNTUK MOBILE --}}
            <li class="nav-item d-lg-none mb-3">
                <div class="d-flex align-items-center p-3 rounded-3 position-relative" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <button type="button" class="btn-close-sidebar-mobile" title="Tutup Menu" aria-label="Tutup Menu">
                        <i class="mdi mdi-close"></i>
                    </button>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=0f1b54&color=ffffff&bold=true&size=80" 
                         class="rounded-circle me-3 border border-2 border-white-50" 
                         style="width: 48px; height: 48px; object-fit: cover;" 
                         alt="Avatar">
                    <div class="overflow-hidden pe-3">
                        <h6 class="text-white fw-bold mb-0 text-truncate" style="font-size: 0.9rem;">{{ Auth::user()->nama }}</h6>
                        <small class="text-white-50 d-block text-truncate mb-2" style="font-size: 0.75rem;">Username: {{ Auth::user()->username }}</small>
                        <a href="{{ route('admin.profil') }}" class="btn text-white py-1 px-2.5 fw-semibold rounded-pill d-inline-flex align-items-center" style="font-size: 0.7rem; background: #0f1b54; border: none; line-height: 1;">
                            <i class="mdi mdi-account-circle-outline me-1" style="font-size: 0.85rem;"></i> Lihat Profil
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->is('admin/dashboard', 'dashboard') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="mdi mdi-grid-large menu-icon"></i>
                    <span class="menu-title">Dashboard Utama</span>
                </a>
            </li>

            <li class="nav-category">Data Master & Akun</li>
            <li class="nav-item {{ request()->is('admin/master/*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#master-sekolah"
                    aria-expanded="{{ request()->is('admin/master/*') ? 'true' : 'false' }}"
                    aria-controls="master-sekolah">
                    <i class="menu-icon mdi mdi-archive"></i>
                    <span class="menu-title">Master Sekolah</span>
                    <i class="mdi mdi-chevron-down ms-auto" style="font-size: 1rem; opacity: 0.5;"></i>
                </a>
                <div class="collapse {{ request()->is('admin/master/*') ? 'show' : '' }}" id="master-sekolah">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/master/jurusan') ? 'active-sub' : '' }}"
                                href="/admin/master/jurusan">Data Jurusan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/master/kelas') ? 'active-sub' : '' }}"
                                href="/admin/master/kelas">Data Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/master/mapel') ? 'active-sub' : '' }}"
                                href="/admin/master/mapel">Data Mata Pelajaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/master/guru') ? 'active-sub' : '' }}"
                                href="/admin/master/guru">Data Guru</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/master/siswa') ? 'active-sub' : '' }}"
                                href="/admin/master/siswa">Data Siswa</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ request()->is('admin/pengguna/*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#manajemen-user"
                    aria-expanded="{{ request()->is('admin/pengguna/*') ? 'true' : 'false' }}"
                    aria-controls="manajemen-user">
                    <i class="menu-icon mdi mdi-account-box-multiple"></i>
                    <span class="menu-title">Manajemen Akun</span>
                    <i class="mdi mdi-chevron-down ms-auto" style="font-size: 1rem; opacity: 0.5;"></i>
                </a>
                <div class="collapse {{ request()->is('admin/pengguna/*') ? 'show' : '' }}" id="manajemen-user">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/pengguna/guru') ? 'active-sub' : '' }}"
                                href="/admin/pengguna/guru">Akun Guru</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/pengguna/siswa') ? 'active-sub' : '' }}"
                                href="/admin/pengguna/siswa">Akun Siswa</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-category">Akademik & KBM</li>
            <li class="nav-item {{ request()->is('admin/akademik/jadwal*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="/admin/akademik/jadwal">
                    <i class="menu-icon mdi mdi-calendar-clock"></i>
                    <span class="menu-title">Jadwal Pelajaran</span>
                </a>
            </li>

            <li class="nav-category">Laporan</li>
            <li class="nav-item {{ request()->is('admin/laporan/absensi*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('admin.laporan.absensi') }}">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Laporan Absensi</span>
                </a>
            </li>

            <li class="nav-category">Pengaturan</li>
            <li class="nav-item {{ request()->is('admin/settings/lokasi*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('admin.settings.lokasi') }}">
                    <i class="menu-icon mdi mdi-map-marker-radius"></i>
                    <span class="menu-title">Lokasi Ujian</span>
                </a>
            </li>

          <!-- <li class="nav-category">Pengaturan SAW</li>
            <li class="nav-item {{ request()->is('admin/saw/*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu-saw"
                    aria-expanded="{{ request()->is('admin/saw/*') ? 'true' : 'false' }}"
                    aria-controls="menu-saw">
                    <i class="menu-icon mdi mdi-calculator-variant"></i>
                    <span class="menu-title">Bobot SAW</span>
                    <i class="mdi mdi-chevron-down ms-auto" style="font-size: 1rem; opacity: 0.5;"></i>
                </a>
                <div class="collapse {{ request()->is('admin/saw/*') ? 'show' : '' }}" id="menu-saw">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/saw/kriteria') ? 'active-sub' : '' }}"
                                href="{{ route('admin.saw') }}">Kriteria Penilaian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/saw/sub_kriteria') ? 'active-sub' : '' }}"
                                href="{{ route('admin.subkriteria') }}">Sub-Kriteria</a>
                        </li>
                    </ul>
                </div>
            </li>-->
            

        @endif


        {{-- ==================================================================
           🟩 MENU KHUSUS UNTUK GURU
           ================================================================== --}}
        @if (Auth::user()?->role == 'guru')
            {{-- 👤 PROFILE WIDGET CARD UNTUK MOBILE --}}
            <li class="nav-item d-lg-none mb-3">
                <div class="d-flex align-items-center p-3 rounded-3 position-relative" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <button type="button" class="btn-close-sidebar-mobile" title="Tutup Menu" aria-label="Tutup Menu">
                        <i class="mdi mdi-close"></i>
                    </button>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=0f1b54&color=ffffff&bold=true&size=80" 
                         class="rounded-circle me-3 border border-2 border-white-50" 
                         style="width: 48px; height: 48px; object-fit: cover;" 
                         alt="Avatar">
                    <div class="overflow-hidden pe-3">
                        <h6 class="text-white fw-bold mb-0 text-truncate" style="font-size: 0.9rem;">{{ Auth::user()->nama }}</h6>
                        <small class="text-white-50 d-block text-truncate mb-1" style="font-size: 0.75rem;">{{ Auth::user()->email }}</small>
                        @php
                            $sidebarGuru = Auth::user()->guru;
                            $sidebarKelasWali = $sidebarGuru?->kelasWali;
                            $sidebarIsWali = $sidebarKelasWali || str_contains(strtoupper($sidebarGuru?->jabatan ?? ''), 'WALI');
                        @endphp
                        <div class="mb-2">
                            @if($sidebarIsWali)
                                <span class="badge rounded-pill fw-bold" style="font-size: 10px; background: rgba(16, 185, 129, 0.25); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.4);">
                                    <i class="mdi mdi-shield-account me-0.5"></i> Wali Kelas{{ $sidebarKelasWali ? ' ' . $sidebarKelasWali->nama_kelas : '' }}
                                </span>
                            @else
                                <span class="badge rounded-pill fw-bold" style="font-size: 10px; background: rgba(56, 189, 248, 0.2); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.4);">
                                    <i class="mdi mdi-book-open-page-variant me-0.5"></i> Guru Mapel (Guru Biasa)
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('admin.profil') }}" class="btn text-white py-1 px-2.5 fw-semibold rounded-pill d-inline-flex align-items-center" style="font-size: 0.7rem; background: #0f1b54; border: none; line-height: 1;">
                            <i class="mdi mdi-account-circle-outline me-1" style="font-size: 0.85rem;"></i> Lihat Profil
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}" title="Dashboard Guru">
                    <i class="menu-icon mdi mdi-view-dashboard"></i>
                    <span class="menu-title">Dashboard Guru</span>
                </a>
            </li>

            <li class="nav-category"> Pembelajaran</li>

            <li class="nav-item {{ request()->is('guru/modul*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('guru.modul.index') }}" title="Modul Pembelajaran">
                    <i class="menu-icon mdi mdi-book-multiple"></i>
                    <span class="menu-title">Modul</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('guru/rpp*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('guru.rpp.index') }}" title="Data RPP">
                    <i class="menu-icon mdi mdi-file-document-box"></i>
                    <span class="menu-title">Data RPP</span>
                </a>
            </li>

            <li class="nav-category">Aktivitas & Evaluasi</li>

            <li class="nav-item {{ request()->is('guru/input-absen*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('guru.jadwal') }}" title="Jadwal & Presensi Mengajar">
                    <i class="menu-icon mdi mdi-border-color"></i>
                    <span class="menu-title"> Mengajar</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('guru/rekap-kehadiran*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('guru.rekap') }}" title="Rekap Presensi Kehadiran">
                    <i class="menu-icon mdi mdi-chart-bar"></i>
                    <span class="menu-title">Rekap Absen</span>
                </a>
            </li>

            <?php /* <li class="nav-item {{ request()->is('guru/penilaian*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu-penilaian"
                    aria-expanded="{{ request()->is('guru/penilaian*') ? 'true' : 'false' }}"
                    aria-controls="menu-penilaian">
                    <i class="menu-icon mdi mdi-format-list-checks"></i>
                    <span class="menu-title">Rekap Penilaian</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ request()->is('guru/penilaian*') ? 'show' : '' }}" id="menu-penilaian">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.penilaian.tugas') ? 'active' : '' }}"
                                href="#">Tugas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.penilaian.uh') ? 'active' : '' }}"
                                href="#">Ulangan
                                Harian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.penilaian.uts') ? 'active' : '' }}"
                                href="#">UTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guru.penilaian.uas') ? 'active' : '' }}"
                                href="#">UAS</a>
                        </li>
                    </ul>
                </div>
            </li> */ ?>

            <li class="nav-category">Administrasi</li>

            <li class="nav-item {{ request()->routeIs('guru.izin.index') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('guru.izin.index') }}" title="Pengajuan Izin Masuk">
                    <i class="menu-icon mdi mdi-email-open"></i>
                    <span class="menu-title">Pengajuan Masuk</span>
                </a>
            </li>

            <li class="nav-category">Ujian</li>

            <li class="nav-item {{ request()->is('guru/ujian*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('guru.ujian.index') }}" title="Manajemen Ujian Online">
                    <i class="menu-icon mdi mdi-book-open-variant"></i>
                    <span class="menu-title">Manajemen Ujian</span>
                </a>
            </li>

            @if (Auth::user()?->guru && Auth::user()->guru->kelasWali)
                <li class="nav-category">Khusus Wali Kelas</li>
                <li class="nav-item {{ request()->routeIs('guru.saw.*') ? 'active-menu-induk' : '' }}">
                    <a class="nav-link" href="{{ route('guru.saw.index') }}" title="Sistem Pendukung Keputusan (SAW)">
                        <i class="menu-icon mdi mdi-calculator"></i>
                        <span class="menu-title">SAW</span>
                    </a>
                </li>
            @endif
        @endif

        {{-- ==================================================================
            🟦 MENU KHUSUS UNTUK SISWA
            ================================================================== --}}
        @if (Auth::user()?->role == 'siswa')

            {{-- 👤 PROFILE WIDGET CARD UNTUK MOBILE --}}
            <li class="nav-item d-lg-none mb-3">
                <div class="d-flex align-items-center p-3 rounded-3 position-relative" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <button type="button" class="btn-close-sidebar-mobile" title="Tutup Menu" aria-label="Tutup Menu">
                        <i class="mdi mdi-close"></i>
                    </button>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=0f1b54&color=ffffff&bold=true&size=80" 
                         class="rounded-circle me-3 border border-2 border-white-50" 
                         style="width: 48px; height: 48px; object-fit: cover;" 
                         alt="Avatar">
                    <div class="overflow-hidden pe-3">
                        <h6 class="text-white fw-bold mb-0 text-truncate" style="font-size: 0.9rem;">{{ Auth::user()->nama }}</h6>
                        <small class="text-white-50 d-block text-truncate mb-2" style="font-size: 0.75rem;">NISN {{ Auth::user()->username }}</small>
                        <a href="{{ route('siswa.profil') }}" class="btn text-white py-1 px-2.5 fw-semibold rounded-pill d-inline-flex align-items-center" style="font-size: 0.7rem; background: #0f1b54; border: none; line-height: 1;">
                            <i class="mdi mdi-account-circle-outline me-1" style="font-size: 0.85rem;"></i> Lihat Profil
                        </a>
                    </div>
                </div>
            </li>

            {{-- Dashboard Siswa --}}
            <li class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                    <i class="menu-icon mdi mdi-view-dashboard"></i>
                    <span class="menu-title">Dashboard Siswa</span>
                </a>
            </li>

            <li class="nav-category">Akademik</li>

            <li class="nav-item {{ request()->is('siswa/modul*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('siswa.modul.index') }}">
                    <i class="menu-icon mdi mdi-book-multiple"></i>
                    <span class="menu-title">Modul</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('siswa.jadwal') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('siswa.jadwal') }}">
                    <i class="menu-icon mdi mdi-calendar-clock"></i>
                    <span class="menu-title">Jadwal Pelajaran</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('siswa.riwayat') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('siswa.riwayat') }}">
                    <i class="menu-icon mdi mdi-history"></i>
                    <span class="menu-title">Riwayat Kehadiran</span>
                </a>
            </li>

            <li class="nav-category">Ruang Ujian</li>

            <li class="nav-item {{ request()->is('siswa/ujian*') ? 'active-menu-induk' : '' }}">
                <a class="nav-link" href="{{ route('siswa.ujian.index') }}">
                    <i class="menu-icon mdi mdi-book-variant"></i>
                    <span class="menu-title">Ujian </span>
                </a>
            </li>
        @endif

        {{-- ==================================================================
           🟥 LOGOUT
           ================================================================== --}}
        <li class="nav-category">Autentikasi</li>
        <li class="nav-item btn-logout-sidebar">
            <a class="nav-link" href="#" title="Keluar / Log Out"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon mdi mdi-logout"></i>
                <span class="menu-title">Log Out</span>
            </a>
            <form id="logout-form" action="/logout" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
</nav>
