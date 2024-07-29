<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Support\Facades\File;

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

    public function hapus_data_session()
    {
        // Mendapatkan path direktori sesi
        $sessionPath = storage_path('framework/sessions');

        // Mendapatkan semua file dalam direktori sesi kecuali .gitignore
        $sessionFiles = File::files($sessionPath);

        foreach ($sessionFiles as $file) {
            if ($file->getFilename() !== '.gitignore') {
                File::delete($file);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data session berhasil dibersihkan']);
    }
}
