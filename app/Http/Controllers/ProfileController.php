<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $mahasiswa = Mahasiswa::with('detail','detail.provinsi','detail.kota','detail.kecamatan','detail.kelurahan')->findOrFail($user->relation_id);
        
        return view('profile.index', compact('user','mahasiswa'));
    }
}
