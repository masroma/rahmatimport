<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenAddress extends Model
{
    use HasFactory, SoftDeletes;

    public function Provinsi()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function Kota()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function Kecamatan()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function Kelurahan()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

}
