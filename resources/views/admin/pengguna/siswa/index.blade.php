@extends('template.layouts.app')

@section('title', 'Akun Siswa')

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
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 6px;
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
                            <i class="mdi mdi-account-multiple text-primary me-2"></i>Manajemen Akun Siswa
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Berikut adalah daftar seluruh akun login siswa beserta kredensialnya</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success text-white btn-lg fw-bold btn-icon-text" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                            <i class="mdi mdi-file-excel me-2"></i> Import Excel
                        </button>
                        <a href="/admin/pengguna/siswa/create" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text">
                            <i class="mdi mdi-plus-circle me-2"></i> Tambah Akun Siswa
                        </a>
                    </div>
                </div>

                {{-- Filter Kelas Bar --}}
                <div class="filter-card mb-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        {{-- Sisi Kiri: Form Filter --}}
                        <form action="{{ url()->current() }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 m-0">
                            <div class="d-flex align-items-center me-1">
                                <div class="filter-icon-box me-2">
                                    <i class="mdi mdi-filter-variant fs-5"></i>
                                </div>
                                <span class="fw-bold text-dark small">Filter Kelas:</span>
                            </div>

                            <div style="min-width: 200px;">
                                <select name="kelas_id" id="filter_kelas" class="form-select custom-filter-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($kelas_list as $kls)
                                        <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                                            {{ $kls->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-filter-action">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>

                            @if(request('kelas_id'))
                                <a href="{{ url()->current() }}" class="btn btn-filter-reset" title="Reset Filter">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                            @endif
                        </form>

                        {{-- Sisi Kanan: Status & Counter --}}
                        <div class="d-flex align-items-center ms-auto">
                            <div class="filter-stat-badge text-nowrap">
                                <span class="text-muted small">Total:</span>
                                <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ count($siswa) }}</strong>
                                <span class="text-muted small ms-1">Akun</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alert Feedback --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-check-circle me-2 fs-5"></i>
                            <div><strong>Sukses!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-alert-circle me-2 fs-5"></i>
                            <div><strong>Peringatan!</strong> {{ session('warning') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-close-circle me-2 fs-5"></i>
                            <div><strong>Error!</strong> {{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Tabel Data Siswa --}}
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th style="width: 7%;" class="text-center">No</th>
                                <th style="width: 13%;" class="text-center">Kelas</th>
                                <th style="width: 25%;">NISN (Username)</th>
                                <th style="width: 41%;">Nama Lengkap</th>
                                <th style="width: 14%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $key => $item)
                                @php
                                    $rawName = trim($item->nama_lengkap ?? $item->nama_siswa ?? 'Siswa');
                                    $cleanName = preg_replace('/,\s*.*$/', '', $rawName);
                                    $displayName = ucwords(strtolower($cleanName));

                                    $words = array_values(array_filter(explode(' ', trim($displayName))));
                                    $initials = '';
                                    if (count($words) >= 2) {
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } elseif (count($words) == 1) {
                                        $initials = strtoupper(substr($words[0], 0, 2));
                                    } else {
                                        $initials = 'SW';
                                    }
                                    $palette = [
                                        'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
                                        'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
                                        'linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)',
                                        'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                                        'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                                        'linear-gradient(135deg, #ec4899 0%, #be185d 100%)',
                                    ];
                                    $bgGradient = $palette[abs(crc32($rawName)) % count($palette)];
                                @endphp
                            <tr>
                                {{-- Kolom Nomor --}}
                                <td class="text-center text-muted fw-bold" style="font-size: 0.88rem;">
                                    {{ $key + 1 }}
                                </td>

                                {{-- Kolom Kelas --}}
                                <td class="text-center">
                                    <span class="badge rounded-pill fw-semibold px-2.5 py-1.5" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.25); font-size: 0.78rem;">
                                        {{ $item->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </td>

                                {{-- Kolom NISN --}}
                                <td>
                                    <span class="code-badge">
                                        {{ $item->nisn ?? '-' }}
                                    </span>
                                </td>

                                {{-- Kolom Nama Lengkap --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs flex-shrink-0" 
                                             style="width: 36px; height: 36px; background: {{ $bgGradient }}; font-size: 0.78rem; letter-spacing: 0.5px;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block" style="font-size: 0.92rem; line-height: 1.25;">
                                                {{ $displayName }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Ubah --}}
                                        <a href="/admin/pengguna/siswa/{{ $item->id }}/edit" class="btn-action-icon btn-action-edit" title="Ubah Akun">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="/admin/pengguna/siswa/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun login siswa ini?')" class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete" title="Hapus Akun">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="mdi mdi-folder-open-outline d-block mb-2 text-muted" style="font-size: 2.2rem;"></i>
                                    Belum ada data akun siswa yang tersimpan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Info Footer --}}
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <div class="text-muted small">
                        Menampilkan {{ count($siswa) }} data akun siswa
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="importExcelModalLabel">
                    <i class="mdi mdi-file-excel text-success me-2"></i>Import Akun Siswa dari Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 shadow-sm small mb-3">
                        <strong class="text-dark">Petunjuk Penggunaan:</strong>
                        <ol class="ps-3 mt-1 mb-0 text-dark">
                            <li>Download terlebih dahulu format template Excel yang disediakan.</li>
                            <li>Format Excel akan langsung terisi dengan <strong>NISN</strong> dan <strong>Nama Lengkap</strong> yang sudah terdaftar di sistem.</li>
                            <li>Admin cukup mengisi kolom <strong>Password</strong> untuk membuat/memperbarui akun login siswa tersebut (username login menggunakan NISN).</li>
                        </ol>
                    </div>
                    
                    <div class="mb-3">
                        <a href="{{ route('admin.siswa.download-template') }}" class="btn btn-outline-success btn-sm w-100 fw-bold">
                            <i class="mdi mdi-download me-1"></i> Download Format Template Excel (Akun)
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excel_file" class="form-label fw-bold small text-dark">Pilih File Excel (.xlsx, .xls):</label>
                        <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx, .xls, .csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success text-white fw-bold">
                        <i class="mdi mdi-upload me-1"></i> Mulai Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
