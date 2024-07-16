<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;

class HapusCacheController extends Controller
{
    public function index()
    {
        return view('admin.cache.hapus-cache');
    }

    public function hapus_data_cache()
    {
        Artisan::call('cache:clear');

        return response()->json(['success' => true, 'message' => 'Data cache berhasil dibersihkan']);
    }
}
