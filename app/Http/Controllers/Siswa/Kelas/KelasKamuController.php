<?php

namespace App\Http\Controllers\Siswa\Kelas;

use App\Models\User;
use App\Models\Data\Kelas;
use App\Models\Data\KelasSiswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class KelasKamuController extends Controller
{
    public function index()
    {
        $data['kelas'] = $this->_checkKelas();
        $data['periodeAktif'] = $this->periodeAktif;

        return view('siswa.kelas.kelas-kamu', $data);
    }

    private function _checkKelas()
    {
        $cariKelas = KelasSiswa::where('periode_id', $this->periodeAktif->id)
            ->where('user_id', Auth::user()->id)->get();
        if (count($cariKelas) < 1) {
            $result = [
                'hasKelas' => false,
            ];
            return $result;
        } else {
            $result = [
                'hasKelas' => true,
                'kelasSiswa' => Cache::remember($cariKelas[0]->kelas_id, 1200, function () use ($cariKelas) {
                    return KelasSiswa::with(['user:id,avatar,nama', 'siswa:user_id,nis'])
                        ->where('kelas_id', $cariKelas[0]->kelas_id)
                        ->join('users', 'kelas_siswas.user_id', '=', 'users.id')
                        ->orderBy('users.nama', 'asc')
                        ->get();
                }),
                'data' => Cache::remember('data' . $cariKelas[0]->kelas_id, 500, function () use ($cariKelas) {
                    $kelas = Kelas::where('id', $cariKelas[0]->kelas_id)->first();
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
                })
            ];
            return $result;
        }
    }
}
