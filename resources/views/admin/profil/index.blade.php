@extends('template.layouts.app')

@section('title', 'Profil Saya - ' . ($user->role == 'guru' ? 'Guru' : ($user->role == 'admin' ? 'Administrator' : 'Pengguna')))

@section('content')
@php
    $role = $user->role;
    $theme = match($role) {
        'admin' => [
            'bg' => 'linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #2563eb 100%)',
            'badge_bg' => 'rgba(37, 99, 235, 0.2)',
            'badge_border' => 'rgba(96, 165, 250, 0.4)',
            'badge_text' => '#bfdbfe',
            'badge_icon' => 'mdi-shield-crown-outline',
            'badge_label' => 'Administrator',
            'desc' => 'Akun ini memiliki hak akses penuh sebagai Operator Utama dalam mengelola sistem data master, laporan kehadiran, dan konfigurasi sekolah.',
            'accent' => '#2563eb'
        ],
        'guru' => [
            'bg' => 'linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #1d4ed8 100%)',
            'badge_bg' => 'rgba(16, 185, 129, 0.25)',
            'badge_border' => 'rgba(52, 211, 153, 0.4)',
            'badge_text' => '#a7f3d0',
            'badge_icon' => 'mdi-school-outline',
            'badge_label' => 'Tenaga Pendidik',
            'desc' => 'Akun ini terdaftar resmi sebagai Guru/Pendidik. Memiliki wewenang untuk mengajar, mengunggah modul & tugas, serta melakukan rekapitulasi kehadiran siswa.',
            'accent' => '#059669'
        ],
        'siswa' => [
            'bg' => 'linear-gradient(135deg, #0f172a 0%, #312e81 60%, #4f46e5 100%)',
            'badge_bg' => 'rgba(168, 85, 247, 0.25)',
            'badge_border' => 'rgba(192, 132, 252, 0.4)',
            'badge_text' => '#e9d5ff',
            'badge_icon' => 'mdi-account-school-outline',
            'badge_label' => 'Siswa Aktif',
            'desc' => 'Akun ini terdaftar sebagai Siswa/Pelajar Aktif dalam pangkalan data sekolah.',
            'accent' => '#7c3aed'
        ],
        default => [
            'bg' => 'linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%)',
            'badge_bg' => 'rgba(148, 163, 184, 0.2)',
            'badge_border' => 'rgba(203, 213, 225, 0.4)',
            'badge_text' => '#f1f5f9',
            'badge_icon' => 'mdi-account-outline',
            'badge_label' => 'Pengguna',
            'desc' => 'Akun terdaftar sebagai pengguna umum dalam pangkalan data sekolah.',
            'accent' => '#4b5563'
        ]
    };
@endphp

