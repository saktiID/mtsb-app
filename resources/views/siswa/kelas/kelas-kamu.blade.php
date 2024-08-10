@extends('layout.main')
@section('title', 'Kelas Kamu')
@section('content')
<div class="row pt-4">
    <x-periode-banner semester="{{ $periodeAktif->semester }}" tahunAjaran="{{ $periodeAktif->tahun_ajaran }}" />

    <x-card-box cardTitle="Kelas Kamu">
        @if(!$kelas['hasKelas'])
        <div class="d-flex align-items-center flex-column">
            <img src="{{ asset('assets/img/not-found.png') }}" width="400px" alt="not found">
            <h6 class="text-center">Yahh, Kamu belum dimasukkan kelas di periode ini 🥲 <br> Tenang! infokan aja ke walas kamu.</h6>
        </div>

        @else

        <div class="row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <div class="d-flex justify-content-center">
                    <div class="avatar avatar-xl ">
                        <div class="rounded alert alert-light-danger p-0 " style="height: 170px; width:170px">
                            <img id="foto" src="{{ route('get-foto', ['filename' => $kelas['data']->avatar]) }}" class="rounded gallery-item" width="170px" height="170px">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <th>ID kelas</th>
                        <td>{{ $kelas['data']->id }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $kelas['data']->jenjang_kelas }}-{{ $kelas['data']->bagian_kelas }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>Semester: {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <th>Wali kelas</th>
                        <td>
                            <p id="nama_walas">{{ $kelas['data']->nama_walas }}</p>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach ($kelas['kelasSiswa'] as $teman)
                        <tr>
                            <td width="20%">
                                <div class="avatar text-center">
                                    <img alt="avatar" src="{{ route('get-foto', $teman->user->avatar) }}" class="rounded bg-success gallery-item" width="50px" height="50px" />
                                </div>
                            </td>
                            <td>{{ $teman->user->nama }} @if($teman->user->nama === Auth::user()->nama) (Akun kamu) @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @endif


    </x-card-box>
</div>
@endsection
