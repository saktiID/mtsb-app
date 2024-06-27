@extends('layout.main')
@section('title', 'Assessment History')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Assessment History">
        <div class="form-row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ asset('user-male-90x90.png') }}" width="250px" height="250px" class="rounded bg-success" />
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kelas</th>
                            <td>VII-1</td>
                        </tr>
                        <tr>
                            <th width="20%">Nama</th>
                            <td>
                                <select id="siswa_kelas" name="siswa_kelas" class="form-control">
                                    <option value="">-- Pilih siswa --</option>
                                    <option>Abdul Rojak</option>
                                    <option>Ahsan Syai</option>
                                    <option>Gupron Sultoni</option>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>
                                <select id="periode" name="periode" class="form-control">
                                    <option value="">-- Pilih periode --</option>
                                    <option>2024-2025 | Ganjil</option>
                                    <option>2024-2025 | Genap</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Bulan</th>
                            <td>
                                <select id="bulan" name="bulan" class="form-control">
                                    <option value="">-- Pilih bulan --</option>
                                    <option>Januari</option>
                                    <option>Februari</option>
                                    <option>Maret</option>
                                    <option>April</option>
                                    <option>Mei</option>
                                    <option>Juni</option>
                                    <option>Juli</option>
                                    <option>Agustus</option>
                                    <option>September</option>
                                    <option>Oktober</option>
                                    <option>November</option>
                                    <option>Desember</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Minggu ke</th>
                            <td>
                                <select id="minggu" name="minggu" class="form-control">
                                    <option value="">-- Pilih minggu --</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Assessment type</th>
                            <td>
                                <select id="assessment" name="assessment" class="form-control">
                                    <option value="">-- Pilih assessment --</option>
                                    <option>Parrent Assessment</option>
                                    <option>Peer Assessment</option>
                                    <option>Teacher Assessment</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-secondary">Telusuri</button>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="table-responsive">
                <table id="history" class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th width="70%">Aspect</th>
                            <th>Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Take ablution orderly</th>
                            <td>
                                <span class="badge outline-badge-dark">Always</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Pray orderly</th>
                            <td>
                                <span class="badge outline-badge-dark">Sometimes</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Dzikir, istighosah orderly</th>
                            <td>
                                <span class="badge outline-badge-dark">Never</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label>Note:</label>
                    <table class="table table-bordered">
                        <tr>
                            <td id="note">You must upgrade your attitude better!</td>
                        </tr>
                        <tr>
                            <td id="evaluator">Evaluator: Rojak</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-warning">Print</button>
                </div>
            </div>

        </div>
    </x-card-box>



</div>
@endsection


@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

<script>
    $('#history').DataTable({
        info: false, // 
        ordering: false, //
        paging: false, //
        searching: false, //
    })

</script>


@endsection
