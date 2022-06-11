<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use HasFactory, softDeletes;


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
}
