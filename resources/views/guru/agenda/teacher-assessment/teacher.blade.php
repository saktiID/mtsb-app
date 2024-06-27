@extends('layout.main')
@section('title', 'Teacher Assessment')
@section('content')
<div class="row pt-4">

    <x-card-box cardTitle="Teacher Assessment">
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
        </div>

        <div class="form-row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Aspect</th>
                                <th class="text-center" width="40%">Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Take ablution orderly</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-1">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-1">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-1">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Pray orderly</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-2">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-2">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-2">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Dzikir, istighosah orderly</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-3">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-3">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-3">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Discipline in habitual morning, Dhuhur, and Ashar Prayer</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-4">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-4">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-4">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Polite in speaking with teacher/friends</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-5">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-5">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-5">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Like to help others</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-6">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-6">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-6">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Keep harmony with other</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-7">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-7">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-7">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Doing verbal bullying to others</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-8">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-8">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-8">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Doing physical bullying to others</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-9">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-9">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-9">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Speak English in madrasah area</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-10">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-10">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-10">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Use social media wisely</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-11">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-11">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-11">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Wear clothes that cover aurat</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-12">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-12">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-12">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Save cleanliness</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-13">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-13">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-13">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Ethic when eating and drinking</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-14">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-14">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-14">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Wear atribut completely</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-15">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-15">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-15">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Smoking in madrasah area or outside</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-16">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-16">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-16">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Having boyfriend/girlfriend</th>
                                <td>
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-success">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-17">
                                            <span class="new-control-indicator"></span>Always
                                        </label>
                                        <label class="new-control new-radio radio-warning">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-17">
                                            <span class="new-control-indicator"></span>Sometimes
                                        </label>
                                        <label class="new-control new-radio radio-danger">
                                            <input type="radio" class="new-control-input" name="aspect-teacher-17">
                                            <span class="new-control-indicator"></span>Never
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>


                <div class="mb-3">
                    <label for="note">Note:</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-primary">Kirim</button>
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
@endsection

@section('script')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>

@endsection
