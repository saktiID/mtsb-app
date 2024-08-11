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
                <input type="file" accept="image/*" id="avatar_upload" name="avatar_upload" hidden>
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ route('get-foto', $user->avatar) }}" width="250px" height="250px" class="rounded bg-success gallery-item" />
                    </div>
                    <label for="avatar_upload" class="btn btn-outline-primary btn-sm">Ubah foto</label>
                </div>

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
                                <input type="text" value="{{ $user->guru->email }}" id="email" name="email" class="form-control" required>
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

            </div>

        </div>
    </x-card-box>
</div>
@endsection

@section('modal')
<div class="modal fade" id="uploadImgModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadImgModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImgModalLabel">Upload foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <img src="" id="previewImg" alt="preview" height="450px">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
                <button type="submit" class="btn btn-primary loadingTrigger" id="crop">Upload</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('cropperjs-main/dist/cropper.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('cropperjs-main/dist/cropper.min.js') }}"></script>

<script>
    let textLoadingtrigger
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

    // cropper
    const avatar = document.getElementById('previewImg')
    const cropper = new Cropper(avatar, {
        aspectRatio: 1, // Sesuaikan dengan rasio aspek yang Anda inginkan
        minContainerWidth: 350, // 
        minContainerHeight: 350, //
    })

    // Aktifkan pemilihan gambar saat file dipilih
    let inputImage = document.getElementById('avatar_upload');
    inputImage.addEventListener('change', function() {
        $("#uploadImgModal").modal()
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                cropper.replace(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Upload foto
    function upload() {
        cropper.getCroppedCanvas({
            width: 90, //
            height: 90, //
        });
        cropper.getCroppedCanvas().toBlob((blob) => {
            const formData = new FormData();

            // Pass the image file name as the third parameter if necessary.
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', '{{ Auth::user()->id }}');
            formData.append('avatar_upload', blob, '.png');

            // Use `jQuery.ajax` method for example
            $.ajax({
                url: "{{ route('foto-profile') }}", //
                method: 'POST', //
                data: formData, //
                processData: false, //
                contentType: false, //
                success: function(res) {
                    if (res.success) {
                        onfinish()
                        notif(res.message, true)
                        replaceImg(res.newImage)
                    } else {
                        notif(res.message, false)
                    }
                }, //
                error: function(err) {
                    onfinish()
                    notif(res.message, false)
                    console.log(err.responseText);
                }
            });
        });
    }

    // Trigger close modal upload
    $('#uploadImgModal').on('hidden.bs.modal', () => {
        cropper.destroy()
        inputImage.value = ''
    })

    // replace image with new image
    function replaceImg(newImageName) {
        console.log(newImageName);
        let src = "{{ route('get-foto', ['filename' => 'src_js']) }}".replace('src_js', newImageName)
        $('#foto').attr('src', src)
        $("#uploadImgModal").modal('hide')
    }

    // click upload button
    $('#crop').parent().on('click', () => {
        upload()
    })

</script>
@endsection
