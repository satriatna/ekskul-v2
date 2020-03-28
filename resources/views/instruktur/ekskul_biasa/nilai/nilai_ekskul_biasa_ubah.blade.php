@extends('layouts.layout')
@section('content')

<title>
    Ubah Nilai Siswa Ekskul Biasa {{$nilai->nama_ekskul_biasa}} - Aplikasi Pemilihan Senbud UPD
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
                                Data Nilai Ekskul Biasa : <span class="text-white" style="font-weight: bold">{{$nilai->nama_ekskul_biasa}} </span> <br>
                                Nama @if($nilai->jk == "L") Siswa : @else Siswi : @endif<span class="text-white" style="font-weight: bold">{{$nilai->nama}} </span>
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
                Ubah Nilai : {{$nilai->keterangan_nilai_ekskul_biasa_detail}}
              </div>
                
              <div class="card-body">
                  <form method="POST" action="/nilai_ekskul_biasa_ubah_post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_nilai_ekskul_biasa" value="{{$nilai->id_nilai_ekskul_biasa}}">
                  <input type="hidden" name="ekskul_biasa_nilai_ekskul_biasa_id" value="{{$nilai->ekskul_biasa_nilai_ekskul_biasa_id}}">
                  <input type="hidden" name="keterangan" value="{{$nilai->keterangan_nilai_ekskul_biasa_detail}}">
                    <div class="form-group">
                        <label for="nilai_sikap_ekskul_biasa">Nilai Sikap</label>
                        <select name="nilai_sikap_ekskul_biasa" id="nilai_sikap_ekskul_biasa" class="form-control" id="nilai_sikap_ekskul_biasa">
                            @if($nilai->nilai_sikap_ekskul_biasa =="Kurang")
                            <option value="Kurang" selected>Kurang</option>
                            @else
                            <option value="Kurang">Kurang</option>
                            @endif
                            @if($nilai->nilai_sikap_ekskul_biasa =="Cukup")
                            <option value="Cukup" selected>Cukup</option>
                            @else
                            <option value="Cukup">Cukup</option>
                            @endif
                            @if($nilai->nilai_sikap_ekskul_biasa =="Baik")
                            <option value="Baik" selected>Baik</optBaikon>
                            @else
                            <option value="Baik">Baik</option>
                            @endif
                            @if($nilai->nilai_sikap_ekskul_biasa =="Sangat Baik")
                            <option value="Sangat Baik" selected>Sangat Baik</option>
                            @else
                            <option value="Sangat Baik">Sangat Baik</option>
                            @endif
                        </select>
                        <label for="nilai_pengetahuan_ekskul_biasa">Nilai Pengetahuan</label>
                        <input type="text" value="{{$nilai->nilai_pengetahuan_ekskul_biasa}}" name="nilai_pengetahuan_ekskul_biasa" class="form-control" id="nilai_pengetahuan_ekskul_biasa">
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