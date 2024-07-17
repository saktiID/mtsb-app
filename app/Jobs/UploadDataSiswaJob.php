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
use Illuminate\Support\Facades\Log;

class UploadDataSiswaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chunk;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            foreach ($this->chunk as $item) {
                $avatar = '';
                if ($item['gender'] == 'male') {
                    $avatar = 'user-male-90x90.png';
                } elseif ($item['gender'] == 'female') {
                    $avatar = 'user-female-90x90.png';
                }

                // buat akun user
                $user = User::create([
                    'nama' => $item['nama'],
                    'username' => $item['username'],
                    'role' => 'Siswa',
                    'gender' => $item['gender'],
                    'avatar' => $avatar,
                    'password' => Hash::make($item['password']),
                    'is_active' => true,
                ]);

                // buat siswa
                Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $item['nis'],
                    'nisn' => $item['nisn'],
                    'email' => null,
                    'telp' => null,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Job gagal.', [
                'error' => $e->getMessage(),
                'data' => $this->chunk,
            ]);
        }
    }
}
