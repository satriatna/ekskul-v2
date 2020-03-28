<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Instruktur
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
        $user = $request->user();

        if ($user->level != 'Instruktur') {
            return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');
        }
    
        return $next($request);
    }
}
