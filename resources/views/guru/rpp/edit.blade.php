@extends('template.layouts.app')

@section('title', 'Edit Dokumen RPP')

@push('styles')
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
        padding: 20px 24px;
    }
    .form-card-body {
        padding: 24px;
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
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
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
                    <i class="mdi mdi-pencil-box-multiple-outline text-primary me-2"></i>Edit Dokumen RPP
                </h4>
                <p class="text-muted small mb-0">Perbarui parameter atau sunting konten dokumen rencana pelaksanaan pembelajaran.</p>
            </div>
            <a href="{{ route('guru.rpp.index') }}" class="btn-back-modern">
                <div class="btn-back-icon">
                    <i class="mdi mdi-arrow-left"></i>
                </div>
                <span>Kembali ke Data RPP</span>
            </a>
        </div>
    </div>

    {{-- Main Form Card --}}
    <div class="col-12 mb-4">
        <div class="form-card">
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-file-document-edit-outline"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">Formulir Perubahan Dokumen RPP</h5>
                        <p class="text-muted small mb-0">Pastikan seluruh rincian telah sesuai sebelum memperbarui</p>
                    </div>
                </div>
            </div>

            <div class="form-card-body">
                <form action="{{ route('guru.rpp.update', $rpp->id) }}" method="POST" id="edit-rpp-form">
                    @csrf
                    @method('PUT')

                    {{-- Row 1: Mapel, Kelas, Fase --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label for="mata_pelajaran_id" class="form-label-custom d-block">
                                Mata Pelajaran <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-book-open-page-variant"></i>
                                </span>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                                    <option value="" disabled>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mataPelajarans as $mapel)
                                        <option value="{{ $mapel->id }}" {{ $rpp->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="kelas_id" class="form-label-custom d-block">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-google-classroom"></i>
                                </span>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="" disabled>-- Pilih Kelas --</option>
                                    @foreach($kelases as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $rpp->kelas_id == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="fase" class="form-label-custom d-block">
                                Fase <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-tag-outline"></i>
                                </span>
                                <select name="fase" id="fase" class="form-select">
                                    <option value="">Fase...</option>
                                    <option value="Fase E" {{ $rpp->fase == 'Fase E' || $rpp->fase == 'E' ? 'selected' : '' }}>Fase E (X)</option>
                                    <option value="Fase F" {{ $rpp->fase == 'Fase F' || $rpp->fase == 'F' ? 'selected' : '' }}>Fase F (XI/XII)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Topik, Alokasi Waktu, Model Pembelajaran --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="topik" class="form-label-custom d-block">
                                Topik / Materi Pokok <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-text-box-search-outline"></i>
                                </span>
                                <input type="text" name="topik" id="topik" class="form-control" 
                                       value="{{ $rpp->topik }}" placeholder="Contoh: Teks Laporan Hasil Observasi" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="alokasi_waktu" class="form-label-custom d-block">
                                Alokasi Waktu <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-clock-outline"></i>
                                </span>
                                <input type="text" name="alokasi_waktu" id="alokasi_waktu" class="form-control" 
                                       value="{{ $rpp->alokasi_waktu }}" placeholder="Contoh: 2 x 45 Menit" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="model_pembelajaran" class="form-label-custom d-block">
                                Model Pembelajaran
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-shape-outline"></i>
                                </span>
                                <select name="model_pembelajaran" id="model_pembelajaran" class="form-select">
                                    @php
                                        $models = [
                                            'Problem Based Learning (PBL)',
                                            'Project Based Learning (PjBL)',
                                            'Discovery Learning',
                                            'Inquiry Learning',
                                            'Diskusi & Kolaborasi Kelompok',
                                            'Teaching Factory (TEFA)'
                                        ];
                                    @endphp
                                    @foreach($models as $m)
                                        <option value="{{ $m }}" {{ str_contains($rpp->model_pembelajaran ?? '', explode(' ', $m)[0]) ? 'selected' : '' }}>
                                            {{ $m }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Profil Pelajar Pancasila (P3) --}}
                    @php
                        $currentP3 = is_array($rpp->profil_pelajar_pancasila) ? $rpp->profil_pelajar_pancasila : [];
                    @endphp
                    <div class="mb-4">
                        <label class="form-label-custom d-block mb-1">
                            Profil Pelajar Pancasila (P3)
                        </label>
                        <small class="text-muted d-block mb-2" style="font-size: 0.78rem;">Pilih dimensi karakter yang diasah:</small>
                        <div class="p3-chips-grid">
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" name="profil_pelajar_pancasila[]" value="Beriman & Bertakwa kepada Tuhan YME"
                                       {{ in_array('Beriman & Bertakwa kepada Tuhan YME', $currentP3) || in_array('Beriman, bertakwa kepada Tuhan YME, dan berakhlak mulia', $currentP3) ? 'checked' : '' }}>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-heart-outline text-danger"></i>
                                    <span>Beriman & Takwa</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" name="profil_pelajar_pancasila[]" value="Berkebinekaan Global"
                                       {{ in_array('Berkebinekaan Global', $currentP3) || in_array('Berkebinekaan global', $currentP3) ? 'checked' : '' }}>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-earth text-primary"></i>
                                    <span>Kebinekaan Global</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" name="profil_pelajar_pancasila[]" value="Gotong Royong"
                                       {{ in_array('Gotong Royong', $currentP3) || in_array('Gotong Royong (Kelompok)', $currentP3) ? 'checked' : '' }}>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-account-group-outline text-success"></i>
                                    <span>Gotong Royong</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" name="profil_pelajar_pancasila[]" value="Mandiri"
                                       {{ in_array('Mandiri', $currentP3) ? 'checked' : '' }}>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-account-outline text-info"></i>
                                    <span>Mandiri</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" name="profil_pelajar_pancasila[]" value="Bernalar Kritis"
                                       {{ in_array('Bernalar Kritis', $currentP3) || in_array('Bernalar kritis', $currentP3) ? 'checked' : '' }}>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-brain text-warning"></i>
                                    <span>Bernalar Kritis</span>
                                </div>
                            </label>
                            <label class="p3-chip-label">
                                <input class="p3-checkbox d-none" type="checkbox" name="profil_pelajar_pancasila[]" value="Kreatif"
                                       {{ in_array('Kreatif', $currentP3) ? 'checked' : '' }}>
                                <div class="p3-chip-content">
                                    <i class="mdi mdi-lightbulb-on-outline text-primary"></i>
                                    <span>Kreatif</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Row 4: Konten RPP Editor --}}
                    <div class="mb-4">
                        <label class="form-label-custom d-block mb-2">
                            Konten Lembar Kerja Dokumen RPP <span class="text-danger">*</span>
                        </label>
                        <textarea id="rpp-editor" name="konten">{!! $rpp->konten !!}</textarea>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('guru.rpp.index') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            <button type="button" id="btn-export-pdf" class="btn btn-outline-danger fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                                <i class="mdi mdi-printer me-1.5"></i> Cetak / Export PDF
                            </button>
                            <button type="submit" id="btn-submit-update" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                                <i class="mdi mdi-content-save-edit-outline me-1.5"></i> Perbarui Dokumen RPP
                            </button>
                        </div>
                    </div>
                </form>
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
            height: 600,
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

        // Form Submit Handler
        const form = document.getElementById('edit-rpp-form');
        const btnSubmit = document.getElementById('btn-submit-update');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const konten = tinymce.get('rpp-editor').getContent();
            if(!konten || konten.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konten Kosong',
                    text: 'Konten dokumen RPP tidak boleh kosong!',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            const formData = new FormData(form);
            formData.set('konten', konten);

            let data = {};
            formData.forEach((value, key) => {
                if (key === 'profil_pelajar_pancasila[]') {
                    if (!data['profil_pelajar_pancasila']) {
                        data['profil_pelajar_pancasila'] = [];
                    }
                    data['profil_pelajar_pancasila'].push(value);
                } else {
                    data[key] = value;
                }
            });

            const originalBtnHtml = btnSubmit.innerHTML;
            btnSubmit.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1.5"></i> Menyimpan Perubahan...';
            btnSubmit.disabled = true;

            fetch(form.action, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(resData => {
                if(resData.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diperbarui!',
                        text: 'Dokumen RPP berhasil diperbarui.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = resData.redirect_url;
                    });
                } else {
                    btnSubmit.innerHTML = originalBtnHtml;
                    btnSubmit.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memperbarui',
                        text: resData.message || 'Terjadi kesalahan sistem saat memperbarui dokumen.',
                        confirmButtonColor: '#2563eb'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                btnSubmit.innerHTML = originalBtnHtml;
                btnSubmit.disabled = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Gagal menghubungi server untuk memperbarui data.',
                    confirmButtonColor: '#2563eb'
                });
            });
        });
        // Klik Export PDF / Print
        const btnExportPdf = document.getElementById('btn-export-pdf');
        if (btnExportPdf) {
            btnExportPdf.addEventListener('click', function() {
                const editor = tinymce.get('rpp-editor');
                const content = editor ? editor.getContent() : '';

                if (!content || !content.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Konten Kosong',
                        text: 'Belum ada konten RPP untuk dicetak. Silakan isi konten RPP terlebih dahulu!',
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
        }
    });
</script>
@endpush
