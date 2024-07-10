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
        App.init();
    });

</script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('feather/feather.min.js') }}"></script>
<script>
    feather.replace()
    const logoutSidebarBtn = document.getElementById("logoutSidebarBtn");
    const container = document.getElementById("container");
    const overlay = document.querySelector(".overlay");
    const html = document.querySelector("html");
    const body = document.querySelector("body");

    logoutSidebarBtn.addEventListener("click", () => {
        $('.overlay').click()
    });

</script>

@yield('script')
@yield('script-layout')
<!-- END GLOBAL MANDATORY SCRIPTS -->
