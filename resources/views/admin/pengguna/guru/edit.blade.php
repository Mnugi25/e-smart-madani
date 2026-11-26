@extends('template.layouts.app')

@section('title', 'Ubah Akun Guru')

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
    .credential-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
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
    html.dark-mode .credential-box {
        background: #1e293b !important;
        border-color: #334155 !important;
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
    <div class="col-lg-9 mx-auto">
        <div class="form-card mb-4">
            {{-- Header Card --}}
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 44px; height: 44px; font-size: 1.35rem;">
                        <i class="mdi mdi-pencil-box-outline"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Ubah Akun Guru</h4>
                        <p class="text-muted small mb-0">Perbarui kredensial akun login guru.</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-4 p-md-4">
                <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')

                    {{-- Data Profil Guru (Read-Only) --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom d-block">Kode Guru</label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-card-details-outline"></i>
                                </span>
                                <input type="text" class="form-control" value="{{ $guru->kode_guru }}" readonly style="background-color: #f1f5f9;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom d-block">Nama Lengkap</label>
                            <div class="input-group input-group-custom">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account"></i>
                                </span>
                                <input type="text" class="form-control" value="{{ $guru->nama_lengkap }}" readonly style="background-color: #f1f5f9;">
                            </div>
                        </div>
                    </div>

                    {{-- Kredensial Login --}}
                    <div class="credential-box mb-4">
                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                            <i class="mdi mdi-lock-outline"></i> Kredensial Akun Login
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label-custom d-block">
                                    Email Login <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-custom">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-email-outline"></i>
                                    </span>
                                    <input type="email" name="email" id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $guru->user?->email) }}" 
                                           placeholder="contoh@guru.sch.id" required>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">* Digunakan sebagai email identitas masuk sistem.</small>
                                @error('email')
                                    <small class="text-danger d-block mt-1 fw-bold">
                                        <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label-custom d-block">
                                    Password Baru <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <div class="input-group input-group-custom">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-key-outline"></i>
                                    </span>
                                    <input type="password" name="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Kosongkan jika tidak ingin diubah">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">* Isi hanya jika ingin mereset/mengganti password lama.</small>
                                @error('password')
                                    <small class="text-danger d-block mt-1 fw-bold">
                                        <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('admin.guru') }}" class="btn btn-dark fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-1.5"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary text-white fw-bold rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-xs">
                            <i class="mdi mdi-content-save-outline me-1.5"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
