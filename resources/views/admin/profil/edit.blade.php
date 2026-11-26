@extends('template.layouts.app')

@section('title', 'Perbarui Profil Akun')

@section('content')
<style>
    /* Form Card Styles */
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
        min-height: 85px;
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
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem; flex-shrink: 0;">
                        <i class="mdi mdi-account-edit"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Perbarui Profil Akun</h4>
                        <p class="text-muted small mb-0">Ubah informasi nama, nomor telepon, alamat, atau kata sandi Anda.</p>
                    </div>
                </div>
            </div>

            {{-- Body Card --}}
            <div class="card-body p-4 p-md-5">
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

                <form action="{{ route('admin.profil.update') }}" method="POST">
                    @csrf 
                    @method('PUT')

                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label for="nama" class="form-label-custom d-block">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-account-circle-outline"></i>
                            </span>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required placeholder="Masukkan nama lengkap Anda">
                        </div>
                    </div>

                    {{-- Username / Identitas Login (Readonly) --}}
                    <div class="mb-4">
                        <label for="username" class="form-label-custom d-block">
                            {{ $user->role == 'siswa' ? 'NISN / Username Login' : 'Username / Akun Login' }} <span class="text-muted fw-normal">(Tidak dapat diubah)</span>
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-card-account-details-outline"></i>
                            </span>
                            <input type="text" id="username" class="form-control" value="{{ $user->role == 'siswa' ? $user->username : ($user->email ?? $user->username) }}" readonly disabled style="opacity: 0.85;">
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            <i class="mdi mdi-information-outline me-1"></i>Kredensial {{ $user->role == 'siswa' ? 'NISN' : 'username' }} dikelola langsung oleh administrator sistem sekolah.
                        </small>
                    </div>

                    {{-- Nomor Telepon --}}
                    @php
                        $noHp = $user->guru ? $user->guru->no_hp : ($user->siswa ? $user->siswa->no_hp : '');
                        $alamat = $user->guru ? $user->guru->alamat : ($user->siswa ? $user->siswa->alamat : '');
                    @endphp
                    <div class="mb-4">
                        <label for="no_hp" class="form-label-custom d-block">
                            Nomor Telepon / WhatsApp
                        </label>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-phone-outline"></i>
                            </span>
                            <input type="text" id="no_hp" name="no_hp" class="form-control" value="{{ old('no_hp', $noHp) }}" placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    {{-- Alamat Lengkap --}}
                    @if($user->guru || $user->siswa)
                        <div class="mb-4">
                            <label for="alamat" class="form-label-custom d-block">
                                Alamat Lengkap
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-map-marker-outline"></i>
                                </span>
                                <textarea id="alamat" name="alamat" class="form-control" rows="2" placeholder="Tuliskan alamat domisili atau tempat tinggal lengkap Anda">{{ old('alamat', $alamat) }}</textarea>
                            </div>
                        </div>
                    @endif

                    {{-- Ubah Password (Opsional) --}}
                    <div class="mb-4 p-3 rounded-3" style="background: rgba(37, 99, 235, 0.04); border: 1.5px dashed rgba(37, 99, 235, 0.25);">
                        <label for="password" class="form-label-custom d-block text-primary mb-1">
                            <i class="mdi mdi-lock-outline me-1"></i>Ubah Kata Sandi (Opsional)
                        </label>
                        <p class="text-muted small mb-2.5" style="font-size: 0.78rem;">
                            Kosongkan kolom kata sandi di bawah jika Anda tidak ingin mengubah password saat ini.
                        </p>
                        <div class="input-group input-group-custom">
                            <span class="input-group-text">
                                <i class="mdi mdi-key-variant"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password baru (minimal 6 karakter)">
                        </div>
                    </div>

                    {{-- Form Footer Actions --}}
                    <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.profil') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tips & Panduan Sidebar (Col-4) --}}
    <div class="col-lg-4 mb-4">
        <div class="card tips-card p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge bg-warning text-dark fw-bold rounded-pill px-2.5 py-1">
                    <i class="mdi mdi-lightbulb-on me-1"></i> TIPS
                </span>
                <h5 class="fw-bold mb-0 text-dark" style="font-size: 1rem;">Keamanan Akun</h5>
            </div>
            
            <p class="card-text text-muted mb-3" style="font-size: 0.88rem; line-height: 1.5;">
                Pastikan data profil Anda selalu diperbarui agar komunikasi akademik sekolah berjalan lancar dan akun Anda tetap aman.
            </p>
            
            <div class="p-3 rounded-3 mb-3" style="background: rgba(255, 255, 255, 0.65); border: 1px dashed rgba(245, 158, 11, 0.4);">
                <div class="d-flex align-items-center text-dark fw-bold small mb-1">
                    <i class="mdi mdi-shield-check text-success me-1.5 fs-6"></i> Kata Sandi Kuat
                </div>
                <div class="text-muted" style="font-size: 0.78rem; line-height: 1.4;">
                    Gunakan kombinasi minimal 6-8 karakter yang memadukan huruf kapital, angka, dan simbol untuk keamanan maksimal.
                </div>
            </div>

            <div class="p-3 rounded-3 mb-3" style="background: rgba(255, 255, 255, 0.65); border: 1px dashed rgba(245, 158, 11, 0.4);">
                <div class="d-flex align-items-center text-dark fw-bold small mb-1">
                    <i class="mdi mdi-whatsapp text-success me-1.5 fs-6"></i> Kontak WhatsApp Aktif
                </div>
                <div class="text-muted" style="font-size: 0.78rem; line-height: 1.4;">
                    Nomor WhatsApp digunakan untuk konfirmasi perizinan siswa serta notifikasi penting kegiatan pembelajaran.
                </div>
            </div>

            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.65); border: 1px dashed rgba(245, 158, 11, 0.4);">
                <div class="d-flex align-items-center text-dark fw-bold small mb-1">
                    <i class="mdi mdi-information-outline text-primary me-1.5 fs-6"></i> Perubahan Kredensial
                </div>
                <div class="text-muted" style="font-size: 0.78rem; line-height: 1.4;">
                    Jika Anda lupa password atau ingin mengganti kredensial login sistem, silakan hubungi Tim Operator / IT Sekolah.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
