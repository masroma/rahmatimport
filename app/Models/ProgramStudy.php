<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudy extends Model
{
    use HasFactory,  SoftDeletes;

    /**
     * Get the user that owns the ProgramStudy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenjang()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_id', 'id');
    }
}
