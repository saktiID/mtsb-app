@extends('layout.main')
@section('title', 'Assessment Aspects')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Tambah Aspect">
        <div class="form-row">
            <div class="col-lg-6 col-sm-12">
                <div class="mb-3">
                    <label for="aspect">Aspect for</label>
                    <select class="form-control" name="aspect_for" id="aspect_for">
                        <option disabled selected>-- Pilih aspect untuk --</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                        <option value="parent">Parent</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="mb-3">
                    <label for="aspect">Aspect</label>
                    <textarea name="aspect" id="aspect" rows="2" class="form-control"></textarea>
                </div>
            </div>

            <div class="col">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-secondary">Tambah</button>
                </div>
            </div>

        </div>
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Take ablution orderly</td>
                        <td class="text-center">
                            <label class="switch s-primary mb-0">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm">Edit</button>
                        </td>
                    </tr>

                </tbody>
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Take ablution orderly</td>
                        <td class="text-center">
                            <label class="switch s-primary mb-0">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm">Edit</button>
                        </td>
                    </tr>

                </tbody>
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Take ablution orderly</td>
                        <td class="text-center">
                            <label class="switch s-primary mb-0">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm">Edit</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </x-card-box>

</div>
@endsection


@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script>
    $('#aspect_teacher').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })
    $('#aspect_parent').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })
    $('#aspect_peer').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })

</script>
@endsection
