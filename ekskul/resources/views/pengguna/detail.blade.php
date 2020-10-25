@extends('layouts.layout')
@section('content')
<title>
    Detail Data User @foreach($pengguna as $p) {{$p->level}} {{$p->nama}} @endforeach - Aplikasi Pemilihan Senbud UPD
 </title>
 <style>
 #upload{
    display:none
}
 </style>{{ (request()->is('senbud/detail/Auth::user()->id*')) ? 'active' : '' }}
<!-- Header -->
<div class="header pb-6 d-flex align-items-center" style="min-height: 300px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
  <span class="mask bg-gradient-primary opacity-8"></span>
  <!-- Header container -->
  <div class="container-fluid"><div class="row">
    <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data @foreach($pengguna as $p) {{$p->level}} :  {{$p->nama}} @endforeach </span></h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
      </div>
            
    </div>
  </div>
</div>
    
<br>
<br>
<div class="container-fluid mt--7">

  <div class="row">
    <div class="col-xl-4 order-xl-2">
      <div class="card card-profile">
        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">

        </div>
        <div class="card-body pt-0">
        @foreach($pengguna as $p)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}"> 
        <img src="{{url('/assets/img/database/'.$pengguna_detail->foto)}}" alt="AdminLTE Logo" class="profile-user-img img-fluid img-circle"
        src="../../dist/img/user4-128x128.jpg"
        alt="User profile picture">
            <div class="carousel-caption">
            <form action="/foto_pengguna_ubah" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$p->id}}">
            <input id="upload" type="file" onchange="this.form.submit()" name="foto"/>
              <a href="" id="upload_link" class="btn btn-primary bg-gradient-primary opacity-8 text-white">Ubah Gambar</a>​
            </form>
            </div>
        </div>
<br>
        <h3 class="profile-username text-center">{{$p->nama}}</h3>

        <p class="text-muted text-center">{{$p->level}}</p>
        </ul>
        @endforeach
      </div>
    </div>

    </div>
  <div class="col-xl-8 order-xl-2">
    <div class="card shadow">
      <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data {{$p->level}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Edit Akun</a>
          </li>
        </ul>
        <div class="tab-content">

        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card-body">
              @if($p->level =="Siswa")
              <div class="form-group">
                  <label for="nis" class="col-sm-2 control-label">NIS</label>

                  <div class="col-sm-10">
                    @if(Auth::user()->level == 'Pengurus')
                    <input type="number" class="form-control" id="nis" name="nis" value="{{$p->nis}}">
                    @else
                    <input type="number" class="form-control" id="nis" name="nis" value="{{$p->nis}}" disabled>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="nama" class="col-sm-2 control-label">Nama</label>

                  <div class="col-sm-10">
                  <input type="text" class="form-control readonly" id="nama" name="nama" value="{{$p->nama}}" readonly>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="kelas" class="col-sm-2 control-label">Kelas</label>

                  <div class="col-sm-10">
                  <input type="text" class="form-control readonly" id="kelas" name="kelas" value="{{$p->kelas}}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="jk" class="col-sm-2 control-label">Jenis Kelamin</label>

                  <div class="col-sm-10">
                  <input type="text" class="form-control readonly" id="jk" name="jk" value="{{$p->jk}}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="rombel" class="col-sm-2 control-label">Rombel</label>
                  @foreach($rombel as $ro)
                    @if($ro->id_rombel == $p->rombel_id)
                    <div class="col-sm-10">
                    <input class="form-control readonly" value="{{$ro->nama_rombel}}" readonly>
                    </div>
                    @endif
                  @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="rayon" class="col-sm-2 control-label">Rayon</label>
                  @foreach($rayon as $ro)
                    @if($ro->id_rayon == $p->rayon_id)
                    <div class="col-sm-10">
                    <input class="form-control readonly" value="{{$ro->nama_rayon}}" readonly>
                    </div>
                    @endif
                  @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="jurusan" class="col-sm-2 control-label">Jurusan</label>
                  @foreach($jurusan as $ro)
                    @if($ro->id_jurusan == $p->jurusan_id)
                    <div class="col-sm-10">
                    <input class="form-control readonly" value="{{$ro->nama_jurusan}}" readonly>
                    </div>
                    @endif
                  @endforeach
                  </select>
                </div>

                @else

                  <form action="/instuktur_data_pribadi/update" method="POST">
                  @csrf
                  <input type="hidden" class="form-control" id="id" name="id" value="{{$p->id}}">
                  
                  <div class="form-group">
                    <label for="nama" class="col-sm-4 control-label">Nama Lengkap</label>

                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" value="{{$p->nama}}">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="jk" class="col-sm-5 control-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" name="jk">
                        @if($p->jk== "P")
                        <option value="P" selected="selected">P</option>
                        @else
                        <option value="P">P</option>
                        @endif
                        @if($p->jk== "L")
                        <option value="L" selected="selected">L</option>
                        @else
                        <option value="L">L</option>
                    @endif
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                          <div class="col-sm-10">
                          <button class="btn btn-primary btn-md">Ubah</button>
                          </div>
                          </div>
                  </form>

                @endif

            </div>
        </div>

              <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card-body">
                  <div class="card">
                    <div class="card-body">
                    <form method="POST" action="/instruktur_akun/update">
                    {{csrf_field()}}
                    <input type="hidden" class="form-control" id="id" name="id" value="{{$p->id}}">

                    <div class="form-group">
                      <div class="form-group">
                        <label for="username" class="col-sm-4 control-label">Username</label>

                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" value="{{$p->username}}">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Email</label>

                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" value="{{$p->email}}" readonly>
                        </div>
                      </div>
                    </div>


                      <div class="form-group">
                        <div class="form-group">
                          <div class="col-sm-10">
                          <button class="btn btn-primary btn-md">Ubah</button>
                          </div>
                      </div>

                      </form>
                  </div>
              </div>
<br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>
</div>
@push('scripts')

<script>
$(function(){
    $("#upload_link").on('click', function(e){
        e.preventDefault();
        $("#upload:hidden").trigger('click');
    });
});
</script>

@endpush
</body>
@endsection