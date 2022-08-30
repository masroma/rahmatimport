<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPerkuliahan extends Model
{
    use HasFactory;
    protected $table = "nilai_perkuliahans";
    protected $fillable = ['kelas_id','mahasiswa_id','nilai_angka','nilai_huruf'];

    public function master_nilai()
    {
        return $this->hasOne(MasterNilai::class,'nilai_huruf','nilai_huruf');
    }
    public function kelas()
    {
        return $this->hasOne(KelasPerkuliahan::class,'id','kelas_id');
    }
}


