@extends('layout.main')
@section('title', 'Check Peer Assessment')
@section('content')
    <div class="row pt-4">

        <x-card-box cardTitle="Check Peer Assessment">
            <form class="form-row" id="check-peer-form">
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
                                    Peer Assessment
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
                                        <option>5</option>
                                    </select>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="mb-3 btn btn-secondary" id="btn-telusuri">
                            <span id="spinner-wrapper"
                                class="d-none spinner-border text-white align-self-center loader-sm"></span>
                            <span id="text-search" class="d-block">Telusuri</span>
                        </button>
                    </div>
                </div>


            </form>

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table id="table-result" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th data-priority="1">Evaluator</th>
                                    <th data-priority="2">Assessed</th>
                                    <th data-priority="2">Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-content">
                                <tr>
                                    <td class="text-center" colspan="3">No result</td>
                                </tr>
                            </tbody>
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

    <script>
        $('#check-peer-form').on('submit', (e) => {
            e.preventDefault()

            $('#btn-telusuri').attr('disabled', true)
            $('#spinner-wrapper').removeClass('d-none').addClass('d-block')
            $('#text-search').removeClass('d-block').addClass('d-none')

            let PARAMS = []

            PARAMS.push({
                'periode_id': "{{ $periodeAktif->id }}",
                'kelas_id': "{{ $kelas->id }}",
                'bulan': $('#bulan').val(),
                'minggu_ke': $('#minggu_ke').val()
            })

            $.ajax({
                url: "{{ route('check-peer.guru', ['a' => 'params']) }}".replace('params', JSON
                    .stringify(PARAMS)),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    makeTable(response)

                    $('html, body').animate({
                        scrollTop: $('#table-result').offset().top
                    }, 800);

                    $('#btn-telusuri').attr('disabled', false)
                    $('#spinner-wrapper').removeClass('d-block').addClass('d-none')
                    $('#text-search').removeClass('d-none').addClass('d-block')

                },
                error: function(error) {
                    console.log(error.responseText);

                }
            })

        })

        function makeTable(data) {
            // kosongkan tbody-content
            $('#tbody-content').empty()

            // looping data
            data.forEach(element => {
                // buat element tr
                let tr = document.createElement('tr')

                // buat element td evaluator
                let td_evaluator = document.createElement('td')
                td_evaluator.innerText = element.evaluator
                tr.append(td_evaluator)

                // buat element td assessed
                let td_assessed = document.createElement('td')
                td_assessed.innerText = element.assessed
                tr.append(td_assessed)

                // buat element td status
                const statusClassMap = {
                    complete: 'badge-success',
                    processing: 'badge-info',
                    failed: 'badge-danger'
                };
                const badgeClass = statusClassMap[element.status] || 'badge-dark';
                let td_status = document.createElement('td')
                td_status.innerHTML = `<span class="badge ${badgeClass}">${element.status}</span>`;
                td_status.className = 'text-center'
                tr.append(td_status)

                $('#tbody-content').append(tr)

            })
        }
    </script>

@endsection
