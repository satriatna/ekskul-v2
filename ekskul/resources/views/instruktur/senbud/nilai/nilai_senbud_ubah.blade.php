@extends('layouts.layout')
@section('content')

<title>
    Ubah Nilai Siswa Senbud {{$nilai->nama_senbud}} - Aplikasi Pemilihan Senbud UPD
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
                                Data Nilai Senbud : <span class="text-white" style="font-weight: bold">{{$nilai->nama_senbud}} </span> <br>
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
                Ubah Nilai : {{$nilai->keterangan_nilai_senbud_detail}}
              </div>
                
              <div class="card-body">
                  <form method="POST" action="/nilai_senbud_ubah_post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_nilai_senbud" value="{{$nilai->id_nilai_senbud}}">
                  <input type="hidden" name="senbud_nilai_senbud_id" value="{{$nilai->senbud_nilai_senbud_id}}">
                  <input type="hidden" name="keterangan" value="{{$nilai->keterangan_nilai_senbud_detail}}">
                    <div class="form-group">
                        <label for="nilai_sikap_senbud">Nilai Sikap</label>
                        <select name="nilai_sikap_senbud" id="nilai_sikap_senbud" class="form-control" id="nilai_sikap_senbud">
                            @if($nilai->nilai_sikap_senbud =="Kurang")
                            <option value="Kurang" selected>Kurang</option>
                            @else
                            <option value="Kurang">Kurang</option>
                            @endif
                            @if($nilai->nilai_sikap_senbud =="Cukup")
                            <option value="Cukup" selected>Cukup</option>
                            @else
                            <option value="Cukup">Cukup</option>
                            @endif
                            @if($nilai->nilai_sikap_senbud =="Baik")
                            <option value="Baik" selected>Baik</optBaikon>
                            @else
                            <option value="Baik">Baik</option>
                            @endif
                            @if($nilai->nilai_sikap_senbud =="Sangat Baik")
                            <option value="Sangat Baik" selected>Sangat Baik</option>
                            @else
                            <option value="Sangat Baik">Sangat Baik</option>
                            @endif
                        </select>
                        <label for="nilai_pengetahuan_senbud">Nilai Pengetahuan</label>
                        <input type="text" value="{{$nilai->nilai_pengetahuan_senbud}}" name="nilai_pengetahuan_senbud" class="form-control" id="nilai_pengetahuan_senbud">
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