<style>
    /* Profile Hero Card */
    .profile-hero-card {
        background: {{ $theme['bg'] }};
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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
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
        flex-shrink: 0;
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

    /* Cards & Tiles */
    .card-profile-section {
        border-radius: 18px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    }
    .info-tile {
        background: #f8fafc;
        border-radius: 14px;
        padding: 14px 18px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .info-tile:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    .info-tile-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }
    .info-tile-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
        word-break: break-word;
    }

    /* Dark Mode Harmonization */
    html.dark-mode .card-profile-section {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .info-tile {
        background: #121215 !important;
        border-color: #27272a !important;
    }
    html.dark-mode .info-tile-label {
        color: #a1a1aa !important;
    }
    html.dark-mode .info-tile-value {
        color: #f4f4f5 !important;
    }
</style>

{{-- Profile Hero Banner --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="profile-hero-card p-4 p-md-5">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                    <div class="profile-avatar-box mx-auto">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=1e3a8a&color=ffffff&bold=true&size=128" 
                             alt="{{ $user->nama }}" 
                             class="profile-avatar-img">
                    </div>
                </div>
                <div class="col-md text-center text-md-start">
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start mb-2">
                        <span class="profile-badge-pill" style="background: {{ $theme['badge_bg'] }}; border-color: {{ $theme['badge_border'] }}; color: {{ $theme['badge_text'] }};">
                            <i class="mdi {{ $theme['badge_icon'] }}"></i> {{ $theme['badge_label'] }}
                        </span>
                        @if($user->guru && $user->guru->kelasWali)
                            <span class="profile-badge-pill" style="background: rgba(59, 130, 246, 0.25); border-color: rgba(96, 165, 250, 0.4); color: #bfdbfe;">
                                <i class="mdi mdi-account-star"></i> Wali Kelas {{ $user->guru->kelasWali->nama_kelas }}
                            </span>
                        @endif
                    </div>
                    <h2 class="fw-bold mb-1 text-white" style="letter-spacing: -0.5px;">{{ $user->nama }}</h2>
                    <p class="text-white-50 mb-0 small">
                        @if($user->role == 'siswa')
                            <i class="mdi mdi-card-account-details-outline me-1"></i>NISN: {{ $user->username }} &bull; SMK Al-Madani Pontianak
                        @else
                            <i class="mdi mdi-email-outline me-1"></i>{{ $user->email ?? $user->username }} &bull; SMK Al-Madani Pontianak
                        @endif
                    </p>
                </div>
                <div class="col-md-auto text-center text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.profil.edit') }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center text-dark">
                        <i class="mdi mdi-pencil-outline me-1.5 fs-5 text-primary"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alert Sukses --}}
@if(session('success'))
    <div class="col-12 mb-4">
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 14px;">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-check-circle me-2 fs-5"></i>
                <div><strong>Sukses!</strong> {{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<div class="row g-4">
    {{-- Kolom Kiri: Ringkasan Akun & Status --}}
    <div class="col-lg-4">
        <div class="card card-profile-section h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-2 bg-primary-subtle text-primary me-2.5 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="mdi mdi-shield-account-outline fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Status Akun</h5>
                        <small class="text-muted">Kredensial dan hak akses</small>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light text-center mb-4">
                    <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-3 py-1.5 mb-2 d-inline-flex align-items-center" style="font-size: 0.8rem;">
                        <i class="mdi mdi-check-decagram me-1"></i> Akun Terverifikasi Aktif
                    </span>
                    <p class="text-muted small mb-0 lh-base" style="font-size: 0.8rem;">
                        {{ $theme['desc'] }}
                    </p>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted small fw-semibold"><i class="mdi mdi-calendar-check me-1 text-primary"></i>Terdaftar Sejak</span>
                        <strong class="text-dark small">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted small fw-semibold"><i class="mdi mdi-clock-check-outline me-1 text-primary"></i>Terakhir Diperbarui</span>
                        <strong class="text-dark small">{{ $user->updated_at ? $user->updated_at->diffForHumans() : '-' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted small fw-semibold"><i class="mdi mdi-key-variant me-1 text-primary"></i>Tingkat Hak Akses</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="font-size: 0.72rem;">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Detail Informasi Akun --}}
    <div class="col-lg-8">
        <div class="card card-profile-section h-100">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 p-2 bg-primary-subtle text-primary me-2.5 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="mdi mdi-card-account-details-outline fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Informasi Pribadi & Kredensial</h5>
                            <small class="text-muted">Data resmi terdaftar di database SMK Al-Madani</small>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Nama Lengkap --}}
                    <div class="col-md-6">
                        <div class="info-tile">
                            <span class="info-tile-label">
                                <i class="mdi mdi-account-circle-outline me-1 text-primary"></i>Nama Lengkap
                            </span>
                            <p class="info-tile-value">{{ $user->nama }}</p>
                        </div>
                    </div>

                    {{-- Username / Akun Login --}}
                    <div class="col-md-6">
                        <div class="info-tile">
                            <span class="info-tile-label">
                                <i class="mdi mdi-card-account-details-outline me-1 text-primary"></i>{{ $user->role == 'siswa' ? 'NISN (Username Login)' : 'Username / Email' }}
                            </span>
                            <p class="info-tile-value">{{ $user->role == 'siswa' ? $user->username : ($user->email ?? $user->username) }}</p>
                        </div>
                    </div>

                    {{-- Data Khusus Guru --}}
                    @if($user->role == 'guru' && $user->guru)
                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-badge-account-outline me-1 text-primary"></i>Kode Guru / NIP
                                </span>
                                <p class="info-tile-value">{{ $user->guru->kode_guru ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-briefcase-outline me-1 text-primary"></i>Jabatan Pendidik
                                </span>
                                <p class="info-tile-value text-uppercase">{{ $user->guru->jabatan ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-gender-male-female me-1 text-primary"></i>Jenis Kelamin
                                </span>
                                <p class="info-tile-value">{{ ($user->guru->jk ?? '') == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-phone-outline me-1 text-primary"></i>Nomor Telepon / WhatsApp
                                </span>
                                <p class="info-tile-value">{{ $user->guru->no_hp ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-map-marker-outline me-1 text-primary"></i>Alamat Lengkap
                                </span>
                                <p class="info-tile-value">{{ $user->guru->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Data Khusus Siswa --}}
                    @if($user->role == 'siswa' && $user->siswa)
                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-card-bulleted-outline me-1 text-primary"></i>NISN
                                </span>
                                <p class="info-tile-value">{{ $user->siswa->nisn ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-google-classroom me-1 text-primary"></i>Kelas Aktif
                                </span>
                                <p class="info-tile-value">{{ $user->siswa->kelas->nama_kelas ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-gender-male-female me-1 text-primary"></i>Jenis Kelamin
                                </span>
                                <p class="info-tile-value">{{ ($user->siswa->jk ?? '') == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="info-tile-label">
                                    <i class="mdi mdi-phone-outline me-1 text-primary"></i>Nomor Telepon / WA
                                </span>
                                <p class="info-tile-value">{{ $user->siswa->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
