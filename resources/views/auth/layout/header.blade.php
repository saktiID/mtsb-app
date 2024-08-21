<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!-- Primary Meta Tags -->
    <title>MTs Bilingual APP — Aplikasi sarana belajar</title>
    <meta name="title" content="MTs Bilingual — Aplikasi sarana belajar" />
    <meta name="description" content="Dengan aplikasi ini siswa dapat melihat daftar nilai yang dicapai selama pembelajaran di MTs Bilingual Muslimat NU Pucang Sidoarjo." />
    <meta name="keywords" content="mtsb, app mtsb, mtsb-app, app-mtsb">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="MTs Bilingual — Aplikasi sarana belajar" />
    <meta property="og:description" content="Dengan aplikasi ini siswa dapat melihat daftar nilai yang dicapai selama pembelajaran di MTs Bilingual Muslimat NU Pucang Sidoarjo." />
    <meta property="og:image" content="{{ asset('meta.jpeg') }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="MTs Bilingual — Aplikasi sarana belajar" />
    <meta property="twitter:description" content="Dengan aplikasi ini siswa dapat melihat daftar nilai yang dicapai selama pembelajaran di MTs Bilingual Muslimat NU Pucang Sidoarjo." />
    <meta property="twitter:image" content="{{ asset('meta.jpeg') }}" />

    {{-- <title>@yield('title', 'MTsB App') | MTsB App</title> --}}
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    {{-- BEGIN PLUGIN --}}
    @yield('style')
    {{-- END BEGIN PLUGIN --}}
    {{-- pwa --}}
    @laravelPWA
    {{-- endpwa --}}
</head>
