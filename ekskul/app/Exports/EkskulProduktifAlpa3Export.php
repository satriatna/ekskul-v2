<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class EkskulProduktifAlpa3Export implements FromCollection
{
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $users = DB::table('users')->where('kehadiran_ekskul_produktif','>',3)->select('nis','nama','nama_rombel','nama_rayon','nama_ekskul_produktif','kehadiran_ekskul_produktif')
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
        
    }
}
