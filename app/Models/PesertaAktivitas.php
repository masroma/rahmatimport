<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaAktivitas extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the PesertaAktivitas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
    public function aktivitas_mahasiswa()
    {
        return $this->hasOne(AktivitasMahasiswa::class,'id','aktivitasmahasiswa_id');
    }
}
