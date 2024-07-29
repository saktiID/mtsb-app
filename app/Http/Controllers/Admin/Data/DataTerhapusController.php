<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Data\DataTerhapusService;
use Illuminate\Http\Request;

class DataTerhapusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = new DataTerhapusService($request->a);

            return $data->getDataTerhapus();
        }

        return view('admin.data.terhapus.data-terhapus');
    }

    public function hapus_permanent_data(Request $request)
    {
        $delete = User::onlyTrashed()->find($request->id)->forceDelete();
        if ($delete) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus secara permanen']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data gagal dihapus secara permanen']);
        }
    }

    public function pulihkan_data(Request $request)
    {
        $restore = User::onlyTrashed()->find($request->id)->restore();
        if ($restore) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dikembalikan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data gagal dikembalikan']);
        }
    }
}
