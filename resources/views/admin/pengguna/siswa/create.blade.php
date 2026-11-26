@extends('template.layouts.app')

@section('title', 'Tambah Akun Siswa')

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
    .credential-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
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
    html.dark-mode .credential-box {
        background: #1e293b !important;
        border-color: #334155 !important;
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
    <div class="col-lg-9 mx-auto">
        <div class="form-card mb-4">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-account-plus-outline"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Tambah Akun Siswa</h4>
                        <p class="text-muted small mb-0">Pilih data siswa dari master untuk membuat kredensial akun login.</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-4 p-md-4">
                <form action="{{ route('admin.siswa.store') }}" method="POST" class="forms-sample">
                    @csrf

                    @if(isset($siswa) && $siswa->isNotEmpty())
                        {{-- Data Profil Siswa --}}
                        <div class="mb-4">
                            <div class="mb-3">
                                <label for="siswa_id" class="form-label-custom d-block">
                                    Pilih Siswa dari Data Master <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-custom">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-account-search-outline"></i>
                                    </span>
                                    <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- Pilih Siswa --</option>
                                        @foreach($siswa as $s)
                                            <option value="{{ $s->id }}" data-nisn="{{ $s->nisn }}" data-kelas="{{ $s->kelas->nama_kelas ?? '-' }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                                {{ $s->nama_lengkap }} (Kelas: {{ $s->kelas->nama_kelas ?? '-' }} - NISN: {{ $s->nisn ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('siswa_id')
                                    <small class="text-danger d-block mt-1 fw-bold">
                                        <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="kelas_nama" class="form-label-custom d-block">Kelas (Otomatis)</label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-google-classroom"></i>
                                        </span>
                                        <input type="text" id="kelas_nama" class="form-control" readonly placeholder="Pilih siswa terlebih dahulu" style="background-color: #f1f5f9;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nisn_val" class="form-label-custom d-block">NISN (Otomatis)</label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-account-card-details-outline"></i>
                                        </span>
                                        <input type="text" id="nisn_val" class="form-control" readonly placeholder="Pilih siswa terlebih dahulu" style="background-color: #f1f5f9;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kredensial Login --}}
                        <div class="credential-box mb-4">
                            <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                                <i class="mdi mdi-lock-outline"></i> Kredensial Akun Login
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="password" class="form-label-custom d-block">
                                        Password Default <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-key-outline"></i>
                                        </span>
                                        <input type="password" name="password" id="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Minimal 6 karakter" required>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">* Tentukan password awal untuk login siswa.</small>
                                    @error('password')
                                        <small class="text-danger d-block mt-1 fw-bold">
                                            <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                            <i class="mdi mdi-alert-circle me-2 fs-5"></i>
                            <div>
                                Seluruh data siswa di master data sudah memiliki akun login. Silakan tambahkan data siswa baru di Master Data Siswa terlebih dahulu jika ingin membuat akun baru.
                            </div>
                        </div>
                    @endif

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('admin.siswa') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs" {{ (!isset($siswa) || $siswa->isEmpty()) ? 'disabled' : '' }}>
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectSiswa = document.getElementById('siswa_id');
    const inputKelas = document.getElementById('kelas_nama');
    const inputNisn = document.getElementById('nisn_val');

    function updateFields() {
        if (!selectSiswa) return;
        const selectedOption = selectSiswa.options[selectSiswa.selectedIndex];
        if (selectedOption && selectedOption.value !== '') {
            const nisn = selectedOption.getAttribute('data-nisn') || '';
            const kelas = selectedOption.getAttribute('data-kelas') || '';
            if (inputKelas) inputKelas.value = kelas;
            if (inputNisn) inputNisn.value = nisn;
        } else {
            if (inputKelas) inputKelas.value = '';
            if (inputNisn) inputNisn.value = '';
        }
    }

    if (selectSiswa) {
        selectSiswa.addEventListener('change', updateFields);
        updateFields();
    }
});
</script>
@endsection
