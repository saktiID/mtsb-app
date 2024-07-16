<?php

namespace App\Services\Data;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class SiswaDataTableService
{
    public function getSiswaDataTable()
    {
        $user = User::has('siswa')
            ->where('is_active', true)
            ->with('siswa')
            ->orderBy('nama', 'asc')
            ->get();
        $dataTable = DataTables::of($user)
            ->addColumn('check', function ($user) {
                $data['id'] = $user->id;
                $data['nama'] = $user->nama;

                return view('element.checkbox-table', $data);
            })
            ->addColumn('avatar', function ($user) {
                $data['avatar'] = $user->avatar;
                $data['route'] = 'detail-data-siswa';
                $data['id'] = $user->id;

                return view('element.avatar', $data);
            })
            ->addColumn('nama', function ($user) {
                $data['route'] = 'detail-data-siswa';
                $data['id'] = $user->id;
                $data['nama'] = $user->nama;
                $data['role'] = '';

                return view('element.anchor-nama', $data);
            })
            ->addColumn('nis', function ($user) {
                return $user->siswa->nis;
            })
            ->addColumn('nisn', function ($user) {
                return $user->siswa->nisn;
            })
            ->addColumn('more', function ($user) {
                $data['nama'] = $user->nama;
                $data['id'] = $user->id;
                $data['route'] = 'detail-data-siswa';

                return view('element.more-action', $data);
            })
            ->make(true);

        return $dataTable;
    }
}
