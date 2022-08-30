<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Model
{
    use HasFactory, softDeletes;

    /**
     * Get the user associated with the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Detail()
    {
        return $this->hasOne(MahasiswaDetail::class, 'mahasiswa_id');
    }

    /**
     * Get the user associated with the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function OrangTua()
    {
        return $this->hasOne(MahasiswaDetailOrangTua::class, 'mahasiswa_id');
    }

    /**
     * Get the user associated with the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Wali()
    {
        return $this->hasOne(MahasiswaDetailWali::class, 'mahasiswa_id');
    }

    /**
     * Get the user associated with the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function KebutuhanKhusus()
    {
        return $this->hasOne(MahasiswaDetailKebutuhanKhusus::class, 'mahasiswa_id');
    }

    /**
     * Get the user associated with the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Riwayatpendidikan()
    {
        return $this->hasOne(MahasiswaHistoryPendidikan::class, 'mahasiswa_id');
    }

    /**
     * Get all of the comments for the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aktivitasKuliahMahaswa()
    {
        return $this->hasMany(AktivitasKuliahMahasiswa::class, 'mahasiswa_id', 'id');
    }

    /**
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * Get all of the comments for the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id', 'id')->with(['Matakuliah']);
    }

    /**
     * Get all of the comments for the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totalKrs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id', 'id')->with(['Matakuliah']);
    }

    public function nilai_perkuliahan()
    {
        return $this->hasMany(NilaiPerkuliahan::class,'mahasiswa_id','id')->with(['master_nilai']);
    }

    public function calculate_nilai()
    {
        return $this->hasMany(CalculateIpsIpk::class,'mahasiswa_id','id');
    }
   
}
