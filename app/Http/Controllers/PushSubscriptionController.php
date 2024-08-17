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
        $check = PushSubscription::where('user_id', $user->id)
            ->where('data', $request->getContent())
            ->exists();

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

        $payload = json_encode([
            'title' => 'Test title',
            'body' => 'Body test',
            'url' => '/',
        ]);

        $admins = User::where('role', 'Admin')->get();

        if (count($admins) > 0) {
            foreach ($admins as $admin) {
                $subs = PushSubscription::where('user_id', $admin->id)->get();

                $result = [];
                if (count($subs) > 0) {
                    foreach ($subs as $sub) {
                        $result[] = $webPush->sendOneNotification(
                            Subscription::create(json_decode($sub->data, true)),
                            $payload
                        );
                    }
                }
            }
        }

        dd($result);
    }
}
