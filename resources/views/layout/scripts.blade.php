<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-toaster/bootsrap-toaster.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        App.init()
    })

</script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('feather/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/internet-status.js') }}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.16.1/echo.iife.min.js"></script>
<script>
    feather.replace()
    const logoutSidebarBtn = document.getElementById("logoutSidebarBtn")
    const container = document.getElementById("container")
    const overlay = document.querySelector(".overlay")
    const html = document.querySelector("html")
    const body = document.querySelector("body")

    logoutSidebarBtn.addEventListener("click", () => {
        $('.overlay').click()
    })

    let err = document.getElementById('aux_error')
    let suc = document.getElementById('aux_success')

    Toast.enableTimers(TOAST_TIMERS.COUNTDOWN)

    function notif(msg, status) {
        if (status) {
            suc.play()
            Toast.create({
                title: "Berhasil", //
                message: msg, //
                status: TOAST_STATUS.SUCCESS, //
                timeout: 10000, //
            })

        } else {
            err.play()
            Toast.create({
                title: "Gagal", //
                message: msg, //
                status: TOAST_STATUS.DANGER, //
                timeout: 10000, //
            })
        }
    }

</script>

@yield('script')
@yield('script-layout')
<!-- END GLOBAL MANDATORY SCRIPTS -->
