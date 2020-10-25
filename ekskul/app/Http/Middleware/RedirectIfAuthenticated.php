<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
      
        
        if (Auth::guard($guard)->check()) {
            if( Auth::user()->level == 'Pengurus')
            {
                return redirect('/dashboard_admin');
            }
            else if( Auth::user()->level == 'Instruktur')
            {
                return redirect('/dashboard_instruktur');
            }
            else
            {
                return redirect('/dashboard_siswa');
            }
        }

        return $next($request);
    }
}
