<?php

namespace App\Jobs;

use App\Models\Agenda\AssessmentRecord;
use App\Models\PushSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class InsertAssessmentRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    private $notif;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $notif)
    {
        $this->data = $data;
        $this->notif = $notif;
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
    }
}
