<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function username()
    {
        return 'username';
    }
  

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(session('success_message'))
            {
                Alert::success('Berhasil!',session('success_message'));
            }
            elseif(session('error_message'))
            {
                Alert::error('Gagal!',session('error_message'));
            }
            elseif(session('warning_message'))
            {
                Alert::warning('Eitss!',session('warning_message'));
            }
            return $next($request);
        });
    }

    public function authenticated()
    {
        if(Auth::user()->level == 'Pengurus')
        {
            return redirect('/dashboard_admin');
        }
        else if (Auth::user()->level == 'Instruktur')
        {
            return redirect('/dashboard_instruktur');
        }
        else if (Auth::user()->level == 'Piket')
        {
            return redirect('/dashboard_piket');
        }
        else
        {
            return redirect('/dashboard_siswa');
        }
    }
    
    
    // public function login(Request $request)
    // {
    //     $this->validate($request, [
    //         'username'    => 'required',
    //         'password' => 'required',
    //     ]);

    //     $login_type = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL ) 
    //         ? 'email' 
    //         : 'nis';

    //     $request->merge([
    //         $login_type => $request->input('username')
    //     ]);

    //     if (Auth::attempt($request->only($login_type, 'password'))) {
    //         return redirect()->intended($this->redirectPath());
    //     }

    //     $user = User::where('username', $request->username)->where('password', $request->password)->first();
    //     if ($user) {
    //         Auth::loginUsingId($user->id);
    //         return redirect()->intended($this->redirectPath());
    //     }

    //     return redirect()->back()
    //         ->withInput()
    //         ->withErrors([
    //             'username' => 'These credentials do not match our records.',
    //         ]);
    // } 

    public function logout(Request $request)
{
    $this->performLogout($request);
    return redirect('/login');
}

}
