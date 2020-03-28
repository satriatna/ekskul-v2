@extends('layouts.layout')
@section('content')
<style>
#upload{
    display:none
}
@media screen and (max-width: 600px) {
  .geser{
    margin-top: 20px !important;
  }
}
</style>
<title>
    Detail Data User Siswa @foreach($pengguna as $p) {{$p->nama}} @endforeach - Aplikasi Pemilihan Senbud UPD
 </title>
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
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Biodata : @foreach($pengguna as $p) {{$p->nama}} @endforeach </span></h5>
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
<div class="container-fluid mt--7">

  <div class="row">
    <div class="col-xl-4 order-xl-2">
      <div class="card card-profile">
        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">

        </div>
        <div class="card-body pt-0">
        @foreach($pengguna as $p)
        <div class="text-center">
        <input id="upload" type="file"/>
        <a href="" id="upload_link"> <img src="{{url('/assets/img/database/'.$pengguna_detail->foto)}}" alt="AdminLTE Logo" class="profile-user-img img-fluid img-circle"
        src="../../dist/img/user4-128x128.jpg"
        alt="User profile picture"></a>​
       

        </div>
        <br>

        <h3 class="profile-username text-center">{{$p->nama}}</h3>

        <p class="text-muted text-center">{{$p->nama_jurusan}}</p>

        <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
        <b>Rombel</b> <a class="float-right">{{$p->nama_rombel}}</a>
        </li>
        <li class="list-group-item">
        <b>Rayon</b> <a class="float-right">{{$p->nama_rayon}}</a>
        </li>
        <!-- <li class="list-group-item">
        <b>Jurusan</b> <a class="float-right">{{$p->nama_jurusan}}</a>
        </li> -->
        <!-- @foreach($senbud as $sen)
        @if($sen != "")
        <li class="list-group-item">
        <b>Senbud</b> <a class="float-right">{{$sen->nama_senbud}}</a>
        </li>
        @else
        @endif
        @endforeach
        @foreach($upd as $up)
        @if($up != "")
        <li class="list-group-item">
        <b>UPD</b> <a class="float-right">{{$up->nama_upd}}</a>
        </li>
        @else
        @endif
        @endforeach -->
        </ul>
        @endforeach
      </div>
    </div>

    </div>
  <div class="col-xl-8 order-xl-2 geser">
    <div class="card shadow">
      <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data Siswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Edit</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card-body">
                <form method="POST" action="/pengguna_data_pribadi/update">
                {{csrf_field()}}
                <input type="hidden" class="form-control" id="id" name="id" value="{{$p->id}}">

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
                  <input type="text" class="form-control" id="nama" name="nama" value="{{$p->nama}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="kelas" class="col-sm-2 control-label">kelas</label>
                  <div class="col-sm-10">
                  <select class="form-control select2" name="kelas">
                  @if($p->kelas== 10)
                  <option value="10" selected="selected">10</option>
                  @else
                  <option value="10">10</option>
                  @endif
                  @if($p->kelas== 11)
                  <option value="11" selected="selected">11</option>
                  @else
                  <option value="11">11</option>
                  @endif
                  </select>
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
                  <label for="rombel" class="col-sm-2 control-label">Rombel</label>
                  <div class="col-sm-10">
                  <select class="form-control select2" name="rombel">

                  @foreach($rombel as $ro)
                  @if($ro->id_rombel == $p->rombel_id)
                  <option value="{{$ro->id_rombel}}" selected="selected">{{$ro->nama_rombel}}</option>
                  @else
                  <option value="{{$ro->id_rombel}}">{{$ro->nama_rombel}}</option>
                  @endif

                  @endforeach
                  </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="rombel" class="col-sm-2 control-label">Rayon</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" name="rayon">
                      @foreach($pengguna as $p)
                      @foreach($rayon as $ray)
                      @if($ray->id_rayon == $p->rayon_id)
                      <option value="{{$ray->id_rayon}}" selected="selected">{{$ray->nama_rayon}}</option>
                      @else
                      <option value="{{$ray->id_rayon}}">{{$ray->nama_rayon}}</option>
                      @endif

                      @endforeach
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="rombel" class="col-sm-2 control-label">Jurusan</label>
                    <div class="col-sm-10">
                    <select class="form-control select2" name="jurusan">

                    @foreach($jurusan as $ju)
                    @if($ju->id_jurusan == $p->jurusan_id)
                    <option value="{{$ju->id_jurusan}}" selected="selected">{{$ju->nama_jurusan}}</option>
                    @else
                    <option value="{{$ju->id_jurusan}}">{{$ju->nama_jurusan}}</option>
                    @endif

                    @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group">
                          <div class="col-sm-10">
                          <button class="btn btn-primary btn-md">Ubah</button>
                          </div>
                </div>
                
                </form>
                
                </div>
              </div>
              <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card-body">
                  <div class="card">
                    <div class="card-body">
                    <form method="POST" action="/pengguna_akun/update">
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