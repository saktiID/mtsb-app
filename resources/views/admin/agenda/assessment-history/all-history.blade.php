@extends('layout.main')
@section('title', 'Assessment History')
@section('content')
    <div class="row pt-4">

        <x-card-box cardTitle="Assessment History">
            <form class="form-row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Kelas</th>
                                <td>
                                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                                        <option value="">-- Pilih kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option
                                                value="{{ $k->id }}/{{ $k->jenjang_kelas }}-{{ $k->bagian_kelas }}">
                                                {{ $k->jenjang_kelas }}-{{ $k->bagian_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                        <option value="Self">Self Assessment</option>
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
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="mb-3 btn btn-secondary">Telusuri</button>
                    </div>
                </div>
            </form>
        </x-card-box>

        <x-card-box cardTitle="Result">

            <div id="print-area">

                <table class="mb-3 table table-bordered" style="width: 100%">
                    <tr>
                        <td class="text-bold">Kelas</td>
                        <td id="nama-kelas-wrapper"></td>
                    </tr>
                    <tr>
                        <td class="text-bold">Periode</td>
                        <td>Semester: {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Assessment Type</td>
                        <td id="assessment-type-wrapper"></td>
                    </tr>
                    <tr>
                        <td class="text-bold">Bulan</td>
                        <td id="bulan-wrapper"></td>
                    </tr>
                    <tr>
                        <td class="text-bold">Minggu ke</td>
                        <td id="minggu-ke-wrapper"></td>
                    </tr>
                </table>

                <p>Assessment Aspects:</p>
                <ol id="aspects-wrapper">
                    <li>No result</li>
                </ol>
                <div class="table-responsive" id="table-result">
                    <table class="table table-striped" style="width:100%">
                        <thead>
                            <tr id="tr-header"></tr>
                        </thead>
                        <tbody id="tbody-content">
                            <tr>
                                <td class="text-center">No result</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p>Notice:</p>
                <ul>
                    <li>A: Always</li>
                    <li>S: Sometimes</li>
                    <li>N: Never</li>
                </ul>
            </div>

            <button id="print-button" class="mb-3 btn btn-success">Print</button>
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

    {{-- page logic --}}
    <script>
        let PARAMS = []

        $('form').on('submit', function(e) {
            e.preventDefault()

            let kelas_input = $('#kelas_id').val().split('/')

            PARAMS.push({
                'kelas_id': kelas_input[0], //
                'periode_id': "{{ $periodeAktif->id }}", //
                'bulan': document.getElementById('bulan').value, //
                'minggu_ke': document.getElementById('minggu_ke').value, //
                'evaluator': document.getElementById('assessment_for').value, //
            })

            $('#nama-kelas-wrapper').text(kelas_input[1])
            $('#assessment-type-wrapper').text(`${document.getElementById('assessment_for').value} Assessment`)
            $('#bulan-wrapper').text(document.getElementById('bulan').value)
            $('#minggu-ke-wrapper').text(document.getElementById('minggu_ke').value)
            load()
        })

        function load() {
            $.ajax({
                url: "{{ route('get-assessment-history.guru', ['a' => 'params']) }}".replace('params', JSON
                    .stringify(PARAMS)), //, // Sesuaikan dengan route kamu
                type: "GET", // atau "POST" sesuai kebutuhan
                dataType: "json", // opsional, tergantung respons
                success: function(response) {
                    console.log("Data dari server:", response);
                    makeAspectsList(response.aspects);
                    makeTable(response.aspects, response.table);
                    $('html, body').animate({
                        scrollTop: $('#table-result').offset().top
                    }, 800);

                    PARAMS = []
                },
                error: function(xhr) {
                    console.error("Terjadi kesalahan:", xhr.responseText);
                }
            });
        }

        function makeAspectsList(aspects) {
            // kosongkan aspects
            $('#aspects-wrapper').empty()

            // looping aspect
            aspects.forEach(element => {

                // buat element li
                let li = document.createElement('li')
                li.innerHTML = `${element.aspect}`

                // ambil element aspects wrapper dan isi child
                $('#aspects-wrapper').append(li)
            });
        }

        function makeTable(aspects, table) {
            // kosongkan tr-header
            $('#tr-header').empty()

            // isi tr-header
            let nama_header = document.createElement('th')
            nama_header.innerText = "Nama"
            $('#tr-header').append(nama_header)

            // looping aspect header
            aspects.forEach((element, index) => {
                // buat element th
                let th_content = document.createElement('th')

                // isi element th
                th_content.innerHTML = `${index + 1}`

                // isi child tr-header
                $('#tr-header').append(th_content)
            })

            // kosongkan tbody-content
            $('#tbody-content').empty()

            // looping content data tabel
            table.forEach(element => {
                // buat element tr
                let tr = document.createElement('tr')

                // buat element td nama
                let td = document.createElement('td')
                td.innerText = element.nama_siswa
                tr.append(td)

                element.aspect_answer.forEach(answer => {
                    let td_answer = document.createElement('td')
                    td_answer.innerHTML = `${answer.answer.charAt(0)}`
                    tr.append(td_answer)
                })


                $('#tbody-content').append(tr)
            })

        }
    </script>

    {{-- print logic --}}
    <script>
        document.getElementById('print-button').addEventListener('click', function() {
            let printContents = document.getElementById('print-area').innerHTML;
            let originalContents = document.body.innerHTML;

            let printWindow = window.open('', '', 'width=' + screen.width + ',height=' + screen.height +
                ',top=0,left=0');
            printWindow.document.write('<html><head><title>&nbsp;</title>');
            printWindow.document.write(
                '<style>@media print {@page {size: A4;margin: 0;} body {margin: 0;padding: 20px; }table {border-collapse: collapse;width: 100%;}th, td {border: 1px solid black;padding: 4px;}}</style>'
            );
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();

            printWindow.print();
            printWindow.close();
        });
    </script>

@endsection
