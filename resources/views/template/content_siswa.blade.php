@if(auth()->user()->role == 'siswa')
{{-- 🎨 MODERN STYLING UNTUK DASHBOARD SISWA --}}
<style>
    :root {
        --siswa-primary: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4f46e5 100%);
        --siswa-success: linear-gradient(135deg, #059669 0%, #10b981 100%);
        --siswa-warning: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        --siswa-info: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);
        --siswa-danger: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        --card-radius: 18px;
        --soft-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.8);
    }

    .card-modern {
        border-radius: var(--card-radius);
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: #ffffff;
        box-shadow: var(--soft-shadow);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 32px -8px rgba(37, 99, 235, 0.12);
    }

    /* Stat Cards */
    .stat-micro-card {
        border-radius: var(--card-radius);
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: var(--soft-shadow);
        padding: 18px 16px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .stat-micro-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.08);
    }
    .stat-icon-box {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ffffff;
        margin-bottom: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }
    .stat-number {
        font-size: 1.65rem;
        font-weight: 800;
        font-family: var(--font-heading), 'Outfit', sans-serif;
        line-height: 1;
        color: #0f172a;
    }
    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.1px;
    }
    .mapel-filter-select {
        font-size: 0.82rem !important;
        padding: 7px 34px 7px 14px !important;
        border-radius: 30px !important;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0 !important;
        color: #1e293b !important;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .mapel-filter-select:hover,
    .mapel-filter-select:focus {
        border-color: #3b82f6 !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    html.dark-mode .mapel-filter-select {
        background-color: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        color: #f1f5f9 !important;
    }

    /* Schedule Mobile Cards */
    .schedule-mobile-card {
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb !important;
        padding: 13px 14px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
    }
    .schedule-mobile-card-active {
        background: rgba(59, 130, 246, 0.04);
        border-color: rgba(59, 130, 246, 0.3);
    }
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
    .schedule-mapel-title {
        font-size: 0.95rem;
        line-height: 1.35;
        color: #1e293b;
    }
    html.dark-mode .schedule-mobile-card {
        background: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .schedule-mobile-card-active {
        background: rgba(59, 130, 246, 0.12) !important;
        border-color: rgba(59, 130, 246, 0.4) !important;
    }
    html.dark-mode .schedule-time-badge {
        background: rgba(59, 130, 246, 0.2) !important;
        color: #93c5fd !important;
    }
    html.dark-mode .schedule-mapel-title {
        color: #ffffff !important;
    }
    html.dark-mode .stat-number {
        color: #ffffff !important;
    }
    html.dark-mode .stat-label {
        color: #94a3b8 !important;
    }

    /* Welcome Hero Card */
    .hero-welcome-siswa {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%);
        border-radius: 22px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.35);
    }
    .hero-welcome-siswa::after {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, transparent 70%);
        top: -150px; right: -100px;
        pointer-events: none;
    }

    .hero-chips-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 10px;
    }
    .chip-info {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        padding: 9px 12px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        transition: background 0.2s ease;
    }
    .chip-info:hover {
        background: rgba(255, 255, 255, 0.16);
    }
    .chip-label {
        font-size: 10px !important;
        text-transform: uppercase;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.7);
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .chip-val {
        font-size: 13.5px !important;
        font-weight: 800;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        line-height: 1.2;
    }

    /* Timeline Izin */
    .timeline-mini {
        max-height: 280px;
        overflow-y: auto;
        padding-right: 6px;
    }
    .timeline-mini::-webkit-scrollbar { width: 5px; }
    .timeline-mini::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.15);
        border-radius: 10px;
    }

    /* Pulse Live Indicator */
    .pulse-live {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-ring-live 2s infinite;
        display: inline-block;
    }
    @keyframes pulse-ring-live {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Dark Mode Harmonization */
    html.dark-mode .card-modern,
    html.dark-mode .stat-micro-card {
        background: #0f172a !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }
    html.dark-mode .card-modern h4,
    html.dark-mode .card-modern h5,
    html.dark-mode .card-modern h6,
    html.dark-mode .stat-micro-card h3 {
        color: #ffffff !important;
    }
    html.dark-mode .card-modern p,
    html.dark-mode .stat-micro-card p {
        color: #cbd5e1 !important;
    }
    html.dark-mode .bg-light {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }

    /* Active Schedule Row Styling */
    .row-schedule-active {
        background-color: rgba(31, 59, 179, 0.05) !important;
    }
    .row-schedule-active td {
        background-color: rgba(31, 59, 179, 0.05) !important;
    }
    html.dark-mode .row-schedule-active,
    html.dark-mode .row-schedule-active td {
        background-color: rgba(59, 130, 246, 0.15) !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .row-schedule-active .text-dark {
        color: #ffffff !important;
    }
    html.dark-mode .row-schedule-active .text-primary {
        color: #60a5fa !important;
    }
    html.dark-mode .row-schedule-active .text-muted {
        color: #94a3b8 !important;
    }

    /* Dark Mode Table Support for Schedule */
    html.dark-mode .card-modern table.table {
        color: #e2e8f0 !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .card-modern table.table thead.table-light,
    html.dark-mode .card-modern table.table thead th {
        background-color: #1e293b !important;
        color: #94a3b8 !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .card-modern table.table tbody tr {
        border-color: rgba(255, 255, 255, 0.06) !important;
    }
    html.dark-mode .card-modern table.table tbody td {
        border-color: rgba(255, 255, 255, 0.06) !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .card-modern table.table tbody tr:hover td {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
    html.dark-mode .card-modern table.table .text-dark {
        color: #f1f5f9 !important;
    }
    html.dark-mode .card-modern table.table .text-primary {
        color: #60a5fa !important;
    }
    html.dark-mode .card-modern table.table .text-muted {
        color: #94a3b8 !important;
    }

    /* SAW Hall of Fame Dark Mode Harmonization */
    html.dark-mode .saw-card-award {
        background: linear-gradient(135deg, #1e293b 0%, #172033 100%) !important;
        border: 1px solid rgba(245, 158, 11, 0.25) !important;
        border-left: 6px solid #f59e0b !important;
    }
    html.dark-mode .saw-card-award h5 {
        color: #f1f5f9 !important;
    }
    html.dark-mode .saw-card-award p {
        color: #94a3b8 !important;
    }

    /* Dark Mode Support for Timeline, List Group & Modal */
    html.dark-mode .timeline-mini .bg-light,
    html.dark-mode .timeline-mini div[class*="bg-light"] {
        background-color: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.06) !important;
    }
    html.dark-mode .timeline-mini p.text-dark {
        color: #e2e8f0 !important;
    }
    html.dark-mode .list-group-item {
        background-color: transparent !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .list-group-item h6 {
        color: #ffffff !important;
    }
    html.dark-mode .modal-content {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
    }
    html.dark-mode .modal-footer.bg-light {
        background-color: #1e293b !important;
    }
    html.dark-mode .modal-body .form-control,
    html.dark-mode .modal-body .form-select {
        background-color: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
    }
    html.dark-mode .modal-body label {
        color: #cbd5e1 !important;
    }

    /* Mobile Responsive Optimizations for Siswa */
    @media (max-width: 767.98px) {
        .hero-welcome-siswa {
            border-radius: 18px !important;
            padding: 20px 16px !important;
        }
        .hero-welcome-title {
            font-size: 1.25rem !important;
            line-height: 1.35 !important;
        }
        .hero-subtitle {
            font-size: 12.5px !important;
            line-height: 1.5 !important;
            margin-bottom: 0.85rem !important;
        }
        .hero-chips-grid {
            gap: 6px !important;
            margin-top: 6px !important;
        }
        .chip-info {
            padding: 7px 8px !important;
            border-radius: 10px !important;
        }
        .chip-label {
            font-size: 8.5px !important;
            margin-bottom: 2px !important;
        }
        .chip-val {
            font-size: 11.5px !important;
        }
        .stat-micro-card {
            padding: 13px 12px !important;
            border-radius: 15px !important;
        }
        .stat-icon-box {
            width: 36px !important;
            height: 36px !important;
            font-size: 18px !important;
            margin-bottom: 8px !important;
            border-radius: 10px !important;
        }
        .stat-number {
            font-size: 1.35rem !important;
            margin-bottom: 2px !important;
        }
        .stat-label {
            font-size: 11px !important;
        }
        .card-modern {
            padding: 16px 14px !important;
            border-radius: 16px !important;
        }
        .timeline-mini .p-3 {
            padding: 12px 10px !important;
            border-radius: 12px !important;
        }
    }
</style>

{{-- 🌌 1. HERO BANNER PROFILE SISWA --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="hero-welcome-siswa p-4 p-md-5">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-12 col-lg-10">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="font-size: 11px;">
                            <i class="mdi mdi-school me-1"></i> Portal Siswa Digital
                        </span>
                        <span class="badge text-white px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px; background: rgba(255, 255, 255, 0.18); border: 1px solid rgba(255, 255, 255, 0.25);">
                            <span class="pulse-live me-1"></span> Aktif
                        </span>
                    </div>

                    <h2 class="fw-bold text-white mb-2 hero-welcome-title" style="font-size: 1.85rem;">
                        Selamat Datang, <span class="text-nowrap">{{ $siswa->nama_siswa ?? $siswa->nama_lengkap ?? $siswa->nama ?? 'Siswa' }}! 👋</span>
                    </h2>
                    <p class="text-white-50 mb-3 hero-subtitle" style="font-size: 14px; max-width: 720px;">
                        Hari ini <strong>{{ $hariIni ?? \Carbon\Carbon::now()->translatedFormat('l') }}, {{ now()->format('d') }} {{ ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][now()->month - 1] }} {{ now()->format('Y') }}</strong>. Pantau jadwal, presensi mandiri, dan tingkatkan prestasimu!
                    </p>

                    <!-- Chips Info (Compact 3-Column Grid) -->
                    <div class="hero-chips-grid">
                        <div class="chip-info">
                            <small class="chip-label"><i class="mdi mdi-school me-1"></i>Kelas</small>
                            <span class="chip-val" title="{{ $siswa->kelas->nama_kelas ?? '-' }}">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                        <div class="chip-info">
                            <small class="chip-label"><i class="mdi mdi-card-account-details-outline me-1"></i>NISN</small>
                            <span class="chip-val" title="{{ $siswa->nisn ?? $siswa->nis ?? '-' }}">{{ $siswa->nisn ?? $siswa->nis ?? '-' }}</span>
                        </div>
                        <div class="chip-info">
                            <small class="chip-label"><i class="mdi mdi-laptop me-1"></i>Jurusan</small>
                            <span class="chip-val" title="{{ $siswa->kelas->jurusan->nama_jurusan ?? 'Kejuruan' }}">{{ $siswa->kelas->jurusan->nama_jurusan ?? 'Kejuruan' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🏆 2. HALL OF FAME: PRESTASI & SISWA TELADAN (HASIL SAW) --}}
@php
    $terdisiplin = cache('siswa_terdisiplin');
    $isMe = $terdisiplin && (
        strtolower($terdisiplin['nama'] ?? '') === strtolower($siswa->nama_siswa ?? $siswa->nama_lengkap ?? '') ||
        (!empty($terdisiplin['nisn']) && ($terdisiplin['nisn'] ?? '') === ($siswa->nisn ?? ''))
    );
@endphp
@if($terdisiplin)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-modern saw-card-award border-0 overflow-hidden" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 50%, #fde68a 100%); border-left: 6px solid #d97706 !important;">
                <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 52px; height: 52px; border-radius: 16px; background: #d97706; color: white; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 8px 18px rgba(217, 119, 6, 0.35); flex-shrink: 0;">
                            <i class="mdi mdi-trophy"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 10px;">ANALISIS SAW MINGGU INI</span>
                                @if($isMe)
                                    <span class="badge bg-success text-white fw-bold px-2.5 py-1 rounded-pill" style="font-size: 10.5px;">🏆 SELAMAT! KAMU TERPILIH!</span>
                                @endif
                            </div>
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                Siswa Terdisiplin & Berprestasi: <span class="text-primary">{{ $terdisiplin['nama'] }}</span>
                            </h5>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                                Terpilih melalui perhitungan matematis (Kehadiran, Tugas, & Sikap) dengan skor preferensi SAW <strong>{{ number_format((float)($terdisiplin['skor'] ?? 0), 3) }}</strong>.
                            </p>
                        </div>
                    </div>
                    @if($isMe)
                        <div class="text-md-end flex-shrink-0">
                            <span class="badge bg-success px-3 py-2 rounded-pill fw-bold shadow-xs">
                                <i class="mdi mdi-star me-1"></i> Pertahankan Prestasimu!
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

{{-- 📊 3. STATISTIK KEHADIRAN (BENTO MICRO CARDS) --}}
@php
    $totHadir = $statistikSiswa['total_hadir'] ?? 0;
    $totIzin = $statistikSiswa['total_izin'] ?? 0;
    $totSakit = $statistikSiswa['total_sakit'] ?? 0;
    $totAlpa = $statistikSiswa['total_alpa'] ?? 0;
@endphp
<div class="row mb-3 align-items-center g-2 px-1">
    <div class="col-12 col-md-6 mb-1 mb-md-0">
        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center" style="font-size: 1.05rem;">
            <i class="mdi mdi-chart-donut text-primary me-2 fs-5"></i>Statistik Kehadiran
        </h5>
    </div>
    <div class="col-12 col-md-6 d-flex justify-content-start justify-content-md-end">
        <form action="{{ route('siswa.dashboard') }}" method="GET" class="w-100 w-md-auto">
            <div class="position-relative">
                <select name="mapel_id" class="form-select form-select-sm mapel-filter-select rounded-pill fw-bold" onchange="this.form.submit()">
                    <option value="">🔍 Semua Mata Pelajaran</option>
                    @foreach(($mapelList ?? []) as $mapel)
                        <option value="{{ $mapel->id }}" {{ (isset($selectedMapel) && $selectedMapel == $mapel->id) ? 'selected' : '' }}>
                            📚 {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<div class="row g-2 g-md-3 mb-4">
    <!-- HADIR -->
    <div class="col-6 col-md-3">
        <div class="stat-micro-card h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="stat-icon-box" style="background: var(--siswa-success);">
                    <i class="mdi mdi-account-check"></i>
                </div>
                <h3 class="fw-bold mb-1 stat-number">{{ $totHadir }}</h3>
            </div>
            <p class="stat-label mb-0 text-truncate">Hadir Tepat</p>
        </div>
    </div>
    <!-- IZIN -->
    <div class="col-6 col-md-3">
        <div class="stat-micro-card h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="stat-icon-box" style="background: var(--siswa-warning);">
                    <i class="mdi mdi-account-clock"></i>
                </div>
                <h3 class="fw-bold mb-1 stat-number">{{ $totIzin }}</h3>
            </div>
            <p class="stat-label mb-0 text-truncate">Izin</p>
        </div>
    </div>
    <!-- SAKIT -->
    <div class="col-6 col-md-3">
        <div class="stat-micro-card h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="stat-icon-box" style="background: var(--siswa-info);">
                    <i class="mdi mdi-medical-bag"></i>
                </div>
                <h3 class="fw-bold mb-1 stat-number">{{ $totSakit }}</h3>
            </div>
            <p class="stat-label mb-0 text-truncate">Sakit</p>
        </div>
    </div>
    <!-- ALPA -->
    <div class="col-6 col-md-3">
        <div class="stat-micro-card h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="stat-icon-box" style="background: var(--siswa-danger);">
                    <i class="mdi mdi-account-remove"></i>
                </div>
                <h3 class="fw-bold mb-1 stat-number">{{ $totAlpa }}</h3>
            </div>
            <p class="stat-label mb-0 text-truncate">Alpa</p>
        </div>
    </div>
</div>

{{-- 📅 4. JADWAL HARI INI & TIMELINE PENGAJUAN IZIN --}}
<div class="row g-4 mb-4">
    <!-- JADWAL KELAS HARI INI -->
    <div class="col-12 col-lg-8">
        <div class="card-modern h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="mdi mdi-calendar-clock text-primary me-2"></i>Jadwal Pelajaran Hari Ini
                    </h5>
                    <small class="text-muted">Jadwal resmi untuk kelas {{ $siswa->kelas->nama_kelas ?? '' }}</small>
                </div>
                <span class="badge bg-light text-primary border rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px;">
                    {{ $hariIni ?? \Carbon\Carbon::now()->translatedFormat('l') }}
                </span>
            </div>

            @if(count($jadwalHariIni ?? []) > 0)
                <!-- Desktop Table View -->
                <div class="d-none d-md-block" style="overflow-x: hidden;">
                    <table class="table table-hover align-middle m-0 w-100" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 28%; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">JAM</th>
                                <th style="width: 48%;">MATA PELAJARAN</th>
                                <th class="text-center" style="width: 24%; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(($jadwalHariIni ?? []) as $j)
                                @php
                                    $jamSekarang = now()->format('H:i:s');
                                    $isAktif = ($j->jam_mulai <= $jamSekarang && $j->jam_selesai >= $jamSekarang);
                                    $isSelesai = ($jamSekarang > $j->jam_selesai);
                                    $absen = $j->absensi->first();
                                @endphp
                                <tr class="{{ $isAktif ? 'row-schedule-active' : '' }}">
                                    <td class="fw-bold text-primary py-3 text-nowrap" style="font-size: 0.85rem;">
                                        <i class="mdi mdi-clock-outline me-1"></i>
                                        {{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem; line-height: 1.35; word-wrap: break-word;">
                                            {{ $j->mataPelajaran->nama_mapel ?? '-' }}
                                        </div>
                                        <small class="text-muted d-block mt-0.5 text-truncate" style="font-size: 0.78rem;" title="{{ $j->guru->nama_lengkap ?? '-' }}">
                                            <i class="mdi mdi-account-tie me-1 text-primary"></i>{{ $j->guru->nama_lengkap ?? '-' }}
                                        </small>
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($absen)
                                            <span class="badge bg-success text-white px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.72rem;">
                                                <i class="mdi mdi-check-circle me-1"></i>{{ strtoupper($absen->status) }}
                                            </span>
                                        @elseif($isAktif)
                                            <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fw-bold shadow-xs" style="font-size: 0.72rem;">
                                                <span class="pulse-live me-1"></span> Berlangsung
                                            </span>
                                        @elseif($isSelesai)
                                            <span class="badge bg-light text-muted border px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">Selesai</span>
                                        @else
                                            <span class="badge bg-light text-primary border px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">Akan Datang</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="d-md-none">
                    @foreach(($jadwalHariIni ?? []) as $j)
                        @php
                            $jamSekarang = now()->format('H:i:s');
                            $isAktif = ($j->jam_mulai <= $jamSekarang && $j->jam_selesai >= $jamSekarang);
                            $isSelesai = ($jamSekarang > $j->jam_selesai);
                            $absen = $j->absensi->first();
                            $statusColor = $absen ? '#10b981' : ($isAktif ? '#f59e0b' : ($isSelesai ? '#94a3b8' : '#2563eb'));
                        @endphp
                        <div class="schedule-mobile-card {{ $isAktif ? 'schedule-mobile-card-active' : '' }}" style="border-left-color: {{ $statusColor }} !important;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="schedule-time-badge">
                                    <i class="mdi mdi-clock-outline me-1"></i>{{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                                </span>
                                @if($absen)
                                    <span class="badge bg-success text-white px-2.5 py-1 rounded-pill fw-bold" style="font-size: 10px;">
                                        <i class="mdi mdi-check-circle me-1"></i>{{ strtoupper($absen->status) }}
                                    </span>
                                @elseif($isAktif)
                                    <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fw-bold shadow-xs" style="font-size: 10px;">
                                        <span class="pulse-live me-1"></span> Berlangsung
                                    </span>
                                @elseif($isSelesai)
                                    <span class="badge bg-light text-muted border px-2 py-0.5 rounded-pill" style="font-size: 10px;">Selesai</span>
                                @else
                                    <span class="badge bg-light text-primary border px-2 py-0.5 rounded-pill" style="font-size: 10px;">Akan Datang</span>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1 schedule-mapel-title">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</h6>
                            <div class="small text-muted d-flex align-items-center">
                                <i class="mdi mdi-account-tie me-1 text-primary"></i> {{ $j->guru->nama_lengkap ?? '-' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="mdi mdi-calendar-blank display-4 d-block mb-2 opacity-50"></i>
                    <p class="fw-bold mb-0">Tidak ada jadwal pelajaran hari ini.</p>
                    <small>Selamat beristirahat atau belajar mandiri!</small>
                </div>
            @endif
        </div>
    </div>

    <!-- TIMELINE PENGAJUAN IZIN -->
    <div class="col-12 col-lg-4">
        <div class="card-modern h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="mdi mdi-file-document-edit text-warning me-2"></i>Pengajuan Izin
                </h5>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-xs text-white" data-bs-toggle="modal" data-bs-target="#modalTambahIzin">
                    <i class="mdi mdi-plus-circle me-1"></i> Ajukan Izin
                </button>
            </div>

            <div class="timeline-mini">
                @forelse(($izinTerbaru ?? []) as $izin)
                    <div class="p-3 mb-2 rounded-3 bg-light border-0">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge {{ $izin->jenis == 'sakit' ? 'bg-danger text-white' : 'bg-info text-white' }} px-2 py-0.5 rounded-pill fw-bold" style="font-size: 10px;">
                                {{ strtoupper($izin->jenis) }}
                            </span>
                            <small class="text-muted" style="font-size: 11px;">{{ $izin->created_at->locale('id')->diffForHumans() }}</small>
                        </div>
                        <p class="text-dark small mb-2 fw-semibold" style="line-height: 1.4;">{{ Str::limit($izin->alasan, 55) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $izin->status == 'disetujui' ? 'bg-success text-white' : ($izin->status == 'ditolak' ? 'bg-danger text-white' : 'bg-warning text-dark') }} px-2.5 py-1 rounded-pill fw-bold" style="font-size: 10px;">
                                {{ strtoupper($izin->status) }}
                            </span>
                            <small class="text-muted" style="font-size: 11px;">{{ date('d M Y', strtotime($izin->tanggal_mulai)) }}</small>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="mdi mdi-email-open-outline display-5 d-block mb-2 opacity-50"></i>
                        <p class="small fw-bold mb-0">Belum ada riwayat pengajuan izin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- 📚 5. TUGAS TERBARU & MATERI TERBARU --}}
<div class="row g-4">
    <!-- TUGAS TERBARU -->
    <div class="col-12 col-md-6">
        <div class="card-modern h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="mdi mdi-clipboard-text-clock text-primary me-2"></i>Tugas Terbaru
                </h5>
                <span class="badge bg-light text-primary border rounded-pill px-2.5 py-1 small">E-Learning</span>
            </div>

            <div class="list-group list-group-flush">
                @forelse(($tugasTerbaru ?? []) as $t)
                    @php
                        $pengumpulan = $t->pengumpulan->first();
                        $isSubmitted = !empty($pengumpulan);
                        $isOverdue = $t->deadline && \Carbon\Carbon::now()->isAfter($t->deadline);
                    @endphp
                    <div class="list-group-item px-0 py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $t->judul }}</h6>
                            <span class="badge {{ $isSubmitted ? 'bg-success text-white' : ($isOverdue ? 'bg-danger text-white' : 'bg-warning text-dark') }} rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10.5px;">
                                {{ $isSubmitted ? ($pengumpulan->nilai ? 'Nilai: ' . $pengumpulan->nilai : 'Terkumpul') : ($isOverdue ? 'Terlambat' : 'Belum Kumpul') }}
                            </span>
                        </div>
                        <p class="text-muted small mb-2 text-truncate" style="max-width: 90%;">{{ $t->deskripsi }}</p>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted"><i class="mdi mdi-calendar-clock me-1"></i>Deadline: {{ $t->deadline ? $t->deadline->translatedFormat('d M Y, H:i') : 'Tanpa Batas' }}</small>
                            <a href="{{ route('siswa.tugas.form', $t->id) }}" class="btn btn-outline-primary btn-xs rounded-pill px-3 fw-bold">
                                {{ $isSubmitted ? 'Detail Tugas' : 'Kumpul Tugas' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="mdi mdi-checkbox-marked-circle-outline display-4 d-block mb-2 opacity-50 text-success"></i>
                        <p class="small fw-bold mb-0">Semua tugas telah diselesaikan!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- MATERI TERBARU -->
    <div class="col-12 col-md-6">
        <div class="card-modern h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="mdi mdi-book-open-page-variant text-success me-2"></i>Materi Pembelajaran
                </h5>
                <span class="badge bg-light text-success border rounded-pill px-2.5 py-1 small">Modul Ajar</span>
            </div>

            <div class="list-group list-group-flush">
                @forelse(($materiTerbaru ?? []) as $m)
                    <div class="list-group-item px-0 py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $m->judul }}</h6>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10.5px;">
                                {{ $m->jadwal->mataPelajaran->nama_mapel ?? 'Materi' }}
                            </span>
                        </div>
                        <p class="text-muted small mb-2 text-truncate" style="max-width: 90%;">{{ $m->deskripsi }}</p>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted"><i class="mdi mdi-account-tie me-1"></i>Oleh: {{ $m->jadwal->guru->nama_lengkap ?? 'Guru' }}</small>
                            <a href="{{ route('materi.download', $m->id) }}" class="btn btn-outline-success btn-xs rounded-pill px-3 fw-bold">
                                <i class="mdi mdi-download me-1"></i> Unduh
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="mdi mdi-folder-open-outline display-4 d-block mb-2 opacity-50"></i>
                        <p class="small fw-bold mb-0">Belum ada materi pembelajaran baru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endif

{{-- MODAL TAMBAH PENGAJUAN IZIN --}}
<div class="modal fade" id="modalTambahIzin" tabindex="-1" aria-labelledby="modalTambahIzinLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header p-4 border-0" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold text-white" id="modalTambahIzinLabel">
                    <i class="mdi mdi-email-plus me-2"></i>Form Pengajuan Izin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.izin.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Jenis Pengajuan</label>
                        <div class="d-flex gap-3">
                            <div class="flex-fill">
                                <input type="radio" class="btn-check" name="jenis" id="typeSakit" value="sakit" required>
                                <label class="btn btn-outline-danger w-100 py-3 rounded-4 fw-bold" for="typeSakit">
                                    <i class="mdi mdi-medical-bag d-block fs-3 mb-1"></i>SAKIT
                                </label>
                            </div>
                            <div class="flex-fill">
                                <input type="radio" class="btn-check" name="jenis" id="typeIzin" value="izin">
                                <label class="btn btn-outline-info w-100 py-3 rounded-4 fw-bold" for="typeIzin">
                                    <i class="mdi mdi-account-alert d-block fs-3 mb-1"></i>IZIN
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Mata Pelajaran</label>
                        <select name="mapel_id" id="mapel_select" class="form-select bg-light border-0" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach(($mapelList ?? []) as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }} data-guru="{{ $mapel->jadwal->first()->guru->nama_lengkap ?? 'N/A' }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Guru Pengampu</label>
                        <input type="text" id="guru_pengampu" class="form-control bg-light border-0" readonly placeholder="Pilih mata pelajaran terlebih dahulu...">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Mulai Tanggal</label>
                            <input type="date" name="tanggal_mulai" class="form-control bg-light border-0" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Sampai Tanggal</label>
                            <input type="date" name="tanggal_selesai" class="form-control bg-light border-0" value="{{ old('tanggal_selesai', date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ALASAN</label>
                        <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Mengalami demam dan disarankan dokter istirahat..." required>{{ old('alasan') }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-muted">FILE BUKTI / SURAT DOKTER (Opsional)</label>
                        <input type="file" name="file_bukti" class="form-control">
                        <div class="form-text small">Format: JPG, PNG, JPEG, PDF. Max: 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-secondary fw-bold rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm rounded-pill text-white px-4">
                        <i class="mdi mdi-send me-1"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mapelSelect = document.getElementById('mapel_select');
        if (mapelSelect) {
            mapelSelect.addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var guru = selectedOption.getAttribute('data-guru');
                document.getElementById('guru_pengampu').value = guru || 'Data guru tidak tersedia';
            });
        }
    });
</script>
