@extends('template.layouts.app')

@section('title', 'Tugas Siswa')

@section('content')
<style>
    .btn-bright-danger {
        background-color: #ff3131 !important;
        color: white !important;
        border: none !important;
    }
    .btn-bright-danger:disabled {
        opacity: 0.8;
    }

    /* CSS Khusus Tugas Premium */
    .mobile-tugas-card {
        border-radius: 16px !important;
        background: #ffffff !important;
        border: 1px solid rgba(0, 0, 0, 0.06) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .mobile-tugas-card:active {
        transform: scale(0.99);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02) !important;
    }
    .tugas-badge-belum {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444 !important;
        font-weight: 800;
        font-size: 0.65rem !important;
        letter-spacing: 0.5px;
        padding: 5px 10px !important;
        border-radius: 30px !important;
    }
    .tugas-badge-sudah {
        background-color: rgba(34, 197, 94, 0.1) !important;
        color: #22c55e !important;
        font-weight: 800;
        font-size: 0.65rem !important;
        letter-spacing: 0.5px;
        padding: 5px 10px !important;
        border-radius: 30px !important;
    }
    .tugas-badge-belum-mulai {
        background-color: rgba(108, 117, 125, 0.1) !important;
        color: #6c757d !important;
        font-weight: 800;
        font-size: 0.65rem !important;
        letter-spacing: 0.5px;
        padding: 5px 10px !important;
        border-radius: 30px !important;
    }
    .tugas-desc-box {
        background-color: #f8fafc !important;
        border-left: 4px solid #cbd5e1 !important;
        border-radius: 4px 12px 12px 4px !important;
        padding: 10px 14px !important;
    }
    .btn-gradient-collect {
        background: linear-gradient(135deg, #ffc107, #ff9800) !important;
        border: none !important;
        color: #000000 !important;
        font-weight: 800 !important;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.2) !important;
        transition: all 0.2s ease;
    }
    .btn-gradient-collect:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(255, 193, 7, 0.2) !important;
    }
    .btn-gradient-edit-tugas {
        background: linear-gradient(135deg, #22c55e, #15803d) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        box-shadow: 0 4px 10px rgba(34, 197, 94, 0.2) !important;
        transition: all 0.2s ease;
    }
    .btn-gradient-edit-tugas:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(34, 197, 94, 0.2) !important;
    }
    .btn-gradient-download-tugas {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2) !important;
        transition: all 0.2s ease;
    }
    .btn-gradient-download-tugas:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(59, 130, 246, 0.2) !important;
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

    html.dark-mode .mobile-tugas-card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
    }
    html.dark-mode .mobile-tugas-card .text-dark {
        color: #ffffff !important;
    }
    html.dark-mode .mobile-tugas-card-divider {
        border-color: #334155 !important;
    }
    html.dark-mode .tugas-desc-box {
        background-color: rgba(255, 255, 255, 0.02) !important;
        border-left-color: #475569 !important;
    }
