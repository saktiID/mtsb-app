<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $notif;

    private $type;

    /**
     * The duration of the delay in seconds
     *
     * @var int
     */
    public $delay = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notif, $type)
    {
        $this->notif = $notif;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telp = User::with('guru:user_id,telp')
            ->where('id', $this->notif['walas_id'])->first();

        $endPointWA = env('WA_END_POINT');
        $data = [
            'api_key' => env('WA_API_KEY'),
            'sender' => env('WA_SENDER'),
            'number' => $telp->guru->telp,
            'message' => '*'.$this->notif['nama_siswa'].'* sudah mendapatkan '.$this->type.' Assessment pekan '.$this->notif['minggu_ke'].' bulan '.$this->notif['bulan'].' dengan evaluator '.$this->notif['evaluator'].' pada '.date('Y-m-d H:i:s'),
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
        if (env('WA_GATEWAY_ENABLED')) {
            curl_exec($ch);
        }

        // Tutup sesi cURL
        curl_close($ch);
    }
}
