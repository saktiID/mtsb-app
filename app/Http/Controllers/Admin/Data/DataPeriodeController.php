<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Services\Data\PeriodeDataTableService as PeriodeDataTable;
use App\Services\Data\PeriodeService as Periode;
use Illuminate\Http\Request;

class DataPeriodeController extends Controller
{
    private $periodeData;

    private $periode;

    public function __construct(PeriodeDataTable $periodeData, Periode $periode)
    {
        $this->periodeData = $periodeData;
        $this->periode = $periode;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->periodeData->getPeriodeDataTable();
        }

        return view('admin.data.periode.data-periode');
    }

    public function tambah_periode(Request $request)
    {
        if ($request->kunci_kode_konfirmasi !== $request->kode_konfirmasi) {
            return response()->json(['success' => false, 'message' => 'Kunci kode konfirmasi harus sama']);
        }

        $query = $this->periode->tambahPeriode($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Periode baru berhasil ditambahkan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Periode baru gagal ditambahkan']);
        }
    }

    public function activate_periode(Request $request)
    {
        $query = $this->periode->activatePeriode($request->id);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Periode berhasil diaktifkan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Periode gagal diaktifkan']);
        }
    }

    public function hapus_periode($id)
    {
        $query = $this->periode->hapusPeriode($id);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Periode berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Periode gagal dihapus']);
        }
    }
}
