<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
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
    public function send(Request $request)
    {
        $webPush = new WebPush([
            'VAPID' => [
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
                'subject' => route('home'),
            ],
        ]);

        $payload = json_encode([
            'title' => 'Judul Notification Test',
            'body' => 'Isi notification test',
            'url' => '/',
        ]);

        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        } else {
            dd(['User ID is required']);

            return false;
        }

        $subs = PushSubscription::where('user_id', $user_id)->get();

        if (count($subs) > 0) {
            foreach ($subs as $sub) {
                $result[] = $webPush->sendOneNotification(
                    Subscription::create(json_decode($sub->data, true)),
                    $payload
                );
            }
            dd($result);

            return;
        } else {
            dd(['User ID not found']);

            return false;
        }
    }
}
