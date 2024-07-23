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

                {{-- install app --}}
                <style>
                    #installPWAWrapper {
                        z-index: 99;
                        position: fixed;
                        bottom: 10px;
                        right: 3%;
                        width: 94%;
                    }

                </style>

                <div id="installPWAWrapper">
                    <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="bi-x" style="color: #000"></i></button>
                        <i data-feather="alert-triangle"></i>
                        <strong>Install</strong> <span class="mr-2"> aplikasi di perangkat Kamu!</span>
                        <button id="installPWA" class="btn btn-primary btn-sm"></button>
                    </div>
                </div>
                {{-- end install app --}}
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

    {{-- pwa --}}
    <script>
        let deferredPrompt

        window.addEventListener('beforeinstallprompt', (e) => {
            //  e.preventDefault()
            deferredPrompt = e
        })

        const installButton = document.getElementById('installPWA')
        const installWrap = document.getElementById('installPWAWrapper')

        if (installButton) {
            function updateInstallButton() {
                if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                    installButton.textContent = 'Installed'
                    installWrap.style.display = 'none'
                } else {
                    installButton.textContent = 'Install Now'
                    installWrap.style.display = 'block'
                }
            }

            installButton.addEventListener('click', async () => {
                if (installButton.textContent === 'Installed') {
                    return
                }

                if (deferredPrompt) {
                    deferredPrompt.prompt()
                    const {
                        outcome
                    } = await deferredPrompt.userChoice
                    if (outcome === 'accepted') {
                        installButton.textContent = 'Installed'
                        installWrap.style.display = 'none'
                    } else {
                        installButton.textContent = 'Install Now'
                    }
                    deferredPrompt = null
                }
            })

            updateInstallButton()
            window.matchMedia('(display-mode: standalone)').addEventListener('change', updateInstallButton)
        }

    </script>
    {{-- endpwa --}}
</body>
</html>
