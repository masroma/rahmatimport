<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataKuliah extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'kode_matakuliah','nama_matakuliah','programstudy_id','jenis_mata_kuliah','bobot_mata_kuliah','bobot_tatap_muka','bobot_pratikum','bobot_praktek_lapanagn','bobot_simulasi','min_nilai_kelulusan','metode_pembelajaran','tanggal_mulai_efektif','tanggal_akhir_efektif'

    ];



    public function Programstudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'programstudy_id');
    }

    public function Jenismatakuliah()
    {
        return $this->belongsTo(JenisMataKuliah::class, 'jenis_mata_kuliah');
    }

    public function KurikulumMatakuliah()
    {
        return $this->hasMany(KurikulumMatakuliah::class, 'matakuliah_id');
    }

    public function matakuliahs()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the comments for the MataKuliah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas()
    {
        return $this->hasMany(KelasPerkuliahan::class, 'matakuliah_id');
    }


}
