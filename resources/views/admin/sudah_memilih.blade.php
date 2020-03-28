@extends('layouts.layout')
@section('content')
 
<title>
    Siswa Sudah Memilih - Aplikasi Pemilihan Senbud UPD
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
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Data Siswa Sudah Memilih </span></h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
                <div class="card bg-none border-0 ml-3 export-geser">
                    <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">
                                @if($siswa->count() == "")
                                <button class="btn btn-primary btn-block" disabled>Export Excel</button>
                                @else
                                <a href="/siswa/sudah_memilih_export" class="btn btn-primary btn-block">Export Excel</a>
                                @endif
                   
                                </h5>
                                </div>
                                <div class="col-auto">
                              
                            </div>
                        </div>
                  
                    </div>
                </div>
  <br>
         
         
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7" style="margin-top:-210px !important;">

      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
        
            <div class="card-body">
            <div style="overflow-x:auto;">
            <table class="table table-bordered text-center data-table" id="users-table">

                <thead class="bg-secondary">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                    <th>Tgl Memilih</th>
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
  
@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
       serverSide: true,
       ajax: '/sudah/memilih/json',
       columns: [
          
        { data: 'nis', name: 'nis' },
           { data: 'nama', name: 'nama' },
           { data: 'nama_rombel', name: 'nama_rombel' },
           { data: 'nama_rayon', name: 'nama_rayon' },
           { data: 'tgl_pilih', name: 'tgl_pilih' },
           {data: 'action', name: 'action', orderable: false, searchable: false},
       ]
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