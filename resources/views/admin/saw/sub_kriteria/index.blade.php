@extends('template.layouts.app')

@section('title', 'Data Sub-Kriteria SAW')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">

                {{-- Header Atas --}}
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold">
                            <i class="mdi mdi-format-list-checks text-primary me-2"></i>Data Sub-Kriteria SAW
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Kelola pembagian range nilai dan parameter bobot detail dari setiap kriteria utama</p>
                    </div>
                    <div>
                        <a href="/admin/saw/sub_kriteria/create" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text shadow-sm">
                            <i class="mdi mdi-plus me-2"></i> Tambah Sub-Kriteria
                        </a>
                    </div>
                </div>

                {{-- Alert Notifikasi --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="mdi mdi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Tabel Data Sub-Kriteria --}}
                <div class="table-responsive border rounded shadow-sm">
                    <table class="table table-striped table-hover align-middle m-0">
                        <thead class="table-light" style="border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th style="width: 25%; color: #4a5568;" class="fw-bold py-3">Kriteria Induk</th>
                                <th style="color: #4a5568;" class="fw-bold py-3">Keterangan / Range Parameter</th>
                                <th style="width: 20%; color: #4a5568;" class="text-center fw-bold py-3">Nilai Skor / Bobot</th>
                                <th style="width: 15%; color: #4a5568;" class="text-center fw-bold py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($subKriteria) && count($subKriteria) > 0)
                                @foreach($subKriteria as $sub)
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary text-dark fw-bold me-1">{{ $sub->kriteriaSaw->kode ?? '-' }}</span>
                                            <strong class="text-dark">{{ $sub->kriteriaSaw->nama_kriteria ?? 'Kriteria Dihapus' }}</strong>
                                        </td>
                                        <td class="text-dark fw-medium">{{ $sub->keterangan }}</td>
                                        <td class="text-center fw-bold text-primary fs-6">{{ $sub->nilai }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Tombol Edit --}}
                                                <a href="/admin/saw/sub_kriteria/{{ $sub->id }}/edit" class="btn btn-warning btn-sm p-2 text-white" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>

                                                {{-- Form Hapus Data --}}
                                                <form action="/admin/saw/sub_kriteria/{{ $sub->id }}" method="POST" onsubmit="return confirm('Hapus sub-kriteria {{ $sub->keterangan }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm p-2 text-white" title="Hapus">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-alert-circle-outline d-block mb-2 fs-3 text-secondary"></i>
                                        Belum ada data sub-kriteria yang tersimpan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
