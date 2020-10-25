@extends('layouts.layout')
@section('content')
<title>
    Data User Instuktur- Aplikasi Pemilihan Senbud UPD
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
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Instruktur </span></h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
         
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7" style="margin-top:-210px !important;">>
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent">
            <button type="button" class="btn-sm btn btn-primary flats" data-toggle="modal" data-target="#exampleModal">
                Tambah Instruktur
                </button>
            </div>
            <div class="card"><!-- Button trigger modal -->
                <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama Instruktur</th>
                                <th>Status </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($instruktur as $i)
                            <tr class="data-row">
                                <td></td>
                                <td class="align-middle intruktur">{{$i->nama}} </td>
                                <td class="align-middle intruktur">{{$i->status}} </td>
                                <td>
                                <a href="/instruktur_kehadiran/{{$i->id}}" class="btn btn-sm btn-info">Kehadiran</a> 
                                <a href="/pengguna/detail/{{$i->id}}" class="btn btn-sm btn-primary" >Detail</a> 
                                @if($i->status == 'aktif')
                                <a href="/pengguna/hapus/{{$i->id}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-sm btn-danger">Non - Aktifkan</a></td>
                                @else
                                <a href="/pengguna/hapus/{{$i->id}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-sm btn-danger">Aktifkan</a></td>
                                @endif
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
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="exampleModalLabel">Tambah Instruktur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" role="form" method="POST" action="/tambah/siswa">
                    {{ csrf_field() }}
                    {{ method_field('post') }}

                <div class="form-group">
                    <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Nama Siswa" required autofocus>
                    @if ($errors->has('nama'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama') }}</strong>
                    </span>
                    @endif
                </div>
                      
                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                </div>

                <div class="form-group">
                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                    @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
              

                <div class="form-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                     </span>
                    @endif
                </div>
                        
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                </div>
                
                <div class="form-group">
                <select name="jk" id="jk" class="form-control{{ $errors->has('jk') ? ' is-invalid' : '' }}" required>
                    <option value="">Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @if ($errors->has('jk'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jk') }}</strong>
                    </span>
                @endif
                </div>
                
               <div class="row">
                    <button type="submit" class="btn btn-md btn-primary ml-3">
                        Tambah
                    </button>
                    <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                
                </form>
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