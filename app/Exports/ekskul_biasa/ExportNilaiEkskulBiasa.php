<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class ExportNilaiEkskulBiasa implements FromCollection
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
        return DB::table('tb_nilai_ekskul_biasa')->where('keterangan_nilai_ekskul_biasa_detail',$this->id)
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('tb_nilai_ekskul_biasa.ekskul_biasa_nilai_ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
        })
        ->join('users', function ($join) {
            $join->on('tb_nilai_ekskul_biasa.users_nilai_ekskul_biasa_id', '=', 'users.id');
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
        ->select('nis','nama','nama_rayon','nama_ekskul_biasa','nilai_sikap_ekskul_biasa','nilai_pengetahuan_ekskul_biasa')
        ->get();
    }
}
