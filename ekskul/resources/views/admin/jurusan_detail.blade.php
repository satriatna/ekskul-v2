@extends('layouts.layout')
@section('content')
<title>
Data jurusan - Aplikasi Pemilihan Senbud UPD
</title>
<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid">

        <div class="header-body mt-5">
          <!-- Card stats -->   
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0"> Data Siswa jurusan <br> @if($nama_jurusan == '') @else {{$nama_jurusan->nama_jurusan}} @endif</h5>
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
                        <h5 class="card-title text-uppercase text-muted mb-0"> Jumlah Siswa <br> @if($siswa->count() == '') 0 @else {{$siswa->count()}} @endif </h5>
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
                        <h5 class="card-title text-uppercase text-muted mb-0"> <button class="btn btn-primary btn-block">Export Excel</button> </h5>
                      </div>
                    </div>
                  
                  </div>
                </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid mt--7">

      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table id="example" class="table table-striped table-bordered nowrap mt-3" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NIS</th>
                                <th> Nama</th>
                                <th>jurusan</th>
                                <th> Aksi </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($siswa as $s)
                            <tr class="data-row">
                                <td class="align-middle iteration"></td>
                                <td class="align-middle nis">{{$s->nis}}</td>
                                <td class="align-middle name">{{$s->nama}}</td>
                                <td class="align-middle word-break description2">{{$s->nama_jurusan}}</td>
                                <td class="align-middle">
                                <button type="button" class="btn btn-sm btn-primary" id="edit-item" data-item-id="{{$s->id}}">Pindahkan</button>
                                </td>
                            </tr>
                                @endforeach
                        </tfoot>
                        </table>
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
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">Pindah jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
       
          <div class="card">
           
            <div class="card-body">
            <form id="edit-form" class="form-horizontal" method="POST" action="/pindahkan/jurusan">
            {{csrf_field()}}
              <!-- id -->
              <div class="form-group">
                <input type="hidden" name="modal_input_id" class="form-control" id="modal_input_id" required>
              </div>
              <!-- /id -->
              <!-- name -->
              <div class="form-group">
                <label class="col-form-label" for="modal_input_name">Nama</label>
                <input type="text" name="modal_input_name" class="form-control" id="modal_input_name" required readonly>
              </div>
              <!-- /name -->
              <label for="dari">Dari</label>
                <input type="text" class="form-control" value="{{$nama_jurusan->nama_jurusan}}" readonly>
                        <br>
                        <label for="ke">Ke</label>
                             <select name="jurusanAkhir" id="jurusanAkhir" class="form-control">
                                 @foreach($jurusan as $r)
                                 <option value="{{$r->id_jurusan}}">{{$r->nama_jurusan}}</option>
                                 @endforeach
                                 <option value="0">Belum Ada jurusan</option>
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
  @endsection