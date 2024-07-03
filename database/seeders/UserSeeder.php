<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Data\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            // Membuat record baru di tabel users
            $user1 = User::create([
                'nama' => 'Penguasa Aplikasi',
                'username' => '@admin.mtsb',
                'role' => 'Admin',
                'gender' => 'male',
                'avatar' => 'user-male-90x90.png',
                'password' => Hash::make('admin5758')
            ]);

            // Membuat record baru di tabel guru dengan user_id dari user yang baru dibuat
            Guru::create([
                'user_id' => $user1->id,
                'email' => 'admin@mtsb.app',
                'telp' => '6281472583690',
            ]);

            // Membuat record baru di tabel users
            $user2 = User::create([
                'nama' => 'Sipaling Guru',
                'username' => '@guru.mtsb',
                'role' => 'Guru',
                'gender' => 'male',
                'avatar' => 'user-male-90x90.png',
                'password' => Hash::make('guru5758')
            ]);

            // Membuat record baru di tabel guru dengan user_id dari user yang baru dibuat
            Guru::create([
                'user_id' => $user2->id,
                'email' => 'guru@mtsb.app',
                'telp' => '6281472583690',
            ]);
        });

        User::create([
            'id' => 'de6c287f-e126-4eb4-b5a8-aeef4c652bc4',
            'nama' => 'Alex Alexander',
            'username' => '@siswa.mtsb',
            'role' => 'Siswa',
            'gender' => 'male',
            'avatar' => 'user-male-90x90.png',
            'password' => Hash::make('siswa5758')
        ]);
    }
}
