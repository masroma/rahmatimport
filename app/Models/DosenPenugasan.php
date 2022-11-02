<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenPenugasan extends Model
{
    use HasFactory, softDeletes;
    protected $table = "dosen_penugasans";
    protected $fillable = [
        'id','dosen_id','kampus_id','jurusan_id','tahunajaran_id','no_surat_tugas','tanggal_surat_tugas','TMT_surat_tugas'
    ];

    /**
     * Get the user that owns the DosenPenugasan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Kampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }

    /**
     * Get the user that owns the DosenPenugasan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    // public function Jurusan()
    // {
    //     return $this->hasMany(Jurusan::class, 'id','jurusan_id');
    // }



    /**
     * Get the user that owns the DosenPenugasan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    /**
     * Get the user that owns the DosenPenugasan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id', 'id');
    }
}
