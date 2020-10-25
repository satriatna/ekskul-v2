@extends('layouts.layout')
@section('content')

@if($ambil_nama == null)

<title>
    Data Kehadiran Siswa Ekskul Biasa {{$ambil_ekskul_biasa->nama_ekskul_biasa}} - Aplikasi Pemilihan Senbud UPD
 </title>

 <div class="header pb-6 d-flex align-items-center" style="min-height: 300px; background-image: url(../../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid">

                <div class="row">
                    <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white"> 
                                Data Kehadiran Ekskul Biasa : <span class="text-white" style="font-weight: bold">{{$ambil_ekskul_biasa->nama_ekskul_biasa}} </span> <br>
                                Nama @if($ambil_user->jk == "L") Siswa : @else Siswi : @endif<span class="text-white" style="font-weight: bold">{{$ambil_user->nama}} </span>
                                </h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                    </div>
                  
        </div>
      </div>
    </div>
    
    <div class="container-fluid mt--7">

      <div class="row">
      <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="{{url('/assets/img/brand/latar_foto.jpg')}}" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="{{url('/assets/img/database/'.$ambil_user->foto)}}" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
             
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-5">
                    <div>
                      <span class="heading">0</span>
                      <span class="description">Hadir</span>
                    </div>
                    <div>
                      <span class="heading">0</span>
                      <span class="description">Ijin</span>
                    </div>
                    <div>
                      <span class="heading">0</span>
                      <span class="description">Sakit</span>
                    </div>
                    <div>
                      <span class="heading">0</span>
                      <span class="description">Alpa</span>
                    </div>
                  </div>
                </div>
                
              </div>
             
            </div>
          </div>
          
        </div>
         <div class="col-xl-8 order-xl-2">
         <div class="card geser">
            <div class="card-header">
              Absensi {{$ambil_user->nama}}
            </div>
              
            <div class="card-body">
                  <div style="overflow-x:auto;">
                      <table id="example" class="table table-striped table-bordered nowrap mt-3" style="overflow-x:auto;">
                        <thead>
                          <tr>
                              <th>#</th>
                              <th>Tanggal</th>
                              <th>Keterangan</th>
                              <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td colspan="4" class="text-center">Tidak ditemukan data</td>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
          </div> 
        </div>
        
      </div>
    </div>

        </div>
      </div>
    </div>
@else 






<title>
    Data Kehadiran Siswa Ekskul Biasa {{$ambil_nama->nama_ekskul_biasa}} - Aplikasi Pemilihan Senbud UPD
 </title>
<!-- Header -->
<div class="header pb-6 d-flex align-items-center" style="min-height: 300px; background-image: url(../../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid">

                <div class="row">
                    <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white"> 
                                Data Kehadiran Ekskul Biasa : <span class="text-white" style="font-weight: bold">{{$ambil_nama->nama_ekskul_biasa}} </span> <br>
                                Nama @if($ambil_nama->jk == "L") Siswa : @else Siswi : @endif<span class="text-white" style="font-weight: bold">{{$ambil_nama->nama}} </span>
                                </h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
                <div class="card bg-none border-0 ml-3 export-geser">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">
                                <a href="/export/kehadiran_ekskul_biasa_persiswa_export/{{$ambil_user->id}}" class="btn btn-primary btn-block">Export Excel
                  </a> 
                                </h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
         
        </div>
      </div>
    </div>
    
    <br>
    <div class="container-fluid mt--7">

      <div class="row">
      <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="{{url('/assets/img/brand/latar_foto.jpg')}}" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="{{url('/assets/img/database/'.$ambil_nama->foto)}}" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
             
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-5">
                    <div>
                      <span class="heading">{{$hadir->count()}}</span>
                      <span class="description">Hadir</span>
                    </div>
                    <div>
                      <span class="heading">{{$ijin->count()}}</span>
                      <span class="description">Ijin</span>
                    </div>
                    <div>
                      <span class="heading">{{$sakit->count()}}</span>
                      <span class="description">Sakit</span>
                    </div>
                    <div>
                      <span class="heading">{{$alpa->count()}}</span>
                      <span class="description">Alpa</span>
                    </div>
                  </div>
                </div>
                
              </div>
             
            </div>
          </div>
          
        </div>
         <div class="col-xl-8 order-xl-2">
         <div class="card geser">
            <div class="card-header">
              Absensi {{$ambil_nama->nama}}
            </div>
              
            <div class="card-body">
                  <div style="overflow-x:auto;">
                      <table id="example" class="table table-striped table-bordered nowrap mt-3" style="overflow-x:auto;">
                        <thead>
                          <tr>
                              <th>#</th>
                              <th>Tanggal</th>
                              <th>Keterangan</th>
                              <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $s)
                            <tr>
                            <td></td>
                              <td>{{$s->tgl_absen_ekskul_biasa_detail}}</td>
                              <td>{{$s->keterangan_absen_ekskul_biasa}}</td>
                              <td>
                              <form action="/data_ekskul_biasa_siswa_ubah" method="GET">
                                  <input type="hidden" name="id_absen_ekskul_biasa" value="{{$s->id_absen_ekskul_biasa}}">
                                  <input type="hidden" name="ekskul_biasa_id_absen" value="{{$s->ekskul_biasa_id_absen}}">
                                  <input type="hidden" name="users_absen_ekskul_biasa_id" value="{{$s->users_absen_ekskul_biasa_id}}">
                                  <button class="btn btn-primary btn-sm">Edit</button>
                              </form>
                              </td>
                          </tr>
                            @endforeach
                        </tfoot>
                      </table>
                  </div>
                </div>
          </div> 
        </div>
        
      </div>
    </div>

        </div>
      </div>
    </div>
      
@endif
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
</body>
@endsection