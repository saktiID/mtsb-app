<?php

namespace App\Jobs;

use App\Events\ProgressEvent;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Data\Siswa;
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

    private $chunk, $total;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk, $total)
    {
        $this->chunk = $chunk;
        $this->total = $total;
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

            // test pusher
            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );

            $pusher = new Pusher(
                'f55aa73926891d45b5c3',
                '33fb9430497e8df51ca7',
                '1835667',
                $options
            );

            $data['message'] = ['upload' => true,];
            $data['progress'] = $this->total;
            $pusher->trigger('my-channel', 'my-event', $data);

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
