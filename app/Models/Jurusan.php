<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $fillable = ['kode_jurusan', 'nama_jurusan'];

    // Satu jurusan memiliki banyak kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }
}
