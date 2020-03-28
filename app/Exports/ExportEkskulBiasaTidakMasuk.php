<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class ExportEkskulBiasaTidakMasuk implements FromCollection
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
        return  $cek = DB::table('tb_absen_senbud')->where('keterangan_absen_senbud','A')->where('tgl_absen_senbud_detail',$this->request)
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
        ->select('nis','nama','nama_rayon','nama_senbud','keterangan_absen_senbud','tgl_absen_senbud_detail')
        ->get();
    }
}
