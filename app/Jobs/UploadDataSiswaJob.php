<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Data\Siswa;
use App\Events\ProgressEvent;
use App\Events\ProgressFailEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadDataSiswaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chunk, $totalChunks, $chunkIndex;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk, $totalChunks, $chunkIndex)
    {
        $this->chunk = $chunk;
        $this->totalChunks = $totalChunks;
        $this->chunkIndex = $chunkIndex;
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
            foreach ($this->chunk as $index => $item) {
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

            $progress = ($this->chunkIndex / $this->totalChunks) * 100;
            event(new ProgressEvent(['progress' => $progress]));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Job gagal.', [
                'error' => $e->getMessage(),
                'data' => $this->chunk,
            ]);

            event(new ProgressFailEvent([
                'message' => 'Gagal memasukkan data <br/>' . $e->getMessage()
            ]));

            throw $e;
        }
    }
}
