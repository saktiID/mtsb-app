@extends('layout.main')
@section('title', 'Assessment Aspects')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Tambah Aspect">
        <form class="form-row" id="tambah_aspect">
            @csrf
            <div class="col-lg-6 col-sm-12">
                <div class="mb-3">
                    <label for="aspect">Aspect for</label>
                    <select class="form-control selectpicker" name="aspect_for" id="aspect_for" required>
                        <option disabled selected value="">-- Pilih aspect untuk --</option>
                        <option value="teacher">Teacher</option>
                        <option value="parent">Parent</option>
                        <option value="peer">Peer</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="mb-3">
                    <label for="aspect">Aspect</label>
                    <textarea name="aspect" id="aspect" rows="2" class="form-control" required></textarea>
                </div>
            </div>

            <div class="col">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-secondary loadingTrigger tambah">Tambah</button>
                </div>
            </div>

        </form>
    </x-card-box>

    <x-card-box cardTitle="Assessment Aspects (for teacher)" cardLayout="col-lg-6 col-sm-12">
        <div class="table-responsive">
            <table id="aspect_teacher" class="table table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Aspect</th>
                        <th>Status</th>
                        <th><i data-feather="more-horizontal"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-box>

    <x-card-box cardTitle="Assessment Aspects (for parent)" cardLayout="col-lg-6 col-sm-12">
        <div class="table-responsive">
            <table id="aspect_parent" class="table table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Aspect</th>
                        <th>Status</th>
                        <th><i data-feather="more-horizontal"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-box>

    <x-card-box cardTitle="Assessment Aspects (for peer)" cardLayout="col-lg-6 col-sm-12">
        <div class="table-responsive">
            <table id="aspect_peer" class="table table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Aspect</th>
                        <th>Status</th>
                        <th><i data-feather="more-horizontal"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-box>

</div>
@endsection

@section('modal')
<div class="modal fade" id="hapusModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Hapus aspect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="alert alert-warning mb-4" role="alert">
                    <strong>Pastikan aspect tidak pernah dijawab oleh siapapun!</strong>
                </div>
                <p>Akan menghapus data:</p>
                <hr>
                <p id="aspect_for_box"></p>
                <p id="aspect_box"></p>
                <hr>
                <strong>Konfirmasi hapus aspect?</strong>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Batalkan</button>
                <a href="" type="submit" class="btn btn-danger loadingTrigger" id="hapus_aspect">Hapus</a>
            </div>
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
    let textLoadingtrigger
    let loadingTrigger = document.querySelectorAll('.loadingTrigger')
    let aspect_box = document.querySelector('#aspect_box')
    let aspect_for_box = document.querySelector('#aspect_for_box')
    let hapusAspectBtn = document.querySelector('#hapus_aspect')
    let form = document.querySelector('form')

    $('#tambah_aspect').on('submit', function(e) {
        e.preventDefault()
        let data = $(this).serializeArray()
        serrialAssoc(data)
    })

    $('#hapus_aspect').on('click', function(e) {
        e.preventDefault()
        let formData = new FormData
        formData.append('id', $(this).attr('href'))
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "{{ route('hapus-assessment-aspect') }}")
    })

    $(document).on('click', '.aspect-status', function() {
        let formData = new FormData
        formData.append('id', $(this).attr('data-id'))
        formData.append('_token', "{{ csrf_token() }}")
        prosesAjax(formData, "{{ route('switch-aspect-status') }}")
    })

    $(document).on('click', '.hapus-aspect', function() {
        aspect_box.innerHTML = $(this).attr('data-aspect')
        aspect_for_box.innerHTML = `<i>${$(this).attr('data-for')} assessment</i>`
        hapusAspectBtn.href = $(this).attr('data-id')
        $('#hapusModal').modal('show')
    })

    function serrialAssoc(data) {
        let formData = new FormData()
        data.forEach(element => {
            formData.append(element.name, element.value)
        })
        prosesAjax(formData, "{{ route('tambah-assessment-aspect') }}")
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

    function loadData(id, params) {
        $(id).DataTable({
            info: false, // 
            ordering: false, //
            paging: false, //
            searching: false, //

            processing: true, //
            serverSide: true, //
            ajax: {
                url: "{{ route('assessment-aspect', ['a' => 'params']) }}".replace('params', params), //
            }, //
            columns: [{
                    data: 'DT_RowIndex', //
                    name: 'DT_RowIndex', //
                    orderable: false, //
                    searchbar: false, //
                    className: 'text-center'
                }, //
                {
                    data: 'aspect', //
                }, //
                {
                    data: 'aspect_status', //
                    className: 'text-center'
                }, //
                {
                    data: 'more', //
                    className: 'text-center'
                }, //
            ]

        })
    }

    function checkForm() {
        let elements = form.querySelectorAll('select, textarea')
        for (let element of elements) {
            if (element.value.trim() === '') {
                return false
            }
        }
        return true
    }

    function onfinish() {
        let span = document.createElement('span')
        span.innerHTML = textLoadingtrigger
        loadingTrigger.forEach(function(loading) {
            if (loading.querySelector('.spinner-border')) {
                loading.replaceChild(span, loading.childNodes[0])
            }
        })

        $('#tambah_aspect')[0].reset()
        $('#aspect_teacher').DataTable().ajax.reload()
        $('#aspect_parent').DataTable().ajax.reload()
        $('#aspect_peer').DataTable().ajax.reload()
        $('#hapusModal').modal('hide')
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

    loadData('#aspect_teacher', 'teacher')
    loadData('#aspect_parent', 'parent')
    loadData('#aspect_peer', 'peer')

</script>

@endsection
