<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Redirect;
use Alert;
use Validator;
use App\Exports\ExportNilaiEkskulProduktif;
use App\Exports\DataEkskulProduktifExport;
use App\Exports\DataEkskulProduktifAlpaExport;
use App\Exports\KehadiranEkskulProduktifExport;
use App\Exports\KehadiranEkskulProduktifPersiswaExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class EkskulProduktifController extends Controller
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
    
    public function ekskul_produktif()
    {
       
        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->get();
        return view('ekskul/ekskul_produktif',compact('ekskul_produktif','instruktur'));
  
    }

    public function ekskul_produktif_store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'nama_ekskul_produktif'=>'required|unique:tb_ekskul_produktif',
            'hari'=>'required',
            'kuota'=>'required',
            'instruktur_ekskul_produktif_id'=>'required',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages('Tidak Boleh Sama')->all()[0])->withInput()->withErrors($validator);;    
        }
        DB::table('tb_ekskul_produktif')->insert([
            'nama_ekskul_produktif'=>$request->nama_ekskul_produktif,
            'hari_ekskul_produktif'=>$request->hari,
            'kuota_ekskul_produktif'=>$request->kuota,
            'sisa_kuota_ekskul_produktif'=>$request->kuota,
            'instruktur_ekskul_produktif_id'=>$request->instruktur_ekskul_produktif_id,
        ]);
        
            return redirect()->back()->withSuccessMessage('Data Berhasil Ditambahkan');
        }

        public function ekskul_produktif_hapus($id)
        {
            DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->delete();
          
            return redirect()->back()->withSuccessMessage('Data Berhasil dihapus');;;
        }
        
        public function ekskul_produktif_detail($id,$instruktur_id)
        {
            $pengguna_detail = DB::table('users')->where('id',$instruktur_id)->first();
            $ekskul_produktif_cek = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
            // if(Auth::user()->level !='Pengurus')
            // {

            //     if($pengguna_detail->id != Auth::user()->id || $ekskul_produktif_cek->instruktur_ekskul_produktif_id != Auth::user()->id)
            //     {
            //         return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');

            //     }
            // }
            $tb_tgl_absen_ekskul_produktif = DB::table('tb_tgl_absen_ekskul_produktif')->first();
            $alpa = DB::table("users")->where('kehadiran_ekskul_produktif','>',3)->get();
            $nama_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
    
            $instruktur = DB::table('users')->where('level','Instruktur')->get();
            $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->get();
            $siswa = DB::table('users')->where('level','Siswa')->where('ekskul_produktif_id',$id)
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
            $gambar_ekskul_produktif = DB::table('tb_gambar_ekskul_produktif')->where('gambar_ekskul_produktif_id',$id)->get();
            $pindah = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif','!=',$id)->get();
            return view('ekskul/ekskul_produktif_detail',compact('ekskul_produktif','siswa','pindah','instruktur','nama_ekskul_produktif','alpa','tb_tgl_absen_ekskul_produktif','gambar_ekskul_produktif'));
             
    }
    
    public function ekskul_produktif_update(Request $request)
    { 
        DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->id_ekskul_produktif)->update([
            'nama_ekskul_produktif'=>$request->nama_ekskul_produktif,
            'hari_ekskul_produktif'=>$request->hari_ekskul_produktif,
            'kuota_ekskul_produktif'=>$request->kuota_ekskul_produktif,
            'sisa_kuota_ekskul_produktif'=>$request->sisa_kuota_ekskul_produktif,
            'instruktur_ekskul_produktif_id'=>$request->instruktur_ekskul_produktif_id,
            'deskripsi_kegiatan_ekskul_produktif'=>$request->deskripsi_kegiatan_ekskul_produktif
        ]);
       
            return redirect()->back()->withSuccessMessage('Data Senbud Berhasil Diubah');
    }

    public function detail_ekskul_produktif_siswa($id)
    {
       
        $absen_ekskul_produktif_hadir = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $absen_ekskul_produktif_tak_hadir = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','!=','H')->get();
        $hadir = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $ijin = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','S')->get();
        $alpa = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','A')->get();
        $nama_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();

        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->get();
        $siswa = DB::table('users')->where('id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->get();
       
            $pindah = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif','!=',$id)->get();
            return view('ekskul/detail_ekskul_produktif_siswa',compact('ekskul_produktif','siswa','pindah','instruktur','nama_ekskul_produktif','hadir','absen_ekskul_produktif_hadir','absen_ekskul_produktif_tak_hadir','ijin','sakit','alpa'));
         
         
    }

    public function data_ekskul_produktif($id)
    {
        $absen_ekskul_produktif = DB::table("tb_absen_ekskul_produktif")->where('ekskul_produktif_id_absen',$id)->get();         
        $alpa = DB::table("users")->where('kehadiran_ekskul_produktif','>',3)->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
        $siswa = DB::table('users')->where('ekskul_produktif_id',$id)
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
        return view('instruktur/ekskul_produktif/data_ekskul_produktif',compact('ekskul_produktif','siswa','absen_ekskul_produktif','alpa'));
    }

    public function data_ekskul_produktif_siswa($id,$id2)
    {
        $hadir = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('ekskul_produktif_id_absen',$id2)->where('keterangan_absen_ekskul_produktif','H')->get();
        $ijin = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('ekskul_produktif_id_absen',$id2)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('ekskul_produktif_id_absen',$id2)->where('keterangan_absen_ekskul_produktif','S')->get();
        $alpa = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('ekskul_produktif_id_absen',$id2)->where('keterangan_absen_ekskul_produktif','A')->get();
        $ambil_user = DB::table("users")->where('id',$id)->first();
        $ambil_ekskul_produktif = DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif',$id2)->first();
        $ambil_nama = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('ekskul_produktif_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
        })
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->first();

        $siswa = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('ekskul_produktif_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
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
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->get();
        return view('instruktur/ekskul_produktif/data_ekskul_produktif_siswa',compact('siswa','ambil_nama','hadir','ijin','sakit','alpa','ambil_user','ambil_ekskul_produktif'));
    }

    public function data_ekskul_produktif_siswa_ubah(Request $request)
    {
        $ekskul_produktif_id_absen = $request->ekskul_produktif_id_absen;
        $users_absen_ekskul_produktif_id = $request->users_absen_ekskul_produktif_id;
        $siswa = DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->id_absen_ekskul_produktif)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
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
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })->first();
        return view('instruktur/ekskul_produktif/data_ekskul_produktif_siswa_ubah',compact('siswa','ekskul_produktif_id_absen','users_absen_ekskul_produktif_id'));
    }
    
    public function data_ekskul_produktif_siswa_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->id_absen_ekskul_produktif)->first();
        if($cek_alpa->keterangan_absen_ekskul_produktif == 'A')
        {
            if($request->keterangan_absen_ekskul_produktif !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->first();
                $kurangi_alpa = $cek->kehadiran_ekskul_produktif - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->update([
                    'kehadiran_ekskul_produktif'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_ekskul_produktif =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->first();
                $tambah_alpa = $cek->kehadiran_ekskul_produktif + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->update([
                    'kehadiran_ekskul_produktif'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->id_absen_ekskul_produktif)->update([
            'keterangan_absen_ekskul_produktif'=>$request->keterangan_absen_ekskul_produktif
        ]);
        $tgl = $request->tgl_absen_ekskul_produktif_detail;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'data/ekskul_produktif/siswa/'. $request->id_3. '/' . $request->id_2;
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function data_kehadiran_ekskul_produktif_ubah(Request $request)
    {
        $ekskul_produktif_id_absen = $request->ekskul_produktif_id_absen;
        $ambil_tanggal = $request->ambil_tanggal;
        $users_absen_ekskul_produktif_id = $request->users_absen_ekskul_produktif_id;
        $siswa = DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->id_absen_ekskul_produktif)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
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
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })->first();
        return view('instruktur/ekskul_produktif/data_kehadiran_ekskul_produktif_ubah',compact('siswa','id_absen_ekskul_produktif','ambil_tanggal','users_absen_ekskul_produktif_id'));
    }
    
    public function data_kehadiran_ekskul_produktif_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->id_absen_ekskul_produktif)->first();
        if($cek_alpa->keterangan_absen_ekskul_produktif == 'A')
        {
            if($request->keterangan_absen_ekskul_produktif !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->first();
                $kurangi_alpa = $cek->kehadiran_ekskul_produktif - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->update([
                    'kehadiran_ekskul_produktif'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_ekskul_produktif =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->first();
                $tambah_alpa = $cek->kehadiran_ekskul_produktif + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_produktif_id)->update([
                    'kehadiran_ekskul_produktif'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->id_absen_ekskul_produktif)->update([
            'keterangan_absen_ekskul_produktif'=>$request->keterangan_absen_ekskul_produktif
        ]);
        $tgl = $request->tgl;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'kehadiran/ekskul_produktif/detail/'. $tgl.'/'.$request->ekskul_produktif_id_absen. '/';
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function input_absen_ekskul_produktif(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif',$gabungan)->where('tgl_absen_ekskul_produktif_id',$request->ekskul_produktif_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_ekskul_produktif > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktif_id)->first();
        $siswa = DB::table('users')->where('ekskul_produktif_id',$request->ekskul_produktif_id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->get();
        return view('instruktur/ekskul_produktif/input_absen_ekskul_produktif',compact('siswa','ekskul_produktif'));
    }
    public function input_absen_ekskul_produktif_post(Request $request)
         
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif',$gabungan)->where('tgl_absen_ekskul_produktif_id',$request->ekskul_produktif_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_ekskul_produktif > 0 )
            {
                $kembali = 'data_ekskul_produktif/'. $request->ekskul_produktif_id;
                return redirect($kembali)->withWarningMessage('Absen hari ini telah diisi');
            }
        }

        $date = date('Y-m-d');
        $count = count($request->siswa);
        DB::table("tb_tgl_absen_ekskul_produktif")->insert([
            'tgl_absen_ekskul_produktif'=>$request->tgl_absen_ekskul_produktif,
            'tgl_absen_ekskul_produktif_id'=>$request->ekskul_produktif_id,
        ]);
        
        for($i=0; $i < $count; $i++)
        {
            if($request->keterangan[$i] == 'A')
            {
                
                $cek = DB::table('users')->where('id',$request->siswa[$i])->get();
                foreach($cek as $c)
                {
                    $hitung = $c->kehadiran_ekskul_produktif + 1;
                }
                DB::table('users')->where('id',$request->siswa[$i])->update([
                    'kehadiran_ekskul_produktif'=>$hitung
                ]);
            }
            DB::table('tb_absen_ekskul_produktif')->insert([
                'ekskul_produktif_id_absen'=>$request->ekskul_produktif_id,
                'users_absen_ekskul_produktif_id'=>$request->siswa[$i],
                'tgl_absen_ekskul_produktif_detail'=>$request->tgl_absen_ekskul_produktif,
                'keterangan_absen_ekskul_produktif'=>$request->keterangan[$i]
            ]);
        }
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif', $request->ekskul_produktif_id)->first();
        $kembali = '/ekskul_produktif/detail/'.$ekskul_produktif->id_ekskul_produktif.'/'.$request->instruktur_ekskul_produktif_id;
        $message = 'Berhasil mengisi absen pada tanggal' .' '. $request->tgl_absen_ekskul_produktif;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_ekskul_produktif($id)
    {
        $tgl_absen_ekskul_produktif = DB::table("tb_tgl_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_id',$id)
        ->join('tb_ekskul_produktif', function ($join) use($id) {
            $join->on('tb_tgl_absen_ekskul_produktif.tgl_absen_ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
       ->get();
       $nama_ekskul_produktif = DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif',$id)
       ->first();
        return view('instruktur/ekskul_produktif/kehadiran_ekskul_produktif',compact('tgl_absen_ekskul_produktif','nama_ekskul_produktif'));
    }

    public function kehadiran_ekskul_produktif_hapus($id)
    {
        $ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','A')->get();
        $count = count($ekskul_produktif);
        for($i=0; $i < $count; $i++)
        {   
            foreach($ekskul_produktif as $s)
            {
                $kotak [] = $s->users_absen_ekskul_produktif_id;
            }
            $users = DB::table('users')->where('id',$kotak[$i])->get();
            foreach($users as $u) 
            {
                $kurangi = $u->kehadiran_ekskul_produktif - 1;
                $users = DB::table('users')->where('id',$kotak[$i])->update([
                    'kehadiran_ekskul_produktif'=> $kurangi
                ]);
            }
        }
        
        DB::table("tb_tgl_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif',$id)->delete();
        DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)->delete();
        $message = "Data absensi tanggal". ' '. $id. ' '. "berhasil dihapus";
        return redirect()->back()->withSuccessMessage($message);;

        return view('instruktur/ekskul_produktif/kehadiran_ekskul_produktif',compact('tgl_absen_ekskul_produktif','nama_ekskul_produktif'));
    }
    

    public function kehadiran_ekskul_produktif_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $ijin = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','S')->get();
        $alpa = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','A')->get();
        $nama_ekskul_produktif = DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)
        ->join('tb_ekskul_produktif', function ($join) use($id) {
            $join->on('tb_absen_ekskul_produktif.ekskul_produktif_id_absen', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)->first();
        $absen_ekskul_produktif = DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
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
        return view('instruktur/ekskul_produktif/kehadiran_ekskul_produktif_detail',compact('absen_ekskul_produktif','ambil_tanggal','nama_ekskul_produktif','hadir','ijin','sakit','alpa'));
    }

    public function keterangan_kehadiran_update(Request $request)
    {
        DB::table('tb_absen_ekskul_produktif')->where('id_absen_ekskul_produktif',$request->modal_input_id)->update([
            'tgl_absen_ekskul_produktif_detail'=>$request->modal_input_keterangan_absen_ekskul_produktif
        ]);
        return redirect()->back()->withSuccessMessage('Data Berhasil Diubah');

    }

    public function filter_ekskul_produktif_alpa(Request $request)
    {
        $nama_ekskul_produktif = DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif',$request->id_ekskul_produktif)->first();
        $jumlah = DB::table('users')->where('ekskul_produktif_id',$request->id_ekskul_produktif)->where('kehadiran_ekskul_produktif', '>','3')->get();
        $siswa = DB::table('users')->where('ekskul_produktif_id',$request->id_ekskul_produktif)->where('kehadiran_ekskul_produktif', '>','3')
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
        return view('instruktur/ekskul_produktif/siswa_ekskul_produktif_alpa',compact('nama_ekskul_produktif','siswa','jumlah'));
        
    }

    public function export_data_ekskul_produktif($id)
    {
        $nama_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
        $nama_file = 'Data Ekskul Produktif'. ' '. $nama_ekskul_produktif->nama_ekskul_produktif. ' '. '.xlsx';
        return Excel::download(new Dataekskul_produktifExport($id), $nama_file);
    }
    public function export_data_ekskul_produktif_alpa($id)
    {
        $nama_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
        $nama_file = 'Data kehadiran Ekskul Produktif'. ' '. $nama_ekskul_produktif->nama_ekskul_produktif. ' '. 'siswa alpa > 3.xlsx';
        return Excel::download(new Dataekskul_produktifAlpaExport($id), $nama_file);
    }
    public function export_kehadiran_ekskul_produktif($id,$id2)
    {
        $nama_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id2)->first();
        $nama_file = 'Data kehadiran Ekskul Produktif'. ' '. $nama_ekskul_produktif->nama_ekskul_produktif. ' '. 'tanggal'. ' '. $id. '.xlsx';
        return Excel::download(new Kehadiranekskul_produktifExport($id), $nama_file);
    }
    public function export_kehadiran_ekskul_produktif_persiswa($id)
    {
        $nama_siswa = DB::table('users')->where('id',$id)->first();
        $nama_file = 'Data kehadiran Ekskul Produktif'. ' '. $nama_siswa->nama.'.xlsx';
        return Excel::download(new Kehadiranekskul_produktifPersiswaExport($id), $nama_file);
    }
    public function export_nilai_ekskul_produktif($id)
    {
        $nama_ekskul_produktif = DB::table('tb_nilai_ekskul_produktif')->where('keterangan_nilai_ekskul_produktif_detail',$id)
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('tb_nilai_ekskul_produktif.ekskul_produktif_nilai_ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })->first();
        $nama_file = 'Data nilai siswa ekskul produktif'. ' '. $nama_ekskul_produktif->nama_ekskul_produktif.' '. 'keterangan : '.$nama_ekskul_produktif->keterangan_nilai_ekskul_produktif_detail.'.xlsx';
        return Excel::download(new ExportNilaiEkskulProduktif($id), $nama_file);
    }
    public function upload_ekskul_produktif_foto(Request $request)
    {
        $cekfoto_ekskul_produktif = Validator::make($request->all(), [
            'foto_ekskul_produktif' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cekfoto_ekskul_produktif->fails()) {
            return redirect()->back()->withErrorMessage('Gagal upload gambar, file harus berbentuk jpg');
        }

        $foto_ekskul_produktif = $request->file('foto_ekskul_produktif');
        $size = $foto_ekskul_produktif->getSize();
        $nama_foto_ekskul_produktif = time() . "_" . $foto_ekskul_produktif->getClientOriginalName();
        $tujuan_upload_foto_ekskul_produktif = 'assets/img/database';
        $foto_ekskul_produktif->move($tujuan_upload_foto_ekskul_produktif, $nama_foto_ekskul_produktif);

     
        $isi = DB::table("tb_gambar_ekskul_produktif")->insert([
            'gambar_ekskul_produktif_id' => $request->foto_ekskul_produktif_id,
            'gambar_nama_ekskul_produktif' => $nama_foto_ekskul_produktif,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil di upload');

    }

    public function ubah_foto_ekskul_produktif(Request $request)
    {
        $cek_foto_ekskul_produktif = Validator::make($request->all(), [
            'foto_ekskul_produktif' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cek_foto_ekskul_produktif->fails()) {
            return redirect()->back()->withErrorMessage('Gagal ubah gambar, file harus berbentuk jpg');
        }

        $foto_ekskul_produktif = $request->file('foto_ekskul_produktif');
        $size = $foto_ekskul_produktif->getSize();
        $nama_foto_ekskul_produktif = time() . "_" . $foto_ekskul_produktif->getClientOriginalName();
        $tujuan_upload_foto_ekskul_produktif = 'assets/img/database';
        $foto_ekskul_produktif->move($tujuan_upload_foto_ekskul_produktif, $nama_foto_ekskul_produktif);

     
        DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif',$request->id_ekskul_produktif)->update([
            'foto_ekskul_produktif' => $nama_foto_ekskul_produktif,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil diubah');
    }

    public function gambar_ekskul_produktif_hapus($id)
    {
        DB::table("tb_gambar_ekskul_produktif")->where('id_gambar_ekskul_produktif',$id)->delete();
        return redirect()->back()->withSuccessMessage('Gambar berhasil dihapus');

    }

    

    public function input_absen_instruktur_ekskul_produktif(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_ekskul_produktif')->where('tgl_absen_instruktur_ekskul_produktif_detail',$gabungan)->where('ekskul_produktif_absen_instruktur_id',$request->ekskul_produktif_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
      
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktif_id)
        ->join('users', function ($join) {
            $join->on('tb_ekskul_produktif.instruktur_ekskul_produktif_id', '=', 'users.id');
        })->first();
        return view('piket/instruktur/ekskul_produktif/input_absen_instruktur_ekskul_produktif',compact('ekskul_produktif'));
    }

    public function input_absen_instruktur_ekskul_produktif_post(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_ekskul_produktif')->where('tgl_absen_instruktur_ekskul_produktif_detail',$gabungan)->where('ekskul_produktif_absen_instruktur_id',$request->ekskul_produktif_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
        DB::table('tb_absen_instruktur_ekskul_produktif')->insert([
            'instruktur_absen_ekskul_produktif_id' => $request->instruktur_ekskul_produktif_id,
            'ekskul_produktif_absen_instruktur_id' => $request->ekskul_produktif_id,
            'tgl_absen_instruktur_ekskul_produktif_detail' => $request->tgl_absen_instruktur_ekskul_produktif,
            'keterangan_absen_instruktur_ekskul_produktif' => $request->keterangan,
        ]);
        
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif', $request->ekskul_produktif_id)->first();
        $kembali = '/ekskul_produktif/detail/'.$ekskul_produktif->id_ekskul_produktif.'/'.$request->instruktur_ekskul_produktif_id;
        $message = 'Instruktur berhasil diabsen pada tanggal' .' '. $request->tgl_absen_ekskul_produktif;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_instruktur_ekskul_produktif($id)
    {
        
       $nama_instruktur = DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif',$id)
       ->join('users', function ($join) {
           $join->on('tb_ekskul_produktif.instruktur_ekskul_produktif_id', '=', 'users.id');
       })->first();
       $kehadiran = DB::table("tb_absen_instruktur_ekskul_produktif")->where('instruktur_absen_ekskul_produktif_id',$nama_instruktur->id)->get();
        return view('piket/instruktur/ekskul_produktif/kehadiran_instruktur_ekskul_produktif',compact('kehadiran','nama_instruktur'));
    }

    public function data_kehadiran_instruktur_ekskul_produktif_hapus($id)
    {
        $ambil = DB::table('tb_absen_instruktur_ekskul_produktif')->where('id_absen_instruktur_ekskul_produktif',$id)->first();
        $message = "Data absensi Instruktur pada tanggal". ' '. $ambil->tgl_absen_instruktur_ekskul_produktif_detail. ' '. "berhasil dihapus";
        $ambil = DB::table('tb_absen_instruktur_ekskul_produktif')->where('id_absen_instruktur_ekskul_produktif',$id)->delete();
        return redirect()->back()->withSuccessMessage($message);;
    }
    

    public function kehadiran_instruktur_ekskul_produktif_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $ijin = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','S')->get();
        $alpa = DB::table('tb_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif_detail',$id)->where('keterangan_absen_ekskul_produktif','A')->get();
        $nama_ekskul_produktif = DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)
        ->join('tb_ekskul_produktif', function ($join) use($id) {
            $join->on('tb_absen_ekskul_produktif.ekskul_produktif_id_absen', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)->first();
        $absen_ekskul_produktif = DB::table("tb_absen_ekskul_produktif")->where('tgl_absen_ekskul_produktif_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
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
        return view('piket/instruktur/ekskul_produktif/kehadiran_ekskul_produktif_detail',compact('absen_ekskul_produktif','ambil_tanggal','nama_ekskul_produktif','hadir','ijin','sakit','alpa'));
    }

    public function data_kehadiran_instruktur_ekskul_produktif_ubah($id)
    {
        $instruktur = DB::table('tb_absen_instruktur_ekskul_produktif')->where('id_absen_instruktur_ekskul_produktif',$id)
        ->join('users', function ($join) {
            $join->on('tb_absen_instruktur_ekskul_produktif.instruktur_absen_ekskul_produktif_id', '=', 'users.id');
        })
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('tb_absen_instruktur_ekskul_produktif.ekskul_produktif_absen_instruktur_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->first();
        return view('piket/instruktur/ekskul_produktif/data_kehadiran_instruktur_ekskul_produktif_ubah',compact('instruktur'));
    }

    public function data_kehadiran_instruktur_ekskul_produktif_ubah_post(Request $request)
    {
        DB::table('tb_absen_instruktur_ekskul_produktif')->where('id_absen_instruktur_ekskul_produktif',$request->id_absen_instruktur_ekskul_produktif)->update([
            'keterangan_absen_instruktur_ekskul_produktif'=>$request->keterangan_absen_instruktur_ekskul_produktif
        ]);
        $ambil = DB::table('tb_absen_instruktur_ekskul_produktif')->where('id_absen_instruktur_ekskul_produktif',$request->id_absen_instruktur_ekskul_produktif)->first();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif', $ambil->ekskul_produktif_absen_instruktur_id)->first();
        $kembali = '/kehadiran_instruktur_ekskul_produktif/'.$ekskul_produktif->id_ekskul_produktif;
        $message = 'Absen Instruktur berhasil diubah pada tanggal' .' '. $ambil->tgl_absen_instruktur_ekskul_produktif_detail;
        return redirect($kembali)->withSuccessMessage($message);;
    }


    public function input_nilai_ekskul_produktif($id)
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_ekskul_produktif')->where('tgl_absen_ekskul_produktif',$gabungan)->where('tgl_absen_ekskul_produktif_id',$id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_ekskul_produktif > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
        $siswa = DB::table('users')->where('ekskul_produktif_id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->get();

        return view('instruktur/ekskul_produktif/nilai/input_nilai_ekskul_produktif',compact('siswa','ekskul_produktif'));
    }
    public function input_nilai_ekskul_produktif_post(Request $request)
    {
        $cek = DB::table('tb_keterangan_nilai_ekskul_produktif')->where('keterangan_nilai_ekskul_produktif', $request->keterangan_nilai_ekskul_produktif)->get();
        $count = count($cek);
        if($count != 0)
        {
            return redirect()->back()->withErrorMessage('Gagal, keterangan nilai tersebut sudah ada');;;

        }
        $tgl = date('Y-m-d');
        DB::table('tb_keterangan_nilai_ekskul_produktif')->insert([
            'keterangan_nilai_ekskul_produktif_id'=>$request->ekskul_produktif_id,
            'keterangan_nilai_ekskul_produktif'=>$request->keterangan_nilai_ekskul_produktif,
            'tgl_nilai_ekskul_produktif'=>$tgl,
        ]);

        $count = count($request->siswa);
        for($i=0; $i < $count; $i++)
        {
            DB::table('tb_nilai_ekskul_produktif')->insert([
                'users_nilai_ekskul_produktif_id'=>$request->siswa[$i],
                'ekskul_produktif_nilai_ekskul_produktif_id'=>$request->ekskul_produktif_id,
                'nilai_pengetahuan_ekskul_produktif'=>$request->pengetahuan[$i],
                'nilai_sikap_ekskul_produktif'=>$request->sikap[$i],
                'keterangan_nilai_ekskul_produktif_detail'=>$request->keterangan_nilai_ekskul_produktif
            ]);
        }
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif', $request->ekskul_produktif_id)->first();
        $kembali = '/ekskul_produktif/detail/'.$ekskul_produktif->id_ekskul_produktif.'/'.$request->instruktur_ekskul_produktif_id;
        $message = 'Berhasil input nilai' .' '. $request->tgl_absen_ekskul_produktif;
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function lihat_nilai_ekskul_produktif($id)
    {
       $tb_keterangan_nilai_ekskul_produktif = DB::table("tb_keterangan_nilai_ekskul_produktif")
       ->join('tb_ekskul_produktif', function ($join) {
        $join->on('tb_keterangan_nilai_ekskul_produktif.keterangan_nilai_ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })->get();
       $nama_ekskul_produktif = DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif', $id)->first();
        return view('instruktur/ekskul_produktif/nilai/lihat_nilai_ekskul_produktif',compact('nama_ekskul_produktif','tb_keterangan_nilai_ekskul_produktif'));
    }
    public function lihat_detail_nilai_ekskul_produktif($id)
    {
        $tb_nilai_ekskul_produktif = DB::table("tb_nilai_ekskul_produktif")->where('keterangan_nilai_ekskul_produktif_detail',$id)
        ->join('users', function ($join) {
         $join->on('tb_nilai_ekskul_produktif.users_nilai_ekskul_produktif_id', '=', 'users.id')
         ->join('tb_rayon', function ($join) {
             $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
         });
     })->get();
        $ambil = DB::table("tb_nilai_ekskul_produktif")->where('keterangan_nilai_ekskul_produktif_detail',$id)->first();

        $nama_ekskul_produktif = DB::table("tb_ekskul_produktif")->where('id_ekskul_produktif',$ambil->ekskul_produktif_nilai_ekskul_produktif_id)->first();
         return view('instruktur/ekskul_produktif/nilai/lihat_detail_nilai_ekskul_produktif',compact('nama_ekskul_produktif','tb_nilai_ekskul_produktif','ambil'));
    }

    public function nilai_ekskul_produktif_ubah(Request $request)
    {
        $id_nilai_ekskul_produktif = $request->id_nilai_ekskul_produktif;
        $users_nilai_ekskul_produktif_id = $request->users_nilai_ekskul_produktif_id;
        $nilai = DB::table('tb_nilai_ekskul_produktif')->where('id_nilai_ekskul_produktif',$request->id_nilai_ekskul_produktif)
        ->join('users', function ($join) {
            $join->on('tb_nilai_ekskul_produktif.users_nilai_ekskul_produktif_id', '=', 'users.id');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_ekskul_produktif', function ($join) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })->first();
        $nama_ekskul_produktif =  DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$nilai->ekskul_produktif_nilai_ekskul_produktif_id)->first();

        return view('instruktur/ekskul_produktif/nilai/nilai_ekskul_produktif_ubah',compact('nilai','id_nilai_ekskul_produktif','users_nilai_ekskul_produktif_id','nama_ekskul_produktif'));
    }
    public function nilai_ekskul_produktif_ubah_post(Request $request)
    {
        DB::table('tb_nilai_ekskul_produktif')->where('id_nilai_ekskul_produktif',$request->id_nilai_ekskul_produktif)->update([
            'nilai_sikap_ekskul_produktif' => $request->nilai_sikap_ekskul_produktif,
            'nilai_pengetahuan_ekskul_produktif' => $request->nilai_pengetahuan_ekskul_produktif,
        ]);
        $kembali = '/lihat_detail_nilai_ekskul_produktif/'.$request->keterangan;
        $message = 'Nilai berhasil diubah';
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function hapus_nilai_ekskul_produktif($id)
    {
        $ambil = DB::table('tb_keterangan_nilai_ekskul_produktif')->where('id_keterangan_nilai_ekskul_produktif',$id)->first();
        DB::table('tb_keterangan_nilai_ekskul_produktif')->where('id_keterangan_nilai_ekskul_produktif',$id)->delete();
        DB::table('tb_nilai_ekskul_produktif')->where('keterangan_nilai_ekskul_produktif_detail',$ambil->keterangan_nilai_ekskul_produktif)->delete();
        return redirect()->back()->withSuccessMessage('Data berhasil dihapus');
    }

}
