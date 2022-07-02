<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPerkuliahan extends Model
{
    use HasFactory;
    protected $table = "nilai_perkuliahans";
    protected $fillable = ['kelas_id','mahasiswa_id','nilai_angka','nilai_huruf'];
}


