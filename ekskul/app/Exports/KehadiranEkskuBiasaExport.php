<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class KehadiranEkskulBiasaExport implements FromCollection
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
        return DB::table('tb_absen_ekskul_biasa')->where("tgl_absen_ekskul_biasa_detail",$this->id)->select('tgl_absen_ekskul_biasa_detail','keterangan_absen_ekskul_biasa','nis','nama','nama_jurusan','nama_rombel','nama_rayon','kelas','jk','nama_ekskul_biasa')
        ->join('users', function ($join) {
            $join->on('tb_absen_ekskul_biasa.users_absen_ekskul_biasa_id', '=', 'users.id');
        })
        ->join('tb_ekskul_biasa', function ($join) {
            $join->on('users.ekskul_biasa_id', '=', 'tb_ekskul_biasa.id_ekskul_biasa');
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
