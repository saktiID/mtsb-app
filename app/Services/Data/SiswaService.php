<?php

namespace App\Services\Data;

use App\Models\Data\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaService
{
    public function tambahSiswa($request)
    {
        $query = DB::transaction(function () use ($request) {
            $avatar = '';
            if ($request->gender == 'male') {
                $avatar = 'user-male-90x90.png';
            } elseif ($request->gender == 'female') {
                $avatar = 'user-female-90x90.png';
            }

            $user = User::create([
                'nama' => $request->nama,
                'username' => '@'.$request->username,
                'password' => Hash::make($request->password),
                'role' => 'Siswa',
                'gender' => $request->gender,
                'avatar' => $avatar,
            ]);

            if ($user && $user->id) {
                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $request->nis,
                    'nisn' => $request->nisn,
                    'email' => $request->email,
                    'telp' => $request->telp,
                ]);

                if ($siswa && $siswa->id) {
                    return true;
                } else {
                    DB::rollBack();

                    return false;
                }
            } else {
                DB::rollBack();

                return false;
            }
        });

        return $query;
    }

    public function detailSiswa($id)
    {
        $siswa = User::has('siswa')
            ->with('siswa')
            ->where('id', $id)
            ->first();

        return $siswa;
    }

    public function updateSiswa($request)
    {
        $query = DB::transaction(function () use ($request) {
            $user = User::find($request->id);
            $siswa = Siswa::where('user_id', $request->id)->first();

            if ($user && $user->id) {
                $user->nama = $request->nama;
                $user->username = '@'.Str::of($request->username)->trim();
                $user->gender = $request->gender;
                if ($request->password != '') {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                if ($siswa && $siswa->id) {
                    $siswa->nis = $request->nis;
                    $siswa->nisn = $request->nisn;
                    $siswa->email = $request->email;
                    $siswa->telp = $request->telp;
                    $siswa->save();
                } else {
                    DB::rollBack();

                    return false;
                }
            } else {
                DB::rollBack();

                return false;
            }

            return true;
        });

        return $query;
    }

    public function hapusSiswa($ids)
    {
        $query = DB::transaction(function () use ($ids) {
            $deletedCount = User::destroy($ids);
            if ($deletedCount >= 1) {
                return true;
            } else {
                DB::rollBack();

                return false;
            }
        });

        return $query;
    }
}
