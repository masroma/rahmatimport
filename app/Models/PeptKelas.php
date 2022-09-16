<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeptKelas extends Model
{
    use HasFactory;

    public function Jenissemester()
    {
        return $this->belongsTo(JenisSemester::class, 'jenissemester_id', 'id');
    }
}
