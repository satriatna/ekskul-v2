@extends('layouts.layout')
@section('content')
<title>
    Kehadiran Instruktur {{$nama_instruktur->nama}} - Aplikasi Pemilihan Senbud UPD
</title>
<style>
#myDIV {
  width: 100%;
  background-color: none;
  margin-top: 20px;
  display: none;
}

#myDIV2 {
  width: 100%;
  background-color: none;
  margin-top: 20px;
  display: none;
}

#myDIV3 {
  width: 100%;
  background-color: none;
  margin-top: 20px;
  display: none;
}

#myDIV4 {
  width: 100%;
  background-color: none;
  margin-top: 20px;
  display: none;
}
</style>

<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid mt-5">
        <div class="header-body mt-5">
          <!-- Card stats -->
          <div class="row">
          <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Kehadiran Instruktur : {{$nama_instruktur->nama}} </h5>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          <div class="row w3-animate-right mt-4">
          
            @if($senbud->count() !=0)
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Nama Senbud </h5>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <button onclick="myFunction2()" id="pencet2" class="btn btn-primary btn-block">Lihat Detail</button>
                  </p>
                </div>
              </div>
            </div>
            @else
            @endif
            
            @if($ekskul_biasa->count() !=0)
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Nama Ekskul Biasa </h5>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <button onclick="myFunction()" id="pencet" class="btn btn-primary btn-block">Lihat Detail</button>
                  </p>
                </div>
              </div>
            </div>
            @else
            @endif

            @if($ekskul_produktif->count() !=0)
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Nama Ekskul Produktif </h5>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <button onclick="myFunction3()" id="pencet3" class="btn btn-primary btn-block">Lihat Detail</button>
                  </p>
                </div>
              </div>
            </div>
            @else
            @endif
            
            @if($keputrian->count() !=0)
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Nama Keputrian </h5>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <button onclick="myFunction4()" id="pencet4" class="btn btn-primary btn-block">Lihat Detail</button>
                  </p>
                </div>
              </div>
            </div>
            @else
            @endif

          </div>

        <div id="myDIV">
            <div class="row">
              
            @foreach($ekskul_biasa as $s)   
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0"> {{$s->nama_ekskul_biasa}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="ni ni-bullet-list-67"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <a href="/instruktur_kehadiran_ekskul_biasa/{{$s->id_ekskul_biasa}}/{{$s->instruktur_ekskul_biasa_id}}" class="btn btn-primary btn-block">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div id="myDIV2">
            <div class="row">
              
            @foreach($senbud as $s)   
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0"> {{$s->nama_senbud}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="ni ni-bullet-list-67"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <a href="/instruktur_kehadiran_senbud/{{$s->id_senbud}}/{{$s->instruktur_senbud_id}}" class="btn btn-primary btn-block">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div id="myDIV3">
            <div class="row">
              
            @foreach($ekskul_produktif as $s)   
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0"> {{$s->nama_ekskul_produktif}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="ni ni-bullet-list-67"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <a href="/instruktur_kehadiran_ekskul_produktif/{{$s->id_ekskul_produktif}}/{{$s->instruktur_ekskul_produktif_id}}" class="btn btn-primary btn-block">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div id="myDIV4">
            <div class="row">
              
            @foreach($keputrian as $s)   
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0"> {{$s->nama_keputrian}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="ni ni-bullet-list-67"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <a href="/instruktur_kehadiran_keputrian/{{$s->id_keputrian}}/{{$s->instruktur_keputrian_id}}" class="btn btn-primary btn-block">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    </div>
  </div>
  <script>
function myFunction() {
  var x = document.getElementById("myDIV");
  var y = document.getElementById("pencet");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function myFunction2() {
  var x = document.getElementById("myDIV2");
  var y = document.getElementById("pencet2");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function myFunction3() {
  var x = document.getElementById("myDIV3");
  var y = document.getElementById("pencet3");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function myFunction4() {
  var x = document.getElementById("myDIV4");
  var y = document.getElementById("pencet4");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>

  @endsection