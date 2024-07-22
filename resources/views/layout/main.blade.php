<!DOCTYPE html>
<html lang="en">

@include('layout.header')

<body class="sidebar-noneoverflow">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    {{-- install pwa --}}
    <div id="installWrap">
        <div class="close text-light" id="clsInstallBtn">
            <i data-feather="x-circle"></i>
        </div>
        <div class="content text-center mt-2">
            <a href="javascript:void(0);" id="installButton" class="text-light">Klik untuk install MTsB APP</a>
        </div>
    </div>
    {{-- end install pwa --}}

    <!--  BEGIN NAVBAR  -->
    @include('layout.navbar')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('layout.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">


                <!-- CONTENT AREA -->
                @yield('content')

                @yield('modal')

                @yield('modal_logout')
                <!-- CONTENT AREA -->

            </div>


            @include('layout.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    {{-- aux --}}
    <audio id="aux_success">
        <source src="{{ asset('audio/success.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="aux_error">
        <source src="{{ asset('audio/error.mp3') }}" type="audio/mpeg">
    </audio>
    {{-- endaux --}}

    {{-- BEGIN SCRIPTS --}}
    @include('layout.scripts')
    {{-- END BEGIN SCRIPTS --}}
</body>
</html>
