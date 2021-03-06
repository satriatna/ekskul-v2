@extends('layouts.layout')
@section('content')

<title>
    Ubah Kehadiran Siswa Ekskul Biasa {{$siswa->nama_ekskul_biasa}} - Aplikasi Pemilihan ekskul_biasa UPD
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
                                Data Kehadiran Ekskul Biasa : <span class="text-white" style="font-weight: bold">{{$siswa->nama_ekskul_biasa}} </span> <br>
                                Nama @if($siswa->jk == "L") Siswa : @else Siswi : @endif<span class="text-white" style="font-weight: bold">{{$siswa->nama}} </span>
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
         <div class="col-xl-5 order-xl-2">
          <div class="card geser">
              <div class="card-header">
                Ubah Absensi Tanggal : {{$siswa->tgl_absen_ekskul_biasa_detail}}
              </div>
                
              <div class="card-body">
                  <form method="POST" action="/data_ekskul_biasa_siswa_ubah_post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_absen_ekskul_biasa" value="{{$siswa->id_absen_ekskul_biasa}}">
                  <input type="hidden" name="tgl_absen_ekskul_biasa_detail" value="{{$siswa->tgl_absen_ekskul_biasa_detail}}">
                  <input type="hidden" name="id_2" value="{{$siswa->ekskul_biasa_id_absen}}">
                  <input type="hidden" name="id_3" value="{{$siswa->users_absen_ekskul_biasa_id}}">
                    <div class="form-group">
                        <label for="keterangan_absen_ekskul_biasa">Keterangan Absen</label>
                        <select name="keterangan_absen_ekskul_biasa" id="keterangan_absen_ekskul_biasa" class="form-control">
                            @if($siswa->keterangan_absen_ekskul_biasa =="H")
                            <option value="H" selected>H</option>
                            @else
                            <option value="H">H</option>
                            @endif
                            @if($siswa->keterangan_absen_ekskul_biasa =="S")
                            <option value="S" selected>S</option>
                            @else
                            <option value="S">S</option>
                            @endif
                            @if($siswa->keterangan_absen_ekskul_biasa =="I")
                            <option value="I" selected>I</option>
                            @else
                            <option value="I">I</option>
                            @endif
                            @if($siswa->keterangan_absen_ekskul_biasa =="A")
                            <option value="A" selected>A</option>
                            @else
                            <option value="A">A</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-md">Ubah</button>
                  </form>
              </div>
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


</script>
@endpush
</body>
@endsection