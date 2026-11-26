@extends('template.layouts.app')

@section('title', 'Materi Tambahan')

@section('content')
<style>
    /* CSS Khusus Materi Pelajaran */
    .mobile-materi-card {
        border-radius: 16px !important;
        background: #ffffff !important;
        border: 1px solid rgba(0, 0, 0, 0.06) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .mobile-materi-card:active {
        transform: scale(0.99);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02) !important;
    }
    .materi-badge-video {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444 !important;
        font-weight: 800;
        font-size: 0.65rem !important;
        letter-spacing: 0.5px;
        padding: 5px 10px !important;
        border-radius: 30px !important;
    }
    .materi-badge-doc {
        background-color: rgba(59, 130, 246, 0.1) !important;
        color: #3b82f6 !important;
        font-weight: 800;
        font-size: 0.65rem !important;
        letter-spacing: 0.5px;
        padding: 5px 10px !important;
        border-radius: 30px !important;
    }
    .materi-desc-box-video {
        background-color: #fef2f2 !important;
        border-left: 4px solid #ef4444 !important;
        border-radius: 4px 12px 12px 4px !important;
        padding: 10px 14px !important;
    }
    .materi-desc-box-doc {
        background-color: #eff6ff !important;
        border-left: 4px solid #3b82f6 !important;
        border-radius: 4px 12px 12px 4px !important;
        padding: 10px 14px !important;
    }
    .btn-gradient-download {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25) !important;
        transition: all 0.2s ease;
    }
    .btn-gradient-download:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(59, 130, 246, 0.25) !important;
    }
    .btn-gradient-video {
        background: linear-gradient(135deg, #ef4444, #b91c1c) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25) !important;
        transition: all 0.2s ease;
    }
    .btn-gradient-video:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(239, 68, 68, 0.25) !important;
    }
    .btn-back-premium {
        background-color: #000000 !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.2s ease-in-out !important;
    }
    .btn-back-premium:hover {
        background-color: #1a1a1a !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25) !important;
    }
    .btn-back-premium:active {
        transform: scale(0.97) translateY(0);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15) !important;
    }

    html.dark-mode .mobile-materi-card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
    }
    html.dark-mode .mobile-materi-card .text-dark {
        color: #ffffff !important;
    }
    html.dark-mode .mobile-materi-card-divider {
        border-color: #334155 !important;
    }
    html.dark-mode .materi-badge-video {
        background-color: rgba(239, 68, 68, 0.2) !important;
        color: #fca5a5 !important;
    }
    html.dark-mode .materi-badge-doc {
        background-color: rgba(59, 130, 246, 0.2) !important;
        color: #93c5fd !important;
    }
    html.dark-mode .materi-desc-box-video {
        background-color: rgba(239, 68, 68, 0.08) !important;
        border-left-color: #f87171 !important;
    }
    html.dark-mode .materi-desc-box-doc {
        background-color: rgba(59, 130, 246, 0.08) !important;
        border-left-color: #60a5fa !important;
    }
    html.dark-mode .table th {
        color: #cbd5e1 !important;
    }
    html.dark-mode .table td {
        color: #cbd5e1 !important;
    }
    html.dark-mode .table tr:hover {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }
</style>

