@extends('layouts.layout')
@section('content')

<title>
    Ubah Kehadiran Siswa Senbud {{$instruktur->nama_senbud}} - Aplikasi Pemilihan Senbud UPD
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
                                Data Kehadiran Instruktur : <span class="text-white" style="font-weight: bold">{{$instruktur->nama}} </span> <br>
                                Nama Senbud : <span class="text-white" style="font-weight: bold">{{$instruktur->nama_senbud}} </span>
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
                Ubah Absensi Tanggal : {{$instruktur->tgl_absen_instruktur_senbud_detail}}
              </div>
                
              <div class="card-body">
                  <form method="POST" action="/data_kehadiran_instruktur_senbud_ubah_post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_absen_instruktur_senbud" value="{{$instruktur->id_absen_instruktur_senbud}}">
                    <div class="form-group">
                        <label for="keterangan_absen_instruktur_senbud">Keterangan Absen</label>
                        <select name="keterangan_absen_instruktur_senbud" id="keterangan_absen_instruktur_senbud" class="form-control">
                            @if($instruktur->keterangan_absen_instruktur_senbud =="H")
                            <option value="H" selected>H</option>
                            @else
                            <option value="H">H</option>
                            @endif
                            @if($instruktur->keterangan_absen_instruktur_senbud =="S")
                            <option value="S" selected>S</option>
                            @else
                            <option value="S">S</option>
                            @endif
                            @if($instruktur->keterangan_absen_instruktur_senbud =="I")
                            <option value="I" selected>I</option>
                            @else
                            <option value="I">I</option>
                            @endif
                            @if($instruktur->keterangan_absen_instruktur_senbud =="A")
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