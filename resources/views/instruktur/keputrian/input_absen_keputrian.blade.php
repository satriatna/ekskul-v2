@extends('layouts.layout')
@section('content')
  
 <title>
    Input Absen Keputrian - Aplikasi Pemilihan Senbud UPD
 </title>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid" style="margin-top:-60px !important;">

        <div class="header-body mt-5">
        </div>
        <div class="card col-xl-6">
            <div class="card-body">
                <span class="mr-3" style="font-size:16px; font-weight:bold;">Input Data Absensi Tanggal : <?php echo date('d-m-Y')?>  </span>
            </div>
        </div>
        <div class="card shadow mt-2">
        <div class="card-header bg-secondary">
        Data Nama Siswa 
        </div>
            <div class="card-body">
            <div style="overflow-x:auto;">
            <form action="/input/absen/keputrian" method="POST">
            {{csrf_field()}}
            <input type="hidden" value="<?php echo date('Y-m-d')?> " name="tgl_absen_keputrian">
            <table id="example" class="table table-striped table-bordered nowrap mt-3 text-center" style="overflow-x:auto;">
            <input type="hidden" name="instruktur_keputrian_id" value="{{$keputrian->instruktur_keputrian_id}}">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th> Nama</th>
                    <th>Rayon</th>
                    <td>Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    
                    <tr class="data-row">
                    <td class="align-middle iteration"> </td>
                    <td class="align-middle nis">{{$s->nis}} <input name="siswa[]" type="hidden" value="{{$s->id}}">  <input type="hidden" name="keputrian_id" value="{{$keputrian->id_keputrian}}"> </td>
                    <td class="align-middle name">{{$s->nama}}</td>
                    <td class="align-middle word-break description2">{{$s->nama_rayon}}</td>
                    <td>
                    <select name="keterangan[]" id="keterangan" class="form-control">
                        <option value="H">Hadir</option>
                        <option value="I">Ijin</option>
                        <option value="S">Sakit</option>
                        <option value="A">Alpa</option>
                    </select>

                     </td>
                    </tr>
                    @endforeach
                </tfoot>
            </table>
            </div>
            <button class="btn btn-primary float-right mt-5">Simpan Data</button>
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