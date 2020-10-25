<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class ExportNilaiSenbud implements FromCollection
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
        return DB::table('tb_nilai_senbud')->where('keterangan_nilai_senbud_detail',$this->id)
        ->join('tb_senbud', function ($join) {
            $join->on('tb_nilai_senbud.senbud_nilai_senbud_id', '=', 'tb_senbud.id_senbud');
        })
        ->join('users', function ($join) {
            $join->on('tb_nilai_senbud.users_nilai_senbud_id', '=', 'users.id');
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
        ->select('nis','nama','nama_rayon','nama_senbud','nilai_sikap_senbud','nilai_pengetahuan_senbud')
        ->get();
    }
}
