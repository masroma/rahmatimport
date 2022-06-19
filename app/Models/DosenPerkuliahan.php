<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenPerkuliahan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the user that owns the DosenPerkuliahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Substansi()
    {
        return $this->belongsTo(SubstansiKuliah::class, 'substansi_id','id');
    }

    public function Dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
