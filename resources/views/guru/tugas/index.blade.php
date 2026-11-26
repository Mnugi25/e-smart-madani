@extends('template.layouts.app')

@section('title', 'Ruang Tugas')

@section('content')
<style>
    .tugas-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        border-left: 5px solid #ffc107;
    }
    .tugas-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .btn-create {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        color: #fff;
        border: none;
    }
    .btn-create:hover {
        background: linear-gradient(135deg, #218838 0%, #28a745 100%);
        color: #fff;
    }
    .task-icon {
        font-size: 2.5rem;
        color: #ffc107;
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
    .btn-create-tugas {
        width: auto;
    }
    @media (max-width: 576px) {
        .btn-create-tugas {
            width: 100% !important;
        }
    }
</style>

<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="mdi mdi-clipboard-text-outline text-warning me-2"></i>Ruang Tugas
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

    <div class="col-lg-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <div class="mb-3 mb-sm-0">
                        <h4 class="fw-bold text-dark mb-0">Kelola Penugasan Siswa</h4>
                        <p class="text-muted small mb-0">Berikan latihan atau proyek untuk mengevaluasi pemahaman siswa.</p>
                    </div>
                    <button type="button" class="btn btn-create rounded-pill px-4 fw-bold shadow-sm btn-create-tugas d-flex justify-content-center align-items-center" style="height: 42px;" data-bs-toggle="modal" data-bs-target="#modalTugas">
                        <i class="mdi mdi-plus-circle me-2"></i> BUAT TUGAS BARU
                    </button>
                </div>

                {{-- Desktop View --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start">No</th>
                                <th class="border-0">Informasi Tugas</th>
                                <th class="border-0">Waktu Mulai</th>
                                <th class="border-0">Batas Waktu (Deadline)</th>
                                <th class="border-0 text-center">File</th>
                                <th class="border-0 text-center">Pengumpulan</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $index => $item)
                                <tr class="align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $item->judul }}</div>
                                        <p class="text-muted small mb-0" style="max-width: 400px; white-space: normal;">
                                            {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                                        </p>
                                    </td>
                                    <td>
                                        @if($item->waktu_mulai)
                                            <div class="small text-dark fw-bold">
                                                <i class="mdi mdi-calendar-play text-success me-1"></i>
                                                {{ $item->waktu_mulai->format('d/m/Y') }}
                                            </div>
                                            <div class="small text-muted"><i class="mdi mdi-clock-outline me-1"></i>Jam: {{ $item->waktu_mulai->format('H:i') }} WIB</div>
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
                                            <div class="small text-muted"><i class="mdi mdi-clock-outline me-1"></i>Jam: {{ $item->deadline->format('H:i') }} WIB</div>
                                        @else
                                            <span class="text-muted small">Tanpa batas waktu</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->file_path)
                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill shadow-sm" title="Download File Tugas">
                                                <i class="mdi mdi-file-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('guru.tugas.pengumpulan', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">
                                            Lihat Pengumpulan
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-sm btn-warning text-white rounded-circle" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <form action="{{ route('guru.tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger text-white rounded-circle" title="Hapus">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                            <i class="mdi mdi-clipboard-text-outline display-3 text-muted"></i>
                                        </div>
                                        <h5 class="text-muted fw-bold">Belum ada tugas yang dibuat.</h5>
                                        <p class="text-muted small">Klik tombol "Buat Tugas Baru" untuk mulai memberikan tugas kepada siswa.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View --}}
                <div class="d-md-none">
                    @forelse($tugas as $item)
                        <div class="card bg-white border mb-3 p-3 rounded-3 shadow-xs" style="border: 1px solid rgba(0,0,0,0.06) !important; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="pe-2 overflow-hidden text-start">
                                    <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.95rem; line-height: 1.3;">{{ $item->judul }}</h6>
                                    @if($item->deskripsi)
                                        <p class="text-muted mb-0" style="font-size: 0.75rem; white-space: normal; word-break: break-word;">
                                            {{ Str::limit($item->deskripsi, 100) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="my-2 py-2 border-top border-bottom text-start" style="border-top-style: dashed !important; border-bottom-style: dashed !important; border-color: #e2e8f0 !important;">
                                <div class="d-flex flex-column gap-1 text-muted" style="font-size: 0.75rem;">
                                    <div>
                                        <span class="fw-bold text-success"><i class="mdi mdi-calendar-play me-1"></i>Mulai:</span>
                                        @if($item->waktu_mulai)
                                            {{ $item->waktu_mulai->format('d/m/Y H:i') }} WIB
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div>
                                        <span class="fw-bold text-danger"><i class="mdi mdi-calendar-clock me-1"></i>Batas:</span>
                                        @if($item->deadline)
                                            {{ $item->deadline->format('d/m/Y H:i') }} WIB
                                        @else
                                            Tanpa batas waktu
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 d-flex flex-wrap gap-2 justify-content-start mt-2">
                                <a href="{{ route('guru.tugas.pengumpulan', $item->id) }}" class="btn btn-xs btn-outline-warning d-inline-flex align-items-center gap-1 py-1.5 px-3 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                    <i class="mdi mdi-clipboard-text-outline"></i> Lihat Pengumpulan
                                </a>
                                @if($item->file_path)
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-xs btn-outline-info d-inline-flex align-items-center gap-1 py-1.5 px-3 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                        <i class="mdi mdi-file-download"></i> Unduh Berkas
                                    </a>
                                @endif
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-sm btn-warning text-white w-100 justify-content-center py-2 px-1 rounded-3 d-inline-flex align-items-center shadow-xs" style="font-size: 0.75rem; font-weight: 600; gap: 4px;" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="ti-pencil"></i> Edit
                                    </button>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('guru.tugas.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white w-100 justify-content-center py-2 px-1 rounded-3 d-inline-flex align-items-center shadow-xs" style="font-size: 0.75rem; font-weight: 600; gap: 4px;">
                                            <i class="ti-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-clipboard-text-outline display-3 text-muted opacity-50 mb-2"></i>
                            <p class="small">Belum ada tugas yang dibuat.</p>
                        </div>
                    @endforelse
                </div>

                {{-- MODAL EDIT --}}
                @foreach($tugas as $item)
                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-dark"><i class="mdi mdi-pencil text-warning me-2"></i>Edit Tugas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('guru.tugas.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Judul Tugas</label>
                                            <input type="text" name="judul" class="form-control border-0 bg-light rounded-3 py-2" value="{{ $item->judul }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control border-0 bg-light rounded-3 py-2" rows="4">{{ $item->deskripsi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Waktu Mulai</label>
                                            <input type="datetime-local" name="waktu_mulai" class="form-control border-0 bg-light rounded-3 py-2" value="{{ $item->waktu_mulai ? $item->waktu_mulai->format('Y-m-d\TH:i') : '' }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Batas Waktu / Deadline</label>
                                            <input type="datetime-local" name="deadline" class="form-control border-0 bg-light rounded-3 py-2" value="{{ $item->deadline ? $item->deadline->format('Y-m-d\TH:i') : '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Ganti File (Opsional)</label>
                                            <input type="file" name="file_tugas" class="form-control border-0 bg-light rounded-3 py-2">
                                            @if($item->file_name)
                                                <small class="text-muted d-block mt-1">File saat ini: <strong>{{ $item->file_name }}</strong></small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0 p-4">
                                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">BATAL</button>
                                        <button type="submit" class="btn btn-warning text-white rounded-pill px-4 fw-bold shadow-sm">SIMPAN PERUBAHAN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- MODAL BUAT TUGAS --}}
<div class="modal fade" id="modalTugas" tabindex="-1" aria-labelledby="modalTugasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="modalTugasLabel"><i class="mdi mdi-plus-circle text-warning me-2"></i>Buat Tugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('guru.tugas.store', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Judul Tugas</label>
                        <input type="text" name="judul" class="form-control border-0 bg-light rounded-3 py-2" placeholder="Contoh: Latihan 1 - Struktur Atom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi / Instruksi</label>
                        <textarea name="deskripsi" class="form-control border-0 bg-light rounded-3 py-2" rows="4" placeholder="Berikan instruksi detail pengerjaan tugas..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Waktu Mulai (Tanggal & Jam)</label>
                        <input type="datetime-local" name="waktu_mulai" class="form-control border-0 bg-light rounded-3 py-2" required>
                        <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">
                            <i class="mdi mdi-clock-outline me-1"></i>Pilih tanggal dan jam mulai.
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Batas Waktu / Deadline (Tanggal & Jam)</label>
                        <input type="datetime-local" name="deadline" class="form-control border-0 bg-light rounded-3 py-2">
                        <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">
                            <i class="mdi mdi-information-outline me-1"></i>Kosongkan jika tidak ada batas waktu.
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">File Tugas (Opsional)</label>
                        <input type="file" name="file_tugas" class="form-control border-0 bg-light rounded-3 py-2">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 p-4">
                    <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-create rounded-pill px-4 fw-bold shadow-sm">SIMPAN TUGAS</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection