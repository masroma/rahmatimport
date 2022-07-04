<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPengujiAktivitasMahasiswa extends Model
{
    use HasFactory;

    public function Dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    /**
     * Get the user that owns the DosenPembimbingAktivitasMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Kategorikegiatan()
    {
        return $this->belongsTo(KategoriKegiatan::class, 'kategorikegiatan_id');
    }
}
