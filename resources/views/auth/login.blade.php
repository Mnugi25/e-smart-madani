<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — E-Learning SMK Al-Madani</title>
    <!-- Favicon (SMK Al-Madani Logo) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />
    <link rel="shortcut icon" href="{{ asset('template/images/smk madani.jpg') }}?v=2" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            background: #070c1a;
        }

        .login-container {
            height: 100vh;
            display: flex;
        }

        /* ===== SISI KIRI: PREMIUM GRADIENT PANEL ===== */
        .brand-panel {
            flex: 0 0 50%;
            background: linear-gradient(145deg, #050a22 0%, #0b1a4f 45%, #16368c 80%, #1e40af 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Abstract decorative blobs */
        .blob-dec {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .blob-dec-1 {
            width: 440px; height: 440px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.28) 0%, transparent 70%);
            top: -120px; right: -90px;
        }
        .blob-dec-2 {
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, transparent 70%);
            bottom: -70px; left: -90px;
        }
        .blob-dec-3 {
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.18) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Grid lines deco */
        .grid-deco {
            display: none;
        }

        .brand-top {
            position: relative; z-index: 2;
            display: flex; align-items: center; gap: 12px;
        }
        .brand-logo-box {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid rgba(255,255,255,0.35);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .brand-logo-box img {
            width: 52px; height: 52px;
            border-radius: 50%;
            object-fit: cover;
        }
        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: #ffffff;
            line-height: 1;
            letter-spacing: -0.3px;
        }
        .brand-name span {
            color: #a5b4fc;
            font-size: 11px;
            font-weight: 600;
            display: block;
            margin-top: 3px;
            letter-spacing: 0.3px;
        }

        .brand-middle {
            position: relative; z-index: 2;
        }
        .brand-middle h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 40px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
        }
        .brand-middle h2 em {
            font-style: normal;
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .brand-middle p {
            font-size: 14.5px;
            color: rgba(255,255,255,0.72);
            line-height: 1.7;
            max-width: 400px;
        }

        /* Feature list glassmorphism */
        .feature-glass {
            margin-top: 36px;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.25);
        }
        .feature-item {
            display: flex; align-items: center; gap: 14px;
        }
        .feature-icon-box {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .feature-item h6 {
            font-size: 13px; font-weight: 700; color: #ffffff; margin: 0 0 2px;
        }
        .feature-item p {
            font-size: 11.5px; color: rgba(255,255,255,0.6); margin: 0;
        }

        .brand-bottom {
            position: relative; z-index: 2;
            display: flex; gap: 8px; flex-wrap: wrap;
        }
        .tag-pill {
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 100px;
            padding: 6px 15px;
            font-size: 11.5px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            display: inline-flex; align-items: center; gap: 6px;
            backdrop-filter: blur(8px);
        }

        /* ===== SISI KANAN: MIDNIGHT SLATE & GLASS FORM PANEL ===== */
        .form-panel {
            flex: 0 0 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 85% 15%, #132247 0%, #0b1329 45%, #070c1a 100%);
            padding: 48px;
            position: relative;
            overflow: hidden;
            border-left: 1px solid rgba(255, 255, 255, 0.06);
        }

        .form-panel::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.16) 0%, transparent 70%);
            pointer-events: none;
            filter: blur(50px);
        }
        .form-panel::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -80px;
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.14) 0%, transparent 70%);
            pointer-events: none;
            filter: blur(50px);
        }

        .login-box {
            width: 100%;
            max-width: 430px;
            position: relative; z-index: 2;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 38px 36px 36px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        /* Header login form */
        .login-header { margin-bottom: 28px; }
        .login-header h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 30px; font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.8px;
            margin-bottom: 6px;
        }
        .login-header p {
            font-size: 14px; color: #94a3b8; margin: 0;
        }

        /* Input fields */
        .field-group { margin-bottom: 20px; }
        .field-label {
            font-size: 12.5px; font-weight: 700;
            color: #cbd5e1; margin-bottom: 7px; display: block;
            letter-spacing: 0.2px;
        }
        .field-wrap {
            position: relative;
        }
        .field-wrap svg {
            color: #64748b !important;
            transition: color 0.2s ease;
        }
        .field-wrap:focus-within svg {
            color: #38bdf8 !important;
        }
        .field-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            font-size: 14px; font-weight: 500;
            color: #ffffff;
            background: rgba(11, 19, 38, 0.85);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.25s ease;
            outline: none;
        }
        .field-input::placeholder {
            color: #64748b;
        }
        .field-input:focus {
            background: #0b1329;
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.18);
            color: #ffffff;
        }

        /* Password toggle */
        .toggle-pass {
            position: absolute; right: 14px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px; color: #64748b;
            cursor: pointer; transition: color 0.2s;
            z-index: 2;
        }
        .toggle-pass:hover { color: #38bdf8 !important; }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #4f46e5 100%);
            color: #ffffff;
            font-size: 14px; font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 25px -4px rgba(37, 99, 235, 0.5);
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 10px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 50%, #4338ca 100%);
            box-shadow: 0 14px 30px -4px rgba(56, 189, 248, 0.5);
        }
        .btn-login:active { transform: translateY(0); }

        /* Alert error */
        .alert-custom {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: #fca5a5;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }

        /* Footer form */
        .form-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: #64748b;
        }
        .form-footer a {
            color: #94a3b8; font-weight: 600; text-decoration: none;
        }
        .form-footer a:hover { color: #38bdf8; }

        /* Mobile brand header */
        .mobile-brand {
            text-align: center;
            margin-bottom: 28px;
            display: none;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .brand-panel { display: none !important; }
            .form-panel {
                flex: 0 0 100%;
                padding: 36px 18px;
                min-height: 100vh;
            }
            .login-box {
                padding: 28px 22px;
                border-radius: 20px;
            }
            .mobile-brand { display: block; }
            body { overflow-y: auto; }
        }
        @media (max-width: 480px) {
            .form-panel { padding: 24px 14px; }
        }
    </style>
</head>
<body>

<div class="login-container">

    <!-- ===== SISI KIRI ===== -->
    <div class="brand-panel d-none d-lg-flex flex-column justify-content-between">
        <div class="blob-dec blob-dec-1"></div>
        <div class="blob-dec blob-dec-2"></div>
        <div class="blob-dec blob-dec-3"></div>
        <div class="grid-deco"></div>

        <!-- Brand Top -->
        <div class="brand-top">
            <div class="brand-logo-box">
                <img src="{{ asset('template/images/smk madani.jpg') }}" alt="Logo SMK Al-Madani">
            </div>
            <div class="brand-name">
                E-Learning SMK Al-Madani
                <span>Pontianak, Kalimantan Barat</span>
            </div>
        </div>

        <!-- Brand Middle -->
        <div class="brand-middle">
            <h2>Belajar lebih<br>cerdas, <em>tanpa batas</em>.</h2>
            <p>Platform digital terintegrasi untuk kehadiran, ujian, dan evaluasi akademik siswa SMK Al-Madani Pontianak secara real-time dan transparan.</p>

            <div class="feature-glass">
                <div class="feature-item">
                    <div class="feature-icon-box" style="background: rgba(74, 222, 128, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#4ade80" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h6>Akses Aman & Terenkripsi</h6>
                        <p>Seluruh data akun dilindungi dengan enkripsi tingkat tinggi.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-box" style="background: rgba(251, 191, 36, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fbbf24" viewBox="0 0 16 16">
                            <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                        </svg>
                    </div>
                    <div>
                        <h6>Pemrosesan Real-Time</h6>
                        <p>Presensi dan nilai terekam instan tanpa jeda pemrosesan.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-box" style="background: rgba(165, 180, 252, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#a5b4fc" viewBox="0 0 16 16">
                            <path d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"/>
                        </svg>
                    </div>
                    <div>
                        <h6>Analisis & Ranking SAW</h6>
                        <p>Guru & admin dapat melihat rekap dan ranking siswa otomatis.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brand Bottom Pills -->
        <div class="brand-bottom">
            <span class="tag-pill"><i class="bi bi-award-fill" style="color: #fbbf24;"></i> Disiplin</span>
            <span class="tag-pill"><i class="bi bi-cpu-fill" style="color: #a5b4fc;"></i> Modern</span>
            <span class="tag-pill"><i class="bi bi-heart-fill" style="color: #f87171;"></i> Berkarakter</span>
            <span class="tag-pill"><i class="bi bi-geo-alt-fill" style="color: #4ade80;"></i> Pontianak</span>
        </div>
    </div>

    <!-- ===== SISI KANAN: FORM ===== -->
    <div class="form-panel">
        <div class="login-box">

            <!-- Mobile-only brand header -->
            <div class="mobile-brand">
                <img src="{{ asset('template/images/smk madani.jpg') }}" alt="Logo" style="width: 52px; height: 52px; border-radius: 16px; object-fit: cover; margin-bottom: 12px; box-shadow: 0 8px 20px rgba(37,99,235,0.35);">
                <div style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 20px; color: #ffffff; letter-spacing: -0.5px;">E-Learning SMK Al-Madani</div>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 3px;">Pontianak, Kalimantan Barat</div>
            </div>

            <!-- Heading -->
            <div class="login-header">
                <h3>Selamat Datang 👋</h3>
                <p>Masuk ke portal E-Learning SMK Al-Madani</p>
            </div>

            <!-- Error Alert -->
            @if(session()->has('loginError'))
                <div class="alert-custom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f87171" viewBox="0 0 16 16" style="flex-shrink:0">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    {{ session('loginError') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="/login" method="POST">
                @csrf

                <div class="field-group">
                    <label for="username" class="field-label">Username / NISN</label>
                    <div class="field-wrap">
                        <input type="text" name="username" id="username"
                            class="field-input @error('username') is-invalid @enderror"
                            placeholder="Masukkan username atau NISN"
                            value="{{ old('username') }}" autofocus required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16"
                            style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#64748b; pointer-events:none;">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        @error('username')
                            <div style="font-size: 12px; color: #f87171; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">Password</label>
                    <div class="field-wrap">
                        <input type="password" name="password" id="password"
                            class="field-input"
                            placeholder="Masukkan password Anda" required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16"
                            style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#64748b; pointer-events:none;">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <span id="togglePass" onclick="togglePassword()" class="toggle-pass">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                    Masuk ke Sistem
                </button>

            </form>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('togglePass');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            if (icon) icon.style.color = '#2563eb';
        } else {
            pwd.type = 'password';
            if (icon) icon.style.color = '#94a3b8';
        }
    }
</script>
</body>
</html>
