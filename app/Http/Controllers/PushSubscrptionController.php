<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscrptionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $check = PushSubscription::where('user_id', $user->id)->exists();

        if (! $check) {
            PushSubscription::create([
                'user_id' => $user->id,
                'data' => $request->getContent(),
            ]);

            return true;
        }
    }
}
