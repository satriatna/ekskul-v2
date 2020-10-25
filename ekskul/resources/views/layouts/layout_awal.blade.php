<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    body{
        background-image: public/img/1.jpg  ;
    }
    </style>
  <meta charset="utf-8">
  <title>Aplikasi Pemilihan Senbud UPD </title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{{url('/assets/awal/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{{url('/assets/awal/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{url('/assets/awal/lib/animate/animate.min.css')}}" rel="stylesheet">
  <link href="{{url('/assets/awal/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
  <link href="{{url('/assets/awal/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{url('/assets/awal/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{url('/assets/awal/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
    Theme Name: awal
    Theme URL: https://bootstrapmade.com/awal-bootstrap-business-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
        <img src="../assets/img/brand/logo.png" />

        <a href="#intro" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li class=""><a href="/login">Masuk</a></li>
          <li class="active"><a href="#intro">Home</a></li>
          
          <li><a href="#services">Kegiatan</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <!-- <li><a href="#testimonials">Team</a></li> -->
        </ul>
      </nav><!-- .main-nav -->
      
    </div>
  </header><!-- #header -->
  @include('sweetalert::alert')
  
  @yield('content')

  <!-- JavaScript Libraries -->
  <script src="{{url('/assets/awal/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/easing/easing.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/mobile-nav/mobile-nav.js')}}"></script>
  <script src="{{url('/assets/awal/lib/wow/wow.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/counterup/counterup.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{url('/assets/awal/lib/lightbox/js/lightbox.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{url('/assets/awal/contactform/contactform.js')}}"></script>

  <script src="{{url('/assets/awal/js/main.js')}}"></script>


</body>
</html>

