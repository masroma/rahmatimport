<?php

namespace App\Providers;

use App\Models\AksesMenu;
use Auth;

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
        view()->composer('*', function($view) {
            $user = Auth::user();
            if($user != null){
                $userRole = $user->roles->pluck('id');
                // $menua = AksesMenu::with('menu')->where('role_id', $userRole)->get();
                $menua = AksesMenu::with('menu')->get();
                \View::share('menudata',[$menua]);
            }

        });

    }
}
