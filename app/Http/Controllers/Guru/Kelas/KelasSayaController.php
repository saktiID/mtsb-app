<?php

namespace App\Http\Controllers\Guru\Kelas;

use App\Http\Controllers\Controller;
use App\Services\Data\KelasDataTableService as KelasData;
use App\Services\Data\KelasService as Kelas;
use App\Services\Data\SiswaService as Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KelasSayaController extends Controller
{
    private $siswa;

    private $kelas;

    private $kelasData;

    public function __construct(Siswa $siswa, Kelas $kelas, KelasData $kelasData)
    {
        parent::__construct();
        $this->kelas = $kelas;
        $this->kelasData = $kelasData;
        $this->siswa = $siswa;
    }

    public function index()
    {
        $data['kelas'] = $this->kelas->getKelasByWalasId(Auth::user()->id, $this->periodeAktif);
        $data['periodeAktif'] = $this->periodeAktif;

        return view('guru.kelas.kelas-saya', $data);
    }

    public function siswa_kelas(Request $request)
    {
        if ($request->ajax()) {
            return $this->kelasData->getSiswaKelasDataTable($this->periodeAktif->id, $request->id);
        }
    }

    public function detail_siswa($id)
    {
        $data['user'] = $this->siswa->detailSiswa($id);

        return view('admin.data.siswa.detail-siswa', $data);
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
            return response()->json(['success' => false, 'message' => 'Siswa/i '.$request->nama.' sudah dimasukkan kelas']);
        } else {
            $query = $this->kelas->masukkanSiswa($request);
            if ($query) {
                return response()->json([
                    'success' => true,
                    'type' => 'masukkan',
                    'message' => 'Siswa/i '.$request->nama.' berhasil dimasukkan',
                    'nama' => $request->nama,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'type' => 'masukkan',
                    'message' => 'Siswa/i '.$request->nama.' gagal dimasukkan',
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
                'message' => 'Siswa/i '.$request->nama.' berhasil dikeluarkan',
                'nama' => $request->nama,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'type' => 'keluarkan',
                'message' => 'Siswa/i '.$request->nama.' gagal dikeluarkan',
                'nama' => $request->nama,
            ]);
        }
    }

    public function download_template()
    {
        return response()->download(public_path('storage/template-input-siswa-ke-kelas.xlsx'));
    }

    public function upload_file(Request $request)
    {
        if ($request->hasFile('excelFile')) {
            $filename = $_FILES['excelFile']['name'];
            $filetmp = $_FILES['excelFile']['tmp_name'];
            $filetype = pathinfo($filename)['extension'];
            $extAllowed = ['xls', 'xlsx'];
        } else {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan!']);
        }

        $reader = IOFactory::createReaderForFile($filetmp);
        $spreadsheet = $reader->load($filetmp);
        $sheetName = $spreadsheet->getSheetNames()[0];

        if ($sheetName != 'data') {
            return response()->json(['success' => false, 'message' => 'Format file salah, unduh template lagi!']);
        }

        if (! in_array($filetype, $extAllowed)) {
            return response()->json(['success' => false, 'message' => 'Format file tidak diizinkan!']);
        }

        $log = $this->kelas->masukkanSiswaExcel($filetmp, $request->periode_id, $request->kelas_id);

        if (count($log) > 0) {
            return response()->json(['success' => false, 'message' => $log]);
        }

        return response()->json(['success' => true, 'message' => 'Data berhasil diupload!']);
    }
}
