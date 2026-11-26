@extends('template.layouts.app')

@section('title', 'Pengajuan Izin & Sakit')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title fw-bold">
                            <i class="mdi mdi-email-multiple text-primary me-2"></i>Riwayat Pengajuan Izin & Sakit
                        </h4>
                        <p class="card-subtitle mb-0 text-muted">Kelola dan pantau status pengajuan izin atau sakit Anda</p>
                    </div>
                    <div class="mt-3 mt-sm-0">
                        <button type="button" class="btn btn-primary btn-lg fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahIzin">
                            <i class="mdi mdi-plus-circle me-1"></i> Tambah Pengajuan
                        </button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="mdi mdi-alert-circle me-2"></i> Terdapat kesalahan pada input Anda. Silakan cek kembali form pengajuan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarIzin as $index => $izin)
                                <tr>
                                    <td>{{ $daftarIzin->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge {{ $izin->jenis == 'sakit' ? 'bg-danger' : 'bg-info' }}">
                                            {{ ucfirst($izin->jenis) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                        @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                            s/d {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $izin->alasan }}</td>
                                    <td>
                                        @php
                                            $statusClass = match(strtolower($izin->status)) {
                                                'pending'   => 'bg-warning',
                                                'disetujui' => 'bg-success',
                                                'ditolak'   => 'bg-danger',
                                                default     => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($izin->status) }}</span>
                                    </td>
                                    <td>
                                        @if($izin->file_bukti)
                                            <a href="{{ asset('storage/' . $izin->file_bukti) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                Lihat
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada riwayat pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $daftarIzin->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH PENGAJUAN --}}
<div class="modal fade" id="modalTambahIzin" tabindex="-1" aria-labelledby="modalTambahIzinLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header modal-header-premium p-4 border-0">
                <h5 class="modal-title fw-bold text-white" id="modalTambahIzinLabel">
                    <i class="mdi mdi-email-plus me-2"></i>Buat Pengajuan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.izin.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Jenis Pengajuan</label>
                        <div class="d-flex gap-3">
                            <div class="flex-fill">
                                <input type="radio" class="btn-check" name="jenis" id="typeSakit" value="sakit" required>
                                <label class="btn btn-outline-danger w-100 py-3 rounded-4 fw-bold" for="typeSakit">
                                    <i class="mdi mdi-medical-bag d-block fs-3 mb-1"></i>SAKIT
                                </label>
                            </div>
                            <div class="flex-fill">
                                <input type="radio" class="btn-check" name="jenis" id="typeIzin" value="izin">
                                <label class="btn btn-outline-info w-100 py-3 rounded-4 fw-bold" for="typeIzin">
                                    <i class="mdi mdi-account-alert d-block fs-3 mb-1"></i>IZIN
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Mata Pelajaran</label>
                        <select name="mapel_id" id="mapel_select" class="form-select bg-light border-0 @error('mapel_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel['id'] }}" data-guru="{{ $mapel['guru'] }}">{{ $mapel['nama'] }}</option>
                            @endforeach
                        </select>
                        @error('mapel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Guru Pengampu</label>
                        <input type="text" id="guru_pengampu" class="form-control bg-light border-0" readonly placeholder="Pilih mata pelajaran terlebih dahulu...">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Mulai Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-calendar"></i></span>
                                <input type="date" name="tanggal_mulai" class="form-control bg-light border-start-0 @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Sampai Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-calendar"></i></span>
                                <input type="date" name="tanggal_selesai" class="form-control bg-light border-start-0 @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ALASAN</label>
                        <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="3" placeholder="Contoh: Sakit demam dan butuh istirahat..." required>{{ old('alasan') }}</textarea>
                        @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-muted">FILE BUKTI (Opsional)</label>
                        <input type="file" name="file_bukti" class="form-control @error('file_bukti') is-invalid @enderror">
                        <div class="form-text small opacity-75">Format: JPG, PNG, JPEG. Max: 2MB. Boleh dikosongkan jika tidak ada.</div>
                        @error('file_bukti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm">
                        <i class="mdi mdi-send me-1"></i> Kirim Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk auto-show modal jika ada error validation --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahIzin'));
        myModal.show();
    });
</script>
@endif

<script>
    document.getElementById('mapel_select').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var guru = selectedOption.getAttribute('data-guru');
        document.getElementById('guru_pengampu').value = guru || 'Data guru tidak tersedia';
    });
</script>

@endsection
