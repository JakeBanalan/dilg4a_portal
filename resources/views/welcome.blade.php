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
        <ul>
            <li v-for="message in messages" :key="message.id">

            </li>
        </ul>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatablesnet-bs4/dataTables-bootstrap4.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/Chart.roundedBarCharts.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>
        // Initialize Pusher
        var pusher = new Pusher('29d53f8816252d29de52', {
            cluster: 'ap1'
        });

        // Vue application
        const app = new Vue({
            el: 'app', // Make sure to use '#' if 'app' is an ID
            data: {
                messages: [],
            },
        });

        // Subscribe to the ICT TA channel for admin notifications
        if (localStorage.getItem('user_role') === 'admin') {
            var channel = pusher.subscribe('ict-ta-channel');
            channel.bind('new-ict-ta', function(data) {
                // Show SweetAlert notification
                Swal.fire({
                    title: 'New Request',
                    text: 'A new request has been created.', // You can add more details if needed
                    icon: 'info',
                    confirmButtonText: 'Okay'
                }).then((result) => {
                    // Check if the user clicked the confirm button
                    if (result.isConfirmed) {
                        // Redirect to the specified path
                        window.location.href = '/rictu/ict_ta/index';
                    }
                });
            });
        }

        // Subscribe to the Received TA channel for user notifications
        if (localStorage.getItem('user_role') === 'user') {
            var channel = pusher.subscribe('received-ta-channel');
            channel.bind('received-ict-ta', function(data) {
                // Show SweetAlert notification
                Swal.fire({
                    title: 'Your Request has been Received',
                    icon: 'info',
                    confirmButtonText: 'Okay'
                }).then((result) => {
                    // Check if the user clicked the confirm button
                    if (result.isConfirmed) {
                        // Reload the page
                        location.reload();
                    }
                });
            });
        }

         // Subscribe to the Completed TA channel for user notifications
         if (localStorage.getItem('user_role') === 'user') {
            var channel = pusher.subscribe('completed-ta-channel');
            channel.bind('completed-ict-ta', function(data) {
                // Show SweetAlert notification
                Swal.fire({
                    title: 'Your Request has been Completed',
                    text: 'Please dont forget to take the Survey Thank you!.', // You can add more details if needed
                    icon: 'info',
                    confirmButtonText: 'Okay'
                }).then((result) => {
                    // Check if the user clicked the confirm button
                    if (result.isConfirmed) {
                        // Reload the page
                        location.reload();
                    }
                });
            });
        }
    </script> --}}

</body>

</html>
