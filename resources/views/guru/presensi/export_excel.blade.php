<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-left {
            text-align: left;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="title">
        REKAP PRESENSI SISWA<br>
        Kelas: {{ $jadwalAktif->kelas->nama_kelas }}<br>
        Mata Pelajaran: {{ $jadwalAktif->mataPelajaran->nama_mapel }}<br>
        Periode: {{ Carbon\Carbon::create(null, (int)$bulan)->translatedFormat('F') }} {{ $tahun }}
    </div>

    <table class="table">
        <thead>
            <tr class="header">
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Hadir</th>
                @if($showTerlambat)
                    <th>Terlambat</th>
                @endif
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($semuaSiswa as $index => $siswa)
                @php
                    $items = $dataAbsensi->where('siswa_id', $siswa->id);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $siswa->nama_lengkap }}</td>
                    <td>{{ $siswa->nisn ?? '-' }}</td>
                    <td>{{ $items->where('status', 'hadir')->count() }}</td>
                    @if($showTerlambat)
                        <td>{{ $items->where('status', 'terlambat')->count() }}</td>
                    @endif
                    <td>{{ $items->where('status', 'izin')->count() }}</td>
                    <td>{{ $items->where('status', 'sakit')->count() }}</td>
                    <td>{{ $items->where('status', 'alpa')->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
