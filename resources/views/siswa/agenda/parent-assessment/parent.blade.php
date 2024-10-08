@extends('layout.main')
@section('title', 'Parrent Assessment')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Parent Assessment">
        <div class="form-row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ route('get-foto', Auth::user()->avatar) }}" width="250px" height="250px" class="rounded bg-success" />
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <input type="text" id="siswa" value="{{ Auth::user()->id }}/{{ Auth::user()->avatar }}/{{ Auth::user()->siswa->nis }}/{{ Auth::user()->nama }}" hidden>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $kelas->kelas->jenjang_kelas.'-'.$kelas->kelas->bagian_kelas }}</td>
                        </tr>
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
                            <td>Semester: {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}</td>

                        </tr>
                        <tr>
                            <th>Assessment type</th>
                            <td>Parent</td>
                        </tr>
                        <tr>
                            <th>Bulan</th>
                            <td>
                                <select id="bulan" name="bulan" class="form-control">
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
                                <select id="minggu_ke" name="minggu_ke" class="form-control">
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
        </div>

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
        </form>

    </x-card-box>



</div>
@endsection

@section('modal')
<div class="modal fade" id="storeAssessmentModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="storeAssessmentModalLabel" aria-hidden="true">
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
                <strong>Assessment yang terkirim tidak dapat dihapus atau diubah. <br />Konfirmasi kirim assessment?</strong>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
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
    let siswa = $('#siswa').val().split('/')
    let kirimBtn = document.getElementById('kirim')
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')
    const DATA = {}

    $('#aspects_form').on('submit', function(e) {
        e.preventDefault()

        // cek form
        let bulan = document.getElementById('bulan')
        let mingguKe = document.getElementById('minggu_ke')

        if (!siswa[0] || bulan.value == '' || mingguKe.value == '') {
            notif('Lengkapi data form', false)
        } else {
            let data = $(this).serializeArray()
            let formData = new FormData()
            formData.append('_token', "{{ csrf_token() }}")
            formData.append('kelas_id', "{{ $kelas->kelas->id }}")
            formData.append('periode_id', "{{ $periodeAktif->id }}")
            formData.append('siswa_user_id', siswa[0])
            formData.append('aspects', JSON.stringify(data))
            formData.append('bulan', $('#bulan').val())
            formData.append('minggu_ke', $('#minggu_ke').val())
            formData.append('nama_siswa', "{{ Auth::user()->nama }}")
            formData.append('walas_id', "{{ $kelas->kelas->walas_id }}")

            $('#assessment').html(`Parent assessment: ${siswa[3]}`)
            $('#storeAssessmentModal').modal('show')
            DATA.data = formData
            DATA.route = "{{ route('parent-assessment-store') }}"
        }
    })

    function prosesAjax(data, route) {
        $.ajax({
            url: route, //
            method: 'POST', //
            data: data, //
            dataType: 'json', //
            processData: false, //
            contentType: false, //
            success: function(res) {
                onfinish()
                if (res.success) {
                    notif(res.message, true)
                } else {
                    notif(res.message, false)
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
        span.innerHTML = textLoadingtrigger
        loadingTrigger.forEach(function(loading) {
            if (loading.querySelector('.spinner-border')) {
                loading.replaceChild(span, loading.childNodes[0])
            }
        })
        $('#storeAssessmentModal').modal('hide')
        $('#aspects_form').get(0).reset()
    }

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
        prosesAjax(DATA.data, DATA.route)
    })

</script>

@endsection
