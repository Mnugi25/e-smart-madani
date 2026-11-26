@extends('template.layouts.app')

@section('title', 'Rekap Absensi Siswa')

@section('content')
<style>
    /* Filter Bar Styles */
    .filter-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .filter-icon-box {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-radius: 10px;
    }
    .custom-filter-select {
        height: 38px !important;
        border-radius: 10px !important;
        border: 1.5px solid #cbd5e1 !important;
        font-size: 0.88rem !important;
        font-weight: 500 !important;
        color: #1e293b !important;
        padding: 6px 36px 6px 14px !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease;
    }
    .custom-filter-select:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
    }
    .btn-filter-action {
        height: 38px;
        padding: 0 18px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-filter-action:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
    }
    .filter-stat-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
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

    /* Avatar Initial */
    .avatar-initial {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Mobile Card */
    .rekap-card-mobile {
        background-color: #ffffff;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        padding: 16px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03) !important;
        transition: transform 0.2s ease;
    }
    .stat-mini-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Dark Mode Overrides */
    html.dark-mode .filter-card {
        background: linear-gradient(135deg, #18181b 0%, #1f1f23 100%) !important;
        border-color: #27272a !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark-mode .filter-icon-box {
        background: rgba(59, 130, 246, 0.18) !important;
        color: #60a5fa !important;
    }
    html.dark-mode .custom-filter-select {
        background-color: #121215 !important;
        border-color: #3f3f46 !important;
        color: #f4f4f5 !important;
    }
    html.dark-mode .filter-stat-badge {
        background: #18181b !important;
        border-color: #2e2e34 !important;
    }
    html.dark-mode .filter-stat-badge .text-muted {
        color: #a1a1aa !important;
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
    html.dark-mode .avatar-initial {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%) !important;
        color: #a5b4fc !important;
    }
    html.dark-mode .rekap-card-mobile {
        background-color: #18181b !important;
        border-color: #27272a !important;
    }
</style>

<div class="row">
    {{-- Header Section --}}
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                    <i class="mdi mdi-chart-bar text-primary me-2"></i>Rekapitulasi Absensi Siswa
                </h4>
                <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                    Laporan kehadiran bulanan siswa per kelas dan mata pelajaran yang Anda ampu.
                    @if($jadwalAktif)
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-0.5 ms-1 fw-bold">
                            {{ $jadwalAktif->kelas->nama_kelas }} • {{ $jadwalAktif->mataPelajaran->nama_mapel }}
                        </span>
                    @endif
                </p>
            </div>

            {{-- Tombol Export Excel & PDF --}}
            @if($jadwalAktif)
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('guru.rekap.export', ['jadwal_id' => $jadwalAktif->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
                       class="btn btn-success text-white fw-bold rounded-pill px-3.5 py-2 d-inline-flex align-items-center shadow-xs" 
                       style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                        <i class="mdi mdi-file-excel me-1.5"></i> Export Excel
                    </a>
                    <a href="{{ route('guru.rekap.pdf', ['jadwal_id' => $jadwalAktif->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
                       class="btn btn-danger text-white fw-bold rounded-pill px-3.5 py-2 d-inline-flex align-items-center shadow-xs" 
                       style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none;" target="_blank">
                        <i class="mdi mdi-file-pdf-box me-1.5"></i> Cetak / PDF
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Main Container Card --}}
    <div class="col-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">

                {{-- Filter Bar --}}
                <div class="filter-card mb-4">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <form action="{{ route('guru.rekap') }}" method="GET" class="d-flex align-items-center gap-2 m-0 flex-wrap flex-md-nowrap">
                            <div class="d-flex align-items-center me-1 text-nowrap">
                                <div class="filter-icon-box me-2">
                                    <i class="mdi mdi-filter-variant fs-5"></i>
                                </div>
                                <span class="fw-bold text-dark small">Filter Rekap:</span>
                            </div>

                            {{-- Dropdown Kelas & Mapel --}}
                            <div style="min-width: 220px;">
                                <select name="jadwal_id" class="form-select custom-filter-select" required>
                                    <option value="" disabled {{ !$jadwalAktif ? 'selected' : '' }}>-- Pilih Kelas & Mapel --</option>
                                    @foreach($daftarJadwal as $dj)
                                        <option value="{{ $dj->id }}" {{ (isset($jadwalAktif) && $jadwalAktif->id == $dj->id) ? 'selected' : '' }}>
                                            {{ $dj->kelas->nama_kelas }} - {{ $dj->mataPelajaran->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Bulan --}}
                            @php
                                $namaBulan = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                            @endphp
                            <div style="width: 145px;">
                                <select name="bulan" class="form-select custom-filter-select">
                                    @foreach($namaBulan as $num => $nama)
                                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Tahun --}}
                            <div style="width: 110px;">
                                <select name="tahun" class="form-select custom-filter-select">
                                    @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <button type="submit" class="btn btn-filter-action text-nowrap">
                                <i class="mdi mdi-filter"></i> Tampilkan
                            </button>
                        </form>

                        {{-- Total Siswa Counter Badge (Pinned Right) --}}
                        <div class="d-flex align-items-center ms-auto">
                            <div class="filter-stat-badge text-nowrap">
                                <span class="text-muted small">Total:</span>
                                <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ count($rekapSiswa) }}</strong>
                                <span class="text-muted small ms-1">Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($jadwalAktif)
                    {{-- 1. Desktop Table View --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="modern-table align-middle text-center">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">NO</th>
                                    <th class="text-start">NAMA LENGKAP SISWA</th>
                                    <th class="text-center" style="width: 100px;">HADIR</th>
                                    @if($showTerlambat)
                                        <th class="text-center" style="width: 110px;">TERLAMBAT</th>
                                    @endif
                                    <th class="text-center" style="width: 100px;">IZIN</th>
                                    <th class="text-center" style="width: 100px;">SAKIT</th>
                                    <th class="text-center" style="width: 100px;">ALPA</th>
                                    <th class="text-center" style="width: 160px;">KEHADIRAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rekapSiswa as $index => $siswa)
                                    @php
                                        $total = ($siswa['c1'] ?? 0) + ($showTerlambat ? ($siswa['terlambat'] ?? 0) : 0) + ($siswa['c2'] ?? 0) + ($siswa['c3'] ?? 0) + ($siswa['c4'] ?? 0);
                                        $persenHadir = $total > 0 ? round(((($siswa['c1'] ?? 0) + ($showTerlambat ? ($siswa['terlambat'] ?? 0) : 0)) / $total) * 100) : 0;
                                        
                                        if ($persenHadir >= 90) {
                                            $barColor = 'bg-success';
                                            $textColor = 'text-success';
                                        } elseif ($persenHadir >= 75) {
                                            $barColor = 'bg-info';
                                            $textColor = 'text-info';
                                        } elseif ($persenHadir >= 50) {
                                            $barColor = 'bg-warning';
                                            $textColor = 'text-warning';
                                        } else {
                                            $barColor = 'bg-danger';
                                            $textColor = 'text-danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-initial me-3">
                                                    {{ strtoupper(substr($siswa['nama'], 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong class="text-dark d-block">{{ $siswa['nama'] }}</strong>
                                                    <small class="text-muted"><i class="mdi mdi-card-account-details-outline me-1"></i>NISN: {{ $siswa['nisn'] ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                                {{ $siswa['c1'] ?? 0 }} Hari
                                            </span>
                                        </td>
                                        @if($showTerlambat)
                                            <td class="text-center">
                                                <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background-color: rgba(253, 126, 20, 0.12); color: #ea580c; font-size: 0.78rem;">
                                                    {{ $siswa['terlambat'] ?? 0 }} Hari
                                                </span>
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                                {{ $siswa['c2'] ?? 0 }} Hari
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info-subtle text-info fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                                {{ $siswa['c3'] ?? 0 }} Hari
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                                {{ $siswa['c4'] ?? 0 }} Hari
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex justify-content-between w-100 mb-1" style="max-width: 130px;">
                                                    <span class="small text-muted" style="font-size: 0.72rem;">Hadir:</span>
                                                    <strong class="{{ $textColor }}" style="font-size: 0.78rem;">{{ $persenHadir }}%</strong>
                                                </div>
                                                <div class="progress rounded-pill bg-light w-100" style="height: 6px; max-width: 130px;">
                                                    <div class="progress-bar {{ $barColor }} rounded-pill" role="progressbar" style="width: {{ $persenHadir }}%" aria-valuenow="{{ $persenHadir }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $showTerlambat ? 8 : 7 }}" class="text-center text-muted py-5">
                                            <i class="mdi mdi-account-off-outline d-block mb-2 fs-2 opacity-50"></i>
                                            <div class="fw-bold mb-1">Belum Ada Data Presensi</div>
                                            <small class="text-muted">Tidak ditemukan catatan kehadiran untuk kelas dan periode yang dipilih.</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- 2. Mobile View Cards --}}
                    <div class="d-md-none">
                        @forelse ($rekapSiswa as $index => $siswa)
                            @php
                                $total = ($siswa['c1'] ?? 0) + ($showTerlambat ? ($siswa['terlambat'] ?? 0) : 0) + ($siswa['c2'] ?? 0) + ($siswa['c3'] ?? 0) + ($siswa['c4'] ?? 0);
                                $persenHadir = $total > 0 ? round(((($siswa['c1'] ?? 0) + ($showTerlambat ? ($siswa['terlambat'] ?? 0) : 0)) / $total) * 100) : 0;
                                
                                if ($persenHadir >= 90) {
                                    $barColor = 'bg-success';
                                    $textColor = 'text-success';
                                } elseif ($persenHadir >= 75) {
                                    $barColor = 'bg-info';
                                    $textColor = 'text-info';
                                } elseif ($persenHadir >= 50) {
                                    $barColor = 'bg-warning';
                                    $textColor = 'text-warning';
                                } else {
                                    $barColor = 'bg-danger';
                                    $textColor = 'text-danger';
                                }
                            @endphp
                            <div class="card rekap-card-mobile mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial me-2.5" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="overflow-hidden text-start">
                                            <strong class="text-dark d-block text-truncate" style="max-width: 170px; font-size: 0.95rem;">
                                                {{ $siswa['nama'] }}
                                            </strong>
                                            <small class="text-muted" style="font-size: 0.74rem;">NISN: {{ $siswa['nisn'] ?? '-' }}</small>
                                        </div>
                                    </div>
                                    <span class="badge {{ $barColor }} text-white rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem;">
                                        {{ $persenHadir }}% Hadir
                                    </span>
                                </div>

                                {{-- Progress Bar --}}
                                <div class="progress rounded-pill bg-light my-2" style="height: 6px;">
                                    <div class="progress-bar {{ $barColor }} rounded-pill" role="progressbar" style="width: {{ $persenHadir }}%"></div>
                                </div>

                                {{-- Stat Pills Breakdown --}}
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top flex-wrap gap-1">
                                    <span class="stat-mini-pill bg-success-subtle text-success">
                                        <i class="mdi mdi-check"></i> {{ $siswa['c1'] ?? 0 }} H
                                    </span>
                                    @if($showTerlambat)
                                        <span class="stat-mini-pill" style="background-color: rgba(253, 126, 20, 0.12); color: #ea580c;">
                                            <i class="mdi mdi-clock-outline"></i> {{ $siswa['terlambat'] ?? 0 }} T
                                        </span>
                                    @endif
                                    <span class="stat-mini-pill bg-warning-subtle text-warning">
                                        <i class="mdi mdi-information-outline"></i> {{ $siswa['c2'] ?? 0 }} I
                                    </span>
                                    <span class="stat-mini-pill bg-info-subtle text-info">
                                        <i class="mdi mdi-medical-bag"></i> {{ $siswa['c3'] ?? 0 }} S
                                    </span>
                                    <span class="stat-mini-pill bg-danger-subtle text-danger">
                                        <i class="mdi mdi-close"></i> {{ $siswa['c4'] ?? 0 }} A
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted card bg-light border-0 rounded-3">
                                <i class="mdi mdi-account-off-outline fs-2 text-muted opacity-50 mb-1"></i>
                                <span class="small">Belum ada data presensi untuk periode ini.</span>
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3" style="width: 80px; height: 80px; background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                            <i class="mdi mdi-clipboard-text-search-outline display-5"></i>
                        </div>
                        <h5 class="text-dark fw-bold mb-1">Pilih Kelas untuk Melihat Rekapitulasi</h5>
                        <p class="text-muted small">Pilih kelas dan mata pelajaran pada filter di atas untuk menampilkan rincian presensi bulanan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
