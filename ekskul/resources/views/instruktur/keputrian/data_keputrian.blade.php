@extends('layouts.layout')
@section('content')
<title>
    Data Keputrian {{$keputrian->nama_keputrian}} - Aplikasi Pemilihan Senbud UPD
 </title>
  <body onload="script();">
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid" style="margin-top:-60px !important;">

    <div class="header-body mt-5">
          <!-- Card stats -->   
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0"> Data Keputrian <br> <span class="text-bold" style="font-weight: bold">{{$keputrian->nama_keputrian}}  </span> <br> </h5>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fas fa-chart-pie"></i>
                        </div>
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
                        <h5 class="card-title text-uppercase text-muted mb-0"> Jumlah Siswa <br> <span class="text-bold" style="font-weight: bold">@if($siswa->count() == '') 0 @else {{$siswa->count()}} </span>  @endif </h5>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fas fa-users"></i>
                        </div>
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
                        <h5 class="card-title text-uppercase text-muted mb-0"> Alpa > 3 <br> <span class="text-bold" style="font-weight: bold">@if($alpa->count() =='' ) 0 @else {{$alpa->count()}} @endif</h5>
                      </div>
                      <div class="col-auto">
                          <form action="/filter_keputrian_alpa" method="GET">
                              <input type="hidden">
                              @if($alpa->count() =='' )
                          <button type="submit" class="btn btn-primary" disabled>Filter</button>
                          @else
                          <input type="hidden" name="id_keputrian" value="{{$keputrian->id_keputrian}}">
                          <button type="submit" class="btn btn-primary">Filter</button>
                          @endif
                          </form>
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 mt-3">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form action="/input/absen/keputrian" method="GET">
                            <input type="hidden" name="keputrian_id" value="{{$keputrian->id_keputrian}}">
                                <button class="btn btn-primary float-right btn-block">Input Absen</button>
                                
                            </form>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 mt-3">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0"> <a href="/kehadiran/keputrian/{{$keputrian->id_keputrian}}" class="btn btn-primary btn-block">Lihat Kehadiran</a>   </h5>
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 mt-3">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0"> <a href="/export/data_keputrian/{{$keputrian->id_keputrian}}" class="btn btn-primary btn-block">Export Excel</a> </h5>
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>

          </div>
        </div>
    </div>
    </div>
    <div class="container-fluid mt--7" style="margin-top:-100px !important;">

      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
            <div class="card-header">
                Data Siswa
            </div>
                <div class="card-body">
                    <div class="card-body">
                        <div style="overflow-x:auto;">
                        <table id="example" class="table table-striped table-bordered nowrap mt-3" style="overflow-x:auto;">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>NIS</th>
                                <th> Nama</th>
                                <th> Rombel</th>
                                <th>Rayon</th>
                                <th> Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswa as $s)
                                <tr class="data-row">
                                <td class="align-middle iteration"></td>
                                <td class="align-middle nis">{{$s->nis}}</td>
                                <td class="align-middle name">{{$s->nama}}</td>
                                <td class="align-middle word-break description">{{$s->nama_rombel}}</td>
                                <td class="align-middle word-break description2">{{$s->nama_rayon}}</td>
                                <td class="align-middle">
                                <a href="/data/keputrian/siswa/{{$s->id}}/{{$s->keputrian_id}}" class="btn btn-sm btn-info">Lihat </a>
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

function script()
{
    var tanggal = document.getElementById('tanggal').value;
    var tanggal=new Date();
    var tgl2= tgl.getDate();alert(tgl2);
}
</script>
@endpush
</body>
@endsection