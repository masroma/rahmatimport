<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaLulusDo extends Model
{
    use HasFactory;

    public $fillable = [
        'mahasiswa_id',
        'jeniskeluar_id',
        'tanggal_keluar',
        'jenissemester_id',
        'tanggal_sk',
        'nomor_sk',
        'ipk',
        'no_ijazah',
        'keterangan',
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class,'id','mahasiswa_id')->with('Riwayatpendidikan');
    }

    public function jenis_keluar()
    {
        return $this->hasOne(JenisKeluar::class,'id','jeniskeluar_id');
    }
    public function jenis_semester()
    {
        return $this->hasOne(JenisSemester::class,'id','jenissemester_id')->with('Tahunajaran');
    }
}
