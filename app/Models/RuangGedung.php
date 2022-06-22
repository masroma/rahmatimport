<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangGedung extends Model
{
    use HasFactory, softDeletes;

    public function ListKampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }
}
