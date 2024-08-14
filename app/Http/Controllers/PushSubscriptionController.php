<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $check = PushSubscription::where('user_id', $user->id)->exists();

        if (! $check) {
            PushSubscription::create([
                'user_id' => $user->id,
                'data' => $request->getContent(),
            ]);

            return response()->json(['success' => true]);
        }
    }

    /**
     * PERCOBAAN KIRIM NOTIF
     */
    public function send()
    {
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
            'title' => 'Test title',
            'body' => 'Body test',
            'url' => '/',
        ]);

        $result = $webPush->sendOneNotification(
            Subscription::create(json_decode($sub->data, true)),
            $payload
        );

        dd($result);
    }
}
