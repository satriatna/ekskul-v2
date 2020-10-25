@extends('layouts.layout')
@section('content')
  
 <title>
    Input Absen Keputrian - Aplikasi Pemilihan Senbud UPD
 </title>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid" style="margin-top:-60px !important;">

        <div class="header-body mt-5">
        </div>
        <div class="card col-xl-4">
            <div class="card-body">
                <span class="mr-3" style="font-size:16px; font-weight:bold;">Input Absen Instruktur <br> Tanggal : <?php echo date('d-m-Y')?> <br> Nama Instruktur : {{$keputrian->nama}} <br>  </span>
            </div>
        </div>
        <div class="card shadow mt-2">
            <div class="card-body">
            <div style="overflow-x:auto;">
            <form action="/input_absen_instruktur_keputrian" method="POST">
            <input type="hidden" name="keputrian_id" value="{{$keputrian->id_keputrian}}"> 
            <input type="hidden" name="instruktur_keputrian_id" value="{{$keputrian->instruktur_keputrian_id}}"> 
            {{csrf_field()}}
            <input type="hidden" value="<?php echo date('Y-m-d')?> " name="tgl_absen_instruktur_keputrian">
            <table id="example" class="table table-striped table-bordered nowrap mt-3 text-center" style="overflow-x:auto;">
                <thead>
                    <tr>
                    <th>#</th>
                    <th> Nama</th>
                    <th> Email</th>
                    <td>Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="data-row">
                    <td class="align-middle iteration"> </td>
                    <td class="align-middle name">{{$keputrian->nama}}</td>
                    <td class="align-middle name">{{$keputrian->email}}</td>
                    <td>
                    <select name="keterangan" id="keterangan" class="form-control" required>
                        <option value="">Belum di absen</option>
                        <option value="H">Hadir</option>
                        <option value="I">Ijin</option>
                        <option value="S">Sakit</option>
                        <option value="A">Alpa</option>
                    </select>

                     </td>
                    </tr>
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