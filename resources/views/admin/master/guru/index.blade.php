@extends('template.layouts.app')

@section('title', 'Daftar Guru')

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
    .btn-action-detail {
        background: rgba(56, 189, 248, 0.12);
        color: #0284c7;
        border: 1px solid rgba(56, 189, 248, 0.25);
    }
    .btn-action-detail:hover {
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

    /* Dark Mode Support for Modern Table */
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
    html.dark-mode .btn-action-detail {
        background: rgba(56, 189, 248, 0.16) !important;
        color: #38bdf8 !important;
        border-color: rgba(56, 189, 248, 0.35) !important;
    }
    html.dark-mode .btn-action-detail:hover {
        background: #0284c7 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4) !important;
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
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title card-title-dash fw-bold">
                            <i class="mdi mdi-teach text-primary me-2"></i>Master Data Guru
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Daftar semua guru yang terdaftar di sistem.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success text-white btn-lg fw-bold btn-icon-text" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                            <i class="mdi mdi-file-excel me-2"></i> Import Excel
                        </button>
                        <a href="/admin/master/guru/create" class="btn btn-primary text-white btn-lg fw-bold btn-icon-text">
                            <i class="mdi mdi-plus-circle me-2"></i> Tambah Guru Baru
                        </a>
                    </div>
                </div>

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

                <div class="table-responsive">
                    <table class="table modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 11%;" class="text-center">Kode Guru</th>
                                <th style="width: 28%;">Nama Lengkap</th>
                                <th style="width: 14%;">Jenis Kelamin</th>
                                <th style="width: 15%;">Jabatan</th>
                                <th style="width: 15%;">No. HP</th>
                                <th style="width: 12%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guru as $key => $item)
                                @php
                                    $rawName = trim($item->nama_lengkap ?? 'Guru');
                                    $gelarMap = [
                                        's.pd.' => 'S.Pd.', 's.pd' => 'S.Pd.',
                                        'm.pd.' => 'M.Pd.', 'm.pd' => 'M.Pd.',
                                        's.kom.' => 'S.Kom.', 's.kom' => 'S.Kom.',
                                        's.t.' => 'S.T.', 's.t' => 'S.T.',
                                        's.si.' => 'S.Si.', 's.si' => 'S.Si.',
                                        's.e.' => 'S.E.', 's.e' => 'S.E.',
                                        'm.m.' => 'M.M.', 'm.m' => 'M.M.',
                                        'm.kom.' => 'M.Kom.', 'm.kom' => 'M.Kom.',
                                    ];
                                    if (str_contains($rawName, ',')) {
                                        $parts = explode(',', $rawName, 2);
                                        $namaUtama = ucwords(strtolower(trim($parts[0])));
                                        $lowerGelar = strtolower(trim($parts[1]));
                                        $formattedGelar = $gelarMap[$lowerGelar] ?? ucwords($lowerGelar);
                                        $displayName = $namaUtama . ', ' . $formattedGelar;
                                    } else {
                                        $displayName = ucwords(strtolower($rawName));
                                    }

                                    $cleanName = preg_replace('/,\s*.*$/', '', $rawName);
                                    $words = array_values(array_filter(explode(' ', trim($cleanName))));
                                    $initials = '';
                                    if (count($words) >= 2) {
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } elseif (count($words) == 1) {
                                        $initials = strtoupper(substr($words[0], 0, 2));
                                    } else {
                                        $initials = 'GR';
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

                                    $waLink = null;
                                    if (!empty($item->no_hp)) {
                                        $cleanHp = preg_replace('/[^0-9]/', '', $item->no_hp);
                                        if (str_starts_with($cleanHp, '0')) {
                                            $waNumber = '62' . substr($cleanHp, 1);
                                        } else {
                                            $waNumber = $cleanHp;
                                        }
                                        $waLink = "https://wa.me/" . $waNumber;
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold text-muted" style="font-size: 0.88rem;">{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge code-badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.78rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; letter-spacing: 0.5px;">
                                            {{ $item->kode_guru ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs flex-shrink-0" 
                                                 style="width: 36px; height: 36px; background: {{ $bgGradient }}; font-size: 0.78rem; letter-spacing: 0.5px;">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block" style="font-size: 0.94rem; line-height: 1.25;">
                                                    {{ $displayName }}
                                                </span>
                                                <small class="d-block text-muted" style="font-size: 0.76rem; color: #64748b !important; margin-top: 3px;">
                                                    {{ $item->user?->email ?? ($item->kode_guru ? 'Kode: ' . $item->kode_guru : 'Pengajar') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->jk == 'L')
                                            <span class="d-inline-flex align-items-center text-dark" style="font-size: 0.88rem; font-weight: 500;">
                                                <i class="mdi mdi-gender-male me-1.5" style="color: #3b82f6; font-size: 1.05rem;"></i> Laki-laki
                                            </span>
                                        @elseif($item->jk == 'P')
                                            <span class="d-inline-flex align-items-center text-dark" style="font-size: 0.88rem; font-weight: 500;">
                                                <i class="mdi mdi-gender-female me-1.5" style="color: #ec4899; font-size: 1.05rem;"></i> Perempuan
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(str_contains(strtoupper($item->jabatan ?? ''), 'WALI'))
                                            <span class="badge rounded-pill" style="background: rgba(16, 185, 129, 0.12); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 700; font-size: 0.75rem; padding: 5px 12px;">
                                                <i class="mdi mdi-shield-star-outline me-1"></i> Wali Kelas
                                            </span>
                                        @else
                                            <span class="badge rounded-pill" style="background: rgba(99, 102, 241, 0.1); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.25); font-weight: 600; font-size: 0.75rem; padding: 5px 12px;">
                                                <i class="mdi mdi-book-open-page-variant-outline me-1"></i> Guru Mapel
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($waLink)
                                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" 
                                               class="d-inline-flex align-items-center text-decoration-none fw-semibold" 
                                               style="color: #0f766e; font-size: 0.88rem; transition: all 0.15s ease;"
                                               title="Kirim pesan WhatsApp">
                                                <i class="mdi mdi-whatsapp text-success fs-6 me-1.5"></i>
                                                <span>{{ $item->no_hp }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.master.guru.show', $item->id) }}" class="btn-action-icon btn-action-detail" title="Detail Lengkap">
                                                <i class="mdi mdi-eye fs-6"></i>
                                            </a>
                                            <a href="{{ route('admin.master.guru.edit', $item->id) }}" class="btn-action-icon btn-action-edit" title="Ubah Data">
                                                <i class="mdi mdi-pencil fs-6"></i>
                                            </a>
                                            <form action="{{ route('admin.master.guru.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data guru ini?')" class="d-inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-icon btn-action-delete border-0" title="Hapus Data">
                                                    <i class="mdi mdi-delete fs-6"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="mdi mdi-folder-open-outline d-block mb-2 text-muted" style="font-size: 2.2rem; opacity: 0.5;"></i>
                                        Belum ada data guru yang tersedia.
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
                    <i class="mdi mdi-file-excel text-success me-2"></i>Import Data Guru dari Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.master.guru.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 shadow-sm small mb-3">
                        <strong class="text-dark">Petunjuk Penggunaan:</strong>
                        <ol class="ps-3 mt-1 mb-0 text-dark">
                            <li>Download terlebih dahulu format template Excel yang disediakan.</li>
                            <li>Isi data guru sesuai kolom yang ada (Kode Guru, Nama Lengkap, Jenis Kelamin (L/P), Jabatan, Tanggal Lahir (YYYY-MM-DD), No Hp, Alamat).</li>
                            <li>Kolom Nama Lengkap wajib diisi.</li>
                            <li>Jika Kode Guru dikosongkan, sistem akan meng-generate-nya secara otomatis.</li>
                        </ol>
                    </div>
                    
                    <div class="mb-3">
                        <a href="{{ route('admin.master.guru.download-template') }}" class="btn btn-outline-success btn-sm w-100 fw-bold">
                            <i class="mdi mdi-download me-1"></i> Download Format Template Excel
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
