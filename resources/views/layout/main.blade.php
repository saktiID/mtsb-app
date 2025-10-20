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
                {{-- <style>
                    #installPWAWrapper {
                        z-index: 99;
                        position: fixed;
                        bottom: 10px;
                        right: 3%;
                        width: 94%;
                    }

                    @media only screen and (min-width: 990px) {
                        #installPWAWrapper {
                            width: 70%;
                        }
                    }

                </style>

                <div id="installPWAWrapper">
                    <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="bi-x" style="color: #000"></i></button>
                        <i data-feather="alert-triangle"></i>
                        <strong>Install</strong> <span class="mr-2"> aplikasi yuk!</span>
                        <button id="installPWA" class="btn btn-primary btn-sm"></button>
                    </div>
                </div> --}}
                {{-- end install app --}}
            </div>

            <div class="lightbox" id="lightbox">
                <span class="lightbox-close" id="lightbox-close">&times;</span>
                <img id="lightbox-img" src="" alt="Lightbox Image" />
            </div>

            @include('layout.footer')
        </div>
        <!--  END CONTENT AREA  -->

        {{-- BEGIN FLOAT BAR --}}
        <div id="floating-bar" class="d-sm-block d-md-none fixed-bottom text-center bg-primary text-white transition">

            <header class="header">
                <nav class="bottom-nav">
                    <div class="bottom-nav-item">
                        @if (Auth::user()->role == 'Admin')
                            <a href="{{ route('beranda-admin') }}" class="bottom-nav-link {{ (request()->is('admin/beranda')) ? 'active' : '' }}">
                                <i data-feather="home" width="20"></i>
                                <span>Home</span>
                            </a>
                        @elseif(Auth::user()->role == 'Guru')
                            <a href="{{ route('beranda-guru') }}" class="bottom-nav-link {{ (request()->is('guru/beranda')) ? 'active' : '' }}">
                                <i data-feather="home" width="20"></i>
                                <span>Beranda</span>
                            </a>
                        @elseif (Auth::user()->role == 'Siswa')
                            <a href="{{ route('beranda-siswa') }}" class="bottom-nav-link {{ (request()->is('siswa/beranda')) ? 'active' : '' }}">
                                <i data-feather="home" width="20"></i>
                                <span>Beranda</span>
                            </a>
                        @endif

                    </div>
                    <div class="bottom-nav-item">
                        <a href="{{ route('profile') }}" class="bottom-nav-link {{ (request()->is('profile')) ? 'active' : '' }}">
                            <i data-feather="user" width="20"></i>
                            <span>Profil</span>
                        </a>
                    </div>
                    <div class="bottom-nav-item dropup">
                        <div class="bottom-nav-link {{ (request()->is('*/agenda/*')) ? 'active' : '' }}" id="agenda-trigger">
                            <i data-feather="paperclip" width="20"></i>
                            <span>Agenda</span>
                        </div>
                        <ul class="dropup-menu" id="agenda-menu">
                            @if (Auth::user()->role == 'Admin')
                            <li><a href="{{ route('assessment-aspect') }}">Assessment Aspect</a></li>
                            <li><a href="{{ route('assessment-history.admin') }}">Assessment History</a></li>
                            <li><a href="{{ route('assessment-recap.admin') }}">Monitoring Assessment</a></li>
                            <hr>
                            @endif
                            @if (Auth::user()->role == 'Guru' || Auth::user()->role == 'Admin')
                                @if ($menuAgenda && $menuAgenda->walas_id == Auth::user()->id)
                                <li><a href="{{ route('teacher-assessment') }}">Teacher Assessment</a></li>
                                <li><a href="{{ route('assessment-history.guru') }}">Assessment History</a></li>
                                <li><a href="{{ route('assessment-recap.guru') }}">Monitoring Assessment</a></li>
                                <li><a href="{{ route('check-peer.guru') }}">Check Peer Assessment</a></li>
                                @else
                                <span>Tidak terdapat menu agenda</span>
                                @endif
                            @endif
                            @if (Auth::user()->role == 'Siswa')
                            <li><a href="{{ route('parent-assessment') }}">Parent Assessment</a></li>
                            <li><a href="{{ route('peer-assessment') }}">Peer Assessment</a></li>
                            <li><a href="{{ route('self-assessment') }}">Self Assessment</a></li>
                            <li><a href="{{ route('assessment-history.siswa') }}">Assessment History</a></li>
                            @endif

                        </ul>

                    </div>
                    <div class="bottom-nav-item">
                        <div class="bottom-nav-link" id="menu-trigger">
                            <i data-feather="menu" width="20"></i>
                            <span>Menu</span>
                        </div>
                    </div>
                </nav>
            </header>
        </div>

        <style>
            #floating-bar.transition {
                transition: transform 0.3s ease;
            }
            #floating-bar.hide {
                transform: translateY(100%);
            }
            #floating-bar.show {
                transform: translateY(0);
            }

            /* nav */
            .header .bottom-nav {
                display: flex;
                justify-content: center;
            }

            .header .bottom-nav .bottom-nav-item {
                font-size: 0.8em;
            }

            .header .bottom-nav .bottom-nav-item .bottom-nav-link {
                display: flex;
                align-items: center;
                flex-direction: column;
                color: #FFF;
                padding: 0.7em 2.5em; 
                width: 4rem;
            }
            .bottom-nav .bottom-nav-item .bottom-nav-link.active {
                background-color: rgb(57, 28, 224);
            }

            .bottom-nav .bottom-nav-item .bottom-nav-link:hover {
                background-color: rgb(57, 28, 224);
            }

            /* dropup */
            .dropup {
                position: relative;
            }

            .dropup-menu {
                position: absolute;
                bottom: 85%;
                background-color: #ffffff;
                color: #333;
                border-top: solid 3px rgb(57, 28, 224);
                list-style: none;
                padding: 0.5rem 0;
                margin: 0;
                display: none;
                z-index: 1000;
                width: 100vw;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .dropup-menu li {
                padding: 0.5rem 1rem;
            }

            .dropup-menu li a {
                text-decoration: none;
                color: inherit;
                display: block;
            }

            .dropup-menu.show {
                display: block;
                opacity: 1;
                transform: translateX(-50%) translateY(-10px);
            }
        </style>

        <script>
            let lastScrollTop = 0;
            const floatingBar = document.getElementById('floating-bar');

            // Inisialisasi posisi awal
            floatingBar.classList.add('show');

            window.addEventListener('scroll', function () {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScroll > lastScrollTop) {
                // Scroll ke bawah → sembunyikan
                floatingBar.classList.remove('show');
                floatingBar.classList.add('hide');

                let menu_drop = document.getElementById('agenda-menu');
                menu_drop.classList.remove('show');
            } else {
                // Scroll ke atas → tampilkan
                floatingBar.classList.remove('hide');
                floatingBar.classList.add('show');
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // untuk iOS bounce
            });

            // menu-trigger
            const menu_trigger = document.getElementById('menu-trigger')
            const menu_toggle = document.querySelector('.toggle-sidebar a')
            menu_trigger.addEventListener('click', () => {
                menu_toggle.click()
            })

            // dropup
            document.addEventListener('DOMContentLoaded', function () {
                const trigger = document.getElementById('agenda-trigger');
                const menu = document.getElementById('agenda-menu');

                trigger.addEventListener('click', function () {
                    menu.classList.toggle('show');
                });

                // Optional: klik di luar untuk menutup
                document.addEventListener('click', function (e) {
                    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            });

        </script>

        {{-- END FLOAT BAR --}}

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
                    installButton.textContent = 'Install'
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
                        installButton.textContent = 'Install'
                    }
                    deferredPrompt = null
                }
            })

            updateInstallButton()
            window.matchMedia('(display-mode: standalone)').addEventListener('change', updateInstallButton)
        }
    </script>
    {{-- endpwa --}}

    {{-- lightbox --}}
    <script>
        // Dapatkan elemen-elemen yang diperlukan
        const galleryItems = document.querySelectorAll(".gallery-item");
        const lightbox = document.getElementById("lightbox");
        const lightboxImg = document.getElementById("lightbox-img");
        const lightboxClose = document.getElementById("lightbox-close");

        // Tambahkan event listener untuk setiap item di galeri
        galleryItems.forEach((item) => {
            item.addEventListener("click", () => {
                // Setel sumber gambar yang diklik ke lightbox
                lightboxImg.src = item.src;
                // Tampilkan lightbox
                lightbox.style.display = "flex";
            });
        });

        // Tambahkan event listener untuk menutup lightbox
        lightboxClose.addEventListener("click", () => {
            lightbox.style.display = "none";
        });

        // Tambahkan event listener untuk menutup lightbox ketika area di luar gambar diklik
        lightbox.addEventListener("click", (e) => {
            if (e.target === lightbox) {
                lightbox.style.display = "none";
            }
        });
    </script>
    {{-- endlightbox --}}
</body>

</html>
