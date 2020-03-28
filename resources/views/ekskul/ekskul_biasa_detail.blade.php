@extends('layouts.layout')
@section('content')
<title>
    Data Ekskul Biasa {{$nama_ekskul_biasa->nama_ekskul_biasa}} - Aplikasi Pemilihan Senbud UPD
 </title>
 <style>
 #upload{
    display:none
}

@media screen and (max-width: 992px) {
  .geser_button_atas {
    margin-top: 20px !important;
  }
  }
 </style>
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
                        <h5 class="card-title text-uppercase text-muted mb-0"> Data Ekskul Biasa <br> <span class="text-bold" style="font-weight: bold">{{$nama_ekskul_biasa->nama_ekskul_biasa}}  </span> <br> </h5>
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
                          <form action="/filter_ekskul_biasa_alpa" method="GET">
                              <input type="hidden">
                              @if($alpa->count() =='' )
                          <button type="submit" class="btn btn-primary" disabled>Filter</button>
                          @else
                          <input type="hidden" name="id_ekskul_biasa" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                          <button type="submit" class="btn btn-primary">Filter</button>
                          @endif
                          </form>
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>

          </div>
        </div>
    </div>
    </div>
<div class="container-fluid mt--7">

<div class="row">
  <div class="col-xl-12 mb-5 mb-xl-0">
    <div class="card shadow">
      <div class="card-body">
      @if(Auth::user()->level != 'Pengurus')
      
      <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data Siswa</a>
          </li>
          <li class="nav-item">
              <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                
              <form action="/input/absen/ekskul_biasa" method="GET">
                  <input type="hidden" name="ekskul_biasa_id" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                  <input type="hidden" name="instruktur_ekskul_biasa_id" value="{{$nama_ekskul_biasa->instruktur_ekskul_biasa_id}}">
                  @if($siswa->count() != 0)
                  <button type="submit" class="dropdown-item" style="cursor:pointer">Input Absen</button>
                  @else
                  <a class="dropdown-item" style="cursor:pointer" onclick="alert('Tidak ada siswa yang mengikuti ekskul_biasa ini')">Input Absen</a>
                  @endif
              </form>
                @if(Auth::user()->level == "Instruktur")
                @else
                <form action="/input_absen_instruktur_ekskul_biasa" method="GET">
                  <input type="hidden" name="ekskul_biasa_id" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                  @if($nama_ekskul_biasa->instruktur_ekskul_biasa_id == 0)
                      <button class="dropdown-item" disabled>Input Absen Instruktur</button>
                  @else
                      <button class="dropdown-item">Input Absen Instruktur</button>
                  @endif
                </form>
                @endif
                <a href="/kehadiran/ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}" class="dropdown-item">Lihat Kehadiran Ekskul Biasa</a>
                
                @if(Auth::user()->level =='Piket')
                @else
                <a class="dropdown-item" href="/input_nilai_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}">Input Nilai</a>
                <a class="dropdown-item" href="/lihat_nilai_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}">Lihat Nilai</a>
                @endif
                @if($nama_ekskul_biasa->instruktur_ekskul_biasa_id == 0)
                <button class="dropdown-item" disabled>Lihat Kehadiran Instruktur</button>   </h5>
                @else
                @endif
                <a class="dropdown-item" href="/export/data_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}">Export Excel</a>
                <div class="dropdown-divider"></div>
                
                @if(Auth::user()->level =='Piket')
                @else
                <a href="/kehadiran_instruktur_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}" class="dropdown-item">Lihat Kehadiran Saya</a>
                @endif
              </div>
          </li>
      </ul>
      @else
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data Siswa</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Edit</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" id="foto_sampul-tab" data-toggle="tab" href="#foto_sampul" role="tab" aria-controls="foto_sampul" aria-selected="false">Foto Sampul</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" id="portfolio-tab" data-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false">Portfolio</a>
          </li>
          <li class="nav-item">
              <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <form action="/input/absen/ekskul_biasa" method="GET">
                  <input type="hidden" name="ekskul_biasa_id" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                  <input type="hidden" name="instruktur_ekskul_biasa_id" value="{{$nama_ekskul_biasa->instruktur_ekskul_biasa_id}}">
                  @if($siswa->count() != 0)
                  <a class="dropdown-item" style="cursor:pointer">Input Absen</a>
                  @else
                  <a class="dropdown-item" style="cursor:pointer" onclick="alert('Tidak ada siswa yang mengikuti ekskul_biasa ini')">Input Absen</a>
                  @endif
              </form>
                @if(Auth::user()->level == "Instruktur")
                @else
                <form action="/input_absen_instruktur_ekskul_biasa" method="GET">
                  <input type="hidden" name="ekskul_biasa_id" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                  @if($nama_ekskul_biasa->instruktur_ekskul_biasa_id == 0)
                      <button class="dropdown-item" style="cursor:pointer" disabled>Input Absen Instruktur</button>
                  @else
                      <button class="dropdown-item" style="cursor:pointer">Input Absen Instruktur</button>
                  @endif
                </form>
                @endif
                <a href="/kehadiran/ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}" class="dropdown-item">Lihat Kehadiran Ekskul Biasa</a>
                @if($nama_ekskul_biasa->instruktur_ekskul_biasa_id == 0)
                <button class="dropdown-item" disabled>Lihat Kehadiran Instruktur</button>   </h5>
                @else
                <a href="/kehadiran_instruktur_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}" class="dropdown-item">Lihat Kehadiran Instruktur</a>   </h5>
                @endif
                <a class="dropdown-item" href="/input_nilai_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}">Input Nilai</a>
                <a class="dropdown-item" href="/lihat_nilai_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}">Lihat Nilai</a>
                <a class="dropdown-item" href="/export/data_ekskul_biasa/{{$nama_ekskul_biasa->id_ekskul_biasa}}">Export Excel</a>
              </div>
          </li>
        </ul>
        @endif
  <div class="tab-content">
    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card-body">
          <div class="card">
              <div class="card-body">
              <div style="overflow-x:auto;">
        <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">

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
                <td class="align-middle word-break description2">{{$s->inisial_rayon}}</td>
                <td class="align-middle">
                <a href="/data/ekskul_biasa/siswa/{{$s->id}}/{{$s->ekskul_biasa_id}}" class="btn btn-sm btn-info">Lihat </a>
                @if($tb_tgl_absen_ekskul_biasa =='')
                @if(Auth::user()->level !='Pengurus')
                @else
                <button type="button" class="btn btn-sm btn-primary" id="edit-item" data-item-id="{{$s->id}}">Pindahkan</button>
                @endif
                @else
                @endif
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
    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="card-body">
        <div class="card">
          <div class="card-body">
          @foreach($ekskul_biasa as $eks)
            <form action="/ekskul_biasa/update" method="POST">
              {{csrf_field()}}
                <div class="col-lg-6">
                  <input type="hidden" value="{{$eks->id_ekskul_biasa}}" name="id_ekskul_biasa">
                  <div class="form-group">
                  <label for="instruktur_ekskul_biasa_id">Nama Instruktur</label>
                  <select class="form-control select2" name="instruktur_ekskul_biasa_id" id="instruktur_ekskul_biasa_id">
                    
                  <option value="#" selected disabled>Pilih Instruktur</option>
                  @if($eks->instruktur_ekskul_biasa_id == '0')
                        <option value="0" selected>Belum Ada Instruktur</option>
                    @foreach($instruktur as $i)
                        <option value="{{$i->id}}">{{$i->nama}}</option>
                    @endforeach
                    
                    @else
                    
                    <option value="0">Belum Ada Instruktur</option>
                    @foreach($ekskul_biasa as $eks)
                      @foreach($instruktur as $i)
                        @if($i->id == $eks->instruktur_ekskul_biasa_id)
                        <option value="{{$i->id}} " selected>{{$i->nama}}</option>
                        @else
                      
                        <option value="{{$i->id}} ">{{$i->nama}}</option>
                        @endif
                    @endforeach
                  @endforeach
                      @endif
                    </select>
                </div>
                <div class="form-group">
                  <label for="nama_ekskul_biasa">Nama Ekskul</label>
                  <input type="text" class="form-control" name="nama_ekskul_biasa" id="nama_ekskul_biasa" value="{{$eks->nama_ekskul_biasa}}">
                </div>
                <div class="form-group">
                  <label for="hari_ekskul_biasa">Hari</label>
                  <input type="text" class="form-control" name="hari_ekskul_biasa" id="hari_ekskul_biasa" value="{{$eks->hari_ekskul_biasa}}">
                </div>
                <div class="form-group">
                  <label for="kuota_ekskul_biasa">Kuota</label>
                  <input type="number" class="form-control" name="kuota_ekskul_biasa" id="kuota_ekskul_biasa" value="{{$eks->kuota_ekskul_biasa}}">
                </div>
                <div class="form-group">
                  <label for="sisa_kuota_ekskul_biasa">Sisa Kuota</label>
                  <input type="number" class="form-control" name="sisa_kuota_ekskul_biasa" id="sisa_kuota_ekskul_biasa" value="{{$eks->sisa_kuota_ekskul_biasa}}">
                </div>
                <div class="form-group">
                  <label for="deskripsi_kegiatan_ekskul_biasa">Deskripsi Kegiatan</label>
                  <input type="text" class="form-control" name="deskripsi_kegiatan_ekskul_biasa" id="deskripsi_kegiatan_ekskul_biasa" value="{{$eks->deskripsi_kegiatan_ekskul_biasa}}">
                </div>
             
                </div>
                  <br>    
                  <button class="btn btn-md btn-primary ml-3">Ubah</button> <a href="/ekskul$ekskul_biasa" class="btn btn-md btn-danger">Kembali</a>  
              </form> 
            @endforeach
            </div>
          </div>
        </div>
      </div>

  
    <div class="tab-pane" id="foto_sampul" role="tabpanel" aria-labelledby="foto_sampul-tab">
      <div class="card-body">
        <div class="card">
          <div class="card-body">
            <div class="card">
            <div class="card-header">
            <form action="/ubah_foto_ekskul_biasa" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_ekskul_biasa" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                            <input id="upload" type="file" onchange="this.form.submit()" name="foto_ekskul_biasa"/>
                              <a href="" id="upload_link" class="btn btn-primary bg-gradient-primary opacity-8 text-white">Ubah Gambar</a>​
                            </form>
            </div>
              <div class="card-body">
                <div class="col-lg-6 col-md-6 portfolio-item filter-ekskul_biasa">
                  <div class="portfolio-wrap">
                        <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$nama_ekskul_biasa->foto_ekskul_biasa)}}" alt="{{ $nama_ekskul_biasa->nama_ekskul_biasa }}">
                       
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

    
    <div class="tab-pane" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">
      <div class="card-body">
        <div class="card">
          <div class="card-header">
              <div class="col-12">
                <div class="row">
                  <div class="col-lg-6">
                  
                  <form action="/upload_ekskul_biasa_foto" method="POST" enctype="multipart/form-data">
                  {{csrf_field()}}
                    <input type="file" name="foto_ekskul_biasa" class="form-control" required>
                    <input type="hidden" name="foto_ekskul_biasa_id" value="{{$nama_ekskul_biasa->id_ekskul_biasa}}">
                  </div>
                  <div class="col-lg-6 geser_button_atas">
                      <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                  </form>
                </div>
              </div>
          </div>
          <div class="card-body">
          <div style="overflow-x:auto;">
          <table id="example2" class="table table-striped table-bordered nowrap" style="overflow-x:auto;">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Gambar</th>
                <th>Gambar</th>
                <th> Aksi </th>
              </tr>
              </thead>
              <tbody>
              @foreach($gambar_ekskul_biasa as $s)
              <tr class="data-row">
                <td class="align-middle iteration"></td>
                <td class="align-middle nis">{{$s->gambar_nama_ekskul_biasa}}</td>
                <td class="align-middle nis"><img alt="Image placeholder" src="{{url('/assets/img/database/'.$s->gambar_nama_ekskul_biasa )}}" style="height: 30px !important;"></td>
                <td class="align-middle">
                <a href="/gambar_ekskul_biasa_hapus/{{$s->id_gambar_ekskul_biasa}}" class="btn btn-sm btn-info" onclick="return confirm('Anda yakin ?')">Hapus </a>
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
</div>
</div>


