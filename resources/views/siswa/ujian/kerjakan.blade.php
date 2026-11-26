@extends('template.layouts.app')

@section('title', 'Mengerjakan Ujian')

@section('content')
<style>
    /* CSS Khusus Ujian - Dark Mode & Responsive */
    .card-guru {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        background: #fff;
    }
    html.dark-mode .card-guru {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        color: #e2e8f0 !important;
    }
    html.dark-mode .border-bottom {
        border-color: #334155 !important;
    }
    html.dark-mode .bg-light {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
    }
    html.dark-mode .form-check-label {
        color: #cbd5e1 !important;
    }

    /* CSS Navigasi Soal (Merah jika belum, Hijau jika sudah, Biru jika Aktif) */
    .nav-btn {
        transition: all 0.2s ease;
        cursor: pointer;
        font-weight: bold;
    }
    .nav-btn.btn-unanswered {
        background-color: #dc3545 !important; /* Merah */
        color: #fff !important;
        border: 1px solid #dc3545 !important;
    }
    .nav-btn.btn-answered {
        background-color: #198754 !important; /* Hijau */
        color: #fff !important;
        border: 1px solid #198754 !important;
    }
    .nav-btn.btn-active {
        background-color: #0d6efd !important; /* Biru */
        color: #fff !important;
        border: 2px solid #0b5ed7 !important;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.5);
    }
    html.dark-mode .nav-btn.btn-unanswered {
        background-color: #ef4444 !important; /* Merah terang di Dark Mode */
        color: #fff !important;
        border: 1px solid #ef4444 !important;
    }
    html.dark-mode .nav-btn.btn-answered {
        background-color: #10b981 !important; /* Hijau emerald di Dark Mode */
        color: #fff !important;
        border: 1px solid #10b981 !important;
    }
    html.dark-mode .nav-btn.btn-active {
        background-color: #3b82f6 !important;
        color: #fff !important;
        border: 2px solid #2563eb !important;
    }

    /* Premium Check Option Card Styling */
    .form-check-option {
        padding: 14px 16px 14px 44px;
        margin-bottom: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }
    .form-check-option:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }
    .form-check-option input[type="radio"] {
        margin-left: -28px;
        margin-top: 4px;
    }
    .form-check-option .form-check-label {
        cursor: pointer;
        display: block;
        width: 100%;
        margin-bottom: 0;
    }
    /* Active highlight style for selected option */
    .form-check-option:has(input[type="radio"]:checked) {
        background-color: #eff6ff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }
    html.dark-mode .form-check-option {
        background-color: #1e293b;
        border: 1px solid #334155;
    }
    html.dark-mode .form-check-option:hover {
        background-color: #334155;
        border-color: #475569;
    }
    html.dark-mode .form-check-option:has(input[type="radio"]:checked) {
        background-color: #1e3a8a;
        border-color: #3b82f6;
    }
    
    /* Responsive tweaks */
    @media (max-width: 768px) {
        .card-guru {
            border-radius: 12px;
        }
        .form-check-option {
            padding: 12px 14px 12px 38px;
        }
        .form-check-option input[type="radio"] {
            margin-left: -24px;
        }
    }
</style>

<div class="row">
    <!-- Header Ujian (Full Width - Selalu di Paling Atas baik Desktop maupun Mobile) -->
    <div class="col-12 mb-3">
        <div class="card card-guru border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <h4 class="fw-bold text-dark mb-1 fs-5 fs-md-4">{{ $ujian->judul }}</h4>
                <span class="text-muted small">{{ $ujian->mataPelajaran->nama_mapel }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Kolom Kanan: Timer & Daftar Soal (Desktop: Kanan, Mobile: ATAS) -->
    <div class="col-lg-4 order-1 order-lg-2 mb-4">
        <div class="row">
            <!-- Card Timer & Progres (50% Lebar di Mobile, 100% di Desktop) -->
            <div class="col-6 col-lg-12 mb-3">
                <div class="card card-guru border-0 shadow-sm h-100">
                    <div class="card-body p-2 p-md-4 text-center d-flex flex-column justify-content-center">
                        <span class="text-muted small d-block mb-1 fw-bold uppercase" style="font-size: 0.7rem;">SISA WAKTU</span>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="badge bg-danger rounded-pill px-2 py-1.5 fs-6 w-100 shadow-sm d-flex align-items-center justify-content-center gap-1" style="font-size: 0.85rem !important;">
                                <i class="mdi mdi-timer" style="font-size: 0.9rem;"></i> <span id="timer" class="fw-bold">--:--</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Soal (50% Lebar di Mobile, 100% di Desktop) -->
            <div class="col-6 col-lg-12 mb-3">
                <div class="card card-guru border-0 shadow-sm h-100">
                    <div class="card-body p-2 p-md-4 d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <span class="fw-bold text-dark d-block small uppercase text-muted" style="font-size: 0.7rem; margin-bottom: 0;">Daftar Soal:</span>
                        </div>
                        <div class="d-flex flex-wrap gap-1 justify-content-start" id="questionNav">
                            @foreach($ujian->soal as $index => $s)
                            <button type="button" class="btn btn-sm nav-btn btn-unanswered" id="nav-btn-{{ $index }}" onclick="showQuestion({{ $index }})" style="width: 32px; height: 32px; border-radius: 6px; font-size: 0.8rem; padding: 0;">
                                {{ $index + 1 }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kiri: Soal Ujian (Desktop: Kiri, Mobile: BAWAH) -->
    <div class="col-lg-8 order-2 order-lg-1 mb-4">
        <div class="card card-guru border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <!-- Form Ujian -->
                <form id="ujianForm" action="{{ route('siswa.ujian.submit', $ujian->id) }}" method="POST">
                    @csrf
                    
                    @foreach($ujian->soal as $index => $s)
                    <div class="question-container mb-4" id="question-{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                        <div class="p-3 p-md-4 rounded-3 bg-light border-start border-primary border-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold">Soal {{ $index + 1 }} dari {{ $ujian->soal->count() }}</span>
                            </div>
                            
                            <p class="mb-4 text-dark fw-bold" style="font-size: 1.15rem; line-height: 1.6;">{{ $s->pertanyaan }}</p>
                            
                            <div class="options ps-1">
                                <div class="form-check form-check-option">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $s->id }}]" id="q{{ $s->id }}a" value="a">
                                    <label class="form-check-label text-dark" for="q{{ $s->id }}a">A. {{ $s->opsi_a }}</label>
                                </div>
                                <div class="form-check form-check-option">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $s->id }}]" id="q{{ $s->id }}b" value="b">
                                    <label class="form-check-label text-dark" for="q{{ $s->id }}b">B. {{ $s->opsi_b }}</label>
                                </div>
                                <div class="form-check form-check-option">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $s->id }}]" id="q{{ $s->id }}c" value="c">
                                    <label class="form-check-label text-dark" for="q{{ $s->id }}c">C. {{ $s->opsi_c }}</label>
                                </div>
                                <div class="form-check form-check-option">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $s->id }}]" id="q{{ $s->id }}d" value="d">
                                    <label class="form-check-label text-dark" for="q{{ $s->id }}d">D. {{ $s->opsi_d }}</label>
                                </div>
                                @if($s->opsi_e)
                                <div class="form-check form-check-option">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $s->id }}]" id="q{{ $s->id }}e" value="e">
                                    <label class="form-check-label text-dark" for="q{{ $s->id }}e">E. {{ $s->opsi_e }}</label>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Tombol Kirim Jawaban (Selalu Terlihat di Bagian Bawah Form) -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <button type="submit" id="submitBtn" class="btn btn-success btn-lg rounded-pill px-5 py-2 text-white shadow fw-bold fs-6" onclick="return confirm('Apakah Anda yakin ingin mengakhiri dan mengirimkan jawaban ujian ini?')">
                            Kirim Jawaban <i class="mdi mdi-check-circle ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // State management & Persistence Keys
    const siswaId = {{ Auth::user()->siswa->id }};
    const ujianId = {{ $ujian->id }};
    const timerKey = `exam_start_${siswaId}_${ujianId}`;
    const answersKey = `exam_answers_${siswaId}_${ujianId}`;

    let currentQuestionIndex = 0;
    const totalQuestions = {{ $ujian->soal->count() }};

    function showQuestion(index) {
        if (index < 0 || index >= totalQuestions) return;

        // Hide all questions
        document.querySelectorAll('.question-container').forEach(q => {
            q.style.display = 'none';
        });

        // Show current question
        document.getElementById(`question-${index}`).style.display = 'block';
        currentQuestionIndex = index;

        // Update Nav status
        updateNavStatus();
    }

    function updateNavStatus() {
        document.querySelectorAll('.question-container').forEach((container, idx) => {
            const navBtn = document.getElementById(`nav-btn-${idx}`);
            const isAnswered = container.querySelector('input[type="radio"]:checked') !== null;
            
            navBtn.classList.remove('btn-active', 'btn-answered', 'btn-unanswered');
            
            if (idx === currentQuestionIndex) {
                navBtn.classList.add('btn-active');
            } else if (isAnswered) {
                navBtn.classList.add('btn-answered');
            } else {
                navBtn.classList.add('btn-unanswered');
            }
        });
    }

    // Save answers to localStorage
    function saveAnswers() {
        const answers = {};
        document.querySelectorAll('.question-container').forEach(container => {
            const checkedRadio = container.querySelector('input[type="radio"]:checked');
            if (checkedRadio) {
                const name = checkedRadio.getAttribute('name');
                const match = name.match(/jawaban\[(\d+)\]/);
                if (match) {
                    const soalId = match[1];
                    answers[soalId] = checkedRadio.value;
                }
            }
        });
        localStorage.setItem(answersKey, JSON.stringify(answers));
    }

    // Load answers from localStorage
    function loadSavedAnswers() {
        const saved = localStorage.getItem(answersKey);
        if (saved) {
            try {
                const answers = JSON.parse(saved);
                for (const soalId in answers) {
                    const val = answers[soalId];
                    const radio = document.querySelector(`input[name="jawaban[${soalId}]"][value="${val}"]`);
                    if (radio) {
                        radio.checked = true;
                    }
                }
            } catch (e) {
                console.error("Error loading answers from cache:", e);
            }
        }
    }

    // Timer Logic using localStorage start time & wall clock calculation
    let totalDurationSeconds = {{ $ujian->durasi }} * 60;
    let startTime = localStorage.getItem(timerKey);
    let elapsedSeconds = 0;

    if (!startTime) {
        startTime = Date.now();
        localStorage.setItem(timerKey, startTime);
    } else {
        startTime = parseInt(startTime, 10);
        elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
    }

    let remainingTime = totalDurationSeconds - elapsedSeconds;
    let display = document.querySelector('#timer');
    let countdown;

    function startTimer(duration, display) {
        let timer = duration;
        let minutes, seconds;
        
        if (timer <= 0) {
            alert('Waktu ujian telah habis!');
            localStorage.removeItem(timerKey);
            localStorage.removeItem(answersKey);
            window.onbeforeunload = null;
            document.getElementById('ujianForm').submit();
            return;
        }

        countdown = setInterval(function () {
            let currentElapsed = Math.floor((Date.now() - startTime) / 1000);
            timer = totalDurationSeconds - currentElapsed;

            if (timer <= 0) {
                clearInterval(countdown);
                display.textContent = "00:00";
                alert('Waktu ujian telah habis!');
                localStorage.removeItem(timerKey);
                localStorage.removeItem(answersKey);
                window.onbeforeunload = null;
                document.getElementById('ujianForm').submit();
                return;
            }

            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;
        }, 1000);
    }

    // Attach click triggers to option cards to make the entire card clickable
    document.querySelectorAll('.form-check-option').forEach(card => {
        card.addEventListener('click', function(e) {
            const radio = this.querySelector('input[type="radio"]');
            if (radio && e.target !== radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    // Attach event listeners to all radios to update status on check and save answers
    document.querySelectorAll('.form-check-input').forEach(radio => {
        radio.addEventListener('change', () => {
            updateNavStatus();
            saveAnswers();
        });
    });

    // Initialize saved state and start exam
    loadSavedAnswers();
    showQuestion(0);
    startTimer(remainingTime, display);

    // Prevent page refresh/back
    window.onbeforeunload = function() {
        return "Apakah Anda yakin ingin meninggalkan halaman ini? Progress Anda mungkin hilang.";
    };
    
    document.getElementById('ujianForm').onsubmit = function() {
        // Clear cached state on successful submit
        localStorage.removeItem(timerKey);
        localStorage.removeItem(answersKey);
        window.onbeforeunload = null;
    };
</script>
@endpush
@endsection
