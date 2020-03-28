@extends('layouts.layout')
@section('content')
  
 <title>
    Data Kehadiran Keputrian {{$nama_keputrian->nama_keputrian}} - Aplikasi Pemilihan Senbud UPD
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
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Kehadiran Keputrian : {{$nama_keputrian->nama_keputrian}} </span></h5>
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
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Tanggal</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($tgl_absen_keputrian as $tgl)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle kuota">{{$tgl->tgl_absen_keputrian}}</td>
                    <td class="align-middle">
                    <a href="/kehadiran/keputrian/detail/{{$tgl->tgl_absen_keputrian}}/{{$tgl->tgl_absen_keputrian_id}}" class="btn btn-info btn-sm">Detail</a>
                    <a href="/kehadiran/keputrian/hapus/{{$tgl->tgl_absen_keputrian}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-danger btn-sm">Hapus</a>
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
  
<!-- Attachment Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit keputrian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-form" class="form-horizontal" method="POST" action="/keputrian/update">
         {{csrf_field()}}
                <input type="hidden" name="modal_input_id" class="form-control" id="modal_input_id" required>
              <!-- /id -->
              <!-- name -->
              <div class="form-group">
                <label class="col-form-label" for="modal_input_name">Nama keputrian</label>
                <input type="text" name="modal_input_name" class="form-control" id="modal_input_name" required autofocus>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="modal_input_hari">Nama keputrian</label>
                <input type="text" name="modal_input_hari" class="form-control" id="modal_input_hari" required autofocus>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="modal_input_kuota">Nama keputrian</label>
                <input type="text" name="modal_input_kuota" class="form-control" id="modal_input_kuota" required autofocus>
              </div>
            
              <!-- /name -->
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
        </form>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /Attachment Modal -->

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