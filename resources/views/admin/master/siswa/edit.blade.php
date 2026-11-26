@extends('template.layouts.app')

@section('title', 'Ubah Siswa')

@section('content')
<style>
    .form-card {
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: #ffffff;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 22px 28px;
    }
    .input-group-custom .input-group-text {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-right: none;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        color: #64748b;
        padding: 0.65rem 0.95rem;
        transition: all 0.2s ease;
    }
    .input-group-custom .form-control,
    .input-group-custom .form-select {
        border: 1px solid #cbd5e1;
        border-left: none;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        padding: 0.65rem 0.95rem;
        font-size: 0.92rem;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .input-group-custom:focus-within .input-group-text {
        border-color: #3b82f6;
        background-color: #eff6ff;
        color: #2563eb;
    }
    .input-group-custom:focus-within .form-control,
    .input-group-custom:focus-within .form-select {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .form-label-custom {
        font-size: 0.84rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    /* Dark Mode Theme Support */
    html.dark-mode .form-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .form-card-header {
        background: linear-gradient(135deg, #18181b 0%, #1e1b4b 100%) !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .form-label-custom {
        color: #cbd5e1 !important;
    }
    html.dark-mode .input-group-custom .input-group-text {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    html.dark-mode .input-group-custom .form-control,
    html.dark-mode .input-group-custom .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark-mode .input-group-custom:focus-within .input-group-text {
        border-color: #60a5fa !important;
        background-color: #1e293b !important;
        color: #93c5fd !important;
    }
    html.dark-mode .input-group-custom:focus-within .form-control,
    html.dark-mode .input-group-custom:focus-within .form-select {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25) !important;
    }
</style>

<div class="row">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="form-card mb-4">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-pencil-box-outline"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Ubah Data Siswa</h4>
                        <p class="text-muted small mb-0">Perbarui data siswa sesuai kebutuhan.</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-4 p-md-4">
                <form action="{{ route('admin.master.siswa.update', $siswa->id) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Baris 1: NISN & Nama Siswa --}}
                        <div class="col-md-6">
                            <label for="nisn" class="form-label-custom d-block">
                                NISN <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-card-details-outline"></i>
                                </span>
                                <input type="text" name="nisn" id="nisn" 
                                       class="form-control @error('nisn') is-invalid @enderror" 
                                       value="{{ old('nisn', $siswa->nisn) }}" 
                                       required style="text-transform: uppercase;">
                            </div>
                            @error('nisn')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama_siswa" class="form-label-custom d-block">
                                Nama Siswa <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account"></i>
                                </span>
                                <input type="text" name="nama_siswa" id="nama_siswa" 
                                       class="form-control @error('nama_siswa') is-invalid @enderror" 
                                       value="{{ old('nama_siswa', $siswa->nama_siswa ?? $siswa->nama_lengkap) }}" 
                                       required style="text-transform: uppercase;">
                            </div>
                            @error('nama_siswa')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        {{-- Baris 2: Kelas & Jenis Kelamin --}}
                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label-custom d-block">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-google-classroom"></i>
                                </span>
                                <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                    <option value="" disabled>Pilih Kelas</option>
                                    @foreach($kelas as $item)
                                        <option value="{{ $item->id }}" {{ old('kelas_id', $siswa->kelas_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kelas }} - {{ $item->jurusan->nama_jurusan ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelas_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label-custom d-block">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-gender-male-female"></i>
                                </span>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="" disabled>PILIH JENIS KELAMIN</option>
                                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? $siswa->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? $siswa->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            @error('jenis_kelamin')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        {{-- Baris 3: Tanggal Lahir & Nama Orang Tua --}}
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label-custom d-block">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-calendar"></i>
                                </span>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                            </div>
                            @error('tanggal_lahir')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama_orang_tua" class="form-label-custom d-block">
                                Nama Orang Tua <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-human-male-female"></i>
                                </span>
                                <input type="text" name="nama_orang_tua" id="nama_orang_tua" 
                                       class="form-control @error('nama_orang_tua') is-invalid @enderror" 
                                       value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}" 
                                       style="text-transform: uppercase;">
                            </div>
                            @error('nama_orang_tua')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('admin.master.siswa') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function() {
        ['nisn', 'nama_siswa', 'nama_orang_tua'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.value = input.value.toUpperCase();
            }
        });
    });
</script>
@endpush
