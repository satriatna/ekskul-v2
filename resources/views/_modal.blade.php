@if (Session::has('modal'))
    <script>
        swal({
            text: "{!! Session::get('sweet_alert.text') !!}",
            title: "{!! Session::get('sweet_alert.title') !!}",
            icon: "{!! Session::get('sweet_alert.type') !!}",
            buttons: "{!! Session::get('sweet_alert.buttons') !!}",
        });
    </script>
@endif