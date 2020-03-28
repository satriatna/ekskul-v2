@extends('layouts.layout')
@section('content')
<title>
    Dashboard Piket - Aplikasi Pemilihan Senbud UPD
</title>
<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid" style="margin-top:-100px !important;">

    <div class="row w3-animate-right mt-7">

          <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Selamat Datang</h5>
                      <span class="h2 font-weight-bold mb-0"></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <a href="/banyak/siswa" class="btn btn-primary btn-block">{{Auth::user()->nama}}</a>
                  </p>
                </div>
              </div>
            </div>
        </div>
      </div>

    </div>
        <div class="container-fluid mt--7" style="margin-top:-210px !important;">
<!-- 
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent">
            </div>
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered" id="example"  cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Nama Instruktur</th>
                    <th> Jenis Kelamin</th>
                    <th> Aksi</th>
                </tr>
                </thead>
                <tbody>
                    
                @foreach($instruktur as $i)
                <tr class="data-row">
                    <td class="align-middle iteration">1</td>
                    <td class="align-middle name">{{$i->nama}}</td>
                    <td class="align-middle hari">{{$i->jk}}</td>
                    <td class="align-middle">
                    <a href="/input_absen_instruktur/{{$i->id}}" class="btn btn-info btn-sm">Input Absen</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div> -->
        
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