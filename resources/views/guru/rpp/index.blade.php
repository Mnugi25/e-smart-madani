@extends('template.layouts.app')

@section('title', 'Data RPP AI')

@section('content')
<style>
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
    .btn-action-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-action-icon:hover {
        transform: translateY(-2px);
    }
    .btn-action-view {
        background: rgba(14, 165, 233, 0.12);
        color: #0284c7;
        border: 1px solid rgba(14, 165, 233, 0.25);
    }
    .btn-action-view:hover {
        background: #0284c7;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
    }
    .btn-action-edit {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }
    .btn-action-edit:hover {
        background: #d97706;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(217, 119, 6, 0.3);
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
    .btn-filter-action {
        height: 38px;
        padding: 0 18px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-filter-action:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
    }
    .btn-filter-reset {
        height: 38px;
        padding: 0 14px;
        background: rgba(239, 68, 68, 0.08);
        color: #ef4444 !important;
        border: 1px solid rgba(239, 68, 68, 0.25);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-filter-reset:hover {
        background: #ef4444;
        color: #ffffff !important;
        border-color: #ef4444;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        transform: translateY(-1px);
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

    /* Dark Mode Support */
    html.dark-mode .modern-table {
        background-color: transparent !important;
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
    html.dark-mode .custom-filter-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
    }
    html.dark-mode .btn-filter-reset {
        background: rgba(244, 63, 94, 0.15) !important;
        color: #fb7185 !important;
        border-color: rgba(244, 63, 94, 0.35) !important;
    }
    html.dark-mode .btn-filter-reset:hover {
        background: #e11d48 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.4) !important;
    }
    html.dark-mode .filter-stat-badge {
        background: #18181b !important;
        border-color: #2e2e34 !important;
    }
    html.dark-mode .filter-stat-badge .text-muted {
        color: #a1a1aa !important;
    }
    html.dark-mode .btn-action-view {
        background: rgba(14, 165, 233, 0.16) !important;
        color: #38bdf8 !important;
        border-color: rgba(14, 165, 233, 0.35) !important;
    }
    html.dark-mode .btn-action-view:hover {
        background: #0284c7 !important;
        color: #ffffff !important;
    }
    html.dark-mode .btn-action-edit {
        background: rgba(245, 158, 11, 0.16) !important;
        color: #fbbf24 !important;
        border-color: rgba(245, 158, 11, 0.35) !important;
    }
    html.dark-mode .btn-action-edit:hover {
        background: #d97706 !important;
        color: #ffffff !important;
    }
    html.dark-mode .btn-action-delete {
        background: rgba(244, 63, 94, 0.16) !important;
        color: #fb7185 !important;
        border-color: rgba(244, 63, 94, 0.35) !important;
    }
    html.dark-mode .btn-action-delete:hover {
        background: #e11d48 !important;
        color: #ffffff !important;
    }
    html.dark-mode .header-mobile-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
</style>

<div class="row">
    {{-- Mobile Header (Outside Card) with Compact Side-by-Side Action Button --}}
    <div class="col-12 d-md-none mt-2 mb-3">
        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-xs header-mobile-box" style="border: 1px solid rgba(0,0,0,0.06); background: #ffffff;">
            <div class="pe-2 text-start">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">
                    <i class="mdi mdi-robot text-primary me-2"></i>RPP AI
                </h4>
                <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.2;">Kelola dokumen RPP Kurikulum Merdeka.</p>
            </div>
            <a href="{{ route('guru.rpp.create') }}" class="btn btn-primary rounded-pill px-3 d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" style="height: 36px; font-size: 0.75rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; white-space: nowrap; gap: 4px;">
                <i class="mdi mdi-plus" style="font-size: 14px;"></i> Buat RPP
            </a>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body p-4">
                {{-- Desktop Header --}}
                <div class="d-none d-md-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                            <i class="mdi mdi-robot text-primary me-2"></i>Data RPP AI (Rencana Pelaksanaan Pembelajaran)
                        </h4>
                        <p class="card-subtitle card-subtitle-dash text-muted">Daftar rancangan modul ajar Kurikulum Merdeka yang disusun menggunakan Asisten AI.</p>
                    </div>
                    <div>
                        <a href="{{ route('guru.rpp.create') }}" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text shadow-sm" style="border-radius: 12px;">
                            <i class="mdi mdi-plus-circle me-2"></i> Susun RPP Baru
                        </a>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="filter-card mb-4">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        {{-- Sisi Kiri: Form Filter --}}
                        <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2 m-0 flex-wrap flex-md-nowrap">
                            <div class="d-flex align-items-center me-1 text-nowrap">
                                <div class="filter-icon-box me-2">
                                    <i class="mdi mdi-filter-variant fs-5"></i>
                                </div>
                                <span class="fw-bold text-dark small">Filter RPP:</span>
                            </div>

                            {{-- Dropdown Kelas --}}
                            <div style="width: 175px;">
                                <select name="kelas_id" id="filter_kelas" class="form-select custom-filter-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($kelas_list ?? [] as $kls)
                                        <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                                            {{ $kls->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-filter-action text-nowrap">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>

                            @if(request('kelas_id'))
                                <a href="{{ url()->current() }}" class="btn btn-filter-reset text-nowrap" title="Reset Filter">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                            @endif
                        </form>

                        {{-- Sisi Kanan: Status & Counter (Tetap di posisi kanan, tidak pernah pindah) --}}
                        <div class="d-flex align-items-center ms-auto">
                            <div class="filter-stat-badge text-nowrap">
                                <span class="text-muted small">Total:</span>
                                <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ count($rpps) }}</strong>
                                <span class="text-muted small ms-1">RPP</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alert Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-check-circle me-2 fs-5"></i>
                            <div><strong>Sukses!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Desktop View Table --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="modern-table align-middle text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">NO</th>
                                <th class="text-start">TOPIK & MATERI PEMBELAJARAN</th>
                                <th class="text-start">MATA PELAJARAN</th>
                                <th class="text-center">KELAS</th>
                                <th class="text-center">FASE / MODEL</th>
                                <th class="text-center text-nowrap" style="white-space: nowrap;">TANGGAL DIBUAT</th>
                                <th style="width: 130px;" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rpps as $rpp)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-primary">
                                                <i class="mdi mdi-file-document-edit-outline fs-4"></i>
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block">{{ $rpp->topik }}</strong>
                                                @if(!empty($rpp->alokasi_waktu))
                                                    <small class="text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $rpp->alokasi_waktu }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <span class="fw-semibold text-dark">{{ $rpp->mataPelajaran->nama_mapel ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.76rem;">
                                            {{ $rpp->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if(!empty($rpp->fase))
                                                <span class="badge bg-info-subtle text-info fw-bold rounded-pill px-2.5 py-0.5" style="font-size: 0.72rem;">
                                                    Fase {{ $rpp->fase }}
                                                </span>
                                            @endif
                                            @if(!empty($rpp->model_pembelajaran))
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($rpp->model_pembelajaran, 20) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center text-muted text-nowrap" style="white-space: nowrap; font-size: 0.85rem;">
                                        <i class="mdi mdi-calendar-blank-outline me-1"></i>{{ $rpp->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('guru.rpp.show', $rpp->id) }}" class="btn-action-icon btn-action-view" title="Lihat RPP Lengkap">
                                                <i class="mdi mdi-eye-outline fs-6"></i>
                                            </a>
                                            <a href="{{ route('guru.rpp.edit', $rpp->id) }}" class="btn-action-icon btn-action-edit" title="Edit RPP">
                                                <i class="mdi mdi-pencil fs-6"></i>
                                            </a>
                                            <form action="{{ route('guru.rpp.destroy', $rpp->id) }}" method="POST" class="d-inline m-0 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-action-icon btn-action-delete border-0 btn-delete-rpp" title="Hapus RPP" data-topik="{{ $rpp->topik }}">
                                                    <i class="mdi mdi-trash-can-outline fs-6"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="mdi mdi-file-document-outline d-block mb-2 text-muted" style="font-size: 2.2rem; opacity: 0.5;"></i>
                                        <div class="fw-bold mb-1">Belum Ada RPP AI</div>
                                        <small class="text-muted">Tidak ada dokumen RPP yang sesuai dengan filter atau belum ada RPP yang dibuat.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View Cards --}}
                <div class="d-md-none">
                    @forelse($rpps as $rpp)
                        <div class="card bg-white border mb-3 p-3 rounded-3 shadow-xs" style="border: 1px solid #cbd5e1 !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="pe-2 overflow-hidden text-start">
                                    <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.95rem; line-height: 1.3;">{{ $rpp->topik }}</h6>
                                    <span class="text-muted" style="font-size: 0.75rem;">Mapel: <strong>{{ $rpp->mataPelajaran->nama_mapel ?? '-' }}</strong></span>
                                </div>
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.72rem; white-space: nowrap;">
                                    {{ $rpp->kelas->nama_kelas ?? '-' }}
                                </span>
                            </div>
                            
                            <div class="my-2 py-2 border-top border-bottom text-start" style="border-top-style: dashed !important; border-bottom-style: dashed !important; border-color: #cbd5e1 !important;">
                                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.75rem;">
                                    <span><i class="mdi mdi-clock-outline me-1"></i>{{ $rpp->alokasi_waktu ?? '1 Pertemuan' }}</span>
                                    <span><i class="mdi mdi-calendar me-1"></i>{{ $rpp->created_at->format('d-m-Y') }}</span>
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-4">
                                    <a href="{{ route('guru.rpp.show', $rpp->id) }}" class="btn btn-sm btn-info text-white w-100 justify-content-center py-2 px-1 rounded-3 d-inline-flex align-items-center shadow-xs" style="font-size: 0.75rem; font-weight: 600; gap: 4px;">
                                        <i class="mdi mdi-eye-outline"></i> Detail
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('guru.rpp.edit', $rpp->id) }}" class="btn btn-sm btn-warning text-white w-100 justify-content-center py-2 px-1 rounded-3 d-inline-flex align-items-center shadow-xs" style="font-size: 0.75rem; font-weight: 600; gap: 4px;">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                </div>
                                <div class="col-4">
                                    <form action="{{ route('guru.rpp.destroy', $rpp->id) }}" method="POST" class="m-0 delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger text-white w-100 justify-content-center py-2 px-1 rounded-3 d-inline-flex align-items-center shadow-xs btn-delete-rpp" style="font-size: 0.75rem; font-weight: 600; gap: 4px;" data-topik="{{ $rpp->topik }}">
                                            <i class="mdi mdi-trash-can-outline"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card bg-white p-4 text-center text-muted rounded-3 shadow-xs" style="border: 1px solid #cbd5e1 !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                            <i class="mdi mdi-file-document-outline d-block fs-1 mb-2 opacity-50"></i>
                            <span class="small">Belum ada dokumen RPP AI yang disusun.</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-delete-rpp').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const topik = this.getAttribute('data-topik') || 'RPP ini';
                Swal.fire({
                    title: 'Hapus RPP?',
                    text: `Apakah Anda yakin ingin menghapus RPP "${topik}"? Data yang dihapus tidak dapat dipulihkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus RPP',
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
