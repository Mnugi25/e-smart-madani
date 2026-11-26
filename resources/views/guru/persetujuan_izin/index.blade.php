@extends('template.layouts.app')

@section('title', 'Pengajuan Masuk & Persetujuan Izin')

@section('content')
<style>
    /* Modern Table */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .modern-table thead th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-size: 0.78rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 14px 16px !important;
        border-top: none !important;
        border-bottom: 1.5px solid #e2e8f0 !important;
    }
    .modern-table tbody tr {
        transition: all 0.15s ease;
        border-bottom: 1px solid #f1f5f9;
        background: transparent;
    }
    .modern-table tbody tr:last-child {
        border-bottom: none;
    }
    .modern-table tbody tr:hover {
        background-color: #f8fafc !important;
    }
    .modern-table tbody td {
        padding: 14px 16px !important;
        border-top: none !important;
        vertical-align: middle;
    }

    /* Filter Card */
    .filter-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .filter-icon-box {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-radius: 10px;
    }
    .custom-filter-select {
        height: 38px !important;
        border-radius: 10px !important;
        border: 1.5px solid #cbd5e1 !important;
        font-size: 0.88rem !important;
        font-weight: 500 !important;
        color: #1e293b !important;
        padding: 6px 36px 6px 14px !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease;
    }
    .custom-filter-select:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
    }
    .filter-stat-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    /* Action Buttons */
    .btn-action-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
    }
    .btn-action-icon i {
        font-size: 1.15rem;
        line-height: 1;
    }
    .btn-action-icon:hover {
        transform: translateY(-2px);
    }
    .btn-action-approve {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }
    .btn-action-approve:hover {
        background: #10b981;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }
    .btn-action-reject {
        background: rgba(244, 63, 94, 0.12);
        color: #e11d48;
        border: 1px solid rgba(244, 63, 94, 0.25);
    }
    .btn-action-reject:hover {
        background: #e11d48;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.3);
    }

    /* Student Avatar Initial */
    .student-avatar-initial {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        flex-shrink: 0;
    }

    /* Mobile Permit Card */
    .permit-card-mobile {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 16px;
        transition: all 0.2s ease;
    }

    /* Dark Mode Overrides */
    html.dark-mode .filter-card {
        background: linear-gradient(135deg, #18181b 0%, #1f1f23 100%) !important;
        border-color: #27272a !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark-mode .filter-icon-box {
        background: rgba(59, 130, 246, 0.18) !important;
        color: #60a5fa !important;
    }
    html.dark-mode .custom-filter-select {
        background-color: #121215 !important;
        border-color: #3f3f46 !important;
        color: #f4f4f5 !important;
    }
    html.dark-mode .filter-stat-badge {
        background: #18181b !important;
        border-color: #2e2e34 !important;
    }
    html.dark-mode .filter-stat-badge .text-muted {
        color: #a1a1aa !important;
    }
    html.dark-mode .modern-table thead th {
        background: #18181b !important;
        color: #a1a1aa !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .modern-table tbody tr {
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .modern-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
    html.dark-mode .modern-table tbody td {
        color: #e4e4e7 !important;
    }
    html.dark-mode .student-avatar-initial {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%) !important;
        color: #a5b4fc !important;
    }
    html.dark-mode .permit-card-mobile {
        background: #18181b !important;
        border-color: #27272a !important;
    }
</style>

<div class="row">
    {{-- Header Section --}}
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                    <i class="mdi mdi-email-open-outline text-primary me-2"></i>Pengajuan Surat Izin Masuk
                </h4>
                <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                    Tinjau dan verifikasi permohonan surat izin sakit atau keperluan siswa.
                </p>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-bold" style="font-size: 0.85rem;">
                    <i class="mdi mdi-clock-outline me-1"></i> {{ count($izinMasuk) }} Menunggu Verifikasi
                </span>
            </div>
        </div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-check-circle me-2 fs-5"></i>
                    <div><strong>Sukses!</strong> {{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Filter Card --}}
    <div class="col-12 mb-4">
        <div class="filter-card">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <form action="{{ route('guru.izin.index') }}" method="GET" class="d-flex align-items-center gap-2 m-0 flex-wrap flex-md-nowrap">
                    <div class="d-flex align-items-center me-1 text-nowrap">
                        <div class="filter-icon-box me-2">
                            <i class="mdi mdi-filter-variant fs-5"></i>
                        </div>
                        <span class="fw-bold text-dark small">Filter Kelas:</span>
                    </div>

                    <div style="min-width: 200px;">
                        <select name="kelas_id" class="form-select custom-filter-select" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($daftarKelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($selectedKelas)
                        <a href="{{ route('guru.izin.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1.5 fw-bold" title="Reset Filter">
                            <i class="mdi mdi-refresh me-1"></i> Reset
                        </a>
                    @endif
                </form>

                <div class="d-flex align-items-center ms-auto">
                    <div class="filter-stat-badge text-nowrap">
                        <span class="text-muted small">Total Pengajuan:</span>
                        <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ count($izinMasuk) + count($riwayatIzin) }}</strong>
                        <span class="text-muted small ms-1">Surat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 1: PENGAJUAN PENDING --}}
    <div class="col-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-inbox-arrow-down text-primary me-2"></i>Daftar Menunggu Verifikasi
                        </h5>
                        <p class="text-muted small mb-0">Permohonan izin baru yang membutuhkan persetujuan Anda.</p>
                    </div>
                </div>

                {{-- Desktop Table View --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="modern-table align-middle text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">NO</th>
                                <th class="text-center" style="width: 100px;">KELAS</th>
                                <th class="text-start">NAMA SISWA</th>
                                <th class="text-start">JENIS & ALASAN</th>
                                <th class="text-center" style="white-space: nowrap;">PERIODE TANGGAL</th>
                                <th class="text-center" style="width: 120px;">BUKTI SURAT</th>
                                <th class="text-center" style="width: 140px;">AKSI VERIFIKASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($izinMasuk as $index => $p)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                            {{ $p->siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <div class="student-avatar-initial me-3">
                                                {{ strtoupper(substr($p->siswa->nama_lengkap ?? $p->siswa->nama ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block">{{ $p->siswa->nama_lengkap ?? $p->siswa->nama ?? 'Siswa' }}</strong>
                                                <small class="text-muted"><i class="mdi mdi-card-account-details-outline me-1"></i>NISN: {{ $p->siswa->nisn ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        @if($p->jenis == 'sakit')
                                            <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-medical-bag me-1"></i> SAKIT
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-information-outline me-1"></i> KEPERLUAN / IZIN
                                            </span>
                                        @endif
                                        <div class="small text-muted mt-1" style="font-size: 0.8rem; line-height: 1.3;">
                                            "{{ Str::limit($p->alasan ?? $p->keterangan ?? '-', 45) }}"
                                        </div>
                                    </td>
                                    <td class="text-center text-nowrap" style="white-space: nowrap; font-size: 0.85rem;">
                                        <div class="fw-semibold text-dark">
                                            <i class="mdi mdi-calendar-blank-outline text-primary me-1"></i>
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}
                                        </div>
                                        @if($p->tanggal_mulai != $p->tanggal_selesai)
                                            <small class="text-muted d-block" style="font-size: 0.74rem;">
                                                s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1 fw-bold shadow-xs" data-bs-toggle="modal" data-bs-target="#modalDetailSurat{{ $p->id }}">
                                            <i class="mdi mdi-file-document-outline me-1"></i> Tinjau
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Form Setujui --}}
                                            <form action="{{ route('guru.izin.verifikasi', $p->id) }}" method="POST" class="d-inline m-0 form-verify-izin">
                                                @csrf
                                                <input type="hidden" name="status" value="setuju">
                                                <button type="button" class="btn-action-icon btn-action-approve btn-approve-action" data-action="setujui" data-nama="{{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}" title="Setujui Izin">
                                                    <i class="mdi mdi-check"></i>
                                                </button>
                                            </form>
                                            {{-- Form Tolak --}}
                                            <form action="{{ route('guru.izin.verifikasi', $p->id) }}" method="POST" class="d-inline m-0 form-verify-izin">
                                                @csrf
                                                <input type="hidden" name="status" value="tidak">
                                                <button type="button" class="btn-action-icon btn-action-reject btn-reject-action" data-action="tolak" data-nama="{{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}" title="Tolak Izin">
                                                    <i class="mdi mdi-close"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="mdi mdi-email-check-outline d-block mb-2 fs-2 opacity-50"></i>
                                        <div class="fw-bold mb-1">Kotak Masuk Kosong</div>
                                        <small class="text-muted">Tidak ada pengajuan izin siswa yang menunggu verifikasi saat ini.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View Cards --}}
                <div class="d-md-none">
                    @forelse ($izinMasuk as $p)
                        <div class="permit-card-mobile mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar-initial me-2.5" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                        {{ strtoupper(substr($p->siswa->nama_lengkap ?? $p->siswa->nama ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong class="text-dark d-block text-truncate" style="max-width: 170px; font-size: 0.95rem;">
                                            {{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}
                                        </strong>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                            {{ $p->siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                @if($p->jenis == 'sakit')
                                    <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                        SAKIT
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                        IZIN
                                    </span>
                                @endif
                            </div>

                            <div class="p-2.5 rounded-3 mb-2 small text-muted bg-light" style="font-size: 0.82rem; line-height: 1.4;">
                                "{{ $p->alasan ?? $p->keterangan ?? '-' }}"
                            </div>

                            <div class="d-flex justify-content-between align-items-center small text-muted mb-3" style="font-size: 0.76rem;">
                                <span><i class="mdi mdi-calendar-range me-1"></i>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</span>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2 border-top">
                                <button type="button" class="btn btn-outline-info rounded-pill py-2 fw-bold w-100 shadow-xs" data-bs-toggle="modal" data-bs-target="#modalDetailSurat{{ $p->id }}" style="font-size: 0.82rem;">
                                    <i class="mdi mdi-file-document-outline me-1"></i> Tinjau Berkas Lampiran
                                </button>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <form action="{{ route('guru.izin.verifikasi', $p->id) }}" method="POST" class="m-0 form-verify-izin">
                                            @csrf
                                            <input type="hidden" name="status" value="setuju">
                                            <button type="button" class="btn btn-success text-white w-100 rounded-pill py-2 fw-bold shadow-xs btn-approve-action" data-action="setujui" data-nama="{{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}" style="font-size: 0.82rem;">
                                                <i class="mdi mdi-check me-1"></i> Setuju
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{ route('guru.izin.verifikasi', $p->id) }}" method="POST" class="m-0 form-verify-izin">
                                            @csrf
                                            <input type="hidden" name="status" value="tidak">
                                            <button type="button" class="btn btn-danger text-white w-100 rounded-pill py-2 fw-bold shadow-xs btn-reject-action" data-action="tolak" data-nama="{{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}" style="font-size: 0.82rem;">
                                                <i class="mdi mdi-close me-1"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted card bg-light border-0 rounded-3">
                            <i class="mdi mdi-email-check-outline fs-2 text-muted opacity-50 mb-1"></i>
                            <span class="small">Kotak masuk izin kosong.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: RIWAYAT KEPUTUSAN PERIZINAN --}}
    <div class="col-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-history text-secondary me-2"></i>Riwayat Keputusan Perizinan
                        </h5>
                        <p class="text-muted small mb-0">Daftar arsip permohonan izin yang telah disetujui atau ditolak.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="modern-table align-middle text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">NO</th>
                                <th class="text-center" style="width: 100px;">KELAS</th>
                                <th class="text-start">NAMA SISWA</th>
                                <th class="text-start">JENIS & ALASAN</th>
                                <th class="text-center" style="white-space: nowrap;">PERIODE</th>
                                <th class="text-center" style="width: 120px;">STATUS KEPUTUSAN</th>
                                <th class="text-center" style="white-space: nowrap;">WAKTU DIVERIFIKASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatIzin as $index => $r)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                            {{ $r->siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <strong class="text-dark d-block">{{ $r->siswa->nama_lengkap ?? $r->siswa->nama ?? '-' }}</strong>
                                        <small class="text-muted">NISN: {{ $r->siswa->nisn ?? '-' }}</small>
                                    </td>
                                    <td class="text-start">
                                        <span class="badge {{ $r->jenis == 'sakit' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning' }} rounded-pill px-2.5 py-0.5" style="font-size: 0.72rem;">
                                            {{ strtoupper($r->jenis) }}
                                        </span>
                                        <div class="small text-muted mt-1" style="font-size: 0.8rem;">
                                            {{ Str::limit($r->alasan ?? $r->keterangan ?? '-', 35) }}
                                        </div>
                                    </td>
                                    <td class="text-center text-nowrap" style="white-space: nowrap; font-size: 0.82rem;">
                                        {{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d/m/Y') }}
                                        @if($r->tanggal_mulai != $r->tanggal_selesai)
                                            - {{ \Carbon\Carbon::parse($r->tanggal_selesai)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($r->status == 'disetujui')
                                            <span class="badge bg-success text-white fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-check-circle-outline me-1"></i> Disetujui
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-close-circle-outline me-1"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center text-muted text-nowrap" style="white-space: nowrap; font-size: 0.82rem;">
                                        <i class="mdi mdi-clock-outline me-1"></i>{{ $r->updated_at->format('d/m/Y H:i') }} WIB
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="mdi mdi-folder-open-outline d-block mb-1 fs-3 opacity-50"></i>
                                        <span class="small">Belum ada riwayat perizinan yang diproses.</span>
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

{{-- Modals Detail Surat Bukti --}}
@foreach ($izinMasuk as $p)
    @include('guru.persetujuan_izin.detail', ['p' => $p])
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert Konfirmasi Verifikasi Izin
    document.querySelectorAll('.btn-approve-action').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const nama = this.getAttribute('data-nama') || 'siswa';

            Swal.fire({
                title: 'Setujui Permohonan Izin?',
                text: `Apakah Anda yakin ingin menyetujui izin untuk ${nama}? Status kehadiran siswa akan otomatis tercatat sebagai Izin/Sakit.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.btn-reject-action').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const nama = this.getAttribute('data-nama') || 'siswa';

            Swal.fire({
                title: 'Tolak Permohonan Izin?',
                text: `Apakah Anda yakin ingin menolak permohonan izin dari ${nama}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tolak Izin',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
