<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
