<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    protected $table = 'pengajuan_izin';
    protected $fillable = ['siswa_id', 'tanggal_mulai', 'tanggal_selesai', 'jenis', 'alasan', 'file_bukti', 'status', 'skor_saw', 'mapel_id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Satu data izin akan dipecah nilainya ke matriks kriteria SAW
    public function penilaianSaw()
    {
        return $this->hasMany(PenilaianSaw::class, 'pengajuan_izin_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}
