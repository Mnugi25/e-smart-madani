<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rpp extends Model
{
    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'topik',
        'fase',
        'alokasi_waktu',
        'model_pembelajaran',
        'profil_pelajar_pancasila',
        'konten',
        'status',
    ];

    protected $casts = [
        'profil_pelajar_pancasila' => 'array',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
