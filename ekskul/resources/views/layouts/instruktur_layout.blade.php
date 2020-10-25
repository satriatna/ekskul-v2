<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Ekskul</title>
  
  <link rel="shortcut icon" href="{{('/asset/ico/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-16x16.png')}}" sizes="16x16" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- akhir Favicon -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">

<link rel="stylesheet" href="{{url('/assets/dist/css/adminlte.min.css')}}">
  <style>
      .flats{
          border-radius: 0% !important;
      }
      .container{
    padding: 10px !important;
  }
    .light {
        font-weight: lighter;
    }
    li{
        font-size: 15px !important;
    }
    .paragraf{
      font-family: sans-serif !important;
      color: #6A6A6A !important;
      font-size:15px !important;
      font-weight: bold;
    }
    h1,h2,h3,h4,h5,label{
	    font-family: sans-serif !important;
        color: #6A6A6A !important;
    }

    .text-ungu{
      color: #3E0C64 !important;
      font-weight: bold;
    }

    .abu{
        background:#EBEBEB !important;
    }

    footer{
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        z-index: 999;
    }
    .card{
      border:none !important;
    }
    .dashboard{
      color: white;
      font-weight: bold;
    }
    .btn-ungu{
        background-color: #3E0C64;
        font-family: "Open Sans";
        text-decoration:none;
        color:white;
        font-weigth:bold;
    }
    .font{
	  font-family: sans-serif !important;
    color: #6A6A6A !important;
    }
    .font-button{
    font-family: sans-serif !important;
    color: white !important;
    font-weight:bold !important;
    }

    table{
        font-family: "Arial" !important;
        color: #646464 !important;
        font-size:15px !important;
    }
    .w3-animate-right{
         animation-duration: 1s;
    }
    .bg-ungu{
            background: #69429F;
    }
    .fa-coins{
      background: white !important;
      color: white !important;
    }

  </style>
</head>
<body class="hold-transition sidebar-mini">


  <!-- Content Wrapper. Contains page content -->

 

 <!-- Navbar -->

 <nav class="main-header navbar navbar-expand bg-dark text-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Selamat Datang, {{ Auth::user()->nama }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu bg-dark dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item bg-dark" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
    </ul>
  </nav>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link text-white">
      <img src="{{url('/assets/dist/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light ml-3">Ekskul</span>
    </a>

 
    <!-- Sidebar -->
    <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('/assets/dist/img/profile.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->nama}}</a>
        </div>
      </div>
  
      
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                      <i class="fa fa-user nav-icon"></i>
                      <p>Profil</p>
                    </a>
                </li>
               
                <li class="nav-item has-treeview">
                <a href="#" class="nav-link secondary">
                    <i class="nav-icon fa fa-users"></i>
                    <p>
                     Senbud
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                       @foreach($senbud as $s)
                        <li class="nav-item ">
                            <a href="/instruktur_senbud/{{$s->id_senbud}}" class="nav-link">
                              <i class="fa fa-circle-o nav-icon"></i>
                              <p>{{$s->nama_senbud}}</p>
                            </a>
                        </li>
                       @endforeach
                  </ul>
                  <li class="nav-item has-treeview">
                  <a href="#" class="nav-link secondary">
                    <i class="nav-icon fa fa-users"></i>
                    <p>
                     UPD
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                       @foreach($upd as $u)
                        <li class="nav-item ">
                            <a href="/instruktur_upd/{{$u->id_upd}}" class="nav-link">
                              <i class="fa fa-circle-o nav-icon"></i>
                              <p>{{$u->nama_upd}}</p>
                            </a>
                        </li>
                       @endforeach
                  </ul>
                </li>
                </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          <!-- /.sidebar -->
  </aside>


  @include('sweetalert::alert')

  @yield('content')

<!-- ./wrapper -->
<!-- MEMPENGARUHI LOGOUT -->
<!-- jQuery -->
<script src="{{url('assets/plugins/jquery/jquery.min.js')}} "></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<!-- AdminLTE App -->
<script src="{{url('/assets/dist/js/adminlte.js')}} "></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/assets/v')}} "></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/assets/dist/js/demo.js')}} "></script>
<!-- jQuery -->
<script src="//code.jquery.com/jquery.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>


 <!-- MODAL EDIT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- AKHIR MODAL EDIT -->
@stack('scripts')
