<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Data\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataAPIController extends Controller
{
    public function getKelas()
    {
        $kelas = Kelas::where('periode_id', $this->periodeAktif->id)
            ->orderBy('jenjang_kelas', 'ASC')->orderBy('bagian_kelas', 'ASC')->get();
        return response()->json($kelas);
    }

    public function getSiswa()
    {
        $siswa = User::where('is_active', true)
            ->select('id', 'nama', 'avatar')
            ->has('siswa')
            ->with('siswa:user_id,nis,nisn')
            ->orderBy('nama', 'asc')
            ->get();
        return response()->json($siswa);
    }

    public function getGuru()
    {
        $guru = User::where('role', 'Guru')->orderBy('nama', 'ASC')->get();
        return response()->json($guru);
    }
}
