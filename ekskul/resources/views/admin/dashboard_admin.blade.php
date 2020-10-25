@extends('layouts.layout')
@section('content')
<title>
    Dashboard Admin - Aplikasi Pemilihan Senbud UPD
</title>
<style>
#myDIV {
  width: 100%;
  background-color: none;
  margin-top: 20px;
  display: none;
}
</style>

<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid mt-5">
        <div class="header-body mt-5">
          <!-- Card stats -->
          <div class="row w3-animate-right">

          <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Banyak Siswa</h5>
                      <span class="h2 font-weight-bold mb-0">{{$banyak_siswa->count()}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <a href="/banyak/siswa" class="btn btn-primary btn-block">Lihat Detail</a>
                  </p>
                </div>
              </div>
            </div>
          <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Sudah Memilih</h5>
                      <span class="h2 font-weight-bold mb-0">{{{$sudah_memilih->count()}}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-check"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <a href="/sudah/memilih" class="btn btn-primary btn-block">Lihat Detail</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Belum Memilih</h5>
                      <span class="h2 font-weight-bold mb-0">{{{$belum_memilih->count()}}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-times-circle"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <a href="/belum/memilih" class="btn btn-primary btn-block">Lihat Detail</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Alpa > 3</h5>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <button onclick="myFunction()" id="pencet" class="btn btn-primary btn-block">Lihat Detail</button>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6 mt-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Tidak Masuk</h5>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                     <form action="/cari_tidak_masuk" method="GET">
                     @csrf
                      <div class="row">
                        <div class="col-xl-6">
                      @if( request('tanggal') !='' )
                            <input class="form-control form-control-navbar" name="tanggal" value="{{request('tanggal')}}" type="date">
                            @else
                            <input class="form-control form-control-navbar" name="tanggal" type="date">
                            @endif
                        </div>
                        <div class="col-xl-6">
                        
                      @if( request('tanggal') !='' )
                        <select name="kegiatan" id="kegiatan" class="form-control">
                            @if( request('kegiatan') =='senbud' )
                            <option value="senbud" selected>Senbud</option>
                            @else
                            <option value="senbud">Senbud</option>
                            @endif
                            @if( request('kegiatan') =='ekskul_biasa' )
                            <option value="ekskul_biasa" selected>Ekskul Biasa</option>
                            @else
                            <option value="ekskul_biasa">Ekskul Biasa</option>
                            @endif
                            @if( request('kegiatan') =='ekskul_produktif' )
                            <option value="ekskul_produktif" selected>Ekskul Produktif</option>
                            @else
                            <option value="ekskul_produktif">Ekskul Produktif</option>
                            @endif
                            @if( request('kegiatan') =='keputrian' )
                            <option value="keputrian" selected>keputrian</option>
                            @else
                            <option value="keputrian">Keputrian</option>
                            @endif
                        </select>
                      @else
                        <select name="kegiatan" id="kegiatan" class="form-control">
                            <option value="senbud">Senbud</option>
                            <option value="ekskul_biasa">Ekskul Biasa</option>
                            <option value="ekskul_produktif">Ekskul Produktif</option>
                            <option value="keputrian">Keputrian</option>
                        </select>
                      @endif
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2">Lihat Detail</button>
                     </form>
                  </p>
                </div>
              </div>
            </div>

          </div>
          
          <div id="myDIV">
              <div class="row">
                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0"> Senbud : Alpa > 3</h5>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                          </div>
                        </div>
                      </div>
                      <p class="mt-3 mb-0 text-muted text-sm">
                          <a href="/senbud_alpa_3" class="btn btn-primary btn-block">Lihat Detail</a>
                      </p>
                    </div>
                  </div>
                </div>
                
                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0"> Ekskul Biasa : Alpa > 3</h5>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                          </div>
                        </div>
                      </div>
                      <p class="mt-3 mb-0 text-muted text-sm">
                          <a href="/ekskul_biasa_alpa_3" class="btn btn-primary btn-block">Lihat Detail</a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0"> Ekskul Produktif : Alpa > 3</h5>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                          </div>
                        </div>
                      </div>
                      <p class="mt-3 mb-0 text-muted text-sm">
                          <a href="/ekskul_produktif_alpa_3" class="btn btn-primary btn-block">Lihat Detail</a>
                      </p>
                    </div>
                  </div>
                </div>
                
                <div class="col-xl-3 col-lg-6">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0"> Keputrian : Alpa > 3</h5>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                          </div>
                        </div>
                      </div>
                      <p class="mt-3 mb-0 text-muted text-sm">
                          <a href="/keputrian_alpa_3" class="btn btn-primary btn-block">Lihat Detail</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
        </div>
      </div>
    </div>
    
  @if( request('tanggal') !="")
  <br>
  <br>
  <br>
  <div class="container-fluid mt--7">

<div class="row">
  <div class="col-xl-12 mb-5 mb-xl-0">
  @if( request('kegiatan') =="senbud")
    <div class="card shadow">
          <div class="card-header bg-transparent">
          <form action="/export_senbud_tidak_masuk" method="GET">
              @csrf
              <input type="hidden" name="tgl" value="{{ request('tanggal')}}">
              <button class="btn btn-md btn-primary">Export</button>
          </form>
          </div>
      <div class="card-body">
      <div style="overflow-x:auto;">
      <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Nama</th>
                    <th> Nama</th>
                    <th> Rayon</th>
                    <th> Nama Senbud</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($cek as $r)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle name">{{$r->nis}} </td>
                    <td class="align-middle name">{{$r->nama}} </td>
                    <td class="align-middle name">{{$r->inisial_rayon}} </td>
                    <td class="align-middle name">{{$r->nama_senbud}} </td>
                </tr>
                @endforeach
                </tbody>
            </table>
      </div>
      </div>
    </div>
    @elseif( request('kegiatan') =="ekskul_biasa")
    
    <div class="card shadow">
          <div class="card-header bg-transparent">
          <form action="/export_ekskul_biasa_tidak_masuk" method="GET">
              @csrf
              <input type="hidden" name="tgl" value="{{ request('tanggal')}}">
              <button class="btn btn-md btn-primary">Export</button>
          </form>
          </div>
      <div class="card-body">
      <div style="overflow-x:auto;">
      <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Nama</th>
                    <th> Nama</th>
                    <th> Rayon</th>
                    <th> Nama Ekskul Biasa</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($cek as $r)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle name">{{$r->nis}} </td>
                    <td class="align-middle name">{{$r->nama}} </td>
                    <td class="align-middle name">{{$r->inisial_rayon}} </td>
                    <td class="align-middle name">{{$r->nama_ekskul_biasa}} </td>
                </tr>
                @endforeach
                </tbody>
            </table>
      </div>
      </div>
    </div>
    @elseif( request('kegiatan') =="ekskul_produktif")
    
    <div class="card shadow">
          <div class="card-header bg-transparent">
          <form action="/export_ekskul_produktif_tidak_masuk" method="GET">
              @csrf
              <input type="hidden" name="tgl" value="{{ request('tanggal')}}">
              <button class="btn btn-md btn-primary">Export</button>
          </form>
          </div>
      <div class="card-body">
      <div style="overflow-x:auto;">
      <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Nama</th>
                    <th> Nama</th>
                    <th> Rayon</th>
                    <th> Nama Ekskul Produktif</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($cek as $r)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle name">{{$r->nis}} </td>
                    <td class="align-middle name">{{$r->nama}} </td>
                    <td class="align-middle name">{{$r->inisial_rayon}} </td>
                    <td class="align-middle name">{{$r->nama_ekskul_produktif}} </td>
                </tr>
                @endforeach
                </tbody>
            </table>
      </div>
      </div>
    </div>
    @elseif( request('kegiatan') =="keputrian")
    
    <div class="card shadow">
          <div class="card-header bg-transparent">
          <form action="/export_keputrian_tidak_masuk" method="GET">
              @csrf
              <input type="hidden" name="tgl" value="{{ request('tanggal')}}">
              <button class="btn btn-md btn-primary">Export</button>
          </form>
          </div>
      <div class="card-body">
      <div style="overflow-x:auto;">
      <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Nama</th>
                    <th> Nama</th>
                    <th> Rayon</th>
                    <th> Nama Keputrian</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($cek as $r)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle name">{{$r->nis}} </td>
                    <td class="align-middle name">{{$r->nama}} </td>
                    <td class="align-middle name">{{$r->inisial_rayon}} </td>
                    <td class="align-middle name">{{$r->nama_keputrian}} </td>
                </tr>
                @endforeach
                </tbody>
            </table>
      </div>
      </div>
    </div>
    @endif
  </div>
  
</div>

</div>
</div>
        @endif
        
  

    </div>
  </div>
  
  @if( request('tanggal') !="")
  @push('scripts')
  
    <script>
   $(document).ready(function() {
  /**
   * for showing edit item popup
   */

  $(document).on('click', "#edit-item", function() {
    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function() {
    var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var id = el.data('item-id');
    var name = row.children(".name").text();
    var description = row.children(".description").text();

    // fill the data in the input fields
    $("#modal_input_id").val(id);
    $("#modal_input_name").val(name);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})




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
@endif
  <script>
function myFunction() {
  var x = document.getElementById("myDIV");
  var y = document.getElementById("pencet");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function cari() {
  var x = document.getElementById("myDIV");
  var y = document.getElementById("pencet");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>



  @endsection