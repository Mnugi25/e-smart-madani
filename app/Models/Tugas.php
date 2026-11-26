<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $fillable = [
        'jadwal_id',
        'judul',
        'deskripsi',
        'waktu_mulai',
        'deadline',
        'file_path',
        'file_name',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'deadline' => 'datetime',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
