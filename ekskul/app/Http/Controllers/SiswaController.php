<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Artisan;
use Alert;
use Validator;

class SiswaController extends Controller
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
        $this->middleware('hanya_siswa');
    }
    public function dashboard_siswa()
    {
        $hadir_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','H')->get();
        $ijin_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','I')->get();
        $sakit_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','S')->get();
        $alpa_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','A')->get();

        $hadir_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $ijin_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','S')->get();
        $alpa_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','A')->get();
        
        $hadir_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $ijin_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','S')->get();
        $alpa_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','A')->get();
        
        $hadir_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','H')->get();
        $ijin_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','I')->get();
        $sakit_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','S')->get();
        $alpa_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','A')->get();

        $senbud = DB::table('tb_senbud')->where('kuota_senbud','>','0')->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('kuota_ekskul_produktif','>','0')->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('kuota_ekskul_biasa','>','0')->get();
        $keputrian = DB::table('tb_keputrian')->where('kuota_keputrian','>','0')->get();
        
        if(Auth::user()->level == "Siswa" && Auth::user()->cek_pilihan=="belum")
        {

            $siswa = DB::table('users')->where('id',Auth::user()->id)
            ->join('tb_jurusan', function ($join) {
                $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
            })
            ->join('tb_rombel', function ($join) {
                $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
            })
            ->join('tb_rayon', function ($join) {
                $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
            })->get();
            
            return view('siswa/dashboard_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        if(Auth::user()->level == "Siswa" && Auth::user()->cek_pilihan=="sudah" && Auth::user()->jk == 'L' && Auth::user()->kelas =='10') 
        {
            $siswa = DB::table('users')->where('id',Auth::user()->id)
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
            ->join('tb_ekskul_biasa', function ($join) {
                $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
            })->get();
            return view('siswa/dashboard_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        else if(Auth::user()->level == "Siswa" && Auth::user()->cek_pilihan=="sudah" && Auth::user()->jk == 'L' && Auth::user()->kelas =='11') 
        {
            $siswa = DB::table('users')->where('id',Auth::user()->id)
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
            ->join('tb_ekskul_biasa', function ($join) {
                $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
            })
            ->join('tb_ekskul_produktif', function ($join) {
                $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
            })->get();
            return view('siswa/dashboard_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        else if(Auth::user()->level == "Siswa" && Auth::user()->cek_pilihan=="sudah" && Auth::user()->jk == 'P' && Auth::user()->kelas =='10') 
        {
            $siswa = DB::table('users')->where('id',Auth::user()->id)
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
            ->join('tb_ekskul_biasa', function ($join) {
                $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
            })
            ->join('tb_keputrian', function ($join) {
                $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
            })->get();
            return view('siswa/dashboard_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        else if(Auth::user()->level == "Siswa" && Auth::user()->cek_pilihan=="sudah" && Auth::user()->jk == 'P' && Auth::user()->kelas =='11') 
        {
            $siswa = DB::table('users')->where('id',Auth::user()->id)
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
            ->join('tb_ekskul_biasa', function ($join) {
                $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
            })
            ->join('tb_keputrian', function ($join) {
                $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
            })
            ->join('tb_ekskul_produktif', function ($join) {
                $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
            })->get();
            return view('siswa/dashboard_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
    }

    public function siswa_memilih(Request $request)
    {
        $now = date('Y-m-d');
        if(Auth::user()->kelas == 10 && Auth::user()->jk =='L')
        {
            $ambil_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->first();

            $ambil_senbud = DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->first();

            $cek_salah = $this->cekHari11P([$ambil_senbud->hari_senbud, $ambil_ekskul_biasa->hari_ekskul_biasa]);
            
            if($cek_salah == false)
            {
            return redirect()->back()->withErrorMessage('Gagal memilih, Hari kegiatan tidak boleh bentrok');
            }

            DB::table('users')->where('id',Auth::user()->id)->update([
                'senbud_id'=>$request->senbud_id,
                'ekskul_biasa_id'=>$request->ekskul_biasa_id,
                'cek_pilihan'=> 'sudah',
                'tgl_pilih'=>$now,
            ]);
            $kurang_senbud = $ambil_senbud->sisa_kuota_senbud - 1;
            DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->update([
                'sisa_kuota_senbud'=>$kurang_senbud
            ]);
            $kurang_ekskul_biasa = $ambil_ekskul_biasa->sisa_kuota_ekskul_biasa - 1;
            DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->update([
                'sisa_kuota_ekskul_biasa'=>$kurang_ekskul_biasa
            ]);
        }
        else if(Auth::user()->kelas == 11 && Auth::user()->jk =='L')
        {
            $ambil_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktif_id)->first();

            $ambil_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->first();

            $ambil_senbud = DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->first();

            $cek_salah = $this->cekHari11P([$ambil_senbud->hari_senbud, $ambil_ekskul_biasa->hari_ekskul_biasa, $ambil_ekskul_produktif->hari_ekskul_produktif]);
            
            if($cek_salah == false)
            {
            return redirect()->back()->withErrorMessage('Gagal memilih, Hari kegiatan tidak boleh bentrok');
            }
            DB::table('users')->where('id',Auth::user()->id)->update([
                'senbud_id'=>$request->senbud_id,
                'ekskul_biasa_id'=>$request->ekskul_biasa_id,
                'ekskul_produktif_id'=>$request->ekskul_produktif_id,
                'cek_pilihan'=> 'sudah',
                'tgl_pilih'=>$now,
            ]);
            $kurang_senbud = $ambil_senbud->sisa_kuota_senbud - 1;
            DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->update([
                'sisa_kuota_senbud'=>$kurang_senbud
            ]);
            $kurang_ekskul_biasa = $ambil_ekskul_biasa->sisa_kuota_ekskul_biasa - 1;
            DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->update([
                'sisa_kuota_ekskul_biasa'=>$kurang_ekskul_biasa
            ]);
            $kurang_ekskul_produktif = $ambil_ekskul_produktif->sisa_kuota_ekskul_produktif - 1;
            DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktif_id)->update([
                'sisa_kuota_ekskul_produktif'=>$kurang_ekskul_produktif
            ]);
        }
        else if(Auth::user()->kelas == 10 && Auth::user()->jk =='P')
        {
            $ambil_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$request->keputrian_id)->first();
            $ambil_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->first();
            
            $ambil_senbud = DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->first();
            
            $cek_salah =  $this->cekHari11P([$ambil_senbud->hari_senbud, $ambil_ekskul_biasa->hari_ekskul_biasa, $ambil_keputrian->hari_keputrian]);

            if($cek_salah == false)
            {
            return redirect()->back()->withErrorMessage('Gagal memilih, Hari kegiatan tidak boleh bentrok');
            }
            
            DB::table('users')->where('id',Auth::user()->id)->update([
                'senbud_id'=>$request->senbud_id,
                'ekskul_biasa_id'=>$request->ekskul_biasa_id,
                'keputrian_id'=>$request->keputrian_id,
                'cek_pilihan'=> 'sudah',
                'tgl_pilih'=>$now,
            ]);
            
            $kurang_senbud = $ambil_senbud->sisa_kuota_senbud - 1;
            DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->update([
                'sisa_kuota_senbud'=>$kurang_senbud
            ]);
            $kurang_ekskul_biasa = $ambil_ekskul_biasa->sisa_kuota_ekskul_biasa - 1;
            DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->update([
                'sisa_kuota_ekskul_biasa'=>$kurang_ekskul_biasa
            ]);
            $kurang_keputrian = $ambil_keputrian->sisa_kuota_keputrian - 1;
            DB::table('tb_keputrian')->where('id_keputrian',$request->keputrian_id)->update([
                'sisa_kuota_keputrian'=>$kurang_keputrian
            ]);
        }
        else if(Auth::user()->kelas == 11 && Auth::user()->jk =='P')
        {

            $ambil_senbud = DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->first();
            $ambil_ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->first();

            $ambil_ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktif_id)->first();

            $ambil_keputrian = DB::table('tb_keputrian')->where('id_keputrian',$request->keputrian_id)->first();

            $cek_salah =  $this->cekHari11P([$ambil_senbud->hari_senbud, $ambil_ekskul_biasa->hari_ekskul_biasa, $ambil_ekskul_produktif->hari_ekskul_produktif, $ambil_keputrian->hari_keputrian]);
            if($cek_salah == false)
            {
            return redirect()->back()->withErrorMessage('Gagal memilih, Hari kegiatan tidak boleh bentrok');
            }

                DB::table('users')->where('id',Auth::user()->id)->update([
                    'senbud_id'=>$request->senbud_id,
                    'ekskul_biasa_id'=>$request->ekskul_biasa_id,
                    'ekskul_produktif_id'=>$request->ekskul_produktif_id,
                    'keputrian_id'=>$request->keputrian_id,
                    'cek_pilihan'=> 'sudah',
                    'tgl_pilih'=>$now,
                ]);
              
    
                $kurang_senbud = $ambil_senbud->sisa_kuota_senbud - 1;
                DB::table('tb_senbud')->where('id_senbud',$request->senbud_id)->update([
                    'sisa_kuota_senbud'=>$kurang_senbud
                ]);
                $kurang_ekskul_biasa = $ambil_ekskul_biasa->sisa_kuota_ekskul_biasa - 1;
                DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasa_id)->update([
                    'sisa_kuota_ekskul_biasa'=>$kurang_ekskul_biasa
                ]);
                $kurang_ekskul_produktif = $ambil_ekskul_produktif->sisa_kuota_ekskul_produktif - 1;
                DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktif_id)->update([
                    'sisa_kuota_ekskul_produktif'=>$kurang_ekskul_produktif
                ]);
                $kurang_keputrian = $ambil_keputrian->sisa_kuota_keputrian - 1;
                DB::table('tb_keputrian')->where('id_keputrian',$request->keputrian_id)->update([
                    'sisa_kuota_keputrian'=>$kurang_keputrian
                ]);
        }
        return redirect()->back()->withSuccessMessage('Selamat Anda berhasil memiilih');
    }

    public function cekHari11P(array $data)
    {
        $harusnyaAdaSegini = count($data);
        $datanyaAdaSegini = count(array_unique($data));
        if ($datanyaAdaSegini < $harusnyaAdaSegini) {
            return false;
        } else {
            return true;
        }
        
        
    }

    public function kehadiran_senbud_per_siswa($id)
    {
        $senbud_siswa = DB::table('users')->where('senbud_id',Auth::user()->senbud_id)->where('id',Auth::user()->id)
        ->join('tb_senbud', function ($join) use($id) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->first();

        $kehadiran_senbud = DB::table('tb_absen_senbud')->where('senbud_id_absen',$id)->where('users_absen_senbud_id',Auth::user()->id)
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
        $hadir = DB::table('tb_absen_senbud')->where('senbud_id_absen',$id)->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','H')->get();
        $alpa = DB::table('tb_absen_senbud')->where('senbud_id_absen',$id)->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','A')->get();
        $ijin = DB::table('tb_absen_senbud')->where('senbud_id_absen',$id)->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','I')->get();
        $sakit = DB::table('tb_absen_senbud')->where('senbud_id_absen',$id)->where('users_absen_senbud_id',Auth::user()->id)->where('keterangan_absen_senbud','S')->get();
        return view('siswa/kehadiran_senbud_per_siswa',compact('kehadiran_senbud','senbud_siswa','hadir','alpa','ijin','sakit'));
    }

    public function kehadiran_ekskul_biasa_per_siswa($id)
    {
        $ekskul_biasa_siswa = DB::table('users')->where('ekskul_biasa_id',Auth::user()->ekskul_biasa_id)->where('id',Auth::user()->id)
        ->join('tb_ekskul_biasa', function ($join) use($id) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->first();

        $kehadiran_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('ekskul_biasa_id_absen',$id)->where('users_absen_ekskul_biasa_id',Auth::user()->id)
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
        $hadir = DB::table('tb_absen_ekskul_biasa')->where('ekskul_biasa_id_absen',$id)->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $alpa = DB::table('tb_absen_ekskul_biasa')->where('ekskul_biasa_id_absen',$id)->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','A')->get();
        $ijin = DB::table('tb_absen_ekskul_biasa')->where('ekskul_biasa_id_absen',$id)->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit = DB::table('tb_absen_ekskul_biasa')->where('ekskul_biasa_id_absen',$id)->where('users_absen_ekskul_biasa_id',Auth::user()->id)->where('keterangan_absen_ekskul_biasa','S')->get();
        return view('siswa/kehadiran_ekskul_biasa_per_siswa',compact('kehadiran_ekskul_biasa','ekskul_biasa_siswa','hadir','alpa','ijin','sakit'));
    }

    public function kehadiran_ekskul_produktif_per_siswa($id)
    {
        $ekskul_produktif_siswa = DB::table('users')->where('ekskul_produktif_id',Auth::user()->ekskul_produktif_id)->where('id',Auth::user()->id)
        ->join('tb_ekskul_produktif', function ($join) use($id) {
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->first();

        $kehadiran_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('ekskul_produktif_id_absen',$id)->where('users_absen_ekskul_produktif_id',Auth::user()->id)
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
        $hadir = DB::table('tb_absen_ekskul_produktif')->where('ekskul_produktif_id_absen',$id)->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $alpa = DB::table('tb_absen_ekskul_produktif')->where('ekskul_produktif_id_absen',$id)->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','A')->get();
        $ijin = DB::table('tb_absen_ekskul_produktif')->where('ekskul_produktif_id_absen',$id)->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit = DB::table('tb_absen_ekskul_produktif')->where('ekskul_produktif_id_absen',$id)->where('users_absen_ekskul_produktif_id',Auth::user()->id)->where('keterangan_absen_ekskul_produktif','S')->get();
        return view('siswa/kehadiran_ekskul_produktif_per_siswa',compact('kehadiran_ekskul_produktif','ekskul_produktif_siswa','hadir','alpa','ijin','sakit'));
    }

    public function kehadiran_keputrian_per_siswa($id)
    {
        $keputrian_siswa = DB::table('users')->where('keputrian_id',Auth::user()->keputrian_id)->where('id',Auth::user()->id)
        ->join('tb_keputrian', function ($join) use($id) {
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->first();

        $kehadiran_keputrian = DB::table('tb_absen_keputrian')->where('keputrian_id_absen',$id)->where('users_absen_keputrian_id',Auth::user()->id)
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
        $hadir = DB::table('tb_absen_keputrian')->where('keputrian_id_absen',$id)->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','H')->get();
        $alpa = DB::table('tb_absen_keputrian')->where('keputrian_id_absen',$id)->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','A')->get();
        $ijin = DB::table('tb_absen_keputrian')->where('keputrian_id_absen',$id)->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','I')->get();
        $sakit = DB::table('tb_absen_keputrian')->where('keputrian_id_absen',$id)->where('users_absen_keputrian_id',Auth::user()->id)->where('keterangan_absen_keputrian','S')->get();
        return view('siswa/kehadiran_keputrian_per_siswa',compact('kehadiran_keputrian','keputrian_siswa','hadir','alpa','ijin','sakit'));
    }
}
