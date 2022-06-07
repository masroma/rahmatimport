<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    use HasFactory;
    protected $table = "kampus";

    /**
     * Get the  that owns the Kampus
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Address()
    {
        return $this->hasOne(kampus_address::class, 'kampus_id','id');
    }

    public function Detail()
    {
        return $this->hasOne(kampus_detail::class, 'kampus_id','id');
    }

    public function Akta()
    {
        return $this->hasOne(kampus_akta_pendirian::class, 'kampus_id','id');
    }


}
