@extends('layout.main')
@section('title', 'Teacher Assessment')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Teacher Assessment">
        <div class="form-row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ route('get-foto', '-') }}" width="250px" height="250px" class="rounded bg-success" />
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $kelas }}</td>
                        </tr>
                        <tr>
                            <th width="20%">Nama</th>
                            <td>
                                <select id="siswa_kelas" name="siswa_kelas" class="form-control">
                                    <option value="" selected disabled>-- Pilih siswa --</option>
                                    @foreach ($siswaDalamKelas as $siswa)
                                    <option value="{{ $siswa->user->id }}/{{ $siswa->user->avatar }}/{{ $siswa->siswa->nis }}">{{ $siswa->user->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>
                                <p id="nis">-</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>Semester: {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}</td>
                        </tr>
                        <tr>
                            <th>Assessment type</th>
                            <td>Teacher Assessment</td>
                        </tr>
                        <tr>
                            <th>Bulan</th>
                            <td>
                                <select id="bulan" name="bulan" class="form-control">
                                    <option value="" selected disabled>-- Pilih bulan --</option>
                                    <option>Januari</option>
                                    <option>Februari</option>
                                    <option>Maret</option>
                                    <option>April</option>
                                    <option>Mei</option>
                                    <option>Juni</option>
                                    <option>Juli</option>
                                    <option>Agustus</option>
                                    <option>September</option>
                                    <option>Oktober</option>
                                    <option>November</option>
                                    <option>Desember</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Minggu ke</th>
                            <td>
                                <select id="minggu" name="minggu" class="form-control">
                                    <option value="" selected disabled>-- Pilih minggu --</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Aspect</th>
                                <th class="text-center" width="40%">Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aspects as $item)
                            <tr>
                                <th>{{ $item->aspect }}</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="{{ $item->id }}" value="Always" required>
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="{{ $item->id }}" value="Sometimes" required>
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="{{ $item->id }}" value="Never" required>
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>


                <div class="mb-3">
                    <label for="note">Note:</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </x-card-box>



</div>
@endsection


@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
@endsection

@section('script')
<script>
    $('#siswa_kelas').on('change', function(e) {
        let ex = $('#siswa_kelas').val().split('/')
        let id = ex[0]
        let img = ex[1]
        let nis = ex[2]
        replaceImg(img)
        replaceNis(nis)
    })


    function replaceImg(newImageName) {
        let src = "{{ route('get-foto', ['filename' => 'src_js']) }}".replace('src_js', newImageName)
        $('#foto').attr('src', src)
    }

    function replaceNis(newNis) {
        $('#nis').text(newNis)
    }

</script>
@endsection
