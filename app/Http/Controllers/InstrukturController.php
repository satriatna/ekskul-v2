<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Alert;
class InstrukturController extends Controller
{
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
        
        $this->middleware('instruktur_level');
    }
    public function dashboard_instruktur()
    {
        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',Auth::user()->id)->first();

        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',Auth::user()->id)->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('instruktur_ekskul_biasa_id',Auth::user()->id)->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('instruktur_ekskul_produktif_id',Auth::user()->id)->get();
        $keputrian = DB::table('tb_keputrian')->where('instruktur_keputrian_id',Auth::user()->id)->get();
        return view('instruktur/dashboard_instruktur',compact('pengguna','senbud','upd'));
    }

    // Akhir Senbud Controller

}
