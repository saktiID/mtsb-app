<?php

namespace App\Services\Data;

use App\Models\User;
use App\Models\Data\Kelas;
use Yajra\DataTables\Facades\DataTables;

class KelasDataTableService
{
    public function getKelasDataTable($periode_aktif)
    {
        $kelas = Kelas::where('periode_id', $periode_aktif->id)
            ->orderBy('jenjang_kelas', 'ASC')->orderBy('bagian_kelas', 'ASC')->get();

        $dataTable = $dataTable = DataTables::of($kelas)
            ->addColumn('check', function ($kelas) {
                $data['id'] = $kelas->id;
                $data['nama'] = $kelas->jenjang_kelas . '-' . $kelas->bagian_kelas;
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
            ->addColumn('jenjang', function ($kelas) {
                return $kelas->jenjang_kelas;
            })
            ->addColumn('bagian', function ($kelas) {
                return $kelas->bagian_kelas;
            })
            ->addColumn('more', function ($kelas) {
                $data['id'] = $kelas->id;
                $data['nama'] = $kelas->jenjang_kelas . '-' . $kelas->bagian_kelas;
                $data['route'] = 'detail-kelas';
                return view('element.more-action', $data);
            })

            ->make(true);

        return $dataTable;
    }
}
