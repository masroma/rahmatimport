<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTransfer extends Model
{
    use HasFactory;
    public $fillable = [
        'mahasiswa_id','kode_perguruantinggi_asal','perguruantinggi_asal','kode_mk_asal','matakuliah_asal','sks_asal','nilai_huruf_asal','matakuliah_diakui','nilai_index_diakui','nilai_huruf_diakui'
    ];

    public function mata_kuliah()
    {
        return $this->hasOne(MataKuliah::class,'id','matakuliah_diakui');
    }
}
