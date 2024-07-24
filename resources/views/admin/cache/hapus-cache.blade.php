@extends('layout.main')
@section('title', 'Hapus Cache')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Hapus Cache">
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
