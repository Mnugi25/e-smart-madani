<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSaw extends Model
{
    protected $table = 'hasil_saw';
    protected $fillable = ['siswa_id', 'skor_prestasi', 'skor_risiko'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
