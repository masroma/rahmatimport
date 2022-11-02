<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kurikulum extends Model
{
    use HasFactory, softDeletes;


    public function Programstudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }
    // public function Programstudy()
    // {
    //     return $this->belongsTo(ProgramStudy::class, 'programstudy_id', 'id');
    // }


    public function Jenissemester()
    {
        return $this->belongsTo(JenisSemester::class, 'masa_berlaku', 'id');
    }

    /**
     * Get all of the comments for the Kurikulum
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matakuliah()
    {
        return $this->hasMany(KurikulumMatakuliah::class, 'kurikulum_id');
    }

    public function matakuliahsemester()
    {
        return $this->hasMany(KurikulumMatakuliah::class, 'kurikulum_id');
    }

}