</style>
<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="mdi mdi-clipboard-text-outline text-warning me-2"></i>Penugasan
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

    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
                <i class="mdi mdi-check-circle me-2"></i><strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="col-lg-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-0">{{ $jadwal->mataPelajaran->nama_mapel }}</h4>
                    <p class="text-muted small">Guru Pengampu: <strong>{{ $jadwal->guru->nama_lengkap ?? $jadwal->guru->nama_guru ?? 'Guru' }}</strong></p>
                </div>

                <!-- Desktop View (Tabel) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start">No</th>
                                <th class="border-0">Informasi Tugas</th>
                                <th class="border-0">Materi</th>
                                <th class="border-0">Waktu Mulai</th>
                                <th class="border-0">Batas Waktu</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Nilai</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $index => $item)
                                @php
                                    $pengumpulan = $item->pengumpulan->first();
                                    $sudahKumpul = ($pengumpulan && !empty($pengumpulan->link_tugas)) ? true : false;
                                    $isNotStarted = $item->waktu_mulai && \Carbon\Carbon::now()->isBefore($item->waktu_mulai);
                                @endphp
                                <tr class="align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $item->judul }}</div>
                                        <p class="text-muted small mb-0" style="max-width: 400px; white-space: normal;">
                                            {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                                        </p>
                                    </td>
                                    <td class="text-start">
                                        @if($item->file_path)
                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="mdi mdi-download me-1"></i> Unduh Materi
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->waktu_mulai)
                                            <div class="small text-dark fw-bold">
                                                <i class="mdi mdi-calendar-play text-success me-1"></i>
                                                {{ $item->waktu_mulai->format('d/m/Y') }}
                                            </div>
                                            <div class="small text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $item->waktu_mulai->format('H:i') }} WIB</div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->deadline)
                                            <div class="small text-dark fw-bold">
                                                <i class="mdi mdi-calendar-clock text-danger me-1"></i>
                                                {{ $item->deadline->format('d/m/Y') }}
                                            </div>
                                            <div class="small text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $item->deadline->format('H:i') }} WIB</div>
                                        @else
                                            <span class="text-muted small">Tanpa batas waktu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isNotStarted)
                                            <span class="badge bg-secondary rounded-pill small shadow-sm">
                                                <i class="mdi mdi-clock-start me-1"></i>Belum Dimulai
                                            </span>
                                        @elseif($sudahKumpul)
                                            <span class="badge bg-success rounded-pill small shadow-sm">
                                                <i class="mdi mdi-check-circle me-1"></i>Sudah Dikumpulkan
                                            </span>
                                        @elseif($pengumpulan && !$sudahKumpul)
                                            <span class="badge bg-danger rounded-pill small shadow-sm">
                                                <i class="mdi mdi-close-circle me-1"></i>Tidak Mengumpulkan
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill small shadow-sm">
                                                <i class="mdi mdi-alert-circle me-1"></i>Belum Dikumpulkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-center">
                                        @if($pengumpulan && $pengumpulan->nilai !== null)
                                            <span class="text-primary fs-5">{{ $pengumpulan->nilai }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $isPastDeadline = $item->deadline && \Carbon\Carbon::now()->isAfter($item->deadline);
                                        @endphp
                                        @if($isNotStarted)
                                            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 fw-bold shadow-sm" disabled>
                                                <i class="mdi mdi-lock me-1"></i> Belum Dibuka
                                            </button>
                                        @elseif($isPastDeadline)
                                            <button type="button" class="btn btn-sm btn-bright-danger rounded-pill px-3 fw-bold shadow-sm" disabled>
                                                <i class="mdi mdi-eye-off me-1"></i> Deadline Terlewati
                                            </button>
                                        @else
                                            <a href="{{ route('siswa.tugas.form', $item->id) }}" class="btn btn-sm {{ $sudahKumpul ? 'btn-outline-success' : 'btn-warning' }} rounded-pill px-3 fw-bold shadow-sm">
                                                <i class="mdi {{ $sudahKumpul ? 'mdi-pencil' : 'mdi-cloud-upload' }} me-1"></i>
                                                {{ $sudahKumpul ? 'Edit' : 'Kumpulkan' }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                            <i class="mdi mdi-clipboard-text-outline display-3 text-muted"></i>
                                        </div>
                                        <h5 class="text-muted fw-bold">Belum ada tugas.</h5>
                                        <p class="text-muted small">Mata pelajaran ini belum memiliki tugas yang diberikan oleh guru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View (Bentuk Card Premium) -->
                <div class="d-md-none">
                    @forelse($tugas as $item)
                        @php
                            $pengumpulan = $item->pengumpulan->first();
                            $sudahKumpul = ($pengumpulan && !empty($pengumpulan->link_tugas)) ? true : false;
                            $isNotStarted = $item->waktu_mulai && \Carbon\Carbon::now()->isBefore($item->waktu_mulai);
                            $isPastDeadline = $item->deadline && \Carbon\Carbon::now()->isAfter($item->deadline);
                        @endphp
                        <div class="card mb-3 mobile-tugas-card border-0">
                            <div class="card-body p-3">
                                <!-- Top Area: Status Badge & Score -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    @if($isNotStarted)
                                        <span class="tugas-badge-belum-mulai d-inline-flex align-items-center gap-1">
                                            <i class="mdi mdi-clock-start" style="font-size: 0.85rem;"></i> BELUM DIMULAI
                                        </span>
                                    @elseif($sudahKumpul)
                                        <span class="tugas-badge-sudah d-inline-flex align-items-center gap-1">
                                            <i class="mdi mdi-check-circle" style="font-size: 0.85rem;"></i> SUDAH DIKUMPULKAN
                                        </span>
                                    @else
                                        <span class="tugas-badge-belum d-inline-flex align-items-center gap-1">
                                            <i class="mdi mdi-alert-circle" style="font-size: 0.85rem;"></i> BELUM DIKUMPULKAN
                                        </span>
                                    @endif
                                    
                                    @if($pengumpulan && $pengumpulan->nilai !== null)
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <small class="text-muted" style="font-size: 0.7rem;">Nilai:</small>
                                            <strong class="text-primary" style="font-size: 1.15rem;">{{ $pengumpulan->nilai }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <!-- Title -->
                                <h5 class="fw-bold text-dark mb-3 text-start" style="font-size: 1rem; line-height: 1.4; word-break: break-word; white-space: normal;">
                                    {{ $item->judul }}
                                </h5>

                                <!-- Dates Box -->
                                <div class="mb-3 p-2 bg-light rounded-3 text-start" style="font-size: 0.75rem;">
                                    @if($item->waktu_mulai)
                                        <div class="mb-1 d-flex align-items-center gap-1 text-dark">
                                            <i class="mdi mdi-calendar-play text-success"></i>
                                            <span>Mulai: <strong>{{ $item->waktu_mulai->format('d/m/Y H:i') }} WIB</strong></span>
                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center gap-1 text-dark">
                                        <i class="mdi mdi-calendar-clock text-danger"></i>
                                        <span>Batas Waktu: <strong>{{ $item->deadline ? $item->deadline->format('d/m/Y H:i') . ' WIB' : 'Tanpa batas waktu' }}</strong></span>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($item->deskripsi)
                                    <div class="mb-3 tugas-desc-box">
                                        <div class="d-flex align-items-center gap-1 mb-1 text-muted text-start" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.3px; text-transform: uppercase;">
                                            <i class="mdi mdi-information-outline"></i> Petunjuk Tugas
                                        </div>
                                        <p class="text-muted mb-0 text-start" style="font-size: 0.78rem; line-height: 1.5; white-space: normal;">
                                            {{ $item->deskripsi }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Actions Area -->
                                <div class="d-grid gap-2 pt-2 border-top mobile-tugas-card-divider">
                                    @if($item->file_path)
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-gradient-download-tugas rounded-pill py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.8rem;">
                                            <i class="mdi mdi-download" style="font-size: 1.05rem;"></i> UNDUH LAMPIRAN MATERI
                                        </a>
                                    @endif

                                    @if($isNotStarted)
                                        <button type="button" class="btn btn-secondary rounded-pill py-2 fw-bold d-flex align-items-center justify-content-center gap-2" style="font-size: 0.8rem;" disabled>
                                            <i class="mdi mdi-lock" style="font-size: 1.05rem;"></i> BELUM DIBUKA
                                        </button>
                                    @elseif($isPastDeadline)
                                        <button type="button" class="btn btn-bright-danger rounded-pill py-2 fw-bold d-flex align-items-center justify-content-center gap-2" style="font-size: 0.8rem;" disabled>
                                            <i class="mdi mdi-eye-off" style="font-size: 1.05rem;"></i> DEADLINE TERLEWATI
                                        </button>
                                    @else
                                        <a href="{{ route('siswa.tugas.form', $item->id) }}" class="btn {{ $sudahKumpul ? 'btn-gradient-edit-tugas' : 'btn-gradient-collect' }} rounded-pill py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.8rem;">
                                            <i class="mdi {{ $sudahKumpul ? 'mdi-pencil' : 'mdi-cloud-upload' }}" style="font-size: 1.05rem;"></i>
                                            {{ $sudahKumpul ? 'EDIT JAWABAN' : 'KUMPULKAN TUGAS' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                <i class="mdi mdi-clipboard-text-outline display-4 text-muted"></i>
                            </div>
                            <h6 class="text-muted fw-bold">Belum ada tugas.</h6>
                        </div>
                    @endforelse
                </div>

                <!-- Bottom Navigation (Mobile Only) -->
                <div class="d-flex justify-content-center d-md-none mt-4 pt-3 border-top mobile-tugas-card-divider">
                    <a href="{{ route('siswa.jadwal') }}" class="btn btn-back-premium rounded-pill px-5 py-2 fw-bold shadow-sm">
                        KEMBALI
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
