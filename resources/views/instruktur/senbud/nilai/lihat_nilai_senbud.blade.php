@extends('layouts.layout')
@section('content')
  
 <title>
    Nilai Senbud {{$nama_senbud->nama_senbud}} - Aplikasi Pemilihan Senbud UPD
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
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Nilai Siswa Senbud : {{$nama_senbud->nama_senbud}} </span></h5>
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
                <th rowspan="2">#</th>
                    <th rowspan="2">Keterangan</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Aksi</th>
  </tr>
  </thead>
  <tbody>
  @foreach($tb_keterangan_nilai_senbud as $tb)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle kuota">{{$tb->keterangan_nilai_senbud}}</td>
                    <td class="align-middle kuota">{{$tb->tgl_nilai_senbud}}</td>
                    <td class="align-middle">
                    <a href="/lihat_detail_nilai_senbud/{{$tb->keterangan_nilai_senbud}}" class="btn btn-info btn-sm">Detail</a>
                    <a href="/hapus_nilai_senbud/{{$tb->id_keterangan_nilai_senbud}}" onclick="return confirm('Anda Yakin ?')" class="btn btn-danger btn-sm">Hapus</a>
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