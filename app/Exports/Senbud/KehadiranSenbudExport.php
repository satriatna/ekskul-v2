<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class KehadiranSenbudExport implements FromCollection
{
    protected $id;

        function __construct($id) {
                $this->id = $id;
        }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('tb_absen_senbud')->where("tgl_absen_senbud_detail",$this->id)->select('tgl_absen_senbud_detail','keterangan_absen_senbud','nis','nama','nama_jurusan','nama_rombel','nama_rayon','kelas','jk','nama_senbud')
        ->join('users', function ($join) {
            $join->on('tb_absen_senbud.users_absen_senbud_id', '=', 'users.id');
        })
        ->join('tb_senbud', function ($join) {
            $join->on('users.senbud_id', '=', 'tb_senbud.id_senbud');
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
    }
}
