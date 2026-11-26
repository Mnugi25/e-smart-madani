@extends('template.layouts.app')

@section('title', 'Tambah Jadwal Pelajaran')

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
    <div class="col-lg-9 mx-auto">
        <div class="form-card mb-4">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-calendar-plus"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Tambah Jadwal Pelajaran</h4>
                        <p class="text-muted small mb-0">Atur alokasi waktu, kelas, mapel, beserta guru pengampunya di bawah ini.</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-4 p-md-4">
                <form action="{{ route('admin.jadwal.store') }}" method="POST" class="forms-sample">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="hari" class="form-label-custom d-block">
                                Hari <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-calendar-today"></i>
                                </span>
                                <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror" required>
                                    <option value="" selected disabled>-- Pilih Hari --</option>
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                        <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('hari')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label-custom d-block">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-google-classroom"></i>
                                </span>
                                <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                    @foreach($kelas ?? [] as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelas_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="jam_mulai" class="form-label-custom d-block">
                                Jam Mulai <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-clock-start"></i>
                                </span>
                                <input type="time" name="jam_mulai" id="jam_mulai" 
                                       class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       value="{{ old('jam_mulai') }}" required>
                            </div>
                            @error('jam_mulai')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="jam_selesai" class="form-label-custom d-block">
                                Jam Selesai <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-clock-end"></i>
                                </span>
                                <input type="time" name="jam_selesai" id="jam_selesai" 
                                       class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       value="{{ old('jam_selesai') }}" required>
                            </div>
                            @error('jam_selesai')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="mapel_id" class="form-label-custom d-block">
                                Mata Pelajaran <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-book-open-page-variant"></i>
                                </span>
                                <select name="mapel_id" id="mapel_id" class="form-select @error('mapel_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mapel ?? [] as $m)
                                        <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                                            [{{ $m->kode_mapel }}] - {{ $m->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('mapel_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="guru_id" class="form-label-custom d-block">
                                Guru Pengampu <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-tie"></i>
                                </span>
                                <select name="guru_id" id="guru_id" class="form-select @error('guru_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>-- Pilih Guru Pengampu --</option>
                                    @foreach($guru ?? [] as $g)
                                        <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                            [{{ $g->kode_guru }}] - {{ $g->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('guru_id')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('admin.jadwal') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
