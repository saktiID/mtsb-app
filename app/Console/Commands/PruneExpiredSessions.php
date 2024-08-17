<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneExpiredSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune expired sessions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Mengambil lifetime sesi dari konfigurasi
        $lifetimeInSeconds = config('session.lifetime') * 60;

        // Menghitung waktu kedaluwarsa berdasarkan lifetime
        $expirationTime = Carbon::now()->subSeconds($lifetimeInSeconds)->getTimestamp();

        // Cek session driver
        if (env('SESSION_DRIVER') == 'database') {
            // Hapus session
            DB::table('sessions')
                ->where('last_activity', '<', $expirationTime)
                ->delete();

            $this->info('Expired sessions pruned successfully.');
        }

        return Command::SUCCESS;
    }
}
