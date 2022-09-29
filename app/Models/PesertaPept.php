<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPept extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the PesertaPept
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    /**
     * Get the user that owns the PesertaPept
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function JadwalKelas()
    {
        return $this->belongsTo(JadwalKelas::class, 'jadwalkelas_id');
    }
}
