<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangPerkuliahan extends Model
{
    use HasFactory, SoftDeletes;


    public function kelasPerkuliahan()
    {
        return $this->belongsTo(KelasPerkuliahan::class, 'kelasperkuliahan_id', 'id');
    }

    /**
     * Get the user that owns the RuangPerkuliahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function PenggunaanRuang()
    {
        return $this->belongsTo(PenggunaanRuangan::class, 'penggunaanruang_id', 'id');
    }

    public function PenggunaanRuangs()
    {
        return $this->belongsTo(PenggunaanRuangan::class, 'penggunaanruang_id', 'id');
    }

    /**
     * Get the user that owns the RuangPerkuliahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Ruang()
    {
        return $this->belongsTo(RuangGedung::class, 'ruang_id', 'id');
    }


}
