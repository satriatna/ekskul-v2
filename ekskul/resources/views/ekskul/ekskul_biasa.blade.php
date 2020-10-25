@extends('layouts.layout')
@section('content')
<title>
    Data Ekskul Biasa - Aplikasi Pemilihan Senbud UPD
</title>
<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid" style="margin-top:-100px !important;">

      <div class="row">
                    <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Ekskul Biasa </span></h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
         
        </div>
      </div>

    </div>
      <div class="container-fluid mt--7" style="margin-top:-210px !important;">

      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent">
            @if(Auth::user()->level =='Pengurus')
            <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#exampleModal">
                Tambah Senbud
                </button>
                @endif
            </div>
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Nama Ekskul Biasa</th>
                    <th> Hari</th>
                    <th> Kuota</th>
                    <th> Sisa Kuota</th>
                    <th> Instruktur</th>
                    <th> Aksi</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($ekskul_biasa as $s)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle name">{{$s->nama_ekskul_biasa}}</td>
                    <td class="align-middle hari">{{$s->hari_ekskul_biasa}}</td>
                    <td class="align-middle kuota">{{$s->kuota_ekskul_biasa}}</td>
                    <td class="align-middle kuota">{{$s->sisa_kuota_ekskul_biasa}}</td>
                    <td class="align-middle kuota">
                      @if($s->instruktur_ekskul_biasa_id == 0)
                        Belum Ada Instruktur
                      @else
                        <a href="/instruktur/detail/{{$s->instruktur_ekskul_biasa_id}}" class="btn btn-primary btn-sm">Lihat</a>
                      @endif
                    </td>
                    <td class="align-middle">
                    <a href="/ekskul_biasa/detail/{{$s->id_ekskul_biasa}}/{{$s->instruktur_ekskul_biasa_id}}" class="btn btn-info btn-sm">Detail</a>
                    <!-- <a href="/ekskul_biasa/hapus/{{$s->id_ekskul_biasa}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-danger btn-sm">Hapus</a> -->
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
        
      </div>
     
    </div>
  </div>
  

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Ekskul Biasa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/ekskul_biasa/store" method="POST">
        {{csrf_field()}}
        
        <div class="form-group">
                <label for="kuota">Instruktur</label>
                <select name="instruktur_ekskul_biasa_id" id="instruktur_ekskul_biasa_id" class="form-control">
                <option value="0">Instruktur Belum Ada</option>

                    @foreach($instruktur as $i)
                        <option value="{{$i->id}}">{{$i->nama}}</option>
                    @endforeach

                </select>
            </div>
        <div class="form-group">
                <label for="nama"> Nama Ekskul Biasa</label>
                <input type="text" class="form-control" name="nama_ekskul_biasa" value="{{ old('nama_ekskul_biasa') }}">
                @if ($errors->has('nama_ekskul_biasa'))
                    <div class="error">Gagal : Nama Ekskul Biasa tersebut telah digunakan sebelumnya</div>
                @endif
            </div>
            <div class="form-group">
                <label for="hari">Hari</label>
                <input required type="text" class="form-control" name="hari" value="{{ old('hari') }}">
            </div>
            <div class="form-group">
                <label for="kuota">Kuota</label>
                <input required type="number" class="form-control" name="kuota" value="{{ old('kuota') }}">
            </div>
            <div class="form-group">
                <label for="deskripsi_kegiatan_ekskul_biasa">Deskripsi Kegiatan</label>
                <input required type="text" class="form-control" name="deskripsi_kegiatan_ekskul_biasa" value="{{ old('deskripsi_kegiatan_ekskul_biasa') }}">
            </div>
              <div class="row">
              <button class="btn btn-md btn-primary ml-3">Tambah</button>
                </form>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Close</button>
              </div>
            
      </div>
    
    </div>
  </div>
</div>
</div>

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
    var hari = row.children(".hari").text();
    var kuota = row.children(".kuota").text();
    var nama_instruktur = row.children(".nama_instruktur").text();

    // fill the data in the input fields
    $("#modal_input_id").val(id);
    $("#modal_input_name").val(name);
    $("#modal_input_hari").val(hari);
    $("#modal_input_kuota").val(kuota);
    $("#modal_input_nama_instruktur").val(nama_instruktur);

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
  @endsection