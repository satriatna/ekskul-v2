<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Alert;
use Validator;
use App\Exports\DataSenbudExport;
use App\Exports\DataSenbudAlpaExport;
use App\Exports\ExportNilaiSenbud;
use App\Exports\KehadiranSenbudExport;
use App\Exports\KehadiranSenbudPersiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class SenbudController extends Controller
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
        $this->middleware('siswa_level');
    }
    public function senbud()
    {
       
        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $senbud = DB::table('tb_senbud')->get();
        return view('ekskul/senbud',compact('senbud','instruktur'));
  
    }
     
    public function senbud_hapus($id)
    {
        DB::table('tb_senbud')->where('id_senbud',$id)->delete();
      
        return redirect()->back()->withSuccessMessage('Data Berhasil dihapus');;;
    }
    
    public function senbud_detail($id,$instruktur_id)
    {
        $pengguna_detail = DB::table('users')->where('id',$instruktur_id)->first();
        $senbud_cek = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        // if(Auth::user()->level !='Pengurus')
        // {

        //     if($pengguna_detail->id != Auth::user()->id || $senbud_cek->instruktur_senbud_id != Auth::user()->id)
        //     {
        //         return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');

        //     }
        // }
        $tb_tgl_absen_senbud = DB::table('tb_tgl_absen_senbud')->first();
        $alpa = DB::table("users")->where('kehadiran_senbud','>',3)->get();
        $nama_senbud = DB::table('tb_senbud')->where('id_senbud',$id)->first();

        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $senbud = DB::table('tb_senbud')->where('id_senbud',$id)->get();
        $siswa = DB::table('users')->where('level','Siswa')->where('senbud_id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->get();
        $gambar_senbud = DB::table('tb_gambar_senbud')->where('gambar_senbud_id',$id)->get();
        $pindah = DB::table('tb_senbud')->where('id_senbud','!=',$id)->get();
        return view('ekskul/senbud_detail',compact('senbud','siswa','pindah','instruktur','nama_senbud','alpa','tb_tgl_absen_senbud','gambar_senbud'));
    }
    public function detail_senbud_siswa($id)
    {
       
        $absen_senbud_hadir = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','H')->get();
        $absen_senbud_tak_hadir = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','!=','H')->get();
        $hadir = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','H')->get();
        $ijin = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','I')->get();
        $sakit = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','S')->get();
        $alpa = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','A')->get();
        $siswa = DB::table('users')->where('id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->get();
       
            $pindah = DB::table('tb_senbud')->where('id_senbud','!=',$id)->get();
            return view('ekskul/detail_senbud_siswa',compact('siswa','hadir','absen_senbud_hadir','absen_senbud_tak_hadir','ijin','sakit','alpa'));
         
    }
    public function senbud_store(Request $request)
    { 
        
        $validator = Validator::make($request->all(),[
            'nama_senbud'=>'required|unique:tb_senbud',
            'hari'=>'required',
            'kuota'=>'required',
            'instruktur_senbud_id'=>'required',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages()->all()[0])->withInput()->withErrors($validator);;    
        }
            DB::table('tb_senbud')->insert([
                'nama_senbud'=>$request->nama_senbud,
                'hari_senbud'=>$request->hari,
                'kuota_senbud'=>$request->kuota,
                'sisa_kuota_senbud'=>$request->kuota,
                'instruktur_senbud_id'=>$request->instruktur_senbud_id,
            ]);
            
            return redirect()->back()->withSuccessMessage('Data Berhasil Ditambahkan');   
    }
    public function senbud_update(Request $request)
    { 
        DB::table('tb_senbud')->where('id_senbud',$request->id_senbud)->update([
            'nama_senbud'=>$request->nama_senbud,
            'hari_senbud'=>$request->hari_senbud,
            'kuota_senbud'=>$request->kuota_senbud,
            'sisa_kuota_senbud'=>$request->sisa_kuota_senbud,
            'instruktur_senbud_id'=>$request->instruktur_senbud_id,
            'deskripsi_kegiatan_senbud'=>$request->deskripsi_kegiatan_senbud
        ]);
       
            return redirect()->back()->withSuccessMessage('Data Senbud Berhasil Diubah');
    }

  

    public function data_senbud($id)
    {
        $absen_senbud = DB::table("tb_absen_senbud")->where('senbud_id_absen',$id)->get();         
        $alpa = DB::table("users")->where('kehadiran_senbud','>',3)->get();
        $senbud = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        $siswa = DB::table('users')->where('senbud_id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->get();
        return view('instruktur/senbud/data_senbud',compact('senbud','siswa','absen_senbud','alpa'));
    }

    public function data_senbud_siswa($id,$id2)
    {
        $hadir = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('senbud_id_absen',$id2)->where('keterangan_absen_senbud','H')->get();
        $ijin = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('senbud_id_absen',$id2)->where('keterangan_absen_senbud','I')->get();
        $sakit = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('senbud_id_absen',$id2)->where('keterangan_absen_senbud','S')->get();
        $alpa = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('senbud_id_absen',$id2)->where('keterangan_absen_senbud','A')->get();
        $ambil_user = DB::table("users")->where('id',$id)->first();
        $ambil_senbud = DB::table("tb_senbud")->where('id_senbud',$id2)->first();
        $ambil_nama = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('senbud_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->first();

        $siswa = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('senbud_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->get();
        return view('instruktur/senbud/data_senbud_siswa',compact('siswa','ambil_nama','hadir','ijin','sakit','alpa','ambil_user','ambil_senbud'));
    }

    public function data_senbud_siswa_ubah(Request $request)
    {
        $senbud_id_absen = $request->senbud_id_absen;
        $users_absen_senbud_id = $request->users_absen_senbud_id;
        $siswa = DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->id_absen_senbud)
        ->join('users', function ($join) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })->first();
        return view('instruktur/senbud/data_senbud_siswa_ubah',compact('siswa','senbud_id_absen','users_absen_senbud_id'));
    }
    
    public function data_senbud_siswa_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->id_absen_senbud)->first();
        if($cek_alpa->keterangan_absen_senbud == 'A')
        {
            if($request->keterangan_absen_senbud !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->first();
                $kurangi_alpa = $cek->kehadiran_senbud - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->update([
                    'kehadiran_senbud'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_senbud =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->first();
                $tambah_alpa = $cek->kehadiran_senbud + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->update([
                    'kehadiran_senbud'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->id_absen_senbud)->update([
            'keterangan_absen_senbud'=>$request->keterangan_absen_senbud
        ]);
        $tgl = $request->tgl_absen_senbud_detail;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'data/senbud/siswa/'. $request->id_3. '/' . $request->id_2;
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function data_kehadiran_senbud_ubah(Request $request)
    {
        $senbud_id_absen = $request->senbud_id_absen;
        $ambil_tanggal = $request->ambil_tanggal;
        $users_absen_senbud_id = $request->users_absen_senbud_id;
        $siswa = DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->id_absen_senbud)
        ->join('users', function ($join) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })->first();
        return view('instruktur/senbud/data_kehadiran_senbud_ubah',compact('siswa','id_absen_senbud','ambil_tanggal','users_absen_senbud_id'));
    }
    
    public function data_kehadiran_senbud_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->id_absen_senbud)->first();
        if($cek_alpa->keterangan_absen_senbud == 'A')
        {
            if($request->keterangan_absen_senbud !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->first();
                $kurangi_alpa = $cek->kehadiran_senbud - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->update([
                    'kehadiran_senbud'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_senbud =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->first();
                $tambah_alpa = $cek->kehadiran_senbud + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_senbud_id)->update([
                    'kehadiran_senbud'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->id_absen_senbud)->update([
            'keterangan_absen_senbud'=>$request->keterangan_absen_senbud
        ]);
        $tgl = $request->tgl;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'kehadiran/senbud/detail/'. $tgl.'/'.$request->senbud_id_absen. '/';
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function input_absen_senbud(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_senbud')->where('tgl_absen_senbud',$gabungan)->where('tgl_absen_senbud_id',$request->senbud_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_senbud > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $senbud = DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->first();
        $siswa = DB::table('users')->where('senbud_id',$request->senbud_id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->get();
        return view('instruktur/senbud/input_absen_senbud',compact('siswa','senbud'));
    }
    public function input_absen_senbud_post(Request $request)
         
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_senbud')->where('tgl_absen_senbud',$gabungan)->where('tgl_absen_senbud_id',$request->senbud_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_senbud > 0 )
            {
                $kembali = 'data_senbud/'. $request->senbud_id;
                return redirect($kembali)->withWarningMessage('Absen hari ini telah diisi');
            }
        }

        $date = date('Y-m-d');
        $count = count($request->siswa);
        DB::table("tb_tgl_absen_senbud")->insert([
            'tgl_absen_senbud'=>$request->tgl_absen_senbud,
            'tgl_absen_senbud_id'=>$request->senbud_id,
        ]);
        
        for($i=0; $i < $count; $i++)
        {
            if($request->keterangan[$i] == 'A')
            {
                
                $cek = DB::table('users')->where('id',$request->siswa[$i])->get();
                foreach($cek as $c)
                {
                    $hitung = $c->kehadiran_senbud + 1;
                }
                DB::table('users')->where('id',$request->siswa[$i])->update([
                    'kehadiran_senbud'=>$hitung
                ]);
            }
            DB::table('tb_absen_senbud')->insert([
                'senbud_id_absen'=>$request->senbud_id,
                'users_absen_senbud_id'=>$request->siswa[$i],
                'tgl_absen_senbud_detail'=>$request->tgl_absen_senbud,
                'keterangan_absen_senbud'=>$request->keterangan[$i]
            ]);
        }
        $senbud = DB::table('tb_senbud')->where('id_senbud', $request->senbud_id)->first();
        $kembali = '/senbud/detail/'.$senbud->id_senbud.'/'.$request->instruktur_senbud_id;
        $message = 'Berhasil mengisi absen pada tanggal' .' '. $request->tgl_absen_senbud;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_senbud($id)
    {
        $tgl_absen_senbud = DB::table("tb_tgl_absen_senbud")->where('tgl_absen_senbud_id',$id)
        ->join('tb_senbud', function ($join) use($id) {
            $join->on('tb_tgl_absen_senbud.tgl_absen_senbud_id', '=', 'tb_senbud.id_senbud');
        })
       ->get();
       $nama_senbud = DB::table("tb_senbud")->where('id_senbud',$id)
       ->first();
        return view('instruktur/senbud/kehadiran_senbud',compact('tgl_absen_senbud','nama_senbud'));
    }

    public function kehadiran_senbud_hapus($id)
    {
        $senbud = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','A')->get();
        $count = count($senbud);
        for($i=0; $i < $count; $i++)
        {   
            foreach($senbud as $s)
            {
                $kotak [] = $s->users_absen_senbud_id;
            }
            $users = DB::table('users')->where('id',$kotak[$i])->get();
            foreach($users as $u) 
            {
                $kurangi = $u->kehadiran_senbud - 1;
                $users = DB::table('users')->where('id',$kotak[$i])->update([
                    'kehadiran_senbud'=> $kurangi
                ]);
            }
        }
        
        DB::table("tb_tgl_absen_senbud")->where('tgl_absen_senbud',$id)->delete();
        DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)->delete();
        $message = "Data absensi tanggal". ' '. $id. ' '. "berhasil dihapus";
        return redirect()->back()->withSuccessMessage($message);;

        return view('instruktur/senbud/kehadiran_senbud',compact('tgl_absen_senbud','nama_senbud'));
    }
    

    public function kehadiran_senbud_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','H')->get();
        $ijin = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','I')->get();
        $sakit = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','S')->get();
        $alpa = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','A')->get();
        $nama_senbud = DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)
        ->join('tb_senbud', function ($join) use($id) {
            $join->on('tb_absen_senbud.senbud_id_absen', '=', 'tb_senbud.id_senbud');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)->first();
        $absen_senbud = DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
       ->get();
        return view('instruktur/senbud/kehadiran_senbud_detail',compact('absen_senbud','ambil_tanggal','nama_senbud','hadir','ijin','sakit','alpa'));
    }

    public function keterangan_kehadiran_update(Request $request)
    {
        DB::table('tb_absen_senbud')->where('id_absen_senbud',$request->modal_input_id)->update([
            'tgl_absen_senbud_detail'=>$request->modal_input_keterangan_absen_senbud
        ]);
        return redirect()->back()->withSuccessMessage('Data Berhasil Diubah');

    }

    public function filter_senbud_alpa(Request $request)
    {
        $nama_senbud = DB::table("tb_senbud")->where('id_senbud',$request->id_senbud)->first();
        $jumlah = DB::table('users')->where('senbud_id',$request->id_senbud)->where('kehadiran_senbud', '>','3')->get();
        $siswa = DB::table('users')->where('senbud_id',$request->id_senbud)->where('kehadiran_senbud', '>','3')
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
       ->get();
        return view('instruktur/senbud/siswa_senbud_alpa',compact('nama_senbud','siswa','jumlah'));
        
    }

    public function export_data_senbud($id)
    {
        $nama_senbud = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        $nama_file = 'Data senbud'. ' '. $nama_senbud->nama_senbud. ' '. '.xlsx';
        return Excel::download(new DataSenbudExport($id), $nama_file);
    }
    public function export_data_senbud_alpa($id)
    {
        $nama_senbud = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        $nama_file = 'Data kehadiran senbud'. ' '. $nama_senbud->nama_senbud. ' '. 'siswa alpa > 3.xlsx';
        return Excel::download(new DataSenbudAlpaExport($id), $nama_file);
    }
    public function export_kehadiran_senbud($id,$id2)
    {
        $nama_senbud = DB::table('tb_senbud')->where('id_senbud',$id2)->first();
        $nama_file = 'Data kehadiran senbud'. ' '. $nama_senbud->nama_senbud. ' '. 'tanggal'. ' '. $id. '.xlsx';
        return Excel::download(new KehadiranSenbudExport($id), $nama_file);
    }
    public function export_kehadiran_senbud_persiswa($id)
    {
        $nama_siswa = DB::table('users')->where('id',$id)->first();
        $nama_file = 'Data kehadiran senbud'. ' '. $nama_siswa->nama.'.xlsx';
        return Excel::download(new KehadiranSenbudPersiswaExport($id), $nama_file);
    }
    public function export_nilai_senbud($id)
    {
        $nama_senbud = DB::table('tb_nilai_senbud')->where('keterangan_nilai_senbud_detail',$id)
        ->join('tb_senbud', function ($join) {
            $join->on('tb_nilai_senbud.senbud_nilai_senbud_id', '=', 'tb_senbud.id_senbud');
        })->first();
        $nama_file = 'Data nilai siswa senbud'. ' '. $nama_senbud->nama_senbud.' '. 'keterangan : '.$nama_senbud->keterangan_nilai_senbud_detail.'.xlsx';
        return Excel::download(new ExportNilaiSenbud($id), $nama_file);
    }
    
    public function upload_senbud_foto(Request $request)
    {
        $cekfoto_senbud = Validator::make($request->all(), [
            'foto_senbud' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cekfoto_senbud->fails()) {
            return redirect()->back()->withErrorMessage('Gagal upload gambar, file harus berbentuk jpg');
        }

        $foto_senbud = $request->file('foto_senbud');
        $size = $foto_senbud->getSize();
        $nama_foto_senbud = time() . "_" . $foto_senbud->getClientOriginalName();
        $tujuan_upload_foto_senbud = 'assets/img/database';
        $foto_senbud->move($tujuan_upload_foto_senbud, $nama_foto_senbud);

     
        $isi = DB::table("tb_gambar_senbud")->insert([
            'gambar_senbud_id' => $request->foto_senbud_id,
            'gambar_nama_senbud' => $nama_foto_senbud,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil di upload');

    }

    public function ubah_foto_senbud(Request $request)
    {
        $cek_foto_senbud = Validator::make($request->all(), [
            'foto_senbud' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cek_foto_senbud->fails()) {
            return redirect()->back()->withErrorMessage('Gagal ubah gambar, file harus berbentuk jpg');
        }

        $foto_senbud = $request->file('foto_senbud');
        $size = $foto_senbud->getSize();
        $nama_foto_senbud = time() . "_" . $foto_senbud->getClientOriginalName();
        $tujuan_upload_foto_senbud = 'assets/img/database';
        $foto_senbud->move($tujuan_upload_foto_senbud, $nama_foto_senbud);

     
        DB::table("tb_senbud")->where('id_senbud',$request->id_senbud)->update([
            'foto_senbud' => $nama_foto_senbud,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil diubah');
    }

    public function gambar_senbud_hapus($id)
    {
        DB::table("tb_gambar_senbud")->where('id_gambar_senbud',$id)->delete();
        return redirect()->back()->withSuccessMessage('Gambar berhasil dihapus');

    }

    public function input_absen_instruktur_senbud(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_senbud')->where('tgl_absen_instruktur_senbud_detail',$gabungan)->where('senbud_absen_instruktur_id',$request->senbud_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
      
        $senbud = DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)
        ->join('users', function ($join) {
            $join->on('tb_senbud.instruktur_senbud_id', '=', 'users.id');
        })->first();
        return view('piket/instruktur/senbud/input_absen_instruktur_senbud',compact('senbud'));
    }

    public function input_absen_instruktur_senbud_post(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_senbud')->where('tgl_absen_instruktur_senbud_detail',$gabungan)->where('senbud_absen_instruktur_id',$request->senbud_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
        DB::table('tb_absen_instruktur_senbud')->insert([
            'instruktur_absen_senbud_id' => $request->instruktur_senbud_id,
            'senbud_absen_instruktur_id' => $request->senbud_id,
            'tgl_absen_instruktur_senbud_detail' => $request->tgl_absen_instruktur_senbud,
            'keterangan_absen_instruktur_senbud' => $request->keterangan,
        ]);
        
        $senbud = DB::table('tb_senbud')->where('id_senbud', $request->senbud_id)->first();
        $kembali = '/senbud/detail/'.$senbud->id_senbud.'/'.$request->instruktur_senbud_id;
        $message = 'Instruktur berhasil diabsen pada tanggal' .' '. $request->tgl_absen_senbud;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_instruktur_senbud($id)
    {
        
       $nama_instruktur = DB::table("tb_senbud")->where('id_senbud',$id)
       ->join('users', function ($join) {
           $join->on('tb_senbud.instruktur_senbud_id', '=', 'users.id');
       })->first();
       $kehadiran = DB::table("tb_absen_instruktur_senbud")->where('instruktur_absen_senbud_id',$nama_instruktur->id)->get();
        return view('piket/instruktur/senbud/kehadiran_instruktur_senbud',compact('kehadiran','nama_instruktur'));
    }

    public function data_kehadiran_instruktur_senbud_hapus($id)
    {
        $ambil = DB::table('tb_absen_instruktur_senbud')->where('id_absen_instruktur_senbud',$id)->first();
        $message = "Data absensi Instruktur pada tanggal". ' '. $ambil->tgl_absen_instruktur_senbud_detail. ' '. "berhasil dihapus";
        $ambil = DB::table('tb_absen_instruktur_senbud')->where('id_absen_instruktur_senbud',$id)->delete();
        return redirect()->back()->withSuccessMessage($message);;
    }
    

    public function kehadiran_instruktur_senbud_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','H')->get();
        $ijin = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','I')->get();
        $sakit = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','S')->get();
        $alpa = DB::table('tb_absen_senbud')->where('tgl_absen_senbud_detail',$id)->where('keterangan_absen_senbud','A')->get();
        $nama_senbud = DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)
        ->join('tb_senbud', function ($join) use($id) {
            $join->on('tb_absen_senbud.senbud_id_absen', '=', 'tb_senbud.id_senbud');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)->first();
        $absen_senbud = DB::table("tb_absen_senbud")->where('tgl_absen_senbud_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
       ->get();
        return view('piket/instruktur/senbud/kehadiran_senbud_detail',compact('absen_senbud','ambil_tanggal','nama_senbud','hadir','ijin','sakit','alpa'));
    }

    public function data_kehadiran_instruktur_senbud_ubah($id)
    {
        $instruktur = DB::table('tb_absen_instruktur_senbud')->where('id_absen_instruktur_senbud',$id)
        ->join('users', function ($join) {
            $join->on('tb_absen_instruktur_senbud.instruktur_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('tb_absen_instruktur_senbud.senbud_absen_instruktur_id', '=', 'tb_senbud.id_senbud');
        })
        ->first();
        return view('piket/instruktur/senbud/data_kehadiran_instruktur_senbud_ubah',compact('instruktur'));
    }

    public function data_kehadiran_instruktur_senbud_ubah_post(Request $request)
    {
        DB::table('tb_absen_instruktur_senbud')->where('id_absen_instruktur_senbud',$request->id_absen_instruktur_senbud)->update([
            'keterangan_absen_instruktur_senbud'=>$request->keterangan_absen_instruktur_senbud
        ]);
        $ambil = DB::table('tb_absen_instruktur_senbud')->where('id_absen_instruktur_senbud',$request->id_absen_instruktur_senbud)->first();
        $senbud = DB::table('tb_senbud')->where('id_senbud', $ambil->senbud_absen_instruktur_id)->first();
        $kembali = '/kehadiran_instruktur_senbud/'.$senbud->id_senbud;
        $message = 'Absen Instruktur berhasil diubah pada tanggal' .' '. $ambil->tgl_absen_instruktur_senbud_detail;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    
    public function input_nilai_senbud($id)
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_senbud')->where('tgl_absen_senbud',$gabungan)->where('tgl_absen_senbud_id',$id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_senbud > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $senbud = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        $siswa = DB::table('users')->where('senbud_id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->get();

        return view('instruktur/senbud/nilai/input_nilai_senbud',compact('siswa','senbud'));
    }
    public function input_nilai_senbud_post(Request $request)
    {
        $cek = DB::table('tb_keterangan_nilai_senbud')->where('keterangan_nilai_senbud', $request->keterangan_nilai_senbud)->get();
        $count = count($cek);
        if($count != 0)
        {
            return redirect()->back()->withErrorMessage('Gagal, keterangan nilai tersebut sudah ada');;;

        }
        $tgl = date('Y-m-d');
        DB::table('tb_keterangan_nilai_senbud')->insert([
            'keterangan_nilai_senbud_id'=>$request->senbud_id,
            'keterangan_nilai_senbud'=>$request->keterangan_nilai_senbud,
            'tgl_nilai_senbud'=>$tgl,
        ]);

        $count = count($request->siswa);
        for($i=0; $i < $count; $i++)
        {
            DB::table('tb_nilai_senbud')->insert([
                'users_nilai_senbud_id'=>$request->siswa[$i],
                'senbud_nilai_senbud_id'=>$request->senbud_id,
                'nilai_pengetahuan_senbud'=>$request->pengetahuan[$i],
                'nilai_sikap_senbud'=>$request->sikap[$i],
                'keterangan_nilai_senbud_detail'=>$request->keterangan_nilai_senbud
            ]);
        }
        $senbud = DB::table('tb_senbud')->where('id_senbud', $request->senbud_id)->first();
        $kembali = '/senbud/detail/'.$senbud->id_senbud.'/'.$request->instruktur_senbud_id;
        $message = 'Berhasil input nilai' .' '. $request->tgl_absen_senbud;
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function lihat_nilai_senbud($id)
    {
       $tb_keterangan_nilai_senbud = DB::table("tb_keterangan_nilai_senbud")
       ->join('tb_senbud', function ($join) {
        $join->on('tb_keterangan_nilai_senbud.keterangan_nilai_senbud_id', '=', 'tb_senbud.id_senbud');
        })->get();
       $nama_senbud = DB::table("tb_senbud")->where('id_senbud', $id)->first();
        return view('instruktur/senbud/nilai/lihat_nilai_senbud',compact('nama_senbud','tb_keterangan_nilai_senbud'));
    }
    public function lihat_detail_nilai_senbud($id)
    {
        $tb_nilai_senbud = DB::table("tb_nilai_senbud")->where('keterangan_nilai_senbud_detail',$id)
        ->join('users', function ($join) {
         $join->on('tb_nilai_senbud.users_nilai_senbud_id', '=', 'users.id')
         ->join('tb_rayon', function ($join) {
             $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
         });
     })->get();
        $ambil = DB::table("tb_nilai_senbud")->where('keterangan_nilai_senbud_detail',$id)->first();

        $nama_senbud = DB::table("tb_senbud")->where('id_senbud',$ambil->senbud_nilai_senbud_id)->first();
         return view('instruktur/senbud/nilai/lihat_detail_nilai_senbud',compact('nama_senbud','tb_nilai_senbud','ambil'));
    }

    public function nilai_senbud_ubah(Request $request)
    {
        $id_nilai_senbud = $request->id_nilai_senbud;
        $users_nilai_senbud_id = $request->users_nilai_senbud_id;
        $nilai = DB::table('tb_nilai_senbud')->where('id_nilai_senbud',$request->id_nilai_senbud)
        ->join('users', function ($join) {
            $join->on('tb_nilai_senbud.users_nilai_senbud_id', '=', 'users.id');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })->first();
        $nama_senbud =  DB::table('tb_senbud')->where('id_senbud',$nilai->senbud_nilai_senbud_id)->first();

        return view('instruktur/senbud/nilai/nilai_senbud_ubah',compact('nilai','id_nilai_senbud','users_nilai_senbud_id','nama_senbud'));
    }
    public function nilai_senbud_ubah_post(Request $request)
    {
        DB::table('tb_nilai_senbud')->where('id_nilai_senbud',$request->id_nilai_senbud)->update([
            'nilai_sikap_senbud' => $request->nilai_sikap_senbud,
            'nilai_pengetahuan_senbud' => $request->nilai_pengetahuan_senbud,
        ]);
        $kembali = '/lihat_detail_nilai_senbud/'.$request->keterangan;
        $message = 'Nilai berhasil diubah';
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function hapus_nilai_senbud($id)
    {
        $ambil = DB::table('tb_keterangan_nilai_senbud')->where('id_keterangan_nilai_senbud',$id)->first();
        DB::table('tb_keterangan_nilai_senbud')->where('id_keterangan_nilai_senbud',$id)->delete();
        DB::table('tb_nilai_senbud')->where('keterangan_nilai_senbud_detail',$ambil->keterangan_nilai_senbud)->delete();
        return redirect()->back()->withSuccessMessage('Data berhasil dihapus');
    }


}
