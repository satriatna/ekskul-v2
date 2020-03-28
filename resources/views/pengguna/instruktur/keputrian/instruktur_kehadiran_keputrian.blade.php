@extends('layouts.layout')
@section('content')
<title>
    Kehadiran Instruktur Ekskul Produktif {{$keputrian->nama_keputrian}}- Aplikasi Pemilihan Senbud UPD
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
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Kehadiran Instruktur </span></h5>
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
        <div class="col-xl-4 mb-5 mb-xl-0">
            <div class="card card-profile">
                <img src="{{url('/assets/img/brand/latar_foto.jpg')}}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{url('/assets/img/database/'.$instruktur->foto)}}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
             
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats justify-content-center">
                    <ul class="list-group list-group-unbordered heading text-center mt-6">
                        <li class="list-group-item">
                         <a class="text-center"> {{$instruktur->nama}}</a>
                        </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>

            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow-lg">
                    <div class="card-header">
                    Ekskul Produktif <span style="font-weight: bold">( {{$keputrian->nama_keputrian}} )</span><a class="btn btn-primary btn-sm float-right" href="/kehadiran_instruktur_keputrian/{{$keputrian->id_keputrian}}">Lihat</a>
                    </div>
                    <div class="card-body" style="font-weight: bold">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Hadir</b> <a class="float-right"> {{$hadir->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Sakit</b> <a class="float-right"> {{$sakit->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Izin</b> <a class="float-right"> {{$ijin->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Alpa</b> <a class="float-right"> {{$alpa->count()}} </a>
                            </li>
                        </ul>
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