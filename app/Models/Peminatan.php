<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminatan extends Model
{
    use HasFactory, softDeletes;
    protected $table= "peminatans";
    protected $fillable = [
     'id','nama_peminatan'
   ];
}
