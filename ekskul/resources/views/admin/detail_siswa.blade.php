@extends('layouts.layout')
@section('content')
<title>
    Detail Data Siswa  @foreach($siswa as $s) {{$s->nama}} @endforeach- Aplikasi Pemilihan Senbud UPD
 </title>
<style>
@media screen and (min-width: 992px) {
  .heading {
    margin-top: 80px !important;
  }
  }
  @media screen and (max-width: 992px) {
  .geser {
    margin-top: 40px !important;
  }
  }
  html, 
body, 
.carousel, 
.carousel-inner, 
.carousel-inner .item {
    height: 100%;
}

.item:nth-child(1) {
    background: #ff3322;
}

.item:nth-child(2) {
    background: #44c7f4;
}

.item:nth-child(3) {
    background: #6e2585;
}

.item:nth-child(4) {
    background: #ffcd00;
}

/* Changes position of caption */
.carousel-caption {
    top: 30%;
    bottom: auto;
}
.carousel-caption h1{
  color: white;
  font-weight: bold;
}
}
</style>
<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center mt-6" style="margin-top:-100px !important;">
        <div class="row">
            <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                <div class="card-body">
                    @foreach($siswa as $s)
                        <div class="row">
                            <div class="col">
                            @if($s->cek_pilihan == "belum")
                            <div class="card shadow-lg p-3 bg-danger text-white">
                                Siswa ini belum memilih Ekskul dan Senbud
                            </div>
                            <span class="text-white" style="font-weight: bold"></span></h5>
                            @elseif($s->cek_pilihan == "sudah")
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white text-center">Data Siswa {{$s->nama}}</h5>
                            @endif
                           
                            </div>
                            <div class="col-auto">
                        </div>
                       
                            
                    @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @foreach($siswa as $s)
    <!-- Page content -->
    <div class="container-fluid mt--7" style="margin-top:-210px !important;">

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
            @foreach($siswa as $s)
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats justify-content-center">
                    <ul class="list-group list-group-unbordered heading text-center">
                        <li class="list-group-item">
                             <a class="text-center"> {{$s->nis}}</a>
                        </li>
                        <li class="list-group-item">
                         <a class="text-center"> {{$s->nama}}</a>
                        </li>
                        <li class="list-group-item">
                            <a class="text-center"> {{$s->nama_rombel}}</a>
                        </li>
                        <li class="list-group-item">
                       <a class="text-center"> {{$s->nama_rayon}}</a>
                        </li>
                        <li class="list-group-item">
                          <a class="text-center"> {{$s->nama_jurusan}}</a>
                        </li>
                    </ul>
                   
                  </div>
                </div>
              </div>
            @endforeach
            </div>
          </div>
          
        </div>
       @if($s->cek_pilihan=='sudah')
        
        <div class="col-xl-8 order-xl-1 geser">
      
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header">
                      Senbud <span style="font-weight: bold">( {{$s->nama_senbud}} )</span><a class="btn btn-primary btn-sm float-right" href="/data/senbud/siswa/{{$s->id}}/{{$s->senbud_id}}">Lihat</a>
                    </div>
                    <div class="card-body" style="font-weight: bold">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Hadir</b> <a class="float-right"> {{$hadir_senbud->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Sakit</b> <a class="float-right"> {{$sakit_senbud->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Izin</b> <a class="float-right"> {{$ijin_senbud->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Alpa</b> <a class="float-right"> {{$alpa_senbud->count()}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-lg geser">
                    <div class="card-header">
                     Ekskul Biasa <span style="font-weight: bold">( {{$s->nama_ekskul_biasa}} )</span><a class="btn btn-primary btn-sm float-right" href="/data/ekskul_biasa/siswa/{{$s->id}}/{{$s->ekskul_biasa_id}}">Lihat</a>
                    </div>
                    <div class="card-body" style="font-weight: bold">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Hadir</b> <a class="float-right">  {{$hadir_ekskul_biasa->count()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Sakit</b> <a class="float-right"> {{$sakit_ekskul_biasa->count()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Izin</b> <a class="float-right"> {{$ijin_ekskul_biasa->count()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Alpa</b> <a class="float-right"> {{$alpa_ekskul_biasa->count()}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($s->kelas == 11)
            <div class="col-lg-6 mt-4">
                <div class="card shadow-lg">
                    <div class="card-header">
                     Ekskul Produktif <span style="font-weight: bold"> ( {{$s->nama_ekskul_produktif}} ) </span><a class="btn btn-primary btn-sm float-right" href="/data/ekskul_produktif/siswa/{{$s->id}}/{{$s->ekskul_produktif_id}}">Lihat</a>
                    </div>
                    <div class="card-body" style="font-weight: bold">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Hadir</b> <a class="float-right">  {{$hadir_ekskul_produktif->count()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Sakit</b> <a class="float-right"> {{$ijin_ekskul_produktif->count()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Izin</b> <a class="float-right"> {{$sakit_ekskul_produktif->count()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Alpa</b> <a class="float-right"> {{$alpa_ekskul_produktif->count()}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @else
            @endif
            @if($s->jk == "P")
            <div class="col-lg-6 mt-4">
                <div class="card shadow-lg">
                    <div class="card-header">
                     Keputrian <span style="font-weight: bold">( {{$s->nama_keputrian}} )</span> <a class="btn btn-primary btn-sm float-right" href="/data/keputrian/siswa/{{$s->id}}/{{$s->keputrian_id}}">Lihat</a>
                    </div>
                    <div class="card-body" style="font-weight: bold">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Hadir</b> <a class="float-right">  {{$hadir_keputrian->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Sakit</b> <a class="float-right"> {{$ijin_keputrian->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Izin</b> <a class="float-right"> {{$sakit_keputrian->count()}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Alpa</b> <a class="float-right"> {{$alpa_keputrian->count()}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @else
            @endif
        </div>
        <br>
            @endif
        @endforeach
@endsection