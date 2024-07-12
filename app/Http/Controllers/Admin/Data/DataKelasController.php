<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Data\KelasService as Kelas;
use App\Services\Data\KelasDataTableService as KelasData;

class DataKelasController extends Controller
{
    private $kelasData, $kelas;

    public function __construct(KelasData $kelasData, Kelas $kelas)
    {
        parent::__construct();
        $this->kelasData = $kelasData;
        $this->kelas = $kelas;
    }

    public function index(Request $request)
    {
        $data['periodeAktif'] = $this->periodeAktif;
        if ($request->ajax()) {
            return $this->kelasData->getKelasDataTable($this->periodeAktif);
        }
        return view('admin.data.kelas.data-kelas', $data);
    }

    public function detail_kelas($id)
    {
        $data['kelas'] = $this->kelas->detailKelas($id);
        $data['guru'] = $this->kelas->getGuru();
        if (!$data['kelas']) {
            return redirect()->route('data-kelas');
        }

        return view('admin.data.kelas.detail-kelas', $data);
    }

    public function siswa_kelas(Request $request)
    {
        if ($request->ajax()) {
            return $this->kelasData->getSiswaKelasDataTable($this->periodeAktif->id, $request->id);
        }
    }

    public function tambah_kelas(Request $request)
    {
        $query = $this->kelas->tambahKelas($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Kelas baru ' . $request->jenjang_kelas . '-' . $request->bagian_kelas . ' berhasil ditambahkan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Kelas baru gagal ditambahkan']);
        }
    }

    public function set_walas(Request $request)
    {
        $query = $this->kelas->setWalas($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Wali kelas berhasil diatur']);
        } else {
            return response()->json(['success' => false, 'message' => 'Wali kelas gagal diatur']);
        }
    }

    public function hapus_kelas(Request $request)
    {
        $ids = explode(',', $request->id);
        $query = $this->kelas->hapusKelas($ids);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Data kelas berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data kelas gagal dihapus']);
        }
    }

    public function semua_siswa(Request $request)
    {
        if ($request->ajax()) {
            return $this->kelasData->getSemuaSiswa();
        }
    }

    public function masukkan_siswa(Request $request)
    {
        $cekSiswa = $this->kelas->cekSiswa($request->periode_id, $request->id);
        if ($cekSiswa) {
            return response()->json(['success' => false, 'message' => 'Siswa/i ' . $request->nama . ' sudah dimasukkan kelas']);
        } else {
            $query = $this->kelas->masukkanSiswa($request);
            if ($query) {
                return response()->json([
                    'success' => true,
                    'type' => 'masukkan',
                    'message' => 'Siswa/i ' . $request->nama . ' berhasil dimasukkan',
                    'nama' => $request->nama,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'type' => 'masukkan',
                    'message' => 'Siswa/i ' . $request->nama . ' gagal dimasukkan',
                    'nama' => $request->nama,
                ]);
            }
        }
    }

    public function keluarkan_siswa(Request $request)
    {
        $query = $this->kelas->keluarkanSiswa($request->id);
        if ($query) {
            return response()->json([
                'success' => true,
                'type' => 'keluarkan',
                'message' => 'Siswa/i ' . $request->nama . ' berhasil dikeluarkan',
                'nama' => $request->nama,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'type' => 'keluarkan',
                'message' => 'Siswa/i ' . $request->nama . ' gagal dikeluarkan',
                'nama' => $request->nama,
            ]);
        }
    }
}
