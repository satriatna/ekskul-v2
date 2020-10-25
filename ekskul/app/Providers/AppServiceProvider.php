<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use Composer;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts/layout', function($view)
        {
            $view->with('users', DB::table('users')->where('id',Auth::user()->id)->get());
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('senbud', DB::table('tb_senbud')->where('instruktur_senbud_id',Auth::user()->id)->get());
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('ekskul_biasa', DB::table('tb_ekskul_biasa')->where('instruktur_ekskul_biasa_id',Auth::user()->id)->get());
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('ekskul_produktif', DB::table('tb_ekskul_produktif')->where('instruktur_ekskul_produktif_id',Auth::user()->id)->get());
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('keputrian', DB::table('tb_keputrian')->where('instruktur_keputrian_id',Auth::user()->id)->get());
        });
        // ============================================================================= DATA ABSEN KEHADIRAN

        // Data Kehadiran Per Siswa
        view()->composer('layouts/layout', function($view)
        {
            $view->with('senbud_per_siswa',DB::table('tb_senbud')->where('id_senbud',Auth::user()->senbud_id)->get());
         
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('ekskul_biasa_per_siswa',DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',Auth::user()->ekskul_biasa_id)->get());
         
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('keputrian_per_siswa',DB::table('tb_keputrian')->where('id_keputrian',Auth::user()->keputrian_id)->get());
         
        });
        view()->composer('layouts/layout', function($view)
        {
            $view->with('ekskul_produktif_per_siswa',DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',Auth::user()->ekskul_produktif_id)->get());
         
        });
       
    }
}
