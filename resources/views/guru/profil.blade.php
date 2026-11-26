@extends('template.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-12 mb-4">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">
                <h4 class="card-title fw-bold text-dark"><i class="mdi mdi-account-card-details text-primary"></i> Data Pribadi</h4>
                <p class="card-description text-muted">Perbarui informasi profil Anda di sini.</p>

                <form action="/guru/profil/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="fw-semibold text-small mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold text-small mb-1">Alamat Email</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ Auth::user()->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm text-white w-100 mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 mb-4">
        <div class="card card-rounded shadow-sm">
            <div class="card-body">
                <h4 class="card-title fw-bold text-dark"><i class="mdi mdi-key-variant text-warning"></i> Ganti Password</h4>
                <p class="card-description text-muted">Amankan akun dengan memperbarui password secara berkala.</p>

                <form action="/guru/profil/password" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="fw-semibold text-small mb-1">Password Sekarang</label>
                        <input type="password" name="current_password" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold text-small mb-1">Password Baru</label>
                        <input type="password" name="password" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold text-small mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm text-dark w-100 mt-2 fw-semibold">Perbarui Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
