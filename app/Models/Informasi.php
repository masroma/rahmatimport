<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    public function Kategori()
    {
        return $this->belongsTo(KategoriInformasi::class, 'kategoriinformasi_id', 'id');
    }
}
