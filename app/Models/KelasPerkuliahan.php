<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasPerkuliahan extends Model
{
    use HasFactory, softDeletes;

    public function Programstudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }

    public function Matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    public function Jenissemester()
    {
        return $this->belongsTo(JenisSemester::class, 'semester_id', 'id');
    }

    public function Krs()
    {
        return $this->hasMany(Krs::class, 'kelas_id');
    }

    /**
     * Get the user associated with the KelasPerkuliahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Jadwal()
    {
        return $this->hasOne(RuangPerkuliahan::class, 'kelasperkuliahan_id', 'id')->where('penggunaanruang_id',1);
    }

}
