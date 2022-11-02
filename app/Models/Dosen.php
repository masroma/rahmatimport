<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'nidn','nama_dosen','tempat_lahir','jenis_kelamin','tanggal_lahir','agama'
    ];

    public function Address()
    {
        return $this->hasOne(DosenAddress::class, 'dosen_id', 'id');
    }


    public function Detail()
    {
        return $this->hasOne(DosenDetail::class, 'dosen_id', 'id');
    }


    public function Keluarga()
    {
        return $this->hasOne(DosenKeluarga::class, 'dosen_id', 'id');
    }


    public function KebutuhanKhusus()
    {
        return $this->hasOne(DosenKebutuhanKhusus::class, 'dosen_id', 'id');
    }


    public function dosen_perkuliahan()
    {
        return $this->hasMany(DosenPerkuliahan::class, 'dosen_id');
    }



    // public function dosen_penugasan()
    // {
    //     return $this->hasMany(DosenPenugasan::class, 'id');
    // }
}
