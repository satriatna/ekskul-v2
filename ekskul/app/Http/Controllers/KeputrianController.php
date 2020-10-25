<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Alert;
use Validator;
use App\Exports\ExportNilaiKeputrian;
use App\Exports\DataKeputrianExport;
use App\Exports\DataKeputrianAlpaExport;
use App\Exports\KehadiranKeputrianExport;
use App\Exports\KehadiranKeputrianPersiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class KeputrianController extends Controller
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
    
    
    public function keputrian()
    {
       
        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $keputrian = DB::table('tb_keputrian')->get();
        return view('ekskul/keputrian',compact('keputrian','instruktur'));
  
    }

    public function keputrian_store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'nama_keputrian'=>'required|unique:tb_keputrian',
            'hari_keputrian'=>'required',
            'kuota_keputrian'=>'required',
            'instruktur_keputrian_id'=>'required',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages('Tidak Boleh Sama')->all()[0])->withInput()->withErrors($validator);;    
        }
        DB::table('tb_keputrian')->insert([
            'nama_keputrian'=>$request->nama_keputrian,
            'hari_keputrian'=>$request->hari_keputrian,
            'kuota_keputrian'=>$request->kuota_keputrian,
            'sisa_kuota_keputrian'=>$request->kuota_keputrian,
            'instruktur_keputrian_id'=>$request->instruktur_keputrian_id,
        ]);
        
            return redirect()->back()->withSuccessMessage('Data Berhasil Ditambahkan');
        }
        
        public function keputrian_hapus($id)
        {
            DB::table('tb_keputrian')->where('id_keputrian',$id)->delete();
          
            return redirect()->back()->withSuccessMessage('Data Berhasil dihapus');;;
        }

        public function keputrian_detail($id,$instruktur_id)
        {
            $pengguna_detail = DB::table('users')->where('id',$instruktur_id)->first();
            $keputrian_cek = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
            // if(Auth::user()->level !='Pengurus')
            // {

            //     if($pengguna_detail->id != Auth::user()->id || $keputrian_cek->instruktur_keputrian_id != Auth::user()->id)
            //     {
            //         return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');

            //     }
            // }
            $tb_tgl_absen_keputrian = DB::table('tb_tgl_absen_keputrian')->first();
            $alpa = DB::table("users")->where('kehadiran_keputrian','>',3)->get();
            $nama_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
    
            $instruktur = DB::table('users')->where('level','Instruktur')->get();
            $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->get();
            $siswa = DB::table('users')->where('level','Siswa')->where('keputrian_id',$id)
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
            $gambar_keputrian = DB::table('tb_gambar_keputrian')->where('gambar_keputrian_id',$id)->get();
            $pindah = DB::table('tb_keputrian')->where('id_keputrian','!=',$id)->get();
            return view('ekskul/keputrian_detail',compact('keputrian','siswa','pindah','instruktur','nama_keputrian','alpa','tb_tgl_absen_keputrian','gambar_keputrian'));
             
        }
    
        public function keputrian_update(Request $request)
        { 
            DB::table('tb_keputrian')->where('id_keputrian',$request->id_keputrian)->update([
                'nama_keputrian'=>$request->nama_keputrian,
                'hari_keputrian'=>$request->hari_keputrian,
                'kuota_keputrian'=>$request->kuota_keputrian,
                'sisa_kuota_keputrian'=>$request->sisa_kuota_keputrian,
                'instruktur_keputrian_id'=>$request->instruktur_keputrian_id,
                'deskripsi_kegiatan_keputrian'=>$request->deskripsi_kegiatan_keputrian
            ]);
           
                return redirect()->back()->withSuccessMessage('Data Senbud Berhasil Diubah');
        }

        
        public function detail_keputrian_siswa($id)
        {
            if( Auth::user()->level !='Pengurus' )
            {
                return redirect()->back();
            }
            $absen_keputrian_hadir = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','H')->get();
            $absen_keputrian_tak_hadir = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','!=','H')->get();
            $hadir = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','H')->get();
            $ijin = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','I')->get();
            $sakit = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','S')->get();
            $alpa = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','A')->get();
            $nama_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
    
            $instruktur = DB::table('users')->where('level','Instruktur')->get();
            $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->get();
            $siswa = DB::table('users')->where('id',$id)
            ->join('tb_jurusan', function ($join) {
                $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
            })
            ->join('tb_keputrian', function ($join) {
                $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
            })
            ->join('tb_rombel', function ($join) {
                $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
            })
            ->join('tb_rayon', function ($join) {
                $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
            })
            ->get();
           
                $pindah = DB::table('tb_keputrian')->where('id_keputrian','!=',$id)->get();
                return view('ekskul/detail_keputrian_siswa',compact('keputrian','siswa','pindah','instruktur','nama_keputrian','hadir','absen_keputrian_hadir','absen_keputrian_tak_hadir','ijin','sakit','alpa'));
            
        }

    public function data_keputrian($id)
    {
        $absen_keputrian = DB::table("tb_absen_keputrian")->where('keputrian_id_absen',$id)->get();         
        $alpa = DB::table("users")->where('kehadiran_keputrian','>',3)->get();
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
        $siswa = DB::table('users')->where('keputrian_id',$id)
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
        return view('instruktur/keputrian/data_keputrian',compact('keputrian','siswa','absen_keputrian','alpa'));
    }

    public function data_keputrian_siswa($id,$id2)
    {
        $hadir = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keputrian_id_absen',$id2)->where('keterangan_absen_keputrian','H')->get();
        $ijin = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keputrian_id_absen',$id2)->where('keterangan_absen_keputrian','I')->get();
        $sakit = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keputrian_id_absen',$id2)->where('keterangan_absen_keputrian','S')->get();
        $alpa = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keputrian_id_absen',$id2)->where('keterangan_absen_keputrian','A')->get();
        $ambil_user = DB::table("users")->where('id',$id)->first();
        $ambil_keputrian = DB::table("tb_keputrian")->where('id_keputrian',$id2)->first();
        $ambil_nama = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keputrian_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
        })
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->first();

        $siswa = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keputrian_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
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
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->get();
        return view('instruktur/keputrian/data_keputrian_siswa',compact('siswa','ambil_nama','hadir','ijin','sakit','alpa','ambil_user','ambil_keputrian'));
    }

    public function data_keputrian_siswa_ubah(Request $request)
    {
        $keputrian_id_absen = $request->keputrian_id_absen;
        $users_absen_keputrian_id = $request->users_absen_keputrian_id;
        $siswa = DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->id_absen_keputrian)
        ->join('users', function ($join) {
            $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
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
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })->first();
        return view('instruktur/keputrian/data_keputrian_siswa_ubah',compact('siswa','keputrian_id_absen','users_absen_keputrian_id'));
    }
    
    public function data_keputrian_siswa_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->id_absen_keputrian)->first();
        if($cek_alpa->keterangan_absen_keputrian == 'A')
        {
            if($request->keterangan_absen_keputrian !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->first();
                $kurangi_alpa = $cek->kehadiran_keputrian - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->update([
                    'kehadiran_keputrian'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_keputrian =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->first();
                $tambah_alpa = $cek->kehadiran_keputrian + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->update([
                    'kehadiran_keputrian'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->id_absen_keputrian)->update([
            'keterangan_absen_keputrian'=>$request->keterangan_absen_keputrian
        ]);
        $tgl = $request->tgl_absen_keputrian_detail;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'data/keputrian/siswa/'. $request->id_3. '/' . $request->id_2;
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function data_kehadiran_keputrian_ubah(Request $request)
    {
        $keputrian_id_absen = $request->keputrian_id_absen;
        $ambil_tanggal = $request->ambil_tanggal;
        $users_absen_keputrian_id = $request->users_absen_keputrian_id;
        $siswa = DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->id_absen_keputrian)
        ->join('users', function ($join) {
            $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
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
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })->first();
        return view('instruktur/keputrian/data_kehadiran_keputrian_ubah',compact('siswa','id_absen_keputrian','ambil_tanggal','users_absen_keputrian_id'));
    }
    
    public function data_kehadiran_keputrian_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->id_absen_keputrian)->first();
        if($cek_alpa->keterangan_absen_keputrian == 'A')
        {
            if($request->keterangan_absen_keputrian !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->first();
                $kurangi_alpa = $cek->kehadiran_keputrian - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->update([
                    'kehadiran_keputrian'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_keputrian =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->first();
                $tambah_alpa = $cek->kehadiran_keputrian + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_keputrian_id)->update([
                    'kehadiran_keputrian'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->id_absen_keputrian)->update([
            'keterangan_absen_keputrian'=>$request->keterangan_absen_keputrian
        ]);
        $tgl = $request->tgl;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'kehadiran/keputrian/detail/'. $tgl.'/'.$request->keputrian_id_absen. '/';
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function input_absen_keputrian(Request $request)
    { 
        $gabungan = date('Y-m-d');
        $cek = DB::table('tb_tgl_absen_keputrian')->where('tgl_absen_keputrian',$gabungan)->where('tgl_absen_keputrian_id',$request->keputrian_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_keputrian > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$request->keputrian_id)->first();
        $siswa = DB::table('users')->where('keputrian_id',$request->keputrian_id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->get();
        return view('instruktur/keputrian/input_absen_keputrian',compact('siswa','keputrian'));
    }
    public function input_absen_keputrian_post(Request $request)
         
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_keputrian')->where('tgl_absen_keputrian',$gabungan)->where('tgl_absen_keputrian_id',$request->keputrian_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_keputrian > 0 )
            {
                $kembali = 'data_keputrian/'. $request->keputrian_id;
                return redirect($kembali)->withWarningMessage('Absen hari ini telah diisi');
            }
        }

        $date = date('Y-m-d');
        $count = count($request->siswa);
        DB::table("tb_tgl_absen_keputrian")->insert([
            'tgl_absen_keputrian'=>$request->tgl_absen_keputrian,
            'tgl_absen_keputrian_id'=>$request->keputrian_id,
        ]);
        
        for($i=0; $i < $count; $i++)
        {
            if($request->keterangan[$i] == 'A')
            {
                
                $cek = DB::table('users')->where('id',$request->siswa[$i])->get();
                foreach($cek as $c)
                {
                    $hitung = $c->kehadiran_keputrian + 1;
                }
                DB::table('users')->where('id',$request->siswa[$i])->update([
                    'kehadiran_keputrian'=>$hitung
                ]);
            }
            DB::table('tb_absen_keputrian')->insert([
                'keputrian_id_absen'=>$request->keputrian_id,
                'users_absen_keputrian_id'=>$request->siswa[$i],
                'tgl_absen_keputrian_detail'=>$request->tgl_absen_keputrian,
                'keterangan_absen_keputrian'=>$request->keterangan[$i]
            ]);
        }
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian', $request->keputrian_id)->first();
        $kembali = '/keputrian/detail/'.$keputrian->id_keputrian.'/'.$request->instruktur_keputrian_id;
        $message = 'Berhasil mengisi absen pada tanggal' .' '. $request->tgl_absen_keputrian;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_keputrian($id)
    {
        $tgl_absen_keputrian = DB::table("tb_tgl_absen_keputrian")->where('tgl_absen_keputrian_id',$id)
        ->join('tb_keputrian', function ($join) use($id) {
            $join->on('tb_tgl_absen_keputrian.tgl_absen_keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
       ->get();
       $nama_keputrian = DB::table("tb_keputrian")->where('id_keputrian',$id)
       ->first();
        return view('instruktur/keputrian/kehadiran_keputrian',compact('tgl_absen_keputrian','nama_keputrian'));
    }

    public function kehadiran_keputrian_hapus($id)
    {
        $keputrian = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','A')->get();
        $count = count($keputrian);
        for($i=0; $i < $count; $i++)
        {   
            foreach($keputrian as $s)
            {
                $kotak [] = $s->users_absen_keputrian_id;
            }
            $users = DB::table('users')->where('id',$kotak[$i])->get();
            foreach($users as $u) 
            {
                $kurangi = $u->kehadiran_keputrian - 1;
                $users = DB::table('users')->where('id',$kotak[$i])->update([
                    'kehadiran_keputrian'=> $kurangi
                ]);
            }
        }
        
        DB::table("tb_tgl_absen_keputrian")->where('tgl_absen_keputrian',$id)->delete();
        DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)->delete();
        $message = "Data absensi tanggal". ' '. $id. ' '. "berhasil dihapus";
        return redirect()->back()->withSuccessMessage($message);;

        return view('instruktur/keputrian/kehadiran_keputrian',compact('tgl_absen_keputrian','nama_keputrian'));
    }
    

    public function kehadiran_keputrian_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','H')->get();
        $ijin = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','I')->get();
        $sakit = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','S')->get();
        $alpa = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','A')->get();
        $nama_keputrian = DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)
        ->join('tb_keputrian', function ($join) use($id) {
            $join->on('tb_absen_keputrian.keputrian_id_absen', '=', 'tb_keputrian.id_keputrian');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)->first();
        $absen_keputrian = DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
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
        return view('instruktur/keputrian/kehadiran_keputrian_detail',compact('absen_keputrian','ambil_tanggal','nama_keputrian','hadir','ijin','sakit','alpa'));
    }

    public function keterangan_kehadiran_update(Request $request)
    {
        DB::table('tb_absen_keputrian')->where('id_absen_keputrian',$request->modal_input_id)->update([
            'tgl_absen_keputrian_detail'=>$request->modal_input_keterangan_absen_keputrian
        ]);
        return redirect()->back()->withSuccessMessage('Data Berhasil Diubah');

    }

    public function filter_keputrian_alpa(Request $request)
    {
        $nama_keputrian = DB::table("tb_keputrian")->where('id_keputrian',$request->id_keputrian)->first();
        $jumlah = DB::table('users')->where('keputrian_id',$request->id_keputrian)->where('kehadiran_keputrian', '>','3')->get();
        $siswa = DB::table('users')->where('keputrian_id',$request->id_keputrian)->where('kehadiran_keputrian', '>','3')
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
       dd($siswa);
        return view('instruktur/keputrian/siswa_keputrian_alpa',compact('nama_keputrian','siswa','jumlah'));
        
    }

    public function export_data_keputrian($id)
    {
        $nama_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
        $nama_file = 'Data Keputrian'. ' '. $nama_keputrian->nama_keputrian. ' '. '.xlsx';
        return Excel::download(new DatakeputrianExport($id), $nama_file);
    }
    public function export_data_keputrian_alpa($id)
    {
        $nama_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
        $nama_file = 'Data kehadiran Keputrian'. ' '. $nama_keputrian->nama_keputrian. ' '. 'siswa alpa > 3.xlsx';
        return Excel::download(new DatakeputrianAlpaExport($id), $nama_file);
    }
    public function export_kehadiran_keputrian($id,$id2)
    {
        $nama_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id2)->first();
        $nama_file = 'Data kehadiran Keputrian'. ' '. $nama_keputrian->nama_keputrian. ' '. 'tanggal'. ' '. $id. '.xlsx';
        return Excel::download(new KehadirankeputrianExport($id), $nama_file);
    }
    public function export_kehadiran_keputrian_persiswa($id)
    {
        $nama_siswa = DB::table('users')->where('id',$id)->first();
        $nama_file = 'Data kehadiran Keputrian'. ' '. $nama_siswa->nama.'.xlsx';
        return Excel::download(new KehadirankeputrianPersiswaExport($id), $nama_file);
    }
    public function export_nilai_keputrian($id)
    {
        $nama_keputrian = DB::table('tb_nilai_keputrian')->where('keterangan_nilai_keputrian_detail',$id)
        ->join('tb_keputrian', function ($join) {
            $join->on('tb_nilai_keputrian.keputrian_nilai_keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })->first();
        $nama_file = 'Data nilai siswa keputrian'. ' '. $nama_keputrian->nama_keputrian.' '. 'keterangan : '.$nama_keputrian->keterangan_nilai_keputrian_detail.'.xlsx';
        return Excel::download(new ExportNilaiKeputrian($id), $nama_file);
    }
    public function upload_keputrian_foto(Request $request)
    {
        $cekfoto_keputrian = Validator::make($request->all(), [
            'foto_keputrian' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cekfoto_keputrian->fails()) {
            return redirect()->back()->withErrorMessage('Gagal upload gambar, file harus berbentuk jpg');
        }

        $foto_keputrian = $request->file('foto_keputrian');
        $size = $foto_keputrian->getSize();
        $nama_foto_keputrian = time() . "_" . $foto_keputrian->getClientOriginalName();
        $tujuan_upload_foto_keputrian = 'assets/img/database';
        $foto_keputrian->move($tujuan_upload_foto_keputrian, $nama_foto_keputrian);

     
        $isi = DB::table("tb_gambar_keputrian")->insert([
            'gambar_keputrian_id' => $request->foto_keputrian_id,
            'gambar_nama_keputrian' => $nama_foto_keputrian,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil di upload');

    }

    public function ubah_foto_keputrian(Request $request)
    {
        $cek_foto_keputrian = Validator::make($request->all(), [
            'foto_keputrian' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cek_foto_keputrian->fails()) {
            return redirect()->back()->withErrorMessage('Gagal ubah gambar, file harus berbentuk jpg');
        }

        $foto_keputrian = $request->file('foto_keputrian');
        $size = $foto_keputrian->getSize();
        $nama_foto_keputrian = time() . "_" . $foto_keputrian->getClientOriginalName();
        $tujuan_upload_foto_keputrian = 'assets/img/database';
        $foto_keputrian->move($tujuan_upload_foto_keputrian, $nama_foto_keputrian);

     
        DB::table("tb_keputrian")->where('id_keputrian',$request->id_keputrian)->update([
            'foto_keputrian' => $nama_foto_keputrian,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil diubah');
    }

    public function gambar_keputrian_hapus($id)
    {
        DB::table("tb_gambar_keputrian")->where('id_gambar_keputrian',$id)->delete();
        return redirect()->back()->withSuccessMessage('Gambar berhasil dihapus');

    }

    
    public function input_absen_instruktur_keputrian(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_keputrian')->where('tgl_absen_instruktur_keputrian_detail',$gabungan)->where('keputrian_absen_instruktur_id',$request->keputrian_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
      
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$request->keputrian_id)
        ->join('users', function ($join) {
            $join->on('tb_keputrian.instruktur_keputrian_id', '=', 'users.id');
        })->first();
        return view('piket/instruktur/keputrian/input_absen_instruktur_keputrian',compact('keputrian'));
    }

    public function input_absen_instruktur_keputrian_post(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_keputrian')->where('tgl_absen_instruktur_keputrian_detail',$gabungan)->where('keputrian_absen_instruktur_id',$request->keputrian_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
        DB::table('tb_absen_instruktur_keputrian')->insert([
            'instruktur_absen_keputrian_id' => $request->instruktur_keputrian_id,
            'keputrian_absen_instruktur_id' => $request->keputrian_id,
            'tgl_absen_instruktur_keputrian_detail' => $request->tgl_absen_instruktur_keputrian,
            'keterangan_absen_instruktur_keputrian' => $request->keterangan,
        ]);
        
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian', $request->keputrian_id)->first();
        $kembali = '/keputrian/detail/'.$$keputrian->id_keputrian.'/'.$request->instruktur_keputrian_id;
        $message = 'Instruktur berhasil diabsen pada tanggal' .' '. $request->tgl_absen_keputrian;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_instruktur_keputrian($id)
    {
        
       $nama_instruktur = DB::table("tb_keputrian")->where('id_keputrian',$id)
       ->join('users', function ($join) {
           $join->on('tb_keputrian.instruktur_keputrian_id', '=', 'users.id');
       })->first();
       $kehadiran = DB::table("tb_absen_instruktur_keputrian")->where('instruktur_absen_keputrian_id',$nama_instruktur->id)->get();
        return view('piket/instruktur/keputrian/kehadiran_instruktur_keputrian',compact('kehadiran','nama_instruktur'));
    }

    public function data_kehadiran_instruktur_keputrian_hapus($id)
    {
        $ambil = DB::table('tb_absen_instruktur_keputrian')->where('id_absen_instruktur_keputrian',$id)->first();
        $message = "Data absensi Instruktur pada tanggal". ' '. $ambil->tgl_absen_instruktur_keputrian_detail. ' '. "berhasil dihapus";
        $ambil = DB::table('tb_absen_instruktur_keputrian')->where('id_absen_instruktur_keputrian',$id)->delete();
        return redirect()->back()->withSuccessMessage($message);;
    }
    

    public function kehadiran_instruktur_keputrian_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','H')->get();
        $ijin = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','I')->get();
        $sakit = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','S')->get();
        $alpa = DB::table('tb_absen_keputrian')->where('tgl_absen_keputrian_detail',$id)->where('keterangan_absen_keputrian','A')->get();
        $nama_keputrian = DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)
        ->join('tb_keputrian', function ($join) use($id) {
            $join->on('tb_absen_keputrian.keputrian_id_absen', '=', 'tb_keputrian.id_keputrian');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)->first();
        $absen_keputrian = DB::table("tb_absen_keputrian")->where('tgl_absen_keputrian_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
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
        return view('piket/instruktur/keputrian/kehadiran_keputrian_detail',compact('absen_keputrian','ambil_tanggal','nama_keputrian','hadir','ijin','sakit','alpa'));
    }

    public function data_kehadiran_instruktur_keputrian_ubah($id)
    {
        $instruktur = DB::table('tb_absen_instruktur_keputrian')->where('id_absen_instruktur_keputrian',$id)
        ->join('users', function ($join) {
            $join->on('tb_absen_instruktur_keputrian.instruktur_absen_keputrian_id', '=', 'users.id');
        })
        ->join('tb_keputrian', function ($join) {
            $join->on('tb_absen_instruktur_keputrian.keputrian_absen_instruktur_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->first();
        return view('piket/instruktur/keputrian/data_kehadiran_instruktur_keputrian_ubah',compact('instruktur'));
    }

    public function data_kehadiran_instruktur_keputrian_ubah_post(Request $request)
    {
        DB::table('tb_absen_instruktur_keputrian')->where('id_absen_instruktur_keputrian',$request->id_absen_instruktur_keputrian)->update([
            'keterangan_absen_instruktur_keputrian'=>$request->keterangan_absen_instruktur_keputrian
        ]);
        $ambil = DB::table('tb_absen_instruktur_keputrian')->where('id_absen_instruktur_keputrian',$request->id_absen_instruktur_keputrian)->first();
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian', $ambil->keputrian_absen_instruktur_id)->first();
        $kembali = '/kehadiran_instruktur_keputrian/'.$keputrian->id_keputrian;
        $message = 'Absen Instruktur berhasil diubah pada tanggal' .' '. $ambil->tgl_absen_instruktur_keputrian_detail;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    
    public function input_nilai_keputrian($id)
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_keputrian')->where('tgl_absen_keputrian',$gabungan)->where('tgl_absen_keputrian_id',$id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_keputrian > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
        $siswa = DB::table('users')->where('keputrian_id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->get();

        return view('instruktur/keputrian/nilai/input_nilai_keputrian',compact('siswa','keputrian'));
    }
    public function input_nilai_keputrian_post(Request $request)
    {
        $cek = DB::table('tb_keterangan_nilai_keputrian')->where('keterangan_nilai_keputrian', $request->keterangan_nilai_keputrian)->get();
        $count = count($cek);
        if($count != 0)
        {
            return redirect()->back()->withErrorMessage('Gagal, keterangan nilai tersebut sudah ada');;;

        }
        $tgl = date('Y-m-d');
        DB::table('tb_keterangan_nilai_keputrian')->insert([
            'keterangan_nilai_keputrian_id'=>$request->keputrian_id,
            'keterangan_nilai_keputrian'=>$request->keterangan_nilai_keputrian,
            'tgl_nilai_keputrian'=>$tgl,
        ]);

        $count = count($request->siswa);
        for($i=0; $i < $count; $i++)
        {
            DB::table('tb_nilai_keputrian')->insert([
                'users_nilai_keputrian_id'=>$request->siswa[$i],
                'keputrian_nilai_keputrian_id'=>$request->keputrian_id,
                'nilai_pengetahuan_keputrian'=>$request->pengetahuan[$i],
                'nilai_sikap_keputrian'=>$request->sikap[$i],
                'keterangan_nilai_keputrian_detail'=>$request->keterangan_nilai_keputrian
            ]);
        }
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian', $request->keputrian_id)->first();
        $kembali = '/keputrian/detail/'.$keputrian->id_keputrian.'/'.$request->instruktur_keputrian_id;
        $message = 'Berhasil input nilai' .' '. $request->tgl_absen_keputrian;
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function lihat_nilai_keputrian($id)
    {
       $tb_keterangan_nilai_keputrian = DB::table("tb_keterangan_nilai_keputrian")
       ->join('tb_keputrian', function ($join) {
        $join->on('tb_keterangan_nilai_keputrian.keterangan_nilai_keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })->get();
       $nama_keputrian = DB::table("tb_keputrian")->where('id_keputrian', $id)->first();
        return view('instruktur/keputrian/nilai/lihat_nilai_keputrian',compact('nama_keputrian','tb_keterangan_nilai_keputrian'));
    }
    public function lihat_detail_nilai_keputrian($id)
    {
        $tb_nilai_keputrian = DB::table("tb_nilai_keputrian")->where('keterangan_nilai_keputrian_detail',$id)
        ->join('users', function ($join) {
         $join->on('tb_nilai_keputrian.users_nilai_keputrian_id', '=', 'users.id')
         ->join('tb_rayon', function ($join) {
             $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
         });
     })->get();
        $ambil = DB::table("tb_nilai_keputrian")->where('keterangan_nilai_keputrian_detail',$id)->first();

        $nama_keputrian = DB::table("tb_keputrian")->where('id_keputrian',$ambil->keputrian_nilai_keputrian_id)->first();
         return view('instruktur/keputrian/nilai/lihat_detail_nilai_keputrian',compact('nama_keputrian','tb_nilai_keputrian','ambil'));
    }

    public function nilai_keputrian_ubah(Request $request)
    {
        $id_nilai_keputrian = $request->id_nilai_keputrian;
        $users_nilai_keputrian_id = $request->users_nilai_keputrian_id;
        $nilai = DB::table('tb_nilai_keputrian')->where('id_nilai_keputrian',$request->id_nilai_keputrian)
        ->join('users', function ($join) {
            $join->on('tb_nilai_keputrian.users_nilai_keputrian_id', '=', 'users.id');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_keputrian', function ($join) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })->first();
        $nama_keputrian =  DB::table('tb_keputrian')->where('id_keputrian',$nilai->keputrian_nilai_keputrian_id)->first();

        return view('instruktur/keputrian/nilai/nilai_keputrian_ubah',compact('nilai','id_nilai_keputrian','users_nilai_keputrian_id','nama_keputrian'));
    }
    public function nilai_keputrian_ubah_post(Request $request)
    {
        DB::table('tb_nilai_keputrian')->where('id_nilai_keputrian',$request->id_nilai_keputrian)->update([
            'nilai_sikap_keputrian' => $request->nilai_sikap_keputrian,
            'nilai_pengetahuan_keputrian' => $request->nilai_pengetahuan_keputrian,
        ]);
        $kembali = '/lihat_detail_nilai_keputrian/'.$request->keterangan;
        $message = 'Nilai berhasil diubah';
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function hapus_nilai_keputrian($id)
    {
        $ambil = DB::table('tb_keterangan_nilai_keputrian')->where('id_keterangan_nilai_keputrian',$id)->first();
        DB::table('tb_keterangan_nilai_keputrian')->where('id_keterangan_nilai_keputrian',$id)->delete();
        DB::table('tb_nilai_keputrian')->where('keterangan_nilai_keputrian_detail',$ambil->keterangan_nilai_keputrian)->delete();
        return redirect()->back()->withSuccessMessage('Data berhasil dihapus');
    }

}
