<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QMS Centris</title>

    <!-- Fonts -->
    <link id="googleFonts"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&amp;display=swap"
        rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <link href="{{ asset('vendors/css/vendor.bundle.base.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/feather/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatablesnet-bs4/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('js/select.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vertical-layout-light/style.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>

<body class="antialiased">
    <div id="app">
       
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js" async></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}" defer></script>
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}" async></script>
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}" defer></script>
    <script src="{{ asset('vendors/datatablesnet-bs4/dataTables-bootstrap4.js') }}" defer></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}" defer></script>
    <script src="{{ asset('js/Chart.roundedBarCharts.js') }}" async></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/chart.js') }}" async></script>
    <script src="{{ asset('js/off-canvas.js') }}" async></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}" async></script>
    <script src="{{ asset('js/template.js') }}" async></script>
    <script src="{{ asset('js/settings.js') }}" async></script>
    <script src="{{ asset('js/todolist.js') }}" async></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" async></script>


</body>

</html>
