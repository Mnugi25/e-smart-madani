@extends('template.layouts.app')

@section('title', 'Daftar Pengumpulan Tugas')

@section('content')
<style>
    .btn-bright-danger {
        background-color: #ff3131 !important;
        color: white !important;
        border: none !important;
    }
    .sticky-action-bar {
        position: sticky;
        top: 70px;
        z-index: 100;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 15px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
</style>

<form action="{{ route('guru.tugas.nilai_massal', $tugas->id) }}" method="POST">
    @csrf
    <div class="row mt-4">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-warning-subtle p-2 rounded-3 me-3">
                        <i class="mdi mdi-account-group text-warning fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">Status Pengumpulan & Penilaian</h3>
                        <p class="text-muted small mb-0">{{ $tugas->jadwal->kelas->nama_kelas }} | {{ $tugas->judul }}</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('guru.tugas', $tugas->jadwal_id) }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
                        <i class="mdi mdi-arrow-left me-1"></i> KEMBALI
                    </a>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                        <i class="mdi mdi-content-save me-1"></i> SIMPAN  NILAI
                    </button>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
                    <i class="mdi mdi-check-circle me-2"></i><strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="col-12">
            <div class="card card-rounded shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Daftar Siswa</h4>
                            <p class="text-muted small mb-0">
                                Total: <strong>{{ $siswas->count() }}</strong> |
                                Mengumpulkan: <strong class="text-success">{{ $siswas->filter(fn($s) => $s->pengumpulan->isNotEmpty() && !empty($s->pengumpulan->first()->link_tugas))->count() }}</strong> |
                                Belum: <strong class="text-danger">{{ $siswas->filter(fn($s) => $s->pengumpulan->isEmpty() || empty($s->pengumpulan->first()->link_tugas))->count() }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 rounded-start">No</th>
                                    <th class="border-0">NISN</th>
                                    <th class="border-0">Nama Siswa</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Jam</th>
                                    <th class="border-0">Link / Catatan</th>
                                    <th class="border-0 rounded-end">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $index => $siswa)
                                    @php
                                        $pengumpulan = $siswa->pengumpulan->first();
                                        $hasRecord = $pengumpulan ? true : false;
                                        $isSubmitted = ($pengumpulan && !empty($pengumpulan->link_tugas)) ? true : false;
                                    @endphp
                                    <tr class="align-middle">
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-muted small">{{ $siswa->nisn }}</td>
                                        <td class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</td>
                                        <td class="text-center">
                                            @if($isSubmitted)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                                    <i class="mdi mdi-check-circle me-1"></i> Sudah
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">
                                                    <i class="mdi mdi-close-circle me-1"></i> Belum
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isSubmitted)
                                                <span class="small text-dark fw-bold"><i class="mdi mdi-calendar-outline me-1"></i>{{ $pengumpulan->created_at->format('d/m/Y') }}</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isSubmitted)
                                                <span class="small text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $pengumpulan->created_at->format('H:i') }}</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isSubmitted)
                                                <a href="{{ $pengumpulan->link_tugas }}" target="_blank" class="text-info text-decoration-none fw-bold d-block mb-1">
                                                    <i class="mdi mdi-link-variant me-1"></i> Buka Link
                                                </a>
                                                <small class="text-muted d-block text-truncate" style="max-width: 150px;" title="{{ $pengumpulan->catatan }}">
                                                    {{ $pengumpulan->catatan ?? 'Tidak ada catatan.' }}
                                                </small>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="number" name="nilai[{{ $siswa->id }}]"
                                                   class="form-control form-control-sm border bg-white rounded-pill px-3"
                                                   style="width: 80px;"
                                                   value="{{ $hasRecord ? ($pengumpulan->nilai ?? 0) : 0 }}"
                                                   min="0" max="100" placeholder="0">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
