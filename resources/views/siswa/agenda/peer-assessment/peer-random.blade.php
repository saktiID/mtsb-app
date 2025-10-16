@extends('layout.main')
@section('title', 'Peer Assessment')
@section('content')
    <div class="row pt-4">
        <x-card-box cardTitle="Peer Assessment">
            <form class="form-row" id="form-pilih-teman">

                <div class="col-lg-7 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $kelas->kelas->jenjang_kelas . '-' . $kelas->kelas->bagian_kelas }}</td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td>Semester: {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                                <th>Assessment type</th>
                                <td>Peer Assessment</td>
                            </tr>
                            <tr>
                                <th>Bulan</th>
                                <td>
                                    <select id="bulan" name="bulan" class="form-control" required>
                                        <option value="" selected disabled>-- Pilih bulan --</option>
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

                <div class="col-lg-5 col-sm-12 mb-4">
                    <div class="text-center">
                        <div class="avatar avatar-xl mb-3 d-flex justify-content-center">
                            <img alt="foto" id="foto" src="{{ route('get-foto', '-') }}" width="170px"
                                height="170px" class="rounded bg-success" />
                            <div id="loading-random"
                                class="border rounded rounded-2 bg-white d-none justify-content-center align-items-center"
                                style="width: 170px; height:170px; position:absolute; z-index:9;">
                                <div class="spinner-border text-secondary loader-xl"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 id="nama-teman">[nama teman]</h6>
                        </div>
                        <button type="submit" id="btn-pilih-teman" class="btn btn-primary">Pilih teman secara acak</button>
                    </div>
                </div>
            </form>
        </x-card-box>

        <x-card-box cardTitle="Form">
            <form class="form-row" id="aspects_form">
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
                                                    <input type="radio" class="new-control-input"
                                                        name="{{ $item->id }}" value="Always" required>
                                                    <span class="new-control-indicator"></span>Always
                                                </label>
                                                <label class="new-control new-radio radio-warning">
                                                    <input type="radio" class="new-control-input"
                                                        name="{{ $item->id }}" value="Sometimes" required>
                                                    <span class="new-control-indicator"></span>Sometimes
                                                </label>
                                                <label class="new-control new-radio radio-danger">
                                                    <input type="radio" class="new-control-input"
                                                        name="{{ $item->id }}" value="Never" required>
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
                        <button type="submit" class="mb-3 btn btn-primary" id="btn-answer" disabled="true">Kirim</button>
                    </div>
                </div>
            </form>
        </x-card-box>

    </div>
@endsection

@section('modal')
    <div class="modal fade" id="storeAssessmentModal" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="storeAssessmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="storeAssessmentModalLabel">Kirimkan assessment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Akan mengirimkan data:</p>
                    <hr>
                    <p id="assessment"></p>
                    <hr>
                    <strong>Assessment yang terkirim tidak dapat dihapus atau diubah. <br />Konfirmasi kirim
                        assessment?</strong>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i
                            class="flaticon-cancel-12"></i>Batalkan</button>
                    <button type="submit" id="kirim" class="btn btn-primary loadingTrigger">Kirim</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
@endsection

