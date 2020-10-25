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
        <div class="col-md-12 mt-5">
               <button type="button" class="btn btn-primary flats btn-sm" data-toggle="modal" data-target="#exampleModal">
                Tambah Rayon
                </button>
            <div class="card"><!-- Button trigger modal -->
                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Rayon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($rayon as $r)
                            <tr class="data-row">
                                <td></td>
                                <td class="align-middle rayon">{{$r->nama_rayon}} </td>
                                <td><a href="/rayon/edit/{{$r->id_rayon}}" class="btn btn-success" id="edit-item" data-item-id="">Edit</a> <a href="/rayon/hapus/{{$r->id_rayon}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-danger">Hapus</a></td>
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
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

