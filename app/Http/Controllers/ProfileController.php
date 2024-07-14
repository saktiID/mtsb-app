<?php

namespace App\Http\Controllers;

use App\Services\Data\GuruService as Guru;
use App\Services\Data\SiswaService as Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private $guru;

    private $siswa;

    public function __construct(Guru $guru, Siswa $siswa)
    {
        $this->guru = $guru;
        $this->siswa = $siswa;
    }

    public function index()
    {
        return view('profile.profile-user');
    }

    public function update(Request $request)
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

        if ($request->role == 'Guru' || $request->role == 'Admin') {
            $query = $this->guru->updateGuru($request);
            if ($query) {
                return response()->json(['success' => true, 'message' => 'Profile '.$request->nama.' berhasil diubah']);
            } else {
                return response()->json(['success' => false, 'message' => 'Profile gagal diubah']);
            }
        }

        if ($request->role == 'Siswa') {
            $query = $this->siswa->updateSiswa($request);
            if ($query) {
                return response()->json(['success' => true, 'message' => 'Profile '.$request->nama.' berhasil diubah']);
            } else {
                return response()->json(['success' => false, 'message' => 'Profile gagal diubah']);
            }
        }
    }
}
