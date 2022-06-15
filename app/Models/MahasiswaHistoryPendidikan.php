<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaHistoryPendidikan extends Model
{
    use HasFactory, softDeletes;

    /**
     * Get the user that owns the MahasiswaHistoryPendidikan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Jenispendaftaran()
    {
        return $this->belongsTo(JenisPendaftaran::class, 'jenis_pendaftaran', 'id');
    }


    public function Jalurpendaftaran()
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_pendaftaran', 'id');
    }


    public function Jenissemester()
    {
        return $this->belongsTo(Jenissemester::class, 'periode_pendaftaran', 'id');
    }


    public function Pembiayaanawal()
    {
        return $this->belongsTo(PembiayaanAwal::class, 'pembiayaan_awal', 'id');
    }


    public function Kampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }


    public function Programstudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id', 'id');
    }
}
