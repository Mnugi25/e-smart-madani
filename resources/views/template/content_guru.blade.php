@if(auth()->user()->role == 'guru')
{{-- 🎨 MODERN STYLING UNTUK DASHBOARD GURU --}}
<style>
    :root {
        --guru-primary: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4f46e5 100%);
        --guru-success: linear-gradient(135deg, #059669 0%, #10b981 100%);
        --guru-warning: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        --guru-danger: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        --guru-info: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);
        --card-radius: 18px;
        --soft-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.8);
    }

    .card-guru-modern {
        border-radius: var(--card-radius);
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: #ffffff;
        box-shadow: var(--soft-shadow);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .card-guru-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 32px -8px rgba(37, 99, 235, 0.12);
    }

    /* Hero Banner Guru */
    .hero-welcome-guru {
        background: linear-gradient(135deg, #070d24 0%, #0f1b54 50%, #1e3a8a 100%);
        border-radius: 22px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.3);
    }
    .hero-welcome-guru::after {
        content: '';
        position: absolute;
        width: 350px; height: 350px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        top: -120px; right: -80px;
        pointer-events: none;
    }

    /* Hero Buttons */
    .btn-hero-ghost {
        background: rgba(255, 255, 255, 0.12) !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        color: #ffffff !important;
        backdrop-filter: blur(8px);
        transition: all 0.25s ease;
    }
    .btn-hero-ghost:hover {
        background: rgba(255, 255, 255, 0.25) !important;
        border-color: rgba(255, 255, 255, 0.6) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    }

    /* Stat Cards Guru */
    .stat-micro-guru {
        border-radius: var(--card-radius);
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 4px 15px -2px rgba(15, 23, 42, 0.04);
        padding: 22px 20px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-micro-guru:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px -4px rgba(37, 99, 235, 0.12);
        border-color: rgba(147, 197, 253, 0.8);
    }
    .stat-micro-guru i.bg-watermark {
        position: absolute;
        right: -8px;
        bottom: -10px;
        font-size: 4.5rem;
        opacity: 0.05;
        transform: rotate(-10deg);
        pointer-events: none;
    }
    .stat-micro-guru h3 {
        font-size: 1.85rem;
        font-family: var(--font-heading);
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .stat-icon-guru {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ffffff;
        margin-bottom: 12px;
    }

    /* Verification item */
    .verification-card-item {
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        margin-bottom: 10px;
        transition: background 0.2s ease;
    }
    .verification-card-item:hover {
        background: #f1f5f9;
    }

    /* Rank badge */
    .rank-circle-badge {
        width: 28px; height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* Schedule Time Badge */
    .schedule-time-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
        font-weight: 700;
        font-size: 0.78rem;
        padding: 3px 9px;
        border-radius: 20px;
    }

    /* Dark Mode Harmonization */
    html.dark-mode .card-guru-modern,
    html.dark-mode .stat-micro-guru {
        background: #0f172a !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }
    html.dark-mode .card-guru-modern h5,
    html.dark-mode .card-guru-modern h6,
    html.dark-mode .stat-micro-guru h3,
    html.dark-mode .card-guru-modern .text-dark,
    html.dark-mode .stat-micro-guru .text-dark,
    html.dark-mode .mobile-schedule-card .text-dark,
    html.dark-mode .task-mobile-card .text-dark {
        color: #ffffff !important;
    }
    html.dark-mode .card-guru-modern p,
    html.dark-mode .stat-micro-guru p {
        color: #94a3b8 !important;
    }
    html.dark-mode .verification-card-item {
        background: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .mobile-schedule-card,
    html.dark-mode .task-mobile-card {
        background: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .mobile-schedule-card h6,
    html.dark-mode .task-mobile-card h6 {
        color: #ffffff !important;
    }
    html.dark-mode .schedule-time-badge {
        background: rgba(59, 130, 246, 0.2) !important;
        color: #93c5fd !important;
    }
    html.dark-mode .bg-light {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }

    /* Mobile Responsive Optimizations for Guru */
    @media (max-width: 767.98px) {
        /* Hero Welcome Guru on Mobile */
        .hero-banner-row {
            margin-bottom: 16px !important;
        }
        .hero-welcome-guru {
            border-radius: 18px !important;
            padding: 18px 16px !important;
        }
        .hero-welcome-guru::after {
            width: 180px !important;
            height: 180px !important;
            top: -50px !important;
            right: -50px !important;
            opacity: 0.1 !important;
        }
        .hero-guru-badges {
            gap: 6px !important;
            margin-bottom: 8px !important;
        }
        .hero-guru-badges .badge {
            font-size: 10px !important;
            padding: 3.5px 9px !important;
            border-radius: 20px !important;
        }
        .hero-guru-title {
            font-size: 1.25rem !important;
            line-height: 1.35 !important;
            margin-bottom: 4px !important;
        }
        .hero-guru-sub {
            font-size: 12px !important;
            line-height: 1.5 !important;
            margin-bottom: 12px !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* 3 Hero Action Buttons on Mobile */
        .hero-guru-btn-group {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            gap: 6px !important;
            padding-top: 0 !important;
            margin-bottom: 12px !important;
            width: 100% !important;
        }
        .hero-guru-btn-group .btn {
            font-size: 11px !important;
            padding: 6px 10px !important;
            border-radius: 20px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            flex: 1 1 0 !important;
            min-width: 0 !important;
            white-space: nowrap !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12) !important;
            height: 35px !important;
        }
        .hero-guru-btn-group .btn i {
            font-size: 13px !important;
            margin-right: 3px !important;
        }

        /* Quick Filter Card on Mobile */
        .hero-filter-box {
            padding: 10px 12px !important;
            border-radius: 14px !important;
            margin-top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
        }
        .hero-filter-box .hero-filter-label {
            font-size: 0.72rem !important;
            margin-bottom: 4px !important;
        }
        .hero-filter-box .form-select {
            padding: 6px 12px !important;
            font-size: 12px !important;
            border-radius: 20px !important;
            height: 34px !important;
            line-height: 1.2 !important;
        }

        /* Stat Micro Cards on Mobile - Sleek, Balanced & Title Case */
        .stat-cards-row {
            --bs-gutter-x: 10px !important;
            --bs-gutter-y: 10px !important;
            margin-bottom: 16px !important;
        }
        .stat-micro-guru {
            padding: 13px 12px !important;
            border-radius: 16px !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04) !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            height: 100% !important;
        }
        .stat-micro-guru .stat-head {
            margin-bottom: 6px !important;
        }
        .stat-icon-guru {
            width: 34px !important;
            height: 34px !important;
            font-size: 17px !important;
            border-radius: 9px !important;
            margin-bottom: 0 !important;
        }
        .stat-micro-guru h3 {
            font-size: 1.45rem !important;
            font-weight: 800 !important;
            margin: 4px 0 2px !important;
            line-height: 1 !important;
        }
        .stat-micro-guru p {
            font-size: 11px !important;
            font-weight: 700 !important;
            line-height: 1.25 !important;
            margin-bottom: 0 !important;
            color: #64748b !important;
            text-transform: none !important;
            letter-spacing: 0.1px !important;
        }
        .stat-micro-guru i.bg-watermark {
            display: none !important;
        }
        .stat-micro-guru .badge {
            font-size: 9.5px !important;
            padding: 3px 8px !important;
            border-radius: 20px !important;
            font-weight: 700 !important;
        }

        .card-guru-modern {
            padding: 16px 14px !important;
            border-radius: 16px !important;
            margin-bottom: 16px !important;
        }
        .verification-card-item {
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 8px;
        }

        /* Mobile Schedule Card */
        .mobile-schedule-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        /* Task Mobile Card View */
        .task-mobile-card {
            border-radius: 14px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
    }
</style>

{{-- 👨‍🏫 1. HERO BANNER PROFILE GURU --}}
<div class="row mb-4 hero-banner-row">
    <div class="col-12">
        <div class="hero-welcome-guru p-4 p-md-5">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2 hero-guru-badges">
                        <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="font-size: 11px;">
                            <i class="mdi mdi-account-tie me-1"></i> Ruang Kerja Guru
                        </span>
                        @if($isWaliKelas)
                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold" style="font-size: 11px;">
                                <i class="mdi mdi-shield-star me-1"></i> Wali Kelas: {{ auth()->user()->guru->kelasWali->nama_kelas ?? 'Binaan' }}
                            </span>
                        @endif
                    </div>

                    <h2 class="fw-bold text-white mb-2 hero-guru-title" style="font-size: 1.85rem;">
                        Selamat Bertugas, <span class="d-inline-block">{{ auth()->user()->guru->nama_lengkap ?? auth()->user()->nama ?? 'Bapak/Ibu Guru' }}!</span> 👨‍🏫
                    </h2>
                    <p class="text-white-50 mb-3 hero-guru-sub" style="font-size: 14.5px;">
                        Hari ini <strong>{{ ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'][date('N') - 1] ?? 'Hari Ini' }}, {{ date('d F Y') }}</strong>. Kelola presensi kelas, susun modul ajar AI, dan evaluasi hasil belajar siswa dengan mudah.
                    </p>

                    <div class="d-flex flex-wrap gap-2 pt-2 hero-guru-btn-group">
                        <a href="{{ route('guru.rpp.index') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-bold text-white shadow-xs">
                            <i class="mdi mdi-magic me-1"></i> <span class="d-none d-sm-inline">Asisten </span>RPP AI
                        </a>
                        @if($isWaliKelas)
                            <a href="{{ route('guru.saw.index') }}" class="btn btn-warning btn-sm rounded-pill px-3 py-2 fw-bold text-dark shadow-xs">
                                <i class="mdi mdi-trophy me-1"></i> <span class="d-none d-sm-inline">Analisis </span>Prestasi SAW
                            </a>
                        @endif
                        <a href="{{ route('guru.rekap') }}" class="btn btn-hero-ghost btn-sm rounded-pill px-3 py-2 fw-bold text-white shadow-xs">
                            <i class="mdi mdi-file-chart me-1" style="color: #67e8f9 !important;"></i> Rekap<span class="d-none d-sm-inline"> Absensi</span>
                        </a>
                    </div>
                </div>

                <!-- Right Quick Filter Card -->
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-block text-start p-3 hero-filter-box" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 18px; width: 100%; max-width: 320px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18);">
                        <div class="d-flex align-items-center justify-content-between mb-2 hero-filter-label">
                            <span class="text-white small fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                <i class="mdi mdi-filter-variant text-warning me-1"></i> Filter Kelas Diampu:
                            </span>
                            @if(!empty($selectedKelasId))
                                <a href="{{ route('guru.dashboard') }}" class="badge bg-danger text-white text-decoration-none fw-bold" style="font-size: 10px;">Reset</a>
                            @endif
                        </div>
                        <form action="{{ route('guru.dashboard') }}" method="GET" id="filterForm">
                            <select name="kelas_id" class="form-select border-0 shadow-sm" onchange="this.form.submit()" style="font-size: 0.85rem; font-weight: 600; border-radius: 12px; padding: 9px 14px; background-color: #ffffff !important; color: #0f172a !important; cursor: pointer; height: auto !important; line-height: 1.4 !important;">
                                <option value="" style="color: #0f172a !important;">Semua Kelas Yang Anda Ampu</option>
                                @foreach(($daftarKelas ?? []) as $kls)
                                    <option value="{{ $kls->id }}" {{ ($selectedKelasId ?? '') == $kls->id ? 'selected' : '' }} style="color: #0f172a !important;">
                                        🏫 Kelas {{ $kls->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 📊 2. STAT CARDS (WALI KELAS VS GURU BIASA) --}}
@if($isWaliKelas)
    <div class="row g-3 mb-4 stat-cards-row">
        <!-- Siswa Kelas Saya -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-primary);">
                            <i class="mdi mdi-account-group"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            {{ auth()->user()->guru->kelasWali->nama_kelas ?? 'Binaan' }}
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalSiswaKelas ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Siswa Kelas Binaan</p>
                <i class="mdi mdi-account-group bg-watermark"></i>
            </div>
        </div>
        <!-- Siswa Hadir -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-success);">
                            <i class="mdi mdi-account-check"></i>
                        </div>
                        <span class="badge {{ ($hadirKelas ?? 0) > 0 ? 'bg-success-subtle text-success' : 'bg-light text-muted' }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            {{ ($totalSiswaKelas ?? 0) > 0 ? round((($hadirKelas ?? 0) / $totalSiswaKelas) * 100) : 0 }}% Hadir
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $hadirKelas ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Siswa Hadir Hari Ini</p>
                <i class="mdi mdi-account-check bg-watermark"></i>
            </div>
        </div>
        <!-- Pending Izin -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-warning);">
                            <i class="mdi mdi-account-alert"></i>
                        </div>
                        <span class="badge {{ ($pendingIzinKelas ?? 0) > 0 ? 'bg-warning-subtle text-warning' : 'bg-light text-muted' }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            {{ ($pendingIzinKelas ?? 0) > 0 ? 'Perlu Proses' : 'Selesai' }}
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $pendingIzinKelas ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Pengajuan Izin Pending</p>
                <i class="mdi mdi-account-alert bg-watermark"></i>
            </div>
        </div>
        <!-- Siswa Alpa -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-danger);">
                            <i class="mdi mdi-account-remove"></i>
                        </div>
                        <span class="badge {{ ($alpaKelas ?? 0) > 0 ? 'bg-danger-subtle text-danger' : 'bg-light text-muted' }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            {{ ($alpaKelas ?? 0) > 0 ? 'Perhatian' : 'Nihil' }}
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $alpaKelas ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Siswa Alpa / Tanpa Kabar</p>
                <i class="mdi mdi-account-remove bg-watermark"></i>
            </div>
        </div>
    </div>
@else
    <div class="row g-3 mb-4 stat-cards-row">
        <!-- Total Kelas Diajar -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-primary);">
                            <i class="mdi mdi-domain"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            Aktif
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ count($daftarKelas ?? []) }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Kelas Yang Diampu</p>
                <i class="mdi mdi-domain bg-watermark"></i>
            </div>
        </div>
        <!-- Total Siswa Diajar -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-success);">
                            <i class="mdi mdi-account-group"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            Semua Kelas
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalSiswaKelas ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Total Siswa Diajar</p>
                <i class="mdi mdi-account-group bg-watermark"></i>
            </div>
        </div>
        <!-- Total Materi -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-info);">
                            <i class="mdi mdi-book-open-page-variant"></i>
                        </div>
                        <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            E-Modul
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalMateri ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Materi Diunggah</p>
                <i class="mdi mdi-book-open-page-variant bg-watermark"></i>
            </div>
        </div>
        <!-- Tugas Belum Dinilai -->
        <div class="col-6 col-md-3">
            <div class="stat-micro-guru h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 stat-head">
                        <div class="stat-icon-guru mb-0" style="background: var(--guru-danger);">
                            <i class="mdi mdi-alert-circle-outline"></i>
                        </div>
                        <span class="badge {{ ($tugasBelumDinilai ?? 0) > 0 ? 'bg-danger-subtle text-danger' : 'bg-light text-muted' }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                            {{ ($tugasBelumDinilai ?? 0) > 0 ? 'Perlu Dinilai' : 'Lengkap' }}
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $tugasBelumDinilai ?? 0 }}</h3>
                </div>
                <p class="text-muted small fw-bold mb-0" style="font-size: 11px; letter-spacing: 0.1px;">Tugas Belum Dinilai</p>
                <i class="mdi mdi-alert-circle-outline bg-watermark"></i>
            </div>
        </div>
    </div>
