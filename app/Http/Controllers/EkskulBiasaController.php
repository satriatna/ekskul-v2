<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Alert;
use Validator;
use App\Exports\ExportNilaiEkskulBiasa;
use App\Exports\DataEkskulBiasaExport;
use App\Exports\DataEkskulBiasaAlpaExport;
use App\Exports\KehadiranEkskulBiasaExport;
use App\Exports\KehadiranEkskulBiasaPersiswaExport;
use Maatwebsite\Excel\Facades\Excel;


class EkskulBiasaController extends Controller
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
    
    public function ekskul_biasa()
    {
       
        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->get();
        return view('ekskul/ekskul_biasa',compact('ekskul_biasa','instruktur'));
  
    }
    public function ekskul_biasa_store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'nama_ekskul_biasa'=>'required|unique:tb_ekskul_biasa',
            'hari'=>'required',
            'kuota'=>'required',
            'instruktur_ekskul_biasa_id'=>'required',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages('Tidak Boleh Sama')->all()[0])->withInput()->withErrors($validator);;    
        }
        DB::table('tb_ekskul_biasa')->insert([
            'nama_ekskul_biasa'=>$request->nama_ekskul_biasa,
            'hari_ekskul_biasa'=>$request->hari,
            'kuota_ekskul_biasa'=>$request->kuota,
            'sisa_kuota_ekskul_biasa'=>$request->kuota,
            'instruktur_ekskul_biasa_id'=>$request->instruktur_ekskul_biasa_id,
            'deskripsi_kegiatan_ekskul_biasa'=>$request->deskripsi_kegiatan_ekskul_biasa,
        ]);
        
            return redirect()->back()->withSuccessMessage('Data Berhasil Ditambahkan');
        }
    public function ekskul_biasa_hapus($id)
    {
        DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->delete();
      
        return redirect()->back()->withSuccessMessage('Data Berhasil dihapus');
    }

    
    public function detail_ekskul_biasa_siswa($id)
    {
       
        $absen_ekskul_biasa_hadir = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $absen_ekskul_biasa_tak_hadir = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','!=','H')->get();
        $hadir = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $ijin = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','S')->get();
        $alpa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','A')->get();
        $nama_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();

        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->get();
        $siswa = DB::table('users')->where('id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->get();
       
            $pindah = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa','!=',$id)->get();
            return view('ekskul/detail_ekskul_biasa_siswa',compact('ekskul_biasa','siswa','pindah','instruktur','nama_ekskul_biasa','hadir','absen_ekskul_biasa_hadir','absen_ekskul_biasa_tak_hadir','ijin','sakit','alpa'));
         
    }

    public function ekskul_biasa_detail($id,$instruktur_id)
    {
        $pengguna_detail = DB::table('users')->where('id',$instruktur_id)->first();
        $ekskul_biasa_cek = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        // if(Auth::user()->level !='Pengurus')
        // {

        //     if($pengguna_detail->id != Auth::user()->id || $ekskul_biasa_cek->instruktur_ekskul_biasa_id != Auth::user()->id)
        //     {
        //         return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');

        //     }
        // }
        $tb_tgl_absen_ekskul_biasa = DB::table('tb_tgl_absen_ekskul_biasa')->first();
        $alpa = DB::table("users")->where('kehadiran_ekskul_biasa','>',3)->get();
        $nama_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();

        $instruktur = DB::table('users')->where('level','Instruktur')->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->get();
        $siswa = DB::table('users')->where('level','Siswa')->where('ekskul_biasa_id',$id)
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
        $gambar_ekskul_biasa = DB::table('tb_gambar_ekskul_biasa')->where('gambar_ekskul_biasa_id',$id)->get();
        $pindah = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa','!=',$id)->get();
        return view('ekskul/ekskul_biasa_detail',compact('ekskul_biasa','siswa','pindah','instruktur','nama_ekskul_biasa','alpa','tb_tgl_absen_ekskul_biasa','gambar_ekskul_biasa'));
         
    }

    public function ekskul_biasa_update(Request $request)
    { 
        DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->id_ekskul_biasa)->update([
            'nama_ekskul_biasa'=>$request->nama_ekskul_biasa,
            'hari_ekskul_biasa'=>$request->hari_ekskul_biasa,
            'kuota_ekskul_biasa'=>$request->kuota_ekskul_biasa,
            'sisa_kuota_ekskul_biasa'=>$request->sisa_kuota_ekskul_biasa,
            'instruktur_ekskul_biasa_id'=>$request->instruktur_ekskul_biasa_id,
            'deskripsi_kegiatan_ekskul_biasa'=>$request->deskripsi_kegiatan_ekskul_biasa
        ]);
       
            return redirect()->back()->withSuccessMessage('Data Senbud Berhasil Diubah');
    }

    public function data_ekskul_biasa($id)
    {
        $absen_ekskul_biasa = DB::table("tb_absen_ekskul_biasa")->where('ekskul_biasa_id_absen',$id)->get();         
        $alpa = DB::table("users")->where('kehadiran_ekskul_biasa','>',3)->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        $siswa = DB::table('users')->where('ekskul_biasa_id',$id)
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
        return view('instruktur/ekskul_biasa/data_ekskul_biasa',compact('ekskul_biasa','siswa','absen_ekskul_biasa','alpa'));
    }

    public function data_ekskul_biasa_siswa($id,$id2)
    {
        $hadir = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('ekskul_biasa_id_absen',$id2)->where('keterangan_absen_ekskul_biasa','H')->get();
        $ijin = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('ekskul_biasa_id_absen',$id2)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('ekskul_biasa_id_absen',$id2)->where('keterangan_absen_ekskul_biasa','S')->get();
        $alpa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('ekskul_biasa_id_absen',$id2)->where('keterangan_absen_ekskul_biasa','A')->get();
        $ambil_user = DB::table("users")->where('id',$id)->first();
        $ambil_ekskul_biasa = DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa',$id2)->first();
        $ambil_nama = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('ekskul_biasa_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->first();

        $siswa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('ekskul_biasa_id_absen',$id2)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
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
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->get();
        return view('instruktur/ekskul_biasa/data_ekskul_biasa_siswa',compact('siswa','ambil_nama','hadir','ijin','sakit','alpa','ambil_user','ambil_ekskul_biasa'));
    }

    public function data_ekskul_biasa_siswa_ubah(Request $request)
    {
        $ekskul_biasa_id_absen = $request->ekskul_biasa_id_absen;
        $users_absen_ekskul_biasa_id = $request->users_absen_ekskul_biasa_id;
        $siswa = DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->id_absen_ekskul_biasa)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
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
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })->first();
        return view('instruktur/ekskul_biasa/data_ekskul_biasa_siswa_ubah',compact('siswa','ekskul_biasa_id_absen','users_absen_ekskul_biasa_id'));
    }
    
    public function data_ekskul_biasa_siswa_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->id_absen_ekskul_biasa)->first();
        if($cek_alpa->keterangan_absen_ekskul_biasa == 'A')
        {
            if($request->keterangan_absen_ekskul_biasa !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->first();
                $kurangi_alpa = $cek->kehadiran_ekskul_biasa - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->update([
                    'kehadiran_ekskul_biasa'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_ekskul_biasa =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->first();
                $tambah_alpa = $cek->kehadiran_ekskul_biasa + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->update([
                    'kehadiran_ekskul_biasa'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->id_absen_ekskul_biasa)->update([
            'keterangan_absen_ekskul_biasa'=>$request->keterangan_absen_ekskul_biasa
        ]);
        $tgl = $request->tgl_absen_ekskul_biasa_detail;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'data/ekskul_biasa/siswa/'. $request->id_3. '/' . $request->id_2;
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function data_kehadiran_ekskul_biasa_ubah(Request $request)
    {
        $ekskul_biasa_id_absen = $request->ekskul_biasa_id_absen;
        $ambil_tanggal = $request->ambil_tanggal;
        $users_absen_ekskul_biasa_id = $request->users_absen_ekskul_biasa_id;
        $siswa = DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->id_absen_ekskul_biasa)
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
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
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })->first();
        return view('instruktur/ekskul_biasa/data_kehadiran_ekskul_biasa_ubah',compact('siswa','id_absen_ekskul_biasa','ambil_tanggal','users_absen_ekskul_biasa_id'));
    }
    
    public function data_kehadiran_ekskul_biasa_ubah_post(Request $request)
    {
        $cek_alpa = DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->id_absen_ekskul_biasa)->first();
        if($cek_alpa->keterangan_absen_ekskul_biasa == 'A')
        {
            if($request->keterangan_absen_ekskul_biasa !='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->first();
                $kurangi_alpa = $cek->kehadiran_ekskul_biasa - 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->update([
                    'kehadiran_ekskul_biasa'=>$kurangi_alpa
                ]);
            }
        }
        else
        {
            if($request->keterangan_absen_ekskul_biasa =='A')
            {
                $cek = DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->first();
                $tambah_alpa = $cek->kehadiran_ekskul_biasa + 1;
                DB::table('users')->where('id',$cek_alpa->users_absen_ekskul_biasa_id)->update([
                    'kehadiran_ekskul_biasa'=>$tambah_alpa
                ]);
            }
        }
        DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->id_absen_ekskul_biasa)->update([
            'keterangan_absen_ekskul_biasa'=>$request->keterangan_absen_ekskul_biasa
        ]);
        $tgl = $request->tgl;
        $alert = 'Absen pada tanggal'. ' '. $tgl. ' '. 'berhasil diubah';
        $kembali = 'kehadiran/ekskul_biasa/detail/'. $tgl.'/'.$request->ekskul_biasa_id_absen. '/';
        return redirect($kembali)->withSuccessMessage($alert);
    }

    public function input_absen_ekskul_biasa(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa',$gabungan)->where('tgl_absen_ekskul_biasa_id',$request->ekskul_biasa_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_ekskul_biasa > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->first();
        $siswa = DB::table('users')->where('ekskul_biasa_id',$request->ekskul_biasa_id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->get();
        return view('instruktur/ekskul_biasa/input_absen_ekskul_biasa',compact('siswa','ekskul_biasa'));
    }
    public function input_absen_ekskul_biasa_post(Request $request)
         
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa',$gabungan)->where('tgl_absen_ekskul_biasa_id',$request->ekskul_biasa_id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_ekskul_biasa > 0 )
            {
                $kembali = 'data_ekskul_biasa/'. $request->ekskul_biasa_id;
                return redirect($kembali)->withWarningMessage('Absen hari ini telah diisi');
            }
        }

        $date = date('Y-m-d');
        $count = count($request->siswa);
        DB::table("tb_tgl_absen_ekskul_biasa")->insert([
            'tgl_absen_ekskul_biasa'=>$request->tgl_absen_ekskul_biasa,
            'tgl_absen_ekskul_biasa_id'=>$request->ekskul_biasa_id,
        ]);
        
        for($i=0; $i < $count; $i++)
        {
            if($request->keterangan[$i] == 'A')
            {
                
                $cek = DB::table('users')->where('id',$request->siswa[$i])->get();
                foreach($cek as $c)
                {
                    $hitung = $c->kehadiran_ekskul_biasa + 1;
                }
                DB::table('users')->where('id',$request->siswa[$i])->update([
                    'kehadiran_ekskul_biasa'=>$hitung
                ]);
            }
            DB::table('tb_absen_ekskul_biasa')->insert([
                'ekskul_biasa_id_absen'=>$request->ekskul_biasa_id,
                'users_absen_ekskul_biasa_id'=>$request->siswa[$i],
                'tgl_absen_ekskul_biasa_detail'=>$request->tgl_absen_ekskul_biasa,
                'keterangan_absen_ekskul_biasa'=>$request->keterangan[$i]
            ]);
        }
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa', $request->ekskul_biasa_id)->first();
        $kembali = '/ekskul_biasa/detail/'.$ekskul_biasa->id_ekskul_biasa.'/'.$request->instruktur_ekskul_biasa_id;
        $message = 'Berhasil mengisi absen pada tanggal' .' '. $request->tgl_absen_ekskul_biasa;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_ekskul_biasa($id)
    {
        $tgl_absen_ekskul_biasa = DB::table("tb_tgl_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_id',$id)
        ->join('tb_ekskul_biasa', function ($join) use($id) {
            $join->on('tb_tgl_absen_ekskul_biasa.tgl_absen_ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
       ->get();
       $nama_ekskul_biasa = DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa',$id)
       ->first();
        return view('instruktur/ekskul_biasa/kehadiran_ekskul_biasa',compact('tgl_absen_ekskul_biasa','nama_ekskul_biasa'));
    }

    public function kehadiran_ekskul_biasa_hapus($id)
    {
        $ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','A')->get();
        $count = count($ekskul_biasa);
        for($i=0; $i < $count; $i++)
        {   
            foreach($ekskul_biasa as $s)
            {
                $kotak [] = $s->users_absen_ekskul_biasa_id;
            }
            $users = DB::table('users')->where('id',$kotak[$i])->get();
            foreach($users as $u) 
            {
                $kurangi = $u->kehadiran_ekskul_biasa - 1;
                $users = DB::table('users')->where('id',$kotak[$i])->update([
                    'kehadiran_ekskul_biasa'=> $kurangi
                ]);
            }
        }
        
        DB::table("tb_tgl_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa',$id)->delete();
        DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)->delete();
        $message = "Data absensi tanggal". ' '. $id. ' '. "berhasil dihapus";
        return redirect()->back()->withSuccessMessage($message);;

        return view('instruktur/ekskul_biasa/kehadiran_ekskul_biasa',compact('tgl_absen_ekskul_biasa','nama_ekskul_biasa'));
    }
    

    public function kehadiran_ekskul_biasa_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $ijin = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','S')->get();
        $alpa = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','A')->get();
        $nama_ekskul_biasa = DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)
        ->join('tb_ekskul_biasa', function ($join) use($id) {
            $join->on('tb_absen_ekskul_biasa.ekskul_biasa_id_absen', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)->first();
        $absen_ekskul_biasa = DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
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
        return view('instruktur/ekskul_biasa/kehadiran_ekskul_biasa_detail',compact('absen_ekskul_biasa','ambil_tanggal','nama_ekskul_biasa','hadir','ijin','sakit','alpa'));
    }

    public function keterangan_kehadiran_update(Request $request)
    {
        DB::table('tb_absen_ekskul_biasa')->where('id_absen_ekskul_biasa',$request->modal_input_id)->update([
            'tgl_absen_ekskul_biasa_detail'=>$request->modal_input_keterangan_absen_ekskul_biasa
        ]);
        return redirect()->back()->withSuccessMessage('Data Berhasil Diubah');

    }

    public function filter_ekskul_biasa_alpa(Request $request)
    {
        $nama_ekskul_biasa = DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa',$request->id_ekskul_biasa)->first();
        $jumlah = DB::table('users')->where('ekskul_biasa_id',$request->id_ekskul_biasa)->where('kehadiran_ekskul_biasa', '>','3')->get();
        $siswa = DB::table('users')->where('ekskul_biasa_id',$request->id_ekskul_biasa)->where('kehadiran_ekskul_biasa', '>','3')
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
        return view('instruktur/ekskul_biasa/siswa_ekskul_biasa_alpa',compact('nama_ekskul_biasa','siswa','jumlah'));
        
    }
    public function export_data_ekskul_biasa($id)
    {
        $nama_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        $nama_file = 'Data Ekskul Biasa'. ' '. $nama_ekskul_biasa->nama_ekskul_biasa. ' '. '.xlsx';
        return Excel::download(new DataEkskulBiasaExport($id), $nama_file);
    }
    public function export_data_ekskul_biasa_alpa($id)
    {
        $nama_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        $nama_file = 'Data kehadiran Ekskul Biasa'. ' '. $nama_ekskul_biasa->nama_ekskul_biasa. ' '. 'siswa alpa > 3.xlsx';
        return Excel::download(new DataEkskulBiasaAlpaExport($id), $nama_file);
    }
    public function export_kehadiran_ekskul_biasa($id,$id2)
    {
        $nama_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id2)->first();
        $nama_file = 'Data kehadiran Ekskul Biasa'. ' '. $nama_ekskul_biasa->nama_ekskul_biasa. ' '. 'tanggal'. ' '. $id. '.xlsx';
        return Excel::download(new KehadiranEkskulBiasaExport($id), $nama_file);
    }
    public function export_kehadiran_ekskul_biasa_persiswa($id)
    {
        $nama_siswa = DB::table('users')->where('id',$id)->first();
        $nama_file = 'Data kehadiran Ekskul Biasa'. ' '. $nama_siswa->nama.'.xlsx';
        return Excel::download(new KehadiranEkskulBiasaPersiswaExport($id), $nama_file);
    }
    public function export_nilai_ekskul_biasa($id)
    {
        $nama_ekskul_biasa = DB::table('tb_nilai_ekskul_biasa')->where('keterangan_nilai_ekskul_biasa_detail',$id)
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('tb_nilai_ekskul_biasa.ekskul_biasa_nilai_ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })->first();
        $nama_file = 'Data nilai siswa ekskul biasa'. ' '. $nama_ekskul_biasa->nama_ekskul_biasa.' '. 'keterangan : '.$nama_ekskul_biasa->keterangan_nilai_ekskul_biasa_detail.'.xlsx';
        return Excel::download(new ExportNilaiEkskulBiasa($id), $nama_file);
    }

    public function upload_ekskul_biasa_foto(Request $request)
    {
        $cekfoto_ekskul_biasa = Validator::make($request->all(), [
            'foto_ekskul_biasa' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cekfoto_ekskul_biasa->fails()) {
            return redirect()->back()->withErrorMessage('Gagal upload gambar, file harus berbentuk jpg');
        }

        $foto_ekskul_biasa = $request->file('foto_ekskul_biasa');
        $size = $foto_ekskul_biasa->getSize();
        $nama_foto_ekskul_biasa = time() . "_" . $foto_ekskul_biasa->getClientOriginalName();
        $tujuan_upload_foto_ekskul_biasa = 'assets/img/database';
        $foto_ekskul_biasa->move($tujuan_upload_foto_ekskul_biasa, $nama_foto_ekskul_biasa);

     
        $isi = DB::table("tb_gambar_ekskul_biasa")->insert([
            'gambar_ekskul_biasa_id' => $request->foto_ekskul_biasa_id,
            'gambar_nama_ekskul_biasa' => $nama_foto_ekskul_biasa,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil di upload');

    }

    public function ubah_foto_ekskul_biasa(Request $request)
    {
        $cek_foto_ekskul_biasa = Validator::make($request->all(), [
            'foto_ekskul_biasa' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cek_foto_ekskul_biasa->fails()) {
            return redirect()->back()->withErrorMessage('Gagal ubah gambar, file harus berbentuk jpg');
        }

        $foto_ekskul_biasa = $request->file('foto_ekskul_biasa');
        $size = $foto_ekskul_biasa->getSize();
        $nama_foto_ekskul_biasa = time() . "_" . $foto_ekskul_biasa->getClientOriginalName();
        $tujuan_upload_foto_ekskul_biasa = 'assets/img/database';
        $foto_ekskul_biasa->move($tujuan_upload_foto_ekskul_biasa, $nama_foto_ekskul_biasa);

     
        DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa',$request->id_ekskul_biasa)->update([
            'foto_ekskul_biasa' => $nama_foto_ekskul_biasa,
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil diubah');
    }

    public function gambar_ekskul_biasa_hapus($id)
    {
        DB::table("tb_gambar_ekskul_biasa")->where('id_gambar_ekskul_biasa',$id)->delete();
        return redirect()->back()->withSuccessMessage('Gambar berhasil dihapus');

    }

  

    public function input_absen_instruktur_ekskul_biasa(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_ekskul_biasa')->where('tgl_absen_instruktur_ekskul_biasa_detail',$gabungan)->where('ekskul_biasa_absen_instruktur_id',$request->ekskul_biasa_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
      
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)
        ->join('users', function ($join) {
            $join->on('tb_ekskul_biasa.instruktur_ekskul_biasa_id', '=', 'users.id');
        })->first();
        return view('piket/instruktur/ekskul_biasa/input_absen_instruktur_ekskul_biasa',compact('ekskul_biasa'));
    }

    public function input_absen_instruktur_ekskul_biasa_post(Request $request)
    { 
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_absen_instruktur_ekskul_biasa')->where('tgl_absen_instruktur_ekskul_biasa_detail',$gabungan)->where('ekskul_biasa_absen_instruktur_id',$request->ekskul_biasa_id)->first();
        if($cek !='')
        {
            return redirect()->back()->withWarningMessage('Absen Instruktur hari ini telah diisi');
        }
        DB::table('tb_absen_instruktur_ekskul_biasa')->insert([
            'instruktur_absen_ekskul_biasa_id' => $request->instruktur_ekskul_biasa_id,
            'ekskul_biasa_absen_instruktur_id' => $request->ekskul_biasa_id,
            'tgl_absen_instruktur_ekskul_biasa_detail' => $request->tgl_absen_instruktur_ekskul_biasa,
            'keterangan_absen_instruktur_ekskul_biasa' => $request->keterangan,
        ]);
        
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa', $request->ekskul_biasa_id)->first();
        $kembali = '/ekskul_biasa/detail/'.$ekskul_biasa->id_ekskul_biasa.'/'.$request->instruktur_ekskul_biasa_id;
        $message = 'Instruktur berhasil diabsen pada tanggal' .' '. $request->tgl_absen_ekskul_biasa;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    public function kehadiran_instruktur_ekskul_biasa($id)
    {
        
       $nama_instruktur = DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa',$id)
       ->join('users', function ($join) {
           $join->on('tb_ekskul_biasa.instruktur_ekskul_biasa_id', '=', 'users.id');
       })->first();
       $kehadiran = DB::table("tb_absen_instruktur_ekskul_biasa")->where('instruktur_absen_ekskul_biasa_id',$nama_instruktur->id)->get();
        return view('piket/instruktur/ekskul_biasa/kehadiran_instruktur_ekskul_biasa',compact('kehadiran','nama_instruktur'));
    }

    public function data_kehadiran_instruktur_ekskul_biasa_hapus($id)
    {
        $ambil = DB::table('tb_absen_instruktur_ekskul_biasa')->where('id_absen_instruktur_ekskul_biasa',$id)->first();
        $message = "Data absensi Instruktur pada tanggal". ' '. $ambil->tgl_absen_instruktur_ekskul_biasa_detail. ' '. "berhasil dihapus";
        $ambil = DB::table('tb_absen_instruktur_ekskul_biasa')->where('id_absen_instruktur_ekskul_biasa',$id)->delete();
        return redirect()->back()->withSuccessMessage($message);;
    }
    

    public function kehadiran_instruktur_ekskul_biasa_detail($id,$id2)
    {
        $hadir = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $ijin = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','S')->get();
        $alpa = DB::table('tb_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa_detail',$id)->where('keterangan_absen_ekskul_biasa','A')->get();
        $nama_ekskul_biasa = DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)
        ->join('tb_ekskul_biasa', function ($join) use($id) {
            $join->on('tb_absen_ekskul_biasa.ekskul_biasa_id_absen', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
       ->first();
        $ambil_tanggal = DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)->first();
        $absen_ekskul_biasa = DB::table("tb_absen_ekskul_biasa")->where('tgl_absen_ekskul_biasa_detail',$id)
        ->join('users', function ($join) use($id) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
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
        return view('piket/instruktur/ekskul_biasa/kehadiran_ekskul_biasa_detail',compact('absen_ekskul_biasa','ambil_tanggal','nama_ekskul_biasa','hadir','ijin','sakit','alpa'));
    }

    public function data_kehadiran_instruktur_ekskul_biasa_ubah($id)
    {
        $instruktur = DB::table('tb_absen_instruktur_ekskul_biasa')->where('id_absen_instruktur_ekskul_biasa',$id)
        ->join('users', function ($join) {
            $join->on('tb_absen_instruktur_ekskul_biasa.instruktur_absen_ekskul_biasa_id', '=', 'users.id');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('tb_absen_instruktur_ekskul_biasa.ekskul_biasa_absen_instruktur_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->first();
        return view('piket/instruktur/ekskul_biasa/data_kehadiran_instruktur_ekskul_biasa_ubah',compact('instruktur'));
    }

    public function data_kehadiran_instruktur_ekskul_biasa_ubah_post(Request $request)
    {
        DB::table('tb_absen_instruktur_ekskul_biasa')->where('id_absen_instruktur_ekskul_biasa',$request->id_absen_instruktur_ekskul_biasa)->update([
            'keterangan_absen_instruktur_ekskul_biasa'=>$request->keterangan_absen_instruktur_ekskul_biasa
        ]);
        $ambil = DB::table('tb_absen_instruktur_ekskul_biasa')->where('id_absen_instruktur_ekskul_biasa',$request->id_absen_instruktur_ekskul_biasa)->first();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa', $ambil->ekskul_biasa_absen_instruktur_id)->first();
        $kembali = '/kehadiran_instruktur_ekskul_biasa/'.$ekskul_biasa->id_ekskul_biasa;
        $message = 'Absen Instruktur berhasil diubah pada tanggal' .' '. $ambil->tgl_absen_instruktur_ekskul_biasa_detail;
        return redirect($kembali)->withSuccessMessage($message);;
    }

    
    public function input_nilai_ekskul_biasa($id)
    {
        $gabungan = date('Y-m-d');
 
        $cek = DB::table('tb_tgl_absen_ekskul_biasa')->where('tgl_absen_ekskul_biasa',$gabungan)->where('tgl_absen_ekskul_biasa_id',$id)->get();
        foreach($cek as $c)
        {
            if($c->tgl_absen_ekskul_biasa > 0 )
            {
                return redirect()->back()->withWarningMessage('Absen hari ini telah diisi');
            }
        }
      
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        $siswa = DB::table('users')->where('ekskul_biasa_id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->get();

        return view('instruktur/ekskul_biasa/nilai/input_nilai_ekskul_biasa',compact('siswa','ekskul_biasa'));
    }
    public function input_nilai_ekskul_biasa_post(Request $request)
    {
        $cek = DB::table('tb_keterangan_nilai_ekskul_biasa')->where('keterangan_nilai_ekskul_biasa', $request->keterangan_nilai_ekskul_biasa)->get();
        $count = count($cek);
        if($count != 0)
        {
            return redirect()->back()->withErrorMessage('Gagal, keterangan nilai tersebut sudah ada');;;

        }
        $tgl = date('Y-m-d');
        DB::table('tb_keterangan_nilai_ekskul_biasa')->insert([
            'keterangan_nilai_ekskul_biasa_id'=>$request->ekskul_biasa_id,
            'keterangan_nilai_ekskul_biasa'=>$request->keterangan_nilai_ekskul_biasa,
            'tgl_nilai_ekskul_biasa'=>$tgl,
        ]);

        $count = count($request->siswa);
        for($i=0; $i < $count; $i++)
        {
            DB::table('tb_nilai_ekskul_biasa')->insert([
                'users_nilai_ekskul_biasa_id'=>$request->siswa[$i],
                'ekskul_biasa_nilai_ekskul_biasa_id'=>$request->ekskul_biasa_id,
                'nilai_pengetahuan_ekskul_biasa'=>$request->pengetahuan[$i],
                'nilai_sikap_ekskul_biasa'=>$request->sikap[$i],
                'keterangan_nilai_ekskul_biasa_detail'=>$request->keterangan_nilai_ekskul_biasa
            ]);
        }
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa', $request->ekskul_biasa_id)->first();
        $kembali = '/ekskul_biasa/detail/'.$ekskul_biasa->id_ekskul_biasa.'/'.$request->instruktur_ekskul_biasa_id;
        $message = 'Berhasil input nilai' .' '. $request->tgl_absen_ekskul_biasa;
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function lihat_nilai_ekskul_biasa($id)
    {
       $tb_keterangan_nilai_ekskul_biasa = DB::table("tb_keterangan_nilai_ekskul_biasa")
       ->join('tb_ekskul_biasa', function ($join) {
        $join->on('tb_keterangan_nilai_ekskul_biasa.keterangan_nilai_ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })->get();
       $nama_ekskul_biasa = DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa', $id)->first();
        return view('instruktur/ekskul_biasa/nilai/lihat_nilai_ekskul_biasa',compact('nama_ekskul_biasa','tb_keterangan_nilai_ekskul_biasa'));
    }
    public function lihat_detail_nilai_ekskul_biasa($id)
    {
        $tb_nilai_ekskul_biasa = DB::table("tb_nilai_ekskul_biasa")->where('keterangan_nilai_ekskul_biasa_detail',$id)
        ->join('users', function ($join) {
         $join->on('tb_nilai_ekskul_biasa.users_nilai_ekskul_biasa_id', '=', 'users.id')
         ->join('tb_rayon', function ($join) {
             $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
         });
     })->get();
        $ambil = DB::table("tb_nilai_ekskul_biasa")->where('keterangan_nilai_ekskul_biasa_detail',$id)->first();

        $nama_ekskul_biasa = DB::table("tb_ekskul_biasa")->where('id_ekskul_biasa',$ambil->ekskul_biasa_nilai_ekskul_biasa_id)->first();
         return view('instruktur/ekskul_biasa/nilai/lihat_detail_nilai_ekskul_biasa',compact('nama_ekskul_biasa','tb_nilai_ekskul_biasa','ambil'));
    }

    public function nilai_ekskul_biasa_ubah(Request $request)
    {
        $id_nilai_ekskul_biasa = $request->id_nilai_ekskul_biasa;
        $users_nilai_ekskul_biasa_id = $request->users_nilai_ekskul_biasa_id;
        $nilai = DB::table('tb_nilai_ekskul_biasa')->where('id_nilai_ekskul_biasa',$request->id_nilai_ekskul_biasa)
        ->join('users', function ($join) {
            $join->on('tb_nilai_ekskul_biasa.users_nilai_ekskul_biasa_id', '=', 'users.id');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })->first();
        $nama_ekskul_biasa =  DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$nilai->ekskul_biasa_nilai_ekskul_biasa_id)->first();

        return view('instruktur/ekskul_biasa/nilai/nilai_ekskul_biasa_ubah',compact('nilai','id_nilai_ekskul_biasa','users_nilai_ekskul_biasa_id','nama_ekskul_biasa'));
    }
    public function nilai_ekskul_biasa_ubah_post(Request $request)
    {
        DB::table('tb_nilai_ekskul_biasa')->where('id_nilai_ekskul_biasa',$request->id_nilai_ekskul_biasa)->update([
            'nilai_sikap_ekskul_biasa' => $request->nilai_sikap_ekskul_biasa,
            'nilai_pengetahuan_ekskul_biasa' => $request->nilai_pengetahuan_ekskul_biasa,
        ]);
        $kembali = '/lihat_detail_nilai_ekskul_biasa/'.$request->keterangan;
        $message = 'Nilai berhasil diubah';
        return redirect($kembali)->withSuccessMessage($message);;
    }
    public function hapus_nilai_ekskul_biasa($id)
    {
        $ambil = DB::table('tb_keterangan_nilai_ekskul_biasa')->where('id_keterangan_nilai_ekskul_biasa',$id)->first();
        DB::table('tb_keterangan_nilai_ekskul_biasa')->where('id_keterangan_nilai_ekskul_biasa',$id)->delete();
        DB::table('tb_nilai_ekskul_biasa')->where('keterangan_nilai_ekskul_biasa_detail',$ambil->keterangan_nilai_ekskul_biasa)->delete();
        return redirect()->back()->withSuccessMessage('Data berhasil dihapus');
    }

}
