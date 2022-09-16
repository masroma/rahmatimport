<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    /**
     * Get the Kelas that owns the JadwalKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruangperkuliahan()
    {
        return $this->belongsTo(RuangPerkuliahan::class, 'ruangperkuliahan_id', 'id');
    }
}
