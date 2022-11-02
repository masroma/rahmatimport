<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktivitasMahasiswa extends Model
{
    use HasFactory,SoftDeletes;
    // protected $table = 'aktivitas';

    protected $fillable = [
        'programstudy_id','semester_id','no_sk_tugas','tanggal_sk_tugas','jenisaktivitas_id',
        'jenis_anggota','judul','keterangan','lokasi','	created_at','updated_at','deleted_at','berkas','total_hari'
    ];

    public function tahun_ajarans()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id','id');
    }

    public function semester()
    {
        return $this->belongsTo(JenisSemester::class, 'semester_id');
    }

    public function JenisAktivitas()
    {
        return $this->belongsTo(JenisAktivitas::class, 'jenisaktivitas_id');
    }
    
    public function ProgramStudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }
 
}
