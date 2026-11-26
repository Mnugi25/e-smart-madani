<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianSaw extends Model
{
    protected $table = 'penilaian_saw';
    protected $fillable = ['pengajuan_izin_id', 'kriteria_saw_id', 'nilai_matriks'];

    public function pengajuanIzin()
    {
        return $this->belongsTo(PengajuanIzin::class, 'pengajuan_izin_id');
    }

    public function kriteriaSaw()
    {
        return $this->belongsTo(KriteriaSaw::class, 'kriteria_saw_id');
    }
}
