<?php

namespace Database\Seeders;

use App\Models\Data\Guru;
use App\Models\Data\Siswa;
use App\Models\User;
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
                'password' => Hash::make('admin5758'),
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
                'password' => Hash::make('guru5758'),
            ]);

            // Membuat record baru di tabel guru dengan user_id dari user yang baru dibuat
            Guru::create([
                'user_id' => $user2->id,
                'email' => 'guru@mtsb.app',
                'telp' => '6281472583690',
            ]);

            // Membuat record baru di tabel users
            $user3 = User::create([
                'nama' => 'Prily Latuconsina',
                'username' => '@siswa.mtsb',
                'role' => 'Siswa',
                'gender' => 'female',
                'avatar' => 'user-female-90x90.png',
                'password' => Hash::make('siswa5758'),
            ]);

            // Membuat record baru di tabel siswa dengan user_id dari user yang baru dibuat
            Siswa::create([
                'user_id' => $user3->id,
                'nis' => '232405035-5303501-0513',
                'nisn' => '452345425',
                'email' => 'siswa@mtsb.app',
                'telp' => '622435242454',
            ]);
        });
    }
}
