<?php

namespace App\Http\Controllers;

use App\Services\FotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoGetterController extends Controller
{
    private $fotoUploader;

    public function __construct(FotoService $fotoService)
    {
        $this->fotoUploader = $fotoService;
    }

    public function foto($filename)
    {
        $imagePath = 'profile/'.$filename;
        $file = Storage::disk('local')->get($imagePath);
        if (! isset($file)) {
            $file = Storage::disk('public')->get('404.png');
        }

        return response($file, 200)->header('Content-Type', 'image');
    }

    public function upload_foto(Request $request)
    {
        $image = $request->file('avatar_upload');
        $imageName = 'profile-'.uniqid().'.'.$image->getClientOriginalExtension();
        $updateFoto = $this->fotoUploader->foto($request, $imageName);
        if ($updateFoto) {
            return response()->json(['success' => true, 'message' => 'Foto profil berhasil diupload', 'newImage' => $imageName]);
        } else {
            return response()->json(['success' => false, 'message' => 'Foto profil gagal diupload']);
        }
    }
}
