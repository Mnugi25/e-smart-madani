@extends('template.layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<style>
    .form-card {
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: #ffffff;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 22px 28px;
    }
    .input-group-custom .input-group-text {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-right: none;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        color: #64748b;
        padding: 0.65rem 0.95rem;
        transition: all 0.2s ease;
    }
    .input-group-custom .form-control,
    .input-group-custom .form-select {
        border: 1px solid #cbd5e1;
        border-left: none;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        padding: 0.65rem 0.95rem;
        font-size: 0.92rem;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .input-group-custom:focus-within .input-group-text {
        border-color: #3b82f6;
        background-color: #eff6ff;
        color: #2563eb;
    }
    .input-group-custom:focus-within .form-control,
    .input-group-custom:focus-within .form-select {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .form-label-custom {
        font-size: 0.84rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    /* Dark Mode Theme Support */
    html.dark-mode .form-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .form-card-header {
        background: linear-gradient(135deg, #18181b 0%, #1e1b4b 100%) !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .form-label-custom {
        color: #cbd5e1 !important;
    }
    html.dark-mode .input-group-custom .input-group-text {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    html.dark-mode .input-group-custom .form-control,
    html.dark-mode .input-group-custom .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark-mode .input-group-custom:focus-within .input-group-text {
        border-color: #60a5fa !important;
        background-color: #1e293b !important;
        color: #93c5fd !important;
    }
    html.dark-mode .input-group-custom:focus-within .form-control,
    html.dark-mode .input-group-custom:focus-within .form-select {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25) !important;
    }
</style>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="form-card mb-4">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-pencil-box-outline"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Ubah Data Kelas</h4>
                        <p class="text-muted small mb-0">Silakan perbarui data tingkat, nama kelas, atau jurusan di bawah ini.</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-4 p-md-4">
                <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Baris 1: Nama Kelas & Tingkat --}}
                        <div class="col-md-6">
                            <label for="nama_kelas" class="form-label-custom d-block">
                                Nama Kelas <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-home-variant"></i>
                                </span>
                                <input type="text" name="nama_kelas" id="nama_kelas" 
                                       value="{{ old('nama_kelas', $kelas->nama_kelas) }}" 
                                       class="form-control @error('nama_kelas') is-invalid @enderror" 
                                       placeholder="Contoh: XII RPL 1 atau XI TKJ 2" required>
                            </div>
                            @error('nama_kelas')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tingkat" class="form-label-custom d-block">
                                Tingkat / Jenjang <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-trending-up"></i>
                                </span>
                                <select name="tingkat" id="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Tingkat --</option>
                                    <option value="X" {{ (old('tingkat', $kelas->tingkat) == 'X') ? 'selected' : '' }}>Kelas X (Sepuluh)</option>
                                    <option value="XI" {{ (old('tingkat', $kelas->tingkat) == 'XI') ? 'selected' : '' }}>Kelas XI (Sebelas)</option>
                                    <option value="XII" {{ (old('tingkat', $kelas->tingkat) == 'XII') ? 'selected' : '' }}>Kelas XII (Dua Belas)</option>
                                </select>
                            </div>
                            @error('tingkat')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        {{-- Baris 2: Jurusan & Wali Kelas --}}
                        <div class="col-md-6">
                            <label for="jurusan_id" class="form-label-custom d-block">
                                Jurusan / Program Keahlian <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-tag-outline"></i>
                                </span>
                                <select name="jurusan_id" id="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Jurusan Terkait --</option>
                                    @foreach($jurusan as $jrg)
                                        <option value="{{ $jrg->id }}" {{ (old('jurusan_id', $kelas->jurusan_id) == $jrg->id) ? 'selected' : '' }}>
                                            {{ $jrg->nama_jurusan }} ({{ $jrg->kode_jurusan }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('jurusan_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="wali_kelas_id" class="form-label-custom d-block">
                                Wali Kelas <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-tie"></i>
                                </span>
                                <select name="wali_kelas_id" id="wali_kelas_id" class="form-select @error('wali_kelas_id') is-invalid @enderror">
                                    <option value="">-- Pilih Wali Kelas (Tidak Ada) --</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}" {{ (old('wali_kelas_id', $kelas->wali_kelas_id) == $g->id) ? 'selected' : '' }}>
                                            {{ $g->nama_lengkap }} ({{ $g->jabatan ?? 'GURU' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('wali_kelas_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="/admin/master/kelas" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
