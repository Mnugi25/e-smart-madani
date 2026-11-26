@extends('template.layouts.app')

@section('title', 'Rekap Nilai Ujian Siswa')

@section('content')
<style>
    /* Modern Back Button */
    .btn-back-modern {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-back-modern:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .btn-back-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    /* Stats Cards */
    .rekap-stat-card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        background: #ffffff !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.2s ease;
    }
    .rekap-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05) !important;
    }
    .rekap-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    /* Modern Table */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .modern-table thead th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-size: 0.78rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 14px 16px !important;
        border-top: none !important;
        border-bottom: 1.5px solid #e2e8f0 !important;
    }
    .modern-table tbody tr {
        transition: all 0.15s ease;
        border-bottom: 1px solid #f1f5f9;
        background: transparent;
    }
    .modern-table tbody tr:last-child {
        border-bottom: none;
    }
    .modern-table tbody tr:hover {
        background-color: #f8fafc !important;
    }
    .modern-table tbody td {
        padding: 14px 16px !important;
        border-top: none !important;
        vertical-align: middle;
    }

    /* Student Avatar Initial */
    .student-avatar-initial {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        flex-shrink: 0;
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-area, #printable-area * {
            visibility: visible;
        }
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: #ffffff !important;
            color: #000000 !important;
            padding: 20px !important;
        }
        .no-print {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .table-responsive {
            overflow: visible !important;
        }
        .badge {
            border: 1px solid #000 !important;
            background: transparent !important;
            color: #000 !important;
        }
    }

    /* Dark Mode Overrides */
    html.dark-mode .btn-back-modern {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .rekap-stat-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .modern-table thead th {
        background: #18181b !important;
        color: #a1a1aa !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .modern-table tbody tr {
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .modern-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
    html.dark-mode .modern-table tbody td {
        color: #e4e4e7 !important;
    }
    html.dark-mode .student-avatar-initial {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%) !important;
        color: #a5b4fc !important;
    }
</style>

{{-- Top Navigation & Print Trigger --}}
<div class="row mb-3 no-print">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="{{ route('guru.ujian.index') }}" class="btn-back-modern">
            <div class="btn-back-icon">
                <i class="mdi mdi-arrow-left"></i>
            </div>
            <span>Kembali ke Manajemen Ujian</span>
        </a>
        <button onclick="window.print();" class="btn btn-primary text-white rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center">
            <i class="mdi mdi-printer me-1.5 fs-5"></i> Cetak Rekap Nilai
        </button>
    </div>
</div>

{{-- Printable Area --}}
<div id="printable-area">
    {{-- Header Information Banner --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-rounded shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1.5 flex-wrap">
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                    Kelas {{ $ujian->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="badge bg-info-subtle text-info fw-bold rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                    {{ $ujian->mataPelajaran->nama_mapel ?? '-' }}
                                </span>
                                <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">
                                    Semester {{ $ujian->semester }}
                                </span>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">{{ $ujian->judul }}</h4>
                            <p class="text-muted small mb-0">
                                <i class="mdi mdi-account-tie-outline me-1"></i>Guru Pengampu: <strong>{{ Auth::user()->name ?? 'Guru' }}</strong> 
                                <span class="mx-1.5">•</span> 
                                <i class="mdi mdi-clock-outline me-1"></i>Tanggal Pelaksanaan: {{ $ujian->waktu_mulai->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $totalSiswa = $ujian->nilaiUjian->count();
        $avgScore = $totalSiswa > 0 ? $ujian->nilaiUjian->avg('nilai') : 0;
        $maxScore = $totalSiswa > 0 ? $ujian->nilaiUjian->max('nilai') : 0;
        $minScore = $totalSiswa > 0 ? $ujian->nilaiUjian->min('nilai') : 0;
        $lulusCount = $totalSiswa > 0 ? $ujian->nilaiUjian->where('nilai', '>=', 75)->count() : 0;
        $lulusPercent = $totalSiswa > 0 ? ($lulusCount / $totalSiswa) * 100 : 0;
    @endphp

    {{-- Stats Cards Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card rekap-stat-card h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rekap-stat-icon bg-primary-subtle text-primary me-3">
                        <i class="mdi mdi-account-group-outline"></i>
                    </div>
                    <div>
                        <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Peserta Selesai</span>
                        <h3 class="fw-bold mb-0 text-dark fs-4">{{ $totalSiswa }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card rekap-stat-card h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rekap-stat-icon bg-info-subtle text-info me-3">
                        <i class="mdi mdi-chart-line"></i>
                    </div>
                    <div>
                        <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Rata-rata Nilai</span>
                        <h3 class="fw-bold mb-0 text-dark fs-4">{{ round($avgScore, 1) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card rekap-stat-card h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rekap-stat-icon bg-success-subtle text-success me-3">
                        <i class="mdi mdi-trophy-outline"></i>
                    </div>
                    <div>
                        <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Nilai Tertinggi</span>
                        <h3 class="fw-bold mb-0 text-success fs-4">{{ round($maxScore, 1) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card rekap-stat-card h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rekap-stat-icon bg-warning-subtle text-warning me-3">
                        <i class="mdi mdi-check-decagram-outline"></i>
                    </div>
                    <div>
                        <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Kelulusan (KKM 75)</span>
                        <h3 class="fw-bold mb-0 text-dark fs-4">{{ round($lulusPercent) }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scores Table Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-rounded shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="mdi mdi-format-list-numbered text-primary me-2"></i>Daftar Nilai Siswa
                        </h5>
                        <span class="badge bg-light text-muted border px-2.5 py-1 small fw-semibold">
                            Total: {{ $totalSiswa }} Siswa
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="modern-table align-middle text-center">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">NO</th>
                                    <th class="text-center" style="width: 120px;">NISN</th>
                                    <th class="text-start">NAMA LENGKAP SISWA</th>
                                    <th class="text-center" style="width: 90px;">BENAR</th>
                                    <th class="text-center" style="width: 90px;">SALAH</th>
                                    <th class="text-center" style="width: 110px;">NILAI AKHIR</th>
                                    <th class="text-center" style="width: 120px;">STATUS</th>
                                    <th class="text-center" style="white-space: nowrap;">WAKTU SELESAI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ujian->nilaiUjian as $index => $n)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td class="text-center font-monospace small text-muted">{{ $n->siswa->nisn ?? '-' }}</td>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                <div class="student-avatar-initial me-3">
                                                    {{ strtoupper(substr($n->siswa->nama_lengkap ?? $n->siswa->nama ?? 'S', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong class="text-dark d-block">{{ $n->siswa->nama_lengkap ?? $n->siswa->nama ?? 'Siswa' }}</strong>
                                                    <small class="text-muted">Kelas {{ $ujian->kelas->nama_kelas ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-2.5 py-1">
                                                <i class="mdi mdi-check me-0.5"></i> {{ $n->total_benar }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill px-2.5 py-1">
                                                <i class="mdi mdi-close me-0.5"></i> {{ $n->total_salah }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $n->nilai >= 75 ? 'bg-success text-white' : 'bg-danger text-white' }} fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.92rem;">
                                                {{ round($n->nilai, 1) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($n->nilai >= 75)
                                                <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.75rem;">
                                                    <i class="mdi mdi-check-circle-outline me-1"></i> LULUS
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.75rem;">
                                                    <i class="mdi mdi-alert-circle-outline me-1"></i> REMEDIAL
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center text-muted text-nowrap" style="white-space: nowrap; font-size: 0.82rem;">
                                            <i class="mdi mdi-clock-outline me-1"></i>{{ $n->created_at->format('d/m/Y H:i') }} WIB
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-account-question-outline d-block mb-2 text-muted opacity-50" style="font-size: 2.8rem;"></i>
                                            <div class="fw-bold mb-1">Belum Ada Siswa Menyelesaikan Ujian</div>
                                            <small class="text-muted">Hasil nilai akan otomatis terangkum di sini saat siswa menyelesaikan pengerjaan ujian.</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
