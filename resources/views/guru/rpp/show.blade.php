@extends('template.layouts.app')

@section('title', 'Detail Dokumen RPP')

@push('styles')
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
        padding: 20px 24px;
    }
    .form-card-body {
        padding: 24px;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }
    .detail-item {
        background: #f8fafc;
        padding: 14px 18px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .detail-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
        flex-shrink: 0;
    }
    .detail-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }
    .detail-value {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    /* Document Paper Preview */
    .rpp-document-paper {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 42px 48px;
        min-height: 800px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.04);
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.7;
        color: #1e293b;
    }
    .rpp-document-paper table {
        width: 100%;
        border-collapse: collapse;
        margin: 18px 0;
    }
    .rpp-document-paper th, 
    .rpp-document-paper td {
        border: 1.5px solid #cbd5e1;
        padding: 10px 14px;
        text-align: left;
    }
    .rpp-document-paper th {
        background-color: #f8fafc;
        font-weight: 700;
        color: #0f172a;
    }
    .rpp-document-paper h1, 
    .rpp-document-paper h2, 
    .rpp-document-paper h3, 
    .rpp-document-paper h4 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 24px;
        margin-bottom: 12px;
    }
    .rpp-document-paper ul, 
    .rpp-document-paper ol {
        padding-left: 24px;
        margin-bottom: 16px;
    }
    .rpp-document-paper li {
        margin-bottom: 6px;
    }

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
    html.dark-mode .form-card {
        background: #18181b !important;
        border-color: #27272a !important;
    }
    html.dark-mode .form-card-header {
        background: linear-gradient(135deg, #18181b 0%, #1e1b4b 100%) !important;
        border-bottom-color: #27272a !important;
    }
    html.dark-mode .detail-item {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark-mode .detail-value {
        color: #f8fafc !important;
    }
    html.dark-mode .detail-label {
        color: #94a3b8 !important;
    }
    html.dark-mode .rpp-document-paper {
        background: #18181b !important;
        border-color: #27272a !important;
        color: #e4e4e7 !important;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark-mode .rpp-document-paper th {
        background-color: #27272a !important;
        color: #f4f4f5 !important;
    }
    html.dark-mode .rpp-document-paper th, 
    html.dark-mode .rpp-document-paper td {
        border-color: #3f3f46 !important;
    }
    html.dark-mode .rpp-document-paper h1, 
    html.dark-mode .rpp-document-paper h2, 
    html.dark-mode .rpp-document-paper h3, 
    html.dark-mode .rpp-document-paper h4 {
        color: #f4f4f5 !important;
    }

    /* Print Mode Styling */
    @media print {
        body * {
            visibility: hidden !important;
        }
        .rpp-document-paper, 
        .rpp-document-paper * {
            visibility: visible !important;
        }
        .rpp-document-paper {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 20mm !important;
            border: none !important;
            box-shadow: none !important;
            background: #ffffff !important;
            color: #000000 !important;
        }
        .rpp-document-paper th {
            background-color: #f3f4f6 !important;
            color: #000000 !important;
        }
        .rpp-document-paper th, 
        .rpp-document-paper td {
            border-color: #4b5563 !important;
            color: #000000 !important;
        }
        .no-print {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .rpp-document-paper {
            padding: 24px 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="row no-print">
    {{-- Top Header --}}
    <div class="col-12 mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold mb-1" style="font-size: 1.25rem; color: #0f172a;">
                    <i class="mdi mdi-file-document-outline text-primary me-2"></i>Detail Dokumen RPP AI
                </h4>
                <p class="text-muted small mb-0">Pratinjau lengkap dan cetak dokumen RPP Kurikulum Merdeka.</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('guru.rpp.index') }}" class="btn-back-modern">
                    <div class="btn-back-icon">
                        <i class="mdi mdi-arrow-left"></i>
                    </div>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('guru.rpp.edit', $rpp->id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-3.5 py-2 d-inline-flex align-items-center shadow-xs" style="background: linear-gradient(135deg, #fbbf24, #f59e0b); border: none;">
                    <i class="mdi mdi-pencil-outline me-1.5"></i> Edit RPP
                </a>
                <button type="button" id="btn-print" class="btn btn-danger text-white fw-bold rounded-pill px-3.5 py-2 d-inline-flex align-items-center shadow-xs" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none;">
                    <i class="mdi mdi-printer me-1.5"></i> Cetak / PDF
                </button>
            </div>
        </div>
    </div>

    {{-- Metadata Information Card --}}
    <div class="col-12 mb-4">
        <div class="form-card">
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10" style="width: 42px; height: 42px; font-size: 1.3rem;">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">Informasi & Capaian Pembelajaran</h5>
                        <p class="text-muted small mb-0">Rincian metadata dokumen modul ajar yang telah disusun</p>
                    </div>
                </div>
            </div>

            <div class="form-card-body">
                <div class="detail-grid">
                    {{-- Mapel --}}
                    <div class="detail-item">
                        <div class="detail-icon-box">
                            <i class="mdi mdi-book-open-page-variant"></i>
                        </div>
                        <div>
                            <div class="detail-label">Mata Pelajaran</div>
                            <div class="detail-value">{{ $rpp->mataPelajaran->nama_mapel ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Kelas & Fase --}}
                    <div class="detail-item">
                        <div class="detail-icon-box text-success" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                            <i class="mdi mdi-google-classroom"></i>
                        </div>
                        <div>
                            <div class="detail-label">Kelas & Fase</div>
                            <div class="detail-value">
                                {{ $rpp->kelas->nama_kelas ?? '-' }}
                                @if(!empty($rpp->fase))
                                    <span class="badge bg-info-subtle text-info fw-bold rounded-pill ms-1" style="font-size: 0.72rem;">
                                        Fase {{ $rpp->fase }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Topik --}}
                    <div class="detail-item">
                        <div class="detail-icon-box text-warning" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
                            <i class="mdi mdi-text-box-search-outline"></i>
                        </div>
                        <div>
                            <div class="detail-label">Topik / Materi</div>
                            <div class="detail-value">{{ Str::limit($rpp->topik, 40) }}</div>
                        </div>
                    </div>

                    {{-- Alokasi Waktu --}}
                    <div class="detail-item">
                        <div class="detail-icon-box text-info" style="background: rgba(14, 165, 233, 0.08); color: #0ea5e9;">
                            <i class="mdi mdi-clock-outline"></i>
                        </div>
                        <div>
                            <div class="detail-label">Alokasi Waktu</div>
                            <div class="detail-value">{{ $rpp->alokasi_waktu ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Model Pembelajaran --}}
                    <div class="detail-item">
                        <div class="detail-icon-box text-purple" style="background: rgba(147, 51, 234, 0.08); color: #9333ea;">
                            <i class="mdi mdi-shape-outline"></i>
                        </div>
                        <div>
                            <div class="detail-label">Model Belajar</div>
                            <div class="detail-value">{{ $rpp->model_pembelajaran ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Tanggal Dibuat --}}
                    <div class="detail-item">
                        <div class="detail-icon-box text-secondary" style="background: rgba(100, 116, 139, 0.08); color: #64748b;">
                            <i class="mdi mdi-calendar-blank-outline"></i>
                        </div>
                        <div>
                            <div class="detail-label">Tanggal Dibuat</div>
                            <div class="detail-value">{{ $rpp->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Profil Pelajar Pancasila Chips --}}
                @if(!empty($rpp->profil_pelajar_pancasila))
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="text-muted small fw-bold me-1">
                                <i class="mdi mdi-shield-check-outline text-primary me-1"></i>Profil Pelajar Pancasila:
                            </span>
                            @foreach($rpp->profil_pelajar_pancasila as $p3)
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1.5" style="font-size: 0.78rem;">
                                    {{ $p3 }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Paper Lembar Kerja Dokumen RPP (Dicetak saat print) --}}
<div class="row">
    <div class="col-12">
        <div class="rpp-document-paper">
            {!! $rpp->konten !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btn-print').addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endpush
