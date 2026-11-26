{{-- CSS PREMIUM ADMIN/OPERATOR --}}
<style>
    :root {
        --admin-primary: linear-gradient(135deg, #0f1b54 0%, #1f3bb3 100%);
        --admin-success: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
        --admin-warning: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        --admin-danger: linear-gradient(135deg, #991b1b 0%, #ef4444 100%);
        --admin-secondary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    }

    .stat-card-admin {
        border: none;
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 130px;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
    }
    .stat-card-admin:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
    }
    .stat-card-admin i {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.15;
        transform: rotate(-15deg);
    }
    .stat-card-admin .card-title {
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        opacity: 0.95;
        text-transform: uppercase;
        margin-bottom: 5px;
        color: #ffffff !important;
    }
    .stat-card-admin .card-val {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 0;
        color: #ffffff !important;
    }
    .stat-card-admin p,
    .stat-card-admin .small,
    .stat-card-admin span {
        color: #ffffff !important;
    }
    .stat-card-admin .small.opacity-75 {
        opacity: 0.95 !important;
    }

    .table-premium-admin {
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .table-premium-admin tr {
        background: #fdfdfd;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        border-radius: 12px;
        transition: all 0.2s;
    }
    .table-premium-admin tr:hover {
        background: #f8fafc;
        transform: scale(1.002);
    }
    .table-premium-admin td {
        border: none;
        padding: 15px;
    }
    .table-premium-admin td:first-child { border-radius: 12px 0 0 12px; }
    .table-premium-admin td:last-child { border-radius: 0 12px 12px 0; }

    .initial-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
    }

    .log-feed-item {
        border-left: 3px solid #e5e7eb;
        padding-left: 20px;
        padding-bottom: 20px;
        position: relative;
    }
    .log-feed-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 13px;
        height: 13px;
        background: white;
        border: 3px solid #3b82f6;
        border-radius: 50%;
    }
    .log-feed-item:last-child { border-left: none; }

    .admin-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
        border-radius: 20px;
        padding: 26px 30px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.25);
        margin-bottom: 24px;
    }
    .admin-hero-banner::after {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Filter Buttons Grafik Tren Kehadiran */
    .filter-grafik-container {
        display: inline-flex;
        padding: 3px;
        background: #f1f5f9 !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 50px;
        gap: 2px;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .filter-grafik-container::-webkit-scrollbar {
        display: none;
    }
    .btn-filter-grafik {
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 11.5px;
        font-weight: 700;
        padding: 5px 13px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        outline: none !important;
    }
    .btn-filter-grafik:hover {
        color: #0f172a;
        background: rgba(0, 0, 0, 0.04);
    }
    .btn-filter-grafik.active {
        background: #4f46e5 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
    }
    html.dark-mode .filter-grafik-container {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .btn-filter-grafik {
        color: #a1a1aa;
    }
    html.dark-mode .btn-filter-grafik:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.06);
    }
    html.dark-mode .btn-filter-grafik.active {
        background: #6366f1 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.35);
    }
</style>

{{-- HERO COMMAND BANNER ADMIN --}}
<div class="admin-hero-banner">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-12">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="text-white-50 small"><i class="mdi mdi-calendar-blank-outline me-1"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h3 class="fw-bold text-white mb-1" style="font-size: 1.45rem;">Pusat Kontrol & Manajemen E-Learning</h3>
            <p class="text-white-50 mb-0 small">Pantau metrik akademik, kehadiran harian, dan operasional SMK Al-Madani secara real-time.</p>
        </div>
    </div>
</div>

{{-- BARIS 1: WIDGET STATISTIK GRADIENT --}}
<div class="row">
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="stat-card-admin p-4" style="background: var(--admin-primary)">
            <p class="card-title">TOTAL SISWA</p>
            <h2 class="card-val">{{ $totalSiswa }}</h2>
            <p class="small mb-0 opacity-75 mt-2"><i class="mdi mdi-check-circle-outline me-1"></i> Siswa Aktif</p>
            <i class="mdi mdi-account-group"></i>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="stat-card-admin p-4" style="background: var(--admin-secondary)">
            <p class="card-title">TOTAL GURU</p>
            <h2 class="card-val">{{ $totalGuru }}</h2>
            <p class="small mb-0 opacity-75 mt-2"><i class="mdi mdi-star-circle-outline me-1"></i> Pengajar Aktif</p>
            <i class="mdi mdi-account-tie"></i>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="stat-card-admin p-4" style="background: var(--admin-success)">
            <p class="card-title">TOTAL KELAS</p>
            <h2 class="card-val">{{ $totalKelas }}</h2>
            <p class="small mb-0 opacity-75 mt-2"><i class="mdi mdi-door-open me-1"></i> Kelas Terdaftar</p>
            <i class="mdi mdi-school"></i>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="stat-card-admin p-4" style="background: var(--admin-warning)">
            <p class="card-title">TOTAL JURUSAN</p>
            <h2 class="card-val">{{ $totalJurusan }}</h2>
            <p class="small mb-0 opacity-75 mt-2"><i class="mdi mdi-domain me-1"></i> Jurusan Aktif</p>
            <i class="mdi mdi-briefcase"></i>
        </div>
    </div>
</div>


{{-- BARIS 2: GRAFIK TREN & RINCIAN KEHADIRAN --}}
<div class="row mb-4">
    {{-- GRAFIK TREN --}}
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm" style="border-radius: 24px; overflow: hidden;">
            {{-- Header Card dengan gradient subtle --}}
            <div class="card-body p-0">
                <div class="card-header-subtle" style="padding: 24px 28px 18px;">
                    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-start align-items-xl-center gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.2);"></div>
                                <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 16px; letter-spacing: -0.3px;">Grafik Tren Kehadiran</h5>
                            </div>
                            <p class="mb-0 text-muted" id="subJudulGrafikTren" style="font-size: 12.5px;">Rata-rata persentase kehadiran siswa minggu ini</p>
                        </div>

                        {{-- Filter Buttons & Stats Badges --}}
                        <div class="d-flex flex-wrap align-items-center gap-2.5">
                            {{-- Filter Buttons Akademik (Hari Ini, Minggu Ini, Bulan Ini, Semester Ganjil, Semester Genap) --}}
                            <div class="filter-grafik-container">
                                <button type="button" class="btn-filter-grafik" data-filter="hari_ini">
                                    Hari Ini
                                </button>
                                <button type="button" class="btn-filter-grafik active" data-filter="minggu_ini">
                                    Minggu Ini
                                </button>
                                <button type="button" class="btn-filter-grafik" data-filter="bulan_ini">
                                    Bulan Ini
                                </button>
                                <button type="button" class="btn-filter-grafik" data-filter="sem_ganjil">
                                    Semester Ganjil
                                </button>
                                <button type="button" class="btn-filter-grafik" data-filter="sem_genap">
                                    Semester Genap
                                </button>
                            </div>

                            {{-- Badge stats --}}
                            <div class="d-none d-sm-flex gap-2">
                                <div style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); border-radius: 100px; padding: 5px 12px; display: flex; align-items: center; gap: 6px;">
                                    <div style="width: 7px; height: 7px; border-radius: 50%; background: #10b981;"></div>
                                    <span style="font-size: 11.5px; font-weight: 700; color: #065f46;">{{ $hadirHariIni }} Hadir</span>
                                </div>
                                <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.15); border-radius: 100px; padding: 5px 12px; display: flex; align-items: center; gap: 6px;">
                                    <div style="width: 7px; height: 7px; border-radius: 50%; background: #ef4444;"></div>
                                    <span style="font-size: 11.5px; font-weight: 700; color: #991b1b;">{{ $alpaHariIni }} Alpa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart Area --}}
                <div class="card-body-subtle" style="padding: 24px 28px 20px;">
                    <div style="position: relative; height: 280px;">
                        <canvas id="trenPresensiChart"></canvas>
                    </div>

                    {{-- Legend bawah --}}
                    <div class="d-flex align-items-center justify-content-center gap-4 mt-3 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 24px; height: 3px; background: linear-gradient(90deg, #4f46e5, #818cf8); border-radius: 2px;"></div>
                            <span style="font-size: 12px; color: #64748b; font-weight: 600;">% Kehadiran</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background: #4f46e5; border: 2px solid #c7d2fe;"></div>
                            <span style="font-size: 12px; color: #64748b; font-weight: 600;" id="legendDataLabel">Data per Hari</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background: #e0e7ff; border: 2px solid #a5b4fc;"></div>
                            <span style="font-size: 12px; color: #64748b; font-weight: 600;">Tidak Ada Data</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RINCIAN HARI INI --}}
    <div class="col-lg-4">
        @php
            $totalPresensi = $hadirHariIni + $sakitHariIni + $izinHariIni + $alpaHariIni;
            $persenHadir = $totalPresensi > 0 ? round(($hadirHariIni / $totalPresensi) * 100) : 0;
            $persenSakit = $totalPresensi > 0 ? round(($sakitHariIni / $totalPresensi) * 100) : 0;
            $persenIzin = $totalPresensi > 0 ? round(($izinHariIni / $totalPresensi) * 100) : 0;
            $persenAlpa = $totalPresensi > 0 ? round(($alpaHariIni / $totalPresensi) * 100) : 0;
        @endphp
        <div class="card border-0 shadow-sm h-100" style="border-radius: 24px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="card-header-subtle" style="padding: 24px 24px 18px;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.2);"></div>
                        <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 16px; letter-spacing: -0.3px;">Status Kehadiran</h5>
                    </div>
                    <p class="mb-0" style="font-size: 12.5px; color: #94a3b8;">Rincian absensi siswa hari ini</p>
                </div>

                <div class="card-body-subtle" style="padding: 20px 24px 24px;">


                    {{-- Hadir --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                                <span style="font-size: 13px; font-weight: 600; color: #374151;">Hadir</span>
                            </div>
                            <span style="font-size: 13px; font-weight: 700; color: #10b981;">{{ $hadirHariIni }} <span style="color: #94a3b8; font-weight: 500;">({{ $persenHadir }}%)</span></span>
                        </div>
                        <div style="height: 7px; background: #f1f5f9; border-radius: 100px; overflow: hidden;">
                            <div style="width: {{ $persenHadir }}%; height: 100%; background: linear-gradient(90deg, #10b981, #34d399); border-radius: 100px; transition: width 1s ease;"></div>
                        </div>
                    </div>

                    {{-- Sakit --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; border-radius: 50%; background: #0ea5e9;"></div>
                                <span style="font-size: 13px; font-weight: 600; color: #374151;">Sakit</span>
                            </div>
                            <span style="font-size: 13px; font-weight: 700; color: #0ea5e9;">{{ $sakitHariIni }} <span style="color: #94a3b8; font-weight: 500;">({{ $persenSakit }}%)</span></span>
                        </div>
                        <div style="height: 7px; background: #f1f5f9; border-radius: 100px; overflow: hidden;">
                            <div style="width: {{ $persenSakit }}%; height: 100%; background: linear-gradient(90deg, #0ea5e9, #38bdf8); border-radius: 100px;"></div>
                        </div>
                    </div>

                    {{-- Izin --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b;"></div>
                                <span style="font-size: 13px; font-weight: 600; color: #374151;">Izin</span>
                            </div>
                            <span style="font-size: 13px; font-weight: 700; color: #f59e0b;">{{ $izinHariIni }} <span style="color: #94a3b8; font-weight: 500;">({{ $persenIzin }}%)</span></span>
                        </div>
                        <div style="height: 7px; background: #f1f5f9; border-radius: 100px; overflow: hidden;">
                            <div style="width: {{ $persenIzin }}%; height: 100%; background: linear-gradient(90deg, #f59e0b, #fbbf24); border-radius: 100px;"></div>
                        </div>
                    </div>

                    {{-- Alpa --}}
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></div>
                                <span style="font-size: 13px; font-weight: 600; color: #374151;">Alpa</span>
                            </div>
                            <span style="font-size: 13px; font-weight: 700; color: #ef4444;">{{ $alpaHariIni }} <span style="color: #94a3b8; font-weight: 500;">({{ $persenAlpa }}%)</span></span>
                        </div>
                        <div style="height: 7px; background: #f1f5f9; border-radius: 100px; overflow: hidden;">
                            <div style="width: {{ $persenAlpa }}%; height: 100%; background: linear-gradient(90deg, #ef4444, #f87171); border-radius: 100px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 3: MONITORING & LOGS --}}
<div class="row">
    {{-- LOG AKTIVITAS GURU --}}
    <div class="col-lg-12 mb-4">
        <div class="card card-rounded shadow-sm border-0 h-100" style="border-radius: 20px;">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-4"><i class="mdi mdi-history text-primary me-2"></i>Log Aktivitas Guru</h5>
                <div class="log-container px-2" style="max-height: 400px; overflow-y: auto;">
                    @forelse($logAbsensi as $log)
                    <div class="log-feed-item">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $log->guru->nama_lengkap ?? 'Guru' }}</h6>
                            <span class="badge bg-light text-muted border small">{{ date('H:i', strtotime($log->created_at)) }}</span>
                        </div>
                        <p class="text-muted small mb-0">Mensinkronkan absensi kelas <span class="fw-bold text-primary">{{ $log->kelas->nama_kelas ?? '-' }}</span></p>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="mdi mdi-timeline-text-outline display-4 d-block mb-2 opacity-25"></i>
                        Belum ada aktivitas hari ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CONFIG JAVASCRIPT CHART.JS DENGAN FILTER TREN KEHADIRAN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const canvas = document.getElementById('trenPresensiChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    // Kumpulan Data Filter (Hari Ini, Minggu Ini, Bulan Ini, Semester Ganjil, Semester Genap)
    const filterDatasets = {!! json_encode($trenKehadiranData ?? []) !!};

    const defaultFilter = 'minggu_ini';
    let currentData = filterDatasets[defaultFilter] || {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
        data: [null, null, null, null, null],
        subtitle: 'Rata-rata persentase kehadiran siswa minggu ini',
        unit: 'Data per Hari'
    };

    // Gradient Indigo premium
    const gradient = ctx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.22)');
    gradient.addColorStop(0.6, 'rgba(79, 70, 229, 0.05)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    const trenChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: currentData.labels,
            datasets: [{
                label: 'Kehadiran (%)',
                data: currentData.data,
                borderColor: '#4f46e5',
                backgroundColor: gradient,
                fill: true,
                tension: 0.35,
                lineTension: 0.35,
                borderWidth: 3,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4.5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#4f46e5',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2.5,
                spanGaps: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 750, easing: 'easeInOutQuart' },
            interaction: { intersect: false, mode: 'index' },
            legend: { display: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#e2e8f0',
                    bodyColor: '#94a3b8',
                    borderColor: 'rgba(79, 70, 229, 0.3)',
                    borderWidth: 1,
                    padding: { x: 16, y: 12 },
                    cornerRadius: 12,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    callbacks: {
                        title: items => '📅 ' + items[0].label,
                        label: item => {
                            const val = item.raw ?? item.yLabel;
                            return val !== null && val !== undefined
                                ? '   Kehadiran: ' + val + '%'
                                : '   Tidak ada data';
                        }
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.04)',
                        lineWidth: 1
                    },
                    ticks: {
                        stepSize: 20,
                        callback: v => v + '%',
                        color: '#94a3b8',
                        font: { size: 11, weight: '600' },
                        padding: 8
                    },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 12, weight: '600' },
                        padding: 8
                    },
                    border: { display: false }
                }
            }
        }
    });

    // Event Handler untuk Tombol Filter (1 Hari, 1 Minggu, 3 Bulan, 6 Bulan)
    const filterButtons = document.querySelectorAll('.btn-filter-grafik');
    const subtitleElem = document.getElementById('subJudulGrafikTren');
    const legendDataLabel = document.getElementById('legendDataLabel');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const filterKey = this.getAttribute('data-filter');
            if (!filterDatasets || !filterDatasets[filterKey]) return;

            // Update status tombol aktif
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const selected = filterDatasets[filterKey];

            // Update keterangan teks
            if (subtitleElem && selected.subtitle) {
                subtitleElem.innerText = selected.subtitle;
            }
            if (legendDataLabel && selected.unit) {
                legendDataLabel.innerText = selected.unit;
            }

            // Update data grafik dengan animasi mulus
            trenChart.data.labels = selected.labels;
            trenChart.data.datasets[0].data = selected.data;
            trenChart.update();
        });
    });
});
</script>