<!-- Attachment Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="edit-modal-label">Pindah ekskul_biasa</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body" id="attachment-body-content">
 
    <div class="card">
     
      <div class="card-body">
      <form id="edit-form" class="form-horizontal" method="POST" action="/pindahkan/ekskul_biasa">
      {{csrf_field()}}
        <!-- id -->
          <input type="hidden" name="modal_input_id" class="form-control" id="modal_input_id" required>
        <!-- /id -->
        <!-- name -->
        <div class="form-group">
          <label class="col-form-label" for="modal_input_nama">Nama</label>
          <input type="text" name="modal_input_nama" class="form-control" id="modal_input_nama" required readonly>
        </div>
        <!-- /name -->
        <label for="dari">Dari</label>
                           @foreach($ekskul_biasa as $e)
                           <input type="text" class="form-control" value="{{$e->nama_ekskul_biasa}}" readonly>
                           @endforeach
                  <br>
                  <label for="ke">Ke</label>
                       <select name="ekskul_biasaAkhir" id="ekskul_biasaAkhir" class="form-control">
                           @foreach($pindah as $p)
                           <option value="{{$p->id_ekskul_biasa}}">{{$p->nama_ekskul_biasa}}</option>
                           @endforeach
                       </select>
                  <br>
      </div>
    </div>
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-sm btn-primary">Pindahkan</button>
  </form>
  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
</div>
</div>
</div>
</div>
<!-- /Attachment Modal -->
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
    $("#modal_input_nama").val(name);
    $("#modal-input-description").val(description);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})


$(document).ready(function() {
    var t = $('#example2').DataTable( {
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
$(function(){
    $("#upload_link").on('click', function(e){
        e.preventDefault();
        $("#upload:hidden").trigger('click');
    });
});
</script>
@endpush
</body>
@endsection