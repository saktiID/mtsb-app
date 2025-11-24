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
                                <img id="foto" src="{{ route('get-foto', ['filename' => Auth::user()->avatar]) }}"
                                    class="rounded gallery-item" width="170px" height="170px">
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
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#tambahModal">Masukkan siswa ke kelas</button>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                    data-target="#uploadModal">Upload data</button>
            </div>

            <div class="table-responsive">
                <table id="data-siswa-kelas" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>Foto</th>
                            <th data-priority="1">Nama</th>
                            <th>NIS</th>
                            <th>Username</th>
                            <th data-priority="2"><i data-feather="more-horizontal"></i></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-card-box>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="tambahModal" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Masukkan siswa ke kelas</h5>
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
                                            <th>Username</th>
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
                        <label>Siswa berhasil dimasukkan:</label>
                        <div class="wrapper-siswa"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="col">
                                    <ul class="text-sm">
                                        <li>Gunakan excel versi terbaru</li>
                                        <li>Pastikan dalam kondisi terkoneksi ke internet untuk mengambil data dari server</li>
                                        <li>Aktifkan mode editing dan external data connection</li>
                                        <li>Ketik nama dan pilih dari daftar yang tersedia</li>
                                        <li>Jika ingin menghapus nama tekan tombol delete di keyboard</li>
                                        <li>Jika ingin mengambil data dari file lain tinggal copy-paste kolom nama saja</li>
                                        <li>Jika NIS tidak muncul otomatis cari nama yang tersedia secara manual</li>
                                        <li>Kolom NIS terisi otomatis</li>
                                    </ul>
                                </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <a href="{{ route('download-template-siswa-kelas') }}" class="btn btn-warning btn-sm">Download
                                        template</a>
                                </div>
                                
                            </div>
                            <form action="{{ route('upload-template') }}" method="POST" id="form-upload"
                                enctype="multipart/form-data">
                                <label for="excelFile">Pilih file excel:</label>
                                <input type="file" class="form-control" name="excelFile" id="excelFile"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </form>
                            <div>
                                <span>Upload: <span id="progress-upload">0</span>% </span>
                            </div>
                            <div id="error-message" class="mt-3 text-danger">

                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Tutup</button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('style')
    <link href="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('plugins/table/datatble-v2/datatable-v2-responsive.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>


    <script>
        const wrapperSantri = document.querySelector('.wrapper-siswa')

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

        $('#form-upload').on('change', function(e) {
            const excelFile = $('input#excelFile').prop('files')[0]
            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}")
            formData.append('excelFile', excelFile)
            formData.append('periode_id', "{{ $periodeAktif->id }}")
            formData.append('kelas_id', "{{ $kelas->id }}")
            
            $.ajax({
                url: "{{ route('upload-template-siswa-kelas') }}",
                type: 'POST', //
                data: formData, //
                contentType: false, //
                processData: false, //
                xhr: function() {
                    let xhr = new window.XMLHttpRequest()
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            let percentComplete = evt.loaded / evt.total
                            percentComplete = parseInt(percentComplete * 100)
                            $('#progress-upload').html(percentComplete)
                            console.log(percentComplete);
                            
                        }
                        
                    }, false);
                    return xhr;
                }, //

                success: function(res) {
                    if(res.success) {
                        $('#modal-upload-template').modal('hide')
                        $('#progress-upload').html("0")
                        notif(res.message, true)
                        
                    } else {
                        // Buat elemen <ul>
                        let ul = document.createElement("ul");

                        // Looping object message
                        res.message.forEach(function(item) {
                            let li = document.createElement("li");
                            li.textContent = item.nama + " = " + item.ket;
                            ul.appendChild(li);
                        });

                        notif("Terjadi kesalahan", false)

                        // Tambahkan ke DOM (misalnya ke div dengan id error-message)
                        document.getElementById("error-message").appendChild(ul);

                    }

                    $('#form-upload')[0].reset();
                    $('#data-siswa-kelas').DataTable().ajax.reload()

                },
                error: function(err) {
                    console.log(err);
                }
            })
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
                pageLength: -1,
                ajax: {
                    url: route, //
                }, //
                columns: [{
                        data: 'avatar', //
                        orderable: false, //
                    }, //
                    {
                        data: 'nama', //
                        render: function(data, type, row) {
                            return '<span style="white-space:wrap">' + data + "</span>";
                        }
                    }, //
                    {
                        data: 'nis', //
                    }, //
                    {
                        data: 'username', //
                    }, //
                    {
                        data: 'more', //
                        className: 'text-center', //
                        orderable: false, //
                        searchbar: false, //
                    }, //
                ],
                layout: {
                    topStart: {
                        buttons: [
                            {
                                extend: 'excel',
                                title: `kelas-saya-{{ $kelas->jenjang_kelas }}-{{ $kelas->bagian_kelas }}`,
                                filename: `kelas-saya-{{ $kelas->jenjang_kelas }}-{{ $kelas->bagian_kelas }}`,
                                exportOptions: {
                                    // ambil hanya kolom index ke-1 (nama) dan ke-2 (nis)
                                    columns: [1, 2]
                                },
                                customize: function (xlsx) {
                                    // Ambil XML worksheet
                                    const sheet = xlsx.xl.worksheets['sheet1.xml'];

                                    // Paksa semua sel di kolom B (NIS) bertipe string
                                    $('row c[r^="B"]', sheet).attr('t', 'str');
                                }

                            },
                            {
                                extend: 'pdf',
                                title: `kelas-{{ $kelas->jenjang_kelas }}-{{ $kelas->bagian_kelas }}`,
                                filename: `kelas-{{ $kelas->jenjang_kelas }}-{{ $kelas->bagian_kelas }}`,
                                exportOptions: {
                                    // ambil hanya kolom index ke-1 (nama) dan ke-2 (nis)
                                    columns: [1, 2]
                                },
                                orientation: 'portrait', // bisa 'landscape'
                                pageSize: 'A4',          // ukuran kertas
                                customize: function (doc) {
                                    // Atur agar tabel fit ke lebar halaman
                                    doc.content[1].table.widths = 
                                        Array(doc.content[1].table.body[0].length).fill('*');
                                    doc.pageMargins = [20, 20, 20, 20]; 
                                }


                            },

                        ]
                    }
                }, //

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

        loadData('#data-siswa-kelas', "{{ route('siswa-kelas-saya', ['id' => 'params']) }}".replace('params',
            "{{ $kelas->id }}"))

        loadData('#data-siswa', "{{ route('semua-siswa-umum') }}")
    </script>
@endsection
