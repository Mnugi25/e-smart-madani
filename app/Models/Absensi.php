<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = ['siswa_id', 'jadwal_id', 'tanggal', 'status', 'keterangan', 'foto'];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    // WAJIB ADA: Relasi ke Siswa agar DashboardController tidak error
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->hasOneThrough(Guru::class, Jadwal::class, 'id', 'id', 'jadwal_id', 'guru_id');
    }

    public function kelas()
    {
        return $this->hasOneThrough(Kelas::class, Jadwal::class, 'id', 'id', 'jadwal_id', 'kelas_id');
    }
}
