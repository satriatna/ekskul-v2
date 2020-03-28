<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
class HanyaSiswa
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
        $ambil_siswa = DB::table("users")->where('level',Auth::user()->level)->first();
        $user = $request->user();

        if ($ambil_siswa->level !='Siswa') {
            return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');
        }
    
        return $next($request);
    }
}
