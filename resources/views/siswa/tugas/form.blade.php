<style>
    /* Table Responsive for Mobile */
    @media (max-width: 767px) {
        .table thead { display: none; }
        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }
        .table tr {
            margin-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .table td {
            text-align: left !important;
            padding: 0.5rem 1rem !important;
        }
        .table td:first-child {
            font-weight: bold;
            border-bottom: none;
            padding-bottom: 0.25rem !important;
        }
        .table td:last-child {
            padding-top: 0 !important;
        }
    }
</style>

@extends('template.layouts.app')

@section('title', 'Kumpulkan Tugas')

@section('content')
<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm">
            <h4 class="fw-bold text-dark mb-0 ms-2">
                <i class="mdi mdi-cloud-upload text-primary me-2"></i>Kumpulkan Tugas
            </h4>
            <a href="{{ route('siswa.tugas', $tugas->jadwal_id) }}" class="btn btn-light rounded-pill px-4 fw-bold text-muted border">
                <i class="mdi mdi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="col-lg-10 mx-auto">
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-4 mb-4">
                <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <form action="{{ route('siswa.tugas.submit', $tugas->id) }}" method="POST">
                        @csrf
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th colspan="2" class="p-3 fw-bold text-dark">Informasi Tugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 30%;">Mata Pelajaran</td>
                                    <td class="fw-bold">{{ $tugas->jadwal->mataPelajaran->nama_mapel }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Judul Tugas</td>
                                    <td class="fw-bold text-primary">{{ $tugas->judul }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Batas Waktu</td>
                                    <td>
                                        @php
                                            $deadlineObj = $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline) : null;
                                            $isPastDeadline = $deadlineObj && now()->isAfter($deadlineObj);
                                        @endphp
                                        <span class="{{ $isPastDeadline ? 'text-danger fw-bold' : '' }}">
                                            <i class="mdi mdi-clock-outline me-1"></i>
                                            {{ $deadlineObj ? $deadlineObj->translatedFormat('d M Y, H:i') : 'Tanpa Batas' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Instruksi</td>
                                    <td style="white-space: pre-wrap; line-height: 1.6;">{{ $tugas->deskripsi }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="p-3 bg-light fw-bold text-dark">Pengumpulan Anda</th>
                                </tr>
                                <tr>
                                    <td class="text-muted">Link Tugas</td>
                                    <td>
                                        <input type="url" name="link_tugas" class="form-control"
                                               placeholder="https://..."
                                               value="{{ $pengumpulan->link_tugas ?? old('link_tugas') }}"
                                               {{ $isPastDeadline ? 'disabled' : 'required' }}>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="2" class="p-3 text-center">
                                        @if($isPastDeadline)
                                            <button type="button" class="btn btn-danger rounded-pill w-100" disabled>Pengumpulan Ditutup</button>
                                        @else
                                            <button type="submit" class="btn btn-primary rounded-pill w-100 px-5">
                                                {{ $pengumpulan ? 'Perbarui Pengumpulan' : 'Kirim Tugas' }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
