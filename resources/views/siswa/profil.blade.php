@extends('template.layouts.app')

@section('title', 'Profil Saya - Siswa')

@section('content')
<style>
    .profile-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #3b82f6 100%);
        border-radius: 20px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.25);
    }
    .profile-hero-card::after {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 250px; height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .profile-avatar-box {
        width: 88px;
        height: 88px;
        border-radius: 24px;
        background: #ffffff;
        padding: 4px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .profile-avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 20px;
        object-fit: cover;
    }
    .profile-badge-pill {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .card-profile-section {
        border-radius: 18px !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        background: #ffffff;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    }
    .info-tile {
        background: #f8fafc;
        border-radius: 14px;
        padding: 14px 18px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s;
    }
    .info-tile:hover {
        transform: translateY(-2px);
    }

    /* Dark Mode Harmonization */
    html.dark-mode .card-profile-section {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .info-tile {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .info-tile h6 {
        color: #ffffff !important;
    }
    html.dark-mode .info-tile p {
        color: #94a3b8 !important;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="profile-hero-card p-4 p-md-5">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                    <div class="profile-avatar-box mx-auto">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=1e3a8a&color=ffffff&bold=true&size=120" 
                             alt="{{ Auth::user()->nama }}" 
                             class="profile-avatar-img">
                    </div>
                </div>
                <div class="col-md text-center text-md-start">
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start mb-2">
                        <span class="profile-badge-pill">
                            <i class="mdi mdi-school"></i> Siswa Aktif
                        </span>
                        <span class="profile-badge-pill" style="background: rgba(16, 185, 129, 0.25); border-color: rgba(52, 211, 153, 0.4); color: #a7f3d0;">
                            <i class="mdi mdi-shield-check"></i> Kelas {{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }}
                        </span>
                    </div>
                    <h2 class="fw-bold mb-1 text-white" style="letter-spacing: -0.5px;">{{ Auth::user()->nama }}</h2>
                    <p class="text-white-50 mb-0 small">
                        NISN: <strong>{{ Auth::user()->siswa->nisn ?? Auth::user()->username }}</strong> &bull; SMK Al-Madani Pontianak
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; font-weight: 600;">
        <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    {{-- Form Edit Data Diri & Password --}}
    <div class="col-lg-7 mb-4">
        <div class="card card-profile-section h-100">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="stat-icon-box bg-primary text-white me-3" style="width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="mdi mdi-account-edit"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Pengaturan Akun</h4>
                        <p class="text-muted small mb-0">Perbarui nama tampilan dan kata sandi akun Anda</p>
                    </div>
                </div>

                <form action="{{ route('siswa.profil.update') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NISN (Tetap)</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->siswa->nisn }}" readonly disabled style="font-weight: 600;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Username Login</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->username }}" readonly disabled style="font-weight: 600;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nama Lengkap Siswa</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', Auth::user()->nama) }}" required placeholder="Masukkan nama lengkap">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="p-4 rounded-3 mb-4" style="background: rgba(245, 158, 11, 0.05); border: 1px dashed rgba(245, 158, 11, 0.3);">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="mdi mdi-lock-reset text-warning me-1"></i> Ganti Password Akun
                        </h6>
                        <p class="text-muted small mb-3">Kosongkan kolom di bawah jika Anda tidak ingin mengubah password saat ini.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 py-2.5 fw-bold shadow-sm rounded-pill w-100" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border: none;">
                        <i class="mdi mdi-content-save-outline me-1"></i> Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Info Card & Bantuan --}}
    <div class="col-lg-5 mb-4">
        <div class="card card-profile-section h-100">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="stat-icon-box bg-info text-white me-3" style="width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="mdi mdi-information-variant"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Data Akademik</h4>
                        <p class="text-muted small mb-0">Informasi perwalian & jurusan Anda</p>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="info-tile">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small fw-semibold">Kelas Saat Ini</span>
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">Tingkat Kelas & Rombel</h6>
                    </div>

                    <div class="info-tile">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small fw-semibold">Jurusan / Kompetensi</span>
                            <span class="badge bg-success-subtle text-success fw-bold">{{ Auth::user()->siswa->kelas->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</span>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">Program Keahlian SMK</h6>
                    </div>

                    <div class="info-tile">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small fw-semibold">Wali Kelas</span>
                            <span class="badge bg-warning-subtle text-warning fw-bold"><i class="mdi mdi-shield-account"></i> Terdaftar</span>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ Auth::user()->siswa->kelas->waliKelas->nama_lengkap ?? 'Belum Ditunjuk' }}</h6>
                    </div>
                </div>

                <div class="p-3 rounded-3" style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.15);">
                    <div class="d-flex gap-3">
                        <i class="mdi mdi-help-circle-outline text-primary fs-3 flex-shrink-0"></i>
                        <div>
                            <h6 class="fw-bold text-primary mb-1">Butuh Bantuan Data?</h6>
                            <p class="text-muted small mb-0">
                                Jika NISN atau data rombel tidak sesuai dengan data Dapodik, hubungi Operator Tata Usaha atau Wali Kelas Anda.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
