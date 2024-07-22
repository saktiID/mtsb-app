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
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.16.1/echo.iife.min.js"></script>
<script>
    feather.replace()
    const logoutSidebarBtn = document.getElementById("logoutSidebarBtn")
    const container = document.getElementById("container")
    const overlay = document.querySelector(".overlay")
    const html = document.querySelector("html")
    const body = document.querySelector("body")
    const clsInstallBtn = document.getElementById("clsInstallBtn")
    const installWrap = document.getElementById("installWrap")

    logoutSidebarBtn.addEventListener("click", () => {
        $('.overlay').click()
    })

    clsInstallBtn.addEventListener("click", () => {
        installWrap.style.display = 'none'
    })

    let deferredPrompt

    window.addEventListener('beforeinstallprompt', (e) => {
        //  e.preventDefault()
        deferredPrompt = e
    })

    const installButton = document.getElementById('installButton')

    if (installButton) {
        function updateInstallButton() {
            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                installButton.textContent = 'Installed'
                installWrap.style.display = 'none'
            } else {
                installButton.textContent = 'Klik untuk install MTsB APP'
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
                    installButton.textContent = 'Klik untuk install MTsB APP'
                }
                deferredPrompt = null
            }
        })

        updateInstallButton()
        window.matchMedia('(display-mode: standalone)').addEventListener('change', updateInstallButton)
    }

    let err = document.getElementById('aux_error')
    let suc = document.getElementById('aux_success')

</script>

@yield('script')
@yield('script-layout')
<!-- END GLOBAL MANDATORY SCRIPTS -->
