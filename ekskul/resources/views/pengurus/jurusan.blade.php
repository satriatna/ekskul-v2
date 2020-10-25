@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
  <div class="content-wrapper">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Jurusan
                </button>
            <div class="card"><!-- Button trigger modal -->
                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($jurusan as $r)
                            <tr class="data-row">
                                <td></td>
                                <td class="align-middle jurusan">{{$r->nama_jurusan}} </td>
                                <td><a href="/jurusan/edit/{{$r->id_jurusan}}" class="btn btn-sm btn-success" id="edit-item" data-item-id="">Edit</a> <a href="/jurusan/hapus/{{$r->id_jurusan}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-sm btn-danger">Hapus</a></td>
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/jurusan/store" method="POST">
        {{csrf_field()}}
            <div class="form-group">
                <label for="nama_jurusan">Jurusan</label>
                <input type="text" class="form-control" name="nama_jurusan">
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
</body>
</html>
@endsection

