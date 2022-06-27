<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangGedung extends Model
{
    use HasFactory, softDeletes;

    public function ListKampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }

    /**
     * Get all of the comments for the RuangGedung
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Kelas()
    {
        return $this->hasMany(RuangPerkuliahan::class, 'ruang_id');
    }

    public function Perkuliahan()
    {
        return $this->hasMany(RuangPerkuliahan::class, 'ruang_id')->where('penggunaanruang_id',1);
    }

    public function Uas()
    {
        return $this->hasMany(RuangPerkuliahan::class, 'ruang_id')->where('penggunaanruang_id',3);
    }

    public function Uts()
    {
        return $this->hasMany(RuangPerkuliahan::class, 'ruang_id')->where('penggunaanruang_id',2);
    }







}
