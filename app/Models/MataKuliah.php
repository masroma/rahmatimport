<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataKuliah extends Model
{
    use HasFactory, SoftDeletes;

    public function Programstudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }

    public function Jenismatakuliah()
    {
        return $this->belongsTo(JenisMataKuliah::class, 'jenis_mata_kuliah');
    }

    public function KurikulumMatakuliah()
    {
        return $this->hasMany(KurikulumMatakuliah::class, 'matakuliah_id');
    }
}
