<?php

namespace App\Services\Data;

use App\Models\User;
use App\Models\Data\Kelas;
use Illuminate\Support\Facades\DB;

class KelasService
{
    public function tambahKelas($request)
    {
        $kelas = new Kelas;
        $kelas->periode_id = $request->periode_id;
        $kelas->jenjang_kelas = $request->jenjang_kelas;
        $kelas->bagian_kelas = $request->bagian_kelas;
        $kelas->walas_id = null;

        if ($kelas->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function detailKelas($id)
    {
        $kelas = Kelas::find($id);
        $avatar = '-';
        $nama_walas = '-';
        $walas_id = '-';
        if ($kelas->walas_id != '') {
            $walas = User::find($kelas->walas_id);
            if ($walas) {
                $avatar = $walas->avatar;
                $nama_walas = $walas->nama;
                $walas_id = $walas->id;
            }
        }
        $kelas->avatar = $avatar;
        $kelas->nama_walas = $nama_walas;
        $kelas->walas_id = $walas_id;


        return $kelas;
    }

    public function hapusKelas($ids)
    {
        $query = DB::transaction(function () use ($ids) {
            $deletedCount = Kelas::destroy($ids);
            if ($deletedCount >= 1) {
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        });
        return $query;
    }

    public function getGuru()
    {
        $guru = User::has('guru')->with('guru')->get();
        return $guru;
    }

    public function setWalas($request)
    {
        $kelas = Kelas::find($request->kelas_id);
        $kelas->walas_id = $request->walas_id;
        if ($kelas->save()) {
            return true;
        } else {
            return false;
        }
    }
}
