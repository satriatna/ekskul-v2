<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Alert;

class PiketController extends Controller
{
    public function dashboard_piket()
    {
        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',Auth::user()->id)->first();

        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',Auth::user()->id)->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('instruktur_ekskul_biasa_id',Auth::user()->id)->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('instruktur_ekskul_produktif_id',Auth::user()->id)->get();
        $keputrian = DB::table('tb_keputrian')->where('instruktur_keputrian_id',Auth::user()->id)->get();
        $instruktur = DB::table('users')->where('level','Instruktur')->where('status','aktif')->get();
        return view('piket/dashboard_piket',compact('pengguna','senbud','upd','instruktur'));
    }
   
    public function input_absen_instruktur($id)
    {
        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',$id)->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('instruktur_ekskul_biasa_id',$id)->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('instruktur_ekskul_produktif_id',$id)->get();
        $keputrian = DB::table('tb_keputrian')->where('instruktur_keputrian_id',$id)->get();
        return view('piket/input_absen',compact('senbud','ekskul_biasa','ekskul_produktif','keputrian'));
    }

}
