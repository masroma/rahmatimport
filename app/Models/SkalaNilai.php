<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkalaNilai extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'programstudy_id','nilai_huruf','nilai_index','bobot_min','bobot_max','tanggal_mulai','tanggal_akhir'
    ];
    public function jurusan()
    {
        return $this->hasOne(Jurusan::class, 'id', 'programstudy_id');
    }
}
