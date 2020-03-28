<?php

namespace App\Http\Middleware;

use Closure;
use Alert;
use Auth;

class Cek_Status
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //If the status is not approved redirect to login 
        if(Auth::check() && Auth::user()->status != 'aktif'){
            Auth::logout();
            return redirect('/login')->withWarningMessage('Akun Anda dibekukan oleh Admin, hubungin Admin');
        }
        return $response;
    }
}
