<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenPenugasan extends Model
{
    use HasFactory, softDeletes;

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
