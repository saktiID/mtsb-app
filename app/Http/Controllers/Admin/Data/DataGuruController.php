<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Services\Data\GuruDataTableService as GuruData;
use App\Services\Data\GuruService as Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataGuruController extends Controller
{
    private $guru;

    private $guruData;

    public function __construct(GuruData $guruData, Guru $guru)
    {
        $this->guruData = $guruData;
        $this->guru = $guru;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->guruData->getGuruDataTable();
        }

        return view('admin.data.guru.data-guru');
    }

    public function tambah_guru(Request $request)
    {
        $query = $this->guru->tambahGuru($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Guru baru '.$request->nama.' berhasil ditambahkan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Guru baru gagal ditambahkan']);
        }
    }

    public function detail_guru($id)
    {
        $data['user'] = $this->guru->detailGuru($id);

        return view('admin.data.guru.detail-guru', $data);
    }

    public function update_guru(Request $request)
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
                    $msg .= $message.'<br>';
                }

                return response()->json(['success' => false, 'message' => $msg]);
            }
        }

        $query = $this->guru->updateGuru($request);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Data guru '.$request->nama.' berhasil diubah']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data guru gagal diubah']);
        }
    }

    public function hapus_guru(Request $request)
    {
        $ids = explode(',', $request->id);
        $query = $this->guru->hapusGuru($ids);
        if ($query) {
            return response()->json(['success' => true, 'message' => 'Data guru berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data guru gagal dihapus']);
        }
    }
}
