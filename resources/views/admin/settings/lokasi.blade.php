@extends('template.layouts.app')

@section('title', 'Pengaturan Lokasi Ujian')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    #map {
        height: 480px;
        width: 100%;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }
    .inner-settings-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
    }
    .form-label-custom {
        font-size: 0.84rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .input-group-custom .input-group-text {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #64748b;
        padding: 0.65rem 0.95rem;
        transition: all 0.2s ease;
    }
    .input-group-custom .form-control {
        border: 1px solid #cbd5e1;
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

    /* Dark Mode Theme Support */
    html.dark-mode .inner-settings-card {
        background: #18181b !important;
        border-color: #27272a !important;
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
    html.dark-mode #map {
        border-color: #334155 !important;
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
                            <i class="mdi mdi-map-marker-radius text-primary me-2"></i>Pengaturan Lokasi Ujian
                        </h4>
                        <p class="card-subtitle card-subtitle-dash">Tentukan titik koordinat sekolah dan batas radius jangkauan agar siswa hanya bisa mengerjakan ujian dari area sekolah saja.</p>
                    </div>
                </div>

                {{-- Alert Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-check-circle me-2 fs-5"></i>
                            <div><strong>Sukses!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Content Grid: Form & Map --}}
                <div class="row g-4">
                    <!-- Kolom Kiri: Form Pengaturan -->
                    <div class="col-lg-4">
                        <div class="inner-settings-card p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 1rem;">
                                    <i class="mdi mdi-tune text-primary"></i> Koordinat Sekolah
                                </h5>

                                <form action="{{ route('admin.settings.lokasi.update') }}" method="POST" id="locationForm">
                                    @csrf
                                    @method('PUT')

                                    <!-- Latitude -->
                                    <div class="form-group mb-3">
                                        <label for="school_latitude" class="form-label-custom d-block">
                                            Latitude <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text border-end-0 rounded-start-2">
                                                <i class="mdi mdi-compass-outline"></i>
                                            </span>
                                            <input type="text" name="school_latitude" id="school_latitude" 
                                                   class="form-control border-start-0 rounded-end-2 @error('school_latitude') is-invalid @enderror" 
                                                   value="{{ old('school_latitude', $latitude) }}" required readonly style="background-color: #f1f5f9;">
                                        </div>
                                        @error('school_latitude')
                                            <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Longitude -->
                                    <div class="form-group mb-3">
                                        <label for="school_longitude" class="form-label-custom d-block">
                                            Longitude <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text border-end-0 rounded-start-2">
                                                <i class="mdi mdi-compass-outline"></i>
                                            </span>
                                            <input type="text" name="school_longitude" id="school_longitude" 
                                                   class="form-control border-start-0 rounded-end-2 @error('school_longitude') is-invalid @enderror" 
                                                   value="{{ old('school_longitude', $longitude) }}" required readonly style="background-color: #f1f5f9;">
                                        </div>
                                        @error('school_longitude')
                                            <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Radius -->
                                    <div class="form-group mb-4">
                                        <label for="school_radius" class="form-label-custom d-block">
                                            Radius Jangkauan (Meter) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-custom">
                                            <span class="input-group-text border-end-0 rounded-start-2">
                                                <i class="mdi mdi-radius-outline"></i>
                                            </span>
                                            <input type="number" name="school_radius" id="school_radius" 
                                                   class="form-control border-start-0 border-end-0 @error('school_radius') is-invalid @enderror" 
                                                   value="{{ old('school_radius', $radius) }}" min="10" max="1000" required>
                                            <span class="input-group-text border-start-0 rounded-end-2">Meter</span>
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size: 0.74rem;">* Saran: 50 s.d 200 meter untuk jangkauan area sekolah.</small>
                                        @error('school_radius')
                                            <small class="text-danger mt-1 d-block fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary fw-bold rounded-pill w-100 py-2 d-flex align-items-center justify-content-center gap-1.5 shadow-xs" id="btnGetCurrentLocation">
                                            <i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi Saya
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="pt-3 border-top mt-2">
                                <button type="submit" form="locationForm" class="btn btn-primary text-white fw-bold rounded-pill w-100 py-2.5 d-flex align-items-center justify-content-center gap-1.5 shadow-xs">
                                    <i class="mdi mdi-content-save-outline"></i> Simpan Lokasi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Peta Interaktif -->
                    <div class="col-lg-8">
                        <div class="inner-settings-card p-4 h-100">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size: 1rem;">
                                    <i class="mdi mdi-map-outline text-primary"></i> Peta Sekolah
                                </h5>
                                <span class="badge bg-light text-primary border rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.78rem;">
                                    Klik pada peta untuk memindahkan titik lokasi
                                </span>
                            </div>

                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil data koordinat & radius dari php variables
        let initialLat = parseFloat("{{ $latitude }}");
        let initialLng = parseFloat("{{ $longitude }}");
        let initialRadius = parseInt("{{ $radius }}");

        // Inisialisasi Peta
        const map = L.map('map').setView([initialLat, initialLng], 17);

        // Tambah Layer Satelit Google Maps (Hybrid: Satelit + Jalan & Label)
        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google Maps'
        }).addTo(map);

        // Marker & Circle
        let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);
        let circle = L.circle([initialLat, initialLng], {
            color: '#1e40af',
            fillColor: '#3b82f6',
            fillOpacity: 0.2,
            radius: initialRadius
        }).addTo(map);

        // Fungsi memperbarui form input & lingkaran radius
        function updateCoordinates(lat, lng) {
            document.getElementById('school_latitude').value = lat.toFixed(7);
            document.getElementById('school_longitude').value = lng.toFixed(7);
            circle.setLatLng([lat, lng]);
            marker.setLatLng([lat, lng]);
        }

        // Event saat marker di-drag
        marker.on('dragend', function(e) {
            let latLng = marker.getLatLng();
            updateCoordinates(latLng.lat, latLng.lng);
        });

        // Event saat peta diklik
        map.on('click', function(e) {
            updateCoordinates(e.latlng.lat, e.latlng.lng);
        });

        // Event saat radius diubah
        document.getElementById('school_radius').addEventListener('input', function(e) {
            let r = parseInt(e.target.value);
            if (!isNaN(r) && r > 0) {
                circle.setRadius(r);
            }
        });

        // Tombol Ambil Lokasi Saya
        const btnLocation = document.getElementById('btnGetCurrentLocation');
        if (btnLocation) {
            btnLocation.addEventListener('click', function() {
                if (navigator.geolocation) {
                    const btn = this;
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mencari...';

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            let userLat = position.coords.latitude;
                            let userLng = position.coords.longitude;

                            map.setView([userLat, userLng], 17);
                            updateCoordinates(userLat, userLng);

                            btn.disabled = false;
                            btn.innerHTML = '<i class="mdi mdi-crosshairs-gps me-1"></i> Ambil Lokasi Saya';
                        },
                        function(error) {
                            alert("Gagal mendapatkan lokasi Anda: " + error.message);
                            btn.disabled = false;
                            btn.innerHTML = '<i class="mdi mdi-crosshairs-gps me-1"></i> Ambil Lokasi Saya';
                        },
                        { enableHighAccuracy: true }
                    );
                } else {
                    alert("Browser Anda tidak mendukung deteksi lokasi (Geolocation).");
                }
            });
        }
    });
</script>
@endsection
