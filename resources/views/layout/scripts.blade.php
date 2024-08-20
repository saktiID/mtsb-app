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
    Toast.setTheme(TOAST_THEME.DARK)

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

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    const VAPID_PUBLIC_KEY = "{{ env('VAPID_PUBLIC_KEY') }}"
    const applicationServerKey = urlBase64ToUint8Array(VAPID_PUBLIC_KEY)

    function izinNotif() {
        Notification.requestPermission().then((permission) => {
            if (permission !== 'granted' && permission !== 'denied') {
                notif("Silahkan beri izin untuk menerima notifikasi", true)
            } else if (permission === 'granted') {
                notif("Anda berhasil mengaktifkan izin notifikasi", true)

                navigator.serviceWorker.ready.then((sw) => {

                    sw.pushManager.subscribe({
                        userVisibleOnly: true, //
                        applicationServerKey: applicationServerKey

                    }).then((subscription) => {
                        fetch("{{ route('push-subscribe') }}", {
                            method: "post", //
                            headers: {
                                'Content-Type': 'application/json', //
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }, //
                            body: JSON.stringify(subscription)
                        }).then((response) => {
                            console.log(response);

                        })
                    })
                })

            } else if (permission == 'denied') {
                notif("Anda menolak izin notifikasi, silahkan atur setelan situs di browser Anda atau hapus riwayat penjelajahan", false)
            }
        })
    }

    // check validasi username
    function validateUsername(username) {
        const minLength = 5;
        const maxLength = 25;
        const usernamePattern = /^[a-zA-Z0-9_-]{3,25}$/;

        let indicator = '';

        if (username.length < minLength) {
            console.log(`Username terlalu pendek. Minimal ${minLength} karakter.`);
            indicator = `❌ Username terlalu pendek. Minimal ${minLength} karakter.`;
            return indicator;
        } else if (username.length > maxLength) {
            console.log(`Username terlalu panjang. Maksimal ${maxLength} karakter.`);
            indicator = `❌ Username terlalu panjang. Maksimal ${maxLength} karakter.`;
            return indicator;
        } else if (!usernamePattern.test(username)) {
            console.log("Username tidak valid. Hanya boleh mengandung karakter alfanumerik, garis bawah (_), dan tanda minus (-).");
            indicator = "❌ Username tidak valid. Hanya boleh mengandung karakter alfanumerik, garis bawah (_), dan tanda minus (-).";
            return indicator;
        } else {
            console.log("Username valid");
            indicator = "✔️ Username valid";
            return indicator;
        }
    }

    // event listener username
    $('#username').on('input', function() {
        let username = $(this).val()
        let textIndicator = validateUsername(username)
        $('#indicator').text(textIndicator)
    })

    // eye toggle
    let eyeToggel = document.querySelector('.eye-toggle')
    if (eyeToggel) {
        eyeToggel.addEventListener('click', function(e) {
            let password = document.getElementById('password')
            let password_confirmation = document.getElementById('password-confirmation')

            if (password.type === 'password') {
                password.type = 'text'
                if (password_confirmation) {
                    password_confirmation.type = 'text'
                }
            } else {
                password.type = 'password'
                if (password_confirmation) {
                    password_confirmation.type = 'text'
                }
            }
        })
    }

    // password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;

        // Panjang minimal 8 karakter
        if (password.length >= 5) strength++;

        // Mengandung huruf kecil
        if (/[a-z]/.test(password)) strength++;

        // Mengandung huruf besar
        if (/[A-Z]/.test(password)) strength++;

        // Mengandung angka
        if (/\d/.test(password)) strength++;

        // Mengandung karakter khusus
        if (/[\W_]/.test(password)) strength++;

        // Menilai kekuatan password
        switch (strength) {
            case 0:
            case 1:
                return "Password sangat lemah";
            case 2:
                return "Password lemah";
            case 3:
                return "Password sedang";
            case 4:
                return "Password kuat";
            case 5:
                return "Password sangat kuat";
            default:
                return "Password tidak valid";
        }
    }

    // event listener password
    $('#password').on('input', function() {
        let password = $(this).val()
        let strength = checkPasswordStrength(password)
        $('#password-strength').text(strength)
    })

</script>

@yield('script')
@yield('script-layout')
<!-- END GLOBAL MANDATORY SCRIPTS -->
