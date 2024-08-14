{{-- beranda --}}
@if(Auth::user()->role == 'Admin')
<x-menu-item menuTitle="Beranda" menuIcon="home" menuRoute="beranda-admin" menuActive="beranda-admin" />
@elseif(Auth::user()->role == 'Guru')
<x-menu-item menuTitle="Beranda" menuIcon="home" menuRoute="beranda-guru" menuActive="beranda-guru" />
@elseif (Auth::user()->role == 'Siswa')
<x-menu-item menuTitle="Beranda" menuIcon="home" menuRoute="beranda-siswa" menuActive="beranda-siswa" />
@endif
{{-- end beranda --}}

{{-- profile --}}
<x-menu-item menuTitle="Profile" menuIcon="user" menuRoute="profile" menuActive="profile" />
{{-- endprofile --}}

{{-- logout --}}
<li class="menu ">
    <a href="#" aria-expanded="false" class="dropdown-toggle" data-toggle="modal" data-target="#logoutModal" id="logoutSidebarBtn">
        <div class="">
            <i data-feather="log-out"></i>
            <span> Keluar</span>
        </div>
    </a>
</li>
{{-- end logout --}}


{{-- admin menu --}}
@if(Auth::user()->role == 'Admin')

<x-menu-heading menuHeadingTitle="ADMINISTRASI" />

<x-menu-dropdown menuTitle="Database" menuIcon="database" menuParent="database" menuActive="admin/database/*">

    <x-sub-menu-dropdown menuTitle="Data Siswa" menuRoute="data-siswa" menuActive="admin/database/data-siswa" />
    <x-sub-menu-dropdown menuTitle="Data Guru" menuRoute="data-guru" menuActive="admin/database/data-guru" />
    <x-sub-menu-dropdown menuTitle="Data Kelas" menuRoute="data-kelas" menuActive="admin/database/data-kelas" />
    <x-sub-menu-dropdown menuTitle="Data Periode" menuRoute="data-periode" menuActive="admin/database/data-periode" />
    <x-sub-menu-dropdown menuTitle="Data Terhapus" menuRoute="data-terhapus" menuActive="admin/database/data-terhapus" />

</x-menu-dropdown>

<x-menu-dropdown menuTitle="Agenda Admin" menuIcon="paperclip" menuParent="agenda-admin" menuActive="admin/agenda/*">

    <x-sub-menu-dropdown menuTitle="Assessment Aspect" menuRoute="assessment-aspect" menuActive="admin/agenda/assessment-aspect" />
    <x-sub-menu-dropdown menuTitle="Assessment History" menuRoute="assessment-history.admin" menuActive="admin/agenda/assessment-history" />

</x-menu-dropdown>

<x-menu-item menuTitle="Optimasi" menuIcon="sliders" menuRoute="optimasi" menuActive="optimasi" />

@endif
{{-- end admin menu --}}



{{-- guru menu --}}
@if (Auth::user()->role == 'Guru' || Auth::user()->role == 'Admin')

<x-menu-heading menuHeadingTitle="TUGAS" />

@if ($menuAgenda && $menuAgenda->walas_id == Auth::user()->id)

<x-menu-item menuTitle="Kelas Saya" menuIcon="columns" menuRoute="kelas-saya" menuActive="kelas-saya" altActive="guru/kelas-saya/*" />

<x-menu-dropdown menuTitle="Agenda" menuIcon="paperclip" menuParent="agenda" menuActive="guru/agenda/*">
    <x-sub-menu-dropdown menuTitle="Teacher Assessment" menuRoute="teacher-assessment" menuActive="guru/agenda/teacher-assessment" />
    <x-sub-menu-dropdown menuTitle="Assessment History" menuRoute="assessment-history.guru" menuActive="guru/agenda/assessment-history" />
</x-menu-dropdown>

@section('script-layout')
<script>
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher', //
        key: "{{ env('PUSHER_APP_KEY') }}", //
        cluster: 'ap1', //
        forceTLS: true, //
    });

    function izinNotif() {
        Notification.requestPermission().then((permission) => {
            if (permission !== 'granted' && permission !== 'denied') {
                notif("Silahkan beri izin untuk menerima notifikasi", true)
            } else if (permission === 'granted') {
                // notif("Anda berhasil mengaktifkan izin notifikasi", true)

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
                const applicationServerKey = urlBase64ToUint8Array("BOFC-dhGA-SYl6aDw2ssPcv6k9qKhM3R30aLYVImA_B3lxiimx62sVfLDxCdhylsJtMrXQeNDkSsYh5dS3VP6y4")

                navigator.serviceWorker.ready.then((sw) => {

                    sw.pushManager.subscribe({
                        userVisibleOnly: true, //
                        applicationServerKey: applicationServerKey

                    }).then((subscription) => {
                        fetch("{{ route('push-subscribe') }}", {
                            method: "POST", //
                            headers: {
                                'Content-Type': 'application/json', //
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }, //
                            body: JSON.stringify(subscription)
                        }).then(console.log("Subscribe ok");)
                    })



                })

            } else if (permission == 'denied') {
                notif("Anda menolak izin notifikasi, silahkan atur setelan situs di browser Anda atau hapus riwayat penjelajahan", false)
            }
        })
    }

    Echo.channel('assessment.' + "{{ Auth::user()->id }}")
        .listen('.App\\Events\\AssessmentSentEvent', function(e) {
            notif(e.body, true)

            if (Notification.permission == 'granted') {
                showNotif()
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission().then(permission => {
                    if (permission == 'granted') {
                        showNotif()
                    }
                })
            }

            function showNotif() {
                navigator.serviceWorker.ready.then((registration) => {
                    registration.showNotification(e.title, {
                        body: e.body, //
                        icon: "{{ asset('logo.png') }}", //
                    })
                })
                navigator.vibrate([200, 100, 200, 100, 400])
            }
        })

</script>
@endsection

@endif

@endif
{{-- end guru menu --}}




{{-- siswa menu --}}
@if (Auth::user()->role == 'Siswa')

<x-menu-heading menuHeadingTitle="MENU" />

<x-menu-item menuTitle="Kelas Kamu" menuIcon="columns" menuRoute="kelas-kamu" menuActive="kelas-kamu" />

<x-menu-dropdown menuTitle="Agenda" menuIcon="paperclip" menuParent="agenda" menuActive="siswa/agenda/*">

    <x-sub-menu-dropdown menuTitle="Parent Assessment" menuRoute="parent-assessment" menuActive="siswa/agenda/parent-assessment" />
    <x-sub-menu-dropdown menuTitle="Peer Assessment" menuRoute="peer-assessment" menuActive="siswa/agenda/peer-assessment" />
    <x-sub-menu-dropdown menuTitle="Assessment History" menuRoute="assessment-history.siswa" menuActive="siswa/agenda/assessment-history" />

</x-menu-dropdown>

@endif
{{-- end siswa menu --}}


@section('modal_logout')
<div class="modal fade" id="logoutModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <div class="modal-body">

                <p>Konfirmasi keluar aplikasi?</p>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
                <a href="{{ route('logout') }}" type="submit" class="btn btn-danger loadingTriggerLogout">Tetap keluar</a>
            </div>
        </div>
    </div>
</div>
<script>
    let loadingTriggerLogout = document.querySelector('.loadingTriggerLogout')
    loadingTriggerLogout.addEventListener('click', function() {
        const spinner = document.createElement('div')
        spinner.classList = "spinner-border text-white align-self-center loader-sm"
        loadingTriggerLogout.replaceChild(spinner, loadingTriggerLogout.childNodes[0])
    })

</script>
@endsection
