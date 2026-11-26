@extends('template.layouts.app')

@section('title', 'Ruang Materi')

@section('content')
<style>
    .btn-success-custom {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        color: #fff !important;
        border: none;
    }
    .btn-success-custom:hover {
        background: linear-gradient(135deg, #218838 0%, #28a745 100%);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    /* Modern Back Button */
    .btn-back-modern {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 6px 18px 6px 8px;
        background: #ffffff;
        color: #1e293b !important;
        border: 1.5px solid #cbd5e1;
        border-radius: 50px;
        font-size: 0.86rem;
        font-weight: 700;
        text-decoration: none !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-back-modern:hover {
        background: #f8fafc;
        border-color: #3b82f6;
        color: #2563eb !important;
        transform: translateX(-4px);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);
    }
    .btn-back-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: all 0.25s ease;
    }
    .btn-back-modern:hover .btn-back-icon {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        transform: scale(1.05);
    }
    html.dark-mode .btn-back-modern {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #f4f4f5 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark-mode .btn-back-modern:hover {
        background: #27272a !important;
        border-color: #3b82f6 !important;
        color: #60a5fa !important;
    }
    html.dark-mode .btn-back-icon {
        background: rgba(59, 130, 246, 0.18) !important;
        color: #60a5fa !important;
    }
    html.dark-mode .btn-back-modern:hover .btn-back-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: #ffffff !important;
    }
    .btn-upload-materi {
        width: auto;
    }
    @media (max-width: 767.98px) {
        .btn-upload-materi {
            width: 100% !important;
        }
        .card-body {
            padding: 16px !important;
        }
        .mt-mobile {
            margin-top: 15px !important;
        }
        .page-title-responsive {
            font-size: 1.3rem !important;
            line-height: 1.3 !important;
        }
    }
    
    .btn-edit-materi-mobile {
        font-size: 0.72rem;
        font-weight: 600;
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
    }
    .btn-delete-materi-mobile {
        font-size: 0.72rem;
        font-weight: 600;
        background-color: #fff5f5 !important;
        border: 1px solid #fed7d7 !important;
        color: #dc3545 !important;
    }
    html.dark-mode .btn-edit-materi-mobile {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #ffffff !important;
    }
    html.dark-mode .btn-delete-materi-mobile {
        background-color: rgba(220, 53, 69, 0.2) !important;
        border-color: rgba(220, 53, 69, 0.3) !important;
        color: #fca5a5 !important;
    }
    .card-action-footer-mobile {
        border-top: 1px dashed #e2e8f0 !important;
    }
    html.dark-mode .card-action-footer-mobile {
        border-top: 1px dashed #334155 !important;
    }
    
    /* --- Mobile Icon and View Buttons --- */
    /* PDF style */
    .materi-icon-pdf {
        background-color: #fef2f2 !important;
        color: #ef4444 !important;
    }
    .btn-view-pdf {
        font-size: 0.72rem;
        text-decoration: none;
        background-color: #fef2f2 !important;
        border: 1px solid #fee2e2 !important;
        color: #ef4444 !important;
    }
    html.dark-mode .materi-icon-pdf {
        background-color: rgba(239, 68, 68, 0.15) !important;
        color: #fca5a5 !important;
    }
    html.dark-mode .btn-view-pdf {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border-color: rgba(239, 68, 68, 0.25) !important;
        color: #fca5a5 !important;
    }

    /* Video style */
    .materi-icon-video {
        background-color: #eff6ff !important;
        color: #3b82f6 !important;
    }
    .btn-view-video {
        font-size: 0.72rem;
        text-decoration: none;
        background-color: #eff6ff !important;
        border: 1px solid #dbeafe !important;
        color: #3b82f6 !important;
    }
    html.dark-mode .materi-icon-video {
        background-color: rgba(59, 130, 246, 0.15) !important;
        color: #93c5fd !important;
    }
    html.dark-mode .btn-view-video {
        background-color: rgba(59, 130, 246, 0.15) !important;
        border-color: rgba(59, 130, 246, 0.25) !important;
        color: #93c5fd !important;
    }

    /* Default / Book style */
    .materi-icon-default {
        background-color: #e0f2fe !important;
        color: #0284c7 !important;
    }
    html.dark-mode .materi-icon-default {
        background-color: rgba(2, 132, 199, 0.15) !important;
        color: #7dd3fc !important;
    }
</style>

