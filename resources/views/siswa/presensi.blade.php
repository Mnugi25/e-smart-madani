@extends('template.layouts.app')

@section('title', 'Presensi Mandiri')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body text-center py-5">
                <i class="mdi mdi-fingerprint text-primary mb-4" style="font-size: 5rem;"></i>
                <h3 class="fw-bold text-dark mb-2">Presensi Mandiri</h3>
                <p class="text-muted mb-4 px-lg-5">
                    Silakan lakukan absensi kehadiran untuk mata pelajaran yang sedang berlangsung saat ini.
                </p>

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                        <i class="mdi mdi-alert-circle me-1"></i> {{ session('error') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
                        <i class="mdi mdi-information me-1"></i> {{ session('info') }}
                    </div>
                @endif

                @if($jadwalSekarang)
                    <div class="card bg-light border-0 rounded-3 mb-4 text-start">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Detail Pelajaran Aktif</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1 text-muted small">Mata Pelajaran</p>
                                    <p class="fw-bold">{{ $jadwalSekarang->mataPelajaran->nama_mapel }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1 text-muted small">Guru</p>
                                    <p class="fw-bold">{{ $jadwalSekarang->guru->nama_lengkap }}</p>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <p class="mb-1 text-muted small">Waktu</p>
                                    <p class="fw-bold text-primary">{{ $jadwalSekarang->jam_mulai }} - {{ $jadwalSekarang->jam_selesai }}</p>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <p class="mb-1 text-muted small">Status Anda</p>
                                    @if($sudahAbsen)
                                        <span class="badge bg-success px-3 py-2">SUDAH ABSEN</span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2">BELUM ABSEN</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$sudahAbsen)
                        <form action="{{ route('siswa.presensi.submit') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-3">
                                <i class="mdi mdi-check-circle me-2"></i> KIRIM KEHADIRAN SEKARANG
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success border-0 shadow-sm py-3">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-check-decagram me-1"></i> Terima kasih! Anda sudah tercatat hadir.</h6>
                        </div>
                        <a href="{{ route('siswa.riwayat') }}" class="btn btn-outline-secondary w-100 fw-bold mt-2">
                            Lihat Riwayat Kehadiran
                        </a>
                    @endif
                @else
                    <div class="alert alert-secondary border-0 py-4">
                        <i class="mdi mdi-clock-alert fs-2 mb-2 d-block"></i>
                        <h5 class="fw-bold text-dark">Tidak Ada Jadwal Aktif</h5>
                        <p class="mb-0 small">Saat ini tidak ada mata pelajaran yang sedang berlangsung untuk kelas Anda.</p>
                    </div>
                    <a href="{{ route('siswa.jadwal') }}" class="btn btn-outline-primary w-100 fw-bold mt-3">
                        Cek Jadwal Pelajaran
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
