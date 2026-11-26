@extends('template.layouts.app')

@section('title', 'Edit Jadwal Ujian')

@section('content')
@php
    $judul = $ujian->judul;
    $jenis_terdeteksi = 'Ulangan Harian';
    $topik = $judul;
    
    $options_jenis = ['Ulangan Harian', 'Ujian Tengah Semester (UTS)', 'Ujian Akhir Semester (UAS)'];
    foreach($options_jenis as $option) {
        if(strpos($judul, $option . ': ') === 0) {
            $jenis_terdeteksi = $option;
            $topik = substr($judul, strlen($option . ': '));
            break;
        }
    }
@endphp
<style>
    /* Modern Back Button */
    .btn-back-modern {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-back-modern:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .btn-back-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    /* Modern Form Card */
    .form-card-modern {
        border: 1px solid #e2e8f0 !important;
        border-radius: 18px !important;
        background: #ffffff !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
    }
    .form-section-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }
    .form-control-modern {
        height: 46px;
        border-radius: 12px !important;
        border: 1.5px solid #cbd5e1;
        font-size: 0.9rem;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }
    .form-control-modern:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
    }

    /* Dark Mode Overrides */
    html.dark-mode .btn-back-modern {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .form-card-modern {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .form-section-label {
        color: #a1a1aa !important;
    }
    html.dark-mode .form-control-modern {
        background-color: #121215 !important;
        border-color: #3f3f46 !important;
        color: #f4f4f5 !important;
    }
</style>

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('guru.ujian.index') }}" class="btn-back-modern">
            <div class="btn-back-icon">
                <i class="mdi mdi-arrow-left"></i>
            </div>
            <span>Kembali ke Manajemen Ujian</span>
        </a>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card form-card-modern">
            <div class="card-body p-4 p-md-5">
                {{-- Header --}}
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-3 p-2.5 bg-warning-subtle text-warning me-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px;">
                        <i class="mdi mdi-pencil fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Edit Jadwal Ujian</h4>
                        <p class="text-muted small mb-0">Perbarui informasi jadwal, target kelas, durasi, atau status ujian.</p>
                    </div>
                </div>

                {{-- Alert Error --}}
                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <ul class="mb-0 small ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('guru.ujian.update', $ujian->id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    {{-- Row 1: Mapel & Kelas --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-section-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select name="mapel_id" class="form-select form-control-modern" required>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" {{ $ujian->mapel_id == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-section-label">Target Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-select form-control-modern" required>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $ujian->kelas_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Row 2: Jenis & Topik --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-section-label">Jenis Evaluasi <span class="text-danger">*</span></label>
                            <select id="jenis_ujian" class="form-select form-control-modern" required>
                                @foreach($options_jenis as $option)
                                    <option value="{{ $option }}" {{ $jenis_terdeteksi == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-7">
                            <label class="form-section-label">Topik / Materi Ujian <span class="text-danger">*</span></label>
                            <input type="text" id="topik_ujian" class="form-control form-control-modern" value="{{ $topik }}" required>
                            <input type="hidden" name="judul" id="judul_gabungan" value="{{ $ujian->judul }}">
                        </div>
                    </div>

                    {{-- Row 3: Semester & Durasi --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-section-label">Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-select form-control-modern" required>
                                <option value="Ganjil" {{ $ujian->semester == 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                                <option value="Genap" {{ $ujian->semester == 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-section-label">Durasi Waktu <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="durasi" class="form-control form-control-modern" value="{{ $ujian->durasi }}" min="1" required style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
                                <span class="input-group-text bg-light text-muted px-3" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px; border: 1.5px solid #cbd5e1; border-left: none;">Menit</span>
                            </div>
                        </div>
                    </div>

                    {{-- Row 4: Tanggal, Jam, Status --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-section-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control form-control-modern" value="{{ $ujian->waktu_mulai->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-section-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="jam" class="form-control form-control-modern" value="{{ $ujian->waktu_mulai->format('H:i') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-section-label">Status Ujian <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-control-modern" required>
                                <option value="Draft" {{ $ujian->status == 'Draft' ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                                <option value="Aktif" {{ $ujian->status == 'Aktif' ? 'selected' : '' }}>Aktif (Dapat Dikerjakan)</option>
                                <option value="Selesai" {{ $ujian->status == 'Selesai' ? 'selected' : '' }}>Selesai (Ditutup)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Form Footer Actions --}}
                    <div class="d-flex align-items-center gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary text-white rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                            <i class="mdi mdi-content-save-outline me-1"></i> Perbarui Ujian
                        </button>
                        <a href="{{ route('guru.ujian.index') }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold border text-muted">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const jenisUjian = document.getElementById('jenis_ujian');
    const topikUjian = document.getElementById('topik_ujian');
    const judulGabungan = document.getElementById('judul_gabungan');
    
    function updateJudul() {
        if (topikUjian.value.trim() !== '') {
            judulGabungan.value = jenisUjian.value + ": " + topikUjian.value.trim();
        } else {
            judulGabungan.value = jenisUjian.value;
        }
    }
    
    if (jenisUjian && topikUjian && judulGabungan) {
        jenisUjian.addEventListener('change', updateJudul);
        topikUjian.addEventListener('input', updateJudul);
    }
});
</script>
@endpush
@endsection
