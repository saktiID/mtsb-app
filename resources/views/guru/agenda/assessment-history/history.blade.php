@extends('layout.main')
@section('title', 'Assessment History')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Assessment History">
        <form class="form-row">
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
                                <select id="siswa_kelas" name="siswa_kelas" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih siswa --</option>
                                    @foreach ($siswaDalamKelas as $siswa)
                                    <option value="{{ $siswa->user->id }}/{{ $siswa->user->avatar }}/{{ $siswa->siswa->nis }}/{{ $siswa->user->nama }}">{{ $siswa->user->nama }}</option>
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
                            <td>
                                <select id="assessment_for" name="assessment" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih assessment --</option>
                                    <option value="Teacher">Teacher Assessment</option>
                                    <option value="Parent">Parent Assessment</option>
                                    <option value="Peer">Peer Assessment</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Bulan</th>
                            <td>
                                <select id="bulan" name="bulan" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih bulan --</option>
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
                                <select id="minggu_ke" name="minggu_ke" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih minggu --</option>
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
            <div class="col">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-secondary">Telusuri</button>
                </div>
            </div>
        </form>

        <div class="form-row">
            <div class="table-responsive">
                <table id="history" class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th width="70%">Aspect</th>
                            <th>Answer</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-12">
                <div class="mb-3">

                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <label>Note:</label>
                                <p id="note"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Evaluator:</label>
                                <p id="evaluator"></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <button id="print" class="mb-3 btn btn-warning">Print</button>
                </div>
            </div>

        </div>
    </x-card-box>



</div>
@endsection


@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
<link href="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.css') }}" rel="stylesheet">
@endsection

@section('script')
<script src="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.js') }}"></script>
<script>
    let siswa = []
    let PARAMS = []

    $('#siswa_kelas').on('change', function() {
        siswa = $('#siswa_kelas').val().split('/')
        let img = siswa[1]
        let nis = siswa[2]
        replaceImg(img)
        replaceNis(nis)
    })

    $('form').on('submit', function(e) {
        e.preventDefault()
        PARAMS.push({
            'siswa_user_id': siswa[0], //
            'periode_id': "{{ $periodeAktif->id }}", //
            'bulan': document.getElementById('bulan').value, //
            'minggu_ke': document.getElementById('minggu_ke').value, //
            'evaluator': document.getElementById('assessment_for').value, //
        })

        $('#history').DataTable().destroy()
        loadData()
        prosesAjax()
        replaceEvaluator('-')
        replaceNote('-')
        PARAMS = []
    })

    $('#print').on('click', function(e) {
        e.preventDefault()
        window.print()
    })

    $('#history').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })

    function prosesAjax() {
        $.ajax({
            url: "{{ route('get-note-history.guru', ['a' => 'params']) }}"
                .replace('params', JSON.stringify(PARAMS)), //
            method: 'GET', //
            dataType: 'json', //
            processData: false, //
            contentType: false, //
            success: function(res) {
                replaceNote(res.note)
                replaceEvaluator(res.evaluator)
                $("html, body").animate({
                    scrollTop: $(document).height()
                }, 1000);
            }, //
            error: function(err) {
                console.log(err.responseText)
            }
        });
    }

    function loadData() {
        $('#history').DataTable({
            info: false, // 
            ordering: false, //
            paging: false, //
            searching: false, //
            processing: true, //
            serverSide: true, //
            ajax: {
                url: "{{ route('get-assessment-history.guru', ['a' => 'params']) }}"
                    .replace('params', JSON.stringify(PARAMS)), //
            }, //
            columns: [{
                    data: 'aspect', //
                    className: 'font-weight-bold', //
                }, //
                {
                    data: 'answer', //
                    className: 'text-center'
                }, //
            ]
        })
    }

    function replaceImg(newImageName) {
        let src = "{{ route('get-foto', ['filename' => 'src_js']) }}".replace('src_js', newImageName)
        $('#foto').attr('src', src)
    }

    function replaceNis(newNis) {
        $('#nis').text(newNis)
    }

    function replaceNote(newNote) {
        $('#note').text(newNote)
    }

    function replaceEvaluator(newEvaluator) {
        $('#evaluator').text(newEvaluator)
    }

</script>


@endsection
