<?php

namespace App\Services\Data;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class GuruDataTableService
{
    public function getGuruDataTable()
    {
        $user = User::has('guru')->with('guru')->get();
        $dataTable = DataTables::of($user)
            ->addColumn('check', function ($user) {
                $data['id'] = $user->id;
                $data['nama'] = $user->nama;
                return view('element.checkbox-table', $data);
            })
            ->addColumn('avatar', function ($user) {
                $data['avatar'] = $user->avatar;
                $data['route'] = 'detail-data-guru';
                $data['id'] = $user->id;
                return view('element.avatar', $data);
            })
            ->addColumn('nama', function ($user) {
                $data['route'] = 'detail-data-guru';
                $data['id'] = $user->id;
                $data['nama'] = $user->nama;
                return view('element.anchor-nama', $data);
            })
            ->addColumn('email', function ($user) {
                return $user->guru->email;
            })
            ->addColumn('telp', function ($user) {
                return $user->guru->telp;
            })
            ->addColumn('more', function ($user) {
                $data['nama'] = $user->nama;
                $data['id'] = $user->id;
                return view('element.more-action', $data);
            })
            ->make(true);

        return $dataTable;
    }
}
