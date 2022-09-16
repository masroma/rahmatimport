<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeptBatch extends Model
{
    use HasFactory;

      /**
     * Get the user that owns the PeptGrade
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Grade()
    {
        return $this->belongsTo(PeptGrade::class, 'grade_pept', 'id');
    }

    public function GradeTa()
    {
        return $this->belongsTo(PeptGrade::class, 'grade_sidang', 'id');
    }

    /**
     * Get the user that owns the PeptBatch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Jenissemester()
    {
        return $this->belongsTo(JenisSemester::class, 'jenissemester_id', 'id');
    }
}
