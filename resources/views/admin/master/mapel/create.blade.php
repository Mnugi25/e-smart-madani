@extends('template.layouts.app')

@section('title', 'Tambah Mapel')

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
    .input-group-custom .form-control {
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
    .input-group-custom:focus-within .form-control {
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
    html.dark-mode .input-group-custom .form-control {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark-mode .input-group-custom:focus-within .input-group-text {
        border-color: #60a5fa !important;
        background-color: #1e293b !important;
        color: #93c5fd !important;
    }
    html.dark-mode .input-group-custom:focus-within .form-control {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25) !important;
    }
</style>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="form-card mb-4">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-plus-box-outline"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Tambah Mata Pelajaran Baru</h4>
                        <p class="text-muted small mb-0">Masukkan data kode dan nama mata pelajaran dengan benar.</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-4 p-md-4">
                <form action="{{ route('admin.mapel.store') }}" method="POST" class="forms-sample">
                    @csrf

                    <div class="row g-3">
                        {{-- Kode Mapel --}}
                        <div class="col-md-5">
                            <label for="kode_mapel" class="form-label-custom d-block">
                                Kode Mapel <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-bookmark-outline"></i>
                                </span>
                                <input type="text" name="kode_mapel" id="kode_mapel" 
                                       class="form-control @error('kode_mapel') is-invalid @enderror" 
                                       placeholder="Contoh: MP-01 atau BIN" 
                                       value="{{ old('kode_mapel') }}" required style="text-transform: uppercase;">
                            </div>
                            @error('kode_mapel')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>

                        {{-- Nama Mapel --}}
                        <div class="col-md-7">
                            <label for="nama_mapel" class="form-label-custom d-block">
                                Nama Mata Pelajaran <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-book-open-variant"></i>
                                </span>
                                <input type="text" name="nama_mapel" id="nama_mapel" 
                                       class="form-control @error('nama_mapel') is-invalid @enderror" 
                                       placeholder="Contoh: Bahasa Indonesia" 
                                       value="{{ old('nama_mapel') }}" required>
                            </div>
                            @error('nama_mapel')
                                <small class="text-danger d-block mt-1 fw-bold">
                                    <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="/admin/master/mapel" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Simpan Mapel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
