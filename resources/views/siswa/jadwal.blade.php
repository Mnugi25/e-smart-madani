@extends('template.layouts.app')

@section('title', 'Jadwal Pelajaran Saya')

@section('content')
<style>
    /* Filter Stat Badge */
    .filter-stat-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    /* Day Filter Pills Navigation */
    .day-filter-wrapper {
        position: relative;
    }
    .day-filter-container {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 6px;
        scrollbar-width: thin;
        -webkit-overflow-scrolling: touch;
    }
    .day-filter-container::-webkit-scrollbar {
        height: 4px;
    }
    .day-filter-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .day-pill-btn {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 30px;
        padding: 7px 16px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }
    .day-pill-btn:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }
    .day-pill-btn.active {
        background: #1f3bb3 !important;
        border-color: #1f3bb3 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(31, 59, 179, 0.25) !important;
    }
    .day-pill-btn.is-today-pill:not(.active) {
        border-color: #93c5fd;
        background: #eff6ff;
        color: #1d4ed8;
    }

    /* Day Section Card */
    .day-section-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    /* Schedule Card */
    .schedule-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        border-left: 4px solid #cbd5e1;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }
    .schedule-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        border-color: #cbd5e1;
    }
    .schedule-card.is-active {
        border-left: 4px solid #1f3bb3 !important;
        border-color: #bfdbfe !important;
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%) !important;
        box-shadow: 0 6px 18px rgba(31, 59, 179, 0.1) !important;
    }
    .schedule-card.is-past {
        border-left-color: #94a3b8;
        opacity: 0.95;
    }
    .schedule-card.is-future {
        border-left-color: #38bdf8;
    }

    /* Time Badge */
    .schedule-time-badge {
        background: #f8fafc;
        color: #475569;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        border: 1px solid #f1f5f9;
        letter-spacing: 0.2px;
    }
    .schedule-card.is-active .schedule-time-badge {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #dbeafe;
    }

    /* Pulse animation for active classes */
    .pulse-badge {
        animation: pulseAnimation 2s infinite;
    }
    @keyframes pulseAnimation {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(31, 59, 179, 0.4); }
        70% { transform: scale(1.02); box-shadow: 0 0 0 6px rgba(31, 59, 179, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(31, 59, 179, 0); }
    }

    /* Dark Mode Themes */
    html.dark-mode .day-section-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .schedule-card {
        background: #1e293b !important;
        border-color: #334155 !important;
        border-left-color: #475569;
    }
    html.dark-mode .schedule-card:hover {
        border-color: #475569 !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark-mode .schedule-card.is-active {
        background: linear-gradient(135deg, #1e3a8a 0%, #172554 100%) !important;
        border-color: #3b82f6 !important;
        border-left-color: #60a5fa !important;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.2) !important;
    }
    html.dark-mode .schedule-time-badge {
        background: #0f172a !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }
    html.dark-mode .schedule-card.is-active .schedule-time-badge {
        background: #1e3a8a !important;
        color: #93c5fd !important;
        border-color: #2563eb !important;
    }
    html.dark-mode .day-pill-btn {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #94a3b8 !important;
    }
    html.dark-mode .day-pill-btn:hover {
        background: #27272a !important;
        color: #f1f5f9 !important;
        border-color: #3f3f46 !important;
    }
    html.dark-mode .day-pill-btn.active {
        background: #1f3bb3 !important;
        border-color: #1f3bb3 !important;
        color: #ffffff !important;
    }
    html.dark-mode .day-pill-btn.is-today-pill:not(.active) {
        border-color: #1d4ed8 !important;
        background: rgba(30, 58, 138, 0.25) !important;
        color: #60a5fa !important;
    }
    html.dark-mode .filter-stat-badge {
        background: #18181b !important;
        border-color: #2e2e34 !important;
    }
    html.dark-mode .filter-stat-badge .text-muted {
        color: #a1a1aa !important;
    }
    html.dark-mode .header-mobile-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .day-icon-circle.bg-light {
        background-color: #27272a !important;
        border-color: #3f3f46 !important;
        color: #93c5fd !important;
    }
    html.dark-mode .avatar-mini.bg-primary-subtle {
        background: rgba(59, 130, 246, 0.15) !important;
        color: #60a5fa !important;
    }
    html.dark-mode .text-dark {
        color: #f1f5f9 !important;
    }
    html.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
</style>

<div class="row">
    {{-- Mobile Header (Outside Card) --}}
    <div class="col-12 d-md-none mt-2 mb-3">
        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-xs header-mobile-box" style="border: 1px solid rgba(0,0,0,0.06); background: #ffffff;">
            <div class="pe-2">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">
                    <i class="mdi mdi-calendar-clock text-primary me-2"></i>Jadwal Pelajaran
                </h4>
                <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.2;">
                    Kelas {{ $siswa->kelas->nama_kelas ?? (Auth::user()->siswa->kelas->nama_kelas ?? '') }} • Hari {{ $hariIni }}
                </p>
            </div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-bold text-nowrap">
                {{ $jadwal->flatten()->count() }} Mapel
            </span>
        </div>
    </div>

    {{-- Desktop Header Card --}}
    <div class="col-12 d-none d-md-block mb-4">
        <div class="card card-rounded shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="mdi mdi-calendar-clock fs-3"></i>
                        </div>
                        <div>
                            <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                                Jadwal Pelajaran Saya
                            </h4>
                            <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                                Agenda Kegiatan Belajar Mengajar (KBM) mingguan kelas {{ $siswa->kelas->nama_kelas ?? (Auth::user()->siswa->kelas->nama_kelas ?? '') }}.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Hari Ini:</span>
                            <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ $hariIni }}</strong>
                        </div>
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Total:</span>
                            <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ $jadwal->flatten()->count() }}</strong>
                            <span class="text-muted small ms-1">Mata Pelajaran</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Feedback Alerts --}}
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-check-circle me-2 fs-5"></i>
                    <div><strong>Sukses!</strong> {{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="col-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-alert-circle me-2 fs-5"></i>
                    <div><strong>Perhatian!</strong> {{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Interactive Day Filter Tabs --}}
    @if(count($jadwal) > 0)
        <div class="col-12 mb-4 day-filter-wrapper">
            <div class="day-filter-container">
                <button type="button" class="day-pill-btn active" data-day="all">
                    <i class="mdi mdi-calendar-month-outline me-1"></i> Semua Hari
                    <span class="badge rounded-pill bg-primary-subtle text-primary ms-1.5 px-2 py-0.5 fw-bold" style="font-size: 0.7rem;">{{ $jadwal->flatten()->count() }}</span>
                </button>
                @foreach($jadwal as $hari => $items)
                    @php
                        $isToday = ($hari == $hariIni);
                    @endphp
                    <button type="button" class="day-pill-btn {{ $isToday ? 'is-today-pill' : '' }}" data-day="{{ strtolower($hari) }}">
                        <i class="mdi {{ $isToday ? 'mdi-calendar-today' : 'mdi-calendar-blank-outline' }} me-1"></i>
                        {{ $hari }}
                        @if($isToday)
                            <span class="badge rounded-pill bg-primary text-white ms-1.5 px-2 py-0.5 fw-bold" style="font-size: 0.65rem;">Hari Ini</span>
                        @else
                            <span class="badge rounded-pill bg-light text-muted ms-1.5 px-2 py-0.5" style="font-size: 0.68rem;">{{ count($items) }}</span>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Jadwal Cards by Day --}}
    <div class="col-12">
        @forelse($jadwal as $hari => $items)
            @php
                $isTodayGroup = ($hari == $hariIni);
            @endphp
            <div class="day-section-card shadow-sm mb-4" data-day-section="{{ strtolower($hari) }}">
                <div class="p-3 p-md-4">
                    {{-- Day Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="day-icon-circle {{ $isTodayGroup ? 'bg-primary text-white shadow-sm' : 'bg-light text-primary border' }} rounded-circle d-flex align-items-center justify-content-center me-2.5 me-md-3" style="width: 36px; height: 36px;">
                                <i class="mdi {{ $isTodayGroup ? 'mdi-calendar-today' : 'mdi-calendar-blank-outline' }} fs-5"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">
                                        {{ strtoupper($hari) }}
                                    </h5>
                                    @if($isTodayGroup)
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.68rem;">
                                            <i class="mdi mdi-check-circle me-1"></i>Hari Ini
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-muted small fw-semibold">
                            <i class="mdi mdi-book-open-variant me-1"></i>{{ count($items) }} Sesi Pelajaran
                        </div>
                    </div>

                    {{-- Schedule Grid --}}
                    <div class="row g-3">
                        @foreach($items as $item)
                            @php
                                $isPast = ($hari == $hariIni && $item->jam_selesai < now()->format('H:i:s'));
                                $isFuture = ($hari == $hariIni && $item->jam_mulai > now()->format('H:i:s'));
                                $cardClass = $item->is_aktif ? 'is-active' : ($isPast ? 'is-past' : ($isFuture ? 'is-future' : ''));
                            @endphp
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="schedule-card h-100 p-3 {{ $cardClass }}">
                                    {{-- Card Top: Time & Status Badges --}}
                                    <div class="d-flex justify-content-between align-items-center mb-2.5 gap-2">
                                        <div class="schedule-time-badge">
                                            <i class="mdi mdi-clock-outline me-1"></i>
                                            {{ date('H:i', strtotime($item->jam_mulai)) }} - {{ date('H:i', strtotime($item->jam_selesai)) }}
                                        </div>
                                        @if($item->is_aktif)
                                            <span class="badge bg-primary rounded-pill px-2.5 py-1 text-white fw-bold shadow-xs pulse-badge" style="font-size: 0.65rem;">
                                                <i class="mdi mdi-access-point mdi-spin me-1"></i> BERLANGSUNG
                                            </span>
                                        @elseif($isPast)
                                            <span class="badge bg-secondary-subtle text-muted rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 0.65rem;">
                                                <i class="mdi mdi-check-all me-1"></i>SELESAI
                                            </span>
                                        @elseif($isFuture)
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 0.65rem;">
                                                <i class="mdi mdi-clock-outline me-1"></i>AKAN DATANG
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Card Middle: Subject Name & Teacher --}}
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.98rem; line-height: 1.45;" title="{{ $item->mataPelajaran->nama_mapel ?? '-' }}">
                                        {{ $item->mataPelajaran->nama_mapel ?? '-' }}
                                    </h6>

                                    <div class="d-flex align-items-center text-muted mb-3">
                                        <div class="avatar-mini bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 26px; height: 26px; font-size: 0.8rem;">
                                            <i class="mdi mdi-account-tie"></i>
                                        </div>
                                        <span class="small fw-semibold text-truncate text-dark" style="font-size: 0.8rem;" title="{{ $item->guru->nama_lengkap ?? '-' }}">
                                            {{ $item->guru->nama_lengkap ?? '-' }}
                                        </span>
                                    </div>

                                    {{-- Card Bottom: Action Buttons & Attendance --}}
                                    <div class="pt-2.5 border-top d-flex flex-wrap justify-content-between align-items-center gap-2 mt-auto">
                                        <div class="d-flex gap-1.5">
                                            <a href="{{ route('siswa.materi', $item->id) }}" class="btn btn-outline-info btn-xs rounded-pill px-2.5 py-1 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-book-open-page-variant"></i> Materi
                                            </a>
                                            <a href="{{ route('siswa.tugas', $item->id) }}" class="btn btn-outline-warning btn-xs rounded-pill px-2.5 py-1 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.75rem; color: #d97706; border-color: rgba(217, 119, 6, 0.35);">
                                                <i class="mdi mdi-clipboard-text-outline"></i> Tugas
                                            </a>
                                        </div>

                                        <div>
                                            @if($item->is_aktif)
                                                @if($item->sudah_absen)
                                                    <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1.5 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                                        <i class="mdi mdi-check-circle fs-6"></i> Sudah Absen
                                                    </span>
                                                @else
                                                    <form action="{{ route('siswa.presensi.submit') }}" method="POST" class="d-inline m-0">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-xs rounded-pill px-3 py-1.5 fw-bold shadow-sm d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                            <i class="mdi mdi-fingerprint fs-6"></i> Absen
                                                        </button>
                                                    </form>
                                                @endif
                                            @elseif($isPast)
                                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 fw-medium" style="font-size: 0.68rem;">
                                                    <i class="mdi mdi-clock-check-outline me-1"></i>Selesai
                                                </span>
                                            @else
                                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 fw-medium" style="font-size: 0.68rem;">
                                                    <i class="mdi mdi-lock-outline me-1"></i>Belum Buka
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="card card-rounded shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="mdi mdi-calendar-blank-outline text-muted fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Jadwal Pelajaran</h5>
                    <p class="text-muted small mb-0">Jadwal pelajaran untuk kelas Anda belum ditambahkan oleh administrator sekolah.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dayPills = document.querySelectorAll('.day-pill-btn');
    const daySections = document.querySelectorAll('[data-day-section]');

    dayPills.forEach(pill => {
        pill.addEventListener('click', function () {
            // Update active pill
            dayPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');

            const selectedDay = this.getAttribute('data-day');

            // Filter day sections
            daySections.forEach(section => {
                const sectionDay = section.getAttribute('data-day-section');
                if (selectedDay === 'all' || sectionDay === selectedDay) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
