<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktivitasKuliahMahasiswa extends Model
{
    use HasFactory,SoftDeletes;

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function Semester()
    {
        return $this->belongsTo(JenisSemester::class, 'semester_id');
    }

    public function Status()
    {
        return $this->belongsTo(StatusMahasiswa::class, 'status_id');
    }
    
}
