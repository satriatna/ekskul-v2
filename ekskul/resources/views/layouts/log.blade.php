<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
  <link rel="shortcut icon" href="{{('/asset/ico/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-16x16.png')}}" sizes="16x16" />
    <!-- akhir Favicon -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/assets/dist/css/adminlte.min.css')}}">
</head>
<body>
    

@yield('content')
<!-- ./wrapper -->
<!-- MEMPENGARUHI LOGOUT -->
<!-- jQuery -->
<script src="{{url('assets/plugins/jquery/jquery.min.js')}} "></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- App scripts -->
<script>

  </script>
 <script src="//code.jquery.com/jquery.js"></script>


        @stack('scripts')
</body>
</html>