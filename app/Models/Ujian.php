<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ujian extends Model
{
    protected $fillable = [
        'mapel_id',
        'guru_id',
        'kelas_id',
        'judul',
        'semester',
        'waktu_mulai',
        'durasi',
        'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
    ];

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function soal(): HasMany
    {
        return $this->hasMany(Soal::class, 'ujian_id');
    }

    public function nilaiUjian(): HasMany
    {
        return $this->hasMany(NilaiUjian::class, 'ujian_id');
    }
}
