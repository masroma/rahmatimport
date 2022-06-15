<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSemester extends Model
{
    use HasFactory, softDeletes;

    /**
     * Get the user that owns the JenisSemester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id', 'id');
    }


}
