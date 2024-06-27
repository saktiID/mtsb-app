@extends('layout.main')
@section('title', 'Beranda')
@section('content')
<div class="row pt-4">
    <x-card-box cardTitle="Motto" cardLayout="col-lg-6 col-sm-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th width="20%">
                        <h5 class="text-success">C</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Credible</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">H</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">High Quality</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">O</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Objective</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">I</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Integrity</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">C</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Construct Amaliyah Aswaja</h6>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h5 class="text-success">E</h5>
                    </th>
                    <td>
                        <h6 class="text-secondary">Excellent</h6>
                    </td>
                </tr>
            </table>
        </div>
    </x-card-box>
    <x-card-box cardTitle="Visi dan Misi" cardLayout="col-lg-6 col-sm-12">
        <h6 class="text-secondary">Visi</h6>
        <p class="text-justify">Terwujudnya madrasah pilihan bagi Masyarakat di Jawa Timur</p>

        <h6 class="text-secondary">Misi</h6>
        <ol class="text-justify">
            <li>Upgrade pendidik dan tenaga kependidikan dalam penguasaan IT sehingga bisa melaksanakan komunikasi aktif dengan networking yang ada di Luar Negeri
            </li>
            <li>Meningkatkan layanan manajemen madrasah berbasis digital yang bisa diakses secara offline maupun online
            </li>
            <li>Mengupgrade kemampuan berbahasa pendidik, tenaga kependidikan dan peserta didik
            </li>
            <li>Pendidik mampu membuktikan keunggulan ajaran aswaja baik melaui offline maupun online</li>
        </ol>
    </x-card-box>

    <x-card-box cardTitle="Profil Saya">

        <div class="form-row">
            <div class="col-lg-4 col-sm-12 mb-4">
                <input type="file" accept="image/*" id="avatar_student" name="avatar_student" hidden>
                <div class="text-center">
                    <div class="avatar avatar-xl mb-4">
                        <img alt="foto" id="foto" src="{{ asset('user-male-90x90.png') }}" width="250px" height="250px" class="rounded bg-success" />
                    </div>
                    <label for="avatar_student" class="btn btn-outline-primary btn-sm">Ubah foto</label>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="20%">Nama</th>
                            <td>Romo Maulana Ahlul Kirom Zain Kafabihi</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>2024050-153105-0001</td>
                        </tr>
                        <tr>
                            <th>TTL</th>
                            <td>Maroko, 27 Januari 2000</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>VII-1</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>2024-2025 | Ganjil</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-success">
                                    <i data-feather="check-circle"></i>
                                    Active</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </x-card-box>

    <x-card-box cardTitle="Credential">
        <div class="form-row">
            <div class="col-lg-7 col-sm-12">
                <div class="mb-3">
                    <label for="nama_siswa">Email siswa</label>
                    <input type="text" value="" id="nama_siswa" name="nama" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="telp_siswa">No. telp siswa</label>
                    <input type="text" value="" id="telp_siswa" name="telp_siswa" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="telp_wali">No. telp wali</label>
                    <input type="text" value="" id="telp_wali" name="telp_wali" class="form-control">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-primary simpan-credential">Simpan</button>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12">
                <div class="mb-3">
                    <label for="old_password">Password lama</label>
                    <input type="text" value="" id="old_password" name="old_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password">Password baru</label>
                    <input type="text" value="" id="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation">Konfirmasi password</label>
                    <input type="text" value="" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="mb-3 btn btn-warning simpan-password">Simpan password</button>
                </div>
            </div>
        </div>
    </x-card-box>

</div>
@endsection


@section('style')
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalerts/sweetalert.css') }}">
@endsection

@section('script')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>

@endsection
