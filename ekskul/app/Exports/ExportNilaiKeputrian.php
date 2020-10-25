<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class ExportNilaiKeputrian implements FromCollection
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
        return DB::table('tb_nilai_keputrian')->where('keterangan_nilai_keputrian_detail',$this->id)
        ->join('tb_keputrian', function ($join) {
            $join->on('tb_nilai_keputrian.keputrian_nilai_keputrian_id', '=', 'tb_keputrian.id_keputrian');
        })
        ->join('users', function ($join) {
            $join->on('tb_nilai_keputrian.users_nilai_keputrian_id', '=', 'users.id');
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
        ->select('nis','nama','nama_rayon','nama_keputrian','nilai_sikap_keputrian','nilai_pengetahuan_keputrian')
        ->get();
    }
}
