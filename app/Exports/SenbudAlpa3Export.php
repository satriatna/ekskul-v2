<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class SenbudAlpa3Export implements FromCollection
{
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $users = DB::table('users')->where('kehadiran_senbud','>',3)->select('nis','nama','nama_rombel','nama_rayon','nama_senbud','kehadiran_senbud')
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
        
    }
}
