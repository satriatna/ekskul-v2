<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class KehadiranKeputrianPersiswaExport implements FromCollection
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
        return DB::table('tb_absen_keputrian')->where("users_absen_keputrian_id",$this->id)->select('tgl_absen_keputrian_detail','keterangan_absen_keputrian','nis','nama','nama_jurusan','nama_rombel','nama_rayon','kelas','jk','nama_keputrian')
        ->join('tb_keputrian', function ($join) {
            $join->on('tb_absen_keputrian.keputrian_id_absen', '=', 'tb_keputrian.id_keputrian');
        })
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
        ->get();
    }
}
