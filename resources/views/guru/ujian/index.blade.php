@extends('template.layouts.app')

@section('title', 'Manajemen Ujian Online')

@section('content')
<style>
    /* Modern Stats Cards */
    .stat-card-modern {
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        background: #ffffff !important;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02) !important;
    }
    .stat-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
    }
    .stat-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

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

    /* Action Buttons */
    .btn-action-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 700;
        border-radius: 9px;
        text-decoration: none;
        transition: all 0.2s ease;
        height: 34px;
        border: 1px solid transparent;
    }
    .btn-action-soal {
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-color: rgba(37, 99, 235, 0.25);
    }
    .btn-action-soal:hover {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        transform: translateY(-2px);
    }
    .btn-action-rekap {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.25);
    }
    .btn-action-rekap:hover {
        background: #10b981;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        transform: translateY(-2px);
    }

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
    .btn-action-edit {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }
    .btn-action-edit:hover {
        background: #f59e0b;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }
    .btn-action-delete {
        background: rgba(244, 63, 94, 0.12);
        color: #e11d48;
        border: 1px solid rgba(244, 63, 94, 0.25);
    }
    .btn-action-delete:hover {
        background: #e11d48;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.3);
    }

    /* Glowing Active Dot */
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #22c55e;
        display: inline-block;
        margin-right: 6px;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulse-green 1.5s infinite;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

    /* Mobile Cards */
    .ujian-card-mobile {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        padding: 16px;
        transition: all 0.2s ease;
    }

    /* Dark Mode Overrides */
    html.dark-mode .stat-card-modern {
        background: #18181b !important;
        border-color: #27272a !important;
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
    html.dark-mode .btn-action-soal {
        background: rgba(59, 130, 246, 0.18) !important;
        color: #60a5fa !important;
        border-color: rgba(59, 130, 246, 0.3) !important;
    }
    html.dark-mode .btn-action-rekap {
        background: rgba(16, 185, 129, 0.18) !important;
        color: #34d399 !important;
        border-color: rgba(16, 185, 129, 0.3) !important;
    }
    html.dark-mode .ujian-card-mobile {
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
                    <i class="mdi mdi-book-open-page-variant text-primary me-2"></i>Manajemen Ujian Online
                </h4>
                <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                    Kelola dan jadwalkan evaluasi belajar, bank soal, serta pantau hasil nilai siswa.
                </p>
            </div>
            <a href="{{ route('guru.ujian.create') }}" class="btn btn-primary text-white rounded-pill px-4 py-2.5 shadow-sm d-flex align-items-center justify-content-center fw-bold">
                <i class="mdi mdi-plus-circle fs-5 me-1.5"></i> Buat Jadwal Ujian
            </a>
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

    {{-- Stats Cards Grid --}}
    <div class="col-12 mb-4">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="stat-icon-wrapper bg-primary-subtle text-primary me-3">
                            <i class="mdi mdi-book-multiple-outline"></i>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Total Ujian</span>
                            <h3 class="fw-bold mb-0 text-dark fs-4">{{ $ujians->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="stat-icon-wrapper bg-success-subtle text-success me-3">
                            <i class="mdi mdi-play-circle-outline"></i>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Ujian Aktif</span>
                            <h3 class="fw-bold mb-0 text-dark fs-4">{{ $ujians->where('status', 'Aktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="stat-icon-wrapper bg-warning-subtle text-warning me-3">
                            <i class="mdi mdi-file-document-edit-outline"></i>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Draft Ujian</span>
                            <h3 class="fw-bold mb-0 text-dark fs-4">{{ $ujians->where('status', 'Draft')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="stat-icon-wrapper bg-info-subtle text-info me-3">
                            <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">Ujian Selesai</span>
                            <h3 class="fw-bold mb-0 text-dark fs-4">{{ $ujians->where('status', 'Selesai')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Section --}}
    <div class="col-12">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-format-list-bulleted text-primary me-2"></i>Daftar Jadwal Ujian
                        </h5>
                        <p class="text-muted small mb-0">Kelola soal, pantau nilai, atau edit pengaturan jadwal ujian.</p>
                    </div>
                </div>

                {{-- Desktop View Table --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="modern-table align-middle text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">NO</th>
                                <th class="text-start">MATA PELAJARAN</th>
                                <th class="text-center" style="width: 100px;">KELAS</th>
                                <th class="text-start">JUDUL UJIAN</th>
                                <th class="text-center" style="white-space: nowrap;">WAKTU MULAI</th>
                                <th class="text-center" style="width: 110px;">DURASI</th>
                                <th class="text-center" style="width: 110px;">STATUS</th>
                                <th class="text-center" style="width: 260px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ujians as $index => $u)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 p-2 bg-primary-subtle text-primary me-2.5 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="mdi mdi-book-open-variant fs-6"></i>
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block">{{ $u->mataPelajaran->nama_mapel ?? '-' }}</strong>
                                                <small class="text-muted">Semester {{ $u->semester ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                            {{ $u->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <span class="fw-bold text-dark d-block">{{ $u->judul }}</span>
                                        <small class="text-muted"><i class="mdi mdi-checkbox-multiple-marked-outline me-1 text-primary"></i>{{ $u->soal->count() }} Butir Soal</small>
                                    </td>
                                    <td class="text-center text-nowrap" style="white-space: nowrap; font-size: 0.85rem;">
                                        <div class="fw-semibold text-dark">
                                            <i class="mdi mdi-calendar-blank-outline text-primary me-1"></i>
                                            {{ $u->waktu_mulai->format('d M Y') }}
                                        </div>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                                            <i class="mdi mdi-clock-outline me-1"></i>Pukul {{ $u->waktu_mulai->format('H:i') }} WIB
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill fw-semibold" style="font-size: 0.76rem;">
                                            <i class="mdi mdi-timer-outline me-1 text-primary"></i>{{ $u->durasi }} Menit
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($u->status == 'Aktif')
                                            <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-3 py-1.5 d-inline-flex align-items-center" style="font-size: 0.75rem;">
                                                <span class="pulse-dot"></span> {{ $u->status }}
                                            </span>
                                        @elseif($u->status == 'Draft')
                                            <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-file-document-edit-outline me-1"></i> {{ $u->status }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.75rem;">
                                                <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i> {{ $u->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center align-items-center">
                                            {{-- Kelola Soal --}}
                                            <a href="{{ route('guru.ujian.soal', $u->id) }}" class="btn-action-badge btn-action-soal" title="Kelola Soal">
                                                <i class="mdi mdi-checkbox-multiple-marked-outline me-1"></i> Soal
                                            </a>
                                            {{-- Rekap Nilai --}}
                                            <a href="{{ route('guru.ujian.rekap', $u->id) }}" class="btn-action-badge btn-action-rekap" title="Rekap Nilai Siswa">
                                                <i class="mdi mdi-poll me-1"></i> Nilai
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('guru.ujian.edit', $u->id) }}" class="btn-action-icon btn-action-edit" title="Edit Jadwal">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            {{-- Hapus --}}
                                            <form action="{{ route('guru.ujian.destroy', $u->id) }}" method="POST" class="d-inline m-0 form-delete-ujian">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="button" class="btn-action-icon btn-action-delete btn-trigger-delete" data-judul="{{ $u->judul }}" title="Hapus Ujian">
                                                    <i class="mdi mdi-delete-outline"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-laptop-chromebook d-block mb-2 text-muted opacity-50" style="font-size: 2.8rem;"></i>
                                        <div class="fw-bold mb-1">Belum Ada Jadwal Ujian</div>
                                        <small class="text-muted">Klik tombol "Buat Jadwal Ujian" di atas untuk menambahkan ujian baru.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View Cards --}}
                <div class="d-md-none">
                    @forelse($ujians as $u)
                        <div class="ujian-card-mobile mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1" style="font-size: 0.72rem;">
                                    Kelas {{ $u->kelas->nama_kelas ?? '-' }}
                                </span>
                                @if($u->status == 'Aktif')
                                    <span class="badge bg-success-subtle text-success fw-bold rounded-pill px-2.5 py-1 d-inline-flex align-items-center" style="font-size: 0.72rem;">
                                        <span class="pulse-dot"></span> {{ $u->status }}
                                    </span>
                                @elseif($u->status == 'Draft')
                                    <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                        {{ $u->status }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                        {{ $u->status }}
                                    </span>
                                @endif
                            </div>

                            <h6 class="fw-bold text-dark mb-1" style="font-size: 1rem;">{{ $u->judul }}</h6>
                            <div class="small text-muted mb-3">
                                <span><i class="mdi mdi-book-open-outline me-1"></i>{{ $u->mataPelajaran->nama_mapel ?? '-' }}</span>
                                <span class="mx-1">•</span>
                                <span>Semester {{ $u->semester }}</span>
                            </div>

                            <div class="p-2.5 rounded-3 bg-light d-flex justify-content-between align-items-center mb-3 text-muted small" style="font-size: 0.78rem;">
                                <span><i class="mdi mdi-calendar-blank-outline me-1 text-primary"></i>{{ $u->waktu_mulai->format('d/m/Y H:i') }} WIB</span>
                                <span><i class="mdi mdi-timer-outline me-1 text-primary"></i>{{ $u->durasi }} Menit</span>
                            </div>

                            <div class="row g-2 pt-2 border-top">
                                <div class="col-6">
                                    <a href="{{ route('guru.ujian.soal', $u->id) }}" class="btn btn-sm btn-action-soal w-100 rounded-pill py-2 fw-bold text-center">
                                        <i class="mdi mdi-checkbox-multiple-marked-outline me-1"></i> Kelola Soal
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('guru.ujian.rekap', $u->id) }}" class="btn btn-sm btn-action-rekap w-100 rounded-pill py-2 fw-bold text-center">
                                        <i class="mdi mdi-poll me-1"></i> Rekap Nilai
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('guru.ujian.edit', $u->id) }}" class="btn btn-sm btn-light border w-100 rounded-pill py-2 fw-bold text-muted text-center">
                                        <i class="mdi mdi-pencil me-1"></i> Edit
                                    </a>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('guru.ujian.destroy', $u->id) }}" method="POST" class="w-100 m-0 form-delete-ujian">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger w-100 rounded-pill py-2 fw-bold text-center btn-trigger-delete" data-judul="{{ $u->judul }}">
                                            <i class="mdi mdi-delete-outline me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted card bg-light border-0 rounded-3">
                            <i class="mdi mdi-laptop-chromebook fs-2 text-muted opacity-50 mb-1"></i>
                            <span class="small">Belum ada jadwal ujian yang dibuat.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert Konfirmasi Hapus Jadwal Ujian
    document.querySelectorAll('.btn-trigger-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const judul = this.getAttribute('data-judul') || 'ujian ini';

            Swal.fire({
                title: 'Hapus Jadwal Ujian?',
                text: `Apakah Anda yakin ingin menghapus "${judul}"? Seluruh bank soal dan riwayat nilai siswa pada ujian ini akan ikut terhapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Ujian',
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
