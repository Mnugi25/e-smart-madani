@extends('template.layouts.app')

@section('title', 'Akun Guru')

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
                            <i class="mdi mdi-account-key text-primary me-2"></i>Manajemen Akun Guru
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Berikut adalah daftar seluruh akun login tenaga pengajar sekolah</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success text-white btn-lg fw-bold btn-icon-text" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                            <i class="mdi mdi-file-excel me-2"></i> Import Excel
                        </button>
                        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text">
                            <i class="mdi mdi-plus-circle me-2"></i> Tambah Akun Guru
                        </a>
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

                {{-- Tabel Data Guru --}}
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th style="width: 7%;" class="text-center">No</th>
                                <th style="width: 15%;" class="text-center">Kode Guru</th>
                                <th style="width: 32%;">Nama Lengkap</th>
                                <th style="width: 32%;">Email Login</th>
                                <th style="width: 14%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guru as $key => $item)
                            <tr>
                                {{-- Kolom Nomor --}}
                                <td class="text-center text-muted fw-bold" style="font-size: 0.88rem;">
                                    {{ $key + 1 }}
                                </td>

                                {{-- Kolom Kode Guru --}}
                                <td class="text-center">
                                    <span class="code-badge">
                                        {{ $item->kode_guru }}
                                    </span>
                                </td>

                                {{-- Kolom Nama Lengkap --}}
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 0.94rem;">
                                        {{ $item->nama_lengkap }}
                                    </span>
                                </td>

                                {{-- Kolom Email Login --}}
                                <td>
                                    <span class="text-dark fw-medium d-inline-flex align-items-center" style="font-size: 0.9rem;">
                                        <i class="mdi mdi-email-outline text-primary me-1.5"></i> {{ $item->user?->email ?? '-' }}
                                    </span>
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Ubah --}}
                                        <a href="{{ route('admin.guru.edit', $item->id) }}" class="btn-action-icon btn-action-edit" title="Ubah Akun">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.guru.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun login guru ini?')" class="d-inline m-0">
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
                                    Belum ada data akun guru yang tersimpan.
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

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="importExcelModalLabel">
                    <i class="mdi mdi-file-excel text-success me-2"></i>Import Akun Guru dari Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 shadow-sm small mb-3">
                        <strong class="text-dark">Petunjuk Penggunaan:</strong>
                        <ol class="ps-3 mt-1 mb-0 text-dark">
                            <li>Download terlebih dahulu format template Excel yang disediakan.</li>
                            <li>Format Excel akan langsung terisi dengan <strong>Kode Guru</strong> dan <strong>Nama Lengkap</strong> yang sudah terdaftar di sistem.</li>
                            <li>Admin cukup mengisi kolom <strong>Email</strong> dan <strong>Password</strong> untuk membuat/memperbarui akun guru tersebut.</li>
                            <li>Jika ingin mengubah email tanpa mengganti password, Anda dapat mengosongkan kolom <strong>Password</strong>.</li>
                        </ol>
                    </div>
                    
                    <div class="mb-3">
                        <a href="{{ route('admin.guru.download-template') }}" class="btn btn-outline-success btn-sm w-100 fw-bold">
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
