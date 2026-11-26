@extends('template.layouts.app')

@section('title', 'Data Kriteria SAW')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">

                {{-- Header Atas --}}
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold">
                            <i class="mdi mdi-format-list-bulleted text-primary me-2"></i>Data Kriteria SAW
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Kelola kode, nama, bobot, dan tipe kriteria untuk perhitungan bobot prioritas izin</p>
                    </div>
                    <div>
                        <button class="btn btn-primary text-white btn-lg fw-bold btn-icon-text shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKriteria">
                            <i class="mdi mdi-plus me-2"></i> Tambah Kriteria
                        </button>
                    </div>
                </div>

                {{-- Alert Notifikasi Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="mdi mdi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Tabel Data Kriteria --}}
                <div class="table-responsive border rounded shadow-sm">
                    <table class="table table-striped table-hover align-middle m-0">
                        <thead class="table-light" style="border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th style="width: 10%; color: #4a5568;" class="text-center fw-bold py-3">Kode</th>
                                <th style="color: #4a5568;" class="fw-bold py-3">Nama Kriteria</th>
                                <th style="width: 20%; color: #4a5568;" class="text-center fw-bold py-3">Bobot (W)</th>
                                <th style="width: 20%; color: #4a5568;" class="text-center fw-bold py-3">Tipe</th>
                                <th style="width: 15%; color: #4a5568;" class="text-center fw-bold py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($kriteria) && count($kriteria) > 0)
                                @foreach($kriteria as $k)
                                    <tr>
                                        <td class="text-center fw-bold text-primary">{{ $k->kode }}</td>
                                        <td class="text-dark fw-bold">{{ $k->nama_kriteria }}</td>
                                        <td class="text-center fw-bold text-dark">{{ $k->bobot }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $k->tipe == 'benefit' ? 'bg-success' : 'bg-info' }} text-white fw-bold px-3 py-2" style="border-radius: 4px;">
                                                {{ strtoupper($k->tipe) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Tombol Edit Mengarah ke Halaman Edit Terpisah --}}
                                                <a href="/admin/saw/kriteria/{{ $k->id }}/edit" class="btn btn-warning btn-sm p-2 text-white" title="Edit Kriteria">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>

                                                {{-- Form Hapus Data - Menggunakan URL Konsisten --}}
                                                <form action="/admin/saw/kriteria/{{ $k->id }}" method="POST" onsubmit="return confirm('Hapus kriteria {{ $k->nama_kriteria }}? Tindakan ini juga akan menghapus data sub-kriteria di dalamnya.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm p-2 text-white" title="Hapus Kriteria">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-alert-circle-outline d-block mb-2 fs-3 text-secondary"></i>
                                        Belum ada data kriteria SAW yang tersimpan.
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

{{-- MODAL TAMBAH DATA (POP-UP) --}}
<div class="modal fade" id="modalTambahKriteria" tabindex="-1" aria-labelledby="modalTambahKriteriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        {{-- Form Action disesuaikan ke endpoint simpan kriteria operator --}}
        <form action="/admin/saw/kriteria" method="POST" class="modal-content card card-rounded">
            @csrf
            <div class="modal-header border-0 shadow-sm py-3">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahKriteriaLabel">
                    <i class="mdi mdi-plus-box text-primary me-2"></i>Tambah Kriteria Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Kode Kriteria</label>
                    <input type="text" class="form-control text-dark" name="kode" placeholder="Contoh: C1" required style="border-radius: 6px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Nama Kriteria</label>
                    <input type="text" class="form-control text-dark" name="nama_kriteria" placeholder="Contoh: Urgensi Alasan" required style="border-radius: 6px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Bobot Kriteria (W)</label>
                    <input type="number" step="0.01" class="form-control text-dark" name="bobot" placeholder="Contoh: 0.35" required style="border-radius: 6px;">
                    <small class="text-muted" style="font-size: 11px;">Gunakan titik (.) untuk desimal. Total seluruh bobot kriteria idealnya bernilai 1.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Tipe Kriteria</label>
                    <select class="form-select text-dark" name="tipe" required style="border-radius: 6px;">
                        <option value="benefit">Benefit (Semakin besar nilai asli, skor rangking naik)</option>
                        <option value="cost">Cost (Semakin kecil nilai asli, skor rangking naik)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                <button type="button" class="btn btn-secondary text-dark fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
