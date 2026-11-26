@extends('template.layouts.app')

@section('title', 'Edit Kriteria SAW')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">

                {{-- Header Form Edit --}}
                <div class="mb-4">
                    <h4 class="card-title card-title-dash fw-bold text-dark">
                        <i class="mdi mdi-pencil-box-outline text-warning me-2"></i>Ubah Data Kriteria SAW
                    </h4>
                    <p class="card-subtitle card-subtitle-dash">Sesuaikan bobot atau tipe kriteria pencarian sistem pakar</p>
                </div>

                {{-- Form Update --}}
                {{-- FIX: Action diarahkan ke URL operator --}}
                <form action="/admin/saw/kriteria/{{ $kriteria->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Input Kode (Readonly) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Kode Kriteria</label>
                        <input type="text" class="form-control text-dark bg-light fw-bold" name="kode" value="{{ old('kode', $kriteria->kode) }}" readonly style="border-radius: 6px;">
                        <small class="text-muted" style="font-size: 11px;">Kode kriteria bersifat permanen untuk mengunci rumus database.</small>
                    </div>

                    {{-- Input Nama Kriteria --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Nama Kriteria</label>
                        <input type="text" class="form-control text-dark @error('nama_kriteria') is-invalid @enderror" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required style="border-radius: 6px;">
                        @error('nama_kriteria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Bobot Kriteria --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Bobot Kriteria (W)</label>
                        <input type="number" step="0.01" class="form-control text-dark @error('bobot') is-invalid @enderror" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required style="border-radius: 6px;">
                        @error('bobot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Tipe / Jenis --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Tipe Kriteria</label>
                        <select class="form-select text-dark @error('tipe') is-invalid @enderror" name="tipe" required style="border-radius: 6px;">
                            <option value="benefit" {{ old('tipe', $kriteria->tipe) == 'benefit' ? 'selected' : '' }}>Benefit (Makin Besar Makin Bagus)</option>
                            <option value="cost" {{ old('tipe', $kriteria->tipe) == 'cost' ? 'selected' : '' }}>Cost (Makin Kecil Makin Bagus)</option>
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Navigasi Bawah --}}
                    <div class="d-flex justify-content-between border-top pt-3">
                        {{-- FIX: Href diarahkan kembali ke halaman utama kriteria operator --}}
                        <a href="/admin/saw/kriteria" class="btn btn-outline-secondary fw-bold px-4">
                            <i class="mdi mdi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold px-4">
                            <i class="mdi mdi-content-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
