@extends('layouts.perkenalan')
@section('content')
<title>
    Kegiatan Keputrian {{$nama_keputrian->nama_keputrian}} - Aplikasi Pemilihan Senbud UPD
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
                                        @foreach( $keputrian as $prod )
                                            <li data-target="#carouselExampleControlssenbud" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                        @endforeach
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            @foreach( $keputrian as $prod )
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
                                            <img class="d-block img-fluid" src="{{url('/assets/img/database/'.$prod->gambar_nama_keputrian)}}" alt="{{ $prod->nama_keputrian }}">
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
                                <p>Nama Keputrian : {{$nama_keputrian->nama_keputrian}} </p>
                                <p>Hari : {{$nama_keputrian->hari_keputrian}} </p>
                                <p>Kuota Keputrian : {{$nama_keputrian->kuota_keputrian}} Orang</p>
                                <p>Sisa Kuota : {{$nama_keputrian->kuota_keputrian}} Orang</p>
                                <p>Nama Instruktur : {{$nama_keputrian->nama}}</p>
                                <p>Deskripsi Kegiatan : {{$nama_keputrian->deskripsi_kegiatan_keputrian}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <br>
@endsection