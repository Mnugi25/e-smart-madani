@extends('template.layouts.app')

@section('title', 'Jadwal Pelajaran')

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
    .code-badge {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 5px;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        line-height: 1.2;
    }
    .time-badge {
        background-color: #f8fafc;
        color: #334155;
        border: 1px solid #cbd5e1;
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

    /* Dark Mode Theme Support */
    html.dark-mode .modern-table {
        background-color: transparent !important;
    }
    html.dark-mode .modern-table thead th {
        background: #202025 !important;
        color: #a1a1aa !important;
        border-bottom: 1.5px solid #2e2e34 !important;
    }
    html.dark-mode .modern-table tbody tr {
        background: transparent !important;
        border-bottom: 1px solid #27272a !important;
    }
    html.dark-mode .modern-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.035) !important;
    }
    html.dark-mode .modern-table tbody td {
        background: transparent !important;
        color: #f1f5f9 !important;
    }
    html.dark-mode .modern-table tbody td .text-dark {
        color: #ffffff !important;
    }
    html.dark-mode .code-badge {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #f4f4f5 !important;
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2) !important;
    }
    html.dark-mode .time-badge {
        background-color: rgba(255, 255, 255, 0.06) !important;
        color: #f4f4f5 !important;
        border-color: rgba(255, 255, 255, 0.14) !important;
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
    html.dark-mode .btn-action-edit {
        background: rgba(245, 158, 11, 0.16) !important;
        color: #fbbf24 !important;
        border-color: rgba(245, 158, 11, 0.35) !important;
    }
    html.dark-mode .btn-action-edit:hover {
        background: #d97706 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.4) !important;
    }
    html.dark-mode .btn-action-delete {
        background: rgba(244, 63, 94, 0.16) !important;
        color: #fb7185 !important;
        border-color: rgba(244, 63, 94, 0.35) !important;
    }
    html.dark-mode .btn-action-delete:hover {
        background: #e11d48 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.4) !important;
    }
</style>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">
                {{-- Header Atas --}}
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold">
                            <i class="mdi mdi-calendar-clock text-primary me-2"></i>Manajemen Jadwal Pelajaran
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Berikut adalah daftar seluruh plot jadwal pelajaran sekolah (Senin - Jumat)</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text shadow-sm">
                            <i class="mdi mdi-plus-circle me-2"></i> Tambah Jadwal Baru
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
                                <span class="fw-bold text-dark small">Filter Jadwal:</span>
                            </div>

                            {{-- Dropdown Kelas --}}
                            <div style="width: 145px;">
                                <select name="kelas_id" id="filter_kelas" class="form-select custom-filter-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($kelas_list as $kls)
                                        <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                                            {{ $kls->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Hari --}}
                            <div style="width: 135px;">
                                <select name="hari" id="filter_hari" class="form-select custom-filter-select">
                                    <option value="">-- Semua Hari --</option>
                                    @foreach($hari_list as $h)
                                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>
                                            {{ $h }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-filter-action text-nowrap">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>

                            @if(request('kelas_id') || request('hari'))
                                <a href="{{ url()->current() }}" class="btn btn-filter-reset text-nowrap" title="Reset Filter">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                            @endif
                        </form>

                        {{-- Sisi Kanan: Status & Counter (Tetap di posisi kanan, tidak pernah pindah) --}}
                        <div class="d-flex align-items-center ms-auto">
                            <div class="filter-stat-badge text-nowrap">
                                <span class="text-muted small">Total:</span>
                                <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ count($jadwal) }}</strong>
                                <span class="text-muted small ms-1">Jadwal</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alert Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-check-circle me-2 fs-5"></i>
                            <div><strong>Sukses!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Tabel Data Jadwal --}}
                <div class="table-responsive">
                    <table class="modern-table align-middle m-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 11%;">Hari</th>
                                <th style="width: 17%;" class="text-center">Waktu / Jam</th>
                                <th style="width: 12%;" class="text-center">Kelas</th>
                                <th style="width: 25%;">Mata Pelajaran</th>
                                <th style="width: 20%;">Guru Pengampu</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwal as $key => $item)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $key + 1 }}</td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark d-inline-flex align-items-center">
                                        <i class="mdi mdi-calendar-text text-primary me-1.5"></i>{{ $item->hari }}
                                    </span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge time-badge px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem; border-radius: 6px;">
                                        <i class="mdi mdi-clock-outline text-secondary"></i>
                                        {{ date('H:i', strtotime($item->jam_mulai)) }} - {{ date('H:i', strtotime($item->jam_selesai)) }}
                                    </span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <span class="badge bg-inverse-primary fw-bold px-3 py-1.5 rounded-pill" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                        {{ $item->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 0.92rem;">
                                        {{ $item->mapel->nama_mapel ?? ($item->mataPelajaran->nama_mapel ?? '-') }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex flex-column align-items-start gap-1 py-1">
                                        <span class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.35;">
                                            {{ $item->guru->nama_lengkap ?? '-' }}
                                        </span>
                                        <div class="d-inline-flex align-items-center gap-1.5 text-muted" style="font-size: 0.75rem; line-height: 1;">
                                            <span>Kode:</span>
                                            <span class="code-badge">{{ $item->guru->kode_guru ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center gap-1.5">
                                        {{-- Tombol Ubah --}}
                                        <a href="{{ route('admin.jadwal.edit', $item->id) }}" class="btn-action-icon btn-action-edit" title="Ubah">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal pelajaran ini?')" class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete border-0" title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="mdi mdi-calendar-blank-outline d-block mb-2 text-muted" style="font-size: 2.5rem;"></i>
                                    <span class="fw-bold">Belum ada plot jadwal pelajaran yang ditentukan.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Info Footer --}}
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <div class="text-muted small">
                        Menampilkan {{ count($jadwal) }} jadwal pelajaran {{ (request('kelas_id') || request('hari')) ? '(hasil filter)' : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
