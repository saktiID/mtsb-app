<?php

namespace App\Http\Controllers\Admin\Data;

use App\Models\Data\Periode;
use Illuminate\Http\Request;
use App\Services\Data\KelasService as Kelas;
use App\Http\Controllers\Controller;
use App\Services\Data\KelasDataTableService as KelasData;

class DataKelasController extends Controller
{
    private $kelasData, $kelas, $periodeAktif;

    public function __construct(KelasData $kelasData, Kelas $kelas)
    {
        $this->kelasData = $kelasData;
        $this->kelas = $kelas;
        $this->periodeAktif = Periode::where('periode_status', true)->first();
    }

    public function index(Request $request)
    {
        $data['periode_aktif'] = $this->periodeAktif;
        if ($request->ajax()) {
            return $this->kelasData->getKelasDataTable($this->periodeAktif);
        }
        return view('admin.data.kelas.data-kelas', $data);
    }

    public function detail_kelas($id)
    {
        $data['kelas'] = $this->kelas->detailKelas($id);
        $data['periode'] = Periode::find($data['kelas']->periode_id);
        $data['guru'] = $this->kelas->getGuru();

        return view('admin.data.kelas.detail-kelas', $data);
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
}
