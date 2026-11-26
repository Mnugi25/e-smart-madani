@extends('template.layouts.app')

@section('title', 'Detail Siswa - ' . ($siswa->nama_siswa ?? $siswa->nama_lengkap ?? 'Profil'))

@section('content')
@php
    $rawName = trim($siswa->nama_siswa ?? $siswa->nama_lengkap ?? 'Siswa');
    $displayName = ucwords(strtolower($rawName));
    $words = array_values(array_filter(explode(' ', $rawName)));
    $initials = '';
    if (count($words) >= 2) {
        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    } elseif (count($words) == 1) {
        $initials = strtoupper(substr($words[0], 0, 2));
    } else {
        $initials = 'SW';
    }
    $palette = [
        'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
        'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
        'linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)',
        'linear-gradient(135deg, #10b981 0%, #059669 100%)',
        'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        'linear-gradient(135deg, #ec4899 0%, #be185d 100%)',
    ];
    $bgGradient = $palette[abs(crc32($rawName)) % count($palette)];

    $formattedTtl = $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-';
@endphp

<style>
    .detail-card {
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: #ffffff;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .detail-hero-header {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 24px 28px;
    }
    .info-group-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .info-group-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 13px 0;
        border-bottom: 1px dashed #e2e8f0;
    }
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .info-item:first-child {
        padding-top: 0;
    }
    .info-icon-wrapper {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }
    .info-label {
        font-size: 0.74rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 0.94rem;
        color: #0f172a;
        font-weight: 600;
        word-break: break-word;
    }
    .code-badge {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
    }

    /* Dark Mode Theme Support */
    html.dark-mode .detail-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .detail-hero-header {
        background: linear-gradient(135deg, #18181b 0%, #1e1b4b 100%) !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .info-group-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .info-item {
        border-bottom-color: #334155 !important;
    }
    html.dark-mode .info-label {
        color: #94a3b8 !important;
    }
    html.dark-mode .info-value {
        color: #f8fafc !important;
    }
    html.dark-mode .code-badge {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }
</style>

<div class="row">
    <div class="col-lg-9 mx-auto">
        <div class="detail-card mb-4">
            {{-- Header Hero --}}
            <div class="detail-hero-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm flex-shrink-0" 
                         style="width: 58px; height: 58px; background: {{ $bgGradient }}; font-size: 1.35rem; letter-spacing: 0.5px;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <h3 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">
                                {{ $displayName }}
                            </h3>
                            <span class="code-badge">
                                NISN: {{ $siswa->nisn ?? '-' }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="badge rounded-pill fw-semibold px-2.5 py-1" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.25); font-size: 0.76rem;">
                                <i class="mdi mdi-google-classroom me-1"></i> Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </span>
                            @if(!empty($siswa->kelas?->jurusan?->nama_jurusan))
                                <span class="text-muted small">
                                    {{ $siswa->kelas->jurusan->nama_jurusan }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Informasi 2 Kolom --}}
            <div class="p-4 p-md-4">
                <div class="row g-4">
                    {{-- Kolom Kiri: Data Akademik --}}
                    <div class="col-md-6">
                        <div class="info-group-box">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.98rem;">
                                <i class="mdi mdi-school text-primary fs-5"></i> Data Akademik Siswa
                            </h5>

                            {{-- Item 1: NISN --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;">
                                    <i class="mdi mdi-account-card-details-outline"></i>
                                </div>
                                <div>
                                    <div class="info-label">NISN Siswa</div>
                                    <div class="info-value">
                                        <span class="code-badge">{{ $siswa->nisn ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Item 2: Kelas & Jurusan --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                                    <i class="mdi mdi-google-classroom"></i>
                                </div>
                                <div>
                                    <div class="info-label">Kelas & Jurusan</div>
                                    <div class="info-value">
                                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                                        @if(!empty($siswa->kelas?->jurusan?->nama_jurusan))
                                            <span class="text-muted fw-normal">({{ $siswa->kelas->jurusan->nama_jurusan }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Item 3: Nama Orang Tua --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                                    <i class="mdi mdi-human-male-female text-muted"></i>
                                </div>
                                <div>
                                    <div class="info-label">Nama Orang Tua / Wali</div>
                                    <div class="info-value">{{ $siswa->nama_orang_tua ? ucwords(strtolower($siswa->nama_orang_tua)) : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Biodata Pribadi --}}
                    <div class="col-md-6">
                        <div class="info-group-box">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.98rem;">
                                <i class="mdi mdi-card-account-details-outline text-info fs-5"></i> Biodata Pribadi
                            </h5>

                            {{-- Item 1: Nama Lengkap --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(14, 165, 233, 0.12); color: #0284c7;">
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div>
                                    <div class="info-label">Nama Lengkap Siswa</div>
                                    <div class="info-value">{{ $displayName }}</div>
                                </div>
                            </div>

                            {{-- Item 2: Jenis Kelamin --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(236, 72, 153, 0.12); color: #db2777;">
                                    <i class="mdi mdi-gender-male-female"></i>
                                </div>
                                <div>
                                    <div class="info-label">Jenis Kelamin</div>
                                    <div class="info-value">
                                        @if(($siswa->jenis_kelamin ?? $siswa->jk) == 'L')
                                            <span class="d-inline-flex align-items-center text-dark">
                                                <i class="mdi mdi-gender-male text-primary me-1"></i> Laki-laki
                                            </span>
                                        @else
                                            <span class="d-inline-flex align-items-center text-dark">
                                                <i class="mdi mdi-gender-female text-danger me-1"></i> Perempuan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Item 3: Tanggal Lahir --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                                    <i class="mdi mdi-calendar-heart"></i>
                                </div>
                                <div>
                                    <div class="info-label">Tanggal Lahir</div>
                                    <div class="info-value">{{ $formattedTtl }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Tombol Aksi --}}
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="{{ route('admin.master.siswa') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                        <i class="mdi mdi-arrow-left me-1.5"></i> Kembali
                    </a>
                    <a href="{{ route('admin.master.siswa.edit', $siswa->id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                        <i class="mdi mdi-pencil me-1.5"></i> Edit Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
