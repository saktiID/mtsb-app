@extends('layout.main')
@section('title', 'Data Periode')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Data Periode">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-info btn-sm" id="reloadData">Reload data</button>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah periode</button>
        </div>
        <div class="table-responsive">
            <table id="data-periode" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Semester</th>
                        <th>Tahun ajaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-box>

</div>
@endsection

@section('modal')
<div class="modal fade" id="tambahModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="formTambah">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="alert alert-light-warning">
                                <span>Detail Periode</span>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="semester">Semester</label>
                                        <select name="semester" id="semester" class="form-control selectpicker" required>
                                            <option value="">-- Semester --</option>
                                            <option value="Ganjil">Ganjil</option>
                                            <option value="Genap">Genap</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-3">
                                        <label for="tahun_pertama">Tahun Pertama</label>
                                        <input type="text" value="" id="tahun_pertama" name="tahun_pertama" class="form-control" placeholder="Contoh: 2023" required>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-3">
                                        <label for="tahun_kedua">Tahun Kedua</label>
                                        <input type="text" value="" id="tahun_kedua" name="tahun_kedua" class="form-control" placeholder="Contoh: 2024" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="alert alert-light-warning">
                                        <span>Ketik ulang kode konfirmasi berikut: <span class="badge badge-dark" id="display_kode_konfirmasi" style="user-select: none;">code</span></span>
                                        <input type="text" name="kunci_kode_konfirmasi" id="kunci_kode_konfirmasi" value="" hidden>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="kode_konfirmasi">Kode Konfirmasi</label>
                                        <input type="text" value="" id="kode_konfirmasi" name="kode_konfirmasi" class="form-control" required>
                                        <small>Huruf kapital berpengaruh.</small>
                                    </div>
                                    <div class="mb-3">
                                        <i class="d-block"><b>** Pastikan membuat periode sesuai kebutuhan.</b></i>
                                        <i class="d-block"><b>** Periode yang sudah dibuat tidak bisa dihapus.</b></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-primary tambah loadingTrigger">Tambah</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script>
    let textLoadingtrigger = ''
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')
    let form = document.querySelector('form')

    $('#tambahModal').on('shown.bs.modal', function() {
        const display_kode_konfirmasi = document.getElementById('display_kode_konfirmasi')
        const kunci_kode_konfirmasi = document.getElementById('kunci_kode_konfirmasi')
        const kode = makeCode(6)

        display_kode_konfirmasi.innerHTML = kode
        kunci_kode_konfirmasi.value = kode
    })

    $('#formTambah').on('submit', function(e) {
        e.preventDefault()
        let data = $(this).serializeArray()
        serrialAssoc(data)
    })

    $('#reloadData').on('click', function() {
        $('#data-periode').DataTable().ajax.reload()
        notif('Berhasil muat ulang data', true)
    })

    $(document).on('click', '.periode_status', function(e) {
        let formData = new FormData
        formData.append('_token', "{{ csrf_token() }}")
        formData.append('id', $(this).attr('data-id'))
        prosesAjax(formData, "{{ route('activate-periode') }}")
    })

    function serrialAssoc(data) {
        let formData = new FormData()
        data.forEach(element => {
            formData.append(element.name, element.value)
        })
        prosesAjax(formData, "{{ route('tambah-data-periode') }}")
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
                url: "{{ route('data-periode') }}", //
            }, //
            columns: [{
                    data: 'id', //
                    className: 'text-center', //
                }, //
                {
                    data: 'semester', //
                    className: 'text-center', //
                }, //
                {
                    data: 'tahun_ajaran', //
                    className: 'text-center', //
                }, //
                {
                    data: 'status', //
                    className: 'text-center', //
                    orderable: false, //
                    searchbar: false, //
                }, //
            ]

        })
    }

    function notif(msg, status) {
        if (status) {
            suc.play()
            Toast.create("Berhasil", msg, TOAST_STATUS.SUCCESS, 10000);
        } else {
            err.play()
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
        $('#formTambah')[0].reset()
        $('#data-periode').DataTable().ajax.reload()
        $('#tambahModal').modal('hide')
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

    function makeCode(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
        }
        return result;
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

    loadData('#data-periode')

</script>
@endsection
