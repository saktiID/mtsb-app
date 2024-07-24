@extends('layout.main')
@section('title', 'Data Terhapus')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Data Terhapus">

        <ul class="nav nav-tabs  mb-3" id="lineTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="guru-tab" data-toggle="tab" href="#guru-link" role="tab" aria-selected="true">Data guru </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="siswa-tab" data-toggle="tab" href="#siswa-link" role="tab" aria-selected="false">Data siswa </a>
            </li>
        </ul>

        <div class="tab-content" id="lineTabContent-3">
            <div class="tab-pane fade show active" id="guru-link" role="tabpanel" aria-labelledby="guru-tab">
                <div class="table-responsive">
                    <table id="guru_terhapus" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th data-priority="1">Nama</th>
                                <th>Email</th>
                                <th data-priority="2"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="siswa-link" role="tabpanel" aria-labelledby="siswa-tab">
                <div class="table-responsive">
                    <table id="siswa_terhapus" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th data-priority="1">Nama</th>
                                <th data-priority="2">NIS</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>



    </x-card-box>

</div>
@endsection

@section('modal')
<div class="modal fade" id="hapusModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Hapus permanen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Akan menghapus data:</p>
                <hr>
                <p id="nama_akan_dihapus"></p>
                <hr>
                <strong>Konfirmasi hapus data?</strong>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
                <a href="" type="submit" class="btn btn-danger hapusBtnModal loadingTrigger">Hapus</a>
            </div>

        </div>
    </div>
</div>
@endsection

@section('style')
<link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
<link href="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.css') }}" rel="stylesheet">
@endsection

@section('script')
<script src="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.js') }}"></script>
<script>
    let textLoadingtrigger
    let hapusBtnModal = document.querySelector('.hapusBtnModal')
    let nama_akan_dihapus = document.querySelector('#nama_akan_dihapus')
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')

    $('.hapusBtnModal').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData
        formData.append('id', $(this).attr('href'))
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "{{ route('hapus-permanen') }}")
    })

    $(document).on('click', '.hapus-data', function() {
        nama_akan_dihapus.innerHTML = $(this).attr('data-nama')
        hapusBtnModal.href = $(this).attr('data-id')
        $('#hapusModal').modal('show')
    })

    $(document).on('click', '.pulihkan-data', function() {
        let formData = new FormData
        formData.append('id', $(this).attr('data-id'))
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "{{ route('pulihkan-data') }}")
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
        hapusBtnModal.href = ''
        $('#hapusModal').modal('hide')
        $('#guru_terhapus').DataTable().ajax.reload()
        $('#siswa_terhapus').DataTable().ajax.reload()
    }

    function loadData(id, params) {
        $(id).DataTable({
            responsive: true, //
            processing: true, //
            serverSide: true, //
            ajax: {
                url: "{{ route('data-terhapus', ['a' => 'params']) }}".replace('params', params), //
            }, //
            columns: [{
                    data: 'avatar', //
                    className: 'text-center', //
                    orderable: false, //
                }, //
                {
                    data: 'nama', //
                }, //
                {
                    data: 'unique', //
                }, //
                {
                    data: 'more', //
                    className: 'text-center', //
                    orderable: false, //
                }, //
            ]

        })
    }

    function checkForm() {
        let elements = form.querySelectorAll('input, select, textarea')
        for (let element of elements) {
            if (element.value.trim() === '') {
                return false
            }
        }
        return true
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

    loadData('#guru_terhapus', 'guru')
    loadData('#siswa_terhapus', 'siswa')

</script>

@endsection
