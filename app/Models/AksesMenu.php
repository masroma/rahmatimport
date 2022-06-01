<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesMenu extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id','role_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
