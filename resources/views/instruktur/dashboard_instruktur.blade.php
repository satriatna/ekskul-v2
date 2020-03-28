@extends('layouts.layout')
@section('content')
 <title>
    Dashboard Instruktur - Aplikasi Pemilihan Senbud UPD
 </title>
<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid" style="margin-top:-50px !important;">

        <div class="header-body">
        <div class="header-body mt-5">
          <!-- Card stats -->
          <div class="row w3-animate-right">
          <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo date('m-d-Y')?> </h5>
                      <span class="h2 font-weight-bold mb-0">Selamat Datang </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                      <a datatoggle="Halo" class="btn btn-primary btn-block text-white">{{Auth::user()->nama}}</a>
                  </p>
                </div>
              </div>
            </div>
          
            </div>
    </div>
    </div>
  </div>
  </div>
  </div>
  @endsection