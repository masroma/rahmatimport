<?php

namespace App\Http\Controllers;

use App\Models\AksesMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function __construct()
    {

    }
    public function index()
    {
        return view('dashboard.index');
    }
}
