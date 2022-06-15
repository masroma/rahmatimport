<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class SubstansiKuliah extends Model
{
    use HasFactory, SoftDeletes;


    public function ProgramStudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }
}
