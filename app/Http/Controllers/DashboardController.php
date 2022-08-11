<?php

namespace App\Http\Controllers;

use App\Models\AksesMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function __construct()
    {

    }
    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $role = $user->getRoleNames()[0];
       
        if($role == 'superdewa'){
            return view('dashboard.index');
        }else{
            return view('mahasiswa::dashboard.index');
        }
       
    }
}
