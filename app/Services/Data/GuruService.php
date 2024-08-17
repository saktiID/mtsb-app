<?php

namespace App\Services\Data;

use App\Models\Data\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruService
{
    public function tambahGuru($request)
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
                'role' => 'Guru',
                'gender' => $request->gender,
                'avatar' => $avatar,
            ]);

            if ($user && $user->id) {
                $guru = Guru::create([
                    'user_id' => $user->id,
                    'email' => $request->email,
                    'telp' => $request->telp,
                ]);

                if ($guru && $guru->id) {
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

    public function detailGuru($id)
    {
        $guru = User::has('guru')
            ->with('guru')
            ->where('id', $id)
            ->first();

        return $guru;
    }

    public function updateGuru($request)
    {
        $query = DB::transaction(function () use ($request) {
            $user = User::find($request->id);
            $guru = Guru::where('user_id', $request->id)->first();

            if ($user && $user->id) {
                $user->nama = $request->nama;
                $user->username = '@'.Str::of($request->username)->trim();
                $user->gender = $request->gender;
                if ($request->password != '') {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                if ($guru && $guru->id) {
                    $guru->email = $request->email;
                    $guru->telp = $request->telp;
                    $guru->save();
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

    public function hapusGuru($ids)
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
