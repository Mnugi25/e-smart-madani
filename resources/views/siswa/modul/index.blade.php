@extends('template.layouts.app')

@section('title', 'Modul Pembelajaran')

@section('content')
<style>
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
    .filter-stat-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    /* Dark Mode Theme Support */
    html.dark-mode .modern-table {
        background-color: transparent !important;
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
    html.dark-mode .mobile-modul-card {
        background-color: #18181b !important;
        border-color: #27272a !important;
    }
</style>

<div class="row">
    {{-- Mobile Header (Outside Card) --}}
    <div class="col-12 d-md-none mt-2 mb-3">
        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-xs header-mobile-box" style="border: 1px solid rgba(0,0,0,0.06); background: #ffffff;">
            <div class="pe-2">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">
                    <i class="mdi mdi-book-multiple text-primary me-2"></i>Modul
                </h4>
                <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.2;">
                    Bahan ajar dan materi belajar dari guru.
                </p>
            </div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-bold text-nowrap">
                {{ count($moduls) }} Modul
            </span>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body p-4">
                {{-- Desktop Header --}}
                <div class="d-none d-md-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                            <i class="mdi mdi-book-multiple text-primary me-2"></i>Modul Pembelajaran
                        </h4>
                        <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                            Daftar materi pembelajaran dan dokumen e-modul resmi dari guru kelas Anda.
                        </p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Total:</span>
                            <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ count($moduls) }}</strong>
                            <span class="text-muted small ms-1">Modul</span>
                        </div>
                    </div>
                </div>

                {{-- Alert Feedback --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-check-circle me-2 fs-5"></i>
                            <div><strong>Sukses!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-close-circle me-2 fs-5"></i>
                            <div><strong>Error!</strong> {{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Desktop View Table --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 55px;" class="text-center">NO</th>
                                <th class="text-start">JUDUL MODUL</th>
                                <th class="text-center" style="width: 200px;">MATA PELAJARAN</th>
                                <th class="text-start" style="width: 220px;">GURU PENGAMPU</th>
                                <th class="text-center text-nowrap" style="width: 150px; white-space: nowrap;">TANGGAL DIUNGGAH</th>
                                <th style="width: 140px;" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($moduls as $modul)
                                @php
                                    $rawTeacherName = trim($modul->guru->nama_lengkap ?? $modul->guru->nama_guru ?? $modul->guru->nama ?? 'Guru');
                                    $cleanTeacherName = preg_replace('/,\s*.*$/', '', $rawTeacherName);
                                    $displayTeacherName = ucwords(strtolower($cleanTeacherName));

                                    $words = array_values(array_filter(explode(' ', trim($displayTeacherName))));
                                    $initials = '';
                                    if (count($words) >= 2) {
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } elseif (count($words) == 1) {
                                        $initials = strtoupper(substr($words[0], 0, 2));
                                    } else {
                                        $initials = 'GR';
                                    }
                                    $palette = [
                                        'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
                                        'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
                                        'linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)',
                                        'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                                        'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                                    ];
                                    $bgGradient = $palette[abs(crc32($rawTeacherName)) % count($palette)];
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                    
                                    {{-- Kolom Judul & Deskripsi --}}
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 p-2 bg-primary-subtle text-primary me-2.5 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                                <i class="mdi mdi-file-document-outline fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block" style="font-size: 0.92rem; line-height: 1.3;">{{ $modul->judul }}</strong>
                                                @if(!empty($modul->deskripsi))
                                                    <small class="text-muted d-block mt-0.5" style="font-size: 0.76rem;">{{ Str::limit($modul->deskripsi, 65) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Mata Pelajaran --}}
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.76rem;">
                                            {{ $modul->mataPelajaran->nama_mapel ?? 'Umum' }}
                                        </span>
                                    </td>

                                    {{-- Kolom Guru Pengampu --}}
                                    <td class="text-start">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs flex-shrink-0" 
                                                 style="width: 32px; height: 32px; background: {{ $bgGradient }}; font-size: 0.72rem; letter-spacing: 0.5px;">
                                                {{ $initials }}
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                                                {{ $displayTeacherName }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kolom Tanggal --}}
                                    <td class="text-center text-muted text-nowrap" style="white-space: nowrap; font-size: 0.82rem;">
                                        <i class="mdi mdi-calendar-blank-outline me-1"></i>{{ $modul->created_at->format('d M Y') }}
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="text-center">
                                        <a href="{{ asset('storage/' . $modul->file_modul) }}" target="_blank" 
                                           class="btn btn-primary rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-xs" 
                                           style="font-size: 0.78rem;" title="Buka / Unduh Berkas Modul">
                                            <i class="mdi mdi-download" style="font-size: 0.95rem;"></i> Unduh File
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="mdi mdi-folder-open-outline d-block mb-2 text-muted" style="font-size: 2.4rem; opacity: 0.5;"></i>
                                        <div class="fw-bold mb-1 fs-6">Belum Ada Modul Tersedia</div>
                                        <small class="text-muted">Tidak ditemukan materi modul untuk pencarian atau kelas Anda saat ini.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View Cards --}}
                <div class="d-md-none">
                    @forelse($moduls as $modul)
                        @php
                            $rawTeacherName = trim($modul->guru->nama_lengkap ?? $modul->guru->nama_guru ?? $modul->guru->nama ?? 'Guru');
                            $cleanTeacherName = preg_replace('/,\s*.*$/', '', $rawTeacherName);
                            $displayTeacherName = ucwords(strtolower($cleanTeacherName));
                        @endphp
                        <div class="card mobile-modul-card bg-white border mb-3 p-3 rounded-3 shadow-xs" style="border: 1px solid #cbd5e1 !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.72rem; white-space: nowrap;">
                                    {{ $modul->mataPelajaran->nama_mapel ?? 'Umum' }}
                                </span>
                                <small class="text-muted d-inline-flex align-items-center" style="font-size: 0.72rem;">
                                    <i class="mdi mdi-clock-outline me-1"></i>{{ $modul->created_at->locale('id')->diffForHumans() }}
                                </small>
                            </div>

                            <div class="text-start mb-2">
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem; line-height: 1.35;">{{ $modul->judul }}</h6>
                                @if(!empty($modul->deskripsi))
                                    <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.4;">{{ Str::limit($modul->deskripsi, 80) }}</p>
                                @endif
                            </div>

                            <div class="my-2 py-2 border-top border-bottom text-start" style="border-top-style: dashed !important; border-bottom-style: dashed !important; border-color: #cbd5e1 !important;">
                                <div class="d-flex align-items-center text-muted" style="font-size: 0.78rem;">
                                    <i class="mdi mdi-account-tie text-primary me-1.5 fs-6"></i>
                                    <span>Guru Pengampu: <strong class="text-dark">{{ $displayTeacherName }}</strong></span>
                                </div>
                            </div>

                            <div class="mt-2 pt-1">
                                <a href="{{ asset('storage/' . $modul->file_modul) }}" target="_blank" 
                                   class="btn btn-primary text-white w-100 justify-content-center py-2 px-3 rounded-pill d-inline-flex align-items-center shadow-xs fw-bold" 
                                   style="font-size: 0.8rem; gap: 6px;">
                                    <i class="mdi mdi-download fs-6"></i> Unduh / Buka Dokumen Modul
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="card bg-white p-4 text-center text-muted rounded-3 shadow-xs" style="border: 1px solid #cbd5e1 !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                            <i class="mdi mdi-folder-open-outline d-block fs-1 mb-2 opacity-50"></i>
                            <span class="small fw-semibold">Belum ada modul pembelajaran yang dibagikan.</span>
                        </div>
                    @endforelse
                </div>

                {{-- Info Footer --}}
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <div class="text-muted small">
                        Menampilkan {{ count($moduls) }} materi modul
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
