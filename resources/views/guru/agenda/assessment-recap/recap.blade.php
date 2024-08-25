@extends('layout.main')
@section('title', 'Assessment Recap')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Assessment Recap">
        <form class="form-row" id="recap-form">
            <div class="col-lg-12 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $kelas->jenjang_kelas }}-{{ $kelas->bagian_kelas }}</td>
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
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
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

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="recap" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th data-priority="1">Nama</th>
                                <th data-priority="2">Status</th>
                                <th>Evaluator</th>
                                <th>Waktu</th>
                                <th>Exception</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </x-card-box>

</div>
@endsection


@section('style')
<link href="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css" rel="stylesheet">
@endsection


@section('script')
<script src="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>


<script>
    const parameters = {}
    let sendParameters = []
    $('#recap').DataTable({
        paging: false, //
        searching: false, //
    })

    $('#assessment_for').on('change', function() {
        parameters.evaluator = $(this).val()
    })

    $('#bulan').on('change', function() {
        parameters.bulan = $(this).val()
    })

    $('#minggu_ke').on('change', function() {
        parameters.minggu_ke = $(this).val()
    })

    $('#recap-form').on('submit', function(e) {
        e.preventDefault()
        sendParameters.push({
            'kelas_id': "{{ $kelas->id }}", //
            'periode_id': "{{ $periodeAktif->id }}", //
            'evaluator': parameters.evaluator, //
            'bulan': parameters.bulan, //
            'minggu_ke': parameters.minggu_ke
        })
        $('#recap').DataTable().destroy()
        loadData()
        sendParameters = []
    })

    function loadData() {
        $('#recap').DataTable({
            paging: false, //
            searching: false, //
            serverSide: true, //
            processing: true, //
            ajax: {
                url: "{{ route('get-assessment-recap.guru', ['a' => 'params']) }}"
                    .replace('params', JSON.stringify(sendParameters)), //
            }, //
            columns: [{
                    data: 'nama', //
                    className: 'font-weight-bold' //
                }, //
                {
                    data: 'status'
                }, //
                {
                    data: 'evaluator'
                }, //
                {
                    data: 'last_activity'
                }, //
                {
                    data: 'exception'
                }, //

            ], //
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details for ' + data.nama;
                        }
                    }), //
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table table-bordered'
                    })
                }
            }, //
            layout: {
                topStart: {
                    buttons: ['excel', 'pdf', {
                        text: 'Reload', //
                        action: function(e, dt, node, config) {
                            dt.ajax.reload();
                        }
                    }]
                }
            }, //
            order: [
                [0, 'asc'], //
            ], //
        })

        $("html, body").animate({
            scrollTop: $(document).height()
        }, 1000);
    }

</script>
@endsection
