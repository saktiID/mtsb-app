<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

class FotoService
{
    public function foto($request, $imageName)
    {
        try {
            $image = $request->file('avatar_upload');

            $oldImage = User::where('id', $request->id)
                ->select('avatar')->first();
            $oldImage = $oldImage->avatar;

            $manager = new ImageManager(['driver' => 'gd']);
            $image = $manager->make($image);
            $image->resize(150, 150);
            $image->encode('png', 90)->save(storage_path('app/profile/'.$imageName));

            $foto = User::where('id', $request->id)->update(['avatar' => $imageName]);

            if ($oldImage != 'user-male-90x90.png' && $oldImage != 'user-female-90x90.png') {
                if (file_exists(storage_path('app/profile/'.$oldImage))) {
                    unlink(storage_path('app/profile/'.$oldImage));
                }
            }

            if ($foto) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }
}
