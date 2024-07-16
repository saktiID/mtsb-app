@extends('layout.main')
@section('title', 'Beranda')
@section('content')
<div class="row pt-4">

    <x-periode-banner semester="{{ $periodeAktif->semester }}" tahunAjaran="{{ $periodeAktif->tahun_ajaran }}" />

    <x-card-box cardTitle="Motto" cardLayout="col-lg-6 col-sm-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th width="20%">
                        <h5 class="text-success">C</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Credible</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">H</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">High Quality</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">O</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Objective</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">I</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Integrity</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">C</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Construct Amaliyah Aswaja</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">E</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Excellent</h6>
                    </td>
                </tr>
            </table>
        </div>
    </x-card-box>
    <x-card-box cardTitle="Visi dan Misi" cardLayout="col-lg-6 col-sm-12">
        <h6 class="text-secondary">Visi</h6>
        <p class="text-justify">Terwujudnya madrasah pilihan bagi Masyarakat di Jawa Timur</p>

        <h6 class="text-secondary">Misi</h6>
        <ol class="text-justify">
            <li>Upgrade pendidik dan tenaga kependidikan dalam penguasaan IT sehingga bisa melaksanakan komunikasi aktif dengan networking yang ada di Luar Negeri
            </li>
            <li>Meningkatkan layanan manajemen madrasah berbasis digital yang bisa diakses secara offline maupun online
            </li>
            <li>Mengupgrade kemampuan berbahasa pendidik, tenaga kependidikan dan peserta didik
            </li>
            <li>Pendidik mampu membuktikan keunggulan ajaran aswaja baik melaui offline maupun online</li>
        </ol>
    </x-card-box>

</div>
@endsection
