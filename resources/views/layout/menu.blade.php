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

<x-menu-item menuTitle="Kelas Saya" menuIcon="columns" menuRoute="kelas-saya" menuActive="kelas-saya" />

<x-menu-dropdown menuTitle="Agenda" menuIcon="paperclip" menuParent="agenda" menuActive="guru/agenda/*">
    <x-sub-menu-dropdown menuTitle="Teacher Assessment" menuRoute="teacher-assessment" menuActive="guru/agenda/teacher-assessment" />
    <x-sub-menu-dropdown menuTitle="Assessment History" menuRoute="assessment-history.guru" menuActive="guru/agenda/assessment-history" />
</x-menu-dropdown>

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
                <a href="{{ route('logout') }}" type="submit" class="btn btn-danger">Tetap keluar</a>
            </div>
        </div>
    </div>
</div>
@endsection
