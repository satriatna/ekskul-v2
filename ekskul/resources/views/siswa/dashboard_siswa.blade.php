@extends('layouts.layout')
@section('content')
<title>
    Dashboard Siswa - Aplikasi Pemilihan Senbud UPD
 </title>
<style>
@media screen and (min-width: 992px) {
  .heading {
    margin-top: 80px !important;
  }
  }
  @media screen and (min-width: 992px) {
  .geser2 {
    margin-top: 105px !important
  }
  }
  @media screen and (max-width: 600px) {
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
<!-- Header -->
<div class="header pb-6 d-flex align-items-center" style="min-height: 300px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <!-- Header container -->
    <div class="container-fluid d-flex align-items-center mt-6">
        <div class="row">
            <div class="card bg-default border-0 ml-3 mr-3">
                    <!-- Card body -->
                <div class="card-body">
                    @foreach($siswa as $s)
                        <div class="row">
                            <div class="col">
                            @if(Auth::user()->cek_pilihan == "belum")
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Ayo ! Segera pilih ekskul dan senbud mu ! <br> Kuota kelasnya terbatas !
                            <span class="text-white" style="font-weight: bold"></span></h5>
                            @elseif(Auth::user()->cek_pilihan == "sudah")
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white text-center">Biodata Mu</h5>
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
    <div class="container-fluid mt--6 pt-0">
      <div class="row">
        <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="{{url('/assets/img/brand/latar_foto.jpg')}}" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2 mt--5">
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
                  <div class="card-profile-stats justify-content-center mt--5">
                    <ul class="list-group list-group-unbordered heading text-center geser2">
                        <li class="list-group-item">
                             <a class="text-center"> {{$s->nis}}</a>
                        </li>
                        <li class="list-group-item">
                         <a class="text-center"> {{$s->nama}}</a>
                        </li>
                        <li class="list-group-item">
                            <a class="text-center"> {{$s->nama_rombel}}</a>
                        </li>
                        <!-- <li class="list-group-item">
                       <a class="text-center"> {{$s->nama_rayon}}</a>
                        </li>
                        <li class="list-group-item">
                        @if($s->jk == "P")
                          <a class="text-center"> Perempuan</a>
                        @else
                        <a class="text-center"> Laki - Laki</a>
                        @endif
                        </li>
                        <li class="list-group-item">
                          <a class="text-center"> {{$s->nama_jurusan}}</a>
                        </li> -->
                       
                    </ul>
                   
                  </div>
                </div>
              </div>
            @endforeach
            </div>
          </div>
          
        </div>
       
        
        <div class="col-xl-8 order-xl-1 geser">
          <div class="row">
            
          </div>
        @if(Auth::user()->cek_pilihan == 'sudah')

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                      Senbud <span style="font-weight: bold">( {{$s->nama_senbud}} )</span> <a class="btn btn-primary btn-sm float-right" href="/kehadiran_senbud_per_siswa/{{$s->senbud_id}}">Lihat</a>
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
                <div class="card geser">
                    <div class="card-header">
                     Ekskul Biasa <span style="font-weight: bold">( {{$s->nama_ekskul_biasa}} )</span> <a class="btn btn-primary btn-sm float-right" href="/kehadiran_ekskul_biasa_per_siswa/{{$s->ekskul_biasa_id}}">Lihat</a>
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
            @if(Auth::user()->kelas == 11)
            <div class="col-lg-6 mt-4">
                <div class="card">
                    <div class="card-header">
                     Ekskul Produktif <span style="font-weight: bold"> ( {{$s->nama_ekskul_produktif}} ) </span> <a class="btn btn-primary btn-sm float-right" href="/kehadiran_ekskul_produktif_per_siswa/{{$s->ekskul_produktif_id}}">Lihat</a>
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
            @if(Auth::user()->jk == "P")
            <div class="col-lg-6 mt-4">
                <div class="card">
                    <div class="card-header">
                     Keputrian <span style="font-weight: bold">( {{$s->nama_keputrian}} )</span> <a class="btn btn-primary btn-sm float-right" href="/kehadiran_keputrian_per_siswa/{{$s->keputrian_id}}">Lihat</a>
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
        @else
        <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0 pl-lg-4">Silahkan Pilih <br><small>hari tidak boleh bentrok</small> </h3>
                </div>
               
              </div>
            </div>
            @if(Auth::user()->kelas == 10 && Auth::user()->jk =='L')
            <div class="card-body">
              <form action="siswa/memilih" method="POST">
              {{csrf_field()}}
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Senbud</label>
                        <select class="form-control" name="senbud_id" id="senbud_id" required>
                        <option value=""> ~ Pilih Senbud ~ </option>
                            @foreach($senbud as $s)
                            <option value="{{$s->id_senbud}}">{{$s->nama_senbud}} &nbsp; - {{$s->hari_senbud}} </option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Ekskul Biasa</label>
                        <select class="form-control" name="ekskul_biasa_id" id="ekskul_biasa_id" required>
                          <option value="">~ Pilih Eskskul Biasa ~</option>
                            @foreach($ekskul_biasa as $s)
                            <option value="{{$s->id_ekskul_biasa}}">{{$s->nama_ekskul_biasa}} {{$s->hari_ekskul_biasa}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                       <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin dengan pilihan Anda ?');">Selesai</button>
                       </form>
                      </div>
                    </div>
                  </div>
            @elseif(Auth::user()->kelas == 11 && Auth::user()->jk =='L')
            <div class="card-body">
              <form action="/siswa/memilih" method="POST">
              {{csrf_field()}}
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Senbud</label>
                        <select class="form-control" name="senbud_id" id="senbud_id" required>
                            <option value="">~ Pilih Senbud ~</option>
                            @foreach($senbud as $s)
                            <option value="{{$s->id_senbud}}">{{$s->nama_senbud}} &nbsp; - {{$s->hari_senbud}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Ekskul Biasa</label>
                        <select class="form-control" name="ekskul_biasa_id" id="ekskul_biasa_id">
                            <option value="">~ Pilih Ekskul Biasa ~</option>
                            @foreach($ekskul_biasa as $s)
                            <option value="{{$s->id_ekskul_biasa}}">{{$s->nama_ekskul_biasa}} {{$s->hari_ekskul_biasa}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Ekskul Produktif</label>
                        <select class="form-control" name="ekskul_produktif_id" id="ekskul_produktif_id" required>
                            <option value="">~ Pilih Ekskul Produktif ~</option>
                            @foreach($ekskul_produktif as $s)
                            <option value="{{$s->id_ekskul_produktif}}">{{$s->nama_ekskul_produktif}} {{$s->hari_ekskul_produktif}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                       <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin dengan pilihan Anda ?');">Selesai</button>
                       </form>
                      </div>
                    </div>
                  </div>
            @elseif(Auth::user()->kelas == 10 && Auth::user()->jk =='P')
            <div class="card-body">
              <form action="siswa/memilih" method="POST">
              {{csrf_field()}}
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Senbud</label>
                        <select class="form-control" name="senbud_id" id="senbud_id" required>
                            <option value="">~ Pilih Senbud ~</option>
                            @foreach($senbud as $s)
                            <option value="{{$s->id_senbud}}">{{$s->nama_senbud}} &nbsp; - {{$s->hari_senbud}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Ekskul Biasa</label>
                        <select class="form-control" name="ekskul_biasa_id" id="ekskul_biasa_id" required>
                            <option value="">~ Pilih Ekskul Biasa</option>
                            @foreach($ekskul_biasa as $s)
                            <option value="{{$s->id_ekskul_biasa}}">{{$s->nama_ekskul_biasa}} {{$s->hari_ekskul_biasa}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Keputrian</label>
                        <select class="form-control" name="keputrian_id" id="keputrian_id" required>
                            <option value="">~ Pilih Keputrian ~</option>
                            @foreach($keputrian as $s)
                            <option value="{{$s->id_keputrian}}">{{$s->nama_keputrian}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                       <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin dengan pilihan Anda ?');">Selesai</button>
                       </form>
                      </div>
                    </div>
                  </div>
            @elseif(Auth::user()->kelas == 11 && Auth::user()->jk =='P') <div class="card-body">
              <form action="siswa/memilih" method="POST">
              {{csrf_field()}}
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Senbud</label>
                        <select class="form-control" name="senbud_id" id="senbud_id" required>
                            <option value="">~ Pilih Senbud ~</option>
                            @foreach($senbud as $s)
                            <option value="{{$s->id_senbud}}">{{$s->nama_senbud}} &nbsp; - &nbsp; {{$s->hari_senbud}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Ekskul Biasa</label>
                        <select class="form-control" name="ekskul_biasa_id" id="ekskul_biasa_id" required>
                            <option value="">~ Pilih Ekskul Biasa ~</option>
                            @foreach($ekskul_biasa as $s)
                            <option value="{{$s->id_ekskul_biasa}}">{{$s->nama_ekskul_biasa}} &nbsp; - &nbsp; {{$s->hari_ekskul_biasa}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Ekskul Produktif</label>
                        <select class="form-control" name="ekskul_produktif_id" id="ekskul_produktif_id" required>
                            <option value="">~ Pilih Ekskul Produktif ~</option>
                            @foreach($ekskul_produktif as $s)
                            <option value="{{$s->id_ekskul_produktif}}">{{$s->nama_ekskul_produktif}} &nbsp; - &nbsp; {{$s->hari_ekskul_produktif}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Keputrian</label>
                        <select class="form-control" name="keputrian_id" id="keputrian_id" required>
                            <option value="">~ Pilih Keputrian ~</option>
                            @foreach($keputrian as $s)
                            <option value="{{$s->id_keputrian}}">{{$s->nama_keputrian}} &nbsp; - &nbsp; {{$s->hari_keputrian}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                       <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin dengan pilihan Anda ?');">Selesai</button>
                       </form>
                      </div>
                    </div>
                  </div>
                 @endif
                 
                <hr class="my-4" style="padding-bottom : 9px !important;" />
          </div>
        </div>
      </div>
      </div>
      </div>


      
    <!--========================== Kegiatan Section ============================-->
    <br>
    <div class="col-lg-12">
        <div class="row">
        <div class="card col-12">
        <div class="card-body">
        <span id="portfolio" class="clearfix">
            <div class="container">
            <header class="section-header">
            <h2 class="section-title">Macam - Macam Kegiatan</h2>
            </header>
                <div class="row">
                    <div class="col-lg-12">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-senbud">Senbud</li>
                            <li data-filter=".filter-eksprod">Ekskul Produktif</li>
                            <li data-filter=".filter-eksnon">Ekskul Biasa</li>
                            <li data-filter=".filter-keputrian">Keputrian</li>
                        </ul>
                    </div>
                </div>
        <div class="row portfolio-container">
            <div class="col-lg-6 col-md-6 portfolio-item filter-senbud">
                <div class="portfolio-wrap">
                    <div id="carouselExampleControlssenbud" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                    @foreach( $senbud as $prod )
                        <li data-target="#carouselExampleControlssenbud" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach( $senbud as $prod )
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                        <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$prod->foto_senbud)}}" alt="{{ $prod->nama_senbud }}">
                            <div class="carousel-caption">
                            <h1>{{$prod->nama_senbud}}</h1>
                            <a class="btn btn-primary" href="#">Lihat</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControlssenbud" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControlssenbud" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 portfolio-item filter-eksprod">
            <div class="portfolio-wrap">
                <div id="carouselExampleControlsEksprod" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                    @foreach( $ekskul_produktif as $prod )
                        <li data-target="#carouselExampleControlsEksprod" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                    </ol>
                        <div class="carousel-inner" role="listbox">
                        @foreach( $ekskul_produktif as $prod )
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                        <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$prod->foto_ekskul_produktif)}}" alt="{{ $prod->nama_ekskul_produktif }}">
                            <div class="carousel-caption">
                                <h1>{{$prod->nama_ekskul_produktif}}</h1>
                                <a class="btn btn-primary" href="#">Lihat</a>
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControlsEksprod" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControlsEksprod" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 portfolio-item filter-eksnon">
            <div class="portfolio-wrap">
                <div id="carouselExampleControlseksnon" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                    @foreach( $ekskul_biasa as $eks )
                        <li data-target="#carouselExampleControlseksnon" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                    </ol>
                        <div class="carousel-inner" role="listbox">
                        @foreach( $ekskul_biasa as $eks )
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                        <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$eks->foto_ekskul_biasa)}}" alt="{{ $eks->nama_ekskul_biasa }}">
                            <div class="carousel-caption">
                                <h1>{{$eks->nama_ekskul_biasa}}</h1>
                                <a class="btn btn-primary" href="#">Lihat</a>
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControlseksnon" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControlseksnon" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 portfolio-item filter-keputrian">
            <div class="portfolio-wrap">
                <div id="carouselExampleControlskeputrian" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                    @foreach( $keputrian as $kep )
                        <li data-target="#carouselExampleControlskeputrian" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                    </ol>
                        <div class="carousel-inner" role="listbox">
                        @foreach( $keputrian as $kep )
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                        <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$kep->foto_keputrian)}}" alt="{{ $kep->nama_keputrian }}">
                            <div class="carousel-caption">
                                <h1>{{$kep->nama_keputrian}}</h1>
                                <a class="btn btn-primary" href="#">Lihat</a>
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControlskeputrian" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControlskeputrian" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>
                </div>
            </div>
        </div>

        @endif


        </div>
    </span>
        </div>
    </div>
       
            </div>
            @endforeach 
      
        </div>
    </div>      
    
@endsection