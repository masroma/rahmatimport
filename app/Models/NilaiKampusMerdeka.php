<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiKampusMerdeka extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable =[
        'aktivitas_id','matakuliah_id','mahasiswa_id','nilai_angka','nilai_huruf','index'
    ];

    public function aktivitas_mahasiswa()
    {
        return $this->hasOne(AktivitasMahasiswa::class,'id','aktivitas_id');
    }
    public function matakuliah()
    {
        return $this->hasOne(MataKuliah::class,'id','matakuliah_id');
    }
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class,'id','mahasiswa_id');
    }
}
