<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Alert;
use Validator;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
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
    }
    public function pengguna_hapus($id)
    {
       $cek = DB::table('users')->where('id',$id)->first();
       if($cek->status == 'aktif')
       {
            DB::table('users')->where('id',$id)->update([
                'status'=>'non-aktif'
            ]);
            return redirect()->back()->withSuccessMessage('Pengguna berhasil di non-aktifkan');
       }
       else
       {
            DB::table('users')->where('id',$id)->update([
                'status'=>'aktif'
            ]);
            return redirect()->back()->withSuccessMessage('Pengguna berhasil di aktifkan');
       }
    }
    // public function pengguna_hapus1($id)
    // {
    //     DB::table('users')->where('id',$id)->delete();
    //     DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->delete();
    //     DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->delete();
    //     DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->delete();
    //     DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->delete();
    //     return redirect()->back()->withSuccessMessage('Pengguna berhasil dihapus');

    // }
    public function DaftarKanpengurusPOST(Request $request)
    {
         User::create([
            'nama' => $request['nama'],
            'username' => $request['username'],
            'email' => $request['email'],
            'level' => 'Pengurus',
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->back()->withSuccessMessage('User Pengurus berhasil ditambahkan');
    }
    public function DaftarKanpiketPOST(Request $request)
    {
         User::create([
            'nama' => $request['nama'],
            'username' => $request['username'],
            'email' => $request['email'],
            'level' => 'Piket',
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->back()->withSuccessMessage('User Piket berhasil ditambahkan');
    }

    public function instruktur()
    {

        $instruktur = DB::table('users')->where('level','instruktur')
        ->get();
        return view('pengguna/instruktur/instruktur',compact('instruktur'));
    }
      
    public function piket()
    {
        $piket = DB::table('users')->where('level','piket')->get();
        return view('pengguna/piket/piket',compact('piket'));
    }
      
    public function pengurus()
    {
      
        $pengurus = DB::table('users')->where('level','Pengurus')->get();
       
        return view('pengguna/pengurus',compact('pengurus'));
    }

    public function tambah_instruktur_post(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'max:255','unique:users'],
            'nama' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);
        
        // save into table 
        $user = User::create([
            'username'=>$request->username,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'level'=>'instruktur',
            'password'=>bcrypt($request->password),
        ]);
        return redirect()->back()->withSuccessMessage('Instruktur Berhasil Ditambahkan');
    }

  
    
    public function siswa()
    {
        $rombel = DB::table('tb_rombel')->where('status_rombel','aktif')->get();
        $rayon = DB::table('tb_rayon')->where('status_rayon','aktif')->get();
        $jurusan = DB::table('tb_jurusan')->where('status_jurusan','aktif')->get();
        
        $siswa = DB::table('users')->where('level','siswa')
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })->get();
        return view('pengguna/siswa',compact('siswa','rombel','rayon','jurusan'));
    }
     
    public function tambah_siswa_post(Request $request)
    {
        $cek = $this->validate($request, [
            'nis' => ['required','min:8', 'max:255','unique:users'],
            'nama' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'rombel_id' => ['required'],
            'rayon_id' => ['required'],
            'jurusan_id' => ['required'],
            'jk' => ['required'],
            'kelas' => ['required'],

        ]);
            User::create([
            'nis'=>$request->nis,
            'nama'=>$request->nama,
            'username'=>$request->nis,
            'email'=>$request->email,
            'kelas'=>$request->kelas,
            'rombel_id' => $request->rombel_id,
            'rayon_id' => $request->rayon_id,
            'jurusan_id' => $request->jurusan_id,
            'password' => Hash::make($request['nis']),
            'jk'=>$request->jk,
            'level'=>'siswa',
            'tgl_pilih'=> date('Y-m-d'),
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Ditambahkan');
    }
    public function siswa_detail($id)
    {
        if(Auth::user()->level !='Pengurus')
        {
            $pengguna_detail = DB::table('users')->where('id',$id)->first();

            if($pengguna_detail->id != Auth::user()->id)
            {
                return redirect()->back()->withWarningMessage('Anda Tidak Memiliki Hak Akses ke Halaman Ini');

            }
        }
        $rombel = DB::table('tb_rombel')->get();
        $senbud = DB::table('tb_senbud')->get();
        $rayon = DB::table('tb_rayon')->get();
        $jurusan = DB::table('tb_jurusan')->get();
        $pengguna_detail = DB::table('users')->where('id',$id)
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })->first();

        $pengguna = DB::table('users')->where('id',$id)
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
        return view('pengguna/detail2',compact('pengguna_detail','pengguna','rombel','rayon','jurusan','senbud'));
    }
    public function user_detail($id)
    {
        
        $rombel = DB::table('tb_rombel')->get();
        $senbud = DB::table('tb_senbud')->get();
        $upd = DB::table('tb_upd')->get();
        $rayon = DB::table('tb_rayon')->get();
        $jurusan = DB::table('tb_jurusan')->get();
        $user_detail = DB::table('users')->where('id',$id)->first();

        $user = DB::table('users')->where('id',$id)->get();
        return view('pengguna/user_detail',compact('user_detail','user','rombel','rayon','jurusan','senbud','upd'));
    }
    public function pengguna_data_pribadi_update(Request $request)
    { 
        $cek_nis = DB::table('users')->where('id',$request->id)->first();
        if($cek_nis!='')
        {
            if($cek_nis->nis == $request->nis)
            {
                DB::table('users')->where('id',$request->id)->update([
                    'nama'=>$request->nama,
                    'rombel_id'=>$request->rombel,
                    'rayon_id'=>$request->rayon,
                    'jurusan_id'=>$request->jurusan,
                    'kelas'=>$request->kelas,
                    'jk'=>$request->jk
                ]);
                
                return redirect()->back()->withSuccessMessage('Data berhasil diubah');
            }
            else
            {
                $validator = Validator::make($request->all(),[
                    'nis'=>'required|min:8',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrorMessage('Panjang NIS minimal 8 digit');    
                }
                $validator2 = Validator::make($request->all(),[
                    'nis'=>'required|unique:users',
                ]);
                if($validator2->fails()){
                    return redirect()->back()->withErrorMessage('NIS sudah digunakan');    
                }
                DB::table('users')->where('id',$request->id)->update([
                    'nis'=>$request->nis,
                    'nama'=>$request->nama,
                    'rombel_id'=>$request->rombel,
                    'rayon_id'=>$request->rayon,
                    'jurusan_id'=>$request->jurusan,
                    'kelas'=>$request->kelas,
                    'jk'=>$request->jk
                ]);
                return redirect()->back()->withSuccessMessage('Data berhasil diubah');
            }
        }
        else
        {
            $validator = Validator::make($request->all(),[
                'nis'=>'required|unique:users',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrorMessage('NIS sudah digunakan');    
            }
            DB::table('users')->where('id',$request->id)->update([
                'nis'=>$request->nis,
                'nama'=>$request->nama,
                'rombel_id'=>$request->rombel,
                'rayon_id'=>$request->rayon,
                'jurusan_id'=>$request->jurusan,
                'kelas'=>$request->kelas,
                'jk'=>$request->jk
            ]);
            return redirect()->back()->withSuccessMessage('Data berhasil diubah');
        }
       
    }

    public function pengguna_akun_update(Request $request)
    { 
        $cek_nis = DB::table('users')->where('id',$request->id)->first();
        if($cek_nis!='')
        {
            if($cek_nis->username == $request->username)
            {
                return redirect()->back()->withSuccessMessage('Data berhasil diubah');
            }
            else
            {
                $validator = Validator::make($request->all(),[
                    'username'=>'required|unique:users',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrorMessage('Username sudah digunakan');    
                }
                DB::table('users')->where('id',$request->id)->update([
                    'username'=>$request->username,
                ]);
                return redirect()->back()->withSuccessMessage('Data berhasil diubah');
            }
        }
        else
        {
            $validator = Validator::make($request->all(),[
                'username'=>'required|unique:users',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrorMessage('Username sudah digunakan');    
            }
            DB::table('users')->where('id',$request->id)->update([
                'username'=>$request->username,
            ]);
            return redirect()->back()->withSuccessMessage('Data berhasil diubah');
        }
       
    }

    public function instruktur_data_pribadi_update(Request $request)
    { 
    
            DB::table('users')->where('id',$request->id)->update([
                'nama'=>$request->nama,
                'jk'=>$request->jk,
            ]);
            return redirect()->back()->withSuccessMessage('Data berhasil diubah');
       
    }

    
    public function instruktur_akun_update(Request $request)
    { 
        $cek_nis = DB::table('users')->where('id',$request->id)->first();
        if($cek_nis!='')
        {
            if($cek_nis->username == $request->username)
            {
                return redirect()->back()->withSuccessMessage('Data berhasil diubah');
            }
            else
            {
                $validator = Validator::make($request->all(),[
                    'username'=>'required|unique:users',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrorMessage('Username sudah digunakan');    
                }
                DB::table('users')->where('id',$request->id)->update([
                    'username'=>$request->username,
                ]);
                return redirect()->back()->withSuccessMessage('Data berhasil diubah');
            }
        }
        else
        {
            $validator = Validator::make($request->all(),[
                'username'=>'required|unique:users',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrorMessage('Username sudah digunakan');    
            }
            DB::table('users')->where('id',$request->id)->update([
                'username'=>$request->username,
            ]);
            return redirect()->back()->withSuccessMessage('Data berhasil diubah');
        }
       
    }


    // Akhir Jurusan Controller =======================================================================

    
    public function pengguna_nonaktif()
    {
        $nonaktif = DB::table('users')->where('status','non-aktif')->get();
        return view('pengguna/non_aktif',compact('nonaktif'));
    }


    public function ubah_nonaktif($id)
    {
        alert()->question('Are you sure?','You won\'t be able to revert this!')
        ->showConfirmButton('Yes! Delete it', '#3085d6')
        ->showCancelButton('Cancel', '#aaa')->reverseButtons();
        $ekskul = DB::table('users')->where('id',$id)->update([
            'status'=>'non-aktif'
        ]);
        return redirect()->back()->withSuccessMessage("Pengguna Berhasil Di Non-Aktifkan");
    }

    public function ubah_aktif($id)
    {
        $ekskul = DB::table('users')->where('id',$id)->update([
            'status'=>'aktif'
        ]);
      
        return redirect()->back()->withSuccessMessage("Pengguna Berhasil Di Aktifkan");
    }
    
    // =============================================================================================================================================
    public function pengguna_detail($id)
    {
        if(Auth::user()->level !='Pengurus')
        {
            if(Auth::user()->id != $id)
            {
                return redirect()->back()->withWarningMessage("Anda tidak memiliki hak akses ke halaman ini ");
            }
        }
        $rombel = DB::table('tb_rombel')->get();
        $senbud = DB::table('tb_senbud')->get();
        $rayon = DB::table('tb_rayon')->get();
        $jurusan = DB::table('tb_jurusan')->get();

        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',$id)->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('instruktur_ekskul_biasa_id',$id)->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('instruktur_ekskul_produktif_id',$id)->get();
        $keputrian = DB::table('tb_keputrian')->where('instruktur_keputrian_id',$id)->get();
        $pengguna_detail = DB::table('users')->where('id',$id)->first();
        $pengguna = DB::table('users')->where('id',$id)
        ->get();
        return view('pengguna/detail',compact('pengguna_detail','pengguna','senbud','ekskul_biasa',
        'ekskul_produktif','keputrian','rombel','rayon','jurusan'));
    }
 
    public function siswa_senbud_hapus($id,$senbud_id)
    {
        $senbud = DB::table('tb_senbud')->where('id_senbud',$senbud_id)->get();
       
            DB::table('users')->where('id',$id)->update([
                'senbud_id'=>0
            ]);
            $info = 'Siswa Berhasil Dihapus dari Senbud';
            return redirect()->back()->withSuccessMessage($info);
          
    }

    public function instruktur_kehadiran($id)
    {
        $nama_instruktur = DB::table('tb_senbud')->where('instruktur_senbud_id',$id)
        ->join('users', function ($join) {
                $join->on('tb_senbud.instruktur_senbud_id', '=', 'users.id');
        })->first();

        if($nama_instruktur == '')
        {
            return redirect()->back()->withWarningMessage('instruktur tersebut belum mempunyai data kehadiran');
        }
        $senbud = DB::table('tb_senbud')->where('instruktur_senbud_id',$id)->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('instruktur_ekskul_biasa_id',$id)->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('instruktur_ekskul_produktif_id',$id)->get();
        $keputrian = DB::table('tb_keputrian')->where('instruktur_keputrian_id',$id)->get();
        return view('pengguna/instruktur/instruktur_kehadiran',compact('nama_instruktur','senbud','ekskul_biasa','ekskul_produktif','keputrian'));
    }
    public function instruktur_kehadiran_senbud($id,$id2)
    {
        $instruktur = DB::table('users')->where('id',$id2)->first();
        $senbud = DB::table('tb_senbud')->where('id_senbud',$id)->first();
        $hadir = DB::table('tb_absen_instruktur_senbud')->where('instruktur_absen_senbud_id',$id2)->where('keterangan_absen_instruktur_senbud','H')->get();
        $ijin = DB::table('tb_absen_instruktur_senbud')->where('instruktur_absen_senbud_id',$id2)->where('keterangan_absen_instruktur_senbud','I')->get();
        $sakit = DB::table('tb_absen_instruktur_senbud')->where('instruktur_absen_senbud_id',$id2)->where('keterangan_absen_instruktur_senbud','S')->get();
        $alpa = DB::table('tb_absen_instruktur_senbud')->where('instruktur_absen_senbud_id',$id2)->where('keterangan_absen_instruktur_senbud','A')->get();
        return view('pengguna/instruktur/senbud/instruktur_kehadiran_senbud',compact('instruktur','senbud','hadir','ijin','sakit','alpa'));

    }

    public function instruktur_kehadiran_ekskul_biasa($id,$id2)
    {
        $instruktur = DB::table('users')->where('id',$id2)->first();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$id)->first();
        $hadir = DB::table('tb_absen_instruktur_ekskul_biasa')->where('instruktur_absen_ekskul_biasa_id',$id2)->where('keterangan_absen_instruktur_ekskul_biasa','H')->get();
        $ijin = DB::table('tb_absen_instruktur_ekskul_biasa')->where('instruktur_absen_ekskul_biasa_id',$id2)->where('keterangan_absen_instruktur_ekskul_biasa','I')->get();
        $sakit = DB::table('tb_absen_instruktur_ekskul_biasa')->where('instruktur_absen_ekskul_biasa_id',$id2)->where('keterangan_absen_instruktur_ekskul_biasa','S')->get();
        $alpa = DB::table('tb_absen_instruktur_ekskul_biasa')->where('instruktur_absen_ekskul_biasa_id',$id2)->where('keterangan_absen_instruktur_ekskul_biasa','A')->get();
        return view('pengguna/instruktur/ekskul_biasa/instruktur_kehadiran_ekskul_biasa',compact('instruktur','ekskul_biasa','hadir','ijin','sakit','alpa'));
    }

    public function instruktur_kehadiran_ekskul_produktif($id,$id2)
    {
        $instruktur = DB::table('users')->where('id',$id2)->first();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$id)->first();
        $hadir = DB::table('tb_absen_instruktur_ekskul_produktif')->where('instruktur_absen_ekskul_produktif_id',$id2)->where('keterangan_absen_instruktur_ekskul_produktif','H')->get();
        $ijin = DB::table('tb_absen_instruktur_ekskul_produktif')->where('instruktur_absen_ekskul_produktif_id',$id2)->where('keterangan_absen_instruktur_ekskul_produktif','I')->get();
        $sakit = DB::table('tb_absen_instruktur_ekskul_produktif')->where('instruktur_absen_ekskul_produktif_id',$id2)->where('keterangan_absen_instruktur_ekskul_produktif','S')->get();
        $alpa = DB::table('tb_absen_instruktur_ekskul_produktif')->where('instruktur_absen_ekskul_produktif_id',$id2)->where('keterangan_absen_instruktur_ekskul_produktif','A')->get();
        return view('pengguna/instruktur/ekskul_produktif/instruktur_kehadiran_ekskul_produktif',compact('instruktur','ekskul_produktif','hadir','ijin','sakit','alpa'));
    }

    public function instruktur_kehadiran_keputrian($id,$id2)
    {
        $instruktur = DB::table('users')->where('id',$id2)->first();
        $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$id)->first();
        $hadir = DB::table('tb_absen_instruktur_keputrian')->where('instruktur_absen_keputrian_id',$id2)->where('keterangan_absen_instruktur_keputrian','H')->get();
        $ijin = DB::table('tb_absen_instruktur_keputrian')->where('instruktur_absen_keputrian_id',$id2)->where('keterangan_absen_instruktur_keputrian','I')->get();
        $sakit = DB::table('tb_absen_instruktur_keputrian')->where('instruktur_absen_keputrian_id',$id2)->where('keterangan_absen_instruktur_keputrian','S')->get();
        $alpa = DB::table('tb_absen_instruktur_keputrian')->where('instruktur_absen_keputrian_id',$id2)->where('keterangan_absen_instruktur_keputrian','A')->get();
        return view('pengguna/instruktur/keputrian/instruktur_kehadiran_keputrian',compact('instruktur','keputrian','hadir','ijin','sakit','alpa'));

    }

    public function foto_pengguna_ubah(Request $request)
    {
        $cekfoto = Validator::make($request->all(), [
            'foto' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($cekfoto->fails()) {
            return redirect()->back()->withErrorMessage('Gagal upload gambar, file harus berbentuk jpg');
        }

        $foto = $request->file('foto');
        $size = $foto->getSize();
        $nama_foto = time() . "_" . $foto->getClientOriginalName();
        $tujuan_upload_foto = 'assets/img/database';
        $foto->move($tujuan_upload_foto, $nama_foto);

     
        $isi = DB::table("users")->where('id',$request->id)->update([
            'foto' => $nama_foto
        ]);
        return redirect()->back()->withSuccessMessage('Gambar berhasil di ubah');
    }
}
