@extends('layouts.layout')
@section('content')

<title>
    Data Pengguna Siswa - Aplikasi Pemilihan Senbud UPD
</title>
<div class="header pb-6 d-flex align-items-center" style="min-height: 400px; background-image: url(../../assets/img/brand/1.jpg); background-size: cover; background-position: 800px">
      <!-- Mask -->
      <span class="mask bg-gradient-primary opacity-8"></span>
      <div class="container-fluid" style="margin-top:-100px !important;">
      <div class="row">
                    <div class="card bg-default border-0 ml-3">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Semua Siswa </span></h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
         
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7" style="margin-top:-210px !important;">

      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
                <div class="card-header bg-transparent">
                    <button type="button" class="btn-sm btn btn-primary flats" data-toggle="modal" data-target="#exampleModal">
                        Tambah Siswa
                    </button>
                </div>
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table class="table table-bordered text-center data-table" id="users-table">

                <thead class="bg-secondary">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                
                </thead>
            </div>
            </div>
          </div>
        </div>
        
      </div>
     
    </div>
  </div>
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="exampleModalLabel">Tambah Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" role="form" method="POST" action="/tambah/siswa">
                    {{ csrf_field() }}
                    {{ method_field('post') }}

                <div class="form-group">
                    <input id="nis" type="number" min="8" onKeyPress="if(this.value.length==8) return false;" class="form-control{{ $errors->has('nis') ? ' is-invalid' : '' }}" name="nis" value="{{ old('nis') }}" placeholder="nis" required autofocus>
                    @if ($errors->has('nis'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nis') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Nama Siswa" required autofocus>
                    @if ($errors->has('nama'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                </div>
<!-- 
                <div class="form-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                     </span>
                    @endif
                </div>
                        
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                </div> -->
                <div class="form-group">
                <select name="kelas" id="kelas" class="form-control{{ $errors->has('kelas') ? ' is-invalid' : '' }}" required>
                    <option value="">Pilih Kelas</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                </select>
                @if ($errors->has('kelas'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('kelas') }}</strong>
                    </span>
                @endif
                </div>
                <div class="form-group">
                <select name="rombel_id" id="rombel" class="form-control{{ $errors->has('rombel') ? ' is-invalid' : '' }}" required>
                    <option value="">Pilih Rombel</option>
                    @foreach($rombel as $ro)
                        <option value="{{$ro->id_rombel}}">{{$ro->nama_rombel}}</option>
                    @endforeach
                </select>
                @if ($errors->has('rombel'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('rombel') }}</strong>
                    </span>
                @endif
                </div>

                <div class="form-group">
                <select name="rayon_id" id="rayon" class="form-control{{ $errors->has('rayon') ? ' is-invalid' : '' }}" required>
                    <option value="">Pilih rayon</option>
                    @foreach($rayon as $ra)
                        <option value="{{$ra->id_rayon}}">{{$ra->nama_rayon}}</option>
                    @endforeach
                </select>
                @if ($errors->has('rayon'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('rayon') }}</strong>
                    </span>
                @endif
                </div>

                <div class="form-group">
                <select name="jurusan_id" id="jurusan" class="form-control{{ $errors->has('jurusan') ? ' is-invalid' : '' }}" required>
                    <option value="">Pilih jurusan</option>
                    @foreach($jurusan as $ju)
                        <option value="{{$ju->id_jurusan}}">{{$ju->nama_jurusan}}</option>
                    @endforeach
                </select>
                @if ($errors->has('jurusan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jurusan') }}</strong>
                    </span>
                @endif
                </div>
                
                <div class="form-group">
                <select name="jk" id="jk" class="form-control{{ $errors->has('jk') ? ' is-invalid' : '' }}" required>
                    <option value="">Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @if ($errors->has('jk'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jk') }}</strong>
                    </span>
                @endif
                </div>
                
               <div class="row">
                    <button type="submit" class="btn btn-md btn-primary ml-3">
                        Tambah
                    </button>
                    <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                
                </form>
      </div>
     
    </div>
  </div>
</div>
</div>  
@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
       serverSide: true,
       ajax: '/siswa/json',
       columns: [
           
           { data: 'nis', name: 'nis' },
           { data: 'nama', name: 'nama' },
           { data: 'nama_rombel', name: 'nama_rombel' },
           { data: 'inisial_rayon', name: 'inisial_rayon' },
           { data: 'status', name: 'status' },
           {data: 'action', name: 'action', orderable: false, searchable: false},

       ],
    });
    
});

</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

@endpush
  @endsection