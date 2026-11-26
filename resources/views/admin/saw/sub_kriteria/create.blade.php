@extends('template.layouts.app')

@section('title', 'Tambah Sub-Kriteria SAW')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">
                <h4 class="card-title fw-bold text-dark mb-4">
                    <i class="mdi mdi-plus-box text-primary me-2"></i>Tambah Sub-Kriteria Baru
                </h4>

                <form action="/admin/saw/sub_kriteria" method="POST">
                    @csrf

                    {{-- Pilih Kriteria Utama --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Pilih Kriteria Utama</label>
                        <select class="form-select text-dark" name="kriteria_saw_id" required style="border-radius: 6px;">
                            <option value="" disabled selected>-- Pilih Kriteria Hubungan --</option>
                            @foreach($kriteria as $k)
                                <option value="{{ $k->id }}">[{{ $k->kode }}] {{ $k->nama_kriteria }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Keterangan Sub --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Keterangan Parameter</label>
                        <input type="text" class="form-control text-dark" name="keterangan" placeholder="Contoh: Sangat Mendesak / Rawat Inap" required style="border-radius: 6px;">
                    </div>

                    {{-- Nilai Skor --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Nilai Skor Parameter</label>
                        <input type="number" step="0.01" class="form-control text-dark" name="nilai" placeholder="Contoh: 1 atau 4 atau 100" required style="border-radius: 6px;">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <a href="/admin/saw/sub_kriteria" class="btn btn-secondary text-dark fw-bold px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary text-white fw-bold px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
