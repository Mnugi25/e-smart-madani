@extends('template.layouts.app')

@section('title', 'Laporan Riwayat Absensi')

@section('content')
<style>
    .filter-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
    }
    .filter-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }
    .filter-input {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.55rem 0.85rem;
        font-size: 0.9rem;
        color: #1e293b;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }
    .filter-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        outline: none;
    }
    .filter-input-group .input-group-text {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-right: none;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        color: #64748b;
    }
    .filter-input-group .filter-input {
        border-left: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .filter-input-group:focus-within .input-group-text {
        border-color: #3b82f6;
        color: #2563eb;
    }
    .filter-input-group:focus-within .filter-input {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
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
    .student-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        font-weight: 700;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Dark Mode Theme Support */
    html.dark-mode .filter-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .filter-label {
        color: #94a3b8 !important;
    }
    html.dark-mode .filter-input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark-mode .filter-input[type="week"],
    html.dark-mode .filter-input[type="month"] {
        color-scheme: dark !important;
    }
    html.dark-mode .filter-input::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="%23ffffff"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2zm-8 4h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/></svg>') !important;
        background-size: 18px 18px !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        cursor: pointer !important;
        opacity: 1 !important;
        filter: none !important;
    }
    html.dark-mode .filter-input-group .input-group-text {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .filter-input:focus,
    html.dark-mode .filter-input-group:focus-within .filter-input {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25) !important;
    }
    html.dark-mode .filter-input-group:focus-within .input-group-text {
        border-color: #60a5fa !important;
        color: #93c5fd !important;
    }
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
    html.dark-mode .student-avatar {
        background-color: rgba(96, 165, 250, 0.15) !important;
        color: #93c5fd !important;
    }

    @media print {
        .sidebar, .navbar, .footer, .btn, .filter-wrapper, .filter-card, .settings-panel, .mdi {
            display: none !important;
        }
        .main-panel {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .content-wrapper {
            padding: 0 !important;
            background: white !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        tr {
            page-break-inside: avoid !important;
        }
        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }
        .card-title-dash {
            font-size: 24px !important;
            margin-bottom: 20px !important;
            text-align: center !important;
            display: block !important;
        }
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
                            <i class="mdi mdi-file-document text-primary me-2"></i>Laporan Riwayat Absensi
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Memantau dan mengecek seluruh data kehadiran siswa sekolah</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.laporan.absensi.export', request()->all()) }}" 
                           class="btn btn-success text-white fw-bold rounded-pill px-3 py-2 d-inline-flex align-items-center shadow-xs {{ $absensi->isEmpty() ? 'disabled' : '' }}">
                            <i class="mdi mdi-file-excel me-1.5"></i> Ekspor Excel
                        </a>
                        <a href="{{ route('admin.laporan.absensi.pdf', request()->all()) }}"
                           class="btn btn-danger text-white fw-bold rounded-pill px-3 py-2 d-inline-flex align-items-center shadow-xs {{ $absensi->isEmpty() ? 'disabled' : '' }}"
                           target="_blank">
                            <i class="mdi mdi-file-pdf me-1.5"></i> Ekspor PDF
                        </a>
                    </div>
                </div>

                {{-- Filter Pencarian / Sortir --}}
                <div class="filter-card mb-4">
                    <form action="{{ route('admin.laporan.absensi') }}" method="GET">
                        <div class="row align-items-end g-3">
                            <div class="col-md-3">
                                <label class="filter-label d-block">Pilih Kelas</label>
                                <select class="form-select filter-input" name="kelas">
                                    <option value="">-- Semua Kelas --</option>
                                    @if(isset($daftarKelas))
                                        @foreach($daftarKelas as $k)
                                            <option value="{{ $k->nama_kelas }}" {{ request('kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="filter-label d-block">Rentang Waktu</label>
                                <select class="form-select filter-input" name="filter_type" id="filter_type">
                                    <option value="mingguan" {{ request('filter_type', 'mingguan') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ request('filter_type') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="semester" {{ request('filter_type') == 'semester' ? 'selected' : '' }}>Semester</option>
                                </select>
                            </div>

                            <div class="col-md-3" id="input_mingguan">
                                <label class="filter-label d-block">Pilih Minggu</label>
                                <div class="input-group filter-input-group">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                    <input type="week" class="form-control filter-input" name="minggu" value="{{ request('minggu', date('Y').'-W'.date('W')) }}">
                                </div>
                            </div>

                            <div class="col-md-3" id="input_bulanan" style="display: none;">
                                <label class="filter-label d-block">Pilih Bulan</label>
                                <div class="input-group filter-input-group">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-month"></i>
                                    </span>
                                    <input type="month" class="form-control filter-input" name="bulan" value="{{ request('bulan', date('Y-m')) }}">
                                </div>
                            </div>

                            <div class="col-md-3" id="input_semester" style="display: none;">
                                <div class="row g-2">
                                    <div class="col-7">
                                        <label class="filter-label d-block">Pilih Tahun</label>
                                        <input type="number" class="form-control filter-input" name="tahun_semester" value="{{ request('tahun_semester', date('Y')) }}" placeholder="Tahun">
                                    </div>
                                    <div class="col-5">
                                        <label class="filter-label d-block">Semester</label>
                                        <select class="form-select filter-input" name="semester_pilihan">
                                            <option value="ganjil" {{ request('semester_pilihan') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                            <option value="genap" {{ request('semester_pilihan') == 'genap' ? 'selected' : '' }}>Genap</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary text-white w-100 fw-bold rounded-pill shadow-xs py-2 d-inline-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-magnify me-1.5"></i> Tampilkan Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const filterType = document.getElementById('filter_type');
                        const inputMingguan = document.getElementById('input_mingguan');
                        const inputBulanan = document.getElementById('input_bulanan');
                        const inputSemester = document.getElementById('input_semester');

                        function toggleInputs() {
                            if (!filterType) return;
                            const type = filterType.value;
                            if (inputMingguan) inputMingguan.style.display = type === 'mingguan' ? 'block' : 'none';
                            if (inputBulanan) inputBulanan.style.display = type === 'bulanan' ? 'block' : 'none';
                            if (inputSemester) inputSemester.style.display = type === 'semester' ? 'block' : 'none';
                        }

                        if (filterType) {
                            filterType.addEventListener('change', toggleInputs);
                            toggleInputs();
                        }
                    });
                </script>

                {{-- Tabel Riwayat Absensi --}}
                <div class="table-responsive">
                    <table class="modern-table align-middle m-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 32%;">Siswa</th>
                                <th style="width: 15%;" class="text-center">Kelas</th>
                                <th style="width: 28%;" class="text-center">Mata Pelajaran</th>
                                <th style="width: 20%;" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensi as $index => $row)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="student-avatar">
                                                {{ strtoupper(substr($row->siswa->nama_lengkap ?? 'S', 0, 1)) }}
                                            </div>
                                            <div class="d-flex flex-column align-items-start gap-1">
                                                <div class="fw-bold text-dark" style="font-size: 0.9rem; line-height: 1.35;">
                                                    {{ $row->siswa->nama_lengkap ?? '-' }}
                                                </div>
                                                <div>
                                                    <span class="code-badge" style="font-size: 0.72rem;">
                                                        {{ $row->siswa->nisn ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <span class="badge bg-inverse-primary fw-bold px-3 py-1.5 rounded-pill" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                            {{ $row->siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-semibold text-dark" style="font-size: 0.88rem;">
                                            {{ $row->jadwal->mataPelajaran->nama_mapel ?? 'Presensi Mandiri' }}
                                        </div>
                                        <small class="text-muted d-inline-flex align-items-center gap-1 mt-0.5" style="font-size: 0.75rem;">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ date('H:i', strtotime($row->created_at)) }} WIB
                                        </small>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @php
                                            $statusLabel = strtoupper($row->status);
                                            $badgeClass = 'bg-danger';
                                            $customStyle = '';
                                            if($statusLabel == 'HADIR') {
                                                $badgeClass = 'bg-success';
                                            } elseif($statusLabel == 'TERLAMBAT') {
                                                $badgeClass = '';
                                                $customStyle = 'background-color: #f97316 !important; color: #ffffff !important;';
                                            } elseif($statusLabel == 'IZIN') {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif($statusLabel == 'SAKIT') {
                                                $badgeClass = 'bg-info text-white';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fw-bold px-3 py-1.5 rounded-pill" style="min-width: 82px; font-size: 0.75rem; letter-spacing: 0.3px; {{ $customStyle }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="mdi mdi-clipboard-text-outline d-block mb-2 text-muted" style="font-size: 2.5rem;"></i>
                                        <span class="fw-bold">Belum ada data riwayat absensi yang tercatat.</span>
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
