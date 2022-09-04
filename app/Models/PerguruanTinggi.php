<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerguruanTinggi extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable = [
        "nama","kode","alamat","province_id","city_id","district_id","village_id","kode_pos",
    ];
}
