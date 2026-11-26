@extends('template.layouts.app')

@section('title', 'Riwayat Kehadiran')

@section('content')
<style>
    /* Table Styling */
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

    /* Filter & Stat Badges */
    .filter-stat-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .filter-icon-box {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Mobile Cards */
    .mobile-history-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        border-left: 4px solid #cbd5e1;
        transition: all 0.2s ease;
    }
    .mobile-history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }
    .mobile-history-card.border-hadir { border-left-color: #10b981 !important; }
    .mobile-history-card.border-terlambat { border-left-color: #f59e0b !important; }
    .mobile-history-card.border-izin { border-left-color: #3b82f6 !important; }
    .mobile-history-card.border-sakit { border-left-color: #06b6d4 !important; }
    .mobile-history-card.border-alpa { border-left-color: #ef4444 !important; }

    /* Time & Code Badges */
    .time-badge {
        background-color: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Reset Filter Button (Red Theme) */
    .btn-reset-filter {
        color: #ef4444 !important;
        border: 1.5px solid #ef4444 !important;
        background-color: rgba(239, 68, 68, 0.08) !important;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-reset-filter:hover {
        color: #ffffff !important;
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25) !important;
        transform: translateY(-1px);
    }

    /* Dark Mode Theme Support */
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
    html.dark-mode .filter-stat-badge,
    html.dark-mode .filter-card,
    html.dark-mode .mobile-history-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .time-badge {
        background-color: #0f172a !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }
    html.dark-mode .header-mobile-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .text-dark {
        color: #f1f5f9 !important;
    }
    html.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
    html.dark-mode .btn-reset-filter {
        color: #f87171 !important;
        border-color: #ef4444 !important;
        background-color: rgba(239, 68, 68, 0.15) !important;
    }
    html.dark-mode .btn-reset-filter:hover {
        color: #ffffff !important;
        background-color: #ef4444 !important;
    }
</style>

<div class="row">
    {{-- Mobile Header (Outside Card) --}}
    <div class="col-12 d-md-none mt-2 mb-3">
        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-xs header-mobile-box" style="border: 1px solid rgba(0,0,0,0.06); background: #ffffff;">
            <div class="pe-2">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">
                    <i class="mdi mdi-history text-primary me-2"></i>Riwayat Kehadiran
                </h4>
                <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.2;">
                    Kelas {{ $siswa->kelas->nama_kelas ?? (Auth::user()->siswa->kelas->nama_kelas ?? '') }} • {{ $stats['persentase'] }}% Kehadiran
                </p>
            </div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-bold text-nowrap">
                {{ $stats['total'] }} Catatan
            </span>
        </div>
    </div>

    {{-- Desktop Header Card --}}
    <div class="col-12 d-none d-md-block mb-4">
        <div class="card card-rounded shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="mdi mdi-history fs-3"></i>
                        </div>
                        <div>
                            <h4 class="card-title card-title-dash fw-bold text-dark mb-1">
                                Riwayat Kehadiran Siswa
                            </h4>
                            <p class="card-subtitle card-subtitle-dash text-muted mb-0">
                                Log rekaman presensi mandiri dan catatan kehadiran kelas {{ $siswa->kelas->nama_kelas ?? (Auth::user()->siswa->kelas->nama_kelas ?? '') }}.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Tingkat Hadir:</span>
                            <strong class="{{ $stats['persentase'] >= 80 ? 'text-success' : ($stats['persentase'] >= 60 ? 'text-warning' : 'text-danger') }} ms-1" style="font-size: 0.95rem;">
                                {{ $stats['persentase'] }}%
                            </strong>
                        </div>
                        <div class="filter-stat-badge text-nowrap">
                            <span class="text-muted small">Total:</span>
                            <strong class="text-primary ms-1" style="font-size: 0.92rem;">{{ $stats['total'] }}</strong>
                            <span class="text-muted small ms-1">Presensi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="col-12 mb-4">
        <div class="filter-card">
            <form action="{{ route('siswa.riwayat') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-auto">
                    <div class="filter-icon-box bg-primary-subtle text-primary rounded-3">
                        <i class="mdi mdi-filter-variant fs-5"></i>
                    </div>
                </div>
                <div class="col-12 col-sm-auto flex-grow-1" style="max-width: 360px;">
                    <select name="mapel_id" class="form-select form-select-sm" onchange="this.form.submit()" style="border-radius: 8px;">
                        <option value="">-- Semua Mata Pelajaran --</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id }}" {{ $selectedMapel == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if($selectedMapel)
                    <div class="col-auto">
                        <a href="{{ route('siswa.riwayat') }}" class="btn btn-sm rounded-pill px-3 py-1 btn-reset-filter d-inline-flex align-items-center gap-1 shadow-xs">
                            <i class="mdi mdi-close-circle-outline fs-6"></i> Reset Filter
                        </a>
                    </div>
                @endif
                <div class="col-12 col-sm-auto ms-auto text-end d-none d-sm-block">
                    <span class="text-muted small">Menampilkan <strong>{{ $riwayat->total() }}</strong> catatan riwayat</span>
                </div>
            </form>
        </div>
    </div>

    {{-- Content Area: Table (Desktop) & Cards (Mobile) --}}
    <div class="col-12">
        <div class="card card-rounded shadow-sm">
            <div class="card-body p-0 p-md-3">
                @if($riwayat->count() > 0)
                    {{-- Desktop Table View --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table modern-table mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">No</th>
                                    <th>Tanggal Kehadiran</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Waktu KBM</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $index => $item)
                                    @php
                                        $status = strtolower(trim($item->status));
                                        $theme = match($status) {
                                            'hadir' => ['bg' => 'bg-success-subtle', 'text' => 'text-success', 'icon' => 'mdi-check-circle', 'label' => 'Hadir'],
                                            'terlambat' => ['bg' => 'bg-warning-subtle', 'text' => 'text-warning', 'icon' => 'mdi-clock-alert-outline', 'label' => 'Terlambat'],
                                            'izin' => ['bg' => 'bg-primary-subtle', 'text' => 'text-primary', 'icon' => 'mdi-account-clock-outline', 'label' => 'Izin'],
                                            'sakit' => ['bg' => 'bg-info-subtle', 'text' => 'text-info', 'icon' => 'mdi-medical-bag', 'label' => 'Sakit'],
                                            'alpa' => ['bg' => 'bg-danger-subtle', 'text' => 'text-danger', 'icon' => 'mdi-close-circle-outline', 'label' => 'Alpa'],
                                            default => ['bg' => 'bg-light', 'text' => 'text-muted', 'icon' => 'mdi-help-circle-outline', 'label' => ucfirst($item->status)],
                                        };
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted fw-semibold">
                                            {{ $riwayat->firstItem() + $index }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2 text-primary" style="width: 32px; height: 32px;">
                                                    <i class="mdi mdi-calendar-blank fs-6"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark" style="font-size: 0.88rem;">
                                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark" style="font-size: 0.88rem;">
                                                {{ $item->jadwal->mataPelajaran->nama_mapel ?? '-' }}
                                            </div>
                                            @if(isset($item->jadwal->guru->nama_lengkap))
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                    <i class="mdi mdi-account-tie me-1"></i>{{ $item->jadwal->guru->nama_lengkap }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="time-badge">
                                                <i class="mdi mdi-clock-outline"></i>
                                                {{ date('H:i', strtotime($item->jadwal->jam_mulai ?? '00:00')) }} - {{ date('H:i', strtotime($item->jadwal->jam_selesai ?? '00:00')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $theme['bg'] }} {{ $theme['text'] }} rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                <i class="mdi {{ $theme['icon'] }}"></i>
                                                {{ $theme['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->keterangan)
                                                <span class="text-dark small fw-medium">
                                                    {{ $item->keterangan }}
                                                </span>
                                            @else
                                                <span class="text-muted small fst-italic">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="d-md-none p-3">
                        @foreach($riwayat as $item)
                            @php
                                $status = strtolower(trim($item->status));
                                $theme = match($status) {
                                    'hadir' => ['bg' => 'bg-success-subtle', 'text' => 'text-success', 'border' => 'border-hadir', 'icon' => 'mdi-check-circle', 'label' => 'Hadir'],
                                    'terlambat' => ['bg' => 'bg-warning-subtle', 'text' => 'text-warning', 'border' => 'border-terlambat', 'icon' => 'mdi-clock-alert-outline', 'label' => 'Terlambat'],
                                    'izin' => ['bg' => 'bg-primary-subtle', 'text' => 'text-primary', 'border' => 'border-izin', 'icon' => 'mdi-account-clock-outline', 'label' => 'Izin'],
                                    'sakit' => ['bg' => 'bg-info-subtle', 'text' => 'text-info', 'border' => 'border-sakit', 'icon' => 'mdi-medical-bag', 'label' => 'Sakit'],
                                    'alpa' => ['bg' => 'bg-danger-subtle', 'text' => 'text-danger', 'border' => 'border-alpa', 'icon' => 'mdi-close-circle-outline', 'label' => 'Alpa'],
                                    default => ['bg' => 'bg-light', 'text' => 'text-muted', 'border' => '', 'icon' => 'mdi-help-circle-outline', 'label' => ucfirst($item->status)],
                                };
                            @endphp
                            <div class="mobile-history-card {{ $theme['border'] }}">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem; line-height: 1.4;">
                                            {{ $item->jadwal->mataPelajaran->nama_mapel ?? '-' }}
                                        </h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <i class="mdi mdi-calendar-blank me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </small>
                                    </div>
                                    <span class="badge {{ $theme['bg'] }} {{ $theme['text'] }} rounded-pill px-2.5 py-1 fw-bold text-nowrap" style="font-size: 0.7rem;">
                                        <i class="mdi {{ $theme['icon'] }} me-0.5"></i>{{ $theme['label'] }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light-subtle flex-wrap gap-1">
                                    <span class="time-badge">
                                        <i class="mdi mdi-clock-outline"></i>
                                        {{ date('H:i', strtotime($item->jadwal->jam_mulai ?? '00:00')) }} - {{ date('H:i', strtotime($item->jadwal->jam_selesai ?? '00:00')) }}
                                    </span>
                                    @if($item->keterangan)
                                        <span class="text-muted small fw-medium" style="font-size: 0.75rem;">
                                            {{ $item->keterangan }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($riwayat->hasPages())
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-3 border-top">
                            <div class="text-muted small">
                                Menampilkan <strong>{{ $riwayat->firstItem() }}</strong> - <strong>{{ $riwayat->lastItem() }}</strong> dari <strong>{{ $riwayat->total() }}</strong> data
                            </div>
                            <div>
                                {{ $riwayat->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-5">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                            <i class="mdi mdi-clipboard-text-clock text-muted fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Belum Ada Riwayat Kehadiran</h5>
                        <p class="text-muted small mb-0 px-3">
                            @if($selectedMapel)
                                Tidak ditemukan riwayat kehadiran untuk mata pelajaran ini. Silakan reset filter.
                            @else
                                Riwayat kehadiran Anda akan otomatis tercatat setiap kali melakukan presensi mandiri.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
