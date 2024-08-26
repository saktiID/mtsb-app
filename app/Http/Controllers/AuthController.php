<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class AuthController extends Controller
{
    /**
     * method index login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * method auth login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:5',
        ], [
            'username.required' => 'Kolom username tidak boleh kosong.',
            'password.required' => 'Kolom password tidak boleh kosong.',
            'password.min' => 'Kolom password kurang dari 5 karakter.',
        ]);

        $attempt = Auth::attempt([
            'username' => Str::of($request->username)->trim(),
            'password' => $request->password,
        ], $request->has('remember'));

        if ($attempt) {
            // percobaan stalk siapa baru saja login
            if (Auth::user()->role == 'Guru') {
                $webPush = new WebPush([
                    'VAPID' => [
                        'publicKey' => env('VAPID_PUBLIC_KEY'),
                        'privateKey' => env('VAPID_PRIVATE_KEY'),
                        'subject' => route('home'),
                    ],
                ]);

                $payload = json_encode([
                    'title' => Auth::user()->nama.' baru saja login',
                    'body' => Auth::user()->nama.' telah berhasil login ke aplikasi pada '.date('Y-m-d H:i:s'),
                    'url' => '/',
                ]);

                $admins = User::where('role', 'Admin')->select('id')->get();

                if (count($admins) > 0) {
                    foreach ($admins as $admin) {
                        $subs = PushSubscription::where('user_id', $admin->id)->get();

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

                // kirim notif wa ke user bahwa telah login
                $telp = User::with('guru:user_id,telp')
                    ->where('id', Auth::user()->id)->first();

                $endPointWA = env('WA_END_POINT');
                $data = [
                    'api_key' => env('WA_API_KEY'),
                    'sender' => env('WA_SENDER'),
                    'number' => $telp->guru->telp,
                    'message' => '*'.Auth::user()->nama.'* telah berhasil login ke aplikasi pada '.date('Y-m-d H:i:s'),
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
            }
            // end percobaan stalk siapa baru saja login

            return redirect()->intended('home');
        } else {
            $msg = 'Username atau password salah.';

            return redirect()->route('login')->withInput()->with('response', $msg);
        }
    }

    /**
     * method auth log out
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
