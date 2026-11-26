<div style="font-family: Arial, sans-serif; padding: 40px; line-height: 1.6;">
    <h2 style="text-align: center; text-transform: uppercase;">Surat Pemanggilan Orang Tua</h2>
    <hr style="border: 1px solid #000;">
    
    <p>Kepada Yth,<br>
    Orang Tua / Wali Murid dari:</p>
    
    <table style="width: 100%; margin-left: 20px;">
        <tr><td style="width: 150px;">Nama Siswa</td><td>: <b>{{ $siswa->nama_lengkap }}</b></td></tr>
        <tr><td>Kelas</td><td>: {{ $siswa->kelas->nama_kelas }}</td></tr>
    </table>
    
    <p>Dengan hormat,</p>
    
    <p>Melalui surat ini, kami memberitahukan bahwa siswa tersebut di atas telah melakukan ketidakhadiran tanpa keterangan (Alpa) sebanyak <b>{{ $totalAlpa }} kali</b> pada semester ini.</p>
    
    <p>Sehubungan dengan hal tersebut, kami mengharapkan kehadiran Bapak/Ibu untuk melakukan konsultasi terkait kedisiplinan putra/putri Bapak/Ibu pada:</p>
    
    <table style="width: 100%; margin-left: 20px;">
        <tr><td style="width: 150px;">Hari / Tanggal</td><td>: ...........................................</td></tr>
        <tr><td>Waktu</td><td>: ...........................................</td></tr>
        <tr><td>Tempat</td><td>: Ruang Guru / Wali Kelas</td></tr>
    </table>
    
    <p>Demikian surat pemanggilan ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.</p>
    
    <br><br><br>
    
    <div style="float: right; width: 250px; text-align: center;">
        <p>{{ $tanggal }}</p>
        <p>Wali Kelas,</p>
        <br><br><br>
        <p><b>( ........................................... )</b></p>
    </div>
</div>
