@extends('template.layouts.app')

@section('title', 'Kelola Soal Ujian')

@section('content')
<style>
    /* Modern Back Button */
    .btn-back-modern {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-back-modern:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .btn-back-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    /* Cards & Containers */
    .exam-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .form-card-modern {
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        background: #ffffff !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03) !important;
    }
    .form-section-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }

    /* Option Items */
    .option-item-card {
        border-radius: 10px;
        padding: 9px 14px;
        margin-bottom: 8px;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        font-size: 0.88rem;
    }
    .option-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        margin-right: 12px;
        flex-shrink: 0;
        background-color: #f1f5f9;
        color: #475569;
    }
    .option-item-card.correct-answer {
        background-color: rgba(16, 185, 129, 0.1) !important;
        border-color: #10b981 !important;
        color: #065f46 !important;
        font-weight: 600;
    }
    .option-item-card.correct-answer .option-badge {
        background-color: #10b981 !important;
        color: #ffffff !important;
    }

    /* Soal Card Container */
    .question-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
    }
    .question-card-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    /* Action Delete Icon */
    .btn-delete-soal {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(244, 63, 94, 0.1);
        color: #e11d48;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-delete-soal:hover {
        background: #e11d48;
        color: #ffffff;
    }

    /* Dark Mode Overrides */
    html.dark-mode .btn-back-modern {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #cbd5e1 !important;
    }
    html.dark-mode .exam-header-card,
    html.dark-mode .form-card-modern,
    html.dark-mode .question-card-item {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .form-section-label {
        color: #a1a1aa !important;
    }
    html.dark-mode .option-item-card {
        background-color: #121215 !important;
        border-color: #27272a !important;
        color: #f4f4f5 !important;
    }
    html.dark-mode .option-item-card:not(.correct-answer) .option-badge {
        background-color: #27272a !important;
        color: #a1a1aa !important;
    }
    html.dark-mode .option-item-card.correct-answer {
        background-color: rgba(16, 185, 129, 0.18) !important;
        border-color: #10b981 !important;
        color: #6ee7b7 !important;
    }
</style>

<div class="row">
    {{-- Back Button --}}
    <div class="col-12 mb-3">
        <a href="{{ route('guru.ujian.index') }}" class="btn-back-modern">
            <div class="btn-back-icon">
                <i class="mdi mdi-arrow-left"></i>
            </div>
            <span>Kembali ke Manajemen Ujian</span>
        </a>
    </div>

    {{-- Exam Overview Header Card --}}
    <div class="col-12 mb-4">
        <div class="exam-header-card d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                        Kelas {{ $ujian->kelas->nama_kelas ?? '-' }}
                    </span>
                    <span class="badge bg-info-subtle text-info fw-bold rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                        {{ $ujian->mataPelajaran->nama_mapel ?? '-' }}
                    </span>
                    <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">
                        <i class="mdi mdi-timer-outline me-1"></i>{{ $ujian->durasi }} Menit
                    </span>
                    <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">
                        Semester {{ $ujian->semester }}
                    </span>
                </div>
                <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">{{ $ujian->judul }}</h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary text-white rounded-pill px-3.5 py-2 fw-bold" style="font-size: 0.85rem;">
                    <i class="mdi mdi-format-list-checks me-1"></i> {{ $ujian->soal->count() }} Soal Tersimpan
                </span>
            </div>
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

    {{-- Main Content: Form Tambah Soal (Left) & Daftar Soal (Right) --}}
    <div class="col-lg-5 mb-4">
        <div class="card form-card-modern">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-2 bg-primary-subtle text-primary me-2.5 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="mdi mdi-plus-box-outline fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Tambah Soal Baru</h5>
                        <small class="text-muted">Isi teks pertanyaan & opsi pilihan ganda</small>
                    </div>
                </div>

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger py-2 mb-3 border-0 shadow-sm">
                        <ul class="mb-0 small ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('guru.ujian.soal.store', $ujian->id) }}" method="POST">
                    @csrf
                    
                    {{-- Pertanyaan --}}
                    <div class="mb-3">
                        <label class="form-section-label">Pertanyaan Soal <span class="text-danger">*</span></label>
                        <textarea name="pertanyaan" class="form-control rounded-3 p-3" rows="4" style="border-radius: 12px !important; border: 1.5px solid #cbd5e1;" required placeholder="Tuliskan butir soal pertanyaan di sini...">{{ old('pertanyaan') }}</textarea>
                    </div>

                    {{-- Opsi A - D & E --}}
                    <div class="mb-2">
                        <label class="form-section-label">Opsi Pilihan A <span class="text-danger">*</span></label>
                        <input type="text" name="opsi_a" class="form-control rounded-pill px-3" style="height: 42px; border: 1.5px solid #cbd5e1;" required placeholder="Pilihan A" value="{{ old('opsi_a') }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-section-label">Opsi Pilihan B <span class="text-danger">*</span></label>
                        <input type="text" name="opsi_b" class="form-control rounded-pill px-3" style="height: 42px; border: 1.5px solid #cbd5e1;" required placeholder="Pilihan B" value="{{ old('opsi_b') }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-section-label">Opsi Pilihan C <span class="text-danger">*</span></label>
                        <input type="text" name="opsi_c" class="form-control rounded-pill px-3" style="height: 42px; border: 1.5px solid #cbd5e1;" required placeholder="Pilihan C" value="{{ old('opsi_c') }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-section-label">Opsi Pilihan D <span class="text-danger">*</span></label>
                        <input type="text" name="opsi_d" class="form-control rounded-pill px-3" style="height: 42px; border: 1.5px solid #cbd5e1;" required placeholder="Pilihan D" value="{{ old('opsi_d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-section-label">Opsi Pilihan E <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" name="opsi_e" class="form-control rounded-pill px-3" style="height: 42px; border: 1.5px solid #cbd5e1;" placeholder="Pilihan E" value="{{ old('opsi_e') }}">
                    </div>

                    {{-- Kunci Jawaban Benar --}}
                    <div class="mb-4">
                        <label class="form-section-label text-primary">Kunci Jawaban Benar <span class="text-danger">*</span></label>
                        <select name="jawaban_benar" class="form-select form-control rounded-pill px-3" style="height: 44px; border: 1.5px solid #2563eb;" required>
                            <option value="a" {{ old('jawaban_benar') == 'a' ? 'selected' : '' }}>Opsi A</option>
                            <option value="b" {{ old('jawaban_benar') == 'b' ? 'selected' : '' }}>Opsi B</option>
                            <option value="c" {{ old('jawaban_benar') == 'c' ? 'selected' : '' }}>Opsi C</option>
                            <option value="d" {{ old('jawaban_benar') == 'd' ? 'selected' : '' }}>Opsi D</option>
                            <option value="e" {{ old('jawaban_benar') == 'e' ? 'selected' : '' }}>Opsi E</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-white rounded-pill py-2.5 fw-bold shadow-sm w-100">
                            <i class="mdi mdi-plus-circle-outline me-1"></i> Tambahkan Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Soal Tersimpan (Right) --}}
    <div class="col-lg-7">
        <div class="card form-card-modern">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="mdi mdi-book-open-variant text-primary me-2"></i>Daftar Soal Tersimpan
                    </h5>
                    <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1">
                        {{ $ujian->soal->count() }} Soal
                    </span>
                </div>

                <div class="soal-list-scrollable" style="max-height: 720px; overflow-y: auto; padding-right: 4px;">
                    @forelse($ujian->soal as $index => $s)
                        <div class="question-card-item">
                            <div class="d-flex justify-content-between align-items-center mb-2.5">
                                <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill" style="font-size: 0.75rem;">
                                    Soal Nomor {{ $index + 1 }}
                                </span>
                                <form action="{{ route('guru.ujian.soal.destroy', $s->id) }}" method="POST" class="m-0 form-delete-soal">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn-delete-soal btn-trigger-delete-soal" data-no="{{ $index + 1 }}" title="Hapus Soal">
                                        <i class="mdi mdi-delete-outline fs-5"></i>
                                    </button>
                                </form>
                            </div>

                            <p class="fw-bold text-dark mb-3" style="font-size: 0.95rem; line-height: 1.55;">
                                {{ $s->pertanyaan }}
                            </p>

                            <div class="options-wrapper">
                                <div class="option-item-card {{ $s->jawaban_benar == 'a' ? 'correct-answer' : '' }}">
                                    <span class="option-badge">A</span> 
                                    <span>{{ $s->opsi_a }}</span>
                                    @if($s->jawaban_benar == 'a')
                                        <i class="mdi mdi-check-circle text-success ms-auto fs-5"></i>
                                    @endif
                                </div>
                                <div class="option-item-card {{ $s->jawaban_benar == 'b' ? 'correct-answer' : '' }}">
                                    <span class="option-badge">B</span> 
                                    <span>{{ $s->opsi_b }}</span>
                                    @if($s->jawaban_benar == 'b')
                                        <i class="mdi mdi-check-circle text-success ms-auto fs-5"></i>
                                    @endif
                                </div>
                                <div class="option-item-card {{ $s->jawaban_benar == 'c' ? 'correct-answer' : '' }}">
                                    <span class="option-badge">C</span> 
                                    <span>{{ $s->opsi_c }}</span>
                                    @if($s->jawaban_benar == 'c')
                                        <i class="mdi mdi-check-circle text-success ms-auto fs-5"></i>
                                    @endif
                                </div>
                                <div class="option-item-card {{ $s->jawaban_benar == 'd' ? 'correct-answer' : '' }}">
                                    <span class="option-badge">D</span> 
                                    <span>{{ $s->opsi_d }}</span>
                                    @if($s->jawaban_benar == 'd')
                                        <i class="mdi mdi-check-circle text-success ms-auto fs-5"></i>
                                    @endif
                                </div>
                                @if($s->opsi_e)
                                    <div class="option-item-card {{ $s->jawaban_benar == 'e' ? 'correct-answer' : '' }}">
                                        <span class="option-badge">E</span> 
                                        <span>{{ $s->opsi_e }}</span>
                                        @if($s->jawaban_benar == 'e')
                                            <i class="mdi mdi-check-circle text-success ms-auto fs-5"></i>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-file-question-outline d-block mb-2 text-muted opacity-50" style="font-size: 3rem;"></i>
                            <div class="fw-bold mb-1">Belum Ada Soal Ditambahkan</div>
                            <small class="text-muted">Gunakan form di sebelah kiri untuk mulai menambahkan butir soal.</small>
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
    // SweetAlert Konfirmasi Hapus Soal
    document.querySelectorAll('.btn-trigger-delete-soal').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const no = this.getAttribute('data-no') || 'ini';

            Swal.fire({
                title: 'Hapus Soal Nomor ' + no + '?',
                text: 'Apakah Anda yakin ingin menghapus butir soal ini dari ujian?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Soal',
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
