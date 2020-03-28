@extends('layouts.layout')
@section('content')
  
 <title>
    Input Nilai Siswa Ekskul Produktif - Aplikasi Pemilihan Senbud UPD
 </title>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid" style="margin-top:-60px !important;">

        <div class="header-body mt-5">
        </div>
        <div class="card col-xl-6">
            <div class="card-body">
                <span class="mr-3" style="font-size:16px; font-weight:bold;">Input Nilai Ekskul Produktif </span>
            </div>
        </div>
        <div class="card shadow mt-2">
        <div class="card-header bg-secondary">
        Data Nama Siswa 
        </div>
            <div class="card-body">
            <div style="overflow-x:auto;">
            <form action="/input_nilai_ekskul_produktif_post" method="POST">
            <input type="hidden" name="ekskul_produktif_id" value="{{$ekskul_produktif->id_ekskul_produktif}}"> 
            <input type="hidden" name="instruktur_ekskul_produktif_id" value="{{$ekskul_produktif->instruktur_ekskul_produktif_id}}"> 
            {{csrf_field()}}
            <input type="hidden" value="<?php echo date('Y-m-d')?> " name="tgl_absen_ekskul_produktif">
            <table id="example" class="table table-striped table-bordered nowrap mt-3 text-center" style="overflow-x:auto;">
                <thead>
                    <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">NIS</th>
                    <th rowspan="2"> Nama</th>
                    <th rowspan="2">Rayon</th>
                    <td colspan="2">Nilai</td>
                    </tr>
                    <tr>
                    <th>Sikap</th>
                    <th>Pengetahuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    
                    <tr class="data-row">
                    <td class="align-middle iteration"> </td>
                    <td class="align-middle nis">{{$s->nis}} <input name="siswa[]" type="hidden" value="{{$s->id}}"></td>
                    <td class="align-middle name">{{$s->nama}}</td>
                    <td class="align-middle word-break description2">{{$s->nama_rayon}}</td>
                    <td>
                    <select name="sikap[]" id="sikap" class="form-control" required style="width:100px">
                        <option value=""></option>
                        <option value="Kurang">Kurang</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Baik" selected>Baik</option>
                        <option value="Sangat Baik">Sangat Baik</option>
                    </select>

                     </td>
                     <td>
                        <input type="number" name="pengetahuan[]" class="form-control" style="width:100px" required>
                     </td>
                    </tr>
                    @endforeach
                </tfoot>
            </table>
            </div>
            <br>
            <div class="form-group">
            <label for="keterangan_nilai_ekskul_produktif">Keterangan Nilai</label>
            <input type="text" name="keterangan_nilai_ekskul_produktif" class="form-control col-md-3" id="keterangan_nilai_ekskul_produktif" placeholder="Contoh : Semester 1" required>
            </div>
            <button class="btn btn-primary mt-2">Simpan Data</button>
            </form>
            </div>
          </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
         
        </div>
        
      </div>
     
    </div>
  </div>
  @push('scripts')
  
    <script>

$(document).ready(function() {
    var t = $('#example').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]]
    } );
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
    </script>
    @endpush
  @endsection