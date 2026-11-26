@extends('template.layouts.app')

@section('title', 'Ruang Ujian Online')

@section('content')
<style>
    /* Filter Stat Badges */
    .filter-stat-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    /* Exam Cards */
    .ujian-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border-left: 4px solid #cbd5e1;
    }
    .ujian-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        border-color: #cbd5e1;
    }
    .ujian-card.is-selesai {
        border-left-color: #10b981 !important;
    }
    .ujian-card.is-tersedia {
        border-left-color: #1f3bb3 !important;
    }

    /* Meta & Score Boxes */
    .ujian-meta-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 14px;
        border: 1px solid #f1f5f9;
    }
    .nilai-box {
        background: #f8fafc;
        border-radius: 14px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
    }

    /* Primary Action Button */
    .btn-kerjakan {
        background: #1f3bb3;
        border: none;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 9px 16px;
        border-radius: 30px;
        color: #ffffff;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(31, 59, 179, 0.2);
    }
    .btn-kerjakan:hover {
        background: #172e93;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(31, 59, 179, 0.3);
        transform: translateY(-1px);
    }

    /* Badges */
    .time-badge {
        background-color: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-size: 0.73rem;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Dark Mode Themes */
    html.dark-mode .ujian-card {
        background: #1e293b !important;
        border-color: #334155 !important;
        border-left-color: #475569;
    }
    html.dark-mode .ujian-card.is-selesai {
        border-left-color: #10b981 !important;
    }
    html.dark-mode .ujian-card.is-tersedia {
        border-left-color: #60a5fa !important;
    }
    html.dark-mode .ujian-card:hover {
        border-color: #475569 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3) !important;
    }
    html.dark-mode .filter-stat-badge {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .ujian-meta-box,
    html.dark-mode .nilai-box {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .time-badge {
        background-color: #0f172a !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }
    html.dark-mode .header-mobile-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .empty-state-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .text-dark {
        color: #f1f5f9 !important;
    }
    html.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
</style>

@php
    $totalUjian = $ujians->count();
    $selesaiCount = $ujians->filter(fn($u) => $u->nilaiUjian->isNotEmpty())->count();
    $belumCount = $totalUjian - $selesaiCount;
    $nilaiList = $ujians->filter(fn($u) => $u->nilaiUjian->isNotEmpty())->map(fn($u) => (float)$u->nilaiUjian->first()->nilai);
    $rataRata = $nilaiList->count() > 0 ? round($nilaiList->avg(), 1) : 0;
@endphp

<div class="row">
    {{-- Mobile Header (Outside Card) --}}
    <div class="col-12 d-md-none mt-2 mb-3">
        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-xs header-mobile-box" style="border: 1px solid rgba(0,0,0,0.06); background: #ffffff;">
            <div class="pe-2">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">
                    <i class="mdi mdi-book-open-page-variant text-primary me-2"></i>Ujian Online
                </h4>
                <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.2;">
                    Kelas {{ $siswa->kelas->nama_kelas ?? (Auth::user()->siswa->kelas->nama_kelas ?? '') }} • {{ $totalUjian }} Ujian Aktif
                </p>
            </div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-bold text-nowrap">
                {{ $totalUjian }} Ujian
            </span>
        </div>
    </div>

    {{-- Desktop Header Card --}}
    <div class="col-12 d-none d-md-block mb-4">
        <div class="card card-rounded shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="mdi mdi-book-open-page-variant fs-3"></i>
                        </div>
                        <div>
                            <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                                Ruang Ujian Online
                            </h4>
                            <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                                Daftar ujian aktif dan evaluasi belajar resmi kelas {{ $siswa->kelas->nama_kelas ?? (Auth::user()->siswa->kelas->nama_kelas ?? '') }}.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Total:</span>
                            <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ $totalUjian }}</strong>
                            <span class="text-muted small ms-1">Ujian</span>
                        </div>
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Selesai:</span>
                            <strong class="text-success ms-1" style="font-size: 0.92rem;">{{ $selesaiCount }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Geofencing / Location Notice --}}
    <div class="col-12 mb-4">
        <div class="alert alert-info border-0 shadow-xs rounded-3 p-3 mb-0" role="alert" style="background-color: rgba(3, 105, 161, 0.08); border-left: 4px solid #0284c7 !important;">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-map-marker-radius-outline text-info me-2.5 fs-4 flex-shrink-0"></i>
                <div class="small" style="font-size: 0.8rem; color: #0369a1;">
                    <strong>Informasi Geofencing:</strong> Akses pengerjaan ujian memerlukan verifikasi lokasi GPS di area sekolah. Pastikan izin lokasi browser aktif saat menekan tombol <strong>Mulai Mengerjakan</strong>.
                </div>
            </div>
        </div>
    </div>

    {{-- Feedback Alerts --}}
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-check-circle me-2 fs-5"></i>
                    <div><strong>Sukses!</strong> {{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="col-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-alert-circle me-2 fs-5"></i>
                    <div><strong>Perhatian!</strong> {{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Exam Cards Grid --}}
    <div class="col-12">
        <div class="row g-3">
            @forelse($ujians as $u)
                @php
                    $isSelesai = $u->nilaiUjian->isNotEmpty();
                    $nilai = $isSelesai ? $u->nilaiUjian->first()->nilai : null;
                @endphp
                <div class="col-12 col-md-6 col-xl-4 d-flex align-items-stretch">
                    <div class="card ujian-card w-100 shadow-sm {{ $isSelesai ? 'is-selesai' : 'is-tersedia' }}">
                        <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                            <div>
                                {{-- Card Top: Subject Pill, Duration & Status --}}
                                <div class="d-flex justify-content-between align-items-center mb-2.5 gap-2 flex-wrap">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold text-truncate" style="font-size: 0.72rem; max-width: 170px;" title="{{ $u->mataPelajaran->nama_mapel ?? '-' }}">
                                        {{ $u->mataPelajaran->nama_mapel ?? '-' }}
                                    </span>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="time-badge">
                                            <i class="mdi mdi-clock-outline text-warning"></i>
                                            {{ $u->durasi }} Menit
                                        </span>
                                        @if($isSelesai)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.68rem;">
                                                <i class="mdi mdi-check-circle me-0.5"></i>Selesai
                                            </span>
                                        @elseif($u->status == 'Selesai')
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.68rem;">
                                                <i class="mdi mdi-close-circle me-0.5"></i>Ditutup
                                            </span>
                                        @else
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.68rem;">
                                                <i class="mdi mdi-play-circle-outline me-0.5"></i>Tersedia
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Exam Title --}}
                                <h5 class="fw-bold text-dark mb-1" style="font-size: 0.98rem; line-height: 1.45;" title="{{ $u->judul }}">
                                    {{ $u->judul }}
                                </h5>

                                {{-- Teacher Info --}}
                                <div class="d-flex align-items-center text-muted mb-3">
                                    <div class="avatar-mini bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 26px; height: 26px; font-size: 0.8rem;">
                                        <i class="mdi mdi-account-tie"></i>
                                    </div>
                                    <span class="small text-truncate fw-semibold text-dark" style="font-size: 0.8rem;" title="{{ $u->guru->nama_lengkap ?? '-' }}">
                                        {{ $u->guru->nama_lengkap ?? '-' }}
                                    </span>
                                </div>

                                {{-- Details Box --}}
                                <div class="ujian-meta-box mb-3">
                                    <div class="d-flex justify-content-between align-items-center small py-1 border-bottom border-light-subtle">
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            <i class="mdi mdi-calendar-text text-primary me-1"></i>Jadwal Mulai
                                        </span>
                                        <strong class="text-dark" style="font-size: 0.75rem;">
                                            {{ $u->waktu_mulai ? \Carbon\Carbon::parse($u->waktu_mulai)->locale('id')->isoFormat('D MMMM Y, HH:mm [WIB]') : '-' }}
                                        </strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small py-1">
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            <i class="mdi mdi-format-list-numbered text-primary me-1"></i>Jumlah Soal
                                        </span>
                                        <strong class="text-dark" style="font-size: 0.75rem;">
                                            {{ $u->soal ? $u->soal->count() : 0 }} Butir Soal
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Bottom Action Area --}}
                            <div class="mt-auto pt-2 border-top border-light-subtle">
                                @if($isSelesai)
                                    <div class="nilai-box text-center">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small fw-semibold" style="font-size: 0.72rem;">Hasil Perolehan:</span>
                                            <div class="d-flex align-items-baseline">
                                                <span class="h4 fw-bold mb-0 {{ $nilai >= 75 ? 'text-success' : 'text-warning' }}">
                                                    {{ round($nilai, 1) }}
                                                </span>
                                                <span class="text-muted small ms-1" style="font-size: 0.72rem;">/ 100</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('siswa.ujian.download', $u->id) }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill d-inline-flex align-items-center justify-content-center gap-1.5 fw-semibold" style="font-size: 0.75rem; padding: 7px 14px;">
                                            <i class="mdi mdi-file-document-outline"></i> Unduh Bukti Ujian
                                        </a>
                                    </div>
                                @elseif($u->status == 'Selesai')
                                    <button class="btn btn-secondary w-100 d-inline-flex align-items-center justify-content-center gap-1.5 shadow-sm rounded-pill" disabled style="opacity: 0.7; font-size: 0.85rem; padding: 9px 16px;">
                                        <i class="mdi mdi-lock-outline"></i> <span>Ujian Telah Ditutup</span>
                                    </button>
                                @else
                                    <a href="#" data-url="{{ route('siswa.ujian.kerjakan', $u->id) }}" class="btn-kerjakan-gps btn btn-kerjakan w-100 d-inline-flex align-items-center justify-content-center gap-1.5 shadow-sm">
                                        <i class="mdi mdi-pencil-lock"></i> <span>Mulai Mengerjakan</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card card-rounded shadow-sm empty-state-card py-5">
                        <div class="card-body">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                <i class="mdi mdi-book-remove-outline text-muted fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Belum Ada Ujian Aktif</h5>
                            <p class="text-muted small mb-0 px-3">Saat ini belum ada jadwal ujian aktif untuk kelas Anda. Silakan cek kembali secara berkala.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-kerjakan-gps');
    
    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            
            // Tunjukkan status loading pada tombol
            const originalHTML = this.innerHTML;
            this.classList.add('disabled');
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memverifikasi Lokasi...';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        // Redirect ke halaman ujian dengan query param koordinat
                        window.location.href = `${url}?lat=${lat}&lng=${lng}`;
                    },
                    (error) => {
                        this.classList.remove('disabled');
                        this.innerHTML = originalHTML;
                        
                        let msg = "Akses Ujian Ditolak! Anda wajib mengaktifkan GPS dan mengizinkan akses lokasi pada browser untuk dapat mengerjakan ujian.";
                        if (error.code === error.PERMISSION_DENIED) {
                            msg = "Izin lokasi diblokir. Harap aktifkan izin lokasi untuk situs ini di pengaturan browser Anda lalu coba lagi.";
                        } else if (error.code === error.POSITION_UNAVAILABLE) {
                            msg = "Informasi lokasi tidak tersedia. Pastikan GPS perangkat Anda aktif.";
                        } else if (error.code === error.TIMEOUT) {
                            msg = "Waktu permintaan lokasi habis. Silakan coba lagi.";
                        }
                        
                        alert(msg);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                this.classList.remove('disabled');
                this.innerHTML = originalHTML;
                alert("Browser Anda tidak mendukung deteksi lokasi (Geolocation). Gunakan browser lain.");
            }
        });
    });
});
</script>
@endsection
