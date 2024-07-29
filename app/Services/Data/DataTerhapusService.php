<?php

namespace App\Services\Data;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class DataTerhapusService
{
    private $guru;

    private $siswa;

    private $kelas;

    public function __construct($reqData)
    {
        if ($reqData == 'guru') {
            $this->guru = User::onlyTrashed()->has('guru')->with('guru')->get();
        }
        if ($reqData == 'siswa') {
            $this->siswa = User::onlyTrashed()->has('siswa')->with('siswa')->get();
        }
        if (! $reqData || $reqData == '') {
            throw new \Exception('Data type not provided');
        }
    }

    public function getDataTerhapus()
    {
        if ($this->guru) {
            return $this->getGuruTerhapus();
        } elseif ($this->siswa) {
            return $this->getSiswaTerhapus();
        } else {
            throw new \Exception('No data found for the provided data type');
        }
    }

    private function getGuruTerhapus()
    {
        return DataTables::of($this->guru)
            ->addColumn('avatar', function ($guru) {
                $data['avatar'] = $guru->avatar;
                $data['route'] = null;
                $data['id'] = $guru->id;

                return view('element.avatar', $data);
            })
            ->addColumn('nama', function ($guru) {
                return $guru->nama;
            })
            ->addColumn('unique', function ($guru) {
                return $guru->guru->email;
            })
            ->addColumn('more', function ($guru) {
                $data['id'] = $guru->id;
                $data['nama'] = $guru->nama;

                return view('element.more-action-deleted', $data);
            })
            ->make(true);
    }

    private function getSiswaTerhapus()
    {
        return DataTables::of($this->siswa)
            ->addColumn('avatar', function ($siswa) {
                $data['avatar'] = $siswa->avatar;
                $data['route'] = null;
                $data['id'] = $siswa->id;

                return view('element.avatar', $data);
            })
            ->addColumn('nama', function ($siswa) {
                return $siswa->nama;
            })
            ->addColumn('unique', function ($siswa) {
                return $siswa->siswa->nis;
            })
            ->addColumn('more', function ($siswa) {
                $data['id'] = $siswa->id;
                $data['nama'] = $siswa->nama;

                return view('element.more-action-deleted', $data);
            })
            ->make(true);
    }
}
