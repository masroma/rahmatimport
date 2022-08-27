<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnlockKrs extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the UnlockKrs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function jenissemester()
    {
        return $this->belongsTo(JenisSemester::class, 'jenissemester_id', 'id');
    }
}
