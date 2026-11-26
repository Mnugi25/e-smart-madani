<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Presensi PDF</title>
    <style>
        @page { size: A4 portrait; margin: 1cm; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .info { margin-bottom: 15px; }
        .info table { border: none; width: auto; }
        .info td { border: none; padding: 2px 10px 2px 0; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekapitulasi Presensi Siswa</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>Mata Pelajaran</td>
                <td>: {{ $jadwalAktif->mataPelajaran->nama_mapel }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $jadwalAktif->kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>: {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Siswa</th>
                <th style="width: 50px;">Hadir</th>
                @if($showTerlambat)
                    <th style="width: 50px;">Terlambat</th>
                @endif
                <th style="width: 50px;">Izin</th>
                <th style="width: 50px;">Sakit</th>
                <th style="width: 50px;">Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapSiswa as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row['nama'] }}</td>
                    <td class="text-center">{{ $row['c1'] }}</td>
                    @if($showTerlambat)
                        <td class="text-center">{{ $row['terlambat'] }}</td>
                    @endif
                    <td class="text-center">{{ $row['c2'] }}</td>
                    <td class="text-center">{{ $row['c3'] }}</td>
                    <td class="text-center">{{ $row['c4'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i') }}
    </div>
</body>
</html>