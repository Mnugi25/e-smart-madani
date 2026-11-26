@extends('template.layouts.app')

@section('title', Auth::user()->role == 'admin' ? 'Dashboard Utama' : (Auth::user()->role == 'siswa' ? 'Dashboard Siswa' : 'Dashboard Guru'))

@section('content')
<style>
    /* CSS Khusus Mobile: Memberi ruang di bagian atas judul */
    @media (max-width: 991px) {
        .dashboard-header-guru, .dashboard-header-siswa {
            padding-top: 5px !important;
            margin-top: 15px !important;
        }
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; font-weight: 500;">
                    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert" style="border-radius: 12px; font-weight: 500;">
                    <div>
                        <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
                        @if(str_contains(session('error'), 'belum ditunjuk untuk kelas manapun') && Auth::user()->role == 'guru')
                            <a href="{{ route('guru.auto_assign_wali') }}" class="btn btn-dark btn-sm text-white ms-3 fw-bold shadow-sm" style="border-radius: 8px; padding: 4px 12px; font-size: 0.8rem;">
                                <i class="mdi mdi-account-plus-outline me-1"></i> Hubungkan Kelas Otomatis
                            </a>
                        @endif
                    </div>
                    <button type="button" class="btn-close position-static ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; font-weight: 500;">
                    <i class="mdi mdi-alert-circle me-2"></i> Terdapat kesalahan pada input Anda. Silakan cek kembali form pengajuan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- 👑 KONTEN KHUSUS ADMIN --}}
            @if(Auth::user()->role == 'admin')
                <div class="main-content-wrapper">
                    @include('template.content_operator')
                </div>
            @endif

            {{-- 👨‍🏫 KONTEN KHUSUS GURU --}}
            @if(Auth::user()->role == 'guru')
                <div class="main-content-wrapper">
                    @include('template.content_guru')
                </div>
            @endif

            {{-- 🎓 KONTEN KHUSUS SISWA --}}
            @if(Auth::user()->role == 'siswa')
                <div class="main-content-wrapper">
                    @include('template.content_siswa')
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
