<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="/">
                    <img src="{{ asset('logo.png') }}" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="/" class="nav-link"> MTSB </a>
            </li>
            <li class="nav-item toggle-sidebar">
                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                    <i data-feather="list"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row navbar-dropdown ml-auto">

            @if(Auth::user()->role == "Admin" || Auth::user()->role == "Guru")
            <li class="nav-item dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i><span class="badge badge-success"></span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    <div class="notification-scroll">
                        <div class="dropdown-item">
                            <div class="media">
                                <div class="media-body">
                                    <div class="data-info d-flex">
                                        <h6 class="">Terima notifikasi</h6>
                                        <span class="btn btn-info btn-sm" onclick="mintaIzinNotif()">Aktifkan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endif

            <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="settings"></i>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <img src="{{ route('get-foto', ['filename' => Auth::user()->avatar]) }}" class="img-fluid mr-2" alt="avatar">
                            <div class="media-body">
                                <h5>{{ Auth::user()->nama }}</h5>
                                <p>{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <a href="{{ route('profile') }}">
                            <i data-feather="user"></i> <span>Profile</span>
                        </a>
                    </div>
                    <div class="dropdown-item">
                        <a href="#" data-toggle="modal" data-target="#logoutModal">
                            <i data-feather="log-out"></i> <span>Keluar</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </header>
    <div id="internetStatus" style="height: 30px" class="text-center text-white pt-1">
    </div>
</div>
