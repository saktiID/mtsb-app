@extends('layout.main')
@section('title', 'Data Kelas')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Data Kelas">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary btn-sm">Tambah kelas</button>
        </div>
        <div class="table-responsive">
            <table id="data-kelas" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
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


@section('style')
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script>
    $('#data-kelas').DataTable()

</script>
@endsection
