@extends('layout.main')
@section('title', 'Assessment History')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Assessment History">
        <form class="form-row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ route('get-foto', Auth::user()->avatar) }}" width="250px" height="250px" class="rounded bg-success" />
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="20%">Nama</th>
                            <td>{{ Auth::user()->nama }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ Auth::user()->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>
                                <select id="periode" name="periode" class="form-control">
                                    <option value="" selected disabled>-- Pilih periode --</option>
                                    @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->tahun_ajaran }} | {{ $periode->semester }}</option>
                                    @endforeach
                                </select>
                            </td>
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
                                <select id="minggu_ke" name="minggu_ke" class="form-control">
                                    <option value="" selected disabled>-- Pilih minggu --</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Assessment type</th>
                            <td>
                                <select id="assessment_for" name="assessment_for" class="form-control">
                                    <option value="" selected disabled>-- Pilih assessment --</option>
                                    <option value="Teacher">Teacher Assessment</option>
                                    <option value="Parent">Parent Assessment</option>
                                    <option value="Peer">Peer Assessment</option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
<script>
    let PARAMS = []

    $('#print').hide()

    $('form').on('submit', function(e) {
        e.preventDefault()
        PARAMS.push({
            'siswa_user_id': "{{ Auth::user()->id }}", //
            'periode_id': document.getElementById('periode').value, //
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
        // e.preventDefault()
        // window.print()

        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();
        let form_check = document.querySelector('form')

        if (form_check.checkValidity()) {

            PARAMS.push({
                'siswa_user_id': "{{ Auth::user()->id }}", //
                'periode_id': "{{ $periodeAktif->id }}", //
                'bulan': document.getElementById('bulan').value, //
                'minggu_ke': document.getElementById('minggu_ke').value, //
                'evaluator': document.getElementById('assessment_for').value, //
            })

            $.ajax({
                url: "{{ route('print-assessment-history.siswa', ['a' => 'params']) }}"
                    .replace('params', JSON.stringify(PARAMS)), //
                method: 'GET', //
                dataType: 'json', //
                success: function(res) {
                    PARAMS = []
                    // data
                    let p_nama = '{{ Auth::user()->nama }}'
                    let p_kelas = '{{ $kelas->kelas->jenjang_kelas }}-{{ $kelas->kelas->bagian_kelas }}'
                    let p_periode = 'Semester {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}'
                    let p_assessment_for = $('#assessment_for').val()
                    let p_bulan = $('#bulan').val()
                    let p_minggu_ke = $('#minggu_ke').val()
                    let p_evaluator = $('#evaluator').text()
                    let p_note = $('#note').text()

                    // set x position
                    let xPosition = 14
                    let xAfterCol = 45

                    // Menambahkan teks judul
                    doc.setFontSize(18);
                    doc.text('Assessment Records', xPosition, 15);

                    // Menambahkan data
                    doc.setFontSize(10);
                    doc.text('Nama', xPosition, 25);
                    doc.text(': ' + p_nama, xAfterCol, 25);
                    doc.text('Kelas', xPosition, 30);
                    doc.text(': ' + p_kelas, xAfterCol, 30);
                    doc.text('Periode', xPosition, 35);
                    doc.text(': ' + p_periode, xAfterCol, 35);
                    doc.text('Assessment type', xPosition, 40);
                    doc.text(': ' + p_assessment_for, xAfterCol, 40);
                    doc.text('Bulan', xPosition, 45);
                    doc.text(': ' + p_bulan, xAfterCol, 45);
                    doc.text('Minggu ke', xPosition, 50);
                    doc.text(': ' + p_minggu_ke, xAfterCol, 50);
                    doc.text('Evaluator', xPosition, 55);
                    doc.text(': ' + p_evaluator, xAfterCol, 55);

                    // Data untuk tabel invoice
                    const headers = [
                        ['Aspek', 'Answer']
                    ];
                    const data = []

                    res.map(function(content) {
                        data.push([content.aspect, content.answer])
                    })

                    // Menambahkan tabel
                    doc.autoTable({
                        head: headers, //
                        body: data, //
                        startY: 60
                    });

                    // Menambahkan note
                    doc.setFontSize(10)
                    doc.text(`Note: ${p_note}`, xPosition, doc.autoTable.previous.finalY + 10);

                    // Membuat URL blob untuk PDF
                    const blob = doc.output('blob');
                    const url = URL.createObjectURL(blob);

                    // Membuka PDF di tab baru
                    window.open(url, '_blank');
                }, //
                error: function(err) {
                    console.log(err.responseText)
                    PARAMS = []
                }
            })

        } else {
            notif('Isi form terlebih dahulu!', false)
        }

    })

    $('#history').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })

    function prosesAjax() {
        $.ajax({
            url: "{{ route('get-note-history.siswa', ['a' => 'params']) }}"
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
                url: "{{ route('get-assessment-history.siswa', ['a' => 'params']) }}"
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
            ], //
            drawCallback: function(settings) {
                var api = this.api()
                var data = api.rows({
                    page: 'current'
                }).data();

                if (data.length === 0) {
                    $('#print').hide()
                } else {
                    $('#print').show()
                }
            }
        })
    }

    function replaceNote(newNote) {
        $('#note').text(newNote)
    }

    function replaceEvaluator(newEvaluator) {
        $('#evaluator').text(newEvaluator)
    }

</script>


@endsection
