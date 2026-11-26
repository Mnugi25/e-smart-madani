@extends('template.layouts.app')

@section('title', 'Unggah Modul Baru')

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
        border: 1.5px solid #cbd5e1;
        border-right: none;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        color: #64748b;
        padding: 0.65rem 0.95rem;
        transition: all 0.2s ease;
    }
    .input-group-custom .form-control,
    .input-group-custom .form-select {
        border: 1.5px solid #cbd5e1;
        border-left: none;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        padding: 0.65rem 0.95rem !important;
        font-size: 0.92rem !important;
        color: #1e293b !important;
        height: 44px !important;
        line-height: 1.5 !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease;
    }
    .input-group-custom textarea.form-control {
        height: auto !important;
        min-height: 80px;
    }
    .input-group-custom:focus-within .input-group-text {
        border-color: #3b82f6;
        background-color: #eff6ff;
        color: #2563eb;
    }
    .input-group-custom:focus-within .form-control,
    .input-group-custom:focus-within .form-select {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .form-label-custom {
        font-size: 0.84rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .tips-card {
        border-radius: 16px;
        border: 1px solid rgba(245, 158, 11, 0.25);
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.45) 0%, rgba(255, 251, 235, 0.9) 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.06);
    }

    /* Dark Mode Support */
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
    html.dark-mode .tips-card {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.9) 100%) !important;
        border-color: rgba(245, 158, 11, 0.3) !important;
    }
    html.dark-mode .tips-card .card-text {
        color: #cbd5e1 !important;
    }
</style>

<div class="row">
    {{-- Main Form (Col-8) --}}
    <div class="col-lg-8 mb-4">
        <div class="form-card">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-book-plus-multiple"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="font-size: 1.15rem; color: #0f172a;">Unggah Modul Baru</h4>
                        <p class="text-muted small mb-0">Lengkapi formulir di bawah ini untuk membagikan materi modul pembelajaran kepada siswa.</p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <form action="{{ route('guru.modul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Judul Modul --}}
                    <div class="mb-4">
                        <label for="judul" class="form-label-custom d-block">
                            Judul Modul <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-format-title"></i>
                            </span>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul') }}" 
                                   placeholder="Contoh: Modul 1 - Struktur Algoritma Pemrograman" required>
                        </div>
                        @error('judul')
                            <small class="text-danger d-block mt-1 fw-bold">
                                <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Mata Pelajaran & Kelas --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="mata_pelajaran_id" class="form-label-custom d-block">
                                Mata Pelajaran <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-book-open-page-variant"></i>
                                </span>
                                <select class="form-select @error('mata_pelajaran_id') is-invalid @enderror" 
                                        id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    <option value="" selected disabled>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mataPelajarans ?? [] as $mapel)
                                        <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('mata_pelajaran_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label-custom d-block">
                                Kelas <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-google-classroom"></i>
                                </span>
                                <select class="form-select @error('kelas_id') is-invalid @enderror" 
                                        id="kelas_id" name="kelas_id">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($kelases ?? [] as $kelas)
                                        <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">
                                Kosongkan jika modul ini berlaku untuk semua kelas.
                            </small>
                            @error('kelas_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- File Modul --}}
                    <div class="mb-4">
                        <label for="file_modul" class="form-label-custom d-block">
                            File Modul <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-file-upload-outline"></i>
                            </span>
                            <input type="file" class="form-control @error('file_modul') is-invalid @enderror" 
                                   id="file_modul" name="file_modul" 
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar" required>
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.78rem;">
                            <i class="mdi mdi-information-outline me-1"></i>Format yang diizinkan: <strong>PDF, DOCX, PPTX, ZIP, RAR</strong>. Maksimal ukuran file: <strong>10MB</strong>.
                        </small>
                        @error('file_modul')
                            <small class="text-danger d-block mt-1 fw-bold">
                                <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Deskripsi Modul (Opsional) --}}
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label-custom d-block">
                            Deskripsi Singkat <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text align-items-start pt-2">
                                <i class="mdi mdi-text-box-outline"></i>
                            </span>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="3" 
                                      placeholder="Ringkasan materi atau instruksi pengerjaan tugas modul...">{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')
                            <small class="text-danger d-block mt-1 fw-bold">
                                <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('guru.modul.index') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Modul
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tips Sidebar (Col-4) --}}
    <div class="col-lg-4 mb-4">
        <div class="card tips-card p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge bg-warning text-dark fw-bold rounded-pill px-2.5 py-1">
                    <i class="mdi mdi-lightbulb-on me-1"></i> TIPS
                </span>
                <h5 class="fw-bold mb-0 text-dark" style="font-size: 1rem;">Panduan Pengunggahan</h5>
            </div>
            
            <p class="card-text text-muted mb-3" style="font-size: 0.88rem; line-height: 1.5;">
                Pastikan Modul yang Anda unggah mudah dibaca oleh siswa di berbagai perangkat. Format <strong>PDF</strong> sangat disarankan agar dokumen tidak berubah bentuk atau berantakan saat dibuka melalui smartphone maupun laptop.
            </p>
            
            <div class="p-3 rounded-3 mb-3" style="background: rgba(255, 255, 255, 0.65); border: 1px dashed rgba(245, 158, 11, 0.4);">
                <div class="d-flex align-items-center text-dark fw-bold small mb-1">
                    <i class="mdi mdi-file-multiple text-warning me-1.5"></i> Banyak Berkas?
                </div>
                <small class="text-muted d-block" style="font-size: 0.8rem; line-height: 1.4;">
                    Jika ada beberapa file pendukung (misal: slide presentasi + lembar kerja), gabungkan menjadi satu arsip format <strong>.ZIP</strong> atau <strong>.RAR</strong>.
                </small>
            </div>

            <div class="text-muted small" style="font-size: 0.78rem;">
                <i class="mdi mdi-shield-check text-success me-1"></i> File disimpan secara aman di cloud storage E-Learning.
            </div>
        </div>
    </div>
</div>
@endsection
