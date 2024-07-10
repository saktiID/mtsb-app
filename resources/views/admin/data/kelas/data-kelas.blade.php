@extends('layout.main')
@section('title', 'Data Kelas')
@section('content')
<div class="row pt-4">

    <x-periode-banner semester="{{ $periode_aktif->semester }}" tahunAjaran="{{ $periode_aktif->tahun_ajaran }}" />

    <x-card-box cardTitle="Data Kelas">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-info btn-sm" id="reloadData">Reload data</button>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah kelas</button>
            <button type="button" class="btn btn-danger btn-sm hapus-beberapa">Hapus beberapa</button>
        </div>
        <div class="table-responsive">
            <table id="data-kelas" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>
                            <div class="checkbox-wrapper-31">
                                <input type="checkbox" id="check_all_item" />
                                <svg viewBox="0 0 35.6 35.6">
                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                </svg>
                            </div>
                        </th>
                        <th>Walas</th>
                        <th>Jenjang kelas</th>
                        <th>Rombel kelas</th>
                        <th><i data-feather="more-horizontal"></i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>


    </x-card-box>

</div>
@endsection

@section('modal')
<div class="modal fade" id="tambahModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <form id="formTambah">
                <div class="modal-body">
                    @csrf
                    <input type="text" name="periode_id" value="{{ $periode_aktif->id }}" hidden>
                    <div class="form-row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="alert alert-light-warning">
                                <span>Detail Kelas | Periode: Semester {{ $periode_aktif->semester}} {{ $periode_aktif->tahun_ajaran }} </span>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="jenjang_kelas">Jenjang</label>
                                        <select name="jenjang_kelas" id="jenjang_kelas" class="form-control selectpicker" required>
                                            <option value="">-- Pilih Jenjang --</option>
                                            @for($i = 1; $i < 13; $i++) <option value="{{ $i }}">Jenjang - {{ $i }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="bagian_kelas">Bagian Kelas</label>
                                        <input type="text" value="" id="bagian_kelas" name="bagian_kelas" class="form-control" placeholder="contoh: A" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary tambah loadingTrigger">Tambah</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="hapusModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Hapus kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Akan menghapus data:</p>
                <hr>
                <p id="nama_kelas_akan_dihapus"></p>
                <hr>
                <strong>Konfirmasi hapus data kelas?</strong>

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
<link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script>
    let check_all_item = document.querySelector('#check_all_item')
    let hapus_beberapa = document.querySelector('.hapus-beberapa')
    let hapusBtnModal = document.querySelector('.hapusBtnModal')
    let nama_kelas_akan_dihapus = document.querySelector('#nama_kelas_akan_dihapus')
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')
    let form = document.querySelector('form')

    $('#formTambah').on('submit', function(e) {
        e.preventDefault()
        let data = $(this).serializeArray()
        serrialAssoc(data)
    })

    $('.hapusBtnModal').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData
        formData.append('id', $(this).attr('href'))
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "{{ route('hapus-data-kelas') }}")
    })

    $('#reloadData').on('click', function() {
        $('#data-kelas').DataTable().ajax.reload()
        notif('Berhasil muat ulang data', true)
    })

    $(document).on('click', '.hapus-data', function() {
        nama_kelas_akan_dihapus.innerHTML = $(this).attr('data-nama')
        hapusBtnModal.href = $(this).attr('data-id')
        $('#hapusModal').modal('show')
    })

    function serrialAssoc(data) {
        let formData = new FormData()
        data.forEach(element => {
            formData.append(element.name, element.value)
        })
        prosesAjax(formData, "{{ route('tambah-data-kelas') }}")
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

    function loadData(id) {
        $(id).DataTable({
            processing: true, //
            serverSide: true, //
            order: [
                [2, 'asc']
            ], //
            ajax: {
                url: "{{ route('data-kelas') }}", //
            }, //
            columns: [{
                    data: 'check', //
                    className: 'text-center', //
                    orderable: false, //
                    searchbar: false, //
                }, //
                {
                    data: 'walas', //
                    orderable: false, //
                }, //
                {
                    data: 'jenjang', //
                    className: 'text-center', //
                }, //
                {
                    data: 'bagian', //
                    className: 'text-center', //
                }, //
                {
                    data: 'more', //
                    className: 'text-center', //
                    orderable: false, //
                    searchbar: false, //
                }, //
            ]

        })
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
        hapusBtnModal.href = ''
        $('#formTambah')[0].reset()
        $('#data-kelas').DataTable().ajax.reload()
        $('#tambahModal').modal('hide')
        $('#hapusModal').modal('hide')
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

    check_all_item.addEventListener('change', function() {
        let check_items = document.querySelectorAll('.check_item[type="checkbox"]')
        check_items.forEach(function(item) {
            item.checked = check_all_item.checked
        })
    })

    hapus_beberapa.addEventListener('click', function() {
        let listNama = ''
        let listId = ''
        let checkeds = document.querySelectorAll('.check_item[type="checkbox"]:checked')
        if (checkeds.length === 0) {
            notif("Pilih item yang akan dihapus!", false)
        }
        checkeds.forEach(function(checked) {
            listNama += checked.dataset.nama + '<br/>'
            nama_kelas_akan_dihapus.innerHTML = listNama
            listId += checked.dataset.id + ','
            $('#hapusModal').modal('show')
        })
        hapusBtnModal.href = listId
    })

    loadData('#data-kelas')

</script>
@endsection
