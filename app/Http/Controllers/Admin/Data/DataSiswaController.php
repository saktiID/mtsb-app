<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use App\Services\Data\SiswaService as Siswa;
use App\Services\Data\SiswaDataTableService as SiswaDataTable;
use App\Services\Data\UploadTemplateService as UploadTemplate;
use App\Services\Data\DownloadTemplateService as DownloadTemplate;

class DataSiswaController extends Controller
{
    private $siswa;

    private $siswaData;

    private $downloadTemplate;

    private $uploadTemplate;

    public function __construct(
        Siswa $siswa,
        SiswaDataTable $siswaData,
        DownloadTemplate $downloadTemplate,
        UploadTemplate $uploadTemplate,
    ) {
        $this->siswaData = $siswaData;
        $this->siswa = $siswa;
        $this->downloadTemplate = $downloadTemplate;
        $this->uploadTemplate = $uploadTemplate;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->siswaData->getSiswaDataTable();
        }

        return view('admin.data.siswa.data-siswa');
    }

    public function tambah_siswa(Request $request)
    {
        $query = $this->siswa->tambahSiswa($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Siswa baru ' . $request->nama . ' berhasil ditambahkan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Siswa baru gagal ditambahkan']);
        }
    }

    public function detail_siswa($id)
    {
        $data['user'] = $this->siswa->detailSiswa($id);

        return view('admin.data.siswa.detail-siswa', $data);
    }

    public function update_siswa(Request $request)
    {
        if ($request->password != '') {
            $validate = Validator::make(
                $request->all(),
                ['password' => 'min:5|confirmed'],
                [
                    'password.confirmed' => 'Password tidak sama.',
                    'password.min' => 'Password kurang dari 5 karakter.',
                ]
            );

            if ($validate->fails()) {
                $msg = '';
                $messages = $validate->errors()->messages()['password'];
                foreach ($messages as $message) {
                    $msg .= $message . '<br>';
                }

                return response()->json(['success' => false, 'message' => $msg]);
            }
        }

        $query = $this->siswa->updateSiswa($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Data siswa ' . $request->nama . ' berhasil diubah']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data siswa gagal diubah']);
        }
    }

    public function hapus_siswa(Request $request)
    {
        $ids = explode(',', $request->id);
        $query = $this->siswa->hapusSiswa($ids);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Data siswa berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data siswa gagal dihapus']);
        }
    }

    public function download_template()
    {
        return $this->downloadTemplate->generateTemplateSiswa();
    }

    public function upload_template(Request $request)
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
        if ($sheetName != 'template-upload-siswa') {
            return response()->json(['success' => false, 'message' => 'Format file salah, unduh template lagi!']);
        }

        if (!in_array($filetype, $extAllowed)) {
            return response()->json(['success' => false, 'message' => 'Format file tidak diizinkan!']);
        }

        $upload = $this->uploadTemplate->storeData($filetmp);

        if ($upload) {
            return response()->json(['success' => true, 'message' => 'Data siswa segera diupload!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data siswa gagal diupload!']);
        }
    }
}
