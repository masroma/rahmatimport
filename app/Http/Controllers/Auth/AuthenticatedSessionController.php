<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

     //tambahkan script google di bawah ini
     public function redirectToProvider()
     {
         return Socialite::driver('google')->redirect();
     }


     //tambahkan script di bawah ini
     public function handleProviderCallback(\Request $request)
     {
         try {
             $user_google    = Socialite::driver('google')->user();
             $user           = User::where('email', $user_google->getEmail())->first();

             //jika user ada maka langsung di redirect ke halaman home
             //jika user tidak ada maka simpan ke database
             //$user_google menyimpan data google account seperti email, foto, dsb

             if($user != null){
                User::findOrFail($user->id)->update([
                    'google_id' => $user_google->id,
                    'photo' => $user_google->avatar
                ]);
                 \auth()->login($user, true);
                 return redirect()->route('home');
             }else{
                return redirect()->route('login')->with(['error' => 'Gagal Masuk, karena akun belum terdaftar, hubungi itsupport@paramadina.ac.id']);
             }

         } catch (\Exception $e) {
             return redirect()->route('login');
         }


     }
}
