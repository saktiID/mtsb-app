<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'MTsB App') | MTsB App</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png?v' . now()) }}" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href=" {{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/loader.js') }}"></script>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=' . time()) }}">
    <link href="{{ asset('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-toaster/bootstrap-toaster.min.css') }}" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    @yield('style')

    <style>
        @media print {
            #content {
                margin-top: -20px !important;
            }

            button,
            #foto,
            .footer-wrapper {
                display: none !important;
            }
        }

    </style>

    <style>
        /* Style untuk lightbox dan gambar */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 999999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .lightbox img {
            height: 320px;
            width: 320px
        }

        /* Style untuk menutup lightbox */
        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 40px;
            color: #fff;
            cursor: pointer;
        }

    </style>

    {{-- pwa --}}
    @laravelPWA
    {{-- endpwa --}}
</head>
