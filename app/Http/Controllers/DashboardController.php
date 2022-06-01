<?php

namespace App\Http\Controllers;

use App\Models\AksesMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:dashboard-list|dashboard-create|dashboard-edit|dashboard-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:dashboard-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:dashboard-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:dashboard-delete', ['only' => ['destroy']]);



    }
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->roles->pluck('id');
        $menu = AksesMenu::with('menu')->where('role_id', $userRole)->get();
        return view('dashboard.index', compact('menu'));
    }
}
