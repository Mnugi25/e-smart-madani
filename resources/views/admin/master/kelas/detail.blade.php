@extends('template.layouts.app')

@section('title', 'Detail Kelas - ' . ($kelas->nama_kelas ?? 'Kelas'))

@section('content')
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
    <div class="col-lg-8 mx-auto">
        <div class="detail-card mb-4">
            {{-- Header Hero --}}
            <div class="detail-hero-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10 shadow-sm flex-shrink-0" 
                         style="width: 54px; height: 54px; font-size: 1.5rem;">
                        <i class="mdi mdi-google-classroom"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <h3 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">
                                {{ $kelas->nama_kelas }}
                            </h3>
                            <span class="code-badge">
                                Kelas {{ $kelas->tingkat ?? '-' }}
                            </span>
                        </div>
                        <p class="text-muted small mb-0">{{ $kelas->jurusan->nama_jurusan ?? 'Tanpa Jurusan' }}</p>
                    </div>
                </div>
            </div>

            {{-- Detail Informasi --}}
            <div class="p-4 p-md-4">
                <div class="info-group-box">
                    <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.98rem;">
                        <i class="mdi mdi-information-outline text-primary fs-5"></i> Informasi Detail Kelas
                    </h5>

                    {{-- Item 1: Nama Kelas --}}
                    <div class="info-item">
                        <div class="info-icon-wrapper" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;">
                            <i class="mdi mdi-home-variant"></i>
                        </div>
                        <div>
                            <div class="info-label">Nama Kelas</div>
                            <div class="info-value">{{ $kelas->nama_kelas }}</div>
                        </div>
                    </div>

                    {{-- Item 2: Tingkat --}}
                    <div class="info-item">
                        <div class="info-icon-wrapper" style="background: rgba(139, 92, 246, 0.12); color: #7c3aed;">
                            <i class="mdi mdi-trending-up"></i>
                        </div>
                        <div>
                            <div class="info-label">Tingkat / Jenjang</div>
                            <div class="info-value">
                                <span class="code-badge">Kelas {{ $kelas->tingkat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Item 3: Jurusan --}}
                    <div class="info-item">
                        <div class="info-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                            <i class="mdi mdi-tag-outline"></i>
                        </div>
                        <div>
                            <div class="info-label">Jurusan / Program Studi</div>
                            <div class="info-value">
                                {{ $kelas->jurusan->nama_jurusan ?? 'Tanpa Jurusan' }}
                                @if(!empty($kelas->jurusan?->kode_jurusan))
                                    <span class="text-muted fw-normal ms-1">({{ $kelas->jurusan->kode_jurusan }})</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Item 4: Wali Kelas --}}
                    <div class="info-item">
                        <div class="info-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                            <i class="mdi mdi-account-tie"></i>
                        </div>
                        <div>
                            <div class="info-label">Wali Kelas</div>
                            <div class="info-value">
                                @if($kelas->waliKelas)
                                    <span class="d-inline-flex align-items-center text-dark">
                                        <i class="mdi mdi-account-circle text-primary me-1.5 fs-6"></i> {{ $kelas->waliKelas->nama_lengkap }}
                                    </span>
                                @else
                                    <span class="text-muted fw-normal">Belum Ditunjuk</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Tombol Aksi --}}
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="/admin/master/kelas" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                        <i class="mdi mdi-arrow-left me-1.5"></i> Kembali
                    </a>
                    <a href="/admin/master/kelas/{{ $kelas->id }}/edit" class="btn btn-warning text-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                        <i class="mdi mdi-pencil me-1.5"></i> Edit Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