@section('script')
    <script>
        let loadingTrigger = document.querySelectorAll('.loadingTrigger')
        let kirimBtn = document.getElementById('kirim')
        let formData = new FormData();
        let textLoadingtrigger;

        $('#form-pilih-teman').on('submit', (e) => {
            e.preventDefault()
            const teman = @json($siswaDalamKelas);
            $('#btn-pilih-teman').attr('disabled', true)
            $('#loading-random').removeClass('d-none').addClass('d-flex');

            let intervalRandom

            intervalRandom = setInterval(() => {
                const randomNumber = Math.floor(Math.random() * teman.length);
                $('#nama-teman').text(teman[randomNumber].nama)
            }, 150);


            formData.append('_token', "{{ csrf_token() }}")
            formData.append('kelas_id', "{{ $kelas->kelas->id }}")
            formData.append('periode_id', "{{ $periodeAktif->id }}")
            formData.append('siswa_user_id', "{{ Auth::user()->id }}")
            formData.append('bulan', $('#bulan').val())
            formData.append('minggu_ke', $('#minggu_ke').val())
            formData.append('walas_id', "{{ $walas_id }}")

            $.ajax({
                url: "{{ route('peer-assessment-random') }}", //
                method: 'POST', //
                data: formData, //
                dataType: 'json', //
                processData: false, //
                contentType: false, //
                success: function(response) {
                    let link = "{{ route('get-foto', 'avatar') }}".replace('avatar',
                        response.avatar)
                    $('#foto').attr('src', link)

                    // append form
                    formData.append('nama_siswa', response.nama)

                    setTimeout(() => {
                        clearInterval(intervalRandom)
                        $('#loading-random').removeClass('d-flex').addClass('d-none');
                        $('#nama-teman').text(response.nama)
                    }, 1000);


                    // submit answer aspect
                    $('#btn-answer').attr('disabled', false)
                    $('#aspects_form').on('submit', function(e) {
                        e.preventDefault()

                        // append form
                        formData.append('nama_siswa', response.nama)
                        formData.append('aspects', JSON.stringify($(this).serializeArray()))

                        $('#assessment').html(`Peer assessment: ${response.nama}`)
                        $('#storeAssessmentModal').modal('show')

                    })

                },
                error: function(xhr) {
                    console.error("Terjadi kesalahan:", xhr.responseText);
                }
            });

            loadingTrigger.forEach(function(loading) {
                loading.addEventListener('click', function(e) {
                    if (loading.classList.contains('tambah')) {
                        if (checkForm()) {
                            loadingSpin()
                        }
                    } else {
                        loadingSpin()
                    }

                    function loadingSpin() {
                        textLoadingtrigger = loading.innerHTML
                        const spinner = document.createElement('div')
                        spinner.classList = "spinner-border text-white align-self-center loader-sm"
                        loading.replaceChild(spinner, loading.childNodes[0])
                    }

                })
            })

            kirimBtn.addEventListener('click', function() {
                prosesAjax()
            })

            function prosesAjax() {

                $.ajax({
                    url: "{{ route('peer-assessment-store') }}", //
                    method: 'POST', //
                    data: formData, //
                    dataType: 'json', //
                    processData: false, //
                    contentType: false, //
                    success: function(res) {
                        onfinish()
                        if (res.success) {
                            notif(res.message, true)
                            setTimeout(() => {
                                location.reload()
                            }, 3000)

                        } else {
                            notif(res.message, false)
                            setTimeout(() => {
                                location.reload()
                            }, 3000)
                        }
                    }, //
                    error: function(err) {
                        onfinish()
                        console.log(err.responseText)
                        notif(err.responseText, false)
                    }
                });
            }

            function onfinish() {
                let span = document.createElement('span')
                span.innerHTML = "Kirim"

                loadingTrigger.forEach(function(loading) {
                    if (loading.querySelector('.spinner-border')) {
                        loading.replaceChild(span, loading.childNodes[0])
                    }
                })

                $('#loading-random').removeClass('d-flex').addClass('d-none');
                $('#nama-teman').text("[nama teman]")
                $('#btn-pilih-teman').attr('disabled', false)
                $('#btn-answer').attr('disabled', true)
                $('#foto').attr('src', "{{ route('get-foto', '-') }}")
                $('#storeAssessmentModal').modal('hide')
                $('#aspects_form').get(0).reset()
            }


        })

        $('#bulan, #minggu_ke').on('change', onInputChange)

        function onInputChange() {
            $('#btn-answer').attr('disabled', true)
            $('#btn-pilih-teman').attr('disabled', false)
            $('#nama-teman').text('[nama teman]')
            $('#foto').attr('src', "{{ route('get-foto', '-') }}")
        }
    </script>

@endsection
