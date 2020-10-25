@extends('layouts.layout')
@section('content')

<title>
    Detail Data Kehadiran Ekskul Biasa {{$nama_ekskul_biasa->nama_ekskul_biasa}} Tanggal : {{$ambil_tanggal->tgl_absen_ekskul_biasa_detail}}- Aplikasi Pemilihan Senbud UPD
 </title>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid">

      <div class="row">
      <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0"> Kehadiran Ekskul Biasa :  <span class="text-bold" style="font-weight: bold"> {{$nama_ekskul_biasa->nama_ekskul_biasa}} </span> <br>  Tanggal :  <span class="text-bold" style="font-weight: bold"> {{$ambil_tanggal->tgl_absen_ekskul_biasa_detail}}</span> <br> </h5>
                      </div>
                      <div class="col-auto">
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">   
                        <div class="row">
                          <div class="col-5">
                          Hadir : {{$hadir->count()}} <br>
                          Ijin : {{$ijin->count()}} 
                          </div>
                          <div class="col-6">
                          Sakit : {{$sakit->count()}} <br>
                          Alpa : {{$alpa->count()}}
                          </div>
                        </div>
                      </div>
                      <div class="col-auto">
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>
              <br>
        
              <div class="col-xl-4 col-lg-6 m-0 export-geser">
                  <div class="card">
                  <a href="/export/kehadiran_ekskul_biasa_export/{{$ambil_tanggal->tgl_absen_ekskul_biasa_detail}}/{{$nama_ekskul_biasa->id_ekskul_biasa}}" class="btn btn-primary btn-block">Export Excel
                  </a> 
                  </div>
              </div>
              <br>
         
        </div>
        </div>
      </div>

    <div class="container-fluid mt--7 ">

      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
           
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Rayon</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($absen_ekskul_biasa as $absen)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle nis">{{$absen->nis}}</td>
                    <td class="align-middle nama">{{$absen->nama}}</td>
                    <td class="align-middle nama_rayon">{{$absen->nama_rayon}}</td>
                    <td class="align-middle keterangan_absen_ekskul_biasa">{{$absen->keterangan_absen_ekskul_biasa}}</td>
                    <td class="align-middle">
                    <form action="/data_kehadiran_ekskul_biasa_ubah" method="GET">
                                  <input type="hidden" name="id_absen_ekskul_biasa" value="{{$absen->id_absen_ekskul_biasa}}">
                                  <input type="hidden" name="ambil_tanggal" value="{{$ambil_tanggal->tgl_absen_ekskul_biasa_detail}}">
                                  <input type="hidden" name="users_absen_ekskul_biasa_id" value="{{$absen->users_absen_ekskul_biasa_id}}">
                                  <button class="btn btn-primary btn-sm">Edit</button>
                              </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
          </div>
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

  function myFunction() {
    var x = document.getElementById("modal_input_keterangan_absen_ekskul_biasa");
    
    x.value = x.value.toUpperCase();
    if(x.value != 'S' || x.value != 'A' )
    {
        x.value=""
        alert('Hanya boleh diisi dengan huruf " H / S / I / A " ')
    }
  
  }
</script>
    @endpush
  @endsection