@extends('layout.main')
@section('title', 'Data Periode')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Data Periode">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary btn-sm">Tambah periode</button>
        </div>
        <div class="table-responsive">
            <table id="data-periode" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Tahun ajaran</th>
                        <th>Semester</th>
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
    $('#data-periode').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })

</script>
@endsection
