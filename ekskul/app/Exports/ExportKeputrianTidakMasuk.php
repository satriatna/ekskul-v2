<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class ExportKeputrianTidakMasuk implements FromCollection
{
    protected $id;

        function __construct($request) {
                $this->request = $request->tgl;
        }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  $cek = DB::table('tb_absen_keputrian')->where('keterangan_absen_keputrian','A')->where('tgl_absen_keputrian_detail',$this->request)
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
        ->select('nis','nama','nama_rayon','nama_keputrian','keterangan_absen_keputrian','tgl_absen_keputrian_detail')
        ->get();
    }
}
