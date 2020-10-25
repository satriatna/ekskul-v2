

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
   <!-- Favicon -->
   <link href="{{('/assets/img/brand/logo.png')}}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700')}}" rel="stylesheet">
  <!-- Icons -->
  <link href="{{('/assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
  <link href="{{('/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{('/assets/css/argon-dashboard.css?v=1.1.0')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

  <!-- Main Stylesheet File -->
  <link href="{{url('/assets/awal/css/style.css')}}" rel="stylesheet">
  <style>
  @media screen and (max-width: 992px) {
  .export-geser {
    margin-top: 20px !important;
  }
  }
    .readonly{
      background-color: white !important; 
    }
    @media screen and (max-width: 992px) {
  .geser {
    margin-top: 40px !important;
  }
  .navbar {
    margin: 0 !important;
    padding : 0 !important;
  }
  .pointer:hover{
    cursor:pointer !important;
  }
}
  </style>
</head>
<body style="background-color: #e6e5e5;">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      
      @if(Auth::user()->level == 'Pengurus')
      <a class="navbar-brand pt-0" href="/dashboard_admin">
      @elseif(Auth::user()->level == 'Instruktur')
      <a class="navbar-brand pt-0" href="/dashboard_instruktur">
      @else
      <a class="navbar-brand pt-0" href="/dashboard_siswa ">
      @endif
      <img src="{{url('/assets/img/brand/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-1"
           style="opacity: .8">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
              @foreach($users as $u)
                  <img alt="Image placeholder" src="{{url('/assets/img/database/'.$u->foto )}}">
                  @endforeach
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome! {{Auth::user()->nama}} </h6>
            </div>
            <a href class="dropdown-item" data-toggle="modal" data-target="#exampleModalChangePassword" class="dropdown-item pointer">
                <i class="ni ni-settings-gear-65"></i>
                <span class="pointer">Change Password</span>
              </a>
            <div class="dropdown-divider"></div>
             <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
            @if(Auth::user()->level == 'Pengurus')
            <a href="/dashboard_admin">
               <img src="{{url('/assets/img/brand/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-1"
           style="opacity: .8">
            </a>
          @elseif(Auth::user()->level == 'Instruktur')
            <a href="/dashboard_instruktur">
               <img src="{{url('/assets/img/brand/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-1"
           style="opacity: .8">
            </a>
            @elseif(Auth::user()->level == 'Piket')
            <a href="/dashboard_piket">
               <img src="{{url('/assets/img/brand/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-1"
           style="opacity: .8">
            </a>
          @else
            <a href="/dashboard_siswa">
               <img src="{{url('/assets/img/brand/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-1"
           style="opacity: .8">
            </a>
          @endif
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
       
        <!-- Navigation -->
        <ul class="navbar-nav">
        @if(Auth::user()->level == 'Pengurus')
        <li class="nav-item {{ (request()->is('dashboard_admin*')) ? 'active' : '' }}">
            <a class="nav-link {{ (request()->is('dashboard_admin*')) ? 'active' : '' }}" href="/dashboard_admin">
              <i class="ni ni-planet text-blue"></i> Dashboard
            </a>
          </li>
          @elseif(Auth::user()->level == 'Instruktur')
          <li class="nav-item {{ (request()->is('dashboard_instruktur*')) ? 'active' : '' }}">
            <a class="nav-link {{ (request()->is('dashboard_instruktur*')) ? 'active' : '' }}" href="/dashboard_instruktur">
              <i class="ni ni-planet text-blue"></i> Dashboard
            </a>
          </li>
          @elseif(Auth::user()->level == 'Piket')
          <li class="nav-item {{ (request()->is('dashboard_piket*')) ? 'active' : '' }}">
            <a class="nav-link {{ (request()->is('dashboard_piket*')) ? 'active' : '' }}" href="/dashboard_piket">
              <i class="ni ni-planet text-blue"></i> Dashboard
            </a>
          </li>
          @else
          <li class="nav-item {{ (request()->is('dashboard_siswa*')) ? 'active' : '' }}">
            <a class="nav-link {{ (request()->is('dashboard_siswa*')) ? 'active' : '' }}" href="/dashboard_siswa">
              <i class="ni ni-planet text-blue"></i> Dashboard
            </a>
          </li>
          @endif
          @if(Auth::user()->level != 'Pengurus')
          @else
            <li class="nav-item {{ (request()->is('rombel*')) ? 'active' : '' }} {{ (request()->is('rayon*')) ? 'active' : '' }} {{ (request()->is('jurusan*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-ungroup text-orange"></i>
                <span class="nav-link-text">Data Master</span>
              </a>
              <div class="collapse {{ (request()->is('rombel*')) ? 'show' : '' }} {{ (request()->is('rayon*')) ? 'show' : '' }} {{ (request()->is('jurusan*')) ? 'show' : '' }}" id="navbar-examples">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="/rombel" class="nav-link {{ (request()->is('rombel*')) ? 'active' : '' }}">Rombel</a>
                  </li>
                  <li class="nav-item">
                    <a href="/rayon" class="nav-link  {{ (request()->is('rayon*')) ? 'active' : '' }}">Rayon</a>
                  </li>
                  <li class="nav-item">
                    <a href="/jurusan" class="nav-link  {{ (request()->is('jurusan*')) ? 'active' : '' }}">Jurusan</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ (request()->is('senbud*')) ? 'active' : '' }} {{ (request()->is('ekskul/biasa*')) ? 'active' : '' }} {{ (request()->is('ekskul/produktif*')) ? 'active' : '' }} {{ (request()->is('keputrian*')) ? 'active' : '' }}" href="#navbar-examples3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-bullet-list-67 text-green"></i>
                <span class="nav-link-text">Data Kegiatan</span>
              </a>
              <div class="collapse  {{ (request()->is('senbud*')) ? 'show' : '' }} {{ (request()->is('ekskul/biasa*')) ? 'show' : '' }} {{ (request()->is('ekskul/produktif*')) ? 'show' : '' }} {{ (request()->is('keputrian*')) ? 'show' : '' }}" id="navbar-examples3">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="/senbud" class="nav-link  {{ (request()->is('senbud*')) ? 'active' : '' }}">Seni Budaya</a>
                  </li>
                  <li class="nav-item">
                    <a href="/ekskul/biasa" class="nav-link {{ (request()->is('ekskul/biasa*')) ? 'active' : '' }} ">Ekskul Biasa</a>
                  </li>
                  <li class="nav-item">
                    <a href="/ekskul/produktif" class="nav-link {{ (request()->is('ekskul/produktif*')) ? 'active' : '' }}">Ekskul Produktif</a>
                  </li>
                  <li class="nav-item">
                    <a href="/keputrian" class="nav-link {{ (request()->is('keputrian*')) ? 'active' : '' }}">Keputrian</a>
                  </li>
                </ul>
              </div>
            </li>
          <li class="nav-item {{ (request()->is('pengurus*')) ? 'active' : '' }} {{ (request()->is('instruktur*')) ? 'active' : '' }} {{ (request()->is('siswa*')) ? 'active' : '' }} {{ (request()->is('piket*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-datauser" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-datauser">
              <i class="fas fa-users"></i>
                <span class="nav-link-text">Data User</span>
              </a>
              <div class="collapse {{ (request()->is('pengurus*')) ? 'show' : '' }} {{ (request()->is('instruktur*')) ? 'show' : '' }} {{ (request()->is('siswa*')) ? 'show' : '' }} {{ (request()->is('piket*')) ? 'show' : '' }}" id="navbar-datauser">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="/pengurus" class="nav-link {{ (request()->is('pengurus*')) ? 'active' : '' }}">Pengurus</a>
                  </li>
                  <li class="nav-item">
                    <a href="/instruktur" class="nav-link  {{ (request()->is('instruktur*')) ? 'active' : '' }}">Instruktur</a>
                  </li>
                  <li class="nav-item">
                    <a href="/siswa" class="nav-link  {{ (request()->is('siswa*')) ? 'active' : '' }}">Siswa</a>
                  </li>
                  <li class="nav-item">
                    <a href="/piket" class="nav-link {{ (request()->is('piket*')) ? 'active' : '' }}">Piket</a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          @if(Auth::user()->level == 'Instruktur')
            @if($senbud->count() != '')
            <li class="nav-item {{ (request()->is('senbud/detail*')) ? 'active' : '' }} {{ (request()->is('ekskul_biasa/detail*')) ? 'active' : '' }} {{ (request()->is('ekskul_produktif/detail*')) ? 'active' : '' }} {{ (request()->is('keputrian/detail*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-bullet-list-67 text-orange"></i>
                <span class="nav-link-text">Data Senbud</span>
              </a>
              <div class="collapse {{ (request()->is('senbud/detail*')) ? 'show' : '' }}" id="navbar-examples">
                <ul class="nav nav-sm flex-column">
                 @foreach($senbud as $s)
                 <li class="nav-item">
                    <a href="/senbud/detail/{{$s->id_senbud}}/{{Auth::user()->id}}" class="nav-link {{ (request()->is('senbud/detail*')) ? 'active' : '' }}">{{$s->nama_senbud}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            
            @else
            @endif
            @if($ekskul_biasa->count() != '')
            <li class="nav-item">
              <a class="nav-link" href="#navbar-examples2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-bullet-list-67 text-yellow"></i>
                <span class="nav-link-text">Data Ekskul Biasa</span>
              </a>
              <div class="collapse" id="navbar-examples2">
                <ul class="nav nav-sm flex-column">
                 @foreach($ekskul_biasa as $s)
                 <li class="nav-item">
                    <a href="/ekskul_biasa/detail/{{$s->id_ekskul_biasa}}/{{Auth::user()->id}}" class="nav-link">{{$s->nama_ekskul_biasa}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            @else
            @endif
            @if($ekskul_produktif->count() != '')
            <li class="nav-item">
              <a class="nav-link" href="#navbar-examples3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-bullet-list-67 text-green"></i>
                <span class="nav-link-text">Data Ekskul Produktif</span>
              </a>
              <div class="collapse" id="navbar-examples3">
                <ul class="nav nav-sm flex-column">
                 @foreach($ekskul_produktif as $s)
                 <li class="nav-item">
                    <a href="/ekskul_produktif/detail/{{$s->id_ekskul_produktif}}/{{Auth::user()->id}}" class="nav-link">{{$s->nama_ekskul_produktif}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            @else
            @endif
            @if($keputrian->count() != '')
            <li class="nav-item">
              <a class="nav-link" href="#navbar-examples4" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-bullet-list-67 text-dark"></i>
                <span class="nav-link-text">Data Keputrian</span>
              </a>
              <div class="collapse" id="navbar-examples4">
                <ul class="nav nav-sm flex-column">
                 @foreach($keputrian as $s)
                 <li class="nav-item">
                    <a href="/keputrian/detail/{{$s->id_keputrian}}/{{Auth::user()->id}}" class="nav-link">{{$s->nama_keputrian}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            @else
            @endif
            
            @else
            
            @if($senbud_per_siswa->count() != '')
            <li class="nav-item {{ (request()->is('kehadiran_senbud_per_siswa*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-1" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-1">
                <i class="ni ni-bullet-list-67 text-orange"></i>
                <span class="nav-link-text">Data Senbud</span>
              </a>
              <div class="collapse {{ (request()->is('kehadiran_senbud_per_siswa*')) ? 'show' : '' }}" id="navbar-1">
                <ul class="nav nav-sm flex-column">
                 @foreach($senbud_per_siswa as $s)
                 <li class="nav-item">
                    <a href="/kehadiran_senbud_per_siswa/{{$s->id_senbud}}" class="nav-link {{ (request()->is('kehadiran_senbud_per_siswa*')) ? 'active' : '' }}">{{$s->nama_senbud}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            
            @else
            @endif
            @if($ekskul_biasa_per_siswa->count() != '')
            <li class="nav-item {{ (request()->is('kehadiran_ekskul_biasa_per_siswa*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-2">
                <i class="ni ni-bullet-list-67 text-yellow"></i>
                <span class="nav-link-text">Data Ekskul Biasa</span>
              </a>
              <div class="collapse {{ (request()->is('kehadiran_ekskul_biasa_per_siswa*')) ? 'show' : '' }}" id="navbar-2">
                <ul class="nav nav-sm flex-column">
                 @foreach($ekskul_biasa_per_siswa as $s)
                 <li class="nav-item">
                    <a href="/kehadiran_ekskul_biasa_per_siswa/{{$s->id_ekskul_biasa}}" class="nav-link {{ (request()->is('kehadiran_ekskul_biasa_per_siswa*')) ? 'active' : '' }}">{{$s->nama_ekskul_biasa}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            
            @else
            @endif
            @if($ekskul_produktif_per_siswa->count() != '')
            <li class="nav-item {{ (request()->is('kehadiran_ekskul_produktif_per_siswa*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-3">
                <i class="ni ni-bullet-list-67 text-success"></i>
                <span class="nav-link-text">Data Ekskul Produktif</span>
              </a>
              <div class="collapse {{ (request()->is('kehadiran_ekskul_produktif_per_siswa*')) ? 'show' : '' }}" id="navbar-3">
                <ul class="nav nav-sm flex-column">
                 @foreach($ekskul_produktif_per_siswa as $s)
                 <li class="nav-item">
                    <a href="/kehadiran_ekskul_produktif_per_siswa/{{$s->id_ekskul_produktif}}" class="nav-link {{ (request()->is('kehadiran_ekskul_produktif_per_siswa*')) ? 'active' : '' }}">{{$s->nama_ekskul_produktif}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            
            @else
            @endif
            @if($keputrian_per_siswa->count() != '')
            <li class="nav-item {{ (request()->is('kehadiran_keputrian_per_siswa*')) ? 'active' : '' }}">
              <a class="nav-link" href="#navbar-4" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-4">
                <i class="ni ni-bullet-list-67 text-dark"></i>
                <span class="nav-link-text">Data keputrian</span>
              </a>
              <div class="collapse {{ (request()->is('kehadiran_keputrian_per_siswa*')) ? 'show' : '' }}" id="navbar-4">
                <ul class="nav nav-sm flex-column">
                 @foreach($keputrian_per_siswa as $s)
                 <li class="nav-item">
                    <a href="/kehadiran_keputrian_per_siswa/{{$s->id_keputrian}}" class="nav-link {{ (request()->is('kehadiran_keputrian_per_siswa*')) ? 'active' : '' }}">{{$s->nama_keputrian}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            
            @else
            @endif
            @if(Auth::user()->level == 'Piket')
            <li class="nav-item">
              <a class="nav-link {{ (request()->is('senbud*')) ? 'active' : '' }} {{ (request()->is('ekskul/biasa*')) ? 'active' : '' }} {{ (request()->is('ekskul/produktif*')) ? 'active' : '' }} {{ (request()->is('keputrian*')) ? 'active' : '' }}" href="#navbar-examples3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-bullet-list-67 text-green"></i>
                <span class="nav-link-text">Data Kegiatan</span>
              </a>
              <div class="collapse  {{ (request()->is('senbud*')) ? 'show' : '' }} {{ (request()->is('ekskul/biasa*')) ? 'show' : '' }} {{ (request()->is('ekskul/produktif*')) ? 'show' : '' }} {{ (request()->is('keputrian*')) ? 'show' : '' }}" id="navbar-examples3">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="/senbud" class="nav-link  {{ (request()->is('senbud*')) ? 'active' : '' }}">Seni Budaya</a>
                  </li>
                  <li class="nav-item">
                    <a href="/ekskul/biasa" class="nav-link {{ (request()->is('ekskul/biasa*')) ? 'active' : '' }} ">Ekskul Biasa</a>
                  </li>
                  <li class="nav-item">
                    <a href="/ekskul/produktif" class="nav-link {{ (request()->is('ekskul/produktif*')) ? 'active' : '' }}">Ekskul Produktif</a>
                  </li>
                  <li class="nav-item">
                    <a href="/keputrian" class="nav-link {{ (request()->is('keputrian*')) ? 'active' : '' }}">Keputrian</a>
                  </li>
                </ul>
              </div>
            </li>
            @else
            @endif
            @endif
            

            @if(Auth::user()->level == 'Siswa')
            <li class="nav-item {{ (request()->is('siswa/detail*')) ? 'active' : '' }}">
              <a class="nav-link {{ (request()->is('siswa/detail*')) ? 'active' : '' }}" href="/siswa/detail/{{Auth::user()->id}}">
                <i class="ni ni-settings-gear-65 text-info"></i>
                <span class="nav-link-text">Kelola Akun</span>
              </a>
            </li>
            @else
            <li class="nav-item {{ (request()->is('pengguna/detail*')) ? 'active' : '' }}">
              <a class="nav-link {{ (request()->is('pengguna/detail*')) ? 'active' : '' }}" href="/pengguna/detail/{{Auth::user()->id}}">
                <i class="ni ni-settings-gear-65 text-info"></i>
                <span class="nav-link-text">Kelola Akun</span>
              </a>
            </li>
            @endif
        </ul>
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        @if(Auth::user()->level == 'Pengurus')
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/dashboard_admin">Dashboard</a>
          @elseif(Auth::user()->level == 'Instruktur')
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/dashboard_instruktur">Dashboard</a>
          @elseif(Auth::user()->level == 'Piket')
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/dashboard_piket">Dashboard</a>
          @else
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/dashboard_siswa">Dashboard</a>
          @endif
     
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
              @foreach($users as $u)
                  <img alt="Image placeholder" src="{{url('/assets/img/database/'.$u->foto )}}">
                  @endforeach
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->nama}}</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome! {{Auth::user()->nama}}</h6>
              </div>
              
              <a href data-toggle="modal" data-target="#exampleModalChangePassword" class="dropdown-item pointer">
                <i class="ni ni-settings-gear-65"></i>
                <span class="pointer">Change Password</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    

          <div class="modal fade" id="exampleModalChangePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">{{ __('Change Password') }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                          <form method="POST" action="/ubah/password" onsubmit="return cekStok()">
                              {{csrf_field()}}
                              <input type="hidden" name="id_user" value="{{Auth::user()->id}}" class="form-control">
                                   
                                  <label for="password_lama"> Password </label>
                                        <input type="password" id="password_lama" name="password_lama" class="form-control" required>
                                  
                                  <label for="password"> New Password </label> 
                                        <input type="password" id="password" name="password" class="form-control" required>
                                  
                                  
                                  <label for="password_confirm"> Confirm Password </label>
                                        <input type="password" id="password_confirm" name="password_confirmation" class="form-control" required>
                                       <button class=" mt-2 btn btn-primary xs">Change Password</button>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </form>
                          </div>
                          </div>
                      </div>
                  </div>
   
  
  @yield('content') 
  @include('sweetalert::alert')
<script type="text/javascript">


function cekStok(){
    var stok = document.getElementById('password').value;
    var terpakai = document.getElementById('password_confirm').value;
    if (stok != terpakai) {
      alert("Maaf konfirmasi password tidak cocok");    
      return false;
    }
    else{
      return true;
   }
}

    </script>

 <!--   Core   -->
 <script src="{{url('/assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{url('/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

  <!--   Argon JS   -->
  <script src="{{url('/assets/js/argon-dashboard.min.js?v=1.1.0')}}"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
   
}
  </script>

  <!-- Layout Awal -->
  <!-- JavaScript Libraries -->
  <script src="{{url('/assets/awal/lib/wow/wow.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/counterup/counterup.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/lightbox/js/lightbox.min.js')}}"></script>
  <!-- Template Main Javascript File -->
  <script src="{{url('/assets/awal/js/main.js')}}"></script>
<!-- Akhir Layout Awal -->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


 <!-- MODAL EDIT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- AKHIR MODAL EDIT -->
@stack('scripts')
</body>