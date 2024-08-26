<?php

namespace App\Jobs;

use App\Models\Agenda\AssessmentRecord;
use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class InsertAssessmentRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    private $notif;

    private $process;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $notif, $process)
    {
        $this->data = $data;
        $this->notif = $notif;
        $this->process = $process;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (array_chunk($this->data, 20) as $dt) {
            AssessmentRecord::insert($dt);
        }

        // update status processing
        $this->process->status = 'complete';
        $this->process->save();

        $webPush = new WebPush([
            'VAPID' => [
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
                'subject' => route('home'),
            ],
        ]);

        $type = '-';
        if (strpos($this->notif['evaluator'], 'Teacher') !== false) {
            $type = 'Teacher';
        }
        if (strpos($this->notif['evaluator'], 'Parent') !== false) {
            $type = 'Parent';
        }
        if (strpos($this->notif['evaluator'], 'Peer') !== false) {
            $type = 'Peer';
        }

        $payload = json_encode([
            'title' => $this->notif['nama_siswa'].' - Assessment Records',
            'body' => $this->notif['nama_siswa'].' sudah mendapatkan '.$type.' Assessment pekan '.$this->notif['minggu_ke'].' bulan '.$this->notif['bulan'].' dengan evaluator '.$this->notif['evaluator'],
            'url' => '/',
        ]);

        $subs = PushSubscription::where('user_id', $this->notif['walas_id'])
            ->orWhere('user_id', $this->data[0]['siswa_user_id'])
            ->get();

        if (count($subs) > 0) {
            foreach ($subs as $sub) {
                $webPush->sendOneNotification(
                    Subscription::create(json_decode($sub->data, true)),
                    $payload
                );
            }
        }

        // test notif wa
        $telp = User::with('guru:user_id,telp')
            ->where('id', $this->notif['walas_id'])->first();

        $endPointWA = env('WA_END_POINT');
        $data = [
            'api_key' => env('WA_API_KEY'),
            'sender' => env('WA_SENDER'),
            'number' => $telp->guru->telp,
            'message' => '*'.$this->notif['nama_siswa'].'* sudah mendapatkan '.$type.' Assessment pekan '.$this->notif['minggu_ke'].' bulan '.$this->notif['bulan'].' dengan evaluator '.$this->notif['evaluator'].' pada '.date('Y-m-d H:i:s'),
        ];

        // Encode array ke dalam format JSON
        $jsonData = json_encode($data);

        // Inisialisasi cURL
        $ch = curl_init($endPointWA);

        // Set opsi untuk cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Untuk mendapatkan respon sebagai string
        curl_setopt($ch, CURLOPT_POST, true);  // Set metode request sebagai POST
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',  // Mengatur header Content-Type sebagai JSON
            'Content-Length: '.strlen($jsonData),  // Mengatur panjang konten berdasarkan data JSON yang dikirim
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);  // Data JSON yang akan dikirim

        // Eksekusi request dan ambil respon
        curl_exec($ch);

        // Tutup sesi cURL
        curl_close($ch);

        // end test notif wa
    }

    /**
     * Handle failed job
     *
     * @return void
     */
    public function failed(\Exception $exception)
    {
        // Log the exception
        Log::error('InsertAssessmentRecordJob failed: '.$exception->getMessage());

        // Set processing to failed
        $this->process->status = 'failed';
        $this->process->exception = $exception->getMessage();
        $this->process->save();
    }
}
