<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    // Nama tabel singular sesuai database saat ini
    protected $table = 'siswa';

    // Hapus user_id dari fillable karena relasi dibalik
    protected $fillable = [
        'kelas_id',
        'nisn',
        'nama_lengkap',
        'nama_siswa',
        'jk',
        'jenis_kelamin',
        'tanggal_lahir',
        'nama_orang_tua',
        'status',
    ];

    // Relasi ke User sekarang adalah HasOne (Tabel users memegang siswa_id)
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    // Relasi ke Kelas tetap BelongsTo (Siswa berada di dalam satu kelas)
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function pengajuanIzin(): HasMany
    {
        return $this->hasMany(PengajuanIzin::class, 'siswa_id');
    }

    public function pengumpulan(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }
}
