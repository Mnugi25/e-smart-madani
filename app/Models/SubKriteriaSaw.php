<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKriteriaSaw extends Model
{
    protected $table = 'sub_kriteria_saw';
    protected $fillable = ['kriteria_saw_id', 'keterangan', 'nilai'];

    public function kriteriaSaw()
    {
        return $this->belongsTo(KriteriaSaw::class, 'kriteria_saw_id');
    }
}
