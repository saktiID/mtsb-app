<?php

namespace App\Services\Data;

use App\Models\Data\Kelas;
use App\Models\Data\KelasSiswa;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class KelasDataTableService
{
    public function getKelasDataTable($periode_aktif)
    {
        $kelas = Kelas::where('periode_id', $periode_aktif->id)
            ->orderBy('jenjang_kelas', 'ASC')->orderBy('bagian_kelas', 'ASC')->get();

        $dataTable = DataTables::of($kelas)
            ->addColumn('check', function ($kelas) {
                $data['id'] = $kelas->id;
                $data['nama'] = $kelas->jenjang_kelas.'-'.$kelas->bagian_kelas;

                return view('element.checkbox-table', $data);
            })
            ->addColumn('walas', function ($kelas) {
                $avatar = '-';
                if ($kelas->walas_id != '') {
                    $walas = User::find($kelas->walas_id);
                    if ($walas) {
                        $avatar = $walas->avatar;
                    }
                }
                $data['avatar'] = $avatar;
                $data['route'] = 'detail-kelas';
                $data['id'] = $kelas->id;

                return view('element.avatar', $data);
            })
            ->addColumn('kelas', function ($kelas) {
                return $kelas->jenjang_kelas.'-'.$kelas->bagian_kelas;
            })
            ->addColumn('more', function ($kelas) {
                $data['id'] = $kelas->id;
                $data['nama'] = $kelas->jenjang_kelas.'-'.$kelas->bagian_kelas;
                $data['route'] = 'detail-kelas';

                return view('element.more-action', $data);
            })

            ->make(true);

        return $dataTable;
    }

    public function getSiswaKelasDataTable($periode_id, $kelas_id)
    {
        $siswa = KelasSiswa::where([
            ['periode_id', $periode_id],
            ['kelas_id', $kelas_id],
        ])->with(['user:id,avatar,nama', 'kelas', 'siswa:user_id,nis,nisn'])
            ->join('users', 'kelas_siswas.user_id', '=', 'users.id')
            ->orderBy('users.nama', 'asc')
            ->select(['*', 'kelas_siswas.id as id'])
            ->get();

        $dataTable = DataTables::of($siswa)

            ->addColumn('avatar', function ($siswa) {
                $el = '
                
                <a href="'.route('detail-data-siswa', $siswa->user->id).'">
                <div class="avatar text-center">
                    <img alt="avatar" src="'.route('get-foto', ['filename' => $siswa->avatar]).'" class="rounded bg-success" width="50px" height="50px" />
                </div>
                </a>

                ';

                return $el;
            })
            ->addColumn('nama', function ($siswa) {
                return $siswa->user->nama;
            })
            ->addColumn('nis', function ($siswa) {
                return $siswa->siswa->nis;
            })
            ->addColumn('nisn', function ($siswa) {
                return $siswa->siswa->nisn;
            })
            ->addColumn('more', function ($siswa) {
                $el = '
                
                <div class="text-center">
                <button class="keluarkan-siswa btn btn-danger btn-sm" data-id="'.$siswa->id.'" data-nama="'.$siswa->nama.'">Keluarkan</button>
                </div>
                
                ';

                return $el;
            })
            ->rawColumns(['avatar', 'more'])
            ->make(true);

        return $dataTable;
    }

    public function getSemuaSiswa()
    {
        $siswa = User::where('is_active', true)
            ->select('id', 'nama', 'avatar')
            ->has('siswa')
            ->with('siswa:user_id,nis,nisn')
            ->orderBy('nama', 'asc')
            ->get();
        $dataTable = DataTables::of($siswa)
            ->addColumn('avatar', function ($siswa) {
                $el = '
                
                <a href="'.route('detail-data-siswa', $siswa->id).'">
                <div class="avatar text-center">
                    <img alt="avatar" src="'.route('get-foto', ['filename' => $siswa->avatar]).'" class="rounded bg-success" width="50px" height="50px" />
                </div>
                </a>

                ';

                return $el;
            })
            ->addColumn('nama', function ($siswa) {
                return $siswa->nama;
            })
            ->addColumn('nis', function ($siswa) {
                return $siswa->siswa->nis;
            })
            ->addColumn('nisn', function ($siswa) {
                return $siswa->siswa->nisn;
            })
            ->addColumn('more', function ($siswa) {
                $el = '
                
                <div class="text-center">
                <button class="masukkan-siswa btn btn-dark btn-sm" data-id="'.$siswa->id.'" data-nama="'.$siswa->nama.'">Masukkan</button>
                </div>
                
                ';

                return $el;
            })
            ->rawColumns(['avatar', 'more'])
            ->make(true);

        return $dataTable;
    }
}
