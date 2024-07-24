@extends('layout.main')
@section('title', 'Assessment Aspects')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Assessment Aspects">
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

        <ul class="nav nav-tabs  mb-3" id="lineTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="teacher-aspect-tab" data-toggle="tab" href="#teacher-link" role="tab" aria-selected="true">Aspect fot teacher </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="parent-aspect-tab" data-toggle="tab" href="#parent-link" role="tab" aria-selected="false">Aspect for parent </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="peer-aspect-tab" data-toggle="tab" href="#peer-link" role="tab" aria-selected="false">Aspect fot peer </a>
            </li>
        </ul>

        <div class="tab-content" id="lineTabContent-3">
            <div class="tab-pane fade show active" id="teacher-link" role="tabpanel" aria-labelledby="teacher-aspect-tab">
                <div class="table-responsive">
                    <table id="aspect_teacher" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th data-priority="1">Aspect</th>
                                <th data-priority="2">Status</th>
                                <th><i data-feather="more-horizontal"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="parent-link" role="tabpanel" aria-labelledby="parent-aspect-tab">
                <div class="table-responsive">
                    <table id="aspect_parent" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th data-priority="1">Aspect</th>
                                <th data-priority="2">Status</th>
                                <th><i data-feather="more-horizontal"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="peer-link" role="tabpanel" aria-labelledby="peer-aspect-tab">
                <div class="table-responsive">
                    <table id="aspect_peer" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th data-priority="1">Aspect</th>
                                <th data-priority="2">Status</th>
                                <th><i data-feather="more-horizontal"></i></th>
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
<link href="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.css') }}" rel="stylesheet">
@endsection

@section('script')
<script src="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.js') }}"></script>
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

    function loadData(id, params) {
        $(id).DataTable({
            responsive: true, //
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

        $('textarea#aspect').val('')
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
