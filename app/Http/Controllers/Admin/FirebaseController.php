<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirebaseController extends Controller
{
    public function updateMessageTokenFirebase(Request $request)
    {
        $header = $request->header();
        $userAgentArray = array_reverse($header['user-agent']);
        $userAgent = array_pop($userAgentArray);

        $deviceByToken = Device::where('device_token', $request->token)->first();

        if(!empty($deviceByToken)){
            Device::where('device_token', $request->token)->update([
                'device_token' => null
            ]);
        }

        $device = Device::updateOrCreate(
            [
                'device_id' => $userAgent,
            ],
            [
                'device_token' => $request->token,
                'user_id'   => Auth::id(),
                'platform'  => Device::PLATFORM['Web'],
            ]);

        return response()->json(['Token successfully stored.']);
    }
}
