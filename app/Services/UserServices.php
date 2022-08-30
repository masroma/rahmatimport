<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getUser()
    {
        $user = User::where('id',Auth::user()->id)->first();
        return $user;
    }
}
