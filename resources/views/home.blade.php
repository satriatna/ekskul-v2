@extends('layouts/layout_awal')
@section('content')

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro" class="clearfix">
    <div class="container">

      <div class="intro-img">
        <img src="img/intro-img.svg" alt="" class="img-fluid">
      </div>

      <div class="intro-info">
        <h2>Tingkatkan Bakat Mu <br>bersama<br>Ekskul Kami</h2>
        <div>
          <a href="/login" class="btn-get-started scrollto">Masuk</a>
        </div>
      </div>

    </div>
  </section><!-- #intro -->

  <main id="main">

    <!--==========================
      Services Section
    ============================-->
    <section id="services" class="section-bg">
      <div class="container">

        <header class="section-header">
          <h3>Kegiatan </h3>
          <p>Macam - macam kegiatan yang wajib diikuti oleh siswa sesuai kelas dan kompetensi masing - masing.</p>
        </header>

        <div class="row">

          <div class="col-md-6 col-lg-5 offset-lg-1 wow bounceInUp" data-wow-duration="1.4s">
            <div class="box p-5">
              <div class="icon ml-4"><i class="ion-ios-analytics-outline" style="color: #ff689b;"></i></div>
              <h4 class="title"><a >Seni Budaya</a></h4>
              <p class="description">Berbagai kegiatan seni, seperti seni rupa, seni teater, seni musik dan masih banyak lagi kegiatan seni lainnya.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-5 wow bounceInUp" data-wow-duration="1.4s">
            <div class="box p-5">
              <div class="icon ml-4"><i class="ion-ios-bookmarks-outline" style="color: #e9bf06;"></i></div>
              <h4 class="title"><a >Ekskul Produktif</a></h4>
              <p class="description">Berbagan kegiatan yang wajib diikuti siswa sesuai kompetensi keahlian masing - masing.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-5 offset-lg-1 wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="box p-5">
              <div class="icon ml-4"><i class="ion-ios-paper-outline" style="color: #3fcdc7;"></i></div>
              <h4 class="title"><a >Ekskul Non - Produktif</a></h4>
              <p class="description">Berbagai kegiatan ekskul, seperti dibidang olahraga : Futsal, Sepak Bola, Bola Basket dan lainnya.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-5 wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="box p-5">
              <div class="icon ml-4"><i class="ion-ios-speedometer-outline" style="color:#41cf2e;"></i></div>
              <h4 class="title"><a >Keputrian</a></h4>
              <p class="description">Kegiatan yang wajib diikuti khusus siswi yang dilakukan setiap hari jumat pada saat siswa melaksanakan sholat jumat.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #services -->

    <!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio" class="clearfix">
      <div class="container">

        <header class="section-header">
          <h3 class="section-title">Portofolio</h3>
        </header>

        <div class="row">
          <div class="col-lg-12">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-eksprod">Ekskul Produktif</li>
              <li data-filter=".filter-eksnon">Ekskul Biasa</li>
              <li data-filter=".filter-senbud">Senbud</li>
              <li data-filter=".filter-keputrian">Keputrian</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">
          @foreach($senbud as $sen)
          <div class="col-lg-4 col-md-6 portfolio-item filter-senbud">
            <div class="portfolio-wrap">
              <img src="{{url('/assets/img/database/'.$sen->foto_senbud)}}" class="img-fluid" alt="" style="height: 300px; width:350px">
              <div class="portfolio-info">
                <h4><a href="#">{{$sen->nama_senbud}}</a></h4>
                <div>
                  <a href="{{url('/assets/img/database/'.$sen->foto_senbud)}}" data-lightbox="portfolio" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="perkenalan_senbud/{{$sen->id_senbud}}" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @foreach($ekskul_biasa as $eks_biasa)
          <div class="col-lg-4 col-md-6 portfolio-item filter-eksnon">
            <div class="portfolio-wrap">
              <img src="{{url('/assets/img/database/'.$eks_biasa->foto_ekskul_biasa)}}" class="img-fluid" alt="" style="height: 300px; width:350px">
              <div class="portfolio-info">
                <h4><a href="#">{{$eks_biasa->nama_ekskul_biasa}}</a></h4>
                <div>
                  <a href="{{url('/assets/img/database/'.$eks_biasa->foto_ekskul_biasa)}}" data-lightbox="portfolio" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="perkenalan_ekskul_biasa/{{$eks_biasa->id_ekskul_biasa}}" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @foreach($ekskul_produktif as $eks_prod)
          <div class="col-lg-4 col-md-6 portfolio-item filter-eksprod">
            <div class="portfolio-wrap">
              <img src="{{url('/assets/img/database/'.$eks_prod->foto_ekskul_produktif)}}" class="img-fluid" alt="" style="height: 300px; width:350px">
              <div class="portfolio-info">
                <h4><a href="#">{{$eks_prod->nama_ekskul_produktif}}</a></h4>
                <div>
                  <a href="{{url('/assets/img/database/'.$eks_prod->foto_ekskul_produktif)}}" data-lightbox="portfolio" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="perkenalan_ekskul_produktif/{{$eks_prod->id_ekskul_produktif}}" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @foreach($keputrian as $kep)
          <div class="col-lg-4 col-md-6 portfolio-item filter-keputrian">
            <div class="portfolio-wrap">
              <img src="{{url('/assets/img/database/'.$kep->foto_keputrian)}}" class="img-fluid" alt="" style="height: 300px; width:350px">
              <div class="portfolio-info">
                <h4><a href="#">{{$kep->nama_keputrian}}</a></h4>
                <div>
                  <a href="{{url('/assets/img/database/'.$kep->foto_keputrian)}}" data-lightbox="portfolio" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="/perkenalan_keputrian/{{$kep->id_keputrian}}" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
      
      </div>
    </section><!-- #portfolio -->

  </main>

  @endsection