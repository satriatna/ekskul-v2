@extends('layouts.layout')
@section('content')
<title>
    Filter Data Ekskul Biasa {{$nama_ekskul_biasa->nama_ekskul_biasa}} Alpa > 3 - Aplikasi Pemilihan ekskul_biasa UPD
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
                        <h5 class="card-title text-uppercase text-muted mb-0"> Data Ekskul Biasa : {{$nama_ekskul_biasa->nama_ekskul_biasa}} <br> Banyak Siswa : {{$siswa->count()}}  <br> Keterangan : Alpa > 3 <span class="text-bold" style="font-weight: bold"> </span> <br> </h5>
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

            <div class="col-xl-4 col-lg-6 mt-1">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0"> <a href="/export/data_ekskul_biasa_alpa/{{$nama_ekskul_biasa->id_ekskul_biasa}}" class="btn btn-primary btn-block">Export Excel</a> </h5>
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
                                <a href="/data/ekskul_biasa/siswa/{{$s->id}}/{{$s->ekskul_biasa_id}}" class="btn btn-sm btn-info">Detail </a>
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