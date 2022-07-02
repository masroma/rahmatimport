<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktivitasMahasiswa extends Model
{
    use HasFactory,SoftDeletes;

    public function ProgramStudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }

    public function Semester()
    {
        return $this->belongsTo(JenisSemester::class, 'semester_id');
    }

    public function JenisAktivitas()
    {
        return $this->belongsTo(JenisAktivitas::class, 'jenisaktivitas_id');
    }
}
