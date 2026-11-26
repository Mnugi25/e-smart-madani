<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['jurusan_id', 'tingkat', 'nama_kelas', 'wali_kelas_id'];

    // Relasi ke Guru sebagai Wali Kelas
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    // Kelas terikat ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    // Satu kelas memiliki banyak siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    // Satu kelas memiliki banyak jadwal pelajaran
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id');
    }
}
