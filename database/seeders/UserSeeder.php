<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'id' => '74a60478-d675-44c8-b196-7a0203b2b441',
            'nama' => 'Penguasa Aplikasi',
            'username' => '@admin.mtsb',
            'role' => 'Admin',
            'gender' => 'male',
            'avatar' => 'user-male-90x90.png',
            'password' => Hash::make('admin5758')
        ]);

        User::create([
            'id' => 'de6c287f-e126-4eb4-b5a8-aeef4c652d2e',
            'nama' => 'Guru Pendidik',
            'username' => '@guru.mtsb',
            'role' => 'Guru',
            'gender' => 'male',
            'avatar' => 'user-male-90x90.png',
            'password' => Hash::make('guru5758')
        ]);

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
