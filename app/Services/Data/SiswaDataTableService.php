<?php

namespace App\Services\Data;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class SiswaDataTableService
{
    public function getSiswaDataTable()
    {
        $user = User::where('is_active', true)
            ->select('id', 'nama', 'avatar')
            ->has('siswa')
            ->with('siswa:user_id,nis,nisn')
            ->orderBy('nama', 'asc')
            ->get();
        $dataTable = DataTables::of($user)
            ->addColumn('check', function ($user) {
                // $data['id'] = $user->id;
                // $data['nama'] = $user->nama;

                $el = '
                
                <div class="text-center">
                <div class="checkbox-wrapper-31">
                    <input type="checkbox" class="check_item" data-id="'.$user->id.'" data-nama="'.$user->nama.'" />
                    <svg viewBox="0 0 35.6 35.6">
                        <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                        <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                        <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                    </svg>
                </div>
                </div>

                ';

                // return view('element.checkbox-table', $data);
                return $el;
            })
            ->addColumn('avatar', function ($user) {
                // $data['avatar'] = $user->avatar;
                // $data['route'] = 'detail-data-siswa';
                // $data['id'] = $user->id;

                $el = '
                
                <a href="'.route('detail-data-siswa', $user->id).'">
                <div class="avatar text-center">
                    <img alt="avatar" src="'.route('get-foto', ['filename' => $user->avatar]).'" class="rounded bg-success" width="50px" height="50px" />
                </div>
                </a>

                ';

                // return view('element.avatar', $data);
                return $el;
            })
            ->addColumn('nama', function ($user) {
                // $data['route'] = 'detail-data-siswa';
                // $data['id'] = $user->id;
                // $data['nama'] = $user->nama;
                // $data['role'] = '';

                $el = '
                
                <a href="'.route('detail-data-siswa', $user->id).'">
                '.$user->nama.'
                </a>
                
                ';

                // return view('element.anchor-nama', $data);
                return $el;
            })
            ->addColumn('nis', function ($user) {
                return $user->siswa->nis;
            })
            ->addColumn('nisn', function ($user) {
                return $user->siswa->nisn;
            })
            ->addColumn('more', function ($user) {
                // $data['nama'] = $user->nama;
                // $data['id'] = $user->id;
                // $data['route'] = 'detail-data-siswa';

                $el = '
                
                <div class="dropdown d-inline-block">
                <a class="dropdown-toggle" href="#" role="button" id="dropMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical" style="font-size: 1.4rem;"></i>
                </a>
                <div class="dropdown-menu dropleft" aria-labelledby="dropMore" style="will-change: transform;">
                    <a href="'.route('detail-data-siswa', $user->id).'" class="dropdown-item"><i class="bi bi-person-vcard"></i> Lihat detail</a>
                    <a href="javascript:void(0);" class="dropdown-item hapus-data" data-id="'.$user->id.'" data-nama="'.$user->nama.'"><i class=" bi bi-trash3"></i> Hapus data</a>
                </div>
                </div>
                
                ';

                // return view('element.more-action', $data);
                return $el;
            })
            ->rawColumns(['check', 'avatar', 'nama', 'more'])
            ->make(true);

        return $dataTable;
    }
}
