<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutLockTime extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the CutLockTime
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Semester()
    {
        return $this->belongsTo(JenisSemester::class, 'tahunajaran_id', 'id');
    }
}
