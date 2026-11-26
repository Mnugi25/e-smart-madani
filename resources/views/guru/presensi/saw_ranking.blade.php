@extends('template.layouts.app')

@section('title', 'Perankingan SAW')

@section('content')
<style>
    /* CSS Responsif */
    @media (max-width: 991px) {
        .table-view { display: none !important; }
        .mobile-view { display: block !important; }
        .mt-mobile { margin-top: 25px !important; }
    }
    .mobile-view { display: none; }

    .card-saw { border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s; }
    .card-saw:hover { transform: translateY(-3px); }
    .rank-badge { position: absolute; top: 10px; right: 10px; font-size: 1.2rem; }
</style>

@php
    $rankedHasil = [];
    $currentRank = 1;
    $prevSkor = null;
    foreach (($hasilSaw ?? []) as $index => $res) {
        $skor = $res['skor_v'] ?? 0;
        if ($prevSkor !== null && $skor < $prevSkor) {
            $currentRank = $index + 1;
        }
        $res['rank'] = $currentRank;
        $rankedHasil[] = $res;
        $prevSkor = $skor;
    }
    $hasilSaw = $rankedHasil;
@endphp

<div class="row mt-mobile">
    <div class="col-12 mb-3">
        <a href="{{ route('guru.rekap') }}" class="btn btn-sm btn-dark text-white text-small mb-3 shadow-sm px-3 rounded-pill">Kembali</a>

        <div class="card bg-gradient-primary text-white card-rounded shadow-sm mb-4" style="background: linear-gradient(135deg, #1F3BB3, #4B6AD6);">
            <div class="card-body d-flex align-items-center p-4">
                <i class="mdi mdi-trophy-award text-warning me-3" style="font-size: 3rem;"></i>
                <div>
                    <h3 class="fw-bold mb-1" style="font-size: 1.4rem;">Rekomendasi Siswa Terdisiplin</h3>
                    <p class="mb-0 text-white-50 text-small">
                        Kelas: {{ $jadwalAktif->kelas->nama_kelas ?? '-' }} |
                        Mapel: {{ $jadwalAktif->mataPelajaran->nama_mapel ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- FORM FILTER KELAS --}}
        <div class="card card-rounded shadow-sm mb-4 border-0" style="background: #f8f9fa;">
            <div class="card-body p-3">
                <form action="{{ route('guru.saw.hitung') }}" method="GET" class="row g-2">
                    <div class="col-md-9 col-sm-12">
                        <label class="form-label small fw-bold text-dark">Pilih Kelas Untuk Perankingan</label>
                        <select name="jadwal_id" class="form-select border-primary shadow-sm" required>
                            @foreach($daftarJadwal as $dj)
                                <option value="{{ $dj->id }}" {{ $jadwalAktif->id == $dj->id ? 'selected' : '' }}>
                                    {{ $dj->kelas->nama_kelas }} - {{ $dj->mataPelajaran->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            <i class="mdi mdi-calculator"></i> Hitung Ranking
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Menampilkan Pesan Jika Ada --}}
        @if(isset($message) && $message)
            <div class="alert alert-warning mb-4 shadow-xs">
                <i class="mdi mdi-alert-circle"></i> {{ $message }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-xs" role="alert">
                <i class="mdi mdi-check-circle text-success me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title fw-bold text-dark mb-4"><i class="mdi mdi-format-list-numbered text-primary"></i> Tabel Peringkat Nilai Preferensi (V)</h4>

                {{-- 1. TAMPILAN MOBILE (Stacked Cards) --}}
                <div class="mobile-view">
                    @forelse (($hasilSaw ?? []) as $index => $res)
                        @php $ranking = $res['rank'] ?? ($index + 1); @endphp
                        <div class="card card-saw mb-3 border {{ $ranking == 1 ? 'border-success' : '' }}" style="{{ $ranking == 1 ? 'background: #f0fdf4;' : '' }}">
                            <div class="card-body p-3 position-relative">
                                <div class="rank-badge">
                                    @if($ranking == 1)
                                        <span class="badge bg-warning text-dark fw-bold"><i class="mdi mdi-star"></i> 1</span>
                                    @else
                                        <span class="badge bg-light text-dark fw-bold">#{{ $ranking }}</span>
                                    @endif
                                </div>

                                <div class="mb-2">
                                    <h6 class="fw-bold mb-0 text-dark">{{ $res['nama'] ?? 'Tanpa Nama' }}</h6>
                                    <small class="text-muted">NISN: {{ $res['nisn'] ?? '-' }}</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Skor Preferensi:</div>
                                        <div class="fw-bold fs-5 text-primary">{{ number_format($res['skor_v'] ?? 0, 4) }}</div>
                                    </div>
                                    <div class="text-end">
                                        @if($res['warning'])
                                            <span class="badge bg-danger text-white mb-2 d-block" style="font-size: 0.65rem;">
                                                <i class="mdi mdi-alert"></i> Peringatan: {{ $res['total_alpa'] }}x Alpa
                                            </span>
                                        @endif

                                        @if($ranking == 1 && isset($res['siswa_id']))
                                            <form action="/guru/presensi/saw/rilis" method="POST">
                                                @csrf
                                                <input type="hidden" name="siswa_id" value="{{ $res['siswa_id'] }}">
                                                <input type="hidden" name="skor" value="{{ $res['skor_v'] }}">
                                                <button type="submit" class="btn btn-success btn-sm text-white px-3 shadow-sm rounded-pill">
                                                    <i class="mdi mdi-cloud-upload"></i> Rilis
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted bg-light rounded-8">
                            <i class="mdi mdi-calculator-off mb-2" style="font-size: 2.5rem; display: block;"></i>
                            Data perankingan belum tersedia untuk kelas ini.
                        </div>
                    @endforelse
                </div>

                {{-- 2. TAMPILAN DESKTOP (Table) --}}
                <div class="table-responsive table-view">
                    <table class="table table-hover align-middle text-center">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="text-center" width="8%">Rank</th>
                                <th class="text-start" width="35%">Nama Siswa</th>
                                <th class="text-start" width="22%">Peringatan</th>
                                <th class="text-start" width="18%">Skor Preferensi (V)</th>
                                <th class="text-center" width="17%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse (($hasilSaw ?? []) as $index => $res)
                                 @php $ranking = $res['rank'] ?? ($index + 1); @endphp
                                <tr class="{{ $ranking == 1 ? 'table-success' : '' }}" style="{{ $ranking == 1 ? '--bs-table-bg: rgba(40, 167, 69, 0.08);' : '' }}">
                                    <td class="text-center">
                                        @if($ranking == 1)
                                            <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="mdi mdi-star"></i> 1</span>
                                        @else
                                            <span class="badge bg-light text-dark fw-bold px-2 py-1">{{ $ranking }}</span>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        <div class="{{ $ranking == 1 ? 'text-dark fw-bold' : 'text-dark' }}">
                                            {{ $res['nama'] ?? 'Tanpa Nama' }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">NISN: {{ $res['nisn'] ?? '-' }}</small>
                                    </td>
                                    <td class="text-start">
                                        @if($res['warning'])
                                            <span class="badge bg-danger text-white py-1 px-2 fw-bold" style="font-size: 0.7rem;">
                                                <i class="mdi mdi-alert-decagram"></i> Peringatan: {{ $res['total_alpa'] }}x Alpa
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-start fw-bold {{ $ranking == 1 ? 'text-primary' : 'text-muted' }}" style="{{ $ranking == 1 ? 'font-size: 1.1rem;' : '' }}">
                                        {{ number_format($res['skor_v'] ?? 0, 4) }}
                                    </td>
                                  {{--    <td class="text-center">
                                        @if($ranking == 1 && isset($res['siswa_id']))
                                            <form action="/guru/presensi/saw/rilis" method="POST">
                                                @csrf
                                                <input type="hidden" name="siswa_id" value="{{ $res['siswa_id'] }}">
                                                <input type="hidden" name="skor" value="{{ $res['skor_v'] }}">
                                                <button type="submit" class="btn btn-success btn-xs text-white px-3 shadow-sm rounded-pill">
                                                    <i class="mdi mdi-cloud-upload"></i> Rilis Juara
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-small text-muted">-</span>
                                        @endif
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="mdi mdi-calculator-off mb-2" style="font-size: 2.5rem; display: block;"></i>
                                        Data perankingan belum tersedia untuk kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
