<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanPeriodePerkuliahan extends Model
{
    use HasFactory;
    public $fillable = [
        'programstudy_id','semester_id','target_mahasiswa_baru','pendaftar_ikut_seleksi','pendaftar_lulus_seleksi','pendaftar_daftar_ulang','pendaftar_mengundurkan_diri','jumlah_pertemuan','awal_perkuliahan','akhir_perkuliahan'
    ];
    public function jurusan()
    {
        return $this->hasOne(Jurusan::class, 'id', 'programstudy_id');
    }
    public function semester()
    {
        return $this->hasOne(JenisSemester::class, 'id', 'semester_id');
    }
}
