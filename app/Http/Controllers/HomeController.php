<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

use Alert;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
    public function index()
    {
        
        $senbud = DB::table('tb_senbud')
        ->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')
       
        ->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')
      
        ->get();
        $keputrian = DB::table('tb_keputrian')
      
        ->get();
        $users = DB::table('users')->where('level','Instruktur')->get();
        return view('home',compact('users','senbud','ekskul_produktif','ekskul_biasa','keputrian'));
    }

    
    public function ubah_password(Request $request)
    {
        $user = DB::table('users')->where('id',$request->id_user)->get();
            
        foreach($user as $u)
        {
            if (Hash::check($request->password_lama,$u->password )) {
                $user = DB::table('users')->where('id',$request->id_user)->update([
                    'password' => bcrypt($request->password),
                ]);
                return redirect()->back()->withSuccessMessage('Password Berhasil Diubah');
            }
            else{
                return redirect()->back()->withErrorMessage('Password Gagal Diubah, Password Yang Anda Masukkan Salah');
            }
        }        
    }

    public function perkenalan_senbud($id)
    {
        $senbud = DB::table('tb_gambar_senbud')->where('gambar_senbud_id',$id)
        ->join('tb_senbud', function ($join) {
            $join->on('tb_gambar_senbud.gambar_senbud_id', '=', 'tb_senbud.id_senbud');
        })->get();

        
        $hitung = DB::table('tb_senbud')->where('id_senbud',$id)
        ->join('users', function ($join) {
            $join->on('tb_senbud.instruktur_senbud_id', '=', 'users.id');
        })->get();
        
        $ambil_nama = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        $count = count($hitung);
        if($count == 0)
        {
            $pesan = 'Maaf data senbud'.' '. $ambil_nama->nama_senbud.' '. 'sedang diurus oleh Admin';
            return redirect()->back()->withWarningMessage($pesan);
        }


        $nama_senbud = DB::table('tb_senbud')->where('id_senbud',$id)
        ->join('users', function ($join) {
            $join->on('tb_senbud.instruktur_senbud_id', '=', 'users.id');
        })->first();

        return view('perkenalan/senbud',compact('senbud','nama_senbud'));
    }

    public function perkenalan_ekskul_biasa($id)
    {
        $ekskul_biasa = DB::table('tb_gambar_ekskul_biasa')->where('gambar_ekskul_biasa_id',$id)
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('tb_gambar_ekskul_biasa.gambar_ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })->get();
        
        $hitung = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)
        ->join('users', function ($join) {
            $join->on('tb_ekskul_biasa.instruktur_ekskul_biasa_id', '=', 'users.id');
        })->get();
        
        $ambil_nama = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        $count = count($hitung);
        if($count == 0)
        {
            $pesan = 'Maaf data ekskul biasa'.' '. $ambil_nama->nama_ekskul_biasa.' '. 'sedang diurus oleh Admin';
            return redirect()->back()->withWarningMessage($pesan);
        }

        $nama_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)
        ->join('users', function ($join) {
            $join->on('tb_ekskul_biasa.instruktur_ekskul_biasa_id', '=', 'users.id');
        })->first();

        return view('perkenalan/ekskul_biasa',compact('ekskul_biasa','nama_ekskul_biasa'));
    }
    public function perkenalan_ekskul_produktif($id)
    {
        $ekskul_produktif = DB::table('tb_gambar_ekskul_produktif')->where('gambar_ekskul_produktif_id',$id)
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('tb_gambar_ekskul_produktif.gambar_ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })->get();

        
        $hitung = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)
        ->join('users', function ($join) {
            $join->on('tb_ekskul_produktif.instruktur_ekskul_produktif_id', '=', 'users.id');
        })->get();
        
        $ambil_nama = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
        $count = count($hitung);
        if($count == 0)
        {
            $pesan = 'Maaf data ekskul produktif'.' '. $ambil_nama->nama_ekskul_produktif.' '. 'sedang diurus oleh Admin';
            return redirect()->back()->withWarningMessage($pesan);
        }


        $nama_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)
        ->join('users', function ($join) {
            $join->on('tb_ekskul_produktif.instruktur_ekskul_produktif_id', '=', 'users.id');
        })->first();

        return view('perkenalan/ekskul_produktif',compact('ekskul_produktif','nama_ekskul_produktif'));
    }

    public function perkenalan_keputrian($id)
    {
        $keputrian = DB::table('tb_gambar_keputrian')->where('gambar_keputrian_id',$id)
        ->join('tb_keputrian', function ($join) {
            $join->on('tb_gambar_keputrian.gambar_keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })->get();

        $hitung = DB::table('tb_keputrian')->where('id_keputrian',$id)
        ->join('users', function ($join) {
            $join->on('tb_keputrian.instruktur_keputrian_id', '=', 'users.id');
        })->get();
        
        $ambil_nama = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
        $count = count($hitung);
        if($count == 0)
        {
            $pesan = 'Maaf data keputrian'.' '. $ambil_nama->nama_keputrian.' '. 'sedang diurus oleh Admin';
            return redirect()->back()->withWarningMessage($pesan);
        }


        $nama_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)
        ->join('users', function ($join) {
            $join->on('tb_keputrian.instruktur_keputrian_id', '=', 'users.id');
        })->first();

        return view('perkenalan/keputrian',compact('keputrian','nama_keputrian'));
    }

}
