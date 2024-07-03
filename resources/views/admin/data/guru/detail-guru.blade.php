@extends('layout.main')
@section('title', 'Data Guru')
@section('content')
<div class="row pt-4">
    <x-card-box cardTitle="Detail Guru">
        <div class="form-row">
            <div class="col-lg-4 col-sm-12 mb-4">

                @if(Auth::user()->role == 'Admin')
                <a href="{{ route('data-guru') }}">
                    <div class="alert alert-outline-primary">
                        <span>&larr; Kembali ke data guru</span>
                    </div>
                </a>
                @endif

                <label>Profile guru</label>
                <input type="file" accept="image/*" id="avatar_asatidz" name="avatar_asatidz" hidden>
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ asset($user->avatar) }}" width="250px" height="250px" class="rounded bg-success" />
                    </div>
                    <label for="avatar_asatidz" class="btn btn-outline-primary btn-sm">Ubah foto</label>
                </div>

                {{-- modal upload avatar --}}

            </div>

            <div class="col-lg-8 col-sm-12">

                <div class="alert alert-light-warning">
                    <span>Detail guru</span>
                </div>
                <form method="POST" id="data_guru" class="mb-4" data-form="data_guru">
                    @csrf

                    <input type="text" name="id" id="id" value="{{ $user->id }}" hidden>

                    <div class="mb-3">
                        <label for="nama">Nama guru *</label>
                        <input type="text" value="{{ $user->nama }}" id="nama" name="nama" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="email">Email guru</label>
                                <input type="text" value="{{ $user->guru->email }}" id="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="username">Username *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">@</span>
                                    </div>
                                    <input type="text" value="{{ str_replace('@', '', $user->username) }}" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="gender_asatidz">Gender guru *</label>
                                <select id="gender_asatidz" name="gender" class="form-control selectpicker" required>
                                    <option value="">-- Pilih Gender --</option>
                                    <option value="male" {{ ($user->gender == 'male' ? 'selected' : '') }}>Laki-laki</option>
                                    <option value="female" {{ ($user->gender == 'female' ? 'selected' : '') }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="telp">No. Telp *</label>
                                <input type="text" value="{{ $user->guru->telp }}" name="telp" id="telp" class="form-control" required>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="password_asatidz">Password guru</label>
                                <input type="password" value="" id="password_asatidz" name="password" class="form-control">
                                <span><i class="text-small text-warning">(*Kosongkan jika tidak ingin merubah password)</i></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="konfirmasi_password_asatidz">Konfirmasi password guru</label>
                                <input type="password" value="" id="konfirmasi_password_asatidz" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="mb-3 btn btn-primary loadingTrigger simpan" data-form="data_guru">Simpan</button>
                    </div>
                </form>

                <div class="alert alert-light-warning">
                    <span>Tugas guru</span>
                </div>

                <form method="POST" id="data_walas" data-form="data_walas" class="mb-4">
                    @csrf

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="is_walas">Status walas</label>
                                <select name="is_walas" id="is_walas" class="form-control selectpicker">
                                    <option value="0">Tidak</option>
                                    <option value="1">Iya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="kelas_id">Walas kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-control selectpicker">
                                    <option value="0">Tidak</option>
                                    <option value="1">Iya</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="mb-3 btn btn-primary loadingTrigger simpan" data-form="data_walas">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </x-card-box>
</div>
@endsection

@section('script')
<script>
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')

    $('form#data_guru').on('submit', function(e) {
        e.preventDefault()
        let data = $(this).serializeArray()
        serrialAssoc(data)
    })

    function serrialAssoc(data) {
        let formData = new FormData()
        data.forEach(element => {
            formData.append(element.name, element.value)
        })
        prosesAjax(formData, "{{ route('update-data-guru') }}")
    }

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

    function notif(msg, status) {
        if (status) {
            Toast.create("Berhasil", msg, TOAST_STATUS.SUCCESS, 10000);
        } else {
            Toast.create("Gagal", msg, TOAST_STATUS.DANGER, 10000);
        }
    }

    function onfinish() {
        let span = document.createElement('span')
        span.innerHTML = textLoadingtrigger
        loadingTrigger.forEach(function(loading) {
            if (loading.querySelector('.spinner-border')) {
                loading.replaceChild(span, loading.childNodes[0])
            }
        })
    }

    function checkForm(data_form) {
        let formCurrent = document.querySelector(`form[data-form="${data_form}"]`)
        let elements = formCurrent.querySelectorAll('input, select, textarea')
        for (let element of elements) {
            if (element.type != 'password') {
                if (element.value.trim() === '') {
                    return false
                }
            }
        }
        return true
    }

    loadingTrigger.forEach(function(loading) {
        loading.addEventListener('click', function(e) {

            if (loading.classList.contains('simpan')) {

                if (checkForm(loading.dataset.form)) {
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

</script>
@endsection
