@extends('template.layouts.app')

@section('title', 'Analisis Siswa (SAW)')

@section('content')
<style>
    .card-saw {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background: #ffffff;
    }
    .bg-gradient-saw {
        background: linear-gradient(135deg, #1E40AF, #030712);
        color: #ffffff;
    }
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 12px 20px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        background: transparent;
    }
    .nav-tabs .nav-link.active {
        color: #1F3BB3;
        border: none;
        border-bottom: 3px solid #1F3BB3;
        background: transparent;
    }
    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: #1F3BB3;
        background: transparent;
    }
    .tab-content {
        padding: 20px 0;
    }
    
    /* Dark Mode Overrides for SAW */
    html.dark-mode .card-saw {
        background: #18181b !important;
        border: 1px solid #27272a !important;
    }
    html.dark-mode .nav-tabs {
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .nav-tabs .nav-link {
        color: #a1a1aa;
        background: transparent !important;
    }
    html.dark-mode .nav-tabs .nav-link.active {
        color: #3b82f6;
        border-bottom: 3px solid #3b82f6 !important;
        background: transparent !important;
    }
    html.dark-mode .nav-tabs .nav-link:hover {
        color: #3b82f6;
    }
    html.dark-mode .table-saw th {
        background-color: #202024 !important;
        color: #e2e8f0 !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode select.form-select,
    html.dark-mode .form-select,
    html.dark-mode .border,
    html.dark-mode .border-bottom,
    html.dark-mode .border-top,
    html.dark-mode .border-start,
    html.dark-mode .border-end,
    html.dark-mode table,
    html.dark-mode th,
    html.dark-mode td,
    html.dark-mode .table-responsive,
    html.dark-mode .table-responsive-md {
        border-color: #27272a !important;
        border-top-color: #27272a !important;
        border-bottom-color: #27272a !important;
        border-left-color: #27272a !important;
        border-right-color: #27272a !important;
        --bs-table-border-color: #27272a !important;
        --bs-border-color: #27272a !important;
    }
    .table-saw th {
        background-color: #f8f9fa;
        color: #333333;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }
    .table-saw td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .badge-count {
        font-size: 0.75rem;
        padding: 5px 10px;
        font-weight: 600;
    }

    /* Scrollable Tabs Wrapper for Mobile */
    .nav-tabs-wrapper {
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
    }
    .nav-tabs-wrapper::-webkit-scrollbar {
        height: 5px;
    }
    .nav-tabs-wrapper::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.15);
        border-radius: 4px;
    }
    .nav-tabs-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }
    .nav-tabs {
        flex-wrap: nowrap;
        white-space: nowrap;
        border-bottom: 1px solid #dee2e6;
        width: 100%;
        display: inline-flex;
    }
    
    /* Table column constraints for readability on mobile */
    .table-saw th, .table-saw td {
        white-space: nowrap;
    }
    .table-saw td.text-start {
        white-space: normal;
        min-width: 150px;
    }

    /* Media query for mobile responsive scaling */
    @media (max-width: 767.98px) {
        .card-saw .card-body {
            padding: 1.25rem 1rem !important;
        }
        .bg-gradient-saw {
            padding: 1.25rem 1rem !important;
        }
        .bg-gradient-saw .mdi-scale-balance {
            font-size: 2.2rem !important;
            margin-right: 0.75rem !important;
        }
        .bg-gradient-saw h3 {
            font-size: 1.2rem !important;
        }
        .bg-gradient-saw p {
            font-size: 0.8rem !important;
        }
        .bg-gradient-saw .btn {
            width: 100%;
            margin-top: 0.5rem;
        }
        .nav-tabs .nav-link {
            padding: 8px 12px !important;
            font-size: 0.85rem !important;
        }
        .table-saw td, .table-saw th {
            font-size: 0.8rem !important;
            padding: 8px 6px !important;
        }
        .badge-count {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
    }

    @media (max-width: 575.98px) {
        .bg-gradient-saw .d-flex.align-items-center {
            align-items: flex-start !important;
            flex-direction: column;
        }
        .bg-gradient-saw .mdi-scale-balance {
            margin-bottom: 0.75rem;
            margin-right: 0 !important;
        }
    }

    /* Toggle between desktop table and mobile cards */
    .saw-desktop-view {
        display: block;
    }
    .saw-mobile-view {
        display: none;
    }

    @media (max-width: 767.98px) {
        .saw-desktop-view {
            display: none !important;
        }
        .saw-mobile-view {
            display: block !important;
        }
    }

    /* Custom badge for "Tidak" status in SAW */
    .badge-tidak-reward {
        background-color: #fee2e2 !important;
        color: #ef4444 !important;
        border: 1px solid #fca5a5 !important;
    }
    html.dark-mode .badge-tidak-reward {
        background-color: rgba(239, 68, 68, 0.15) !important;
        color: #fca5a5 !important;
        border: 1px solid rgba(239, 68, 68, 0.3) !important;
    }
</style>

<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="card bg-gradient-saw card-rounded shadow-sm">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-scale-balance text-warning me-3" style="font-size: 3rem;"></i>
                    <div>
                        <h3 class="fw-bold mb-1">Sistem Pendukung Keputusan (Metode SAW)</h3>
                        <p class="mb-0 text-white-50">
                            Analisis kedisiplinan siswa kelas perwalian <strong>{{ $kelasWali->nama_kelas }}</strong> pada <strong>Semester {{ ucfirst($semester) }} Tahun {{ $tahun }}</strong> untuk menentukan siswa terdisiplin. Jika siswa tersebut disiplin, maka dia akan mendapatkan reward berupa predikat Siswa Terdisiplin.
                        </p>
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <form action="{{ route('guru.saw.hitung') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="semester" value="{{ $semester }}">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4 py-2 shadow-sm">
                            <i class="mdi mdi-refresh me-1"></i> Perbarui Analisis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER SEMESTER & TAHUN --}}
    <div class="col-12 mb-4">
        <div class="card card-saw card-rounded">
            <div class="card-body p-3">
                <form action="{{ route('guru.saw.index') }}" method="GET" class="row align-items-center g-3">
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-calendar-range text-primary fs-4 me-2"></i>
                            <div class="flex-grow-1">
                                <label class="form-label fw-bold mb-1" style="font-size: 0.8rem; color: #4B6AD6;">Semester</label>
                                <select name="semester" class="form-select form-select-sm border" style="border-radius: 8px;">
                                    <option value="ganjil" {{ $semester == 'ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                                    <option value="genap" {{ $semester == 'genap' ? 'selected' : '' }}>Semester Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-calendar-clock text-primary fs-4 me-2"></i>
                            <div class="flex-grow-1">
                                <label class="form-label fw-bold mb-1" style="font-size: 0.8rem; color: #4B6AD6;">Tahun</label>
                                <select name="tahun" class="form-select form-select-sm border" style="border-radius: 8px;">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 3;
                                        $endYear = $currentYear + 2;
                                    @endphp
                                    @for($y = $startYear; $y <= $endYear; $y++)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 text-md-end text-center mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill fw-bold px-4 py-2 text-white shadow-xs">
                            <i class="mdi mdi-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 5px solid #28a745 !important;">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-check-circle text-success fs-3 me-2"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="col-12 mb-4">
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 5px solid #dc3545 !important;">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-alert-circle text-danger fs-3 me-2"></i>
                    <div>
                        <strong>Gagal!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- SAW TABLES TABS --}}
    <div class="col-lg-9 mb-4">
        <div class="card card-saw card-rounded">
            <div class="card-body p-4">
                <div class="nav-tabs-wrapper">
                    <ul class="nav nav-tabs border-bottom mb-3" id="sawTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ranking-tab" data-bs-toggle="tab" data-bs-target="#ranking" type="button" role="tab" aria-controls="ranking" aria-selected="true">
                                <i class="mdi mdi-trophy-award me-1"></i> Hasil Perankingan (V)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="matrix-x-tab" data-bs-toggle="tab" data-bs-target="#matrix-x" type="button" role="tab" aria-controls="matrix-x" aria-selected="false">
                                <i class="mdi mdi-matrix me-1"></i> Matriks Keputusan (X)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="matrix-r-tab" data-bs-toggle="tab" data-bs-target="#matrix-r" type="button" role="tab" aria-controls="matrix-r" aria-selected="false">
                                <i class="mdi mdi-playlist-check me-1"></i> Matriks Normalisasi (R)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="criteria-tab" data-bs-toggle="tab" data-bs-target="#criteria" type="button" role="tab" aria-controls="criteria" aria-selected="false">
                                <i class="mdi mdi-settings me-1"></i> Kriteria & Bobot
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="sawTabContent">
                    {{-- TAB 1: RANKINGS --}}
                    <div class="tab-pane fade show active" id="ranking" role="tabpanel" aria-labelledby="ranking-tab">
                        @php
                            $maxScore = count($rankings) > 0 ? $rankings[0]['skor_v'] : 0;
                            $allScores = collect($rankings)->pluck('skor_v')->unique();
                            $isTiedAll = $allScores->count() <= 1;
                        @endphp
                        {{-- Desktop View --}}
                        <div class="table-responsive saw-desktop-view">
                            <table class="table table-hover table-saw text-center align-middle">
                                <thead>
                                    <tr>
                                        <th width="7%">Rank</th>
                                        <th class="text-start" width="20%">Nama Siswa</th>
                                        <th width="40%">Detail Kriteria</th>
                                        <th width="13%">Skor Akhir (V)</th>
                                        <th width="20%">Status Keputusan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rankings as $index => $item)
                                        @php 
                                            $rank = $index + 1; 
                                            $isMax = ($item['skor_v'] == $maxScore && $maxScore > 0 && !$isTiedAll && !($item['counts']['tugas_dikumpul'] == 0 && $item['counts']['c2_score'] == 0 && $item['counts']['terlambat'] == 0));
                                        @endphp
                                        <tr class="{{ $isMax ? 'table-success' : '' }}" style="{{ $isMax ? '--bs-table-bg: rgba(40, 167, 69, 0.06);' : '' }}">
                                            <td>
                                                @if($isMax)
                                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="mdi mdi-star"></i> 1</span>
                                                @else
                                                    <span class="badge bg-light text-dark fw-bold px-2 py-1">{{ $rank }}</span>
                                                @endif
                                            </td>
                                            <td class="text-start">
                                                <div class="fw-bold text-dark">{{ $item['siswa']->nama_lengkap }}</div>
                                                <small class="text-muted">NISN: {{ $item['siswa']->nisn }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <span class="badge bg-success rounded-pill badge-count text-white" title="Tugas Dikumpul">Pengumpulan Tugas: {{ $item['counts']['tugas_dikumpul'] }}/{{ $item['counts']['total_tugas'] }}</span>
                                                    <span class="badge bg-info rounded-pill badge-count text-white" title="Akumulasi Kehadiran (Hadir=1.0, Izin/Sakit=0.8, Alpa=0)">Kehadiran: {{ number_format($item['counts']['c2_score'], 1) }}</span>
                                                    <span class="badge bg-warning rounded-pill badge-count text-dark" title="Terlambat">Terlambat: {{ $item['counts']['terlambat'] }}</span>
                                                </div>
                                            </td>
                                            <td class="fw-bold {{ $isMax ? 'text-success fs-5' : 'text-primary' }}">
                                                {{ number_format($item['skor_v'], 4) }}
                                            </td>
                                            <td>
                                                @if($isMax)
                                                    <div class="d-flex flex-column align-items-center gap-1">
                                                        <span class="badge bg-success rounded-pill px-3 py-1 text-white fw-bold">Mendapatkan Reward</span>
                                                        <form action="{{ route('guru.saw.rilis') }}" method="POST" class="d-inline mt-1">
                                                            @csrf
                                                            <input type="hidden" name="siswa_id" value="{{ $item['siswa']->id }}">
                                                            <input type="hidden" name="skor" value="{{ $item['skor_v'] }}">
                                                            <button type="submit" class="btn btn-xs btn-primary rounded-pill px-2.5 py-1 text-white shadow-xs fw-bold" style="font-size: 0.72rem;" title="Rilis Siswa Terdisiplin ke Dashboard Sekolah">
                                                                <i class="mdi mdi-bullhorn-outline me-1"></i> Rilis Juara
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-muted">
                                                <i class="mdi mdi-calculator-off d-block fs-1 mb-2"></i>
                                                Belum ada data siswa/absensi untuk dilakukan perankingan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Card List View --}}
                        <div class="saw-mobile-view">
                            @forelse($rankings as $index => $item)
                                @php 
                                    $rank = $index + 1; 
                                    $isMax = ($item['skor_v'] == $maxScore && $maxScore > 0 && !$isTiedAll && !($item['counts']['tugas_dikumpul'] == 0 && $item['counts']['c2_score'] == 0 && $item['counts']['terlambat'] == 0));
                                @endphp
                                <div class="card border rounded-8 mb-3 shadow-xs {{ $isMax ? 'border-success' : '' }}" style="{{ $isMax ? 'background: rgba(40, 167, 69, 0.03);' : '' }}">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                @if($isMax)
                                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="mdi mdi-star"></i> Rank 1</span>
                                                @else
                                                    <span class="badge bg-light text-dark fw-bold px-2 py-1">Rank {{ $rank }}</span>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <span class="text-muted small" style="font-size: 0.75rem;">Skor V:</span>
                                                <span class="fw-bold {{ $isMax ? 'text-success' : 'text-primary' }} d-block" style="font-size: 0.95rem;">{{ number_format($item['skor_v'], 4) }}</span>
                                            </div>
                                        </div>
                                        
                                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">{{ $item['siswa']->nama_lengkap }}</h6>
                                        <div class="text-muted small mb-2" style="font-size: 0.75rem;">NISN: {{ $item['siswa']->nisn }}</div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3 mt-2 pt-2 border-top">
                                            <span class="text-muted small" style="font-size: 0.75rem;">Status Keputusan:</span>
                                            @if($isMax)
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-success rounded-pill px-2.5 py-1 text-white fw-bold" style="font-size: 0.72rem;">Mendapatkan Reward</span>
                                                    <form action="{{ route('guru.saw.rilis') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="siswa_id" value="{{ $item['siswa']->id }}">
                                                        <input type="hidden" name="skor" value="{{ $item['skor_v'] }}">
                                                        <button type="submit" class="btn btn-xs btn-primary rounded-pill px-2 py-1 text-white shadow-xs fw-bold" style="font-size: 0.7rem;">
                                                            <i class="mdi mdi-bullhorn-outline"></i> Rilis
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </div>
                                        
                                        <div class="mt-2 pt-2 border-top">
                                            <div class="small text-muted mb-1" style="font-size: 0.75rem;">Detail Kriteria:</div>
                                            <div class="d-flex gap-1 flex-wrap">
                                                <span class="badge bg-success rounded-pill badge-count text-white" title="Tugas Dikumpul">Pengumpulan Tugas: {{ $item['counts']['tugas_dikumpul'] }}/{{ $item['counts']['total_tugas'] }}</span>
                                                <span class="badge bg-info rounded-pill badge-count text-white" title="Akumulasi Kehadiran (Hadir=1.0, Izin/Sakit=0.8, Alpa=0)">Kehadiran: {{ number_format($item['counts']['c2_score'], 1) }}</span>
                                                <span class="badge bg-warning rounded-pill badge-count text-dark" title="Terlambat">Terlambat: {{ $item['counts']['terlambat'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted small">
                                    <i class="mdi mdi-calculator-off d-block fs-1 mb-2"></i>
                                    Belum ada data siswa/absensi untuk dilakukan perankingan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- TAB 2: MATRIKS KEPUTUSAN (X) --}}
                    <div class="tab-pane fade" id="matrix-x" role="tabpanel" aria-labelledby="matrix-x-tab">
                        <div class="alert alert-info py-2 px-3 border-0 rounded mb-3 small">
                            <i class="mdi mdi-information-outline"></i> Menampilkan nilai persentase masing-masing status kehadiran siswa terhadap total hari presensi.
                        </div>
                        
                        {{-- Desktop View --}}
                        <div class="table-responsive saw-desktop-view">
                            <table class="table table-bordered table-hover table-saw text-center align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-start" width="40%">Nama Siswa</th>
                                        <th>C1 (Pengumpulan Tugas)</th>
                                        <th>C2 (Kehadiran)</th>
                                        <th>C3 (Keterlambatan)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rankings as $item)
                                        <tr>
                                            <td class="text-start">
                                                <div class="fw-bold text-dark">{{ $item['siswa']->nama_lengkap }}</div>
                                            </td>
                                            <td>{{ number_format($item['raw']['c1'] * 100, 1) }}%</td>
                                            <td>{{ number_format($item['raw']['c2'] * 100, 1) }}%</td>
                                            <td>{{ number_format($item['raw']['c3'] * 100, 1) }}%</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-muted">Belum ada data matriks keputusan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Card List View --}}
                        <div class="saw-mobile-view">
                            @forelse($rankings as $item)
                                <div class="card border rounded-8 mb-2 shadow-xs">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.9rem;">{{ $item['siswa']->nama_lengkap }}</h6>
                                        <div class="row text-center g-2">
                                            <div class="col-4">
                                                <div class="text-muted small" style="font-size: 0.65rem;">C1 (Pengumpulan Tugas)</div>
                                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ number_format($item['raw']['c1'] * 100, 1) }}%</div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-muted small" style="font-size: 0.65rem;">C2 (Kehadiran)</div>
                                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ number_format($item['raw']['c2'] * 100, 1) }}%</div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-muted small" style="font-size: 0.65rem;">C3 (Keterlambatan)</div>
                                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ number_format($item['raw']['c3'] * 100, 1) }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted small">Belum ada data matriks keputusan.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- TAB 3: MATRIKS NORMALISASI (R) --}}
                    <div class="tab-pane fade" id="matrix-r" role="tabpanel" aria-labelledby="matrix-r-tab">
                        <div class="alert alert-info py-2 px-3 border-0 rounded mb-3 small">
                            <i class="mdi mdi-information-outline"></i> Normalisasi kriteria <strong>Benefit (C1, C2)</strong> dihitung dengan <code>nilai / max(nilai)</code>. Kriteria <strong>Cost (C3)</strong> dihitung dengan formula <code>1 - (nilai / max(nilai))</code> untuk menghindari pembagian dengan nol ketika nilai minimum bernilai 0.
                        </div>
                        
                        {{-- Desktop View --}}
                        <div class="table-responsive saw-desktop-view">
                            <table class="table table-bordered table-hover table-saw text-center align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-start" width="40%">Nama Siswa</th>
                                        <th>R1 (Pengumpulan Tugas)</th>
                                        <th>R2 (Kehadiran)</th>
                                        <th>R3 (Keterlambatan)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rankings as $item)
                                        <tr>
                                            <td class="text-start">
                                                <div class="fw-bold text-dark">{{ $item['siswa']->nama_lengkap }}</div>
                                            </td>
                                            <td class="fw-bold text-success">{{ number_format($item['normalized']['r1'], 4) }}</td>
                                            <td class="fw-bold text-success">{{ number_format($item['normalized']['r2'], 4) }}</td>
                                            <td class="fw-bold text-primary">{{ number_format($item['normalized']['r3'], 4) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-muted">Belum ada data normalisasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="table-light font-weight-bold">
                                        <td class="text-start fw-bold">Nilai Pembagi Max (Max X)</td>
                                        <td class="fw-bold text-dark">{{ number_format($maxC1, 4) }}</td>
                                        <td class="fw-bold text-dark">{{ number_format($maxC2, 4) }}</td>
                                        <td class="fw-bold text-dark">{{ number_format($maxC3, 4) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Mobile Card List View --}}
                        <div class="saw-mobile-view">
                            @forelse($rankings as $item)
                                <div class="card border rounded-8 mb-2 shadow-xs">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.9rem;">{{ $item['siswa']->nama_lengkap }}</h6>
                                        <div class="row text-center g-2">
                                            <div class="col-4">
                                                <div class="text-muted small" style="font-size: 0.65rem;">R1 (Pengumpulan Tugas)</div>
                                                <div class="fw-bold text-success" style="font-size: 0.85rem;">{{ number_format($item['normalized']['r1'], 4) }}</div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-muted small" style="font-size: 0.65rem;">R2 (Kehadiran)</div>
                                                <div class="fw-bold text-success" style="font-size: 0.85rem;">{{ number_format($item['normalized']['r2'], 4) }}</div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-muted small" style="font-size: 0.65rem;">R3 (Keterlambatan)</div>
                                                <div class="fw-bold text-primary" style="font-size: 0.85rem;">{{ number_format($item['normalized']['r3'], 4) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted small">Belum ada data normalisasi.</div>
                            @endforelse

                            <div class="card bg-light border rounded-8 mt-3 shadow-xs">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;">Nilai Pembagi Max (Max X):</h6>
                                    <div class="row text-center g-2">
                                        <div class="col-4">
                                            <div class="text-muted small" style="font-size: 0.65rem;">Max C1</div>
                                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ number_format($maxC1, 4) }}</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-muted small" style="font-size: 0.65rem;">Max C2</div>
                                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ number_format($maxC2, 4) }}</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-muted small" style="font-size: 0.65rem;">Max C3</div>
                                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ number_format($maxC3, 4) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 4: CRITERIA DEFINITIONS --}}
                    <div class="tab-pane fade" id="criteria" role="tabpanel" aria-labelledby="criteria-tab">
                        <div class="alert alert-success py-2 px-3 border-0 rounded mb-3 small" style="border-left: 4px solid #28a745 !important;">
                            <i class="mdi mdi-check-circle-outline"></i> <strong>Catatan Kedisiplinan:</strong> Jika siswa tersebut disiplin (memiliki persentase kehadiran tinggi dan minim ketidakhadiran), maka dia akan mendapatkan reward berupa predikat Siswa Terdisiplin dengan nilai preferensi/skor akhir (V) yang optimal.
                        </div>
                        {{-- Desktop View --}}
                        <div class="table-responsive saw-desktop-view">
                            <table class="table table-bordered table-hover table-saw text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="10%">No</th>
                                        <th class="text-start" width="45%">Kriteria</th>
                                        <th width="15%">Kode</th>
                                        <th width="15%">Bobot</th>
                                        <th width="15%">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="text-start fw-bold">Pengumpulan Tugas</td>
                                        <td>C1</td>
                                        <td class="fw-bold text-dark">50%</td>
                                        <td><span class="badge bg-success rounded-pill px-3">Benefit</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td class="text-start fw-bold">
                                            Kehadiran
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.75rem; line-height: 1.3;">
                                                (Poin: Hadir = 1.0, Izin/Sakit = 0.8, Alpa = 0)
                                            </div>
                                        </td>
                                        <td>C2</td>
                                        <td class="fw-bold text-dark">20%</td>
                                        <td><span class="badge bg-success rounded-pill px-3">Benefit</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td class="text-start fw-bold">Keterlambatan</td>
                                        <td>C3</td>
                                        <td class="fw-bold text-dark">30%</td>
                                        <td><span class="badge bg-danger rounded-pill px-3">Cost</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Card List View --}}
                        <div class="saw-mobile-view">
                            <div class="card border rounded-8 mb-2 shadow-xs">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">C1: Pengumpulan Tugas</h6>
                                        <span class="badge bg-success rounded-pill px-2">Benefit</span>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted small" style="font-size: 0.75rem;">
                                        <span>Kode: C1</span>
                                        <span>Bobot: 50%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card border rounded-8 mb-2 shadow-xs">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">C2: Kehadiran</h6>
                                        <span class="badge bg-success rounded-pill px-2">Benefit</span>
                                    </div>
                                    <div class="text-muted mb-2" style="font-size: 0.7rem; line-height: 1.3;">
                                        Poin: Hadir = 1.0, Izin/Sakit = 0.8, Alpa = 0
                                    </div>
                                    <div class="d-flex justify-content-between text-muted small" style="font-size: 0.75rem;">
                                        <span>Kode: C2</span>
                                        <span>Bobot: 20%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card border rounded-8 mb-2 shadow-xs">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">C3: Keterlambatan</h6>
                                        <span class="badge bg-danger rounded-pill px-2">Cost</span>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted small" style="font-size: 0.75rem;">
                                        <span>Kode: C3</span>
                                        <span>Bobot: 30%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SIDEBAR: SISWA TIDAK DISIPLIN (AT RISK) --}}
    <div class="col-lg-3 mb-4">
        <div class="card card-saw card-rounded">
            <div class="card-body p-4">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="mdi mdi-alert-circle me-1"></i> Siswa Tidak Disiplin
                </h5>
                <p class="text-muted small">
                    Daftar siswa di kelas perwalian Anda yang memiliki jumlah ketidakhadiran (Alpa) lebih dari 12 kali.
                </p>
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-start">Nama Siswa</th>
                                <th width="25%">Alpa</th>
                                <th width="25%">Surat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($atRisk as $item)
                                <tr>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark">{{ $item->nama_lengkap }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger rounded-pill text-white">{{ $item->absensi_count }}x</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.absen.surat', $item->id) }}" class="btn btn-xs btn-outline-danger rounded-pill" title="Unduh Surat Panggilan Wali Murid">
                                            <i class="mdi mdi-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-muted small">
                                        <i class="mdi mdi-check-decagram text-success d-block fs-2 mb-1"></i>
                                        Tidak ada siswa dalam kategori ini (Semua tertib).
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
@endsection
