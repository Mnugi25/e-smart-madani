@extends('template.layouts.app')

@section('title', 'Susun RPP AI')

@push('styles')
<style>
    .form-card {
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: #ffffff;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .form-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 24px;
    }
    .form-card-body {
        padding: 24px;
        flex: 1 1 auto;
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

    /* P3 Chips Grid */
    .p3-chips-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 6px;
    }
    .p3-chip-label {
        margin: 0;
        cursor: pointer;
        user-select: none;
    }
    .p3-chip-content {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        transition: all 0.2s ease;
    }
    .p3-chip-label input:checked + .p3-chip-content {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(29, 78, 216, 0.08) 100%);
        border-color: #2563eb;
        color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);
    }
    .p3-chip-label:hover .p3-chip-content {
        border-color: #93c5fd;
        background-color: #eff6ff;
    }

    /* Generate Button */
    .btn-gradient-generate {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        border: none !important;
        border-radius: 12px !important;
        font-weight: 700 !important;
        padding: 13px 20px !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25) !important;
        transition: all 0.25s ease !important;
    }
    .btn-gradient-generate:hover:not(:disabled) {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35) !important;
    }
    .btn-gradient-generate:disabled {
        opacity: 0.75;
        cursor: not-allowed;
    }

    /* Skeleton Loader */
    .skeleton-box {
        background: #ffffff;
        border: 1.5px dashed #cbd5e1;
        border-radius: 14px;
        padding: 32px;
        min-height: 600px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .loading-pulse-spinner {
        width: 52px;
        height: 52px;
        border: 4px solid rgba(37, 99, 235, 0.12);
        border-top-color: #2563eb;
        border-right-color: #1d4ed8;
        border-radius: 50%;
        animation: spin 0.9s linear infinite;
        margin-bottom: 16px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .skeleton-line {
        width: 80%;
        height: 14px;
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
        margin-bottom: 12px;
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* TinyMCE Overrides */
    .tox-tinymce {
        border-radius: 12px !important;
        border: 1.5px solid #cbd5e1 !important;
        overflow: hidden;
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

    /* Dark Mode Overrides */
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
    html.dark-mode .p3-chip-content {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    html.dark-mode .p3-chip-label:hover .p3-chip-content {
        border-color: #3b82f6 !important;
        background-color: #172554 !important;
        color: #60a5fa !important;
    }
    html.dark-mode .p3-chip-label input:checked + .p3-chip-content {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.2) 0%, rgba(29, 78, 216, 0.2) 100%) !important;
        border-color: #3b82f6 !important;
        color: #93c5fd !important;
    }
    html.dark-mode .skeleton-box {
        background: #18181b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .skeleton-line {
        background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%) !important;
        background-size: 200% 100% !important;
    }
    html.dark-mode .tox-tinymce {
        border-color: #334155 !important;
        background-color: #0f172a !important;
    }
    html.dark-mode .tox-toolbar, 
    html.dark-mode .tox-toolbar__primary {
        background-color: #18181b !important;
        border-bottom: 1px solid #27272a !important;
    }
    html.dark-mode .tox-tbtn {
        color: #e2e8f0 !important;
    }
    html.dark-mode .tox-tbtn svg {
        fill: #e2e8f0 !important;
    }
    html.dark-mode .tox-tbtn:hover {
        background-color: #27272a !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    {{-- Header Section --}}
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h4 class="fw-bold mb-1" style="font-size: 1.25rem; color: #0f172a;">
                    <i class="mdi mdi-robot text-primary me-2"></i>Susun RPP AI Kurikulum Merdeka
                </h4>
                <p class="text-muted small mb-0">Rancang dokumen Modul Ajar RPP secara otomatis menggunakan integrasi AI Gemini.</p>
            </div>
            <a href="{{ route('guru.rpp.index') }}" class="btn-back-modern">
                <div class="btn-back-icon">
                    <i class="mdi mdi-arrow-left"></i>
                </div>
                <span>Kembali ke Data RPP</span>
            </a>
        </div>
    </div>

    {{-- Panel Kiri: Form Parameter RPP (Col-5) --}}
    <div class="col-lg-5 mb-4">
        <div class="form-card">
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 42px; height: 42px; font-size: 1.3rem;">
                        <i class="mdi mdi-tune-variant"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">Parameter Modul Ajar</h5>
                        <p class="text-muted small mb-0">Tentukan capaian dan target belajar</p>
                    </div>
                </div>
            </div>

            <div class="form-card-body">
                <form id="ai-form">
                    @csrf

                    {{-- Mata Pelajaran --}}
                    <div class="mb-3">
                        <label for="mata_pelajaran_id" class="form-label-custom d-block">
                            Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-book-open-page-variant"></i>
                            </span>
                            <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Mata Pelajaran --</option>
                                @foreach($mataPelajarans as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Kelas & Fase --}}
                    <div class="row g-2 mb-3">
                        <div class="col-sm-7">
                            <label for="kelas_id" class="form-label-custom d-block">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-google-classroom"></i>
                                </span>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                    @foreach($kelases as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <label for="fase" class="form-label-custom d-block">
                                Fase <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-tag-outline"></i>
                                </span>
                                <select name="fase" id="fase" class="form-select">
                                    <option value="">Fase...</option>
                                    <option value="Fase E" selected>Fase E (X)</option>
                                    <option value="Fase F">Fase F (XI/XII)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Topik / Materi Pokok --}}
                    <div class="mb-3">
                        <label for="topik" class="form-label-custom d-block">
                            Topik / Materi Pokok <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-text-box-search-outline"></i>
                            </span>
                            <input type="text" name="topik" id="topik" class="form-control" 
                                   placeholder="Contoh: Teks Laporan Hasil Observasi" required>
                        </div>
                    </div>

                    {{-- Alokasi Waktu --}}
                    <div class="mb-3">
                        <label for="alokasi_waktu" class="form-label-custom d-block">
                            Alokasi Waktu <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-clock-outline"></i>
                            </span>
                            <input type="text" name="alokasi_waktu" id="alokasi_waktu" class="form-control" 
                                   placeholder="Contoh: 2 x 45 Menit (1 Pertemuan)" value="2 x 45 Menit" required>
                        </div>
                    </div>

                    {{-- Model Pembelajaran --}}
                    <div class="mb-3">
                        <label for="model_pembelajaran" class="form-label-custom d-block">
                            Model Pembelajaran <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-shape-outline"></i>
                            </span>
                            <select name="model_pembelajaran" id="model_pembelajaran" class="form-select">
                                <option value="Problem Based Learning (PBL)" selected>Problem Based Learning (PBL)</option>
                                <option value="Project Based Learning (PjBL)">Project Based Learning (PjBL)</option>
                                <option value="Discovery Learning">Discovery Learning</option>
                                <option value="Inquiry Learning">Inquiry Learning</option>
                                <option value="Diskusi & Kolaborasi Kelompok">Diskusi & Kolaborasi Kelompok</option>
                                <option value="Teaching Factory (TEFA)">Teaching Factory (TEFA)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Profil Pelajar Pancasila (P3) --}}
                    <div class="mb-4">
                        <label class="form-label-custom d-block mb-1">
                            Profil Pelajar Pancasila (P3)
                        </label>
                        <small class="text-muted d-block mb-2" style="font-size: 0.78rem;">Pilih dimensi karakter yang diasah:</small>
                        <div class="p3-chips-grid">
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" value="Beriman & Bertakwa kepada Tuhan YME">
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-heart-outline text-danger"></i>
                                    <span>Beriman & Takwa</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" value="Berkebinekaan Global">
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-earth text-primary"></i>
                                    <span>Kebinekaan Global</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" value="Gotong Royong" checked>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-account-group-outline text-success"></i>
                                    <span>Gotong Royong</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" value="Mandiri">
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-account-outline text-info"></i>
                                    <span>Mandiri</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" value="Bernalar Kritis" checked>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-brain text-warning"></i>
                                    <span>Bernalar Kritis</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" value="Kreatif" checked>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-lightbulb-on-outline text-primary"></i>
                                    <span>Kreatif</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Tombol Generate --}}
                    <button type="button" id="btn-generate" class="btn btn-primary w-100 btn-gradient-generate d-flex align-items-center justify-content-center gap-2">
                        <i class="mdi mdi-creation fs-5"></i>
                        <span id="btn-generate-text">Generate Dokumen RPP AI</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Panel Kanan: Lembar Kerja Editor RPP (Col-7) --}}
    <div class="col-lg-7 mb-4">
        <div class="form-card">
            <div class="form-card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 42px; height: 42px; font-size: 1.3rem;">
                        <i class="mdi mdi-file-document-edit-outline"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">Lembar Kerja Dokumen RPP</h5>
                        <p class="text-muted small mb-0">Pratinjau, sesuaikan, dan cetak dokumen RPP Anda</p>
                    </div>
                </div>
                <div id="status-badge-container">
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.75rem;" id="rpp-status-badge">
                        <i class="mdi mdi-circle-outline me-1"></i> Belum Dibuat
                    </span>
                </div>
            </div>

            <div class="form-card-body d-flex flex-column">
                {{-- Skeleton Loader Area (Sembunyi by default) --}}
                <div id="loading-area" class="skeleton-box" style="display: none;">
                    <div class="loading-pulse-spinner"></div>
                    <h6 class="fw-bold text-primary mb-1">Merumuskan Dokumen RPP...</h6>
                    <p class="text-muted small mb-4 text-center">Kecerdasan Buatan Gemini sedang menyusun modul ajar Kurikulum Merdeka yang terstruktur.</p>
                    
                    <div class="skeleton-line" style="width: 50%; height: 20px;"></div>
                    <div class="skeleton-line" style="width: 90%;"></div>
                    <div class="skeleton-line" style="width: 85%;"></div>
                    <div class="skeleton-line" style="width: 70%;"></div>
                    <div class="skeleton-line mt-3" style="width: 40%; height: 18px;"></div>
                    <div class="skeleton-line" style="width: 95%;"></div>
                    <div class="skeleton-line" style="width: 80%;"></div>
                </div>

                {{-- TinyMCE Editor Wrapper --}}
                <div id="editor-wrapper" style="flex: 1 1 auto;">
                    <textarea id="rpp-editor"></textarea>
                </div>

                {{-- Action Bar Bawah Editor (Sembunyi by default sebelum generate) --}}
                <div id="action-area" class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="display: none !important;">
                    <button type="button" id="btn-export-pdf" class="btn btn-outline-danger fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                        <i class="mdi mdi-printer me-1.5"></i> Cetak / Export PDF
                    </button>
                    <button type="button" id="btn-save" class="btn btn-success text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                        <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan ke Database
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let isContentGenerated = false;

        function updateEditorTheme(editor) {
            if (!editor) return;
            const isDark = document.documentElement.classList.contains('dark-mode');
            const doc = editor.getDoc();
            if (doc && doc.body) {
                if (isDark) {
                    doc.body.style.backgroundColor = '#18181b';
                    doc.body.style.color = '#e4e4e7';
                } else {
                    doc.body.style.backgroundColor = '#ffffff';
                    doc.body.style.color = '#1e293b';
                }
            }
        }

        // Init TinyMCE Editor
        tinymce.init({
            selector: '#rpp-editor',
            height: 620,
            menubar: false,
            statusbar: false,
            plugins: 'lists link table code help wordcount',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | removeformat | code',
            content_style: `
                body {
                    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    font-size: 14px;
                    line-height: 1.6;
                    padding: 24px;
                    color: #1e293b;
                }
                table { width: 100%; border-collapse: collapse; margin: 14px 0; }
                th, td { border: 1px solid #cbd5e1; padding: 8px 12px; }
                th { background-color: #f8fafc; font-weight: 700; }
                h1, h2, h3, h4, h5 { color: #0f172a; margin-top: 18px; margin-bottom: 8px; }
                ul, ol { padding-left: 20px; }
            `,
            setup: function (editor) {
                editor.on('init', function () {
                    const emptyState = `
                        <div style="text-align: center; color: #94a3b8; padding: 120px 20px; user-select: none;">
                            <div style="font-size: 3.5rem; margin-bottom: 12px;">✨</div>
                            <h4 style="color: #475569; font-weight: 700; margin-bottom: 6px;">Siap Menyusun RPP AI</h4>
                            <p style="font-size: 0.88rem; max-width: 420px; margin: 0 auto; line-height: 1.5;">
                                Lengkapi parameter di panel sebelah kiri, kemudian klik tombol <strong>Generate Dokumen RPP AI</strong> untuk membuat draf secara instan.
                            </p>
                        </div>
                    `;
                    editor.setContent(emptyState);
                    updateEditorTheme(editor);
                });
            }
        });

        // Dark mode observer
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "class") {
                    const editor = tinymce.get('rpp-editor');
                    if (editor) {
                        updateEditorTheme(editor);
                    }
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });

        const btnGenerate = document.getElementById('btn-generate');
        const btnGenerateText = document.getElementById('btn-generate-text');
        const loadingArea = document.getElementById('loading-area');
        const editorWrapper = document.getElementById('editor-wrapper');
        const actionArea = document.getElementById('action-area');
        const rppStatusBadge = document.getElementById('rpp-status-badge');
        const btnSave = document.getElementById('btn-save');
        const btnExportPdf = document.getElementById('btn-export-pdf');

        // Klik Generate AI
        btnGenerate.addEventListener('click', function() {
            const mapel = document.getElementById('mata_pelajaran_id');
            const kelas = document.getElementById('kelas_id');
            const topik = document.getElementById('topik').value.trim();
            const alokasi = document.getElementById('alokasi_waktu').value.trim();
            const faseText = document.getElementById('fase').value;
            const modelPelajaran = document.getElementById('model_pembelajaran').value;

            if(!mapel.value || !kelas.value || !topik || !alokasi) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Parameter Belum Lengkap',
                    text: 'Harap lengkapi Mata Pelajaran, Kelas, Topik, dan Alokasi Waktu terlebih dahulu!',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            const mapelText = mapel.options[mapel.selectedIndex].text;
            const kelasText = kelas.options[kelas.selectedIndex].text;

            let p3 = [];
            document.querySelectorAll('.p3-checkbox:checked').forEach(cb => {
                p3.push(cb.value);
            });

            // Set loading state UI
            btnGenerate.disabled = true;
            btnGenerateText.textContent = 'Menyusun RPP via AI...';
            editorWrapper.style.display = 'none';
            actionArea.style.setProperty('display', 'none', 'important');
            loadingArea.style.display = 'flex';
            rppStatusBadge.className = 'badge bg-warning-subtle text-warning rounded-pill px-3 py-1.5 fw-bold';
            rppStatusBadge.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Sedang Diproses...';

            fetch("{{ route('guru.rpp.generate-ai') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    mata_pelajaran: mapelText,
                    kelas_fase: kelasText + (faseText ? ' - ' + faseText : ''),
                    topik: topik,
                    alokasi_waktu: alokasi,
                    model_pembelajaran: modelPelajaran,
                    profil_pelajar_pancasila: p3
                })
            })
            .then(res => res.json())
            .then(data => {
                loadingArea.style.display = 'none';
                editorWrapper.style.display = 'block';
                btnGenerate.disabled = false;
                btnGenerateText.textContent = 'Generate Ulang RPP AI';

                if(data.status === 'success') {
                    tinymce.get('rpp-editor').setContent(data.konten);
                    actionArea.style.setProperty('display', 'flex', 'important');
                    rppStatusBadge.className = 'badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-bold';
                    rppStatusBadge.innerHTML = '<i class="mdi mdi-check-circle-outline me-1"></i> Siap Disimpan';
                    isContentGenerated = true;

                    Swal.fire({
                        icon: 'success',
                        title: 'RPP Berhasil Disusun!',
                        text: 'Dokumen RPP Kurikulum Merdeka telah berhasil dibuat. Anda dapat menyuntingnya sebelum menyimpan.',
                        confirmButtonColor: '#2563eb',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    rppStatusBadge.className = 'badge bg-danger-subtle text-danger rounded-pill px-3 py-1.5 fw-bold';
                    rppStatusBadge.innerHTML = '<i class="mdi mdi-alert-circle-outline me-1"></i> Gagal Diproses';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyusun RPP',
                        text: data.message || 'Terjadi kesalahan saat memproses via Gemini AI.',
                        confirmButtonColor: '#2563eb'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                loadingArea.style.display = 'none';
                editorWrapper.style.display = 'block';
                btnGenerate.disabled = false;
                btnGenerateText.textContent = 'Generate Dokumen RPP AI';
                rppStatusBadge.className = 'badge bg-danger-subtle text-danger rounded-pill px-3 py-1.5 fw-bold';
                rppStatusBadge.innerHTML = '<i class="mdi mdi-alert-circle-outline me-1"></i> Error Server';

                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Tidak dapat terhubung ke server atau API Gemini. Silakan coba kembali.',
                    confirmButtonColor: '#2563eb'
                });
            });
        });

        // Klik Simpan ke Database
        btnSave.addEventListener('click', function() {
            const mapel = document.getElementById('mata_pelajaran_id').value;
            const kelas = document.getElementById('kelas_id').value;
            const topik = document.getElementById('topik').value.trim();
            const fase = document.getElementById('fase').value;
            const alokasi = document.getElementById('alokasi_waktu').value.trim();
            const modelPelajaran = document.getElementById('model_pembelajaran').value;

            let p3 = [];
            document.querySelectorAll('.p3-checkbox:checked').forEach(cb => {
                p3.push(cb.value);
            });

            const konten = tinymce.get('rpp-editor').getContent();

            if (!konten || konten.trim() === '' || !isContentGenerated) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konten Kosong',
                    text: 'Harap generate atau tulis konten RPP terlebih dahulu sebelum menyimpan.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            const originalBtnHtml = btnSave.innerHTML;
            btnSave.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1.5"></i> Menyimpan...';
            btnSave.disabled = true;

            fetch("{{ route('guru.rpp.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mata_pelajaran_id: mapel,
                    kelas_id: kelas,
                    topik: topik,
                    fase: fase,
                    alokasi_waktu: alokasi,
                    model_pembelajaran: modelPelajaran,
                    profil_pelajar_pancasila: p3,
                    konten: konten
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Disimpan!',
                        text: 'Dokumen RPP berhasil disimpan ke database.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    btnSave.innerHTML = originalBtnHtml;
                    btnSave.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: data.message || 'Terjadi kesalahan saat menyimpan dokumen.',
                        confirmButtonColor: '#2563eb'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                btnSave.innerHTML = originalBtnHtml;
                btnSave.disabled = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Gagal menghubungi server untuk menyimpan data.',
                    confirmButtonColor: '#2563eb'
                });
            });
        });

        // Klik Export PDF / Print
        btnExportPdf.addEventListener('click', function() {
            const editor = tinymce.get('rpp-editor');
            const content = editor ? editor.getContent() : '';

            if (!content || !content.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konten Kosong',
                    text: 'Belum ada konten RPP untuk dicetak. Silakan generate dokumen RPP terlebih dahulu!',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            const printWindow = window.open('', '_blank', 'height=850,width=850');
            if (!printWindow) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pop-up Diblokir',
                    text: 'Browser Anda memblokir pop-up jendela cetak. Harap izinkan pop-up pada peramban Anda.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            printWindow.document.open();
            printWindow.document.write('<!DOCTYPE html>' +
                '<html>' +
                '<head>' +
                '    <meta charset="utf-8">' +
                '    <title>Dokumen RPP Kurikulum Merdeka</title>' +
                '    <style>' +
                '        @page { size: A4 portrait; margin: 15mm 20mm; }' +
                '        body {' +
                '            font-family: Arial, Helvetica, sans-serif;' +
                '            line-height: 1.6;' +
                '            padding: 30px;' +
                '            color: #111827;' +
                '            background: #ffffff;' +
                '        }' +
                '        table {' +
                '            width: 100%;' +
                '            border-collapse: collapse;' +
                '            margin: 16px 0;' +
                '        }' +
                '        th, td {' +
                '            border: 1px solid #4b5563;' +
                '            padding: 8px 12px;' +
                '            text-align: left;' +
                '            font-size: 11pt;' +
                '        }' +
                '        th {' +
                '            background-color: #f3f4f6;' +
                '            font-weight: 700;' +
                '        }' +
                '        h1, h2, h3, h4, h5 {' +
                '            color: #111827;' +
                '            margin-top: 1.2em;' +
                '            margin-bottom: 0.6em;' +
                '        }' +
                '        @media print {' +
                '            body { padding: 0; }' +
                '        }' +
                '    </style>' +
                '</head>' +
                '<body>' +
                content +
                '</body>' +
                '</html>'
            );
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
            }, 400);
        });
    });
</script>
@endpush