<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="mdi mdi-book-open-page-variant text-info me-2"></i>Materi Tambahan
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.jadwal') }}" class="text-decoration-none text-muted">Jadwal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $jadwal->mataPelajaran->nama_mapel }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('siswa.jadwal') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm d-none d-md-inline-block" style="background-color: #000000 !important; border-color: #000000 !important;">
                <i class="mdi mdi-arrow-left me-1"></i> KEMBALI
            </a>
        </div>
    </div>

    <div class="col-lg-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-3 p-md-4">
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-0">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                    <p class="text-muted small mb-0">Guru Pengampu: <strong>{{ $jadwal->guru->nama_lengkap ?? $jadwal->guru->nama_guru ?? 'Guru' }}</strong></p>
                </div>

                <!-- Desktop View (Tabel) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start">No</th>
                                <th class="border-0">Judul Materi</th>
                                <th class="border-0">Deskripsi</th>
                                <th class="border-0">File/Link</th>
                                <th class="border-0 rounded-end">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materis as $index => $materi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $materi->judul }}</td>
                                    <td>
                                        <small class="text-muted d-block text-truncate" style="max-width: 250px;">{{ $materi->deskripsi ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            @if($materi->file_path)
                                                <a href="{{ route('materi.download', $materi->id) }}" class="btn btn-sm btn-info text-white rounded-pill px-3 fw-bold shadow-sm">
                                                    <i class="mdi mdi-download me-1"></i> DOWNLOAD
                                                </a>
                                            @endif

                                            @if($materi->video_url)
                                                <a href="{{ $materi->video_url }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill px-3 fw-bold shadow-sm">
                                                    <i class="mdi mdi-play-circle me-1"></i> LIHAT VIDEO
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="small text-dark fw-bold"><i class="mdi mdi-calendar-outline me-1"></i>{{ $materi->created_at->format('d/m/Y') }}</span>
                                            <span class="small text-muted ms-2"><i class="mdi mdi-clock-outline me-1"></i>{{ $materi->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                            <i class="mdi mdi-book-open-variant display-3 text-muted"></i>
                                        </div>
                                        <h5 class="text-muted fw-bold">Belum ada materi yang dibagikan.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View (Card List) -->
                <div class="d-md-none">
                    @forelse($materis as $materi)
                        <div class="card mb-3 mobile-materi-card border-0">
                            <div class="card-body p-3">
                                <!-- Top Area: Badge & Time -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    @if($materi->video_url)
                                        <span class="materi-badge-video d-inline-flex align-items-center gap-1">
                                            <i class="mdi mdi-youtube" style="font-size: 0.95rem;"></i> VIDEO PEMBELAJARAN
                                        </span>
                                    @else
                                        <span class="materi-badge-doc d-inline-flex align-items-center gap-1">
                                            <i class="mdi mdi-file-document-outline" style="font-size: 0.95rem;"></i> DOKUMEN MATERI
                                        </span>
                                    @endif
                                    
                                    <small class="text-muted d-inline-flex align-items-center gap-1" style="font-size: 0.7rem;">
                                        <i class="mdi mdi-clock-outline"></i> {{ $materi->created_at->locale('id')->diffForHumans() }}
                                    </small>
                                </div>

                                <!-- Title -->
                                <h5 class="fw-bold text-dark mb-3 text-start" style="font-size: 1rem; line-height: 1.4; word-break: break-word; white-space: normal;">
                                    {{ $materi->judul }}
                                </h5>

                                <!-- Description / Instruction Box -->
                                @if($materi->deskripsi)
                                    <div class="mb-3 {{ $materi->video_url ? 'materi-desc-box-video' : 'materi-desc-box-doc' }}">
                                        <div class="d-flex align-items-center gap-1 mb-1 text-muted text-start" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.3px; text-transform: uppercase;">
                                            <i class="mdi mdi-information-outline"></i> Catatan & Petunjuk Guru
                                        </div>
                                        <p class="text-muted mb-0 text-start" style="font-size: 0.78rem; line-height: 1.5; white-space: normal;">
                                            {{ $materi->deskripsi }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Actions Area -->
                                <div class="d-grid gap-2 pt-2 border-top mobile-materi-card-divider">
                                    @if($materi->file_path)
                                        <a href="{{ route('materi.download', $materi->id) }}" class="btn btn-gradient-download rounded-pill py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.8rem;">
                                            <i class="mdi mdi-download" style="font-size: 1.05rem;"></i> UNDUH FILE MATERI
                                        </a>
                                    @endif

                                    @if($materi->video_url)
                                        <a href="{{ $materi->video_url }}" target="_blank" class="btn btn-gradient-video rounded-pill py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.8rem;">
                                            <i class="mdi mdi-youtube" style="font-size: 1.05rem;"></i> TONTON VIDEO
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                <i class="mdi mdi-book-open-variant display-4 text-muted"></i>
                            </div>
                            <h6 class="text-muted fw-bold">Belum ada materi yang dibagikan.</h6>
                        </div>
                    @endforelse
                </div>

                <!-- Bottom Navigation (Mobile Only) -->
                <div class="d-flex justify-content-center d-md-none mt-4 pt-3 border-top mobile-materi-card-divider">
                    <a href="{{ route('siswa.jadwal') }}" class="btn btn-back-premium rounded-pill px-5 py-2 fw-bold shadow-sm">
                        KEMBALI
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
