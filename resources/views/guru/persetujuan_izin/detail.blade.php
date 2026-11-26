<style>
    .modal-detail-card {
        border-radius: 18px !important;
        border: none !important;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
        overflow: hidden;
    }
    .permit-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        transition: all 0.2s ease;
    }
    .permit-info-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #64748b;
        display: block;
        margin-bottom: 4px;
    }
    .permit-proof-wrapper {
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        overflow: hidden;
    }

    /* Dark Mode Support */
    html.dark-mode .modal-detail-card {
        background-color: #18181b !important;
        border: 1px solid #27272a !important;
    }
    html.dark-mode .permit-info-box {
        background-color: #121215 !important;
        border-color: #27272a !important;
    }
    html.dark-mode .permit-info-box .text-dark {
        color: #f4f4f5 !important;
    }
    html.dark-mode .permit-info-label {
        color: #a1a1aa !important;
    }
    html.dark-mode .permit-proof-wrapper {
        background-color: #121215 !important;
        border-color: #27272a !important;
    }
</style>

<div class="modal fade" id="modalDetailSurat{{ $p->id }}" tabindex="-1" aria-labelledby="modalDetailSuratLabel{{ $p->id }}" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-detail-card">
            {{-- Header --}}
            <div class="modal-header border-0 px-4 pt-4 pb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-2 bg-primary-subtle text-primary me-2.5 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="mdi mdi-file-document-check-outline fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="modalDetailSuratLabel{{ $p->id }}">Detail Permohonan Izin</h5>
                        <small class="text-muted">Tinjau lampiran & keterangan lengkap siswa</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4 py-3">
                {{-- Identitas Siswa Card --}}
                <div class="permit-info-box mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <div class="student-avatar-initial me-3" style="width: 42px; height: 42px; font-size: 1.05rem;">
                            {{ strtoupper(substr($p->siswa->nama_lengkap ?? $p->siswa->nama ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.98rem;">{{ $p->siswa->nama_lengkap ?? $p->siswa->nama ?? 'Siswa' }}</h6>
                            <div class="small text-muted">
                                <span>NISN: {{ $p->siswa->nisn ?? '-' }}</span>
                                <span class="mx-1">•</span>
                                <span class="fw-semibold text-primary">Kelas {{ $p->siswa->kelas->nama_kelas ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if($p->jenis == 'sakit')
                            <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                <i class="mdi mdi-medical-bag me-1"></i> SAKIT
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                <i class="mdi mdi-information-outline me-1"></i> IZIN
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Periode & Waktu Pengajuan Grid --}}
                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <div class="permit-info-box h-100">
                            <span class="permit-info-label">
                                <i class="mdi mdi-calendar-range me-1 text-primary"></i>Periode Izin
                            </span>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d F Y') }}
                                @if($p->tanggal_mulai != $p->tanggal_selesai)
                                    <span class="d-block text-muted small fw-normal">s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d F Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="permit-info-box h-100">
                            <span class="permit-info-label">
                                <i class="mdi mdi-clock-outline me-1 text-primary"></i>Waktu Pengajuan
                            </span>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                {{ $p->created_at ? $p->created_at->format('d M Y, H:i') . ' WIB' : '-' }}
                            </div>
                            <small class="text-muted d-block">
                                Status: <strong class="text-capitalize {{ $p->status == 'disetujui' ? 'text-success' : ($p->status == 'ditolak' ? 'text-danger' : 'text-warning') }}">{{ $p->status ?? 'Menunggu' }}</strong>
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Keterangan / Alasan --}}
                <div class="mb-3">
                    <span class="permit-info-label mb-1">
                        <i class="mdi mdi-comment-text-outline me-1 text-primary"></i>Alasan / Keterangan
                    </span>
                    <div class="permit-info-box text-dark fst-italic" style="font-size: 0.88rem; line-height: 1.5;">
                        "{{ $p->alasan ?? $p->keterangan ?? 'Tidak ada keterangan tambahan.' }}"
                    </div>
                </div>

                {{-- Lampiran Berkas Bukti --}}
                <div class="mb-2">
                    <span class="permit-info-label mb-2">
                        <i class="mdi mdi-attachment me-1 text-primary"></i>Lampiran Dokumen Bukti
                    </span>
                    @if($p->file_bukti)
                        @php
                            $isPdf = str_ends_with(strtolower($p->file_bukti), '.pdf');
                            $fileUrl = asset('storage/' . $p->file_bukti);
                        @endphp
                        @if($isPdf)
                            <div class="permit-proof-wrapper p-4 text-center">
                                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-2" style="width: 52px; height: 52px;">
                                    <i class="mdi mdi-file-pdf-box fs-2"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Dokumen Surat Keterangan (PDF)</h6>
                                <p class="text-muted small mb-3">Klik tombol di bawah untuk membuka dan memeriksa dokumen.</p>
                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-4 py-2 fw-bold text-white shadow-xs">
                                    <i class="mdi mdi-open-in-new me-1"></i> Buka Dokumen PDF
                                </a>
                            </div>
                        @else
                            <div class="permit-proof-wrapper p-2 text-center">
                                <img src="{{ $fileUrl }}" 
                                     class="img-fluid rounded-3 mx-auto d-block" 
                                     style="max-height: 320px; object-fit: contain; width: 100%;" 
                                     alt="Bukti Surat Izin">
                                <div class="pt-2 text-center">
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold">
                                        <i class="mdi mdi-fullscreen me-1"></i> Lihat Ukuran Penuh
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="permit-proof-wrapper p-4 text-center border-dashed text-muted">
                            <i class="mdi mdi-file-remove-outline fs-2 d-block mb-1 opacity-50"></i>
                            <span class="small fw-semibold">Tidak ada berkas bukti yang dilampirkan oleh siswa.</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-1 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4 py-2 fw-bold border text-muted" data-bs-dismiss="modal">
                    Tutup
                </button>

                @if($p->status == 'pending')
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('guru.izin.verifikasi', $p->id) }}" method="POST" class="m-0 form-verify-izin">
                            @csrf
                            <input type="hidden" name="status" value="tidak">
                            <button type="button" class="btn btn-outline-danger rounded-pill px-3 py-2 fw-bold btn-reject-action" data-action="tolak" data-nama="{{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}">
                                <i class="mdi mdi-close me-1"></i> Tolak Izin
                            </button>
                        </form>
                        <form action="{{ route('guru.izin.verifikasi', $p->id) }}" method="POST" class="m-0 form-verify-izin">
                            @csrf
                            <input type="hidden" name="status" value="setuju">
                            <button type="button" class="btn btn-success text-white rounded-pill px-4 py-2 fw-bold shadow-xs btn-approve-action" data-action="setujui" data-nama="{{ $p->siswa->nama_lengkap ?? $p->siswa->nama }}">
                                <i class="mdi mdi-check me-1"></i> Setujui Izin
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
