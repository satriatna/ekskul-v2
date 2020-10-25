@extends('layouts.perkenalan')
@section('content')
<title>
    Kegiatan Ekskul Produktif {{$nama_ekskul_produktif->nama_ekskul_produktif}} - Aplikasi Pemilihan Senbud UPD
</title>
 <!-- Page content -->
 <div class="container mt--8 geser">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="portfolio-wrap">
                                    <div id="carouselExampleControlssenbud" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                        @foreach( $ekskul_produktif as $prod )
                                            <li data-target="#carouselExampleControlssenbud" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                        @endforeach
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            @foreach( $ekskul_produktif as $prod )
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                                            <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$prod->gambar_nama_ekskul_produktif)}}" alt="{{ $prod->nama_ekskul_produktif }}">
                                                <div class="carousel-caption">
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
                    </div>
                    </div>
                    <div class="col-lg-6 geser_atas">
                        <div class="card">
                            <div class="card-body">
                                <p>Nama Ekskul Produktif : {{$nama_ekskul_produktif->nama_ekskul_produktif}} </p>
                                <p>Hari : {{$nama_ekskul_produktif->hari_ekskul_produktif}} </p>
                                <p>Kuota Ekskul Produktif : {{$nama_ekskul_produktif->kuota_ekskul_produktif}} Orang</p>
                                <p>Sisa Kuota : {{$nama_ekskul_produktif->kuota_ekskul_produktif}} Orang</p>
                                <p>Nama Instruktur : {{$nama_ekskul_produktif->nama}}</p>
                                <p>Deskripsi Kegiatan : {{$nama_ekskul_produktif->deskripsi_kegiatan_ekskul_produktif}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <br>
@endsection