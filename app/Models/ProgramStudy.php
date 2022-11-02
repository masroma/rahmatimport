<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudy extends Model
{
    use HasFactory,  SoftDeletes;

    /**
     * Get the user that owns the ProgramStudy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenjang()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_id', 'id');
    }

    // public function jenjang()
    // {
    //     return $this->belongsTo(JenjangPendidikan::class, 'jenjang_id','id');
    // }

    public function jenjangs()
    {
        return $this->hasMany(JenjangPendidikan::class,'id','jenjang_id');

        }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'nama_program_study', 'id');
    }

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class,'id','nama_program_study');

        }

}
