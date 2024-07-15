@extends('layout.main')
@section('title', 'Data Siswa')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Data Siswa">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-info btn-sm" id="reloadData">Reload data</button>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah siswa</button>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#uploadModal">Upload excel</button>
            <button type="button" class="btn btn-danger btn-sm hapus-beberapa">Hapus beberapa</button>
        </div>
        <div class="table-responsive">
            <table id="data-siswa" class="table table-striped table-hover" style="width:100%">
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
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>NISN</th>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form method="POST" id="formTambah">
                @csrf
                <div class="modal-body">
                    <div class="form-row">

                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="nis">NIS *</label>
                                <input type="text" value="" id="nis" name="nis" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama">Nama *</label>
                                <input type="text" value="" id="nama" name="nama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="username">Username *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">@</span>
                                    </div>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="telp">No. Telp *</label>
                                <input type="text" value="" id="telp" name="telp" class="form-control" required>
                                <small>Contoh: 6281234567890</small>
                            </div>

                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="nisn">NISN *</label>
                                <input type="text" value="" id="nisn" name="nisn" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="gender">Gender *</label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option disabled selected value="">-- Pilih gender --</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" value="" id="email" name="email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="password">Password *</label>
                                <input type="password" value="" id="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
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
                <h5 class="modal-title" id="hapusModalLabel">Hapus siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Akan menghapus data:</p>
                <hr>
                <p id="nama_siswa_akan_dihapus"></p>
                <hr>
                <strong>Konfirmasi hapus data siswa?</strong>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
                <a href="" type="submit" class="btn btn-danger hapusBtnModal loadingTrigger">Hapus</a>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('download-template') }}" class="btn btn-warning btn-sm">Download template</a>
                    </div>
                </div>
                <form action="{{ route('upload-template') }}" method="POST" id="form-upload" enctype="multipart/form-data">
                    <label for="excelFile">Pilih file excel:</label>
                    <input type="file" class="form-control" name="excelFile" id="excelFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                </form>
                <div class="progress br-30 progress-md mt-3">
                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
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
    let nama_siswa_akan_dihapus = document.querySelector('#nama_siswa_akan_dihapus')
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
        prosesAjax(formData, "{{ route('hapus-data-siswa') }}")
    })

    $('#reloadData').on('click', function() {
        $('#data-siswa').DataTable().ajax.reload()
        notif('Berhasil muat ulang data', true)
    })

    $(document).on('click', '.hapus-data', function() {
        nama_siswa_akan_dihapus.innerHTML = $(this).attr('data-nama')
        hapusBtnModal.href = $(this).attr('data-id')
        $('#hapusModal').modal('show')
    })

    $('form#form-upload').on('change', function(e) {
        const excelFile = $('input#excelFile').prop('files')[0]
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}")
        formData.append('excelFile', excelFile)
        $.ajax({
            url: "{{ route('upload-template') }}", //
            type: 'POST', //
            data: formData, //
            contentType: false, //
            processData: false, //
            xhr: function() {
                var xhr = new window.XMLHttpRequest()
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total
                        percentComplete = parseInt(percentComplete * 100)
                        $('.progress-bar').css('width', percentComplete + '%')
                    }
                }, false);
                return xhr;
            }, //
            success: function(res) {
                $('#form-upload')[0].reset()
                $('#uploadModal').modal('hide')
                $('.progress-bar').css('width', 0 + '%')
                if (res.success) {
                    notif(res.message, true)
                } else {
                    notif(res.message, false)
                }
            }, //
            error: function(res) {
                $('#form-upload')[0].reset()
                console.log(res);
            }
        })
    })

    function serrialAssoc(data) {
        let formData = new FormData()
        data.forEach(element => {
            formData.append(element.name, element.value)
        })
        prosesAjax(formData, "{{ route('tambah-data-siswa') }}")
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
            ajax: {
                url: "{{ route('data-siswa') }}", //
            }, //
            columns: [{
                    data: 'check', //
                    className: 'text-center', //
                    orderable: false, //
                    searchbar: false, //
                }, //
                {
                    data: 'avatar', //
                    orderable: false, //
                }, //
                {
                    data: 'nama', //
                }, //
                {
                    data: 'nis', //
                }, //
                {
                    data: 'nisn', //
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
        hapusBtnModal.href = ''
        $('#formTambah')[0].reset()
        $('#data-siswa').DataTable().ajax.reload()
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
            nama_siswa_akan_dihapus.innerHTML = listNama
            listId += checked.dataset.id + ','
            $('#hapusModal').modal('show')
        })
        hapusBtnModal.href = listId
    })

    loadData('#data-siswa')

    // nis tracker
    $('#nis').on('input', function(event) {
        $('#username').val(event.target.value)
    })

</script>
@endsection
