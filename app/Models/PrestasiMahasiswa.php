<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiMahasiswa extends Model
{
    use HasFactory;

    /**
     * Get the Mahasiswa that owns the PrestasiMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    /**
     * Get the AktivitasMahasiswa that owns the PrestasiMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function AktivitasMahasiswa()
    {
        return $this->belongsTo(AktivitasMahasiswa::class, 'aktivitasmahasiswa_id', 'id');
    }

    /**
     * Get the JenisPrestasi that owns the PrestasiMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function JenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class, 'jenisprestasi_id', 'id');
    }

    /**
     * Get the user that owns the PrestasiMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TingkatPrestasi()
    {
        return $this->belongsTo(TingkatPrestasi::class, 'tingkatprestasi_id', 'id');
    }
}
