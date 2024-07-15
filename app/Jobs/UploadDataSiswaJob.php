<?php

namespace App\Jobs;

use App\Models\Data\Siswa;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UploadDataSiswaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $dt) {
            DB::transaction(function () use ($dt) {
                $avatar = '';
                if ($dt['gender'] == 'male') {
                    $avatar = 'user-male-90x90.png';
                } elseif ($dt['gender'] == 'female') {
                    $avatar = 'user-female-90x90.png';
                }

                $user = User::create([
                    'nama' => $dt['nama'],
                    'username' => '@'.$dt['username'],
                    'password' => Hash::make($dt['password']),
                    'role' => 'Siswa',
                    'gender' => $dt['gender'],
                    'avatar' => $avatar,
                ]);

                if ($user && $user->id) {
                    $siswa = Siswa::create([
                        'user_id' => $user->id,
                        'nis' => $dt['nis'],
                        'nisn' => $dt['nisn'],
                        'email' => $dt['email'],
                        'telp' => $dt['telp'],
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
        }
    }
}
