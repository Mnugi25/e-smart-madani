@extends('template.layouts.app')

@section('title', 'Presensi Kelas ' . ($jadwal->kelas->nama_kelas ?? ''))

@section('content')
<style>
    /* Modern Back Button */
    .btn-back-modern {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 6px 18px 6px 8px;
        background: #ffffff;
        color: #1e293b !important;
        border: 1.5px solid #cbd5e1;
        border-radius: 50px;
        font-size: 0.86rem;
        font-weight: 700;
        text-decoration: none !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-back-modern:hover {
        background: #f8fafc;
        border-color: #3b82f6;
        color: #2563eb !important;
        transform: translateX(-4px);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);
    }
    .btn-back-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: all 0.25s ease;
    }
    .btn-back-modern:hover .btn-back-icon {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        transform: scale(1.05);
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

    /* Avatar Initial */
    .avatar-initial {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        font-weight: 700;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Radio Group Attendance Badges */
    .status-pill-group {
        display: inline-flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 50px;
        gap: 4px;
    }
    .status-pill-group .btn-check + .btn {
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        border: none;
        color: #64748b;
        background: transparent;
        transition: all 0.2s ease;
    }
    .status-pill-group .btn-check:checked + .btn-status-hadir {
        background: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    .status-pill-group .btn-check:checked + .btn-status-izin {
        background: #f59e0b !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }
    .status-pill-group .btn-check:checked + .btn-status-sakit {
        background: #0ea5e9 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
    }
    .status-pill-group .btn-check:checked + .btn-status-alpa {
        background: #ef4444 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    .status-pill-group .btn-check:checked + .btn-status-terlambat {
        background: #fd7e14 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(253, 126, 20, 0.3);
    }

    /* Sticky Mobile Footer */
    @media (max-width: 991px) {
        .table-view { display: none !important; }
        .mobile-view { display: block !important; }
        .sticky-mobile-footer {
            position: fixed !important;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff !important;
            border-top: 1px solid #e2e8f0;
            padding: 12px 20px !important;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.06);
            z-index: 999;
        }
    }
    @media (min-width: 992px) {
        .mobile-view { display: none !important; }
    }

    /* Dark Mode Overrides */
    html.dark-mode .btn-back-modern {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #f4f4f5 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark-mode .btn-back-modern:hover {
        background: #27272a !important;
        border-color: #3b82f6 !important;
        color: #60a5fa !important;
    }
    html.dark-mode .btn-back-icon {
        background: rgba(59, 130, 246, 0.18) !important;
        color: #60a5fa !important;
    }
    html.dark-mode .btn-back-modern:hover .btn-back-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        color: #ffffff !important;
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
    html.dark-mode .status-pill-group {
        background: #27272a !important;
    }
    html.dark-mode .status-pill-group .btn-check + .btn {
        color: #a1a1aa !important;
    }
    html.dark-mode .avatar-initial {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%) !important;
        color: #a5b4fc !important;
    }
    html.dark-mode .sticky-mobile-footer {
        background: #18181b !important;
        border-top-color: #27272a !important;
        box-shadow: 0 -4px 15px rgba(0,0,0,0.3) !important;
    }
</style>

<div class="row">
    {{-- Header Section --}}
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('guru.jadwal') }}" class="btn-back-modern">
                    <div class="btn-back-icon">
                        <i class="mdi mdi-arrow-left"></i>
                    </div>
                    <span>Kembali ke Jadwal</span>
                </a>
                <div>
                    <h4 class="fw-bold mb-1" style="font-size: 1.25rem; color: #0f172a;">
                        Presensi Kelas {{ $jadwal->kelas->nama_kelas ?? 'Kelas' }}
                    </h4>
                    <p class="text-muted small mb-0">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold me-1">
                            {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
                        </span>
                        <span>{{ $jadwal->hari }}, {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</span>
                    </p>
                </div>
            </div>

            {{-- Tombol Simpan Atas (Desktop) --}}
            <button type="submit" form="form-absensi" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2.5 d-none d-lg-inline-flex align-items-center shadow-xs" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Semua Presensi
            </button>
        </div>
    </div>

    {{-- Main Attendance Card --}}
    <div class="col-12 mb-4">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-4">
                {{-- Quick Actions Bar --}}
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="text-muted small fw-bold me-1">Aksi Cepat:</span>
                        <button type="button" id="btn-quick-all-hadir" class="btn btn-sm btn-outline-success fw-bold rounded-pill px-3 py-1.5">
                            <i class="mdi mdi-check-all me-1"></i> Set Semua Hadir
                        </button>
                        <button type="button" id="btn-quick-reset" class="btn btn-sm btn-outline-secondary fw-bold rounded-pill px-3 py-1.5">
                            <i class="mdi mdi-refresh me-1"></i> Reset Pilihan
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs">
                            <i class="mdi mdi-calendar-today me-1 text-primary"></i>
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill shadow-xs fw-bold">
                            {{ count($siswa) }} Siswa
                        </span>
                    </div>
                </div>

                <form action="{{ route('guru.absen.simpan', $jadwal->id) }}" method="POST" id="form-absensi">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                    {{-- 1. Desktop Table View --}}
                    <div class="table-responsive table-view">
                        <table class="modern-table align-middle text-center">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">NO</th>
                                    <th class="text-start">NAMA LENGKAP SISWA</th>
                                    <th class="text-center">STATUS KEHADIRAN</th>
                                    <th style="width: 120px;" class="text-center">VERIFIKASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $index => $s)
                                    @php
                                        $record = $absensi[$s->id] ?? null;
                                        $isIzin = isset($izinDisetujui[$s->id]);
                                        $current = $record ? $record->status : ($isIzin ? 'izin' : 'alpa');
                                    @endphp
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-initial me-3">
                                                    {{ strtoupper(substr($s->nama_lengkap ?? $s->nama, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong class="text-dark d-block">{{ $s->nama_lengkap ?? $s->nama }}</strong>
                                                    <small class="text-muted"><i class="mdi mdi-card-account-details-outline me-1"></i>NISN: {{ $s->nisn ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="status-pill-group">
                                                @if($current == 'terlambat')
                                                    <input type="hidden" name="status[{{ $s->id }}]" id="hidden_status_{{ $s->id }}" value="terlambat">
                                                @endif

                                                {{-- Hadir --}}
                                                <input type="radio" class="btn-check" name="status[{{ $s->id }}]" id="h_{{ $s->id }}" value="hadir" {{ $current == 'hadir' ? 'checked' : '' }}>
                                                <label class="btn btn-status-hadir" for="h_{{ $s->id }}">Hadir</label>

                                                {{-- Izin --}}
                                                <input type="radio" class="btn-check" name="status[{{ $s->id }}]" id="i_{{ $s->id }}" value="izin" {{ $current == 'izin' ? 'checked' : '' }}>
                                                <label class="btn btn-status-izin" for="i_{{ $s->id }}">Izin</label>

                                                {{-- Sakit --}}
                                                <input type="radio" class="btn-check" name="status[{{ $s->id }}]" id="s_{{ $s->id }}" value="sakit" {{ $current == 'sakit' ? 'checked' : '' }}>
                                                <label class="btn btn-status-sakit" for="s_{{ $s->id }}">Sakit</label>

                                                {{-- Terlambat (Khusus Siswa yang terdata terlambat) --}}
                                                @if($current == 'terlambat')
                                                    <input type="radio" class="btn-check" id="t_{{ $s->id }}" checked disabled>
                                                    <label class="btn btn-status-terlambat" for="t_{{ $s->id }}">Terlambat</label>
                                                @endif

                                                {{-- Alpa --}}
                                                <input type="radio" class="btn-check" name="status[{{ $s->id }}]" id="a_{{ $s->id }}" value="alpa" {{ $current == 'alpa' ? 'checked' : '' }}>
                                                <label class="btn btn-status-alpa" for="a_{{ $s->id }}">Alpa</label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($record && $record->foto)
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 btn-view-selfie shadow-xs" data-foto="{{ asset('storage/' . $record->foto) }}" data-nama="{{ $s->nama_lengkap ?? $s->nama }}" title="Lihat Foto Verifikasi">
                                                    <i class="mdi mdi-camera-account me-1"></i> Foto
                                                </button>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 2. Mobile View Cards --}}
                    <div class="mobile-view" style="padding-bottom: 90px;">
                        @foreach ($siswa as $index => $s)
                            @php
                                $record = $absensi[$s->id] ?? null;
                                $isIzin = isset($izinDisetujui[$s->id]);
                                $current = $record ? $record->status : ($isIzin ? 'izin' : 'alpa');
                            @endphp
                            <div class="card mb-3 border p-3 rounded-3 shadow-xs bg-white" style="border: 1px solid #e2e8f0 !important;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial me-2.5" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block text-truncate" style="max-width: 180px; font-size: 0.92rem;">
                                                {{ $s->nama_lengkap ?? $s->nama }}
                                            </strong>
                                            <small class="text-muted" style="font-size: 0.74rem;">NISN: {{ $s->nisn ?? '-' }}</small>
                                        </div>
                                    </div>
                                    @if($record && $record->foto)
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 btn-view-selfie" data-foto="{{ asset('storage/' . $record->foto) }}" data-nama="{{ $s->nama_lengkap ?? $s->nama }}" title="Lihat Foto">
                                            <i class="mdi mdi-camera"></i>
                                        </button>
                                    @endif
                                </div>

                                <div class="status-pill-group w-100 justify-content-between mt-2">
                                    @if($current == 'terlambat')
                                        <input type="hidden" name="status_mobile[{{ $s->id }}]" id="mhidden_status_{{ $s->id }}" value="terlambat">
                                    @endif

                                    <input type="radio" class="btn-check" name="status_mobile[{{ $s->id }}]" id="mh_{{ $s->id }}" value="hadir" {{ $current == 'hadir' ? 'checked' : '' }}>
                                    <label class="btn btn-status-hadir flex-fill text-center" for="mh_{{ $s->id }}">Hadir</label>

                                    <input type="radio" class="btn-check" name="status_mobile[{{ $s->id }}]" id="mi_{{ $s->id }}" value="izin" {{ $current == 'izin' ? 'checked' : '' }}>
                                    <label class="btn btn-status-izin flex-fill text-center" for="mi_{{ $s->id }}">Izin</label>

                                    <input type="radio" class="btn-check" name="status_mobile[{{ $s->id }}]" id="ms_{{ $s->id }}" value="sakit" {{ $current == 'sakit' ? 'checked' : '' }}>
                                    <label class="btn btn-status-sakit flex-fill text-center" for="ms_{{ $s->id }}">Sakit</label>

                                    @if($current == 'terlambat')
                                        <input type="radio" class="btn-check" id="mt_{{ $s->id }}" checked disabled>
                                        <label class="btn btn-status-terlambat flex-fill text-center" for="mt_{{ $s->id }}">Telat</label>
                                    @endif

                                    <input type="radio" class="btn-check" name="status_mobile[{{ $s->id }}]" id="ma_{{ $s->id }}" value="alpa" {{ $current == 'alpa' ? 'checked' : '' }}>
                                    <label class="btn btn-status-alpa flex-fill text-center" for="ma_{{ $s->id }}">Alpa</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Bottom Desktop Action Bar --}}
                    <div class="d-none d-lg-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('guru.jadwal') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Kembali ke Jadwal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Semua Presensi
                        </button>
                    </div>

                    {{-- Sticky Mobile Footer --}}
                    <div class="sticky-mobile-footer d-lg-none d-flex gap-2">
                        <a href="{{ route('guru.jadwal') }}" class="btn btn-dark py-2.5 fw-bold rounded-pill px-4 text-center d-inline-flex align-items-center justify-content-center">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary py-2.5 fw-bold rounded-pill flex-grow-1 shadow-sm" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                            <i class="mdi mdi-content-save-outline me-1"></i> Simpan Presensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selfie Preview -->
<div class="modal fade" id="selfieModal" tabindex="-1" aria-labelledby="selfieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg" style="border-radius: 16px; border: none; overflow: hidden; background: #ffffff;">
            <div class="modal-header border-0 bg-primary text-white py-3 px-4">
                <h5 class="modal-title fw-bold" id="selfieModalLabel">
                    <i class="mdi mdi-camera-account me-2"></i>Foto Verifikasi Kehadiran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <h6 id="selfie-student-name" class="fw-bold text-dark mb-3">Nama Siswa</h6>
                <div class="mx-auto border rounded-3 overflow-hidden shadow-sm bg-light mb-3" style="max-width: 320px; height: 260px;">
                    <img id="selfie-img" src="" alt="Selfie Verifikasi" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="mt-2">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-bold">
                        <i class="mdi mdi-shield-check me-1"></i> Terverifikasi Foto Mandiri
                    </span>
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
    // Sinkronisasi input radio antara tampilan desktop dan mobile
    const inputs = document.querySelectorAll('.btn-check');
    inputs.forEach(input => {
        input.addEventListener('change', function () {
            const isMobile = this.id.startsWith('m');
            const targetId = isMobile ? this.id.substring(1) : 'm' + this.id;
            const targetInput = document.getElementById(targetId);
            if (targetInput) {
                targetInput.checked = true;
            }

            // Disable hidden terlambat input if another radio is selected
            const siswaId = this.name.replace('status[', '').replace(']', '').replace('status_mobile[', '');
            const hiddenInput = document.getElementById('hidden_status_' + siswaId);
            if (hiddenInput && this.value !== 'terlambat') {
                hiddenInput.disabled = true;
            }
            const mHiddenInput = document.getElementById('mhidden_status_' + siswaId);
            if (mHiddenInput && this.value !== 'terlambat') {
                mHiddenInput.disabled = true;
            }
        });
    });

    // Quick Button: Set Semua Hadir
    const btnAllHadir = document.getElementById('btn-set-all-hadir');
    if (btnAllHadir) {
        btnAllHadir.addEventListener('click', function() {
            document.querySelectorAll("input[type='radio'][value='hadir']").forEach(radio => {
                radio.checked = true;
                // Trigger change event to sync mobile
                radio.dispatchEvent(new Event('change'));
            });

            Swal.fire({
                icon: 'success',
                title: 'Semua Hadir Dipilih',
                text: 'Seluruh siswa telah diatur ke status Hadir. Klik Simpan Presensi untuk memperbarui database.',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // Quick Button: Reset Pilihan
    const btnReset = document.getElementById('btn-quick-reset');
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            document.querySelectorAll("input[type='radio'][value='alpa']").forEach(radio => {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            });
        });
    }

    // Selfie Modal handler
    const selfieModalEl = document.getElementById('selfieModal');
    if (selfieModalEl) {
        const selfieModal = new bootstrap.Modal(selfieModalEl);
        const selfieImg = document.getElementById('selfie-img');
        const studentNameEl = document.getElementById('selfie-student-name');

        document.querySelectorAll('.btn-view-selfie').forEach(button => {
            button.addEventListener('click', function () {
                const fotoUrl = this.getAttribute('data-foto');
                const namaSiswa = this.getAttribute('data-nama');

                selfieImg.src = fotoUrl;
                studentNameEl.innerText = namaSiswa;
                selfieModal.show();
            });
        });
    }
});
</script>
@endpush
