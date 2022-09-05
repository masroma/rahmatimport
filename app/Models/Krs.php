<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the KRS
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function JenisSemester()
    {
        return $this->belongsTo(JenisSemester::class, 'jenissemester_id', 'id');
    }

    /**
     * Get the user that owns the KRS
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matakuliah_id', 'id');
    }

    /**
     * Get the user that owns the KRS
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Kelas()
    {
        return $this->belongsTo(KelasPerkuliahan::class, 'kelas_id', 'id');
    }


    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Get the user associated with the KRS
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Nilai()
    {
        return $this->hasOne(NilaiPerkuliahan::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    public function NilaiKrs()
    {
        return $this->belongsTo(NilaiPerkuliahan::class,'kelas_id','kelas_id');
    }

    /**
     * Get the user that owns the Krs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function NilaiIps()
    {
        return $this->belongsTo(CalculateIpsIpk::class, 'jenissemester_id', 'semester_id');
    }


}
