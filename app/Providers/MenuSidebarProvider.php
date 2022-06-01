<?php

namespace App\Providers;

use App\Models\AksesMenu;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\ServiceProvider;

class MenuSidebarProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $user = Auth::user();
        $userRole = $user->roles->pluck('id');
        $menu = AksesMenu::with('menu')->where('role_id', $userRole)->get();

        \View::share('menu',[$menu]);
    }
}
