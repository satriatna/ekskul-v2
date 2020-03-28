@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<style>
      
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body window.location = window.location>
  <div class="content-wrapper">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-5 pb-5">
            <div class="col-sm-12">
            <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#exampleModal">
                Tambah Rombel
                </button>
            <div class="card"><!-- Button trigger modal -->
                <div class="card-body">
              
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Rombel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($rombel as $r)
                            <tr class="data-row">
                                <td></td>
                                <td class="align-middle rombel">{{$r->nama_rombel}} </td>
                                <td><a href="/rombel/edit/{{$r->id_rombel}}" class="btn btn-sm btn-primary" id="edit-item" data-item-id="">Edit</a> <a href="/rombel/hapus/{{$r->id_rombel}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-sm btn-danger">Hapus</a></td>
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>



<div class="main-container container-fluid">
<!-- Attachment Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
        <form id="edit-form" class="form-horizontal" method="POST" action="/rombel/update">
        {{csrf_field()}}
          <div class="card text-white bg-dark mb-0">
            <div class="card-header">
              <h2 class="m-0">Edit</h2>
            </div>
            <div class="card-body">
              <!-- id -->
              <div class="form-group">
                <label class="col-form-label" for="modal_input_id">Id (just for reference not meant to be shown to the general public) </label>
                <input type="text" name="modal_input_id" class="form-control" id="modal_input_id" required>
              </div>
              <!-- /id -->
              <!-- name -->
              <div class="form-group">
                <label class="col-form-label" for="modal_input_rombel">Name</label>
                <input type="text" name="modal_input_rombel" class="form-control" id="modal_input_rombel" required autofocus>
              </div>
              <!-- /name -->
              <!-- description -->
             <button class="btn btn-sm btn-primary">Ubah</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Done</button>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /Attachment Modal -->




</div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Rombel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/rombel/store" method="POST">
        {{csrf_field()}}
            <div class="form-group">
                <label for="Nama">Rombel</label>
                <input type="text" class="form-control" name="nama_rombel">
            </div>
            <button class="btn btn-sm btn-primary">Tambah</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>

    @push('scripts')
    <script>
    $(document).ready(function() {
    var t = $('#example').DataTable( {
        responsive: true,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]]
    } );
    new $.fn.dataTable.FixedHeader( t );
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
    </script>
    @endpush
    <script>
    
    </script>
<!--     
    <script>
    var f=jQuery.noConflict();
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
    var rombel = row.children(".rombel").text();
    var description = row.children(".description").text();

    // fill the data in the input fields
    $("#modal_input_id").val(id);
    $("#modal_input_rombel").val(rombel);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})
    </script>
     -->

</body>
</html>
@endsection

