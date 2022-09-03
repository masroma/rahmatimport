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
<<<<<<< HEAD

    /**
     * Get the user associated with the KelasPerkuliahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Jadwal()
    {
        return $this->hasOne(RuangPerkuliahan::class, 'kelasperkuliahan_id', 'id')->where('penggunaanruang_id',1);
    }

=======
    public function nilai_perkuliahan()
    {
        return $this->hasMany(NilaiPerkuliahan::class,'kelas_id','id');
    }
>>>>>>> 79ee5b9d44eddd42d2146ecd6eb392695fd9a411
}
