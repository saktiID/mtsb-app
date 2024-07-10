@extends('layout.main')
@section('title', 'Detail Kelas')
@section('content')
<div class="row pt-4">
    <x-card-box cardTitle="Detail Kelas">
        <div class="row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <a href="{{ route('data-kelas') }}">
                    <div class="alert alert-outline-primary">
                        <span>&larr; Kembali ke Data Kelas</span>
                    </div>
                </a>

                <label for="walas_id">Wali Kelas</label>
                <div class="d-flex justify-content-center">
                    <div class="avatar avatar-xl ">
                        <div class="rounded alert alert-light-danger p-0 " style="height: 170px; width:170px">
                            @if($kelas->avatar != '-')
                            <img id="foto" src="{{ route('get-foto', ['filename' => $kelas->avatar]) }}" class="rounded" width="170px" height="170px">
                            @else
                            <img id="foto" src="{{ route('get-foto', ['filename' => '-']) }}" class="rounded" width="170px" height="170px">
                            @endif
                        </div>
                    </div>
                </div>
                <select name="walas_id" id="walas_id" class="form-control selectpicker">
                    <option value="" selected disabled>-- Pilih walas --</option>
                    @foreach ($guru as $gr)
                    <option value="{{ $gr->id.'/'.$gr->avatar.'/'.$gr->nama }}" {{ $gr->id == $kelas->walas_id ? 'selected' : '' }}>{{ $gr->nama }}</option>
                    @endforeach

                </select>
            </div>

            <div class="col-lg-8 col-sm-12">
                <div class="alert alert-light-info">
                    <span>Detail Kelas</span>
                </div>

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
                        <td>Semester: {{ $periode->semester }} {{ $periode->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <th>Wali kelas</th>
                        <td>
                            <p id="nama_walas">{{ $kelas->nama_walas }}</p>
                        </td>
                    </tr>

                </table>

            </div>
        </div>






    </x-card-box>

    <x-card-box cardTitle="Siswa Kelas">
    </x-card-box>
</div>
@endsection

@section('script')
<script>
    $('#walas_id').on('change', function(e) {
        let val = this.value
        let ex = val.split('/')
        let formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        formData.append('walas_id', ex[0])
        formData.append('kelas_id', "{{ $kelas->id }}")

        prosesAjax(formData, "{{ route('set-wali-kelas') }}")
        replaceImg(ex[1])
        replaceName(ex[2])
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
                // onfinish()
                if (res.success) {
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

    function notif(msg, status) {
        if (status) {
            Toast.create("Berhasil", msg, TOAST_STATUS.SUCCESS, 10000);
        } else {
            Toast.create("Gagal", msg, TOAST_STATUS.DANGER, 10000);
        }
    }

    function replaceImg(newImageName) {
        let src = "{{ route('get-foto', ['filename' => 'src_js']) }}".replace('src_js', newImageName)
        $('#foto').attr('src', src)
    }

    function replaceName(newName) {
        $('#nama_walas').text(newName)
    }

</script>
@endsection
