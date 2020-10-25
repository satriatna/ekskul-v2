@extends('layouts.layout')
@section('content')

<title>
    Ubah Kehadiran Siswa Ekskul Produktif {{$siswa->nama_ekskul_produktif}} - Aplikasi Pemilihan ekskul_produktif UPD
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
                                Data Kehadiran Ekskul Produktif : <span class="text-white" style="font-weight: bold">{{$siswa->nama_ekskul_produktif}} </span> <br>
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
                Ubah Absensi Tanggal : {{$siswa->tgl_absen_ekskul_produktif_detail}}
              </div>
                
              <div class="card-body">
                  <form method="POST" action="/data_kehadiran_ekskul_produktif_ubah_post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_absen_ekskul_produktif" value="{{$siswa->id_absen_ekskul_produktif}}">
                  <input type="hidden" name="ekskul_produktif_id_absen" value="{{$siswa->ekskul_produktif_id_absen}}">
                  <input type="hidden" name="tgl" value="{{$siswa->tgl_absen_ekskul_produktif_detail}}">
                  <input type="hidden" name="id_2" value="{{$siswa->ekskul_produktif_id_absen}}">
                  <input type="hidden" name="id_3" value="{{$siswa->users_absen_ekskul_produktif_id}}">
                    <div class="form-group">
                        <label for="keterangan_absen_ekskul_produktif">Keterangan Absen</label>
                        <select name="keterangan_absen_ekskul_produktif" id="keterangan_absen_ekskul_produktif" class="form-control">
                            @if($siswa->keterangan_absen_ekskul_produktif =="H")
                            <option value="H" selected>H</option>
                            @else
                            <option value="H">H</option>
                            @endif
                            @if($siswa->keterangan_absen_ekskul_produktif =="S")
                            <option value="S" selected>S</option>
                            @else
                            <option value="S">S</option>
                            @endif
                            @if($siswa->keterangan_absen_ekskul_produktif =="I")
                            <option value="I" selected>I</option>
                            @else
                            <option value="I">I</option>
                            @endif
                            @if($siswa->keterangan_absen_ekskul_produktif =="A")
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