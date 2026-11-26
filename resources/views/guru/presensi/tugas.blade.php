@extends('template.layouts.app')

@section('title', 'Ruang Tugas')

@section('content')
<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold text-dark mb-0">
                    <i class="mdi mdi-assignment-outline text-warning me-2"></i>Ruang Tugas
                </h3>
                <p class="text-muted small">Kelola penugasan siswa untuk kelas <strong>{{ $jadwal->kelas->nama_kelas }}</strong></p>
            </div>
            <a href="{{ route('guru.jadwal') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">
                <i class="mdi mdi-arrow-left me-1"></i> KEMBALI
            </a>
        </div>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card card-rounded shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Daftar Penugasan: {{ $jadwal->mataPelajaran->nama_mapel }}</h5>
                    <button class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm">
                        <i class="mdi mdi-plus me-1"></i> BUAT TUGAS BARU
                    </button>
                </div>

                <div class="text-center py-5">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                        <i class="mdi mdi-clipboard-text-outline display-3 text-muted"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Belum ada tugas yang dibuat.</h5>
                    <p class="text-muted small">Klik tombol "Buat Tugas Baru" untuk memberikan latihan atau proyek kepada siswa.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
