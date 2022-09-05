<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculateIpsIpk extends Model
{
    use HasFactory;
    protected $table ='calculate_ips_ipk';
    public $fillable = [
        'mahasiswa_id','semester_id','ips','ipk','sks_semester','total_sks','programstudy_id'
    ];
}
