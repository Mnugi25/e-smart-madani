<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaSaw extends Model
{
    protected $table = 'kriteria_saw';
    protected $fillable = ['kode', 'nama_kriteria', 'tipe', 'bobot'];

    // Satu kriteria memiliki banyak pilihan sub-kriteria skor
    public function subKriteria()
    {
        return $this->hasMany(SubKriteriaSaw::class, 'kriteria_saw_id');
    }

    public function penilaianSaw()
    {
        return $this->hasMany(PenilaianSaw::class, 'kriteria_saw_id');
    }
}
