<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Artisan;
use Alert;
use DataTables;
use App\Exports\SiswaExport;
use App\Exports\SenbudAlpa3Export;
use App\Exports\EkskulBiasaAlpa3Export;
use App\Exports\EkskulProduktifAlpa3Export;
use App\Exports\KeputrianAlpa3Export;
use App\Exports\SiswaSudahMemilih;
use App\Exports\ExportSenbudTidakMasuk;
use App\Exports\ExportEkskulBiasaTidakMasuk;
use App\Exports\ExportEkskulProduktifTidakMasuk;
use App\Exports\ExportKeputrianTidakMasuk;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Illuminate\Http\Response;
class AdminController extends Controller
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
        $this->middleware('admin_level');
    }
    public function banyak_siswa()
    {
        return view('admin/banyak_siswa');
    }

    public function cari_tidak_masuk(Request $request)
    {
        $banyak_siswa = DB::table('users')->where('level','Siswa')->get();
        $sudah_memilih = DB::table('users')->where('cek_pilihan','sudah')->where('level','Siswa')->get();
        $belum_memilih = DB::table('users')->where('cek_pilihan','belum')->where('level','Siswa')->get();
        if($request->kegiatan =='senbud')
        {
            $cek = DB::table('tb_absen_senbud')->where('keterangan_absen_senbud','A')->where('tgl_absen_senbud_detail',$request->tanggal)
            ->join('users', function ($join) {
                $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
            })
            ->join('tb_senbud', function ($join) {
                $join->on('tb_absen_senbud.senbud_id_absen', '=', 'tb_senbud.id_senbud');
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
            return view('/admin/dashboard_admin',compact('banyak_siswa','sudah_memilih','belum_memilih','cek'));
        }
        else if($request->kegiatan =='ekskul_biasa')
        {
            $cek = DB::table('tb_absen_ekskul_biasa')->where('keterangan_absen_ekskul_biasa','A')->where('tgl_absen_ekskul_biasa_detail',$request->tanggal)
            ->join('users', function ($join) {
                $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
            })
            ->join('tb_ekskul_biasa', function ($join) {
                $join->on('tb_absen_ekskul_biasa.ekskul_biasa_id_absen', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
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
            return view('/admin/dashboard_admin',compact('banyak_siswa','sudah_memilih','belum_memilih','cek'));
        }
        else if($request->kegiatan =='ekskul_produktif')
        {
            $cek = DB::table('tb_absen_ekskul_produktif')->where('keterangan_absen_ekskul_produktif','A')->where('tgl_absen_ekskul_produktif_detail',$request->tanggal)
            ->join('users', function ($join) {
                $join->on('tb_absen_ekskul_produktif.users_absen_ekskul_produktif_id', '=', 'users.id');
            })
            ->join('tb_ekskul_produktif', function ($join) {
                $join->on('tb_absen_ekskul_produktif.ekskul_produktif_id_absen', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
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
            return view('/admin/dashboard_admin',compact('banyak_siswa','sudah_memilih','belum_memilih','cek'));
        }
        else if($request->kegiatan =='keputrian')
        {
            $cek = DB::table('tb_absen_keputrian')->where('keterangan_absen_keputrian','A')->where('tgl_absen_keputrian_detail',$request->tanggal)
            ->join('users', function ($join) {
                $join->on('tb_absen_keputrian.users_absen_keputrian_id', '=', 'users.id');
            })
            ->join('tb_keputrian', function ($join) {
                $join->on('tb_absen_keputrian.keputrian_id_absen', '=', 'tb_keputrian.id_keputrian');
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
            return view('/admin/dashboard_admin',compact('banyak_siswa','sudah_memilih','belum_memilih','cek'));
        }
    }
    public function banyak_siswa_json()
    {
        $siswa = DB::table('users')->where('level','Siswa')
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
        return Datatables::of($siswa)
        ->addColumn('action', function ($s) {
            return '<a href="/detail_siswa/'.$s->id.'"class="btn btn-sm btn-info">Lihat </a>
            <a href="/siswa/detail/'.$s->id.'"class="btn btn-sm btn-primary">Detail </a>
            ';
        })->make(true);
        
        return Datatables::of($siswa)->make(true);
    }
    public function siswa_json()
    {
        $siswa = DB::table('users')->where('level','Siswa')
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
        return Datatables::of($siswa)
        ->addColumn('action', function ($s) {
            if($s->status == "aktif")
            {
                return '<a href="/detail_siswa/'.$s->id.'"class="btn btn-sm btn-info">Kehadiran </a>
                <a href="/siswa/detail/'.$s->id.'"class="btn btn-sm btn-primary">Detail </a>
                <a href="/pengguna/hapus/'.$s->id.'"class="btn btn-sm btn-danger">Non - Aktifkan </a>
                ';
            }
            else{
                return '<a href="/detail_siswa/'.$s->id.'"class="btn btn-sm btn-info">Kehadiran </a>
                <a href="/siswa/detail/'.$s->id.'"class="btn btn-sm btn-primary">Detail </a>
                <a href="/pengguna/hapus/'.$s->id.'"class="btn btn-sm btn-danger">Aktifkan </a>
                ';
            }
        ;
        })->make(true);
        
        return Datatables::of($siswa)->make(true);
    }
    // public function cari_json(Request $request)
    // {
    //     $siswa = DB::table('tb_absen_senbud')->where('keterangan_absen_senbud','A')->where('tgl_absen_senbud_detail',response()->json($request->tanggal))
    //     ->join('users', function ($join) {
    //         $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
    //     })
    //     ->join('tb_rombel', function ($join) {
    //         $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
    //     })
    //     ->join('tb_rayon', function ($join) {
    //         $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
    //     })
    //     ->join('tb_jurusan', function ($join) {
    //         $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
    //     })->get();
    //     return Datatables::of($siswa)->make(true);
    // }
    public function sudah_memilih()
    {
        $siswa = DB::table('users')->where('level','Siswa')->where('cek_pilihan','sudah')->get();
        return view('admin/sudah_memilih',compact('siswa'));
    }
    public function sudah_memilih_json()
    {
        $siswa = DB::table('users')->where('level','Siswa')->where('cek_pilihan','sudah')
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
        return Datatables::of($siswa)
        ->addColumn('action', function ($s) {
            return '<a href="/detail_siswa/'.$s->id.'"class="btn btn-sm btn-info">Lihat </a>
            <a href="/siswa/detail/'.$s->id.'"class="btn btn-sm btn-primary">Detail </a>

            ';
        })
        ->make(true);
      
        return Datatables::of($siswa)->make(true);
    }
    public function belum_memilih()
    {
        $siswa = DB::table('users')->where('level','Siswa')->where('cek_pilihan','belum')->get();
        return view('admin/belum_memilih',compact('siswa'));
    }
    public function belum_memilih_json(){
        $siswa = DB::table('users')->where('level','Siswa')->where('cek_pilihan','belum')
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
        return Datatables::of($siswa)
        ->addColumn('action', function ($s) {
            return '<a href="/detail_siswa/'.$s->id.'"class="btn btn-sm btn-info">Lihat </a>
            <a href="/siswa/detail/'.$s->id.'"class="btn btn-sm btn-primary">Detail </a>
            
            ';
        })
        ->make(true);
        return Datatables::of($siswa)->make(true);
    }
    public function dashboard_admin()
    {
        
        $banyak_siswa = DB::table('users')->where('level','Siswa')->get();
        $sudah_memilih = DB::table('users')->where('cek_pilihan','sudah')->where('level','Siswa')->get();
        $belum_memilih = DB::table('users')->where('cek_pilihan','belum')->where('level','Siswa')->get();
        return view('/admin/dashboard_admin',compact('banyak_siswa','sudah_memilih','belum_memilih'));
    }
    public function detail_siswa($id)
    {
        $hadir_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','H')->get();
        $ijin_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','I')->get();
        $sakit_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','S')->get();
        $alpa_senbud = DB::table('tb_absen_senbud')->where('users_absen_senbud_id',$id)->where('keterangan_absen_senbud','A')->get();

        $hadir_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','H')->get();
        $ijin_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','I')->get();
        $sakit_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','S')->get();
        $alpa_ekskul_biasa = DB::table('tb_absen_ekskul_biasa')->where('users_absen_ekskul_biasa_id',$id)->where('keterangan_absen_ekskul_biasa','A')->get();
        
        $hadir_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','H')->get();
        $ijin_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','I')->get();
        $sakit_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','S')->get();
        $alpa_ekskul_produktif = DB::table('tb_absen_ekskul_produktif')->where('users_absen_ekskul_produktif_id',$id)->where('keterangan_absen_ekskul_produktif','A')->get();
        
        $hadir_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','H')->get();
        $ijin_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','I')->get();
        $sakit_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','S')->get();
        $alpa_keputrian = DB::table('tb_absen_keputrian')->where('users_absen_keputrian_id',$id)->where('keterangan_absen_keputrian','A')->get();

        $senbud = DB::table('tb_senbud')->where('kuota_senbud','>','0')->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('kuota_ekskul_produktif','>','0')->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('kuota_ekskul_biasa','>','0')->get();
        $keputrian = DB::table('tb_keputrian')->where('kuota_keputrian','>','0')->get();
        
        $senbud = DB::table('tb_senbud')->where('kuota_senbud','!=','0')->get();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('kuota_ekskul_produktif','!=','0')->get();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('kuota_ekskul_biasa','!=','0')->get();
        $keputrian = DB::table('tb_keputrian')->where('kuota_keputrian','!=','0')->get();
        $siswa = DB::table('users')->where('id',$id)->get();
        foreach($siswa as $s)
        {
            if($s->level == "Siswa" && $s->cek_pilihan=="belum")
            {
    
                $siswa = DB::table('users')->where('id',$id)
                ->join('tb_jurusan', function ($join) {
                    $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
                })
                ->join('tb_rombel', function ($join) {
                    $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
                })
                ->join('tb_rayon', function ($join) {
                    $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
                })->get();
                
                return view('admin/detail_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
            }
            else if($s->level == "Siswa" && $s->cek_pilihan=="sudah" && $s->jk == 'L' && $s->kelas =='10') 
            {
                $siswa = DB::table('users')->where('id',$id)
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
                return view('admin/detail_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
            }
            else if($s->level == "Siswa" && $s->cek_pilihan=="sudah" && $s->jk == 'L' && $s->kelas =='11') 
        {
            $siswa = DB::table('users')->where('id',$id)
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
            return view('admin/detail_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        else if($s->level == "Siswa" && $s->cek_pilihan=="sudah" && $s->jk == 'P' && $s->kelas =='10') 
        {
            $siswa = DB::table('users')->where('id',$id)
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
            return view('admin/detail_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        else if($s->level == "Siswa" && $s->cek_pilihan=="sudah" && $s->jk == 'P' && $s->kelas =='11') 
        {
            $siswa = DB::table('users')->where('id',$id)
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
            return view('admin/detail_siswa',compact('siswa','senbud','ekskul_produktif','ekskul_biasa','keputrian','hadir_senbud','ijin_senbud','sakit_senbud','alpa_senbud','hadir_ekskul_biasa','ijin_ekskul_biasa','sakit_ekskul_biasa','alpa_ekskul_biasa','hadir_ekskul_produktif','ijin_ekskul_produktif','sakit_ekskul_produktif','alpa_ekskul_produktif','hadir_keputrian','ijin_keputrian','sakit_keputrian','alpa_keputrian'));
        }
        }
       
      
        
    }
    public function tambah_guru()
    { 
        $mapel = DB::table('tb_mapel')->get();
        return view('pengguna/tambah_guru',compact('mapel'));
    }
    public function tambah_guru_store(Request $request)
    { 
        DB::table('users')->insert([
            
                'nama' => $request['nama'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'mapel_id' => $request['mapel_id'],
                'level' => 'Guru',
        ]);
         
        DB::table('tb_guru')->insert([
            
            'nik' => $request['nik'],
            'nama_guru' => $request['nama'],
            'mapel_id' => $request['mapel_id'],
    ]);
    return redirect()->back();
    }
    
    public function rombel()
    {
        $rombel = DB::table('tb_rombel')->get();
        return view('admin/rombel',compact('rombel'));
    }
    
    public function rombel_hapus($id)
    {
       
        $rombel = DB::table('tb_rombel')->where('id_rombel',$id)->delete();
        
        return redirect()->back()->withSuccessMessage('Data Berhasil Dihapus');
    }
    
    public function rombel_detail($id)
    {
        $siswa = DB::table('users')->where('rombel_id',$id)
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
       
        $rombel = DB::table('tb_rombel')->where('id_rombel','!=',$id)->get();
        $nama_rombel = DB::table('tb_rombel')->where('id_rombel',$id)->first();
        return view('admin/rombel_detail',compact('siswa','nama_rombel','rombel'));
    }

    public function rombel_edit($id)
    {
        
        $rombel = DB::table('tb_rombel')->where('id_rombel',$id)->get();
     
        return view('admin/rombel_edit',compact('rombel'));
    }

    public function rombel_store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'nama_rombel'=>'required|unique:tb_rombel',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages()->all()[0])->withInput()->withErrors($validator);;    
        }
        DB::table('tb_rombel')->insert([
            'nama_rombel'=>$request->nama_rombel
        ]);
        return redirect()->back()->with(['modal','success']);
    }
    public function rombel_update(Request $request)
    { 
        
        
        DB::table('tb_rombel')->where('id_rombel',$request->modal_input_id)->update([
            'nama_rombel'=>$request->modal_input_name
        ]);
        return redirect('/rombel')->withSuccessMessage('Data Berhasil Diubah');
    }

    
    public function pindahkan_rombel(Request $request)
    {
        DB::table('users')->where('id',$request->modal_input_id)->update([
            'rombel_id'=>$request->rombelAkhir            
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
    }

    // Akhir Rombel Controller ==================================

    public function rayon()
    {
        
        $rayon = DB::table('tb_rayon')->get();
      
        return view('admin/rayon',compact('rayon'));
  
    }
    
    public function rayon_hapus($id)
    {
        $rayon = DB::table('tb_rayon')->where('id_rayon',$id)->delete();
      
        return redirect()->back()->withSuccessMessage('Data Berhasil dihapus');;;
    }
    
    public function rayon_detail($id)
    {
        $siswa = DB::table('users')->where('rayon_id',$id)
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
       
        $rayon = DB::table('tb_rayon')->where('id_rayon','!=',$id)->get();
        $nama_rayon = DB::table('tb_rayon')->where('id_rayon',$id)->first();
        return view('admin/rayon_detail',compact('siswa','nama_rayon','rayon'));
    }


    public function rayon_edit($id)
    {
        
        $rayon = DB::table('tb_rayon')->where('id_rayon',$id)->get();
     
        return view('admin/rayon_edit',compact('rayon'));
    }

    public function rayon_store(Request $request)
    { 
        
        $validator = Validator::make($request->all(),[
            'nama_rayon'=>'required|unique:tb_rayon',
            'inisial_rayon'=>'required|unique:tb_rayon',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages()->all()[0])->withInput()->withErrors($validator);;    
        }
        DB::table('tb_rayon')->insert([
            'nama_rayon'=>$request->nama_rayon,
            'inisial_rayon'=>$request->inisial_rayon
        ]);
        return redirect()->back()->withSuccessMessage('Data Berhasil Ditambahkan'); 
        
    }
    public function pindahkan_rayon(Request $request)
    {
        DB::table('users')->where('id',$request->modal_input_id)->update([
            'rayon_id'=>$request->rayonAkhir            
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
    }
    public function pindahkan_jurusan(Request $request)
    {
        DB::table('users')->where('id',$request->modal_input_id)->update([
            'jurusan_id'=>$request->jurusanAkhir            
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
    }

    public function rayon_update(Request $request)
    { 
        DB::table('tb_rayon')->where('id_rayon',$request->modal_input_id)->update([
            'nama_rayon'=>$request->modal_input_name,
            'inisial_rayon'=>$request->modal_input_inisial_rayon
        ]);
        return redirect('/rayon')->withSuccessMessage('Data Berhasil diubah');
    }
    // Akhir Rayon Controller =======================================================================


    public function jurusan()
    {
        
        $jurusan = DB::table('tb_jurusan')->get();
      
        return view('admin/jurusan',compact('jurusan'));
  
    }
    
    public function jurusan_hapus($id)
    {
        $jurusan = DB::table('tb_jurusan')->where('id_jurusan',$id)->delete();
      
        return redirect()->back()->withSuccessMessage('Data Berhasil dihapus');;;
    }

    public function jurusan_detail($id)
    {
        $siswa = DB::table('users')->where('jurusan_id',$id)
        ->join('tb_rombel', function ($join) {
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join) {
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_jurusan', function ($join) {
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
       
        $jurusan = DB::table('tb_jurusan')->where('id_jurusan','!=',$id)->get();
        $nama_jurusan = DB::table('tb_jurusan')->where('id_jurusan',$id)->first();
        return view('admin/jurusan_detail',compact('siswa','nama_jurusan','jurusan'));
    }

    public function jurusan_edit($id)
    {
        
        $jurusan = DB::table('tb_jurusan')->where('id_jurusan',$id)->get();
     
        return view('admin/jurusan_edit',compact('jurusan'));
    }

    public function jurusan_store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'nama_jurusan'=>'required|unique:tb_jurusan',
        ]);
        if($validator->fails()){
            return back()->with('toast_error',$validator->messages()->all()[0])->withInput()->withErrors($validator);;    
        }
        DB::table('tb_jurusan')->insert([
            'nama_jurusan'=>$request->nama_jurusan
        ]);
            
        return redirect()->back()->withSuccessMessage('Data Berhasil Ditambahkan');
       
    }
    public function jurusan_update(Request $request)
    { 
        DB::table('tb_jurusan')->where('id_jurusan',$request->modal_input_id)->update([
            'nama_jurusan'=>$request->modal_input_name
        ]);
        return redirect('/jurusan')->withSuccessMessage('Data Berhasil diubah');
    }
    // Akhir Jurusan Controller =======================================================================

   
   
    // ==================================================================================

    public function pindahkan_senbud(Request $request)
    {
        $cek_user = DB::table('users')->where('id',$request->modal_input_id)->first();
        $senbud = DB::table('tb_senbud')->where('id_senbud',$cek_user->senbud_id)->first();
        $hitung = $senbud->sisa_kuota_senbud + 1;
        DB::table('tb_senbud')->where('id_senbud',$cek_user->senbud_id)->update([
            'sisa_kuota_senbud'=>$hitung          
        ]);
        DB::table('users')->where('id',$request->modal_input_id)->update([
            'senbud_id'=>$request->senbudAkhir          
        ]);

        
        $senbud_akhir = DB::table('tb_senbud')->where('id_senbud',$request->senbudAkhir)->first();
        $hitung_senbud_akhir = $senbud_akhir->sisa_kuota_senbud - 1;
        DB::table('tb_senbud')->where('id_senbud',$request->senbudAkhir)->update([
            'sisa_kuota_senbud'=>$hitung_senbud_akhir          
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
    }

    public function pindahkan_ekskul_biasa(Request $request)
    {
        $cek_user = DB::table('users')->where('id',$request->modal_input_id)->first();
        $ekskul_biasa = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$cek_user->ekskul_biasa_id)->first();
        $hitung = $ekskul_biasa->sisa_kuota_ekskul_biasa + 1;
        DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$cek_user->ekskul_biasa_id)->update([
            'sisa_kuota_ekskul_biasa'=>$hitung          
        ]);
        DB::table('users')->where('id',$request->modal_input_id)->update([
            'ekskul_biasa_id'=>$request->ekskul_biasaAkhir          
        ]);

        
        $ekskul_biasa_akhir = DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasaAkhir)->first();
        $hitung_ekskul_biasa_akhir = $ekskul_biasa_akhir->sisa_kuota_ekskul_biasa - 1;
        DB::table('tb_ekskul_biasa')->where('id_ekskul_biasa',$request->ekskul_biasaAkhir)->update([
            'sisa_kuota_ekskul_biasa'=>$hitung_ekskul_biasa_akhir          
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
    }
    // ================================================================================================

     
    public function pindahkan_ekskul_produktif(Request $request)
    {
        $cek_user = DB::table('users')->where('id',$request->modal_input_id)->first();
        $ekskul_produktif = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$cek_user->ekskul_produktif_id)->first();
        $hitung = $ekskul_produktif->sisa_kuota_ekskul_produktif + 1;
        DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$cek_user->ekskul_produktif_id)->update([
            'sisa_kuota_ekskul_produktif'=>$hitung          
        ]);
        DB::table('users')->where('id',$request->modal_input_id)->update([
            'ekskul_produktif_id'=>$request->ekskul_produktifAkhir          
        ]);

        
        $ekskul_produktif_akhir = DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktifAkhir)->first();
        $hitung_ekskul_produktif_akhir = $ekskul_produktif_akhir->sisa_kuota_ekskul_produktif - 1;
        DB::table('tb_ekskul_produktif')->where('id_ekskul_produktif',$request->ekskul_produktifAkhir)->update([
            'sisa_kuota_ekskul_produktif'=>$hitung_ekskul_produktif_akhir          
        ]);
        return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
    }
    // ================================================================================================

        public function pindahkan_keputrian(Request $request)
        {
            $cek_user = DB::table('users')->where('id',$request->modal_input_id)->first();

            $keputrian = DB::table('tb_keputrian')->where('id_keputrian',$cek_user->keputrian_id)->first();
            $hitung = $keputrian->sisa_kuota_keputrian + 1;
            DB::table('tb_keputrian')->where('id_keputrian',$cek_user->keputrian_id)->update([
                'sisa_kuota_keputrian'=>$hitung          
            ]);
            DB::table('users')->where('id',$request->modal_input_id)->update([
                'keputrian_id'=>$request->keputrianAkhir          
            ]);
    
            
            $keputrian_akhir = DB::table('tb_keputrian')->where('id_keputrian',$request->keputrianAkhir)->first();
            $hitung_keputrian_akhir = $keputrian_akhir->sisa_kuota_keputrian - 1;
            DB::table('tb_keputrian')->where('id_keputrian',$request->keputrianAkhir)->update([
                'sisa_kuota_keputrian'=>$hitung_keputrian_akhir          
            ]);
    
            
            return redirect()->back()->withSuccessMessage('Siswa Berhasil Dipindahkan');
        }
        // ================================================================================================


    public function belum_memilih_export()
	{
		return Excel::download(new SiswaExport, 'Siswa belum memilih ekskul dan senbud.xlsx');
    }

    public function sudah_memilih_export()
	{
		return Excel::download(new SiswaSudahMemilih, 'Siswa sudah memilih ekskul dan senbud.xlsx');
    }
    
   
    public function senbud_alpa_3()
    {
        $users = DB::table('users')->where('kehadiran_senbud','>',3)
        ->join('tb_senbud', function ($join){
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->join('tb_rombel', function ($join){
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join){
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_jurusan', function ($join){
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
        return view('admin/alpa/senbud_alpa_3',compact('users'));

    }
    
   
    public function ekskul_biasa_alpa_3()
    {
        $users = DB::table('users')->where('kehadiran_ekskul_biasa','>',3)
        ->join('tb_ekskul_biasa', function ($join){
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->join('tb_rombel', function ($join){
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join){
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_jurusan', function ($join){
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
        return view('admin/alpa/ekskul_biasa_alpa_3',compact('users'));

    }

    public function ekskul_produktif_alpa_3()
    {
        $users = DB::table('users')->where('kehadiran_ekskul_produktif','>',3)
        ->join('tb_ekskul_produktif', function ($join){
            $join->on('users.ekskul_produktif_id', '=', 'tb_ekskul_produktif.id_ekskul_produktif');
        })
        ->join('tb_rombel', function ($join){
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join){
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_jurusan', function ($join){
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
        return view('admin/alpa/ekskul_produktif_alpa_3',compact('users'));

    }

    public function keputrian_alpa_3()
    {
        $users = DB::table('users')->where('kehadiran_keputrian','>',3)
        ->join('tb_keputrian', function ($join){
            $join->on('users.keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->join('tb_rombel', function ($join){
            $join->on('users.rombel_id', '=', 'tb_rombel.id_rombel');
        })
        ->join('tb_rayon', function ($join){
            $join->on('users.rayon_id', '=', 'tb_rayon.id_rayon');
        })
        ->join('tb_jurusan', function ($join){
            $join->on('users.jurusan_id', '=', 'tb_jurusan.id_jurusan');
        })->get();
        return view('admin/alpa/keputrian_alpa_3',compact('users'));

    }

    public function senbud_alpa_3_export()
	{
		return Excel::download(new SenbudAlpa3Export, 'Siswa Alpa Senbud > 3.xlsx');
    }
    public function ekskul_biasa_alpa_3_export()
	{
		return Excel::download(new EkskulBiasaAlpa3Export, 'Siswa Alpa Ekskul Biasa > 3.xlsx');
    }
    public function ekskul_produktif_alpa_3_export()
	{
		return Excel::download(new EkskulProduktifAlpa3Export, 'Siswa Alpa Ekskul Produktif > 3.xlsx');
    }
    public function keputrian_alpa_3_export()
	{
		return Excel::download(new KeputrianAlpa3Export, 'Siswi Alpa Keputrian > 3.xlsx');
    }
    public function export_senbud_tidak_masuk(Request $request)
	{
        $tgl = $request->tgl;
        $nama_file = 'Siswa tidak masuk senbud, keterangan alpa tanggal'.' '.$tgl.' '. '.xlsx';
        return Excel::download(new ExportSenbudTidakMasuk($request), $nama_file);
    }
    public function export_ekskul_biasa_tidak_masuk(Request $request)
	{
        $tgl = $request->tgl;
        $nama_file = 'Siswa tidak masuk ekskul biasa, keterangan alpa tanggal'.' '.$tgl.' '. '.xlsx';
        return Excel::download(new ExportEkskulBiasaTidakMasuk($request), $nama_file);
    }
    public function export_ekskul_produktif_tidak_masuk(Request $request)
	{
        $tgl = $request->tgl;
        $nama_file = 'Siswa tidak masuk ekskul produktif, keterangan alpa tanggal'.' '.$tgl.' '. '.xlsx';
        return Excel::download(new ExportEkskulProduktifTidakMasuk($request), $nama_file);
    }
    public function export_keputrian_tidak_masuk(Request $request)
	{
        $tgl = $request->tgl;
        $nama_file = 'Siswa tidak masuk keputrian, keterangan alpa tanggal'.' '.$tgl.' '. '.xlsx';
        return Excel::download(new ExportKeputrianTidakMasuk($request), $nama_file);
    }
}
