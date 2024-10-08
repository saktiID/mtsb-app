@extends('layout.main')
@section('title', 'Kelas Saya')
@section('content')
<div class="row pt-4">
    <x-card-box cardTitle="Kelas Saya">
        <div class="row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <label for="walas_id">Wali kelas</label>
                <div class="d-flex justify-content-center">
                    <div class="avatar avatar-xl ">
                        <div class="rounded alert alert-light-danger p-0 " style="height: 170px; width:170px">
                            <img id="foto" src="{{ route('get-foto', ['filename' => Auth::user()->avatar]) }}" class="rounded gallery-item" width="170px" height="170px">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <label>Detail kelas</label>

                <table class="table table-bordered">
                    <tr>
                        <th>ID kelas</th>
                        <td>{{ $kelas->id }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $kelas->jenjang_kelas }}-{{ $kelas->bagian_kelas }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>Semester: {{ $periodeAktif->semester }} {{ $periodeAktif->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <th>Wali kelas</th>
                        <td>
                            <p id="nama_walas">{{ Auth::user()->nama }}</p>
                        </td>
                    </tr>

                </table>

            </div>
        </div>
    </x-card-box>

    <x-card-box cardTitle="Siswa Kelas">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-info btn-sm" id="reloadData">Reload data</button>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Masukkan siswa ke kelas</button>
        </div>

        <div class="table-responsive">
            <table id="data-siswa-kelas" class="table table-striped table-hover nowrap" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>Foto</th>
                        <th data-priority="1">Nama</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th data-priority="2"><i data-feather="more-horizontal"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-box>
</div>
@endsection

@section('modal')
<div class="modal fade" id="tambahModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Masukkan santri ke kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-row">
                    <div class="col-lg-12 col-sm-12">

                        <div class="alert alert-light-warning">
                            <span>Pilih siswa untuk masuk ke kelas</span>
                        </div>
                        <div class="btn-group mb-3" role="group" aria-label="Basic example">
                            <span class="btn btn-info" id="reload_semua_siswa">Reload data</span>
                        </div>

                        <div class="table-responsive">
                            <table id="data-siswa" class="table table-striped table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th data-priority="1">Nama</th>
                                        <th>NIS</th>
                                        <th>NISN</th>
                                        <th data-priority="2"><i data-feather="more-horizontal"></i></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer d-block pt-0">
                <div class="alert alert-outline-primary" style="height: 77px; overflow-x: hidden; overflow-y: auto;">
                    <label>Santri berhasil dimasukkan:</label>
                    <div class="wrapper-santri"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<link href="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.css') }}" rel="stylesheet">
@endsection

@section('script')
<script src="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.js') }}"></script>
<script>
    const wrapperSantri = document.querySelector('.wrapper-santri')

    $('#reloadData').on('click', function() {
        $('#data-siswa-kelas').DataTable().ajax.reload()
        notif('Berhasil muat ulang data', true)
    })

    $('#reload_semua_siswa').on('click', function() {
        $('#data-siswa').DataTable().ajax.reload()
        notif('Berhasil muat ulang data', true)
    })

    $('#tambahModal').on('hidden.bs.modal', function() {
        wrapperSantri.innerHTML = ''
    })

    $('#tambahModal').on('shown.bs.modal', function() {
        $('#data-siswa').DataTable().ajax.reload()
    })

    $(document).on('click', '.masukkan-siswa', function(e) {
        let id = $(this).data('id')
        let nama = $(this).data('nama')
        staging(id, nama, "{{ route('masukkan-siswa-saya') }}")
    })

    $(document).on('click', '.keluarkan-siswa', function(e) {
        let id = $(this).data('id')
        let nama = $(this).data('nama')
        staging(id, nama, "{{ route('keluarkan-siswa-saya') }}")
    })

    function staging(id, nama, route) {
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        formData.append('id', id)
        formData.append('nama', nama)
        formData.append('kelas_id', "{{ $kelas->id }}")
        formData.append('periode_id', "{{ $periodeAktif->id }}")
        prosesAjax(formData, route);
    }

    function berhasilMasukkan(nama) {
        let span = document.createElement('span');
        span.classList.add('badge')
        span.classList.add('badge-success')
        span.classList.add('mr-1')
        span.classList.add('mt-1')
        span.textContent = nama
        wrapperSantri.appendChild(span)
        $('#data-siswa-kelas').DataTable().ajax.reload()
    }

    function berhasilKeluarkan() {
        $('#data-siswa-kelas').DataTable().ajax.reload()
    }

    function loadData(id, route) {
        $(id).DataTable({
            responsive: true, //
            processing: true, //
            serverSide: true, //
            ajax: {
                url: route, //
            }, //
            columns: [{
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

    function prosesAjax(data, route) {
        $.ajax({
            url: route, //
            method: 'POST', //
            data: data, //
            dataType: 'json', //
            processData: false, //
            contentType: false, //
            success: function(res) {
                // onfinish()
                if (res.success) {

                    if (res.type && res.type == 'masukkan') {
                        berhasilMasukkan(res.nama)
                    }

                    if (res.type && res.type == 'keluarkan') {
                        berhasilKeluarkan()
                    }

                    notif(res.message, true)
                } else {
                    notif(res.message, false)
                }
            }, //
            error: function(err) {
                // onfinish()
                console.log(err.responseText)
                notif(err.responseText, false)
            }
        });
    }

    function replaceImg(newImageName) {
        let src = "{{ route('get-foto', ['filename' => 'src_js']) }}".replace('src_js', newImageName)
        $('#foto').attr('src', src)
    }

    function replaceName(newName) {
        $('#nama_walas').text(newName)
    }

    loadData('#data-siswa-kelas', "{{ route('siswa-kelas-saya', ['id' => 'params']) }}".replace('params', "{{ $kelas->id }}"))

    loadData('#data-siswa', "{{ route('semua-siswa-umum') }}")

</script>
@endsection
