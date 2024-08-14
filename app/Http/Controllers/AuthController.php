<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($attempt) {
            // percobaan stalk siapa baru saja login
            $webPush = new WebPush([
                'VAPID' => [
                    'publicKey' => env('VAPID_PUBLIC_KEY'),
                    'privateKey' => env('VAPID_PRIVATE_KEY'),
                    'subject' => route('home'),
                ],
            ]);

            $admin = User::where('role', 'Admin')->first();
            $sub = PushSubscription::where('user_id', $admin->id)->first();

            $payload = json_encode([
                'title' => Auth::user()->nama.' baru saja login',
                'body' => Auth::user()->nama.' telah berhasil login ke aplikasi',
                'url' => '/',
            ]);

            $webPush->sendOneNotification(
                Subscription::create(json_decode($sub->data, true)),
                $payload
            );

            // end percobaan stalk siapa baru saja login

            return redirect()->route('home');
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
