@extends('layouts.perkenalan')
@section('content')
<title>
    Kegiatan ekskul_biasa {{$nama_ekskul_biasa->nama_ekskul_biasa}} - Aplikasi Pemilihan ekskul_biasa UPD
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
                                    <div id="carouselExampleControlsekskul_biasa" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                        @foreach( $ekskul_biasa as $prod )
                                            <li data-target="#carouselExampleControlsekskul_biasa" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                        @endforeach
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            @foreach( $ekskul_biasa as $prod )
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                                            <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$prod->gambar_nama_ekskul_biasa)}}" alt="{{ $prod->nama_ekskul_biasa }}">
                                                <div class="carousel-caption">
                                                </div>
                                            </div>
                                            @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControlsekskul_biasa" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControlsekskul_biasa" role="button" data-slide="next">
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
                                <p>Nama Ekskul Biasa : {{$nama_ekskul_biasa->nama_ekskul_biasa}} </p>
                                <p>Hari : {{$nama_ekskul_biasa->hari_ekskul_biasa}} </p>
                                <p>Kuota Ekskul Biasa : {{$nama_ekskul_biasa->kuota_ekskul_biasa}} Orang</p>
                                <p>Sisa Kuota : {{$nama_ekskul_biasa->kuota_ekskul_biasa}} Orang</p>
                                <p>Nama Instruktur : {{$nama_ekskul_biasa->nama}}</p>
                                <p>Deskripsi Kegiatan : {{$nama_ekskul_biasa->deskripsi_kegiatan_ekskul_biasa}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <br>
@endsection