@endif

{{-- 📅 3. JADWAL MENGAJAR HARI INI --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card-guru-modern p-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="mdi mdi-calendar-clock text-primary me-2"></i>Jadwal Mengajar Hari Ini
                    </h5>
                    <small class="text-muted">Daftar kelas aktif yang Anda ajar pada hari ini</small>
                </div>
                <span class="badge bg-light text-primary border rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px;">
                    <i class="mdi mdi-calendar-today me-1"></i>{{ ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'][date('N') - 1] ?? 'Hari Ini' }}, {{ date('d F Y') }}
                </span>
            </div>

            @if(count($jadwalHariIniGuru ?? []) > 0)
                <!-- Desktop View -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover text-center align-middle m-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">JAM</th>
                                <th>KELAS</th>
                                <th class="text-start">MATA PELAJARAN</th>
                                <th>KEHADIRAN SISWA</th>
                                <th style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalHariIniGuru as $j)
                                @php
                                    $totalSiswaKls = $j->kelas->siswa->count();
                                    $hadirCount = $j->absensi->where('tanggal', date('Y-m-d'))->where('status', 'hadir')->count();
                                    $hasAbsensi = $j->absensi->where('tanggal', date('Y-m-d'))->count() > 0;
                                @endphp
                                <tr>
                                    <td class="text-start fw-bold text-primary py-3">
                                        <i class="mdi mdi-clock-outline me-1"></i>{{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 11px;">
                                            {{ $j->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark text-start py-3">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</td>
                                    <td>
                                        <div class="d-inline-flex flex-column align-items-center">
                                            <span class="badge {{ $hadirCount > 0 ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-3 py-1 fw-bold" style="font-size: 11px;">
                                                {{ $hadirCount }} / {{ $totalSiswaKls }} Hadir
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.absen.kelas', $j->id) }}" class="btn btn-sm btn-primary text-white rounded-pill px-3 shadow-xs fw-bold">
                                            <i class="mdi mdi-account-check me-1"></i> {{ $hasAbsensi ? 'Edit Absensi' : 'Mulai Absen' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="d-md-none">
                    @foreach($jadwalHariIniGuru as $j)
                        @php
                            $totalSiswaKls = $j->kelas->siswa->count();
                            $hadirCount = $j->absensi->where('tanggal', date('Y-m-d'))->where('status', 'hadir')->count();
                            $hasAbsensi = $j->absensi->where('tanggal', date('Y-m-d'))->count() > 0;
                            $statusColor = $hasAbsensi ? '#10b981' : '#f59e0b';
                        @endphp
                        <div class="mobile-schedule-card mb-3" style="border-left: 4.5px solid {{ $statusColor }} !important;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="schedule-time-badge"><i class="mdi mdi-clock-outline me-1"></i>{{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}</span>
                                <span class="badge {{ $hasAbsensi ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                                    <i class="mdi {{ $hasAbsensi ? 'mdi-check-circle' : 'mdi-alert-circle-outline' }} me-1"></i>{{ $hasAbsensi ? 'Sudah Absen' : 'Belum Absen' }}
                                </span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted"><i class="mdi mdi-school me-1 text-primary"></i>Kelas: <strong class="text-dark">{{ $j->kelas->nama_kelas ?? '-' }}</strong></small>
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-2.5 py-1" style="font-size: 10px;">
                                    <i class="mdi mdi-account-check me-1"></i>{{ $hadirCount }}/{{ $totalSiswaKls }} Hadir
                                </span>
                            </div>
                            <a href="{{ route('guru.absen.kelas', $j->id) }}" class="btn btn-sm {{ $hasAbsensi ? 'btn-outline-primary' : 'btn-primary' }} text-white rounded-pill w-100 fw-bold py-2 shadow-xs" style="{{ !$hasAbsensi ? 'background: linear-gradient(135deg, #1e3a8a, #2563eb); border: none;' : '' }}">
                                <i class="mdi mdi-account-check me-1"></i> {{ $hasAbsensi ? 'Edit Absensi Kelas' : 'Mulai Absensi Sekarang' }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 14px;">
                        <i class="mdi mdi-calendar-check-outline"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">Tidak Ada Jadwal Mengajar Hari Ini</h6>
                    <p class="text-muted small mb-3" style="max-width: 480px; margin: 0 auto;">Hari ini tidak ada jam tatap muka terjadwal. Anda dapat memanfaatkan waktu untuk menyusun modul ajar, memeriksa tugas siswa, atau melakukan analisis prestasi SAW.</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('guru.modul.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1.5 fw-bold">
                            <i class="mdi mdi-book-multiple me-1"></i> Buka E-Modul
                        </a>
                        <a href="{{ route('guru.rpp.index') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fw-bold text-white shadow-xs">
                            <i class="mdi mdi-magic me-1"></i> Buat RPP AI
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- 🛡️ 4. VERIFIKASI IZIN & SISWA TERDISIPLIN --}}
<div class="row g-3 g-md-4">
    @if($isWaliKelas)
        <!-- Verifikasi Izin Siswa -->
        <div class="col-12 col-xl-7">
            <div class="card-guru-modern h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-shield-check text-primary me-2"></i>Verifikasi Izin Siswa
                        </h5>
                        <small class="text-muted">Pengajuan surat sakit dan izin dari siswa kelas Anda</small>
                    </div>
                    <a href="{{ route('guru.izin.index') }}" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3">
                        Lihat Semua
                    </a>
                </div>

                <div class="verification-list">
                    @forelse(($izinPending ?? []) as $izin)
                        <div class="verification-card-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0 {{ $izin->jenis == 'sakit' ? 'bg-danger text-white' : 'bg-warning text-dark' }}" style="width: 40px; height: 40px;">
                                    <i class="mdi {{ $izin->jenis == 'sakit' ? 'mdi-medical-bag' : 'mdi-account-alert' }} fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">{{ $izin->siswa->nama_lengkap ?? $izin->siswa->nama ?? 'Siswa' }}</h6>
                                    <small class="text-muted">{{ Str::limit($izin->alasan, 35) }}</small>
                                </div>
                            </div>
                            <a href="{{ route('guru.izin.index') }}" class="btn btn-primary btn-xs px-3 rounded-pill text-white fw-bold">
                                Proses
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-checkbox-marked-circle-outline display-4 d-block mb-2 opacity-50 text-success"></i>
                            <p class="small fw-bold mb-0">Tidak ada pengajuan izin yang tertunda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Siswa Terdisiplin (Top SAW) -->
        <div class="col-12 col-xl-5">
            <div class="card-guru-modern h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-trophy text-warning me-2"></i>Siswa Terdisiplin
                        </h5>
                        <small class="text-muted">Ranking kehadiran kelas binaan</small>
                    </div>
                    <a href="{{ route('guru.saw.index') }}" class="btn btn-xs btn-outline-warning text-dark fw-bold rounded-pill px-3 shadow-xs">
                        <i class="mdi mdi-calculator me-1"></i> Analisis SAW
                    </a>
                </div>

                @forelse(($topSiswa ?? []) as $index => $ts)
                    <div class="d-flex align-items-center justify-content-between mb-2 p-2.5 rounded-3 bg-light border-start border-3 border-primary">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rank-circle-badge {{ $index == 0 ? 'bg-warning text-dark' : ($index == 1 ? 'bg-secondary text-white' : 'bg-info text-white') }}">
                                {{ $index + 1 }}
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $ts->siswa->nama_lengkap ?? 'Siswa' }}</h6>
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 11px;">
                            {{ $ts->total_hadir ?? 0 }} Hadir
                        </span>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="mdi mdi-chart-timeline-variant display-5 d-block mb-2 opacity-50"></i>
                        <p class="small fw-bold mb-0">Data ranking belum tersedia.</p>
                        <small>Lakukan kalkulasi di menu Analisis SAW.</small>
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <!-- Untuk Guru Biasa: Status Pengumpulan Tugas -->
        <div class="col-12 col-xl-8">
            <div class="card-guru-modern h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-file-document text-primary me-2"></i>Status Pengumpulan Tugas
                        </h5>
                        <small class="text-muted">Tugas aktif pada mata pelajaran yang Anda ampu</small>
                    </div>
                    <span class="badge bg-light text-primary border rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px;">Mata Pelajaran Anda</span>
                </div>

                <!-- Desktop Table View -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle text-center m-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">JUDUL TUGAS</th>
                                <th>KELAS</th>
                                <th>DEADLINE</th>
                                <th>PENGUMPULAN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($tugasTerbaru ?? []) as $t)
                                @php
                                    $totalSiswaClass = $t->jadwal->kelas->siswa->count();
                                    $submittedCount = $t->pengumpulan->count();
                                @endphp
                                <tr>
                                    <td class="text-start fw-bold text-dark">{{ $t->judul }}</td>
                                    <td><span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1">{{ $t->jadwal->kelas->nama_kelas ?? '-' }}</span></td>
                                    <td><small class="text-muted">{{ $t->deadline ? $t->deadline->format('d M Y, H:i') : '-' }}</small></td>
                                    <td>
                                        <span class="badge {{ $submittedCount == $totalSiswaClass ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-3 py-1 fw-bold">
                                            {{ $submittedCount }} / {{ $totalSiswaClass }} Siswa
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.tugas.pengumpulan', $t->id) }}" class="btn btn-xs btn-primary text-white rounded-pill px-3 fw-bold shadow-xs">
                                            Nilai Tugas
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-muted text-center">
                                        <i class="mdi mdi-file-document-outline display-5 d-block mb-2 opacity-50"></i>
                                        <p class="small fw-bold mb-0">Belum ada tugas yang dibuat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="d-md-none">
                    @forelse(($tugasTerbaru ?? []) as $t)
                        @php
                            $totalSiswaClass = $t->jadwal->kelas->siswa->count();
                            $submittedCount = $t->pengumpulan->count();
                            $isComplete = ($submittedCount == $totalSiswaClass && $totalSiswaClass > 0);
                        @endphp
                        <div class="task-mobile-card" style="border-left: 4px solid {{ $isComplete ? '#10b981' : '#f59e0b' }} !important;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-2.5 py-1" style="font-size: 10.5px;">
                                    {{ $t->jadwal->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="badge {{ $isComplete ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                                    {{ $submittedCount }} / {{ $totalSiswaClass }} Siswa
                                </span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $t->judul }}</h6>
                            <small class="text-muted d-block mb-3">
                                <i class="mdi mdi-calendar-clock me-1"></i>Deadline: {{ $t->deadline ? $t->deadline->format('d M Y, H:i') : '-' }}
                            </small>
                            <a href="{{ route('guru.tugas.pengumpulan', $t->id) }}" class="btn btn-sm btn-primary text-white rounded-pill w-100 fw-bold shadow-xs">
                                <i class="mdi mdi-check-all me-1"></i> Nilai Tugas
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-file-document-outline display-5 d-block mb-2 opacity-50"></i>
                            <p class="small fw-bold mb-0">Belum ada tugas yang dibuat.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Siswa Izin Hari Ini -->
        <div class="col-12 col-xl-4">
            <div class="card-guru-modern h-100 p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="mdi mdi-account-alert text-warning me-2"></i>Siswa Izin Hari Ini
                </h5>
                <div style="max-height: 350px; overflow-y: auto;">
                    @forelse(($daftarIzinHariIni ?? []) as $izin)
                        <div class="p-2.5 mb-2 rounded-3 bg-light border-start border-warning border-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $izin->siswa->nama_lengkap ?? $izin->siswa->nama ?? 'Siswa' }}</h6>
                                <small class="text-muted">{{ $izin->siswa->kelas->nama_kelas ?? '-' }} &bull; <span class="badge bg-warning-subtle text-warning px-2 py-0.5">{{ strtoupper($izin->jenis) }}</span></small>
                            </div>
                            <small class="text-dark fw-bold">{{ Str::limit($izin->alasan, 18) }}</small>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-check-circle-outline display-5 d-block mb-2 opacity-50 text-success"></i>
                            <p class="small fw-bold mb-0">Tidak ada siswa yang izin hari ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
@endif
