<?php

namespace App\Services\Data;

use App\Models\Data\Kelas;
use App\Models\Data\KelasSiswa;
use App\Models\Data\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $kelas = Kelas::where('id', $id)->with('periode')->first();
        if (! $kelas) {
            return false;
        }
        $avatar = '-';
        $nama_walas = '-';
        $walas_id = '-';
        if ($kelas->walas_id != '') {
            $walas = User::select(['avatar', 'nama', 'id'])->find($kelas->walas_id);
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

    public function getKelasByWalasId($walas_id, $periodeAktif)
    {
        return Kelas::where('walas_id', $walas_id)->where('periode_id', $periodeAktif->id)->first();
    }

    public function getGuru()
    {
        $guru = User::select(['id', 'avatar', 'nama'])
            ->has('guru')
            ->with(['guru:user_id'])
            ->get();

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

    public function cekSiswa($periode_id, $user_id)
    {
        return KelasSiswa::where('periode_id', $periode_id)
            ->where('user_id', $user_id)
            ->exists();
    }

    public function masukkanSiswa($request)
    {
        $kelasSiswa = new KelasSiswa;
        $kelasSiswa->periode_id = $request->periode_id;
        $kelasSiswa->kelas_id = $request->kelas_id;
        $kelasSiswa->user_id = $request->id;

        if ($kelasSiswa->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function keluarkanSiswa($id)
    {
        $kelasSiswa = KelasSiswa::find($id);
        if ($kelasSiswa->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function masukkanSiswaExcel($filetmp, $periode_id, $kelas_id)
    {
        $reader = IOFactory::createReaderForFile($filetmp);
        $spreadsheet = $reader->load($filetmp);
        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();

        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();

        $log = [];

        for ($i = 11; $i < 50; $i++) {
            if ($activeWorksheet[$i][1] != '') {
                $siswa = Siswa::select('user_id')->where('nis', htmlspecialchars($activeWorksheet[$i][1]))->first();
                if ($siswa) {
                    $cek = $this->cekSiswa($periode_id, $siswa->user_id);
                    if (! $cek) {
                        $siswa_masuk = new \stdClass();
                        $siswa_masuk->id = $siswa->user_id;
                        $siswa_masuk->periode_id = $periode_id;
                        $siswa_masuk->kelas_id = $kelas_id;

                        $this->masukkanSiswa($siswa_masuk);
                    } else {
                        $log[] = [
                            'nama' => $activeWorksheet[$i][2],
                            'ket' => 'Siswa sudah memiliki kelas',
                        ];
                    }
                } else {
                    $log[] = [
                        'nama' => $activeWorksheet[$i][2],
                        'ket' => 'Siswa tidak terdaftar',
                    ];
                }
            }
        }

        return $log;
    }
}
