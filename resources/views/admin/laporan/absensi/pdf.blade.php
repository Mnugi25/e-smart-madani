<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi PDF</title>
    <style>
        @page { size: A4 portrait; margin: 1cm; }
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Riwayat Absensi Siswa</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Jam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->siswa->nisn ?? '-' }}</td>
                    <td>{{ $row->siswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $row->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $row->jadwal->mataPelajaran->nama_mapel ?? 'Mandiri' }}</td>
                    <td class="text-center">{{ date('H:i', strtotime($row->created_at)) }}</td>
                    <td class="text-center">{{ strtoupper($row->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>