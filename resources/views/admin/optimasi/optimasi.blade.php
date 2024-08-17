@extends('layout.main')
@section('title', 'Optimasi')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Optimasi">
        <label>Bersihkan data cache: <br>
            <small>Menghapus cache untuk memuat ulang data sementara</small>
        </label>
        <br />
        <a href="" id="data-cache" class="btn btn-danger btn-sm loadingTrigger">Bersihkan</a>
        <hr>
        <label class="mb-3">Bersihkan data session: <br>
            <small>Menghapus session akan menyebabkan semua user harus login kembali</small>
        </label>
        <br />
        <a href="" id="data-session" class="btn btn-danger btn-sm loadingTrigger">Bersihkan</a>
        <hr>
        <label class="mb-3">Bersihkan view cache: <br>
            <small>Menghapus source cache view untuk melihat perubahan interface</small>
        </label>
        <br />
        <a href="" id="hapus-view-cache" class="btn btn-danger btn-sm loadingTrigger">Bersihkan</a>
        <hr>
        <label class="mb-3">Membuat cache untuk view: <br>
            <small>Men-generate source cache untuk view agar load view lebih cepat</small>
        </label>
        <br />
        <a href="" id="view-cache" class="btn btn-warning btn-sm loadingTrigger">Buat cache</a>
        <hr>
        <label class="mb-3">Bersihkan config cache: <br>
            <small>Menghapus source cache config untuk memperbarui konfigurasi tersimpan</small>
        </label>
        <br />
        <a href="" id="hapus-config-cache" class="btn btn-danger btn-sm loadingTrigger">Bersihkan</a>
        <hr>
        <label class="mb-3">Membuat cache untuk config: <br>
            <small>Men-generate source cache untuk config agar load konfigurasi lebih cepat</small>
        </label>
        <br />
        <a href="" id="config-cache" class="btn btn-warning btn-sm loadingTrigger">Buat cache</a>
        <hr>
    </x-card-box>

</div>
@endsection

@section('script')
<script>
    let textLoadingtrigger
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')

    $('#data-cache').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "hapus-data-cache")
    })

    $('#data-session').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "hapus-data-session")
    })

    $('#hapus-view-cache').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "hapus-view-cache")
    })

    $('#view-cache').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "view-cache")
    })

    $('#config-cache').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "config-cache")
    })

    $('#hapus-config-cache').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "hapus-config-cache")
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

</script>
@endsection
