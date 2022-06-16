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
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id', 'id');
    }


    public function Jenissemester()
    {
        return $this->belongsTo(JenisSemester::class, 'masa_berlaku', 'id');
    }
}
