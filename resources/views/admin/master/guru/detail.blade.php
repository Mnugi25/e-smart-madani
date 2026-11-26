@extends('template.layouts.app')

@section('title', 'Detail Guru - ' . ($guru->nama_lengkap ?? 'Profil'))

@section('content')
@php
    $rawName = trim($guru->nama_lengkap ?? 'Guru');
    $gelarMap = [
        's.pd.' => 'S.Pd.', 's.pd' => 'S.Pd.',
        'm.pd.' => 'M.Pd.', 'm.pd' => 'M.Pd.',
        's.kom.' => 'S.Kom.', 's.kom' => 'S.Kom.',
        's.t.' => 'S.T.', 's.t' => 'S.T.',
        's.si.' => 'S.Si.', 's.si' => 'S.Si.',
        's.e.' => 'S.E.', 's.e' => 'S.E.',
        'm.m.' => 'M.M.', 'm.m' => 'M.M.',
        'm.kom.' => 'M.Kom.', 'm.kom' => 'M.Kom.',
    ];
    if (str_contains($rawName, ',')) {
        $parts = explode(',', $rawName, 2);
        $namaUtama = ucwords(strtolower(trim($parts[0])));
        $lowerGelar = strtolower(trim($parts[1]));
        $formattedGelar = $gelarMap[$lowerGelar] ?? ucwords($lowerGelar);
        $displayName = $namaUtama . ', ' . $formattedGelar;
    } else {
        $displayName = ucwords(strtolower($rawName));
    }

    $cleanName = preg_replace('/,\s*.*$/', '', $rawName);
    $words = array_values(array_filter(explode(' ', trim($cleanName))));
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
        'linear-gradient(135deg, #ec4899 0%, #be185d 100%)',
    ];
    $bgGradient = $palette[abs(crc32($rawName)) % count($palette)];

    $isWali = str_contains(strtoupper($guru->jabatan ?? ''), 'WALI');
    $waliKelasName = $guru->kelasWali->nama_kelas ?? null;

    $formattedTtl = '-';
    if ($guru->tempat_lahir && $guru->tanggal_lahir) {
        $formattedTtl = ucwords(strtolower($guru->tempat_lahir)) . ', ' . \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d F Y');
    } elseif ($guru->tanggal_lahir) {
        $formattedTtl = \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d F Y');
    } elseif ($guru->tempat_lahir) {
        $formattedTtl = ucwords(strtolower($guru->tempat_lahir));
    }
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
        padding: 28px 32px;
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
</style>

<div class="row">
    <div class="col-lg-10 mx-auto">
        {{-- Card Container --}}
        <div class="detail-card mb-4">
            {{-- 🌟 1. PROFILE HERO HEADER --}}
            <div class="detail-hero-header">
                <div class="d-flex align-items-center gap-3">
                    {{-- Avatar Circle --}}
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm flex-shrink-0" 
                         style="width: 64px; height: 64px; background: {{ $bgGradient }}; font-size: 1.45rem; letter-spacing: 0.5px;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <h3 class="fw-bold text-dark mb-0" style="font-size: 1.35rem; line-height: 1.2;">
                                {{ $displayName }}
                            </h3>
                            <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.76rem; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                                {{ $guru->kode_guru ?? '-' }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if($isWali)
                                <span class="badge rounded-pill" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 700; font-size: 0.76rem; padding: 4px 12px;">
                                    <i class="mdi mdi-shield-star me-1"></i> Wali Kelas {{ $waliKelasName ? '('.$waliKelasName.')' : '' }}
                                </span>
                            @else
                                <span class="badge rounded-pill" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.25); font-weight: 600; font-size: 0.76rem; padding: 4px 12px;">
                                    <i class="mdi mdi-teach me-1"></i> Guru Mata Pelajaran
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📋 2. INFORMASI DETAIL DUA KOLOM --}}
            <div class="p-4 p-md-5">
                <div class="row g-4">
                    {{-- KOLOM KIRI: TUGAS AKADEMIK & KONTAK --}}
                    <div class="col-md-6">
                        <div class="info-group-box">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 1rem;">
                                <i class="mdi mdi-briefcase-outline text-primary fs-5"></i> Data Kepegawaian
                            </h5>

                            {{-- Item 1: Kode Guru --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;">
                                    <i class="mdi mdi-account-card-details-outline"></i>
                                </div>
                                <div>
                                    <div class="info-label">Kode / NIP Guru</div>
                                    <div class="info-value">{{ $guru->kode_guru ?? '-' }}</div>
                                </div>
                            </div>

                            {{-- Item 2: Jabatan --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                                    <i class="mdi mdi-account-tie"></i>
                                </div>
                                <div>
                                    <div class="info-label">Jabatan Struktural</div>
                                    <div class="info-value">
                                        {{ $guru->jabatan ?? 'Guru Pengajar' }}
                                        @if($isWali && $waliKelasName)
                                            <span class="text-muted fw-normal ms-1">(Kelas {{ $waliKelasName }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Item 3: No. HP --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(34, 197, 94, 0.12); color: #16a34a;">
                                    <i class="mdi mdi-phone-outline"></i>
                                </div>
                                <div>
                                    <div class="info-label">No. HP</div>
                                    <div class="info-value">{{ $guru->no_hp ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: BIODATA & DATA PRIBADI --}}
                    <div class="col-md-6">
                        <div class="info-group-box">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 1rem;">
                                <i class="mdi mdi-card-account-details-outline text-info fs-5"></i> Biodata Pribadi
                            </h5>

                            {{-- Item 1: Nama Lengkap --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(14, 165, 233, 0.12); color: #0284c7;">
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div>
                                    <div class="info-label">Nama Lengkap</div>
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
                                        @if($guru->jk == 'L')
                                            <span class="d-inline-flex align-items-center text-dark">
                                                <i class="mdi mdi-gender-male text-primary me-1"></i> Laki-laki
                                            </span>
                                        @elseif($guru->jk == 'P')
                                            <span class="d-inline-flex align-items-center text-dark">
                                                <i class="mdi mdi-gender-female text-danger me-1"></i> Perempuan
                                            </span>
                                        @else
                                            <span class="text-muted fw-normal">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Item 3: Tempat, Tanggal Lahir --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                                    <i class="mdi mdi-calendar-heart"></i>
                                </div>
                                <div>
                                    <div class="info-label">Tempat, Tanggal Lahir</div>
                                    <div class="info-value">{{ $formattedTtl }}</div>
                                </div>
                            </div>

                            {{-- Item 4: Alamat Tinggal --}}
                            <div class="info-item">
                                <div class="info-icon-wrapper" style="background: rgba(239, 68, 68, 0.12); color: #dc2626;">
                                    <i class="mdi mdi-map-marker-radius"></i>
                                </div>
                                <div>
                                    <div class="info-label">Alamat</div>
                                    <div class="info-value">
                                        {{ $guru->alamat ? ucwords(strtolower($guru->alamat)) : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔙 3. ACTION FOOTER --}}
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="{{ route('admin.master.guru') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                        <i class="mdi mdi-arrow-left me-1.5"></i> Kembali
                    </a>
                    <a href="{{ route('admin.master.guru.edit', $guru->id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                        <i class="mdi mdi-pencil me-1.5"></i> Edit Guru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
