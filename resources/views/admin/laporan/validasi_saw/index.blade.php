@extends('template.layouts.app')

@section('title', 'Laporan Hasil Keputusan SAW')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">

                {{-- 1. HEADER HALAMAN --}}
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold">
                            <i class="mdi mdi-chart-bar text-primary me-2"></i>Laporan Hasil Keputusan SAW (Prioritas Izin)
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Rekomendasi persetujuan izin otomatis berdasarkan pembobotan nilai kriteria</p>
                    </div>
                    <div>
                        <button onclick="window.print()" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text shadow-sm">
                            <i class="mdi mdi-printer me-2"></i> Cetak Hasil Perangkingan
                        </button>
                    </div>
                </div>

                {{-- 2. KONDISI JIKA DATA KOSONG --}}
                @if(isset($pesan) || empty($hasil))
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center py-4" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-3 fs-3 text-warning"></i>
                        <div>
                            <span class="fw-bold d-block">Tidak Ada Antrean</span>
                            {{ $pesan ?? 'Tidak ada pengajuan izin berstatus pending yang perlu dihitung.' }}
                        </div>
                    </div>
                @else

                    {{-- 3. INFORMASI METODE --}}
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                        <i class="mdi mdi-information-outline me-3 fs-4 text-info"></i>
                        <div>
                            Sistem secara otomatis mengurutkan pengajuan izin siswa yang berstatus <strong>Pending</strong>.
                            Semakin tinggi <strong>Skor Akhir (V)</strong>, semakin mendesak atau berprioritas tinggi pengajuan tersebut untuk segera disetujui.
                        </div>
                    </div>

                    {{-- 4. TABEL DATA RANGKING SAW --}}
                    <div class="table-responsive border rounded shadow-sm">
                        <table class="table table-striped table-hover align-middle m-0">
                            <thead class="table-light" style="border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th style="width: 8%; color: #4a5568;" class="text-center fw-bold py-3">Rank</th>
                                    <th style="color: #4a5568;" class="fw-bold py-3">Nama Siswa</th>
                                    <th style="width: 15%; color: #4a5568;" class="fw-bold py-3">Jenis Izin</th>

                                    {{-- Kolom Kriteria Berubah Otomatis Mengikuti Database --}}
                                    @foreach($kriteria as $k)
                                        <th style="width: 12%; color: #4a5568;" class="text-center fw-bold py-3" title="{{ $k->nama_kriteria }}">
                                            {{ $k->kode }} ({{ ucfirst($k->tipe) }})
                                        </th>
                                    @endforeach

                                    <th style="width: 15%; color: #4a5568;" class="text-center fw-bold py-3">Skor Akhir (V)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil as $index => $item)
                                    {{-- Khusus Rank 1 dikasih background ijo tipis biar mencolok --}}
                                    <tr style="{{ $index == 0 ? 'background-color: rgba(25, 135, 84, 0.06);' : '' }}">

                                        {{-- Kolom Nomor Urut / Piala --}}
                                        <td class="text-center">
                                            @if($index == 0)
                                                <span class="badge bg-warning text-dark fw-bold px-2 py-2" style="font-size: 0.85rem;">
                                                    <i class="mdi mdi-trophy text-danger me-1"></i> 1
                                                </span>
                                            @else
                                                <span class="fw-bold text-dark">{{ $index + 1 }}</span>
                                            @endif
                                        </td>

                                        {{-- Nama Siswa --}}
                                        <td class="text-dark fw-bold">
                                            {{ $item['nama_siswa'] }}
                                        </td>

                                        {{-- Jenis Izin --}}
                                        <td class="text-nowrap">
                                            <span class="badge bg-light text-dark border fw-bold px-3 py-2" style="border-radius: 4px;">
                                                {{ strtoupper($item['jenis_izin']) }}
                                            </span>
                                        </td>

                                        {{-- Nilai Matriks Dinamis (Nilai Asli & Nilai R) --}}
                                        @foreach($kriteria as $k)
                                            <td class="text-center">
                                                <span class="text-dark fw-bold d-block">
                                                    {{ $item['matriks'][$k->kode]['nilai_asli'] ?? '-' }}
                                                </span>
                                                @if(isset($item['matriks'][$k->kode]['terormalisasi']))
                                                    <small class="text-muted" style="font-size: 10px;">
                                                        R: {{ $item['matriks'][$k->kode]['terormalisasi'] }}
                                                    </small>
                                                @endif
                                            </td>
                                        @endforeach

                                        {{-- Total Skor Akhir (V) --}}
                                        <td class="text-center text-nowrap">
                                            <span class="fw-bold {{ $index == 0 ? 'text-success fs-5' : 'text-primary fs-6' }}">
                                                {{ $item['skor_akhir'] }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>
        </div>
    </div>
</div>
@endsection
