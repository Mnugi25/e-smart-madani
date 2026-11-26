@extends('template.layouts.app')

@section('title', 'Jadwal Mengajar & Presensi')

@section('content')
<style>
    /* Header Stat Badge */
    .header-stat-badge {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        padding: 6px 16px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    /* Schedule Card Modern */
    .schedule-card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .schedule-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .schedule-card-modern.is-active {
        border-color: #3b82f6;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.12);
    }
    .schedule-card-header {
        padding: 18px 20px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px dashed #f1f5f9;
    }
    .schedule-card-body {
        padding: 20px;
        flex: 1 1 auto;
    }
    .schedule-card-footer {
        padding: 16px 20px 20px;
        background: #fafafa;
        border-top: 1px solid #f1f5f9;
    }

    .schedule-time-badge {
        font-size: 0.78rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #334155;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
    }

    .badge-menunggu-jadwal {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        display: inline-block;
        margin-right: 6px;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-dot 1.5s infinite;
    }
    @keyframes pulse-dot {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Sub Action Buttons (Materi & Tugas) */
    .btn-sub-action {
        font-size: 0.82rem;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }
    .btn-sub-materi {
        background: rgba(14, 165, 233, 0.1);
        color: #0284c7;
        border: 1px solid rgba(14, 165, 233, 0.25);
    }
    .btn-sub-materi:hover {
        background: #0284c7;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);
    }
    .btn-sub-tugas {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }
    .btn-sub-tugas:hover {
        background: #d97706;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(217, 119, 6, 0.25);
    }

    /* Dark Mode Overrides */
    html.dark-mode .header-stat-badge {
        background: #18181b !important;
        border-color: #2e2e34 !important;
    }
    html.dark-mode .header-stat-badge .text-muted {
        color: #a1a1aa !important;
    }
    html.dark-mode .schedule-card-modern {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .schedule-card-modern:hover {
        border-color: #3f3f46 !important;
    }
    html.dark-mode .schedule-card-header {
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .schedule-card-footer {
        background: #141416 !important;
        border-top-color: #27272a !important;
    }
    html.dark-mode .schedule-time-badge {
        background: #27272a !important;
        border-color: #3f3f46 !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .badge-menunggu-jadwal {
        background: #27272a !important;
        color: #cbd5e1 !important;
        border-color: #3f3f46 !important;
    }
</style>

<div class="row">
    {{-- Header Section (Tanpa Filter, Bersih & Elegan) --}}
    <div class="col-12 mb-4">
        <div class="d-none d-md-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                    <i class="mdi mdi-border-color text-primary me-2"></i>Aktivitas Mengajar & Presensi Kelas
                </h4>
                <p class="card-subtitle card-subtitle-dash text-muted">Jadwal kegiatan mengajar Anda, input kehadiran siswa, serta akses cepat ke ruang materi dan tugas.</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="header-stat-badge text-nowrap">
                    <span class="text-muted small">Total:</span>
                    <strong class="text-primary ms-1" style="font-size: 0.95rem;">{{ count($jadwal) }}</strong>
                    <span class="text-muted small ms-1">Kelas Mengajar</span>
                </div>
            </div>
        </div>

        {{-- Mobile Header --}}
        <div class="d-md-none p-3 rounded-3 shadow-xs bg-white mb-2 d-flex justify-content-between align-items-center" style="border: 1px solid rgba(0,0,0,0.06);">
            <div>
                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">
                    <i class="mdi mdi-border-color text-primary me-2"></i>Aktivitas Mengajar
                </h4>
                <p class="text-muted small mb-0">Kelola jadwal mengajar dan absensi kelas.</p>
            </div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-bold">
                {{ count($jadwal) }} Kelas
            </span>
        </div>
    </div>

    {{-- Alert Sukses --}}
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

    {{-- Cards Grid Jadwal --}}
    @forelse ($jadwal as $j)
        @php
            $now = \Carbon\Carbon::now();
            $jamMulai = \Carbon\Carbon::createFromFormat('H:i', substr($j->jam_mulai, 0, 5));
            $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', substr($j->jam_selesai, 0, 5));

            $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $hariSekarang = $days[$now->dayOfWeek];
            $hariSesuai = strtolower($hariSekarang) === strtolower($j->hari);

            $isWaktuMengajar = $hariSesuai && $now->between($jamMulai, $jamSelesai);
            $sudahAbsen = \App\Models\Absensi::where('jadwal_id', $j->id)
                            ->whereDate('tanggal', date('Y-m-d'))
                            ->exists();

            $totalSiswa = \App\Models\Siswa::where('kelas_id', $j->kelas_id)->count();
            $hadirCount = $sudahAbsen ? \App\Models\Absensi::where('jadwal_id', $j->id)->whereDate('tanggal', date('Y-m-d'))->where('status', 'hadir')->count() : 0;
        @endphp

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="schedule-card-modern {{ $isWaktuMengajar ? 'is-active' : '' }}">
                {{-- Header Card --}}
                <div class="schedule-card-header">
                    <div>
                        @if($sudahAbsen)
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.72rem;">
                                <i class="mdi mdi-check-circle-outline me-1"></i> SELESAI ABSEN
                            </span>
                        @elseif($isWaktuMengajar)
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.72rem;">
                                <span class="pulse-dot"></span> SEDANG AKTIF
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-1.5 fw-bold badge-menunggu-jadwal" style="font-size: 0.72rem;">
                                <i class="mdi mdi-clock-outline me-1"></i> MENUNGGU JADWAL
                            </span>
                        @endif
                    </div>
                    <div class="schedule-time-badge">
                        <i class="mdi mdi-clock-time-four-outline me-1 text-primary"></i>
                        {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                    </div>
                </div>

                {{-- Body Card --}}
                <div class="schedule-card-body">
                    {{-- Kelas & Mapel --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">
                            {{ $j->kelas->nama_kelas ?? 'Kelas' }}
                        </h4>
                        <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem;">
                            {{ $totalSiswa }} Siswa
                        </span>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <div class="me-2 text-primary">
                            <i class="mdi mdi-book-open-page-variant fs-5"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block" style="font-size: 0.74rem;">Mata Pelajaran:</span>
                            <strong class="text-dark" style="font-size: 0.92rem;">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="me-2 text-muted">
                            <i class="mdi mdi-calendar-check fs-5"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block" style="font-size: 0.74rem;">Jadwal Mengajar:</span>
                            <span class="fw-semibold text-dark" style="font-size: 0.88rem;">Setiap Hari {{ $j->hari }}</span>
                        </div>
                    </div>

                    @if($sudahAbsen)
                        <div class="mt-3 pt-2 border-top">
                            <div class="d-flex justify-content-between align-items-center small text-muted">
                                <span>Status Kehadiran Hari Ini:</span>
                                <strong class="text-success">{{ $hadirCount }} / {{ $totalSiswa }} Hadir</strong>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Footer Action Buttons --}}
                <div class="schedule-card-footer">
                    {{-- Tombol Utama Presensi --}}
                    @if($sudahAbsen)
                        <a href="{{ route('guru.absen.kelas', $j->id) }}" class="btn btn-outline-primary w-100 rounded-pill py-2.5 fw-bold d-flex align-items-center justify-content-center gap-1.5 shadow-xs mb-2">
                            <i class="mdi mdi-clipboard-check-outline fs-5"></i>
                            <span>Lihat / Edit Presensi</span>
                        </a>
                    @else
                        <a href="{{ route('guru.absen.kelas', $j->id) }}" class="btn btn-primary text-white w-100 rounded-pill py-2.5 fw-bold d-flex align-items-center justify-content-center gap-1.5 shadow-xs mb-2" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                            <i class="mdi mdi-account-check-outline fs-5"></i>
                            <span>Buka Presensi Kelas</span>
                        </a>
                    @endif

                    {{-- Tombol Ruang Materi & Tugas --}}
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('guru.materi', $j->id) }}" class="btn-sub-action btn-sub-materi w-100">
                                <i class="mdi mdi-book-open-page-variant"></i>
                                <span>Materi</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('guru.tugas', $j->id) }}" class="btn-sub-action btn-sub-tugas w-100">
                                <i class="mdi mdi-file-document-edit-outline"></i>
                                <span>Tugas</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3" style="width: 80px; height: 80px; background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                <i class="mdi mdi-calendar-blank-outline display-5"></i>
            </div>
            <h5 class="text-dark fw-bold mb-1">Tidak Ada Jadwal Mengajar</h5>
            <p class="text-muted small">Belum ada jadwal mengajar yang ditentukan untuk akun Anda.</p>
        </div>
    @endforelse
</div>
@endsection
