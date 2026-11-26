<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Soal Ujian - {{ $ujian->judul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: #666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-table td.label {
            width: 15%;
            font-weight: bold;
        }
        .info-table td.separator {
            width: 2%;
        }
        .info-table td.value {
            width: 33%;
        }
        .soal-container {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }
        .soal-text {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .opsi-list {
            margin-left: 15px;
        }
        .opsi-item {
            margin-bottom: 5px;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .correct {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: bold;
            border: 1px solid #badbcc;
        }
        .wrong {
            color: #333;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>BUKTI UJIAN</h2>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="separator">:</td>
            <td class="value">{{ $siswa->nama_lengkap }}</td>
            <td class="label">Mata Pelajaran</td>
            <td class="separator">:</td>
            <td class="value">{{ $ujian->mataPelajaran->nama_mapel }}</td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td class="separator">:</td>
            <td class="value">{{ $siswa->nisn }}</td>
            <td class="label">Ulangan</td>
            <td class="separator">:</td>
            <td class="value">{{ $ujian->judul }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="separator">:</td>
            <td class="value">{{ $siswa->kelas->nama_kelas }}</td>
            <td class="label">Guru Pengampu</td>
            <td class="separator">:</td>
            <td class="value">{{ $ujian->guru->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah Soal</td>
            <td class="separator">:</td>
            <td class="value">{{ $ujian->soal->count() }} butir</td>
            <td class="label">Jawaban Benar</td>
            <td class="separator">:</td>
            <td class="value">{{ $nilaiUjian->total_benar }} soal</td>
        </tr>
        <tr>
            <td class="label">Nilai Akhir</td>
            <td class="separator">:</td>
            <td class="value"><strong>{{ round($nilaiUjian->nilai, 1) }} / 100</strong></td>
            <td class="label">Jawaban Salah</td>
            <td class="separator">:</td>
            <td class="value">{{ $nilaiUjian->total_salah }} soal</td>
        </tr>
    </table>



    <hr style="border: 0.5px solid #ccc; margin-bottom: 20px;">

    @foreach($ujian->soal as $index => $s)
        <div class="soal-container">
            <div class="soal-text">
                {{ $index + 1 }}. {!! $s->pertanyaan !!}
            </div>
            <div class="opsi-list">
                <!-- Opsi A -->
                <div class="opsi-item">
                    A. {{ $s->opsi_a }} 
                </div>
                <!-- Opsi B -->
                <div class="opsi-item">
                    B. {{ $s->opsi_b }}
                </div>
                <!-- Opsi C -->
                <div class="opsi-item">
                    C. {{ $s->opsi_c }}
                </div>
                <!-- Opsi D -->
                <div class="opsi-item">
                    D. {{ $s->opsi_d }}
                </div>
                <!-- Opsi E -->
                @if(!empty($s->opsi_e))
                <div class="opsi-item">
                    E. {{ $s->opsi_e }}
                </div>
                @endif
            </div>
        </div>

    @endforeach

    <div class="footer">
        Dicetak secara otomatis melalui aplikasi E-Learning &bull; Halaman 1 dari 1
    </div>

</body>
</html>
