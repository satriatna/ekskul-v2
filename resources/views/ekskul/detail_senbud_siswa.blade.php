@extends('layouts.layout')
@section('content')
<title>
    Data Siswa Seni Budaya - Aplikasi Pemilihan Senbud UPD
</title>
<div class="header pb-6 d-flex align-items-center" style="min-height: 300px; background-image: url(../../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid">

                <div class="row">
                    <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Senbud : <span class="text-white" style="font-weight: bold">@foreach($siswa as $s) {{$s->nama_senbud}} @endforeach </span></h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
         
        </div>
      </div>
    </div>
    
    @foreach($siswa as $s)
    <!-- Page content -->
    <div class="container-fluid mt--7">

      <div class="row">
        <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="{{url('/assets/img/brand/latar_foto.jpg')}}" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="{{url('/assets/img/database/'.$s->foto)}}" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
             
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-5">
                    <div>
                      <span class="heading">{{$hadir->count()}}</span>
                      <span class="description">Hadir</span>
                    </div>
                    <div>
                      <span class="heading">{{$ijin->count()}}</span>
                      <span class="description">Ijin</span>
                    </div>
                    <div>
                      <span class="heading">{{$sakit->count()}}</span>
                      <span class="description">Sakit</span>
                    </div>
                    <div>
                      <span class="heading">{{$alpa->count()}}</span>
                      <span class="description">Alpa</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="row">
            <div class="col-lg-6">
              <div class="card bg-gradient-info border-0">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Kehadiran</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">{{$absen_senbud_hadir->count()}} </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                        <i class="fa fa-check"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card bg-gradient-danger border-0">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Ketidakhadiran</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">{{$absen_senbud_tak_hadir->count()}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                        <i class="fa fa-times-circle"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Biodata Siswa </h3>
                </div>
               
              </div>
            </div>
            
            <div class="card-body">
              <form>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">NIS</label>
                        <input type="text" id="input-username" class="form-control readonly" placeholder="Username" value="{{$s->nis}}" readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Nama</label>
                        <input type="email" id="input-email" class="form-control readonly" placeholder="jesse@example.com" value="{{$s->nama}}" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Rombel</label>
                        <input type="text" id="input-first-name" class="form-control readonly" placeholder="First name"value="{{$s->nama_rombel}}" readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">Rayon</label>
                        <input type="text" id="input-last-name" class="form-control readonly" placeholder="Last name" value="{{$s->nama_rayon}}" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Jurusan</label>
                        <input type="text" id="input-first-name" class="form-control readonly" placeholder="First name" value="{{$s->nama_jurusan}}" readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">Kelas</label>
                        <input type="text" id="input-last-name" class="form-control readonly" placeholder="Last name" value="{{$s->kelas}}" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Jenis Kelamin</label>
                        @if($s->jk =='L')
                        <input type="text" id="input-first-name" class="form-control readonly" placeholder="First name" value="Laki - Laki" readonly>
                        @else
                        <input type="text" id="input-first-name" class="form-control readonly" placeholder="First name" value="Perempuan" readonly>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <!-- <h6 class="heading-small text-muted mb-4">Contact information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Address</label>
                        <input id="input-address" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">City</label>
                        <input type="text" id="input-city" class="form-control" placeholder="City" value="New York">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Country</label>
                        <input type="text" id="input-country" class="form-control" placeholder="Country" value="United States">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Postal code</label>
                        <input type="number" id="input-postal-code" class="form-control" placeholder="Postal code">
                      </div>
                    </div>
                  </div>
                </div>
                 -->
              </form>
            </div>
            @endforeach 
          </div>
        </div>
      </div>
      
@endsection