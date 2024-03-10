<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="./assets/img/favicon.png">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

        <!-- CSS -->
        @vite([
            'resources/sass/app.scss',
            'resources/js/app.js',
            'resources/argon/css/argon-dashboard.css',
            'resources/argon/css/nucleo-icons.css',
            'resources/argon/css/nucleo-svg.css',
            'resources/argon/css/custom.css',

            'resources/js/main.js',
        ])
    </head>
    <body class="g-sidenav-show   bg-gray-100">
        <div id="app">
            <main>
                @yield('content')
            </main>
        </div>
    </body>
    <!-- Scripts -->
    @vite([    
        'resources/argon/js/core/popper.min.js', 
        // 'resources/argon/js/core/bootstrap.min.js', 
        'resources/argon/js/plugins/perfect-scrollbar.min.js', 
        'resources/argon/js/plugins/smooth-scrollbar.min.js', 
        'resources/argon/js/plugins/chartjs.min.js', 
    ])

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    @vite([    
        // 'resources/argon/js/argon-dashboard.min.js',
        'resources/argon/js/argon-dashboard.js',
    ])

    {{-- <script src="{{ asset('argon/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('argon/js/argon-dashboard.min.js?v=2.0.4') }}"></script> --}}
    {{-- <script src="{{ asset('argon/js/argon-dashboard.js') }}"></script> --}}
    {{-- <script src="{{ asset('argon/js/argon-dashboard.js') }}"></script> --}}
</html>