<div class="row mt-mobile mt-sm-4">
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="mdi mdi-book-open-page-variant text-info me-2"></i>Ruang Materi
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('guru.jadwal') }}" class="text-decoration-none text-muted">Jadwal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->mataPelajaran->nama_mapel }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('guru.jadwal') }}" class="btn-back-modern">
                <div class="btn-back-icon">
                    <i class="mdi mdi-arrow-left"></i>
                </div>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
                <i class="mdi mdi-check-circle me-2"></i><strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="col-12 mb-4">
        {{-- Desktop View --}}
        <div class="card card-rounded shadow-sm border-0 d-none d-md-block">
            <div class="card-body p-4">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <div class="mb-3 mb-sm-0">
                        <h4 class="fw-bold text-dark mb-0">Daftar Bahan Ajar</h4>
                        <p class="text-muted small mb-0">Kelola materi pembelajaran yang dibagikan kepada siswa.</p>
                    </div>
                    <button type="button" class="btn btn-success-custom rounded-pill px-4 fw-bold shadow-sm btn-upload-materi d-flex justify-content-center align-items-center" style="height: 42px;" data-bs-toggle="modal" data-bs-target="#modalUpload">
                        <i class="mdi mdi-cloud-upload me-2"></i> UNGGAH MATERI BARU
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start">No</th>
                                <th class="border-0">Judul Materi</th>
                                <th class="border-0">Deskripsi</th>
                                <th class="border-0">File/Link Video</th>
                                <th class="border-0">Tanggal Unggah</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materis as $index => $materi)
                                <tr class="align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark text-start">{{ $materi->judul }}</td>
                                    <td class="text-start">
                                        <small class="text-muted d-block text-truncate" style="max-width: 250px;">{{ $materi->deskripsi ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($materi->file_path)
                                            @if(strtolower(pathinfo($materi->file_path, PATHINFO_EXTENSION)) == 'pdf')
                                                <div class="mt-1">
                                                    <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill shadow-sm">
                                                        <i class="mdi mdi-file-pdf-box me-1"></i> Lihat PDF
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                        @if($materi->video_url)
                                            <div class="mt-2">
                                                <a href="{{ $materi->video_url }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill shadow-sm">
                                                    <i class="mdi mdi-play-circle me-1"></i> Lihat Video
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="small text-dark fw-bold"><i class="mdi mdi-calendar-outline me-1"></i>{{ $materi->created_at->format('d/m/Y') }}</span>
                                            <span class="small text-muted ms-2"><i class="mdi mdi-clock-outline me-1"></i>{{ $materi->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-sm btn-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $materi->id }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Hapus">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
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
            </div>
        </div>

        {{-- Mobile View Title & Upload Button --}}
        <div class="d-md-none mb-3 mt-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-start">
                    <span class="badge rounded-pill bg-light text-dark fw-bold border" style="font-size: 0.75rem; padding: 6px 12px;">
                        📚 {{ $materis->count() }} Bahan Ajar
                    </span>
                </div>
                <button type="button" class="btn btn-success-custom rounded-pill px-3 fw-bold shadow-sm d-flex justify-content-center align-items-center" style="height: 36px; font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalUpload">
                    <i class="mdi mdi-cloud-upload me-1.5" style="font-size: 0.9rem;"></i> UNGGAH MATERI BARU
                </button>
            </div>
        </div>

        {{-- Mobile View Cards (Direct child of col-12 grid for perfect layout alignment) --}}
        <div class="d-md-none">
            @forelse($materis as $materi)
                @php
                    $hasPdf = $materi->file_path && strtolower(pathinfo($materi->file_path, PATHINFO_EXTENSION)) == 'pdf';
                    $hasVideo = !empty($materi->video_url);
                    
                    if ($hasPdf && !$hasVideo) {
                        $iconClass = 'mdi-file-pdf-box';
                        $iconThemeClass = 'materi-icon-pdf';
                    } elseif ($hasVideo && !$hasPdf) {
                        $iconClass = 'mdi-play-circle';
                        $iconThemeClass = 'materi-icon-video';
                    } else {
                        $iconClass = 'mdi-book-open-variant';
                        $iconThemeClass = 'materi-icon-default';
                    }
                @endphp
                <div class="card bg-white border-0 mb-3 p-3 rounded-4 shadow-sm" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); border: 1px solid rgba(0,0,0,0.04) !important;">
                    <div class="d-flex align-items-start gap-3 mb-2">
                        <div class="rounded-3 p-2 d-flex align-items-center justify-content-center {{ $iconThemeClass }}" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="mdi {{ $iconClass }}" style="font-size: 1.25rem;"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden text-start">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem; line-height: 1.4; word-wrap: break-word;">{{ $materi->judul }}</h6>
                            @if($materi->deskripsi)
                                <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $materi->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-1 text-muted mb-3" style="font-size: 0.72rem; padding-left: 2px;">
                        <i class="mdi mdi-calendar-outline"></i>
                        <span>Diunggah pada {{ $materi->created_at->format('d M Y') }} pukul {{ $materi->created_at->format('H:i') }}</span>
                    </div>

                    @if($materi->file_path || $materi->video_url)
                        <div class="mb-3 d-flex flex-wrap gap-2">
                            @if($materi->file_path && strtolower(pathinfo($materi->file_path, PATHINFO_EXTENSION)) == 'pdf')
                                <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="btn btn-xs btn-view-pdf d-inline-flex align-items-center gap-1.5 py-1.5 px-3 rounded-pill fw-bold">
                                    <i class="mdi mdi-file-pdf-box" style="font-size: 0.9rem;"></i> Lihat PDF
                                </a>
                            @endif
                            @if($materi->video_url)
                                <a href="{{ $materi->video_url }}" target="_blank" class="btn btn-xs btn-view-video d-inline-flex align-items-center gap-1.5 py-1.5 px-3 rounded-pill fw-bold">
                                    <i class="mdi mdi-play-circle" style="font-size: 0.9rem;"></i> Lihat Video
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 card-action-footer-mobile">
                        <button type="button" class="btn btn-edit-materi-mobile px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $materi->id }}">
                            <i class="ti-pencil text-warning" style="font-size: 0.8rem;"></i> Edit
                        </button>
                        <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete-materi-mobile px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-1.5">
                                <i class="ti-trash" style="font-size: 0.8rem;"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.04) !important;">
                    <i class="mdi mdi-book-open-variant display-3 text-muted opacity-50 mb-2"></i>
                    <p class="small">Belum ada materi yang dibagikan.</p>
                </div>
            @endforelse
        </div>

        {{-- Tombol Kembali di Bawah (Hanya muncul di Mobile) --}}
        <div class="mt-4 d-md-none">
            <a href="{{ route('guru.jadwal') }}" class="btn btn-dark w-100 py-2.5 d-flex justify-content-center align-items-center fw-bold rounded-pill text-white" style="background-color: #000000 !important; border-color: #000000 !important; height: 42px;">
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach($materis as $materi)
    <div class="modal fade" id="modalEdit{{ $materi->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-2">
                    <h5 class="modal-title fw-bold text-dark"><i class="mdi mdi-pencil text-warning me-2"></i>Edit Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 py-5">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted text-uppercase">Judul Materi</label>
                                <input type="text" name="judul" class="form-control border-0 bg-light rounded-3 py-3" value="{{ $materi->judul }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted text-uppercase">Ganti File (Opsional)</label>
                                <input type="file" name="file_materi" class="form-control border-0 bg-light rounded-3 py-2">
                                <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">File saat ini: <strong>{{ $materi->file_name }}</strong></small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted text-uppercase">Video Pembelajaran (URL)</label>
                                <input type="url" name="video_url" class="form-control border-0 bg-light rounded-3 py-3" value="{{ $materi->video_url }}" placeholder="https://youtube.com/...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control border-0 bg-light rounded-3 py-3" rows="10" style="min-height: 200px;" placeholder="Berikan keterangan detail mengenai materi ini...">{{ $materi->deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-2">
                        <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold text-white" style="background-color: #000000 !important; border-color: #000000 !important;" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-warning text-white rounded-pill px-4 fw-bold shadow-sm">SIMPAN PERUBAHAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- MODAL UPLOAD --}}
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="modalUploadLabel"><i class="mdi mdi-cloud-upload text-info me-2"></i>Unggah Materi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('guru.materi.store', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-5">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Judul Materi</label>
                            <input type="text" name="judul" class="form-control border-0 bg-light rounded-3 py-3" placeholder="Judul Materi" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">File Materi (Opsional)</label>
                            <input type="file" name="file_materi" class="form-control border-0 bg-light rounded-3 py-2">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Video Pembelajaran (URL)</label>
                            <input type="url" name="video_url" class="form-control border-0 bg-light rounded-3 py-3" placeholder="https://youtube.com/...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="form-control border-0 bg-light rounded-3 py-3" rows="10" style="min-height: 200px;" placeholder="Tuliskan detail atau instruksi materi di sini agar siswa mudah memahaminya..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-2">
                    <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold text-white" style="background-color: #000000 !important; border-color: #000000 !important;" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-info text-white rounded-pill px-4 fw-bold shadow-sm">UNGHAH MATERI</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection