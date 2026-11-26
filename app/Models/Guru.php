<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    // Nama tabel singular sesuai database saat ini
    protected $table = 'guru';

    // Sesuaikan fillable (user_id dihapus karena relasi dibalik)
    protected $fillable = [
        'kode_guru',
        'nama_lengkap',
        'jk',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'jabatan'
    ];

    // Relasi ke User sekarang adalah HasOne (Karena tabel users yang menyimpan guru_id)
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'guru_id');
    }

    // Relasi ke Kelas sebagai Wali Kelas
    public function kelasWali(): HasOne
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    // Relasi ke Jadwal tetap menggunakan hasMany
    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'kode_guru', 'kode_guru');
    }

    /**
     * Mutator to automatically uppercase the jabatan field.
     */
    public function setJabatanAttribute($value)
    {
        $this->attributes['jabatan'] = $value ? strtoupper($value) : null;
    }
}
