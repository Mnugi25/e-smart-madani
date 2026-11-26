<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
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
                <th>Mata Pelajaran</th>
                <th>Jam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->siswa->nisn ?? '-' }}</td>
                    <td>{{ $row->siswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $row->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $row->jadwal->mataPelajaran->nama_mapel ?? 'Presensi Mandiri' }}</td>
                    <td>{{ date('H:i', strtotime($row->created_at)) }}</td>
                    <td>{{ strtoupper($row->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
